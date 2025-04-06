<?php

namespace App\Http\Controllers;

use App\Models\AL;
use App\Models\AL_sales;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ALController extends Controller
{
 
    public function index_ai()
    {
        // جلب سلة المستخدم من جدول a_l_s
        $basket = DB::select('SELECT
            a_l_s.id as as_id,
            products.name AS name_prodect,
            image,
            price_buy,
            total_price,
            mode,
            a_l_s.counter as number_prodect
        FROM
            `a_l_s`
        INNER JOIN products ON a_l_s.product_Id = products.id
        INNER JOIN categories on a_l_s.catagories_Id = categories.id
        WHERE a_l_s.Manger_Id = ?', [auth()->user()->id]);
      
      $total_Balance=0;
      for($i=0; $i< count($basket);$i++){
        $total_Balance +=$basket[$i]->total_price;
      }
        return view('AL.index_ai', ['basket' => $basket ,"total_Balance"=>$total_Balance]);
    }
    
    public function predict_image(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:4096',
        ]);
    
        try {
            $file = fopen($request->file('image')->getPathname(), 'r');
    
            $response = Http::attach(
                'file',
                $file,
                $request->file('image')->getClientOriginalName()
            )->post('http://192.168.137.3:8000/predict/');
    
            if ($response->successful()) {
                $result = $response->json();
                $txt = $result['class'];
    
                $data = DB::select("SELECT * FROM products WHERE status = 'Active' AND name LIKE ?", ["%$txt%"]);
    
                if (!$data) {
                    session()->flash('error', 'لا يوجد منتج بنفس اسم المنتج هذا');
                    return redirect()->route('index_ai')->with('result', $result);
                }
    
                // إضافة المنتج إلى سلة المشتريات
                AL::create([
                    'product_Id' => $data[0]->id,
                    'Manger_Id' => auth()->user()->id,
                    'counter' => 1,
                    'total_price' => $data[0]->price_buy,
                    'catagories_Id' => $data[0]->catagories_Id
                ]);
    
                session()->flash('success', 'تمت الإضافة بنجاح');
    
                // جلب سلة المشتريات المحدثة
                $basket = DB::select('SELECT
                    a_l_s.id as as_id,
                    products.name AS name_prodect,
                    image,
                    price_buy,
                    total_price,
                    mode,
                    a_l_s.counter as number_prodect
                FROM
                    `a_l_s`
                INNER JOIN products ON a_l_s.product_Id = products.id
                INNER JOIN categories on a_l_s.catagories_Id = categories.id
                WHERE a_l_s.Manger_Id = ?', [auth()->user()->id]);
                      $total_Balance=0;
                      for($i=0; $i< count($basket);$i++){
                        $total_Balance +=$basket[$i]->total_price;
                      }
                return view("AL.index_ai", [

                    "basket" => $basket
                    ,"total_Balance"=>$total_Balance
                ])->with('result', [
                    'class' => $txt,
                    'confidence' => $result['confidence'] ?? 1
                ]);
            } else {
                return redirect()->route('index_ai')->with('error', 'فشل في التنبؤ. تحقق من Flask.');
            }
        } catch (\Exception $e) {
            return redirect()->route('index_ai')->with('error', 'خطأ: ' . $e->getMessage());
        }
    }
    
    public function delete_ai_cat($id)
    {
        $basket = AL::find($id);
        if ($basket) {
            $basket->delete();
            session()->flash('success', 'تم الحذف بنجاح');
        } else {
            session()->flash('error', 'خطأ: لم يتم العثور على المنتج');
        }
    
        return redirect()->route('index_ai');
    }
   
    public function cart_ai_sales($id){
        $basket = AL::find($id);
        if($basket){
            //اضافه لجدول المبيعات
            AL_sales::create([
                'product_Id' => $basket->product_Id,
                'Manger_Id' => auth()->user()->id,
                'counter' => $basket->counter,
                'total_price' => $basket->total_price,
                'catagories_Id' => $basket->catagories_Id
            ]);
            //خصم الكميه من جدول المنجات
            $prodect_counter=products::where("id",$basket->product_Id)->first();
            $prodect_counter->update([
                "counter"=>($prodect_counter->counter - $basket->counter)
            ]);

            //حذف المنتج من سله 
            $basket->delete();
            session()->flash('success', 'تمت عملية البيع بنجاح');
            return to_route('index_ai');
           
        }
        else{
            session()->flash('error', 'خطأ: لم يتم العثور على المنتج');
            return redirect()->route('index_ai');
        }
    }


    public function cart_ai_sales_all(){
        $baskets = AL::where('Manger_Id', auth()->user()->id)->get(); // أو حسب الطريقة التي تخزن بها بيانات السلة
    
        if ($baskets->isEmpty()) {
            session()->flash('error', 'السلة فارغة');
            return redirect()->route('index_ai');
        }
    
        foreach ($baskets as $basket) {
            // إضافة للسجل
            AL_sales::create([
                'product_Id' => $basket->product_Id,
                'Manger_Id' => auth()->user()->id,
                'counter' => $basket->counter,
                'total_price' => $basket->total_price,
                'catagories_Id' => $basket->catagories_Id
            ]);
    
            // خصم من المخزون
            $product = products::find($basket->product_Id);
            if ($product) {
                $product->update([
                    'counter' => $product->counter - $basket->counter
                ]);
            }
    
            // حذف من السلة
            $basket->delete();
        }
        session()->flash('success', 'تم بيع جميع المنتجات في السلة بنجاح');
        return redirect()->route('index_ai');
    }
    
    public function cart_ai_delete_all(){
        $DE=AL::where('Manger_Id', auth()->user()->id)->delete();
        if(!$DE){
            session()->flash('error', 'خطأ: لم يتم العثور على المنتج');
            return redirect()->route('index_ai');
        }
        session()->flash('success', 'تم حذف جميع المنتجات من السلة بنجاح');
        return redirect()->route('index_ai');
    }
   
    public function update_ai_cat(Request $request, $id)
    {
        $basket = AL::find($id);
        if ($basket) {
            $basket->update([
                'counter' => $request->counter,
                'total_price' => $basket->total_price * $request->counter,
            ]);
            session()->flash('success', 'تم التحديث بنجاح');
        } else {
            session()->flash('error', 'خطأ: لم يتم العثور على المنتج');
        }
    
        return redirect()->route('index_ai');
    }




}
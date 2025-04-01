<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class ProductsController extends Controller
{

  public  function index(){
   // $data =products::where("status","Active")->where("Manger_Id",2)->get();
    $data=DB::select("
    SELECT 
    products.id as id_products,
    image,
    name,
    categories.mode as name_categories,
    modeType,
    price_buy,
    price_sales,
    counter

FROM `products`
INNER JOIN categories ON products.catagories_Id=categories.id
WHERE status ='Active' AND Manger_Id=? AND deleted_at IS NULL
    ",[Auth()->user()->id]);
      return view("Admin_Provider.product.index_pro",["data"=>$data]);
    }

    public function create(){
      $category=categories::all();

        return view("Admin_Provider.product.create_pro",["category"=>$category]);
    }

    public function store(Request $request){
       
       // $dd=dd($request);
    //    return $dd;
      
    $request->validate([
           "name"=>"required|min:2",
           "price_buy"=>"required|numeric|min:0",
           "price_sales"=>"required|numeric|min:0",
           "counter"=>"required|numeric|min:0",
        ]);
 
        $imge = $request->file('image')->getClientOriginalName();
        $phate = $request->file('image')->storeAs('', $imge, 'Images_Product');
      // $img_path = $request->file('image')->store('', 'Images_Product');

       products::create([
       "name" =>$request->name,
       "image" =>'ImagesProduct' . '/' . $phate,
      //  "image" =>$phate,
       "modeType"=>$request->modeType,
       "description"=>$request->description,
       "price_buy"=>$request->price_buy,
       "price_sales"=>$request->price_sales,
       "counter"=>$request->counter,
       "status"        => "Wait",
       "Manger_Id"=>Auth()->user()->id,
       "catagories_Id"=>$request->catagories_Id ,
       //"catagories_Id "=>$request->catagories_Id
       ]);

       session()->flash("success"," تم الاضافه بنجاح يرجى الانتظار لموافقه الاداره على عرض المنتج ,المنتج قيد الانتظار ");
      return to_route("index_pro");
    }
 
    public function edit($id){
       $sel=products::where("id",$id)->first();
       $catagory=categories::where("id",$sel->catagories_Id)->first();
       //dd($catagory);
       $catagory_all=categories::all();
       if($sel){
        return view("Admin_Provider.product.edit_pro",["sel"=>$sel,"catagory"=>$catagory,"catagory_all"=>$catagory_all]);
       }
       return to_route("index_pro");
    }

    public function updata(Request $request,$id){
      
        // $request->validate([
        //     "name" => "request|min:2",
        //     "price_buy"=>"required|numeric|min:0",
        //     "price_sales"=>"required|numeric|min:0",
        //     "counter"=>"required|numeric|min:0",

        // ]);
        if($request->image){
          $imge = $request->file('image')->getClientOriginalName();
          $phate = $request->file('image')->storeAs('', $imge, 'Images_Product');

          products::where("id",$id)->update([
         "image" =>'ImagesProduct' . '/' . $phate,
          ]);
        }
     

        products::where("id",$id)->update([
            "id"=>$id,
            "name"=>$request->name,
            "modeType"=>$request->modeType,
            "description"=>$request->description,
            "price_buy"=>$request->price_buy,
            "price_sales"=>$request->price_sales,
            "counter"=>$request->counter,
            "catagories_Id"=>$request->catagory_id,

        ]);

        session()->flash("edit","تم التعديل بنجاح");
        return to_route("index_pro");
    }
    
    // public function ed($id){
    //   $id_de=products::where("id",$id)->first();
    //   return view("Admin_Provider.product.delete_pro",["id_de"=>$id_de]);
    // }

    public function delete($id_products){
     //dd($id_products);
     $prod = products::where("id", $id_products)->first(); 
     if ($prod) {
         $prod->delete(); // هذا سيعمل فقط إذا كان لديك softDeletes
         session()->flash("success", "تمت عملية الحذف بنجاح");
     } else {
         session()->flash("error", "لم يتم العثور على المنتج");
     }
     return to_route('index_pro');
     
    }




    public function show_delete(){
      $softdeletin=products::onlyTrashed()->get();
      return view("Admin_Provider.product.show_delete_pro",["softdeletin"=>$softdeletin]);
    }

    public function restor($id){
       products::withTrashed()->where("id",$id)->restore();
       session()->flash("success","تم استرجاع المنتاج بنجاح");
       return to_route("index_pro");
       // return redirect()->back();
    }

    public function forcedelete($id){
      session()->flash("success", "تمت عملية الحذف بنجاح");
      products::withTrashed()->where("id",$id)->forceDelete();
      return to_route("index_pro");
    }




    


    // public function getAllProductByID()
    // {
    //     $data = Products::where("Manger_Id", Auth()->user()->id)
    //         ->orderByDesc("id")
    //         ->get();

    //     return view("Dashboard/ProviderAdmin/Product/StatusProduct", ["data" => $data]);
    // }


    public function showprodect_provider(){
      $data=products::where("Manger_Id",Auth()->user()->id)
      ->orderByDesc("id")->get();

      return view("home.showprodect_provider",["data"=>$data]);
    }



    public function showproduct_status(){
      $data=products::where("status","wait")->get();
      return view("home.showprodudct_status",["data"=>$data]);
    }


    public function requset_product_wait_active(Request $request,$id){

      products::where("id",$id)->update(["status"=>"Active",]);
      session()->flash("success","تم القبول بالمنتج بنجاح");
      return to_route("showproduct_status");
    }


    public function requset_product_wait_unactive(Request $request,$id){

      products::where("id",$id)->update(["status"=>"Unactive"]);
      session()->flash("success","تم الرفض بالمنتج بنجاح");
      return to_route("showproduct_status");

    }







    public function all_product_active(){
      $data=products::where("status","Active")->where("counter","!=","0")->get();
      return view("Master_Admin.allproduct.all_product_active",["data"=>$data]);
    }
 
    
    public function Reporte_product(){
      //$data=products::where("status","Active")->where("counter","!=","0")->get();
      $Start_time=products::first();
      $End_time=products::orderByDesc("id")->first();
      $data=DB::select('select * from products where status="unactive" or created_at between ? and ?', [$Start_time,$End_time]);
      return view("Master_Admin.allproduct.all_product_unactive",
      [
        "data"=>$data,
        "Start_time"=>$Start_time->created_at->format('Y-m-d'),
        "End_time"=> $End_time->created_at->format('Y-m-d'),
      ]);
    }
    
    public function Reporte_produc_Time(Request $request){
   //dd($request);
      $Start_time=products::first();
      $End_time=products::orderByDesc("id")->first();
      $type_pro=$request->type_pro;
      
      if($type_pro=="null_val"){
      //  $type_pro="Active";
        $counter=0;
        $data=DB::select('select * from products where created_at between ? and ? and counter = ?', [$request->Start_time, $request->End_time,$counter]);
       }


       if($type_pro !="null_val"){
        $data=DB::select("SELECT * FROM products WHERE deleted_at IS NULL AND status =? AND created_at BETWEEN ? AND ? and counter != 0",[$type_pro,$request->Start_time, $request->End_time]);
       }
      return view("Master_Admin.allproduct.all_product_unactive",
      [
        "data"=>$data,
        "Start_time"=>$request->Start_time,
        "End_time"=>  $request->End_time
      
      ]);
      
    }
}

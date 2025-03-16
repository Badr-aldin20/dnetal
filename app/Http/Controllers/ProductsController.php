<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class ProductsController extends Controller
{
  public  function index(){
    $data=products::where("Manger_Id",Auth()->user()->id)
    ->where("status","Active")
    ->get();
      return view("Admin_Provider.product.index_pro",["data"=>$data]);
    }

    public function create(){
        return view("Admin_Provider.product.create_pro");
    }

    public function store(Request $request){
       
    //     $dd=dd($request);
    //    return $dd;
        $request->validate([
           "name"=>"required|min:2",
           "price_buy"=>"required|numeric|min:0",
           "price_sales"=>"required|numeric|min:0",
           "counter"=>"required|numeric|min:0",
        ]);
        $imge = $request->file('image')->getClientOriginalName();
        $phate = $request->file('image')->storeAs('users', $imge, 'image_pro');
       // $img_path = $request->file('image')->store('', 'image_pro');

       products::create([
       "name" =>$request->name,
      // "image" =>'ImagesProduct' . '/' . $img_path,
       "image" =>$phate,
       "modeType"=>$request->modeType,
       "description"=>$request->description,
       "price_buy"=>$request->price_buy,
       "price_sales"=>$request->price_sales,
       "counter"=>$request->counter,
       "status"        => "Wait",
       "Manger_Id"=>Auth()->user()->id
       ]);

       session()->flash("success"," تم الاضافه بنجاح يرجى الانتظار لموافقه الاداره على عرض المنتج ,المنتج قيد الانتظار ");
      return to_route("index_pro");
    }
 
    public function edit($id){
       $sel=products::where("id",$id)->first();
       if($sel){
        return view("Admin_Provider.product.edit_pro",["sel"=>$sel]);
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
        $imge = $request->file('image')->getClientOriginalName();
        $phate = $request->file('image')->storeAs('users', $imge, 'image_pro');

        products::where("id",$id)->update([
            "id"=>$id,
            "name"=>$request->name,
            "image" =>$phate,
            "modeType"=>$request->modeType,
            "description"=>$request->description,
            "price_buy"=>$request->price_buy,
            "price_sales"=>$request->price_sales,
            "counter"=>$request->counter,
        ]);

        session()->flash("edit","تم التعديل بنجاح");
        return to_route("index_pro");
    }
    
    // public function ed($id){
    //   $id_de=products::where("id",$id)->first();
    //   return view("Admin_Provider.product.delete_pro",["id_de"=>$id_de]);
    // }

    public function delete($id){
     
      products::where("id",$id)->delete();
      return to_route("index_pro");
     
    }




    public function show_delete(){
      $softdeletin=products::onlyTrashed()->get();
      return view("Admin_Provider.product.show_delete_pro",["softdeletin"=>$softdeletin]);
    }

    public function restor($id){
       products::withTrashed()->where("id",$id)->restore();
       return to_route("index_pro");
       // return redirect()->back();
    }

    public function forcedelete($id){
      products::withTrashed()->where("id",$id)->forceDelete();
      return to_route("index_pro");
    }





    public function getAllProductByID()
    {
        $data = Products::where("Manger_Id", Auth()->user()->id)
            ->orderByDesc("id")
            ->get();

        return view("Dashboard/ProviderAdmin/Product/StatusProduct", ["data" => $data]);
    }


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
        $data=DB::select('select * from products where status=? and created_at between ? and ? and counter != 0', [$type_pro,$request->Start_time, $request->End_time]);
       }
      return view("Master_Admin.allproduct.all_product_unactive",
      [
        "data"=>$data,
        "Start_time"=>$request->Start_time,
        "End_time"=>  $request->End_time
      
      ]);
      
    }
}

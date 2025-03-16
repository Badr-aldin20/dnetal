<?php

namespace App\Http\Controllers;

use App\Models\delaveries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DelaveriesController extends Controller
{
    public function index_delivery(){

        $data=delaveries::where("Manager_Id",Auth()->user()->id)->get();
        return view("Admin_Provider.dalevry.index_dalevry",["data"=>$data]);
    }

    public function create_delivery(){

        return view("Admin_Provider.dalevry.create_delivery");
    }

    public function store_delivery(Request $request){
     
        $request->validate([
         "name"=>"required",
         "email"=>"required|email|min:4",
         "password"=>"required|min:8"
        ]);
      //$haspassword=Hash::make($request->password);
        delaveries::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$request->password,
            "Manager_Id"=>Auth()->user()->id,
            "Status"=>"offline"
        ]);
        session()->flash("success","تم اضافه موصل بنجاح");
        return to_route("index_delivery");

    }


    public function edit_delivery($id){
    $data=delaveries::where('id',$id)->first();
    return view("Admin_Provider.dalevry.edit_delivery",["data"=>$data]);
    }

    public function updata_delivery(Request $request,$id){
        $request->validate([
            "name"=>"required",
            "email"=>"required|email|min:4",
            "password"=>"required|min:8"
        ]);

        $user=delaveries::where("id",$id)->update([
          "name"=>$request->name,
          "email"=>$request->email,
          "password"=>$request->password
        ]);

        if( $user){
            session()->flash("success","تم تعديل بيانات الموصل بنجاح");
            return to_route('index_delivery');
        }
        session()->flash("erorr","لم يتم تعديل بيانات الموصل بنجاح  ");
        return to_route('index_delivery');

    }



    public function delete_delivery($id){
    delaveries::where("id",$id)->delete();
        session()->flash("success"," تم حذف الموصل بنجاح");
        return to_route("index_delivery");
      }






      public function index_order_delivery(){
        $data = DB::select("
        SELECT 
             products.name,
             products.image,
             sales.id,
             sales.couner,
             sales.Order,
             sales.Status_order,
             sales.created_at,
             products.price_sales,
             products.price_buy,
             delaveries.name as 'delivaryName',
             ((products.price_sales - products.price_buy) * sales.couner) as Balance
         
         FROM 
             sales
         INNER JOIN 
             products ON sales.product_Id = products.id
         LEFT JOIN 
             delaveries ON sales.deliver_id = delaveries.id
         WHERE 
             products.Manger_Id = ?
             AND sales.Order != 0
         ORDER BY 
             sales.id DESC;
 
     ", [Auth()->user()->id]);
 
         $deliveries = delaveries::where("status", "Online")
             ->where("Manager_Id", Auth()->user()->id)
             ->get();

        return view("Admin_Provider.dalevry.index_order_delivery",[
                "data" => $data,
                "deliveries" => $deliveries,
            ]);
      }

}

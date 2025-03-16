<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class User_Controller extends Controller
{
   public function supplier(){
    $data=User::where("type","Admin Provider")->where("active",1)->get();
    return view("Master_Admin.Supplier.index_supp",["data"=>$data]);

   }
   public function show_product_supplier($id){
      $data=products::where("Manger_Id",$id)->get();
      return view("Master_Admin.Supplier.show_product_supplier",["data"=>$data]);

   }
   public function stope_supplier($id){
      User::where("id",$id)->update(["active"=>0]);
      session()->flash("sussess","تم ايقاف المزود بنجاح");
      return to_route("supplier");
   }
   
   public function search_supplier(Request $request){
      $data=User::where("type","Admin Provider")->where("name","like","%".$request->txt."%")->get();
      return view("Master_Admin.Supplier.index_supp",["data"=>$data]);
   }






   public function clinic(){
   $data=User::where("type","Clinic")->where("active",1)->get();
   return view("Master_Admin.Clinic.index_clinic",["data"=>$data]);
   }
   public function search_clinic(Request $request){
      $data=DB::select("SELECT * FROM users where type='Clinic' and name like '%$request->txt%'");
      if($data==null){
         session()->flash("error","لا يوجد بيانات");
        // return to_route("search_clinic");
      }
      return view("Master_Admin.Clinic.index_clinic",["data"=>$data]);
   }

   public function stope_clinic($id){
      User::where("id",$id)->update(["active"=>0]);
      session()->flash("sussess","تم ايقاف التطبيق بنجاح");
     return to_route('clinic');

   }









   public function showuser_active(){
      $data=User::where("active",0)->get();
       return view("home.showuser_active",["data"=>$data]);
   }

   public function request_active_user(Request $request,$id){
      User::where("id",$id)->update(["active"=>1]);
      session()->flash("success","تم تفعيل اليوزر بنجاح");
      return to_route("showuser_active");
      
   }

   public function request_delete_user($id){
      User::where("id",$id)->delete();
      session()->flash("success","تم حذف اليوزر بنجاح");
      return to_route("showuser_active");
   }
}

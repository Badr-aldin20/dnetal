<?php

namespace App\Http\Controllers;

use App\Models\categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index_categories(){
        $data=categories::all();
        return view("Master_Admin.allproduct.categories.index_categories",["data"=>$data]);
    }

    public function create_categories(){

        return view("Master_Admin.allproduct.categories.create_categories");
    }

    public function store_categories(Request $request){
       
        $request->validate([
          "mode"=>'required|min:3'
        ]);

        $cate=categories::create([
            "mode"=>$request->mode

        ]);
        
        if(!$cate){
            session()->flash("error","يوجد خطأ في الادخال");
            return to_route('index_categories');
        }
        session()->flash("success","تم الاضافه بنجاح ");
        return to_route('index_categories');

    }

    public function edit_categories($id){
     $data=categories::where("id",$id)->first();
     return view("Master_Admin.allproduct.categories.edit_categories",["data"=>$data]);
    }

    public function updata_categories(Request $request,$id){
    
        $request->validate([
            "mode"=>'required',
        ]);


        $user=categories::where("id",$id)->update([
          "mode"=>$request->mode
        ]);

        if(!$user){
            session()->flash("error","لم تتم عمليه التعديل");
            return to_route('index_categories');
        }
        session()->flash("success","تم التعديل بنجاح");
        return to_route('index_categories');
    }

    public function del_categories($id){

        categories::where("id",$id)->delete();
        session()->flash("success"," تم الحذف بنجاح");
        return to_route('index_categories'); 
    
    }
}

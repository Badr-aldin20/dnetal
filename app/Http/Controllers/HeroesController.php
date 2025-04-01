<?php

namespace App\Http\Controllers;

use App\Models\delaveries;
use App\Models\heroes;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HeroesController extends Controller
{
    public function index_heroe(){
    $data=DB::select("
     SELECT 
     heroes.id as id_heroe, 
     products.id,
     products.image as image,
     products.name  as name,
     products.price_buy as price_old,
     price_new,
     (products.price_buy-price_new) as perce,
     percentage,
     end_time,
     CASE WHEN end_time < NOW() THEN '0' ELSE '1' END AS Active 
            FROM heroes 
            INNER JOIN products ON heroes.product_Id=products.id
            WHERE heroes.status='Success' AND heroes.Manger_Id=?
            ORDER BY id DESC
    ",[Auth()->user()->id]);
    return view("Admin_Provider.Hero.index_heroe",["data"=>$data]);

    }

    public function creat_heroe(){
        $prod=products::where("Manger_Id",Auth()->user()->id)->where("status","Active")->get();

       //   dd($prod);
        return view("Admin_Provider.Hero.creat_heroe",["prod"=>$prod]);
    }

    public function story_heroe(Request $request){
    
        $request->validate([
        "product_Id"=>"required|numeric",
        "end_time"=>"required|date",
        "description"=>"required|min:5",
        "price_new"=>"required|numeric|min:0",
        "percentage"=>"required|string|max:4"	
        ]);

        heroes::create([
         "product_Id"=>$request->product_Id,
         "price_new"=>$request->price_new,
         "end_time"=>$request->end_time,
         "description"=>$request->description,
         "percentage"=>$request->percentage,
         "status"=>"Underway",
         "Manger_Id"=>Auth()->user()->id
        ]);

        session()->flash("success","تم رفع طلب عرض للاداره طلبك قيد الانتظار في حال تم الموافقه عليه سيتم رفع العرض");
        return to_route("index_heroe");
    }







    public function status_heroe_failure($id_heroe){
        $da=heroes::where("id",$id_heroe)->update([
            "status"=>"failure"
        ]);
        if(!$da){
         session()->flash("erorr"," لم يتم الغاء العرض بنجاح");
       return to_route('index_heroe');
        }
        session()->flash("success","تم الغاء العرض بنجاح");
        return to_route('index_heroe');
    }
    


    public function show_hero_status(){
     $data=DB::select("
     SELECT 
     users.name AS name_Manger,
     heroes.id as id_heroe, 
     products.id,
     products.image as image,
     products.name  as name,
     products.price_buy as price_old,
     price_new,
     (products.price_buy-price_new) as perce,
     percentage,
     end_time,
          CASE WHEN end_time < NOW() THEN '0' ELSE '1' END AS Active 
            FROM heroes 
            INNER JOIN products ON heroes.product_Id=products.id
            INNER JOIN users ON heroes.Manger_Id=users.id
            WHERE heroes.status='Underway'
            ORDER BY id DESC
     ");
     return view("home.show_hero_status",["data"=>$data]);
    }

    public function delete_hero_status($id_heroe)
    {
       $da=heroes::where("id",$id_heroe)->delete();
       if(!$da){
        session()->flash("success"," لم يتم الحذف العرض بنجاح");
        return to_route('/');
       }
       session()->flash("success"," تم الحذف العرض بنجاح");
       return to_route('/');
    }
  
  
    public function Active_hero_status($id_heroe)
    {
        $da=heroes::where("id",$id_heroe)->update([
            "status"=>"Success"
        ]);
        if(!$da){
         session()->flash("erorr"," لم يتم قبول العرض بنجاح");
       return to_route('/');
        }
        session()->flash("success","تم قبول العرض بنجاح");
        return to_route('/');
    }
}

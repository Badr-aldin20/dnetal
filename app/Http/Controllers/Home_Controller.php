<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Home_Controller extends Controller
{
    public function index(){
        
        $Allprodect=products::count();
        $product_Active=products::where("status","Active")->count();
        $product_Unactive=products::where("status","Unactive")->count();
        $All_Suplliers=User::where("type","Admin Provider")->count();
        $All_Clinic=User::where("type","Clinic")->count();
        $blananc=User::where("id",Auth()->user()->id)->first();
        $blan=$blananc->stock;
        return view("home.home",
        [
        "Allprodect"       =>   $Allprodect,
        "product_Active"   =>   $product_Active,
        "product_Unactive" =>   $product_Unactive,
        "All_Suplliers"    =>   $All_Suplliers,
        "All_Clinic"       =>   $All_Clinic,
        "blananc"          =>   $blan,
    
    ]);

    }

    public function profile(){
        $data_use=User::where("id",Auth()->user()->id)->first();
        $data_use_pass=Hash::check('',$data_use->password);

        return view("home.prfile",["data_user"=>$data_use,"data_use_pass"=>$data_use_pass]);
    }

    public function update_profile(Request $request,$id){
        

     $user=User::where("id",$id)->first();
    if(!$user){
        session()->flash("error","لا يمكن تعديل هذا المستخدم");
        return to_route("profile");

        // if ($request->image != null) {
        //     $img_path = $request->file('image')->store('', 'Images');
        //     $user->update(["image" => 'ImagesProfile/' . $img_path]);
        //     return to_route("/");
        // }

              
  
        
    }
    
    if($request->image ){

        $request->validate([
            "name"=>"required|min:3",
            "email"=>"required|email",
            "Location"=>"required",
            "name_company"=>"required|min:4|max:35",
            "phone"=>"required|min:9",
          //  "password"=>"required|min:8"
        ]);
        $imge = $request->file('image')->getClientOriginalName();
        $phate = $request->file('image')->storeAs('users', $imge, 'image_user');
        User::where("id",$id)->update([
            "name" =>$request->name,
            "email" =>$request->email,
            "phone" =>$request->phone,
            "Location" =>$request->Location,
            "password" =>Hash::make($request->password),
            "name_company" =>$request->name_company,
            "phone" =>$request->phone,
            "image" => $phate,
  
        ]);

        
        return to_route("/");
    
    }


    if(!$request->image ){

        $request->validate([
            "name"=>"required|min:3",
            "email"=>"required|email",
           // "password"=>"required|min:8",
            "Location"=>"required",
            "name_company"=>"required|min:4|max:35",
            "phone"=>"required|min:9"
        ]);
       
        User::where("id",$id)->update([
            "name" =>$request->name,
            "email" =>$request->email,
            "phone" =>$request->phone,
            "password" =>Hash::make($request->password),
            "Location" =>$request->Location,
            "name_company" =>$request->name_company,
            "phone" =>$request->phone,
          
          ]);
          
          return to_route("profile");
    }




        
    }



    // public function update_profile(Request $request){
    //     $user=User::where("id",Auth()->user()->id)->first();
    //     $user->name=$request->name;
    //     $user->email=$request->email;
    //     $user->phone=$request->phone;
    //     $user->save();
    //     return redirect()->back()->with("success","تم تعديل البيانات بنجاح");
    // }
    // public function update_password(Request $request){
    //     $user=User::where("id",Auth()->user()->id)->first();
    //     if($request->password==$request->password_confirmation){
    //         $user->password=bcrypt($request->password);
    //         $user->save();
    //         return redirect()->back()->with("success","تم تعديل كلمة المرور بنجاح");
    //     }else{
    //         return redirect()->back()->with("error","كلمة المرور غير متطابقة");
    //     }
    // }

}

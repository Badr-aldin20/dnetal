<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Auth_Controller extends Controller
{
   public function Registeruser(Request $request){
    $request->validate([
        "name"=>"required|min:3",
        "email"=>"required|email",
        "password"=>"required|min:8",
        "Location"=>"required",
        "name_company"=>"required|min:4|max:35",
        "phone"=>"required|min:9"
    ]);

    $user=User::where("email",$request->email)->first();
    if($user){
        session()->flash("error","هذا البريد الالكتروني موجود من قبل");
        return to_route("Register_Au");
    }
    
    $passwordhash=Hash::make($request->password);

    $user=User::create([
      "name"=>$request->name,
      "name_company"=>$request->name_company,
      "Location"=>$request->Location,
      "phone"=>$request->phone,
      "email"=>$request->email,
      "password"=>$passwordhash,
      "type"=>"Admin Provider"
      
      
    ]);
    return to_route("wait_Au");


   
}
   
    public function logenuser(Request $request){
        $request->validate([
            'email'=>"required|email|min:4",
            'password'=>"required|min:4"
        ]);

        $user=User::where("email",$request->email)
                 ->where("type","!=","Clinic")
                 ->first();

        if(!$user){
            session()->flash("error","هذا البريد الالكتروني غير موجود");
            return to_route("login_Au");
        }
        
       if(!Hash::check($request->password,$user->password)){
        session()->flash("error","كلمه المرور غلط");
        return to_route("login_Au");
       }

       if($user->active==true){

        Auth()->login($user);
        return to_route("index_pro");
       }

       else{
        session()->flash("error","يرجى مراجع الاداره على طلبك ");
        return to_route("login_Au");
       }
    }
    
    public function Logout(Request $request){
          Auth()->logout();
         return to_route("login_Au");
    }

}
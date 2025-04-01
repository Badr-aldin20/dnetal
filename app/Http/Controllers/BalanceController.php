<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function index(){
        $data=DB::select("SELECT 
       balances.id as id_bala,
       clinic_id,
       users.name as name_clin,
       balances.status,
       totel_balance,
       description,
       balances.created_at as deta
       
    
    
    FROM `balances`
    INNER JOIN users ON balances.clinic_id = users.id
        WHERE balances.status = 'Success' OR balances.status = 'failure'
        ORDER BY balances.id DESC
    ");
        return view("Master_Admin.Balance.balance",["data"=>$data]);
    }

    public function create_balance(){
    $users=User::where("type","clinic")->get();
    return view("Master_Admin.Balance.create_balance",["users"=>$users]);

    }
     
    public function store_balance(Request $request){
    
        $clin_add_stoch=User::where("type","clinic")->where("id",$request->clinic_id)->first();

        if($clin_add_stoch)
        {

            $request->validate([
                "clinic_id"=>'required',
                "totel_balance"=>'required|numeric|min:0',
                "description"=>'required'
                //clinic_id,status,
             ]);
             $totel_balance=$request->totel_balance;
            $bala= Balance::create([
                "clinic_id"=>$request->clinic_id,
                "totel_balance"=>$totel_balance,
                "description"=>$request->description,
                "status"=>"Success"
             ]);
           
             
             
        
             if(!$bala){
                session()->flash("error","يوجد خطأ في الادخال");
                return to_route('balance');
            }

           
           
            $clin_add_stoch->update(["stock"=>($clin_add_stoch->stock + $totel_balance )]);

            // User::update([
            //     $user->Stock += $request->totel_balance
            // ]);
            session()->flash("success","تم الاضافه بنجاح ");
            return to_route('balance');

        }


        session()->flash("error","لا يوجد تطبيق بنفس الاسم");
        return to_route('balance');


    }



    public function edit_balance($id){
     $data=Balance::where("id",$id)->first();
     $users=User::where("type","clinic")->get();
    

     $name_clinc=User::where("id",$data->clinic_id)->first();
    
     if( $data->status == "failure" ){
        session()->flash("error","لا يمكن تعديل عمليه مرفوضه");
        return to_route('balance');
     }
     return view("Master_Admin.Balance.edit_balance",["data"=>$data,"users"=>$users,"name_clinc"=>$name_clinc]);
    }



    //التعديل
    public function update_balance(Request $request,$id){
     
        $clin_add_stoch=User::where("type","clinic")->where("id",$request->clinic_id)->first();
    
       // dd($request);
        if($clin_add_stoch){
       
            $request->validate([
                "clinic_id"=>'required',
                "totel_balance"=>'required|numeric|min:0',
                "description"=>'required'
                //clinic_id,status,
             ]);
             //في حال تم تغير الحساب للضافه للحساب الثاني القيمه بدون خصم من القيمه السابقه
            if($request->clinic_id != $request->id_user){

                //مثل عند التعديل من حساب الى حساب يتم خصم القيمه الاولى من الحساب 
                $clin_tack_stoch=User::where("type","clinic")->where("id",$request->id_user)->first();
                $stock_clint_old=($clin_tack_stoch->stock - $request->minc_balance);

                  //في حال كان الحساب الذي ش اعدل عليه اقل من الصفر
                if( $stock_clint_old < 0){
                  session()->flash("error","لم يتم  التعديل  لان الحساب السابق لا يصلح ان يكون اقل من الصفر ");
                   return to_route('balance');
                 }

               //عمل خصم على الحساب القديم
                 $clin_tack_stoch->update(["stock"=>$stock_clint_old]);

             //اضافه لرصيد الى الحساب الجديد
                $clin_add_stoch->update(["stock"=>($clin_add_stoch->stock  + $request->totel_balance )]);
                
                Balance::where("id",$id)->update([
                    "clinic_id"=>$request->clinic_id,
                    "totel_balance"=>$request->totel_balance,
                    "description"=>$request->description,
                    //"status"=>"Success"
                 ]);
                
                session()->flash("success"," , تم التعديل الاسم مع اضافه الرصيد بنجاح وخصم الحساب من الرصيد السابق");
                 return to_route('balance');
            }

            
            
            //في حال كان الحساب  نفس الحساب الذي سيتم التعديل عليه تعديل المبلغ مع خصم
            elseif($request->clinic_id == $request->id_user)
            {

                $stock_clint_one=(($clin_add_stoch->stock - $request->minc_balance) + $request->totel_balance );
               //في حال كان الرصيد المعدل سيجعل العمود اقل من الصفر
                if($stock_clint_one < 0 ){
                   session()->flash("error","لم يتم  التعديل  لان الحساب لا يصلح ان يكون اقل من الصفر ");
                   return to_route('balance');
                }
             
                $clin_add_stoch->update(["stock"=>$stock_clint_one]);
                
                Balance::where("id",$id)->update([
                    "clinic_id"=>$request->clinic_id,
                    "totel_balance"=>$request->totel_balance,
                    "description"=>$request->description,
                    //"status"=>"Success"
                 ]);
                
                session()->flash("success","تم التعديل الرصيد  بنجاح ");
                return to_route('balance');
            }
        }
         session()->flash("error","لا يوجد حساب بنفس الاسم");
         return to_route('balance');
         }


       public function search_balance(Request $request){  
     //  dd($request->txt);
        $data=DB::select(
    "SELECT
    balances.id as id_bala,
        clinic_id,
        users.name as name_clin,
        balances.status,
        totel_balance,
        description,
        balances.created_at as deta
        
     
     
     FROM `balances`
     INNER JOIN users ON balances.clinic_id = users.id 
         WHERE users.name LIKE '%$request->txt%' AND balances.status != 'Underway'
         ORDER BY balances.id DESC
     ");

          if($data==null){
           session()->flash("error","لا يوجد بيانات");
          return to_route("balance");
        }
         return view("Master_Admin.Balance.balance",["data"=>$data]);

       }

       















    public function balanc_clint(){
        $data=DB::select("SELECT 
        balances.id as id_bala,
        clinic_id,
        users.name as name_clin,
        balances.status,
        totel_balance,
        description,
        balances.created_at as deta
        
     
     
     FROM `balances`
     INNER JOIN users ON balances.clinic_id = users.id
     WHERE balances.status = 'Underway'
     ORDER BY balances.id DESC 
     ");
         return view("Master_Admin.Balance.balanc_clint",["data"=>$data]);
    }
  
  
  
  
    public function search_balanc_clint(Request $request){
        $data=DB::select("SELECT 
        balances.id as id_bala,
        clinic_id,
        users.name as name_clin,
        balances.status,
        totel_balance,
        description,
        balances.created_at as deta
        
     
     
     FROM `balances`
     INNER JOIN users ON balances.clinic_id = users.id
     WHERE users.name LIKE '%$request->txt%' AND balances.status = 'Underway'
     ORDER BY balances.id DESC 
     ");

        if($data==null){
           session()->flash("error","لا يوجد بيانات");
          return to_route("balanc_clint");
        }
         return view("Master_Admin.Balance.balanc_clint",["data"=>$data]);


    }
     //قبول الطلب
     public function Asess_balanc_clint($id){
        $cinacl_bala=Balance::where("id",$id)->first();
        $cinacl_bala->update([
            "status"=>"Success"
        ]);
       if(!$cinacl_bala){
        session()->flash("error","لم يتم قبول الطلب");
        return to_route('balanc_clint');
       }
       

       $clin_add_stoch=User::where("type","clinic")->where("id",$cinacl_bala->clinic_id)->first();
       $clin_add_stoch->update(["stock"=>($clin_add_stoch->stock + $cinacl_bala->totel_balance)]);
      
       session()->flash("success","   تم القبول للطلب واضافه الرصيد للحساب");
       return to_route('balanc_clint');
     }




      //الغاء الطلب 
    public function cincal_balanc_clint($id){
    $cinacl_bala=Balance::where("id",$id)->update([
        "status"=>"failure"
    ]);
   if(!$cinacl_bala){
    session()->flash("error","لم يتم الغاء الطلب");
    return to_route('balanc_clint');
   }

   session()->flash("success","  تم الغاء الطلب ");
   return to_route('balanc_clint');

    }

    
}

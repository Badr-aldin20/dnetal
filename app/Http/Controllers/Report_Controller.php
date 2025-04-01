<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sales;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Report_Controller extends Controller
{
    public function index_Report_purchases_A()
    {
        $Start_time=sales::first();
        $End_time=sales::orderByDesc("id")->first();
        $prod=products::where("Manger_Id",Auth()->user()->id)->where("status","Active")->get();
        $product_Id=products::where("Manger_Id",'')->get();
        $data = DB::select("SELECT 
        products.image,
        products.name,
        products.price_buy,
        products.price_sales,
        sales.counter,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.counter) as Balance
         FROM sales INNER JOIN products on sales.product_Id=products.id and products.Manger_Id=? 
         Order BY sales.id DESC
        ", [Auth()->user()->id]);

        $total_Balance = 0;
        for ($i = 0; $i < count($data); $i++) {
            $total_Balance += $data[$i]->Balance;
        }
        return view("Admin_Provider.Report.pruchases.Report_pruchases", [
            "data" => $data,
            "prod"=>$prod,
           "product_Id"=>$product_Id,
            "total_Balance" => $total_Balance,
            "Start_time"=>$Start_time->created_at->format('Y-m-d'),
            "End_time"=> $End_time->created_at->format('Y-m-d'),
            ]);

    }

    public function Report_purchases_A(Request $request){
        $product_Id=products::where("Manger_Id",'')->get();
        if(!$request->product_Id)
        {
            $Start_time=$request->Start_time;
            $End_time=$request->End_time;
            $prod=products::where("Manger_Id",Auth()->user()->id)->where("status","Active")->get();
            $data = DB::select("
   SELECT 
        products.image,
        products.name,
        products.price_buy,
        products.price_sales,
        sales.counter,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.counter) as Balance
           FROM sales
        INNER JOIN products
        ON sales.product_Id = products.id
        AND products.Manger_Id = ?
        And sales.created_at between ? and ?
         ORDER BY sales.id DESC
    ", [Auth()->user()->id, $request->Start_time, $request->End_time]);
    
            $total_Balance = 0;
            for ($i = 0; $i < count($data); $i++) {
                $total_Balance += $data[$i]->Balance;
            }
            return view("Admin_Provider.Report.pruchases.Report_pruchases", [
                "data" => $data,
                "prod"=>$prod,
               "product_Id"=>$product_Id,
                "total_Balance" => $total_Balance,
                "Start_time"=>$Start_time,
                "End_time"=> $End_time,
                ]);
        }

        if($request->product_Id){

            $product_Id=products::where("id",$request->product_Id)->first();
            $Start_time=$request->Start_time;
            $End_time=$request->End_time;
            $prod=products::where("Manger_Id",Auth()->user()->id)->where("status","Active")->get();
            $data = DB::select("
   SELECT 
        products.image,
        products.name,
        products.price_buy,
        products.price_sales,
        sales.counter,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.counter) as Balance
           FROM sales
        INNER JOIN products
        ON sales.product_Id = products.id
        AND products.Manger_Id = ?
        AND products.id=?
        And sales.created_at between ? and ?
         ORDER BY sales.id DESC
    ", [Auth()->user()->id,$product_Id->id, $request->Start_time, $request->End_time]);
    
            $total_Balance = 0;
            for ($i = 0; $i < count($data); $i++) {
                $total_Balance += $data[$i]->Balance;
            }
            return view("Admin_Provider.Report.pruchases.Report_pruchases", [
                "data" => $data,
                "prod"=>$prod,
                "product_Id"=>$product_Id->id,
                "total_Balance" => $total_Balance,
                "Start_time"=>$Start_time,
                "End_time"=> $End_time,
                ]);
        }

    
    }

    
    public function Purchases_pdf_provider(Request $request){
        $product_Id=products::where("id",$request->product_Id)->first();
       
        if(!$product_Id){
            $data = DB::select("
      
         SELECT 
        products.image,
        products.name,
        products.price_buy,
        products.price_sales,
        sales.counter,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.counter) as Balance
           FROM sales
        INNER JOIN products
        ON sales.product_Id = products.id
        AND products.Manger_Id = ?
        And sales.created_at between ? and ?
         ORDER BY sales.id DESC
    ", [Auth()->user()->id, $request->Start_time, $request->End_time]);
    
    $total_Balance = 0;
    for ($i = 0; $i < count($data); $i++) {
        $total_Balance += $data[$i]->Balance;
    }
    
    $pdf = pdf::loadView('Admin_Provider.pdf.Purchases_pdf_provider', [
        "data" => $data,
        "total_Balance" => $total_Balance,
        "Start_time" => $request->Start_time,
        "End_time" => $request->End_time
    ]);
    return $pdf->download('invoice.pdf');
        }

        if($product_Id)
        {
            $data = DB::select("
      
            SELECT 
           products.image,
           products.name,
           products.price_buy,
           products.price_sales,
           sales.counter,
           sales.total_price,
           sales.created_at,
           ((products.price_buy - products.price_sales)*sales.counter) as Balance
              FROM sales
           INNER JOIN products
           ON sales.product_Id = products.id
           AND products.Manger_Id = ?
           AND products.id=?
           And sales.created_at between ? and ?
            ORDER BY sales.id DESC
       ", [Auth()->user()->id,$product_Id->id, $request->Start_time, $request->End_time]);
       
       $total_Balance = 0;
       for ($i = 0; $i < count($data); $i++) {
           $total_Balance += $data[$i]->Balance;
       }
       
       $pdf = pdf::loadView('Admin_Provider.pdf.Purchases_pdf_provider', [
           "data" => $data,
           "total_Balance" => $total_Balance,
           "Start_time" => $request->Start_time,
           "End_time" => $request->End_time
       ]);
       return $pdf->download('invoice.pdf');
        }
      

    //dd($data);
    }
















    public function process()
    {
        $data = DB::select("
       SELECT  
        users.name as name_user,
        products.image,
        products.name AS name_prodect,
        
        products.price_buy,
        products.price_sales,
        sales.counter,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.counter) as Balance
         FROM sales 
         INNER JOIN products on sales.product_Id=products.id 
         INNER JOIN users on sales.Manger_Id=users.id
         where DATE(sales.created_at) = CURDATE() 
         Order BY sales.id DESC
        ");

        $total_Balance = 0;
        for ($i = 0; $i < count($data); $i++) {
            $total_Balance += $data[$i]->Balance;
        }
        return view("Master_Admin.process.process", [
            "data" => $data,
            "total_Balance" => $total_Balance,
            ]);

    }

    public function process_search()
    {
        $Start_time=sales::first();
        $End_time=sales::orderByDesc("id")->first();
        $prod=products::where("status","Active")->get();
        $user=User::where("type","Admin Provider")->where("active",true)->get();
        $data = DB::select("
         SELECT  
        users.name as name_user,
        products.image,
        products.name AS name_prodect,
        products.price_buy,
        products.price_sales,
        sales.counter,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.counter) as Balance
         FROM sales 
         INNER JOIN products on sales.product_Id=products.id 
         INNER JOIN users on sales.Manger_Id=users.id
         Order BY sales.id DESC
        ");

        $total_Balance = 0;
        for ($i = 0; $i < count($data); $i++) {
            $total_Balance += $data[$i]->Balance;
        }
        return view("Master_Admin.process.process_search", [
            "data" => $data,
            "prod"=>$prod,
            "user"=>$user,
            "total_Balance" => $total_Balance,
            "Start_time"=>$Start_time->created_at->format('Y-m-d'),
            "End_time"=> $End_time->created_at->format('Y-m-d'),
            ]);

    }

    public function process_search_report(Request $request){

        $Start_time=$request->Start_time;
        $End_time=$request->End_time;
        $user=User::where("type","Admin Provider")->where("active",true)->get();
        $prod=products::where("status","Active")->get();
        $name_prodect=$request->name_prodect;
        $name_user=$request->name_user;
        if($name_user && !$name_prodect)
        {
            $data = DB::select("
         SELECT  
        users.name as name_user,
        products.image,
        products.name AS name_prodect,
        products.price_buy,
        products.price_sales,
        sales.counter,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.counter) as Balance
         FROM sales 
         INNER JOIN products on sales.product_Id=products.id 
         INNER JOIN users on sales.Manger_Id=users.id
         WHERE sales.Manger_Id=?
         AND sales.created_at between ? and ?
         Order BY sales.id DESC
        ",[$name_user,$request->Start_time, $request->End_time]);

        $total_Balance = 0;
        for ($i = 0; $i < count($data); $i++) {
            $total_Balance += $data[$i]->Balance;
        }
        return view("Master_Admin.process.process_search", [
            "data" => $data,
            "prod"=>$prod,
            "user"=>$user,
            "total_Balance" => $total_Balance,
            "Start_time"=>$Start_time,
            "End_time"=> $End_time,
            ]);
        }


        if($name_prodect && !$name_user)
        {
            $data = DB::select("
         SELECT  
        users.name as name_user,
        products.image,
        products.name AS name_prodect,
        products.price_buy,
        products.price_sales,
        sales.counter,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.counter) as Balance
         FROM sales 
         INNER JOIN products on sales.product_Id=products.id 
         INNER JOIN users on sales.Manger_Id=users.id
         WHERE sales.product_Id=?
         AND sales.created_at between ? and ?
         Order BY sales.id DESC
        ",[$name_prodect,$request->Start_time, $request->End_time]);

        $total_Balance = 0;
        for ($i = 0; $i < count($data); $i++) {
            $total_Balance += $data[$i]->Balance;
        }
        return view("Master_Admin.process.process_search", [
            "data" => $data,
            "prod"=>$prod,
            "user"=>$user,
            "total_Balance" => $total_Balance,
            "Start_time"=>$Start_time,
            "End_time"=> $End_time,
            ]);
        }



        if($name_prodect && $name_user){


            $data = DB::select("
            SELECT  
           users.name as name_user,
           products.image,
           products.name AS name_prodect,
           products.price_buy,
           products.price_sales,
           sales.counter,
           sales.total_price,
           sales.created_at,
           ((products.price_buy - products.price_sales)*sales.counter) as Balance
            FROM sales 
            INNER JOIN products on sales.product_Id=products.id 
            INNER JOIN users on sales.Manger_Id=users.id
            WHERE sales.product_Id=?
            AND sales.Manger_Id=?
            AND sales.created_at between ? and ?
            Order BY sales.id DESC
           ",[$name_prodect,$name_user,$request->Start_time, $request->End_time]);
   
           $total_Balance = 0;
           for ($i = 0; $i < count($data); $i++) {
               $total_Balance += $data[$i]->Balance;
           }
           return view("Master_Admin.process.process_search", [
               "data" => $data,
               "prod"=>$prod,
               "user"=>$user,
               "total_Balance" => $total_Balance,
               "Start_time"=>$Start_time,
               "End_time"=> $End_time,
               ]);



        }


        $data = DB::select("
         SELECT  
        users.name as name_user,
        products.image,
        products.name AS name_prodect,
        products.price_buy,
        products.price_sales,
        sales.counter,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.counter) as Balance
         FROM sales 
         INNER JOIN products on sales.product_Id=products.id 
         INNER JOIN users on sales.Manger_Id=users.id
         WHERE sales.created_at between ? and ?
         Order BY sales.id DESC
        ",[$request->Start_time, $request->End_time]);

        $total_Balance = 0;
        for ($i = 0; $i < count($data); $i++) {
            $total_Balance += $data[$i]->Balance;
        }
        return view("Master_Admin.process.process_search", [
            "data" => $data,
            "prod"=>$prod,
            "user"=>$user,
            "total_Balance" => $total_Balance,
            "Start_time"=>$Start_time,
            "End_time"=> $End_time,
            ]);

    }
}

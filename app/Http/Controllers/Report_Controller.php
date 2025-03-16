<?php

namespace App\Http\Controllers;

use App\Models\sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Report_Controller extends Controller
{
    public function index_Report_purchases_A()
    {
        $Start_time=sales::first();
        $End_time=sales::orderByDesc("id")->first();
        $data = DB::select("SELECT 
        products.image,
        products.name,
        products.price_buy,
        products.price_sales,
        sales.couner,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.couner) as Balance
         FROM sales INNER JOIN products on sales.product_Id=products.id and products.Manger_Id=? 
         Order BY sales.id DESC
        ", [Auth()->user()->id]);

        $total_Balance = 0;
        for ($i = 0; $i < count($data); $i++) {
            $total_Balance += $data[$i]->Balance;
        }
        return view("Admin_Provider.Report.pruchases.Report_pruchases", [
            "data" => $data,
            "total_Balance" => $total_Balance,
            "Start_time"=>$Start_time->created_at->format('Y-m-d'),
            "End_time"=> $End_time->created_at->format('Y-m-d'),
            ]);

    }

    public function Report_purchases_A(Request $request){
     //   dd($request);
            $Start_time=sales::first();
            $End_time=sales::orderByDesc("id")->first();
            $data = DB::select("
   SELECT 
        products.image,
        products.name,
        products.price_buy,
        products.price_sales,
        sales.couner,
        sales.total_price,
        sales.created_at,
        ((products.price_buy - products.price_sales)*sales.couner) as Balance
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
                "total_Balance" => $total_Balance,
                "Start_time"=>$Start_time->created_at->format('Y-m-d'),
                "End_time"=> $End_time->created_at->format('Y-m-d'),
                ]);
    
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index_sales(){
        $data=DB::select("SELECT products.image,products.name,products.price_buy,products.price_sales,sales.counter,sales.total_price,sales.created_at,
         ((products.price_buy - products.price_sales)*sales.counter) as Balance
          FROM sales INNER JOIN products on sales.product_Id=products.id WHERE products.Manger_Id=? and DATE(sales.created_at) = CURDATE() 
          Order BY sales.id DESC
         ",[Auth()->user()->id]);

         $total_Balance=0;
         for($i=0; $i< count($data);$i++){
           $total_Balance +=$data[$i]->Balance;

         }
         return view("Admin_Provider.sales.index_sales",["data"=>$data,"total_Balance"=>$total_Balance]);

        
    }
}

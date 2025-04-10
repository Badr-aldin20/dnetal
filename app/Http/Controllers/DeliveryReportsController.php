<?php

namespace App\Http\Controllers;

use App\Models\delaveries;
use App\Models\delivery_reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class DeliveryReportsController extends Controller
{
    public function Report_index_delivery(){
     
        $delivery=delaveries::where("Manger_Id",Auth()->user()->id)->get();
        $data=DB::select("
 SELECT 
    delaveries.name AS deliver_name,
    users.name AS clinic_name,
    users.Location,
    delivery_reports.bill_id,
    delivery_reports.code,
    delivery_reports.status,
    delivery_reports.created_at,
    MAX(bills.created_at) AS bill_date,
    SUM(sales.counter * products.price_buy) AS total_amount
FROM delivery_reports 
INNER JOIN users ON delivery_reports.Clinic_Id = users.id 
INNER JOIN delaveries ON delivery_reports.Delivery_Id = delaveries.id
INNER JOIN bills ON delivery_reports.bill_id = bills.id
INNER JOIN sales ON sales.Bill_Id = bills.id
INNER JOIN products ON sales.product_Id = products.id
WHERE   sales.Manger_Id = ?
GROUP BY 
    delivery_reports.bill_id,
    delivery_reports.code,
    delaveries.name,
    users.name,
    users.Location,
    delivery_reports.status,
    delivery_reports.created_at
ORDER BY delivery_reports.created_at DESC

        ",[Auth()->user()->id]);

        $dataCollection=collect($data);
        
        $Success= $dataCollection->where("status","Success")->count();
        $fail= $dataCollection->where("status","failure")->count();
        return view("Admin_Provider.Report.deleviry.Report_delvary",[
            "delivery"=>$delivery,
             "data"=>$data,
            "Success"=>$Success,
            "fail"=>$fail,
            ]);
    }

    public function search_Report_delivery(Request $request){

        $delivery=delaveries::where("Manger_Id",Auth()->user()->id)->get();
        $data=DB::select("
 SELECT 
    delaveries.name AS deliver_name,
    users.name AS clinic_name,
    users.Location,
    delivery_reports.bill_id,
    delivery_reports.code,
    delivery_reports.status,
    delivery_reports.created_at,
    MAX(bills.created_at) AS bill_date,
    SUM(sales.counter * products.price_buy) AS total_amount
FROM delivery_reports 
INNER JOIN users ON delivery_reports.Clinic_Id = users.id 
INNER JOIN delaveries ON delivery_reports.Delivery_Id = delaveries.id
INNER JOIN bills ON delivery_reports.bill_id = bills.id
INNER JOIN sales ON sales.Bill_Id = bills.id
INNER JOIN products ON sales.product_Id = products.id
WHERE   sales.Manger_Id =? AND delivery_reports.Delivery_Id=?
GROUP BY 
    delivery_reports.bill_id,
    delivery_reports.code,
    delaveries.name,
    users.name,
    users.Location,
    delivery_reports.status,
    delivery_reports.created_at
ORDER BY delivery_reports.created_at DESC
        ",[Auth()->user()->id,$request->id_delivery]);
       
       
       
        $dataCollection=collect($data);


        $Success= $dataCollection->where("status","Success")->count();
        $fail= $dataCollection->where("status","failure")->count();
        return view("Admin_Provider.Report.deleviry.Report_delvary",[
            "delivery"=>$delivery,
             "data"=>$data,
            "Success"=>$Success,
            "fail"=>$fail,
            ]);
    }
}
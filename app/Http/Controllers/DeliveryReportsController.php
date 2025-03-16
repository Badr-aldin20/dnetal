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
     
        $delivery=delaveries::where("Manager_Id",Auth()->user()->id)->get();
        $data=DB::select("
        SELECT 
        delaveries.name as deliver_name,
        users.name,
        users.Location,
        delivery_reports.status,
        delivery_reports.created_at
        FROM delivery_reports 
        INNER JOIN users ON  delivery_reports.Clinic_Id=users.id 
        INNER JOIN delaveries ON delivery_reports.Delivery_Id =delaveries.id
     
     WHERE delivery_reports.Clinic_Id=?
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

        $delivery=delaveries::where("Manager_Id",Auth()->user()->id)->get();
        $data=DB::select("
        SELECT 
        delaveries.name as deliver_name,
        users.name,
        users.Location,
        delivery_reports.status,
        delivery_reports.created_at
        FROM delivery_reports 
        INNER JOIN users ON  delivery_reports.Clinic_Id=users.id 
        INNER JOIN delaveries ON delivery_reports.Delivery_Id =delaveries.id
        WHERE delivery_reports.Clinic_Id=? AND delivery_reports.Delivery_Id=?

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
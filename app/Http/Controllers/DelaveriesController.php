<?php

namespace App\Http\Controllers;

use App\Models\Bills;
use App\Models\delaveries;
use App\Models\delivery_reports;
use App\Models\sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DelaveriesController extends Controller
{
    public function index_delivery()
    {

        $data = delaveries::where("Manger_Id", Auth()->user()->id)->get();
        return view("Admin_Provider.dalevry.index_dalevry", ["data" => $data]);
    }

    public function create_delivery()
    {

        return view("Admin_Provider.dalevry.create_delivery");
    }

    public function store_delivery(Request $request)
    {

        $request->validate([
            "name" => "required",
            "email" => "required|email|min:4",
            "password" => "required|min:8"
        ]);
        $haspassword = Hash::make($request->password);
        delaveries::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $haspassword,
            "Manger_Id" => Auth()->user()->id,
            "Status" => "offline"
        ]);
        session()->flash("success", "تم اضافه موصل بنجاح");
        return to_route("index_delivery");
    }


    public function edit_delivery($id)
    {
        $data = delaveries::where('id', $id)->first();
        return view("Admin_Provider.dalevry.edit_delivery", ["data" => $data]);
    }

    public function updata_delivery(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|min:4",
            "password" => "required|min:8"
        ]);

        $user = delaveries::where("id", $id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password
        ]);

        if ($user) {
            session()->flash("success", "تم تعديل بيانات الموصل بنجاح");
            return to_route('index_delivery');
        }
        session()->flash("erorr", "لم يتم تعديل بيانات الموصل بنجاح  ");
        return to_route('index_delivery');
    }



    public function delete_delivery($id)
    {
        delaveries::where("id", $id)->delete();
        session()->flash("success", " تم حذف الموصل بنجاح");
        return to_route("index_delivery");
    }



    public function delavery_C()
    {
        $data = DB::select("
       
    SELECT
        MAX(sales.id) AS id,
        sales.Bill_Id  As bill_sales,
        MAX(sales.created_at) AS created_at,
        SUM(sales.counter * products.price_buy) AS totalprice,
        MIN(sales.Order) AS Order_sa,
        MAX(sales.StatusOrder) AS StatusOrder,
        MAX(users.name_company) as company_clinc,
        MAX(users.Location) as Location_clinc,
        MAX(delaveries.name) AS delivaryName
    FROM sales
    INNER JOIN products ON sales.product_Id = products.id
    INNER JOIN bills ON sales.Bill_Id = bills.id
    INNER JOIN users ON bills.Clinic_Id = users.id
    LEFT JOIN delaveries ON sales.deliver_id = delaveries.id
    WHERE products.Manger_Id = ?
      AND sales.Order != 0 
      AND sales.StatusOrder = 'C'
       OR sales.Order =0
      
    GROUP BY sales.Bill_Id
    ORDER BY sales.Bill_Id DESC
 
     ", [Auth()->user()->id]);



        $deliveries = delaveries::where("status", "Online")
            ->where("Manger_Id", Auth()->user()->id)
            ->get();
        // dd($deliveries);

        return view("Admin_Provider.dalevry.delavery_C", [
            "data" => $data,
            "deliveries" => $deliveries,
        ]);
    }
    public function index_bill_delivery() {
        $data = DB::select("
  
    SELECT
        MAX(sales.id) AS id,
        sales.Bill_Id  As bill_sales,
        MAX(sales.created_at) AS created_at,
        SUM(sales.counter * products.price_buy) AS totalprice,
        MIN(sales.Order) AS Order_sa,
        MAX(sales.StatusOrder) AS StatusOrder,
        MAX(users.name_company) as company_clinc,
        MAX(users.Location) as Location_clinc,
        MAX(delaveries.name) AS delivaryName
    FROM sales
    INNER JOIN products ON sales.product_Id = products.id
    INNER JOIN bills ON sales.Bill_Id = bills.id
    INNER JOIN users ON bills.Clinic_Id = users.id
    LEFT JOIN delaveries ON sales.deliver_id = delaveries.id
    WHERE products.Manger_Id = ?
      AND sales.Order != 0 
      AND sales.StatusOrder != 'C'
    GROUP BY sales.Bill_Id
    ORDER BY sales.Bill_Id DESC

    ;
        ", [Auth()->user()->id]);
        //dd($data);
    
        $deliveries = delaveries::where("status", "Online")
            ->where("Manger_Id", Auth()->user()->id)
            ->get();
    
        return view("Admin_Provider.dalevry.index_bill_delivery", [
            "data" => $data,
            "deliveries" => $deliveries,
        ]);
    }
    

    public function index_order_delivery($id)
    {
            //AND sales.StatusOrder != 'C'

        $data = DB::select("
        SELECT
            products.name,
            products.image,
            sales.id,
            sales.counter,
            sales.Order,
            sales.StatusOrder,
            sales.created_at,
            products.price_sales,
            products.price_buy,
            sales.Bill_Id AS bill_sales,
            users.name_company as company_clinc,
            users.Location as Location_clinc,
            delaveries.name AS delivaryName,
            (
                (products.price_buy - products.price_sales) * sales.counter
            ) AS Balance
        FROM
            sales
        INNER JOIN products ON sales.product_Id = products.id
        INNER JOIN bills ON sales.Bill_Id = bills.id
        INNER JOIN users ON bills.Clinic_Id = users.id
        LEFT JOIN delaveries ON sales.deliver_id = delaveries.id
        WHERE
            products.Manger_Id = ? AND sales.Order != 0 
            AND sales.Bill_Id = ?
        ORDER BY
            sales.id DESC
    ", [Auth()->user()->id,$id]);
    // <-- هنا تمرر $id اللي جاي من الدالة
    


        $deliveries = delaveries::where("status", "Online")
            ->where("Manger_Id", Auth()->user()->id)
            ->get();
        // dd($deliveries);

        return view("Admin_Provider.dalevry.index_order_delivery", [
            "data" => $data,
            "deliveries" => $deliveries,
        ]);
    }


    public function edit_order_delivery(Request $request)
    {

        $salles = sales::where("id", $request->id_Sales)->first();
        $salles->update([
            "StatusOrder" => "B",
            "deliver_id" => $request->id_delivery,
        ]);;

        delaveries::where("id", $request->id_delivery)->update([
            "status" => "Busy"
        ]);
        // get id Clinic for Bill
        $bill = Bills::where("id", $salles->Bill_Id)->first();

        // set data in table  Delivery report
        delivery_reports::create([
            "Delivery_Id" => $request->id_delivery,
            "Clinic_Id" => $bill->Clinic_Id,
            "status" => "Underway",
            "bill_id" => $bill->id,
        ]);

        session()->flash("success", "تم التعديل بنجاح");
        return to_route("index_bill_delivery");
    }
}

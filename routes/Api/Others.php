<?php

use App\Models\delaveries;
use App\Models\delivery_reports;
use App\Models\heroes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Home Api
Route::get("/Get-Data-Home", function () {
    // $heroes = heroes::where('end_time', '>', Carbon::now())->get();
    $heroes = DB::select("SELECT
    heroes.id,
    heroes.percentage,
    heroes.Manger_Id,
    heroes.product_Id,
    heroes.status,
    heroes.end_time,
    heroes.description,
    heroes.price_new,
    products.image
FROM
    `heroes`
INNER JOIN products ON heroes.product_Id = products.id
WHERE
    end_time > NOW() ");

    $data = User::where('active', "1")
        ->where('type', "Admin Provider")
        ->distinct()->inRandomOrder()->limit(4)->get();
    return response()->json([
        "status" => "200",
        "message" => "",
        "heroes" => $heroes,
        "data" => $data,
    ]);
});

// Search
Route::get("/Search/{txt}", function ($txt) {
    $data = DB::select("
        SELECT * FROM products WHERE name LIKE ?
    ", ["%$txt%"]);
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});


//فاتورتين
// SELECT
// sales.Bill_Id,
// sales.Manger_Id,
// MAX(sales.created_at) AS created_at,
// SUM(sales.counter * products.price_buy) AS total_price
// FROM
// sales
// INNER JOIN products ON products.id = sales.product_Id
// INNER JOIN bills ON bills.id = sales.Bill_Id
// WHERE
// bills.Clinic_Id = ?
// GROUP BY
// sales.Bill_Id, sales.Manger_Id
// ORDER BY
// sales.Bill_Id DESC; 



// SELECT
    
// sales.Bill_Id ,
// MAX(sales.created_at) AS created_at,
// SUM(sales.counter * products.price_buy) AS total_price

// FROM
// sales
// INNER JOIN products ON products.id = sales.product_Id
// INNER JOIN bills ON bills.id = sales.Bill_Id
// WHERE
// bills.Clinic_Id = ?
// GROUP BY
// sales.Bill_Id 
// ORDER BY
// sales.Bill_Id DESC;  

// Get Clinic Request وجهه الطلبات
Route::get("/Get-Request-Clinic/{id}", function ($id) {
    
    $data = DB::select("
     SELECT
    
    sales.Bill_Id ,
    MAX(sales.created_at) AS created_at,
    MAX(sales.StatusOrder) AS StatusOrder,
    SUM(sales.counter * products.price_buy) AS total_price
   
FROM
    sales
INNER JOIN products ON products.id = sales.product_Id
INNER JOIN bills ON bills.id = sales.Bill_Id
WHERE
    bills.Clinic_Id = ?
GROUP BY
    sales.Bill_Id 
ORDER BY
    sales.Bill_Id DESC;  

", [$id]);


    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});

// Get data for Bill 
Route::post("/Get-data-bill", function (Request $request) {
    $data = DB::select(
        "
SELECT
    products.name,
    products.image,
    products.price_buy,
    sales.counter,
    ( sales.counter * products.price_buy) AS 'total_price'
FROM
    sales
INNER JOIN products ON products.id = sales.product_Id
INNER JOIN bills ON bills.id = sales.Bill_Id
WHERE
    bills.Clinic_Id = ?
    AND
     sales.Bill_Id = ?;",
        [$request->user_id, $request->bill_id]
    );

    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});

// Get verify code with Delivery
Route::get("/Get-Verify-Code/{id}", function ($id) {
    $data = delivery_reports::where("bill_id", $id)->get();
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});

// Change Status Code with Delivery
Route::post("/Change-Delivery-Status/{id}", function (Request $request, $id) {
    delaveries::where("id", $id)->update([
        "status" => $request->status
    ]);
    return response()->json([
        "status" => "200",
        "message" => "Success",
    ]);
});

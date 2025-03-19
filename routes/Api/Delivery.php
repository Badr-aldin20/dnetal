<?php

use App\Models\delaveries;
use App\Models\delivery_reports;
use App\Models\sales;
use App\Models\User;
use Illuminate\Http\Request;
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


// Get verify code with Deliveryتقارير الموصلين حسب ال id
Route::get("/Get-Verify-Code/{id}", function ($id) {
    $data = delivery_reports::where("bill_id", $id)->get();
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});

// Change Status Code with Delivery زر من اجل ان تجعل الموصل حالته شغاله او مشغول او مغلق
Route::post("/Change-Delivery-Status/{id}", function (Request $request, $id) {
    delaveries::where("id", $id)->update([
        "status" => $request->status
    ]);
    return response()->json([
        "status" => "200",
        "message" => "Success",
    ]);
});

// Get Order By Deliver جلب الحالات التي من نوع b
Route::get("/Get-orderby-delivery/{id}", function ($id) {
    $data = sales::where("deliver_id", $id)
    ->where("StatusOrder", "B")
    ->get();
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});

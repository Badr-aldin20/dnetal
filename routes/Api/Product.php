<?php

use App\Models\products;
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

// Get All products by Id User جلب منتجات عبر تحديد المزود
Route::get("/Get-User-product/{id}", function ($id) {
    $data = products::where('Manger_Id', $id)
    ->inRandomOrder()
    ->where("counter", ">", 0)
    ->where("status", "Active")
    ->limit(6)
    ->get();

    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});

// Get All products جلب المنتجات
Route::get("/Get-All-product", function () {
    $data = products::where("status", "Active")
    ->where("counter", ">", 0)
    ->where("status", "Active")
    ->inRandomOrder()
    ->get();
    
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});

// Get product by Id جلب العنصر بنفسه عن طريق 
Route::get("/Get-product/{id}", function ($id) {
    $data = Products::where('id', $id)->get();
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});

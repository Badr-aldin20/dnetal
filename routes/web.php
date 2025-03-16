<?php

use App\Http\Controllers\Auth_Controller;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\DelaveriesController;
use App\Http\Controllers\DeliveryReportsController;
use App\Http\Controllers\Home_Controller;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Report_Controller;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\User_Controller;
use App\Models\products;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware('guest')->group(function(){
  Route::view("/wait_Au","Auth.wait")->name("wait_Au");
  Route::view("/Register_Au","Auth.Register")->name("Register_Au");
  Route::view("/login_Au","Auth.login")->name("login_Au");

  Route::post("/registeruser",[Auth_Controller::class,'Registeruser'])->name(name:"Registeruser");
  Route::post('/logenuser',[Auth_Controller::class,'logenuser'])->name(name:'logenuser');
});

Route::middleware(['auth','ProvideAdmin'])->group(function(){

  Route::get('showprodect_provider',[ProductsController::class,'showprodect_provider'])->name(name:'showprodect_provider');


Route::get('/product',[ProductsController::class,'index'])->name(name:'index_pro');
Route::get('/product/create',[ProductsController::class,'create'])->name(name:'create_pro');
Route::post('/product/store',[ProductsController::class,'store'])->name(name:'store_pro');
Route::get('/product/edit/{product}',[ProductsController::class,'edit'])->name(name:'edit_pro');
Route::put('/product/{product}',[ProductsController::class,'updata'])->name(name:'updata_pro');
Route::delete('/product/delete/{product}',[ProductsController::class,'delete'])->name(name:'delete_pro');

Route::get('product/showdelete',[ProductsController::class,"show_delete"])->name(name:'show_delete_pro');
Route::get('product/restor/{product}',[ProductsController::class,"restor"])->name(name:'restor_pro');
Route::get('product/forcedelete/{product}',[ProductsController::class,'forcedelete'])->name(name:'forcedelete_pro');


Route::get('index_sales',[SalesController::class,'index_sales'])->name(name:'index_sales');


Route::get('index_delivery',[DelaveriesController::class,'index_delivery'])->name(name:'index_delivery');
Route::get('create_delivery',[DelaveriesController::class,'create_delivery'])->name(name:'create_delivery');
Route::post('store_delivery',[DelaveriesController::class,'store_delivery'])->name(name:'store_delivery');
Route::get('edit_delivery/edit_delivery/{edit_delivery}',[DelaveriesController::class,'edit_delivery'])->name(name:'edit_delivery');
Route::put('updata_delivery/updata_delivery/{updata_delivery}',[DelaveriesController::class,'updata_delivery'])->name(name:'updata_delivery');
Route::delete('delete_delivery/{delete_delivery}',[DelaveriesController::class,'delete_delivery'])->name(name:'delete_delivery');

Route::get('index_order_delivery',[DelaveriesController::class,'index_order_delivery'])->name(name:'index_order_delivery');

Route::get('Report_index_delivery',[DeliveryReportsController::class,'Report_index_delivery'])->name(name:'Report_index_delivery');
Route::post('search_Report_delivery',[DeliveryReportsController::class,'search_Report_delivery'])->name(name:'search_Report_delivery');

Route::get('index_Report_purchases_A',[Report_Controller::class,'index_Report_purchases_A'])->name(name:'index_Report_purchases_A');
Route::post('Report_purchases_A',[Report_Controller::class,'Report_purchases_A'])->name(name:'Report_purchases_A');
});



Route::middleware(['auth','MAdmin'])->group(function(){
  //الجرس 
  //استقبال طلبات تسجيل دخول اليوزرات
  Route::get("showuser_active",[User_Controller::class,'showuser_active'])->name(name:'showuser_active');
  Route::put("request_active_user/{id}",[User_Controller::class,'request_active_user'])->name(name:'request_active_user');
  Route::delete("request_delete_user/{id}",[User_Controller::class,'request_delete_user'])->name(name:'request_delete_user');
  //الرساله
  //استقبال طلبات المنتجات
  Route::get("showproduct_status",[ProductsController::class,'showproduct_status'])->name(name:'showproduct_status');
  Route::put("requset_product_wait_active/{id}",[ProductsController::class,'requset_product_wait_active'])->name(name:'requset_product_wait_active');
  Route::put("requset_product_wait_unactive/{id}",[ProductsController::class,'requset_product_wait_unactive'])->name(name:'requset_product_wait_unactive');
  //المزود
  //المزود وعرض المنتجات والايقاف
  Route::get("supplier",[User_Controller::class,'supplier'])->name(name:'supplier');
  Route::get("show_product_supplier/{id}",[User_Controller::class,'show_product_supplier'])->name(name:'show_product_supplier');
  Route::put("stope_supplier/{id}",[User_Controller::class,'stope_supplier'])->name(name:'stope_supplier');
  Route::post("search_supplier",[User_Controller::class,'search_supplier'])->name(name:'search_supplier');

  Route::get("clinic",[User_Controller::class,'clinic'])->name(name:'clinic');
  Route::post("search_clinic",[User_Controller::class,'search_clinic'])->name(name:'search_clinic');
  Route::put("stope_clinic/{id}",[User_Controller::class,'stope_clinic'])->name(name:'stope_clinic');

  Route::get("balance",[BalanceController::class,'index'])->name(name:"balance");


  Route::get("all_product_active",[ProductsController::class,'all_product_active'])->name(name:'all_product_active');
 
  Route::get("Reporte_product",[ProductsController::class,'Reporte_product'])->name(name:'Reporte_product');
  Route::post("Reporte_produc_Time",[ProductsController::class,'Reporte_produc_Time'])->name(name:'Reporte_produc_Time');
});

Route::middleware('auth')->group(function(){
  Route::get("/", [Home_Controller::class, "index"])->name("/");
  Route::get("/profile",[Home_Controller::class,"profile"])->name(name:"profile");
  Route::put("/profile/update/{profile}",[Home_Controller::class,"update_profile"])->name(name:"profile_up");
  Route::post("/logout",[Auth_Controller::class,"Logout"])->name(name:"Logout");
});
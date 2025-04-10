<?php

use App\Http\Controllers\ALController;
use App\Http\Controllers\Auth_Controller;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DelaveriesController;
use App\Http\Controllers\DeliveryReportsController;
use App\Http\Controllers\HeroesController;
use App\Http\Controllers\Home_Controller;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Report_Controller;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\User_Controller;
use App\Models\Balance;
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


 Route::get('index_ai', [ALController::class, 'index_ai'])->name('index_ai');
 Route::post('predict_image', [ALController::class, 'predict_image'])->name('predict_image');
 Route::get('search_ai_product', [ALController::class, 'search_ai_product'])->name('search_ai_product');
 Route::put('update_ai_cat/{id}', [ALController::class, 'update_ai_cat'])->name('update_ai_cat');
 Route::delete('delete_ai_cat/{id}', [ALController::class, 'delete_ai_cat'])->name('delete_ai_cat');

  Route::post('cart_ai_sales/{id}', [ALController::class, 'cart_ai_sales'])->name('cart_ai_sales');
  Route::post('cart_ai_sales_all', [ALController::class, 'cart_ai_sales_all'])->name('cart_ai_sales_all');
  Route::post('cart_ai_delete_all', [ALController::class, 'cart_ai_delete_all'])->name('cart_ai_delete_all');

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


Route::get("index_heroe",[HeroesController::class,"index_heroe"])->name(name:'index_heroe');
Route::get("creat_heroe",[HeroesController::class,"creat_heroe"])->name(name:'creat_heroe');
Route::post("story_heroe",[HeroesController::class,"story_heroe"])->name(name:'story_heroe');

Route::put("status_heroe_failure/{id_heroe}",[HeroesController::class,'status_heroe_failure'])->name(name:'status_heroe_failure');



Route::get('index_delivery',[DelaveriesController::class,'index_delivery'])->name(name:'index_delivery');
Route::get('create_delivery',[DelaveriesController::class,'create_delivery'])->name(name:'create_delivery');
Route::post('store_delivery',[DelaveriesController::class,'store_delivery'])->name(name:'store_delivery');
Route::get('edit_delivery/edit_delivery/{edit_delivery}',[DelaveriesController::class,'edit_delivery'])->name(name:'edit_delivery');
Route::put('updata_delivery/updata_delivery/{updata_delivery}',[DelaveriesController::class,'updata_delivery'])->name(name:'updata_delivery');
Route::delete('delete_delivery/{delete_delivery}',[DelaveriesController::class,'delete_delivery'])->name(name:'delete_delivery');



Route::get('delavery_C',[DelaveriesController::class,'delavery_C'])->name(name:'delavery_C');

//Route::get('Catgras',[DelaveriesController::class,'index_order_delivery'])->name(name:'index_order_delivery');
Route::get('index_bill_delivery',[DelaveriesController::class,'index_bill_delivery'])->name(name:'index_bill_delivery');
Route::get('index_order_delivery/{id}',[DelaveriesController::class,'index_order_delivery'])->name(name:'index_order_delivery');
Route::put('edit_order_delivery',[DelaveriesController::class,'edit_order_delivery'])->name(name:'edit_order_delivery');



Route::get('Report_index_delivery',[DeliveryReportsController::class,'Report_index_delivery'])->name(name:'Report_index_delivery');
Route::post('search_Report_delivery',[DeliveryReportsController::class,'search_Report_delivery'])->name(name:'search_Report_delivery');

Route::get('index_Report_purchases_A',[Report_Controller::class,'index_Report_purchases_A'])->name(name:'index_Report_purchases_A');
Route::post('Report_purchases_A',[Report_Controller::class,'Report_purchases_A'])->name(name:'Report_purchases_A');

Route::post('Purchases_pdf_provider',[Report_Controller::class,'Purchases_pdf_provider'])->name(name:'Purchases_pdf_provider');
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
  // العوض
  Route::get("show_hero_status",[HeroesController::class,'show_hero_status'])->name(name:'show_hero_status');
  Route::put("Active_hero_status/{id_heroe}",[HeroesController::class,'Active_hero_status'])->name(name:'Active_hero_status');
  Route::delete("delete_hero_status/{id_heroe}",[HeroesController::class,'delete_hero_status'])->name(name:'delete_hero_status');
  //المزود
  //المزود وعرض المنتجات والايقاف
  Route::get("supplier",[User_Controller::class,'supplier'])->name(name:'supplier');
  Route::get("show_product_supplier/{id}",[User_Controller::class,'show_product_supplier'])->name(name:'show_product_supplier');
  Route::put("stope_supplier/{id}",[User_Controller::class,'stope_supplier'])->name(name:'stope_supplier');
  Route::post("search_supplier",[User_Controller::class,'search_supplier'])->name(name:'search_supplier');
  
  Route::put('Password_Recovery/{id}', [User_Controller::class, 'Password_Recovery'])
  ->name('Password_Recovery');
  
  Route::get("clinic",[User_Controller::class,'clinic'])->name(name:'clinic');
  Route::post("search_clinic",[User_Controller::class,'search_clinic'])->name(name:'search_clinic');
  Route::put("stope_clinic/{id}",[User_Controller::class,'stope_clinic'])->name(name:'stope_clinic');

  Route::get("balance",[BalanceController::class,'index'])->name(name:"balance");
  Route::get("create_balance",[BalanceController::class,'create_balance'])->name(name:'create_balance');
  Route::post("store_balance",[BalanceController::class,'store_balance'])->name(name:'store_balance');
  Route::get("edit_balance/{id}",[BalanceController::class,'edit_balance'])->name(name:'edit_balance');
  Route::put("update_balance/{id}",[BalanceController::class,'update_balance'])->name(name:'update_balance');
  Route::post("search_balance",[BalanceController::class,'search_balance'])->name(name:'search_balance');

  Route::get("balanc_clint",[BalanceController::class,'balanc_clint'])->name(name:"balanc_clint");
  Route::post("search_balanc_clint",[BalanceController::class,'search_balanc_clint'])->name(name:'search_balanc_clint');
  Route::put("Asess_balanc_clint/{id}",[BalanceController::class,'Asess_balanc_clint'])->name(name:'Asess_balanc_clint');
  Route::put("cincal_balanc_clint/{id}",[BalanceController::class,'cincal_balanc_clint'])->name(name:'cincal_balanc_clint');



  Route::get("index_categories",[CategoriesController::class,'index_categories'])->name(name:'index_categories');
  Route::get("create_categories",[CategoriesController::class,'create_categories'])->name(name:'create_categories');
  Route::post("store_categories",[CategoriesController::class,'store_categories'])->name(name:'store_categories');
  Route::get("edit_categories/{id}",[CategoriesController::class,'edit_categories'])->name(name:'edit_categories');
  Route::put("updata_categories/{id}",[CategoriesController::class,'updata_categories'])->name(name:'updata_categories');
  Route::delete("del_categories/{id}",[CategoriesController::class,'del_categories'])->name(name:'del_categories');



  Route::get("all_product_active",[ProductsController::class,'all_product_active'])->name(name:'all_product_active');
 
  Route::get("Reporte_product",[ProductsController::class,'Reporte_product'])->name(name:'Reporte_product');
  Route::post("Reporte_produc_Time",[ProductsController::class,'Reporte_produc_Time'])->name(name:'Reporte_produc_Time');


  Route::get("process_all",[Report_Controller::class,'process'])->name(name:'process');
  //index
  Route::get("process_search",[Report_Controller::class,'process_search'])->name(name:'process_search');
  Route::post("process_search_report",[Report_Controller::class,'process_search_report'])->name(name:'process_search_report');
});

Route::middleware('auth')->group(function(){
  Route::get("/", [Home_Controller::class, "index"])->name("/");
  Route::get("/profile",[Home_Controller::class,"profile"])->name(name:"profile");
  Route::put("/profile/update/{profile}",[Home_Controller::class,"update_profile"])->name(name:"profile_up");
  Route::get("edit_password",[Home_Controller::class,"edit_password"])->name(name:'edit_password');
  Route::put("update_password",[Home_Controller::class,'update_password'])->name(name:'update_password');
  Route::post("/logout",[Auth_Controller::class,"Logout"])->name(name:"Logout");
});
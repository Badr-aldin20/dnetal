<?php

use App\Models\Balance;
use App\Models\categories;
use App\Models\products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
#داله موجوده في السله مسبقا اضفت عليه شرط ان يتحقق من كلمه السر
# لو تقدر تعمل من تحقق عند عمليه الشر عبر كلمه السر
# هذا الاشرط الذي اضفته في الداله
#      
    #   if($request->password==$user->password){
#         return response()->json([
#             "status" => "404",
#             "message" => "كلمة المرور غير صحيحة",
#         ]);
#     }



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

//  داله جلب البيانات الاصناف
Route::get("/Get-categories", function () {
    $data = categories::all();
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});


// داله جلب المنتجات عن طريق الاصناف

Route::get("/Get-categories-prodect/{id}", function ($id) {
    $data = products::where("catagories_Id", $id)->get();
    //dd($data);
    if ($data->isEmpty()) {
        return response()->json([
            "status" => "400",
            "message" => "لا يوجد منتجات من هذا الصنف",
        ]);
    }
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});
// للبحث عن وكيل محدد
Route::get("/Search_Manger/{txt}", function ($txt) {
    $data = DB::select("
        SELECT * FROM users WHERE name LIKE ?
    ", ["%$txt%"]);
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});

//لاضافه رصيد واجهه تزويد حسابي


Route::post("/balance/{id}", function (Request $request, $id) {

    $user = User::where("id", $id)->first();

    if (!$user) {
        return response()->json([
            "status" => "400",
            "message" => "هذا المحساب غير موجود",
        ]);
    }

    // Create the user in the database
    $newUser = Balance::create([
        'clinic_id'=> $user->id,
        'status' => "Underway",
        'totel_balance' => $request->totel_balance,
        'description' => $request->description,
    ]);



    return response()->json([
        "status" => "200",
        "message" => "تم رفع الطلب بنجاح",
        "data" => $newUser
    ]);
});

Route::get("/Get-process-delaviery/{id}", function ($id) {
    $data= DB::select("
 
        SELECT
            MAX(sales.id) AS id_n,
            sales.Bill_Id AS bill_sales,
            MAX(sales.created_at) AS created_at,
            SUM(sales.counter * products.price_buy) AS totalprice,
            MIN(sales.Order) AS Order_sa,
            MAX(sales.StatusOrder) AS StatusOrder,
            MAX(users.name_company) AS company_clinc,
            MAX(users.Location) AS Location_clinc,
            MAX(delaveries.name) AS delivaryName

        FROM sales
        INNER JOIN products ON sales.product_Id = products.id
        INNER JOIN bills ON sales.Bill_Id = bills.id
        INNER JOIN users ON bills.Clinic_Id = users.id
        LEFT JOIN delaveries ON sales.deliver_id = delaveries.id
        INNER JOIN delivery_reports ON sales.Bill_Id = delivery_reports.bill_id

        WHERE 
           
             sales.Order != 0 
            AND sales.StatusOrder != 'C'
            AND delivery_reports.Delivery_Id = ?

        GROUP BY sales.Bill_Id
        ORDER BY sales.Bill_Id DESC



    ",[$id]);
    //dd($data);
    if (!$data) {
        return response()->json([
            "status" => "400",
            "message" => "لا يوجد منتجات من هذا الصنف",
        ]);
    }
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});

Route::get("/Get-process-delaviery-progect/{id}", function ($id) {
    $data= DB::select("
 
      SELECT
    products.name AS product_name,
    products.image,
    products.price_buy,
    products.price_sales,
    sales.counter,
    users.name_company AS clinic_name,
    providers.name AS provider_name

FROM sales
INNER JOIN products ON sales.product_Id = products.id
INNER JOIN bills ON sales.Bill_Id = bills.id
INNER JOIN users ON bills.Clinic_Id = users.id
INNER JOIN users AS providers ON products.Manger_Id = providers.id

WHERE sales.Bill_Id = ? 


    ",[$id]);
    //dd($data);
    if (!$data) {
        return response()->json([
            "status" => "400",
            "message" => "لا يوجد منتجات من هذا الصنف",
        ]);
    }
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
    ]);
});
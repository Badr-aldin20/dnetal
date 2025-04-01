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


Route::post("/balance/{id}", function (Request $request,$id) {

    // // Validation
    // $validator = Validator::make($request->all(), [
    //     "email" => "required|email|min:4email",
    //     "password" => "required|min:8",
    //     "clinic" => "required|string|min:4|max:35",
    //     "name" => "required|string",
    //     "phone" => "required",
    //     "Location" => "required",
    // ], [
    //     "email.required" => "يرجى إدخال البريد الإلكتروني.",
    //     "email.email" => "يجب أن يكون البريد الإلكتروني صالحًا.",
    //     "email.min" => "يجب أن يحتوي البريد الإلكتروني على 4 أحرف على الأقل.",
    //     "password.required" => "يرجى إدخال كلمة المرور.",
    //     "password.string" => "يجب أن تكون كلمة المرور نصية.",
    //     "password.min" => "يجب أن تكون كلمة المرور على الأقل 4 أحرف.",
    //     "clinic.required" => "يرجى إدخال اسم العيادة.",
    //     "clinic.string" => "يجب أن يكون اسم العيادة نصًا.",
    //     "clinic.min" => "يجب أن يكون اسم العيادة على الأقل 4 أحرف.",
    //     "clinic.max" => "يجب ألا يزيد اسم العيادة عن 15 حرفًا.",
    //     "name.required" => "يرجى إدخال الاسم.",
    //     "name.string" => "يجب أن يكون الاسم نصيًا.",
    //     "phone.required" => "يرجى إدخال رقم الهاتف.",
    //     "phone.string" => "يجب أن يكون رقم الهاتف نصيًا.",
    //     "Location.required" => "يرجى إدخال العنوان.",
    //     "Location.string" => "يجب أن يكون العنوان نصيًا.",
    // ]);

    // // // Check if validation fails
    // if ($validator->fails()) {
    //     return response()->json([
    //         "status" => "400",
    //         "message" => "هناك أخطاء في المدخلات",
    //         "errors" => $validator->errors()
    //     ], );
    // }


    // Check Email is Already existing
    $user = User::where("id", $id)->first();

    if ($user) {
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
        "message" => "تم التسجيل بنجاح",
        "data" => $newUser
    ]);
});

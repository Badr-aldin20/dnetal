<?php

use App\Models\Bills;
use App\Models\carts;
use App\Models\products;
use App\Models\sales;
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

// Get All Data in Cart
Route::get("/Cart/{id}", function ($id) { 


    $user = User::where('id', $id)->first();

    if (!$user) {
        return response()->json([
            "status" => "404",
            "message" => "This User not Found!",
        ]);
    }

    $data = DB::select("
        SELECT
            products.id as 'products_id',
            products.name,
            products.modeType,
            products.image,
            products.price_buy,
            products.counter,
            carts.quantity,
            carts.product_Id  as 'id'
        FROM
            carts
        INNER JOIN users ON carts.user_Id  = users.id
        INNER JOIN products ON carts.product_Id  = products.id
        WHERE
            users.id = $id");



    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $data,
        "balance" => $user->stock
    ]);
});

// Add to cart
Route::post("/Add-To-Card", function (Request $request) {

    // check user 
    $user = User::where("id", $request->idUser)->first();

    if (!$user) {
        return response()->json([
            "status" => "404",
            "message" => "هذا المستخدم غير موجود",
        ]);
    }

    // check product 
    $product = Products::where('id', $request->product_id)
        ->where('counter', '>', 0)
        ->first();

    if (!$product) {
        return response()->json([
            "status" => "404",
            "message" => "هذا العنصر غير موجود.",
        ]);
    }

    // Check In The Cart 
    $cartItem = Carts::where('user_id', $user->id)
        ->where('product_id', $product->id)
        ->first();

    // Check Count
    if ($cartItem) {

        // increment
        if ($request->target == "increment") {
            if ($cartItem->quantity < $product->counter) {
                $cartItem->quantity += 1;
                $cartItem->save();

                return response()->json([
                    "status" => "200",
                    "message" => "تم تحديث الكمية بنجاح.",
                ]);
            }
            return response()->json([
                "status" => "200",
                "message" => "عذرًا، لا يمكن إضافة المزيد. لقد وصلت إلى الحد الأقصى للكمية المتاحة.",
            ]);
        }
        // Decrement
        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();

            return response()->json([
                "status" => "200",
                "message" => "تم تحديث الكمية بنجاح.",
            ]);
        }
        return response()->json([
            "status" => "200",
            "message" => "عذرًا، لا يمكن تقليل الكمية أكثر. لقد وصلت إلى الحد الأدنى للكمية المتاحة.",
        ]);
    }

    Carts::create([
        'user_Id' => $user->id,
        'product_Id' => $product->id
    ]);
    return response()->json([
        "status" => "200",
        "message" => "تم إضافة المنتج إلى السلة بنجاح.",
    ]);
});

// Remove from Cart
Route::post("/Cart/{id}", function ($id, Request $request) {

    // check user 
    $user = User::where("id", $request->idUser)->first();

    if (!$user) {
        return response()->json([
            "status" => "404",
            "message" => "هذا المستخدم غير موجود",
        ]);
    }

    // check product 
    $cartItem = Carts::where('user_id', $user->id)
        ->where('product_id', $id)
        ->first();

    if (!$cartItem) {
        return response()->json([
            "status" => "404",
            "message" => "هذا العنصر غير موجود في السلة.",
        ]);
    }
    // remove product
    $cartItem->delete();

    return response()->json([
        "status" => "200",
        "message" => "تم حذف العنصر من السلة بنجاح.",
    ]);
});

// Check Out Cart
Route::post("/Check-Out", function (Request $request) {
    $user = User::where('id', $request->user_id)->first();

    if (!$user) {
        return response()->json([
            "status" => "404",
            "message" => "This User not Found!",
        ]);
    }

    

    $data = DB::select("
    SELECT
        products.id as 'products_id',
        products.Manger_Id,
        products.price_buy,
        carts.quantity
    FROM
        carts
    INNER JOIN users ON carts.user_Id  = users.id
    INNER JOIN products ON carts.product_Id  = products.id
    WHERE
        users.id = ?", [$request->user_id]);


    $masterAdmin = User::where("type", "Master Admin")->first();

    $bill = Bills::create([
        "Clinic_Id" => $request->user_id,
    ]);

    for ($i = 0; $i < count($data); $i++) {
        // get Product
        $product = products::where("id", $data[$i]->products_id)->first();
        // get Manger Product
        $supple = User::where("id", $product->Manger_Id)->first();

        // Decrement product 
        $product->update(["counter" => ($product->counter - $data[$i]->quantity)]);

        // Get total price * quantity and mines 10%
        $totalPrice = ($data[$i]->price_buy * $data[$i]->quantity) * 0.9;

        // add total price in Stock Manger Provider 
        $supple->update(["stock" => ($supple->stock + $totalPrice)]);

        // add 10% to Master Admin
        $masterAdmin->update(["stock" => ($masterAdmin->stock + ($totalPrice * 0.1))]);

        // Add to Table sells
        sales::create([
            "product_Id" => $product->id,
            "Manger_Id" => $product->Manger_Id,
            "counter" => $data[$i]->quantity,
            "total_price" => $totalPrice,
            "Bill_Id" => $bill->id,
            "Order" => $request->isOrder,
            "StatusOrder" => "A",
        ]);
    }


    // Decrement Stock Clinic User
    $user->update(["stock" => ($user->stock - $request->total_Price)]);

    // clear Cart 
    carts::where("user_Id", "=", $request->user_id)->delete();

    return response()->json([
        "status" => "200",
        "message" => "Success",
    ]);
});
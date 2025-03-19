<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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






// Get Data Profile جلب المستخدمين بواسطه id
Route::get("/Data-profile/{id}", function ($id) {
    $user = User::where('id', $id)->first();
    return response()->json([
        "status" => "200",
        "message" => "Success",
        "data" => $user
    ]);
});

// Update Data Profile name and phone
Route::put("/Data-profile/{id}", function (Request $request, $id) {

    // Validation
    $validator = Validator::make($request->all(), [
        "name" => "required|string",
        "phone" => "required",
    ], [
        "name.string" => "يجب أن يكون الاسم نصيًا.",
        "phone.required" => "يرجى إدخال رقم الهاتف.",
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            "status" => "400",
            "errors" => $validator->errors()
        ], 400);
    }

    $user = User::where('id', $id)->first();

    if (!$user) {
        return response()->json([
            "status" => "404",
            "message" => "This User not Found!",
        ]);
    }

    $user->update([
        "name" => $request->name,
        "phone" => $request->phone
    ]);

    return response()->json([
        "status" => "200",
        "message" => "User profile updated successfully.",
        "data" => $user
    ]);
});

// Update Data Profile password
Route::put("/Data-profile-password/{id}", function (Request $request, $id) {

    $user = User::where('id', $id)->first();

    if (!$user) {
        return response()->json([
            "status" => "404",
            "message" => "This User not Found!",
        ]);
    }
    $checkPassword = Hash::check($request->oldPassword, $user->password);
    if (!$checkPassword) {
        return response()->json([
            "status" => "400",
            "message" => "كلمه السر القديمه ليست متطابقه",
        ]);
    }
    if ($request->newPassword != $request->confirmPassword) {
        return response()->json([
            "status" => "400",
            "message" => "كلمه السر الجديده ليست متطابقه",
        ]);
    }
    $newPassword = Hash::make($request->confirmPassword);

    $user->update([
        "password" => $newPassword
    ]);

    return response()->json([
        "status" => "200",
        "message" => "تمت عمليه التعديل بنجاح",
        "data" => $user
    ]);
});

// Update Image Profile
Route::post("/Data-profile-Image/{id}", function (Request $request, $id) {
    $user = User::where('id', $id)->first();

    if (!$user) {
        return response()->json([
            "status" => "404",
            "message" => "This User not Found!",
        ]);
    }


    $img_path = $request->file('image')->store('', 'Images');

    $full_image_path = url('ImagesProfile/' . $img_path);
    $user->update([
        "image" => $full_image_path,
    ]);

    return response()->json([
        "status" => "200",
        "message" => "تمت عمليه التعديل بنجاح",
        "data" => $user
    ]);
});

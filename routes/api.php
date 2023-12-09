<?php

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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


//Products routes
//Route::apiResource("products",ProductController::class);
Route::get("products",[ProductController::class,"index"]);
Route::get("products/{id}",[ProductController::class,"show"]);
Route::get("products",[ProductController::class,"Search"]);
Route::get("Categoryproduct/{id}",[ProductController::class,"getCategoryByProducts"]);
Route::get("trashedProducts",[ProductController::class,"getTrashedProducts"]);


//Category routes
Route::get("category",[CategoryController::class,"index"]);
Route::get("category/{id}",[CategoryController::class,"show"]);
Route::get("category",[CategoryController::class,"Search"]);
Route::get("Productcategory/{id}",[CategoryController::class,"getProductsByCategory"]);
Route::get("trashedCategories",[CategoryController::class,"getTrashedCategories"]);


Route::middleware('auth:sanctum')->group(function(){
    //Protected Products routes
    Route::post("products",[ProductController::class,"store"]);
    Route::put("products/{id}",[ProductController::class,"update"]);
    Route::delete("products/{id}",[ProductController::class,"destroy"]);
    Route::put("restoreproduct/{id}",[ProductController::class,"restore"]);

    //Protected Category routes
    Route::post("category",[CategoryController::class,"store"]);
    Route::put("category/{id}",[CategoryController::class,"update"]);
    Route::delete("category/{id}",[CategoryController::class,"destroy"]);
    Route::put("restorecategory/{id}",[CategoryController::class,"restore"]);
});


// AUTH Routes
Route::post("register",[AuthController::class,"register"]);
Route::post("login",[AuthController::class,"login"]);
Route::post('logout', [AuthController::class, 'logout']);


<?php


use App\Http\Controllers\Api\PostQueryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ShowroomController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;



use App\Models\Category;
use App\Models\Post;
use App\Models\Review;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Showroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Posts Routes
Route::get('posts', [PostQueryController::class, 'index']);
Route::get('posts/{id}', [PostQueryController::class, 'getPostById']);
Route::post('posts', [PostQueryController::class, 'store']);
Route::put('posts/{id}', [PostQueryController::class, 'update']);
Route::delete('posts/{id}', [PostQueryController::class, 'destroy']);
Route::post('posts/{id}/restore', [PostQueryController::class, 'restore']);



// Category Routes
Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::put('categories/{id}', [CategoryController::class, 'update']);
Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
Route::post('categories/{id}/restore', [CategoryController::class, 'restore']);

// Product Routes
Route::get('products', [ProductController::class, 'index']);
Route::get('productsbycategory/{id_category}', [ProductController::class, 'getProductsByCategory']);
Route::post('products', [ProductController::class, 'store']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);

Route::delete('products/{id}', [ProductController::class, 'destroy']);
Route::post('products/{id}/restore', [ProductController::class, 'restore']);


//showrooms
Route::get('showrooms', [ShowroomController::class, 'index']);
Route::post('showrooms', [ShowroomController::class, 'store']);
Route::get('showrooms/{id}', [ShowroomController::class, 'show']);
//update showroom is work done
Route::put('showrooms/{id}', [ShowroomController::class, 'update']);
Route::delete('showrooms/{id}', [ShowroomController::class, 'destroy']);
Route::post('showrooms/{id}/restore', [ShowroomController::class, 'restore']);

//reviews
Route::get('reviews', [ReviewController::class, 'index']);
Route::post('reviews', [ReviewController::class, 'store']);
//update reviews is work done 
Route::put('reviews/{id}', [ReviewController::class, 'update']);
Route::get('reviews/{product_id}', [ReviewController::class, 'show']);

//Auth
Route::get('users', [AuthController::class, 'getallUsers']);
Route::get('users/{id}', [AuthController::class, 'getUserById']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);
Route::delete('users/{id}', [AuthController::class, 'destroyUser']);
//update user is work done
Route::put('users/{id}', [AuthController::class, 'update']);


//orders
Route::get('orders', [OrderController::class, 'index']);
Route::post('orders', [OrderController::class, 'store']);
Route::get('orders/{id}', [OrderController::class, 'show']);
//update order is work done
Route::put('orders/{id}', [OrderController::class, 'update']);
Route::delete('orders/{id}', [OrderController::class, 'destroy']);
Route::get('orders/totalsale', [OrderController::class, 'sumTotalsale']);

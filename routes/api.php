<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
/*
|------------------------------------------iii--------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
const Auth = AuthController::class;
const Product = ProductController::class;
// Public routes
Route::post('/register', [Auth, 'register']);
Route::post('/login', [Auth, 'login']);
Route::get('/products', [Product, 'index']);
Route::get('/products/{id}', [Product, 'show']);
Route::get('/products/search/{name}', [Product, 'search']);
// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products', [Product, 'store']);
    Route::put('/products/{id}', [Product, 'update']);
    Route::delete('/products', [Product, 'destroy']);
    Route::post('/logout', [Auth, 'logout']);
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
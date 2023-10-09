<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* use App\Http\Controllers\Cart\CartController; */
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryProductController;
/* use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\OrderItems\OrderItemsController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductImagesController;
use App\Http\Controllers\Product\ProductVariationController;
use App\Http\Controllers\ProductFeatures\ProductFeaturesController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UserOrders\UserOrdersController;
use App\Http\Controllers\Variation\VariationController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReportingController; */
use App\Http\Controllers\UbigeoController;



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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

 /* Route::post('/login', 'AuthController@login');
Route::post('users/register', 'AuthController@register');
Route::get('/users/{email}/check', 'User\UserController@checkByEmail'); */

/*'RECUPERAR CONTRASEÑA' */
/* Route::post('/users/{email}/addRecoveryToken', 'User\UserController@addRecoveryToken');
Route::post('/users/{email}/{token}/checkByRecoveryTokenAndEmail', 'User\UserController@checkByRecoveryTokenAndEmail');
Route::post('/users/updatePassword', 'User\UserController@updatePassword'); */


/*CATEGORY*/


/* Route::resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]); */


/*  Route::resource('categories', 'Category\CategoryController', ['only' => ['index', 'show', 'update']]);*/


Route::get('/categories/parent/{parent}', [CategoryController::class, 'getCategoriesByParent']); //http://127.0.0.1:8000/api/categories/parent/1

/*PRODUCT*/
/* Route::resource('products', 'Product\ProductController', ['only' => ['show']]);
Route::get('/products/random/{qty}', 'Product\ProductController@getRandomProducts'); */
/*PRODUCT FEATURES*/
/* Route::resource('variations.features', 'ProductFeatures\ProductFeaturesController', ['only' => ['index', 'show']]); */


/*SHOPPING CART*/

/* Route::post('/cart/validate', 'Cart\CartController@validateCart'); */


/*UBIGEO*/

Route::get('/departments', [UbigeoController::class, 'getDepartment']);
Route::get('/departments/{departmentId}/provinces', [UbigeoController::class, 'getProvinces']); //http://127.0.0.1:8000/api/departments/01/provinces
Route::get('/provinces/{provinceId}/districts', [UbigeoController::class, 'getDistricts']); //http://127.0.0.1:8000/api/provinces/0101/districts

/*ORDER*/

/* Route::group(['middleware' => 'jwt.verify'], function () {

    Route::put('/updateDistrictCost/{districtId}', 'UbigeoController@updateDistrictCost');
   
    Route::resource('users.orders', 'User\UserOrdersController', ['only' => ['index']]);


    Route::post('/order/demo', 'Order\OrderController@demo');

    
    Route::post('/order', 'Order\OrderController@createOrder');


});
Route::get('/order/{trackingId}', 'Order\OrderController@getOrder');

Route::get('/search/{param}', 'Product\ProductController@searchProduct');

Route::get('/reportingService/bestSelledCategories', 'ReportingController@bestSelledCategories');
Route::get('/reportingService/bestSelledProductsLimit10', 'ReportingController@bestSelledProductsLimit10'); */


/*CONTACT FORM*/
/* Route::post('/contact123', 'ContactController@sendContactForm'); */

// obtener info del usuario logeado
/* Route::get('orderItems/getOrderItemsByOrderId/{orderId}', 'OrderItems\OrderItemsController@getOrderItemsByOrderId'); */

/* Route::group(['middleware' => 'jwt.verifyAdmin'], function () {


    Route::get('/provinces/{provinceId}/allDistricts', 'UbigeoController@getAllDistricts');

    Route::put('/orders/changeOrderStatus', 'Order\OrderController@changeOrderStatus');
    Route::get('/orders/getPendingOrders', 'Order\OrderController@getPendingOrders');
    Route::get('reporting/sumStats', 'ReportingController@sumStats');
    Route::get('reporting/bestSalesAmoutClient', 'ReportingController@bestSalesAmoutClient');
    Route::get('reporting/totalOrdersByMonth', 'ReportingController@totalOrdersByMonth');


    Route::resource('products', 'Product\ProductController', ['only' => ['index', 'destroy', 'store', 'update']]);

    Route::resource('products.images', 'Product\ProductImagesController', ['only' => ['index', 'store']]);
    Route::resource('products.variations', 'Product\ProductVariationController', ['only' => ['index']]);
    Route::resource('variations', 'Variation\VariationController', ['only' => ['store', 'destroy', 'update']]);

    Route::resource('orders', 'Order\OrderController', ['only' => ['index', 'show']]);
    Route::resource('categories', 'Category\CategoryController', ['only' => ['destroy', 'store']]);
    Route::resource('users', 'User\UserController', ['only' => ['index', 'show']]);


    Route::resource('stores', 'Store\StoreController', ['only' => ['show', 'update']]);

    
    Route::delete('productsImages/{id}', 'Product\ProductImagesController@deleteProductImage');


}); */


//*clear cache*/
/* Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:cache');

    return 'Cache deleted';
}); */
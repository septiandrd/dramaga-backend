<?php

use Illuminate\Http\Request;

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
//Route::middleware('jwt.auth')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('api.auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user/getUsersByRole', 'APIUserController@getUserByRole');
Route::get('user/getUsersByGender', 'APIUserController@getUserByGender');
Route::post('user/register', 'APIRegisterController@register');
Route::post('user/login', 'APILoginController@login');

Route::get('product/getAllProducts', 'APIProductController@getAllProducts');
Route::get('product/getSuggestedProducts', 'APIProductController@getSuggestedProducts');
Route::get('product/getProductsByStore', 'APIProductController@getProductsByStore');
Route::get('product/getProductDetails', 'APIProductController@getProductDetails');
Route::get('product/img', 'APIProductController@getImage');
Route::get('product/getProductsByTransactionCount', 'APIProductController@getProductsByTransactionCount');
Route::post('product/saveProduct', 'APIProductController@saveProduct');
Route::post('product/deleteProduct', 'APIProductController@deleteProduct');

Route::get('transaction/getTransactionsById','APITransactionController@getTransactionsById');
Route::get('transaction/getTransactionsByProduct','APITransactionController@getTransactionsByProduct');
Route::get('transaction/getTransactionsByUser','APITransactionController@getTransactionsByUser');
Route::post('transaction/order','APITransactionController@order');
Route::post('transaction/pay','APITransactionController@pay');
Route::post('transaction/cancel','APITransactionController@cancel');
Route::post('transaction/send','APITransactionController@send');
Route::post('transaction/arrive','APITransactionController@arrive');
Route::post('transaction/confirm','APITransactionController@confirm');

Route::get('store/getAllStores', 'APIStoreController@getAllStores');
Route::get('store/getStoresByLevel', 'APIStoreController@getStoresByLevel');
Route::get('store/getStoresByUser', 'APIStoreController@getStoresByUser');
Route::post('store/saveStore', 'APIStoreController@saveStore');
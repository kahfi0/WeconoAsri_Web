<?php

use App\Http\Controllers\Api\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//      return $request->user();
// });

Route::post('login','Api\UserController@login');
Route::post('register','Api\UserController@register');
Route::get('produk','Api\ProdukController@index');
Route::post('checkout','Api\TransaksiController@store');
Route::get('checkout/user/{id}','Api\TransaksiController@history');

Route::post('checkout/upload/{id}','Api\TransaksiController@upload');

Route::post('push','Api\TransaksiController@pushNotif');

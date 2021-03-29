<?php

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
Route::post("login", "AuthController@login");

Route::group(["middleware" => "jwt.verify"], function () {
    Route::post("register", "AuthController@register");
    Route::get('get_user', 'AuthController@getuser');
    Route::get("logout", "AuthController@logout");
    Route::resource("reference_storage", "ReferenceStorageController");
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

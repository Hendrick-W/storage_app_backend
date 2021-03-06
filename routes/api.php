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
    Route::get('get_all_user', 'AuthController@getalluser');
    Route::get("logout", "AuthController@logout");
    Route::apiResource("reference_storage", "ReferenceStorageController");
    Route::apiResource("reception", "ReceptionController");
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'API\AuthController@login')->name('login');
Route::post('/register', 'API\AuthController@register');
Route::get('/hello', 'SensorsController@hello');
Route::post('/hello2', 'SensorsController@hello2');
Route::get('/getThreshold/{mac}', 'SensorsController@getThreshold');
Route::get('getThresholdById/{id}', 'SensorsController@getThresholdById');
Route::post('setThreshold', 'SensorsController@setThreshold');
Route::post('setData', 'SensorsController@setData');
Route::get('getDataSensors', 'SensorsController@getDataSensors');
Route::get('getUsers', 'SensorsController@getUsers');


Route::middleware('auth:api')->group(function () {
    Route::get('/get-user', 'API\AuthController@getUser');
});

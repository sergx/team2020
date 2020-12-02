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
Route::prefix('fastedit')->group(function() {
  $prefix = 'api.fastedit';
  $controllerName = 'ModxResourceController';
  //http://loc-team2020.test/api/fastedit/get-material-tree/
  Route::post(    '/get-material-tree',           $controllerName.'@getMaterialTree')   ->name($prefix.'.getMaterialTree');
  Route::post(    '/get-city-list',               $controllerName.'@getCityList')       ->name($prefix.'.getCityList');
  Route::post(    '/update-field',                $controllerName.'@updateField')       ->name($prefix.'.updateField');
  Route::post(    '/user-permission-get',         $controllerName.'@userPermissionGet')          ->name($prefix.'.userPermissionGet');
  Route::post(    '/user-permission-update',      $controllerName.'@userPermissionUpdate')       ->name($prefix.'.userPermissionUpdate');



  //Route::get(     '/',                    $controllerName.'@index')      ->name($prefix.'.index');
  //Route::get(     '/create',              $controllerName.'@create')     ->name($prefix.'.create');
  //Route::post(    '/',                    $controllerName.'@store')      ->name($prefix.'.store');
  //Route::post(    '/{id}',                $controllerName.'@show')       ->name($prefix.'.show');
  //Route::get(     '/{id}/edit',           $controllerName.'@edit')       ->name($prefix.'.edit');
  //Route::put(     '/{id}',                $controllerName.'@update')     ->name($prefix.'.update');
  //Route::delete(  '/{id}',                $controllerName.'@destroy')    ->name($prefix.'.destroy');
  //Route::get(     '/{id}/orders',         $controllerName.'@getOrders')  ->name($prefix.'.orders');
});

/*
Route::middleware('auth:api')->get('/modxresource', function (Request $request) {
  return $request->user();
});
*/

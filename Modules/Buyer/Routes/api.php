<?php

use Illuminate\Http\Request;

use Modules\Buyer\Transformers\APIBuyer;

use Modules\Buyer\Entities\Buyer;

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
/*
Route::prefix('buyer')->group(function() {
  $prefix = 'api.buyer';
  $controllerName = 'BuyerController';

  Route::get(     '/',                    $controllerName.'@index')      ->name($prefix.'.index');
  Route::get(     '/create',              $controllerName.'@create')     ->name($prefix.'.create');
  Route::post(    '/',                    $controllerName.'@store')      ->name($prefix.'.store');
  Route::get(     '/{id}',                $controllerName.'@show')       ->name($prefix.'.show');
  Route::get(     '/{id}/edit',           $controllerName.'@edit')       ->name($prefix.'.edit');
  Route::put(     '/{id}',                $controllerName.'@update')     ->name($prefix.'.update');
  Route::delete(  '/{id}',                $controllerName.'@destroy')    ->name($prefix.'.destroy');
  //Route::get(     '/{id}/orders',         $controllerName.'@getOrders')  ->name($prefix.'.orders');
});
*/

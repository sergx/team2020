<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::prefix('buyer')->group(function() {
  Route::get('/', 'BuyerController@index');
});
*/

Route::prefix('buyer')->group(function() {
  $prefix = 'buyer';
  $controllerName = 'BuyerController';
  
  Route::get(     '/pre-deleted',         $controllerName.'@preDeletedList') ->name($prefix.'.pre-deleted-list')
    ->middleware(['permission:delete any '.$prefix]); // должен быть выше, чем '/{id}'
  Route::put(     '/{id}/pre-delete',     $controllerName.'@preDelete')      ->name($prefix.'.pre-delete')
    ->middleware(['permission:pre_delete any '.$prefix]);
  Route::get(     '/{id}/keep-alive',     $controllerName.'@keepAlive')      ->name($prefix.'.keep-alive')
    ->middleware(['permission:delete any '.$prefix]);

  Route::get(     '/',                    $controllerName.'@index')          ->name($prefix.'.index');
  Route::get(     '/search',              $controllerName.'@search')         ->name($prefix.'.search');
  Route::get(     '/create',              $controllerName.'@create')         ->name($prefix.'.create');
  Route::post(    '/',                    $controllerName.'@store')          ->name($prefix.'.store');
  Route::get(     '/{id}',                $controllerName.'@show')           ->name($prefix.'.show');
  Route::get(     '/{id}/edit',           $controllerName.'@edit')           ->name($prefix.'.edit')
    ->middleware(['permission:edit any '.$prefix]);
  Route::put(     '/{id}',                $controllerName.'@update')         ->name($prefix.'.update')
    ->middleware(['permission:edit any '.$prefix]);
  Route::delete(  '/{id}',                $controllerName.'@destroy')        ->name($prefix.'.destroy')
    ->middleware(['permission:delete any '.$prefix]);
  
  //Route::get(     '/{id}/orders',         $controllerName.'@getOrders')  ->name($prefix.'.orders');
});

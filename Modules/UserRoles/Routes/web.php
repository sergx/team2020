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
//https://spatie.be/docs/laravel-permission/v3/basic-usage/middleware
Route::prefix('userroles')->/*middleware('role:admin')->*/group(function() {
  $prefix = 'userroles';
  $controllerName = 'UserRolesController';

  Route::get(   '/',          $controllerName.'@index')   ->name($prefix.'.index');
  Route::post(   '/add-permission/',          $controllerName.'@addPermission')      ->name($prefix.'.add-permission');
  Route::post(   '/add-role',                $controllerName.'@addRole')            ->name($prefix.'.add-role');
  Route::post(   '/permission-to-role',      $controllerName.'@permissionToRole')   ->name($prefix.'.permission-to-role');
  Route::delete( '/remove-permission/',          $controllerName.'@removePermission')      ->name($prefix.'.remove-permission');
  Route::delete( '/permission-revoke-role',      $controllerName.'@permissionRevokeRole')   ->name($prefix.'.permission-revoke-role');
  /*
  Route::get(   '/create',       $controllerName.'@create')   ->name($prefix.'.create');
  Route::post(  '/',          $controllerName.'@store')   ->name($prefix.'.store');
  Route::get(   '/{id}',        $controllerName.'@show')    ->name($prefix.'.show');
  Route::get(   '/{id}/edit',      $controllerName.'@edit')    ->name($prefix.'.edit');
  Route::put(   '/{id}',        $controllerName.'@update')   ->name($prefix.'.update');
  Route::delete( '/{id}',        $controllerName.'@destroy')  ->name($prefix.'.destroy');
  */
});

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


//Route::get(   '/{model}/{model_id}/personcontact/create',    'PersonContactController@create')  ->name('personcontact.create');
//Route::post(  '/{model}/{model_id}/personcontact/',          'PersonContactController@store')   ->name('personcontact.store');
//Route::get(   '/{model}/{model_id}/personcontact/{id}/edit', 'PersonContactController@edit')    ->name('personcontact.edit');
//Route::put(   '/{model}/{model_id}/personcontact/{id}',      'PersonContactController@update')  ->name('personcontact.update');
//Route::delete('/{model}/{model_id}/personcontact/{id}',      'PersonContactController@destroy') ->name('personcontact.destroy');

Route::prefix('personcontact')->group(function() {
  $prefix = 'personcontact';
  $controllerName = 'PersonContactController';

  //Route::get(   '/',          $controllerName.'@index')   ->name($prefix.'.index');
  Route::get(   '/create',       $controllerName.'@create')   ->name($prefix.'.create');
  Route::post(  '/',          $controllerName.'@store')   ->name($prefix.'.store');
  //Route::get(   '/{id}',        $controllerName.'@show')    ->name($prefix.'.show');
  //Route::get(   '/{id}/edit',      $controllerName.'@edit')    ->name($prefix.'.edit');
  //Route::put(   '/{id}',        $controllerName.'@update')   ->name($prefix.'.update');
  Route::delete( '/',        $controllerName.'@destroy')  ->name($prefix.'.destroy');

  


});


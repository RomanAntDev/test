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

Route::get('/', 'RegistrationController@index')->name('index');
Route::post('/store', 'RegistrationController@store')->name('store');
Route::post('/cities/{terId}', 'RegistrationController@findCities');
Route::post('/districts/{terId}', 'RegistrationController@findDistricts');
Route::post('/exception/{terId}', 'RegistrationController@findException');

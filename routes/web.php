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
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
Route::get('/','HomeController@index')->name('home');


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/incidents','IncidentController@index')->name('incidents.index');
Route::get('/incidents/create','IncidentController@create')->name('incidents.create');

Route::post('/incidents/store','IncidentController@store')->name('incidents.store');
Route::get('/incidents/{id}/edit','IncidentController@edit')->name('incidents.edit');
Route::post('incidents/update/{id}','IncidentController@update')->name('incidents.update');

});

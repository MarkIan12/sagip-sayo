<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


    Route::get('reports','IncidentReportController@index')->name('incidents.report');

    // Barangays
    Route::get('/barangays', 'BarangayController@index')->name('barangays');
    Route::post('/new_barangay', 'BarangayController@store')->name('barangays.store');
    Route::get('/edit/{id}', 'BarangayController@edit');
    Route::post('update_barangay/{id}', 'BarangayController@update');
    Route::post('delete_barangay/{id}', 'BarangayController@destroy')->name('delete_barangay');

    // Streets

    // Categories
    Route::get('/categories', 'CategoryController@index')->name('categories');
    Route::post('/new_category', 'CategoryController@store')->name('categories.store');
    Route::get('/edit/{id}', 'CategoryController@edit');
    Route::post('update_category/{id}', 'CategoryController@update');
    Route::post('delete_category/{id}', 'CategoryController@destroy')->name('delete_category');

    // User
    Route::get('/users', 'UserController@index')->name('users');
    Route::post('/new_user', 'UserController@store')->name('users.store');
    Route::get('/edit/{id}', 'UserController@edit');
    Route::post('update_user/{id}', 'UserController@update');
    Route::post('user_change_password/{id}', 'UserController@userChangePassword');
    Route::post('deactivate/{id}', 'UserController@deactivate');


});

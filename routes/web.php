<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IncidentController;
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
    Route::post('delete_incident/{id}', 'IncidentController@delete')->name('delete_incident');
    Route::delete('/attachments/{id}', 'IncidentController@destroy')->name('attachments.destroy');
    Route::get('reports','IncidentReportController@index')->name('incidents.report');

    Route::get('/traffic-map','IncidentController@map')->name('incidents.map');
    Route::get('/traffic-map/streets/{barangay}', 'IncidentController@getStreets')->name('incidents.streets');
    Route::get('/traffic-incidents', 'IncidentController@incidents')->name('traffic.incidents');

    // Barangays
    Route::get('/barangays', 'BarangayController@index')->name('barangays');
    Route::post('/new_barangay', 'BarangayController@store')->name('barangays.store');
    Route::get('/edit/{id}', 'BarangayController@edit');
    Route::post('update_barangay/{id}', 'BarangayController@update');
    Route::post('delete_barangay/{id}', 'BarangayController@destroy')->name('delete_barangay');

    // Streets
    Route::get('/streets', 'StreetController@index')->name('streets');
    Route::post('/new_street', 'StreetController@store')->name('streets.store');
    Route::get('/edit/{id}', 'StreetController@edit');
    // Route::post('update_incident_type/{id}', 'StreetController@update');
    Route::post('delete_street/{id}', 'StreetController@destroy')->name('delete_street');

    // Incident Type
    Route::get('/incident_types', 'TypeController@index')->name('incident_types');
    Route::post('/new_incident_type', 'TypeController@store')->name('incident_types.store');
    Route::get('/edit/{id}', 'TypeController@edit');
    Route::post('update_incident_type/{id}', 'TypeController@update');
    Route::post('delete_incident_type/{id}', 'TypeController@destroy')->name('delete_category');

    // User
    Route::get('/users', 'UserController@index')->name('users');
    Route::post('/new_user', 'UserController@store')->name('users.store');
    Route::get('/edit/{id}', 'UserController@edit');
    Route::post('update_user/{id}', 'UserController@update');
    Route::post('user_change_password/{id}', 'UserController@userChangePassword');
    Route::post('deactivate/{id}', 'UserController@deactivate');


});

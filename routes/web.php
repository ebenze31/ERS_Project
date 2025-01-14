<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ----- DEV ----- //
Route::middleware(['auth', 'role:dev-admin'])->group(function () {
    Route::get('/add_districts', 'For_DevController@add_districts');
});

Route::get('/after_login', function () {
    return view('after_login');
});

Route::get('/mockup/after_login', function () {
    return view('mockup/after_login');
});

Route::get('/mockup/score', function () {
    return view('mockup/score');
});
Route::get('/mockup/show_score', function () {
    return view('mockup/show_score');
});
// ----- End DEV ----- //

// -------------------------------------------------------------------------

// ----- Admin ----- //
Route::middleware(['auth', 'role:admin,dev-admin'])->group(function () {
    Route::get('/for_admin', 'AdminController@index');
    Route::resource('polling_units', 'Polling_unitsController');
    Route::resource('candidates', 'CandidatesController');
});
// ----- End Admin ----- //

// ----- Officer ----- //
Route::middleware(['auth', 'role:admin,dev-admin,officer'])->group(function () {

});
// ----- End Officer ----- //

// -------------------------------------------------------------------------


Route::resource('political_parties', 'Political_partiesController');
Route::resource('type_candidates', 'Type_candidatesController');
Route::resource('years', 'YearsController');
Route::resource('scores', 'ScoresController');
Route::get('admin_report_score', 'ScoresController@admin_report_score');
Route::resource('provinces', 'ProvincesController');
Route::resource('districts', 'DistrictsController');
Route::resource('electorates', 'ElectoratesController');
Route::resource('sub_districts', 'Sub_districtsController');


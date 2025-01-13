<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/excel_add_districts/', 'For_DevController@excel_add_districts');
Route::post('/excel_add_sub_districts/', 'For_DevController@excel_add_sub_districts');
Route::post('/excel_add_polling_units/', 'Polling_unitsController@excel_add_polling_units');

Route::get('/install_provinces/', 'For_DevController@install_provinces');
Route::get('/install_districts/', 'For_DevController@install_districts');
Route::get('/install_sub_districts/', 'For_DevController@install_sub_districts');

Route::get('/getData_Candidate', 'CandidatesController@getDataCandidateAPI');
Route::get('/getData_Type_Candidate', 'YearsController@getDataTypeCandidateAPI');


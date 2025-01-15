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

Route::get('/create_user_units/{province}', 'Polling_unitsController@create_user_units');

Route::get('/install_provinces/', 'For_DevController@install_provinces');
Route::get('/install_districts/', 'For_DevController@install_districts');
Route::get('/install_sub_districts/', 'For_DevController@install_sub_districts');

Route::post('/excel_add_candidates/', 'CandidatesController@excel_add_candidates');
Route::get('/get_data_years', 'CandidatesController@get_data_years');
Route::get('/getData_Candidate', 'CandidatesController@getDataCandidateAPI');
Route::get('/getData_Type_Candidate', 'YearsController@getDataTypeCandidateAPI');

Route::get('/getData_Election_Setting', 'YearsController@getData_Election_Setting_API');
Route::get('/activeStatusYear', 'YearsController@activeStatusYearAPI');

Route::post('/create_new_year', 'YearsController@create_new_yearAPI');
Route::post('/update_new_year', 'YearsController@update_new_yearAPI');

Route::get('/admin_vote_score', 'scoresController@admin_vote_scoreAPI');


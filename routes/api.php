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
Route::post('/save_user_polling_units', 'Polling_unitsController@save_user_polling_units');
Route::get('/clear_name_user/{id}/{user_id}', 'Polling_unitsController@clear_name_user');

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

// Route::get('/check_count_score_unit/{unit_id}/{province}', 'scoresController@check_count_score_unit');
Route::get('/admin_vote_score', 'scoresController@admin_vote_scoreAPI');
Route::post('/send_score', 'scoresController@send_score');
Route::get('/get_record_score/{user_id}', 'scoresController@get_record_score');
Route::get('/get_data_scores/{district_id}', 'scoresController@get_data_scores');
Route::get('/get_data_districts/{provinces_id}', 'scoresController@get_data_districts');
Route::get('/clear_score/{id}/{user_id}/{year_id}', 'scoresController@clear_score');

Route::get('/get_active_years/{province}', 'YearsController@get_active_years');
Route::post('/get_candidates_of_electorate_id', 'CandidatesController@get_candidates_of_electorate_id');

Route::get('/get_vote_score_history/{polling_unit_id}', 'scoresController@get_vote_score_historyAPI');
Route::get('/manage_user_data', 'AdminController@get_manage_user_dataAPI');
Route::post('/update_manage_user', 'AdminController@update_user_dataAPI');
Route::post('/multi_update_manage_users', 'AdminController@multi_update_user_dataAPI');
Route::post('/get_district', 'AdminController@get_district_dataAPI');
Route::post('/get_polling_unit', 'AdminController@get_polling_unit_dataAPI');



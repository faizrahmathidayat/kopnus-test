<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobSeekerController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {
    Route::post('/auth/login', 'AuthController@login');
    Route::middleware('auth:api')->group(function () {
        Route::get('/auth/me', 'AuthController@me');
        Route::post('/auth/logout', 'AuthController@logout');

        Route::group(['prefix' => 'jobseekers', 'middleware' => ['check_role_jobseeker']], function () {
            Route::get('/vacancies', 'JobSeekerController@getVacancies');
            Route::get('/vacancies/{id}', 'JobSeekerController@show');
            Route::post('/vacancies/apply', 'JobSeekerController@applyVacancy');
            Route::get('/applied-jobs', 'JobSeekerController@appliedJobs');
            Route::get('/applied-jobs/{id}', 'JobSeekerController@showApplyJob');
        });

        Route::group(['prefix' => 'recruiters', 'middleware' => ['check_role_recruiter']], function () {
            Route::get('/jobs', 'RecruiterController@getJobs');
            Route::get('/jobs/{id}', 'RecruiterController@show');
            Route::post('/jobs/store', 'RecruiterController@store');
            Route::patch('/jobs/{id}', 'RecruiterController@update');
            Route::delete('/jobs/{id}', 'RecruiterController@destroy');
        });
    });
});

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
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/logout', 'App\Http\Controllers\AuthController@logout');

Route::get('/jobseeker/register', function () {
    return view('jobseekerregister');
});

Route::get('/recruiter/register', function () {
    return view('recruiterregister');
});

Route::group(['middleware' => 'App\Http\Middleware\CheckJobSeeker'], function()
    {
        Route::get('/jobseeker/dashboard', function () {
            return view('dashboard.jobseekerdashboard');
        });   
    });


Route::group(['middleware' => 'App\Http\Middleware\CheckRecruiter'], function()
    {
        Route::get('/recruiter/dashboard', function () {
            return view('dashboard.recruiterdashboard');
        });   
    });


Route::post('/addJob', 'App\Http\Controllers\RecruiterController@addJob');

Route::post('/editJob', 'App\Http\Controllers\RecruiterController@editJob');

Route::delete('/deleteJob', 'App\Http\Controllers\RecruiterController@deleteJob');

Route::get('/getAllJob', 'App\Http\Controllers\RecruiterController@getAllJob');

Route::get('/getAllCandidate', 'App\Http\Controllers\RecruiterController@getAllCandidate');

Route::get('/getAllAppliedJob', 'App\Http\Controllers\RecruiterController@getAllAppliedJob');

Route::get('/getActiveJob', 'App\Http\Controllers\RecruiterController@getActiveJob');

Route::post('/searchActiveJob', 'App\Http\Controllers\JobSeekerController@searchActiveJob');

Route::get('/applyJob/{jobId}/{recruiterId}', 'App\Http\Controllers\JobSeekerController@applyJob');

Route::post('/filterCandidate', 'App\Http\Controllers\RecruiterController@filterCandidate');

Route::get('/fetchJob/{jobId}', 'App\Http\Controllers\RecruiterController@fetchJob');

Route::post('/createJobSeeker', 'App\Http\Controllers\JobSeekerController@store');

Route::post('/createRecruiter', 'App\Http\Controllers\RecruiterController@store');

Route::get('/getJobLocation', 'App\Http\Controllers\JobSeekerController@getJobLocation');

Route::post('/userLogin', 'App\Http\Controllers\AuthController@login');

Route::get('/userLogout', 'App\Http\Controllers\AuthController@logout');



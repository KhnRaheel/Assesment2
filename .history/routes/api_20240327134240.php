routes

paste ni ho rhaa ???kia
<?php

use Illuminate\Http\Reques
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

Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', 'UserController');
    Route::apiResource('projects', 'ProjectController');
    Route::apiResource('timesheets', 'TimesheetController');
});

// Authentication Routes
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->middleware('auth:api');

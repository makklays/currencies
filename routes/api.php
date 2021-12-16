<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/courses','App\Http\Controllers\Api\CourseController@courses');
Route::middleware('auth:api')->get('/course/{send_currency}/{recive_currency}', [CourseController::class, 'course']);
    //->where(['send_currency' => '[0-9]+', 'recive_currency' => '[0-9]+']);

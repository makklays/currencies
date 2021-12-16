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
})->name('/');

//
Route::get('/courses/upload', 'App\Http\Controllers\Web\UploadController@upload')->name('upload');
Route::post('/courses/upload_process', 'App\Http\Controllers\Web\UploadController@upload_process')->name('upload_process');

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

// for upload file with courses
Route::prefix('courses')->group(function () {
    Route::get('/upload', 'App\Http\Controllers\Web\UploadController@upload')->name('upload');
    Route::post('/upload_process', 'App\Http\Controllers\Web\UploadController@upload_process')->name('upload_process');
});

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/test', function () {
//    Storage::disk('local')->put('test.txt', "Mohtava");
    # If disk is public, The url is
//    echo asset('storage/test.txt');
//    Storage::disk('private')->put('test.txt', "Mohtava");
//    echo Storage::disk('local')->get('BG3.jpg');
//    return Storage::disk('local')->download('BG3.jpg');
//    return Storage::disk('local')->download('BG3.jpg', 'Witcher');
//      return Storage::disk('local')->url('BG3.jpg');
//    Storage::disk('public')->temporaryUrl('BG3.jpg', now()->addMinute(1));
    return Storage::disk('public')->path('BG3.jpg');
});

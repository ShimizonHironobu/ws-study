<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Events\PublicEvent;

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

Auth::routes();

Route::get('/public-event', function(){
    broadcast(new PublicEvent);
    return 'public';
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //チャットルーム
    Route::get('/chatroom', [App\Http\Controllers\ChatRoomController::class, "index"])->name("chatroom");
    Route::get('/chatroom/messages', [App\Http\Controllers\ChatRoomController::class, "fetchMessages"]);
    Route::post('/chatroom/messages', [App\Http\Controllers\ChatRoomController::class, "sendMessage"]);
});

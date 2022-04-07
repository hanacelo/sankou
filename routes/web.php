<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;//追記


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

//トップページを表示（書き換えたよ〜！）
Route::get('/', [PostsController::class, 'index']);

//登録処理　//ここは追記してます
Route::post('posts', [PostsController::class, 'store']);

//お気に入り処理（追加）
Route::post('post/{post_id}', [PostsController::class, 'favo']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

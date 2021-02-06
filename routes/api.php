<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
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

Route::get('/get_latest_posts',[PostController::class,'getLatestPosts']);
Route::get('/get_most_read_posts',[PostController::class,'getMostReadPosts']);
Route::get('/get_populer_posts',[PostController::class,'getPopulerPosts']);
Route::get('/get_random_posts',[PostController::class,'getRandomPosts']);

Route::get('/get_categories',[CategoryController::class,'getCategories']);
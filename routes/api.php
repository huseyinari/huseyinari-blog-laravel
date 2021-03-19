<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentAnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

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

// Post Api
Route::get('/get_latest_posts',[PostController::class,'getLatestPosts']);
Route::get('/get_most_read_posts',[PostController::class,'getMostReadPosts']);
Route::get('/get_populer_posts',[PostController::class,'getPopulerPosts']);
Route::get('/get_random_posts',[PostController::class,'getRandomPosts']);
Route::get('/get_post_detail/{seo}',[PostController::class,'getPostDetail']);
Route::get('/get_category_posts/{seo}',[PostController::class,'getCategoryPosts']);
Route::post('/increase_view_count',[PostController::class,'increaseViewCount']);

// Category Api
Route::get('/get_categories',[CategoryController::class,'getCategories']);
Route::get('/get_category_details/{seo}',[CategoryController::class,'getCategoryDetails']);

// Comment Api
Route::post('/set_comment',[CommentAnswerController::class,'setComment']);
// Answer Api
Route::post('/set_answer',[CommentAnswerController::class,'setAnswer']);

// Panel Giriş
Route::post('/login',[AuthController::class,'login']);

// Admin Api
Route::group(['prefix' =>'admin','middleware'=>'auth.jwt'],function(){
    Route::post('/logout',[AuthController::class,'logout']);   // çıkış yapma 
    Route::get('/admin_control',[AdminController::class,'adminControl']);
    Route::post('/add_post',[AdminController::class,'addPost']);
    Route::post('/delete_post',[AdminController::class,'deletePost']);
    Route::post('/update_post',[AdminController::class,'updatePost']);
    Route::post('/add_image',[AdminController::class,'addImage']);
    Route::post('/add_category',[AdminController::class,'addCategory']);
    Route::post('/delete_category',[AdminController::class,'deleteCategory']);
    Route::post('/update_category',[AdminController::class,'updateCategory']);
    Route::get('/get_all_posts',[AdminController::class,'getAllPosts']);
    Route::get('/get_all_comments',[AdminController::class,'getAllComments']);
});
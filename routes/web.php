<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Aboutcontroller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

// Route::get('/', [HomeController::class, 'index'])->name('home');

//news
Route::get('/', [NewsController::class, 'index'])->name('index-news');
Route::get('/all-news', [NewsController::class, 'allnews'])->name('show-all-news');
Route::get('/show-news/{news}', [NewsController::class, 'show'])->name('news-show');
Route::get('/show-news-bottom/{newsbottom}', [NewsController::class, 'show2'])->name('news-bottom-show');
Route::get('/about', [Aboutcontroller::class, 'about'])->name('about');
Route::get('/category/{category}', [NewsController::class, 'showByCategory'])->name('category-news');

Route::middleware(['admin'])->group(function(){
    //news
    Route::get('/admin/create-news', [NewsController::class, 'create'])->name('news-create');
    Route::post('/admin/store-news', [NewsController::class, 'store'])->name('news-store');
    Route::get('/admin/edit-news/{news}', [NewsController::class, 'edit'])->name('news-edit');
    Route::delete('/admin/edit-news/{news}/remove-video',  [NewsController::class, 'update'])->name('remove-video');
    Route::patch('/admin/update-news/{news}', [NewsController::class, 'update'])->name('news-update');
    Route::delete('/admin/delete-news/{news}', [NewsController::class, 'delete'])->name('news-delete');

    // news bottom
    Route::get('/admin/create-news-bottom', [NewsController::class, 'create2'])->name('create-news-bottom');
    Route::post('/admin/store-news-bottom', [NewsController::class, 'store2'])->name('store-news-bottom');
    Route::get('/admin/edit-news-bottom/{newsbottom}', [NewsController::class, 'edit2'])->name('news-bottom-edit');
    Route::patch('/admin/update-news-bottom/{newsbottom}', [NewsController::class, 'update2'])->name('news-bottom-update');
    Route::delete('/admin/edit-news-bottom/{newsbottom}/remove-video',  [NewsController::class, 'update2'])->name('remove-video-bottom');
    Route::delete('/admin/delete-news-bottom/{newsbottom}', [NewsController::class, 'delete2'])->name('news-bottom-delete');

});

<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Newscontroller;
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
Route::get('/', [Newscontroller::class, 'index'])->name('index_news');

Route::get('/show-news/{news}', [Newscontroller::class, 'show'])->name('news-show');
Route::get('/show-news-bottom/{newsbottom}', [Newscontroller::class, 'show2'])->name('news-bottom-show');
Route::get('/about', [Aboutcontroller::class, 'about'])->name('about');


Route::middleware(['admin'])->group(function(){
    //news
    Route::get('/admin/create-news', [Newscontroller::class, 'create'])->name('news-create');
    Route::post('/admin/store-news', [Newscontroller::class, 'store'])->name('news-store');
    Route::get('/admin/edit-news/{news}', [Newscontroller::class, 'edit'])->name('news-edit');
    Route::patch('/admin/update-news/{news}', [Newscontroller::class, 'update'])->name('news-update');
    Route::delete('/admin/delete-news/{news}', [Newscontroller::class, 'delete'])->name('news-delete');

    // news bottom
    Route::get('/admin/create-news-bottom', [NewsController::class, 'create2'])->name('create-news-bottom');
    Route::post('/admin/store-news-bottom', [NewsController::class, 'store2'])->name('store-news-bottom');
    Route::get('/admin/edit-news-bottom/{newsbottom}', [Newscontroller::class, 'edit2'])->name('news-bottom-edit');
    Route::patch('/admin/update-news-bottom/{newsbottom}', [Newscontroller::class, 'update2'])->name('news-bottom-update');
    Route::delete('/admin/delete-news-bottom/{newsbottom}', [Newscontroller::class, 'delete2'])->name('news-bottom-delete');

});

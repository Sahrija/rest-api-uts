<?php

use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// News CRUD routes
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::post('/news', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

// Search & category routes
Route::get('/news/search/{title}', [NewsController::class, 'search'])->name('news.search');
Route::get('/news/category/sport', [NewsController::class, 'sport'])->name('news.sport');
Route::get('/news/category/finance', [NewsController::class, 'finance'])->name('news.finance');
Route::get('/news/category/automotive', [NewsController::class, 'automotive'])->name('news.automotive');

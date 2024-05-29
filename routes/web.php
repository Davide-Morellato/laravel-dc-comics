<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicController;

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

Route::get('/', [ComicController::class, 'home'])->name('home');


Route::get('/comics', [ComicController::class, 'index'])->name('comic.index');

Route::get('/comics/{comic}', [ComicController::class, 'show'])->name('comic.show');
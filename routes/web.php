<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;

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

Route::post('/books', [BooksController::class, 'store']);
Route::patch('/books/{book}/{date}/{slug}', [BooksController::class, 'update']);
Route::delete('/books/{book}/{date}/{slug}', [BooksController::class, 'destroy']);

Route::post('/authors', [AuthorController::class, 'store']);
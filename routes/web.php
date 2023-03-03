<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TestimoniController;
use Illuminate\Support\Facades\Route;

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

// Route::post('login', [AuthController::class, 'login_member']);
// Route::post('logout', [AuthController::class, 'logout_member']);

//auth
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);

//kategori
// Route::get('/kategori', [CategoryController::class], 'list');
// Route::get('/subkategori', [SubcategoryController::class], 'index');
// Route::get('/slider', [SliderController::class], 'list');
// Route::get('/barang', [ProductController::class], 'list');
// Route::get('/testimoi', [TestimoniController::class], 'list');
// Route::get('/review', [ReviewController::class], 'list');

Route::get('/kategori', [App\Http\Controllers\CategoryController::class, 'list'])->name('kategori');
Route::get('/subkategori', [App\Http\Controllers\SubcategoryController::class, 'list'])->name('subkategori');
Route::get('/slider', [App\Http\Controllers\SliderController::class, 'list'])->name('slider');
Route::get('/barang', [App\Http\Controllers\ProductController::class, 'list'])->name('barang');
Route::get('/testimoni', [App\Http\Controllers\TestimoniController::class, 'list'])->name('testimoni');
Route::get('/review', [App\Http\Controllers\ReviewController::class, 'list'])->name('review');


Route::get('/dashboard', [DashboardController::class, 'index']);

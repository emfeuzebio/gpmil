<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PgradController;
use App\Http\Controllers\CirculoController;

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

Route::get('/', function () { 
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');


Route::get('/pgrad', [PgradController::class, 'index'])->name('home');
Route::post('pgrad/store', [PgradController::class, 'store'])->name('home');
Route::post('pgrad/edit', [PgradController::class, 'edit'])->name('home');
Route::post('pgrad/destroy', [PgradController::class, 'destroy'])->name('home');


Route::get('/circulo', [CirculoController::class, 'index'])->name('home');
Route::post('circulo/store', [CirculoController::class, 'store'])->name('home');
Route::post('circulo/edit', [CirculoController::class, 'edit'])->name('home');
Route::post('circulo/destroy', [CirculoController::class, 'destroy'])->name('home');





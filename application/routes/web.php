<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CirculoController;
use App\Http\Controllers\NivelAcessoController;
use App\Http\Controllers\PgradController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::get('/users', [App\Http\Controllers\HomeController::class, 'index'])->name('users.index');
 
Route::get('/users', [UsersController::class, 'index'])->name('users.index');

Route::get('/circulos', [CirculoController::class, 'index'])->name('circulos.index');

Route::get('/nivelacessos', [NivelAcessoController::class, 'index'])->name('nivelacessos.index');

//Funcionado todo CRUD, apenas com esta entrada todas operações funcioanam
Route::get('/pgrads', [PgradController::class, 'index'])->name('home');
Route::post('pgrads/store', [PgradController::class, 'store'])->name('home');
Route::post('pgrads/edit', [PgradController::class, 'edit'])->name('home');
Route::post('pgrads/destroy', [PgradController::class, 'destroy'])->name('home');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');


// Route::get('/pgrads', [PgradController::class, 'index'])->name('users.pgrads');
// Route::get('/pgrads/datatablesAjax', [PgradController::class, 'datatablesAjax'])->name('users.pgrads');


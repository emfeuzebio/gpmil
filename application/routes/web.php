<?php


use App\Http\Controllers\BoletinsController;
use App\Http\Controllers\ApresentacaoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CirculoController;
use App\Http\Controllers\NivelAcessoController;
use App\Http\Controllers\PgradController;
use App\Http\Controllers\SecaoController;
use App\Http\Controllers\DestinoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\QualificacaoController;
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
 
Route::get('/users', [UsersController::class, 'index'])->name('users.index');

Route::get('/circulos', [CirculoController::class, 'index'])->name('circulos.index');

Route::get('/nivelacessos', [NivelAcessoController::class, 'index'])->name('nivelacessos.index');

//Funcionado todo CRUD, apenas com esta entrada todas operações funcioanam
Route::get('/pgrads', [PgradController::class, 'index'])->name('home');
Route::post('pgrads/store', [PgradController::class, 'store'])->name('home');
Route::post('pgrads/edit', [PgradController::class, 'edit'])->name('home');
Route::post('pgrads/destroy', [PgradController::class, 'destroy'])->name('home');

//Funcionado todo CRUD, apenas com esta entrada todas operações funcioanam
Route::get('/pessoas', [PessoaController::class, 'index'])->name('home');
Route::post('pessoas/store', [PessoaController::class, 'store'])->name('home');
Route::post('pessoas/edit', [PessoaController::class, 'edit'])->name('home');
Route::post('pessoas/destroy', [PessoaController::class, 'destroy'])->name('home');

//Funcionado todo CRUD, apenas com esta entrada todas operações funcioanam
Route::get('/secaos', [SecaoController::class, 'index'])->name('home');
Route::post('secaos/store', [SecaoController::class, 'store'])->name('home');
Route::post('secaos/edit', [SecaoController::class, 'edit'])->name('home');
Route::post('secaos/destroy', [SecaoController::class, 'destroy'])->name('home');

Route::get('/funcaos', [SecaoController::class, 'index'])->name('home');
Route::post('funcaos/store', [SecaoController::class, 'store'])->name('home');
Route::post('funcaos/edit', [SecaoController::class, 'edit'])->name('home');
Route::post('funcaos/destroy', [SecaoController::class, 'destroy'])->name('home');

Route::get('/qualificacaos', [QualificacaoController::class, 'index'])->name('home');
Route::post('qualificacaos/store', [QualificacaoController::class, 'store'])->name('home');
Route::post('qualificacaos/edit', [QualificacaoController::class, 'edit'])->name('home');
Route::post('qualificacaos/destroy', [QualificacaoController::class, 'destroy'])->name('home');

Route::get('/destinos', [DestinoController::class, 'index'])->name('home');
Route::post('/destinos/store', [DestinoController::class, 'store'])->name('home');
Route::post('/destinos/edit', [DestinoController::class, 'edit'])->name('home');
Route::post('/destinos/destroy', [DestinoController::class, 'destroy'])->name('home');

Route::get('/apresentacaos', [ApresentacaoController::class, 'index'])->name('home');
Route::post('/apresentacaos/store', [ApresentacaoController::class, 'store'])->name('home');
Route::post('/apresentacaos/edit', [ApresentacaoController::class, 'edit'])->name('home');
Route::post('/apresentacaos/destroy', [ApresentacaoController::class, 'destroy'])->name('home');
Route::post('/apresentacaos/homologar', [ApresentacaoController::class, 'homologar'])->name('home');

Route::get('/boletins', [BoletinsController::class, 'index'])->name('home');
Route::post('boletins/store', [BoletinsController::class, 'store'])->name('home');
Route::post('boletins/edit', [BoletinsController::class, 'edit'])->name('home');
Route::post('boletins/destroy', [BoletinsController::class, 'destroy'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', function() {
//     return view('home');
// })->name('home')->middleware('auth');


// Route::get('/pgrads', [PgradController::class, 'index'])->name('users.pgrads');
// Route::get('/pgrads/datatablesAjax', [PgradController::class, 'datatablesAjax'])->name('users.pgrads');


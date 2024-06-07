<?php


use App\Http\Controllers\BoletinsController;
use App\Http\Controllers\ApresentacaoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CirculoController;
use App\Http\Controllers\NivelAcessoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\ReligiaoController;
use App\Http\Controllers\PgradController;
use App\Http\Controllers\SecaoController;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\OrganizacaoController;
use App\Http\Controllers\SituacaoController;
use App\Http\Controllers\DestinoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PlanoChamadaController;
use App\Http\Controllers\QualificacaoController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/', function () { return view('/auth/login'); });


// DGP
Route::get('/auth/redirect', function () {
    return Socialite::driver('DGP')->redirect();
    // return Socialite::driver('github')->redirect();
});
 
// opção inicial
Route::get('/auth/callback/dgp', function () {
    // $DGPUser = Socialite::driver('DGP')->user();
    $DGPUser = Socialite::driver('DGP')->user();

    dd($DGPUser);
 
    // $user = User::updateOrCreate([
    //     //'github_id' => $DGPUser->id,
    // ], [
    //     'name' => $DGPUser->name,
    //     'email' => $DGPUser->email,
    //     'github_token' => $DGPUser->token,
    //     'github_refresh_token' => $DGPUser->refreshToken,
    // ]);
 
    // Auth::login($user);
 
    return redirect('/dashboard');    
});

// opção mais completa
Route::get('/auth/callback/dgp', function () {

    try {
        $DGPUser = Socialite::driver('DGP')->user();
        dd($DGPUser);

        $user = User::query()->whereEmail($DGPUser->email)->first();
 
        if (! $user) {
            // vamos criar um novo User e uma nova Pessoa com o mesmo ID

            // $user = User::updateOrCreate([
            //     //'github_id' => $DGPUser->id,
            // ], [
            //     'name' => $DGPUser->name,
            //     'email' => $DGPUser->email,
            //     'github_token' => $DGPUser->token,
            //     'github_refresh_token' => $DGPUser->refreshToken,
            // ]);
        
            // Auth::login($user);            

            // return redirect('login');

        }
 
        // Auth::guard('web')->login($user);
 
        // return redirect(route('home'));
    } catch (Exception $exception) {
        return redirect('login');
    }
});




Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
 
Route::get('/users', [UsersController::class, 'index'])->name('users.index');

Route::get('/circulos', [CirculoController::class, 'index'])->name('circulos.index');

Route::get('/nivelacessos', [NivelAcessoController::class, 'index'])->name('nivelacessos.index');

Route::get('/municipios', [MunicipioController::class, 'index'])->name('municipios.index');

Route::get('/religiaos', [ReligiaoController::class, 'index'])->name('religiaos.index');

Route::get('/pgrads', [PgradController::class, 'index'])->name('home');
Route::post('pgrads/store', [PgradController::class, 'store'])->name('home');
Route::post('pgrads/edit', [PgradController::class, 'edit'])->name('home');
Route::post('pgrads/destroy', [PgradController::class, 'destroy'])->name('home');

Route::get('/pessoas', [PessoaController::class, 'index'])->name('home');
Route::post('pessoas/store', [PessoaController::class, 'store'])->name('home');
Route::post('pessoas/edit', [PessoaController::class, 'edit'])->name('home');
Route::post('pessoas/destroy', [PessoaController::class, 'destroy'])->name('home');

Route::get('/secaos', [SecaoController::class, 'index'])->name('home');
Route::post('secaos/store', [SecaoController::class, 'store'])->name('home');
Route::post('secaos/edit', [SecaoController::class, 'edit'])->name('home');
Route::post('secaos/destroy', [SecaoController::class, 'destroy'])->name('home');

Route::get('/funcaos', [FuncaoController::class, 'index'])->name('home');
Route::post('funcaos/store', [FuncaoController::class, 'store'])->name('home');
Route::post('funcaos/edit', [FuncaoController::class, 'edit'])->name('home');
Route::post('funcaos/destroy', [FuncaoController::class, 'destroy'])->name('home');

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

// Route::get('/situacaos', [SituacaoController::class, 'index'])->name('home')->middleware('can:is_admin');
Route::get('/situacaos', [SituacaoController::class, 'index'])->name('home');
Route::post('situacaos/store', [SituacaoController::class, 'store'])->name('home');
Route::post('situacaos/edit', [SituacaoController::class, 'edit'])->name('home');
Route::post('situacaos/destroy', [SituacaoController::class, 'destroy'])->name('home');

Route::get('/planochamada', [PlanoChamadaController::class, 'index'])->name('home');
Route::post('planochamada/store', [PlanoChamadaController::class, 'store'])->name('home');
Route::post('planochamada/edit', [PlanoChamadaController::class, 'edit'])->name('home');

Route::get('/organizacaos', [OrganizacaoController::class, 'index'])->name('home');
Route::post('organizacaos/store', [OrganizacaoController::class, 'store'])->name('home');
Route::post('organizacaos/edit', [OrganizacaoController::class, 'edit'])->name('home');
Route::post('organizacaos/destroy', [OrganizacaoController::class, 'destroy'])->name('home');


// Auth::routes();




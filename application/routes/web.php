<?php

use App\Http\Controllers\BoletimController;
use App\Http\Controllers\ApresentacaoController;
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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PlanoChamadaController;
use App\Http\Controllers\QualificacaoController;
use App\Http\Controllers\SolicitacoesController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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
// Auth::logout();    
// Auth::loginUsingId(6);

Route::group(['middleware' => 'check.time'], function () {

    Route::get('/', function () { 
        if(Auth::check()){
            return redirect('/home');
        }
        return view('/auth/login'); 
    });

    // remete para Socialite DGP autenticação
    Route::get('/auth/redirect', function () {
        return Socialite::driver('DGP')->redirect();
    });
    
    // valida a autenticação vinda do Socialite DGP 
    Route::get('/auth/callback/dgpde', function () {
        $DGPUser = Socialite::driver('DGP')->user();

        if($DGPUser->om_codom != '045575') {
            return redirect('/')->withErrors(['msg' => 'Usuário não é ou ainda não está apresentado na DCEM']);
        }

        // dd($DGPUser);
        DB::beginTransaction();
    
        try {
            // Verifica se o usuário já existe
            $user = User::where('email', $DGPUser->email . "@dcem.eb.mil.br")->first();

            if (!$user) {
                // Se o usuário não existir, cria um novo
                $user = User::create([
                    'name' => $DGPUser->nickname,
                    'email' => $DGPUser->email . "@dcem.eb.mil.br",
                    'password' => Hash::make($DGPUser->idt),
                    'remember_token' => $DGPUser->token
                ]);

                // Busca o ID da sigla na tabela 'pgrads'
                $pgrad = DB::table('pgrads')->where('sigla', $DGPUser->pgrad_sigla)->first();
                $pgrad_id = $pgrad ? $pgrad->id : null;

                // Cria um novo registro na tabela 'pessoa' com o mesmo ID do usuário
                DB::table('pessoas')->insert([
                    'id' => $user->id,
                    'pgrad_id' => $pgrad_id,
                    'nome_completo' => $DGPUser->name,
                    'nome_guerra' => $DGPUser->nickname,
                    'idt' => $DGPUser->idt,
                    'user_id' => $user->id
                    // adicione outras colunas da tabela 'pessoa' conforme necessário
                ]);

                DB::table('preferencias')->insert([
                    'id' => $user->id,
                    'dark_mode' => 0,
                    'pessoa_id' => $user->id 
                    // adicione outras colunas da tabela 'preferencias' conforme necessário
                ]);
            } else {
                if($DGPUser->om_codom != '045575') {
                    return redirect('/')->withErrors(['msg' => 'Usuário não é mais da DCEM']);
                }

                // Verifica o status ativo do usuário na tabela 'pessoas'
                $pessoa = DB::table('pessoas')->where('id', $user->id)->first();
                if ($pessoa->ativo === 'NÃO') {
                    return redirect('/')->withErrors(['msg' => 'Usuário não está ativo']);
                }
            }

            // Faz o login do usuário (existente ou recém-criado)
            Auth::login($user);

            // Confirma a transação
            DB::commit();

            return redirect('/home');
        } catch (\Exception $e) {
            // Em caso de erro, desfaz a transação
            DB::rollBack();

            // Trate o erro conforme necessário (exemplo: redirecionar com uma mensagem de erro)
            return redirect('/')->withErrors(['msg' => 'Erro ao criar usuário.']);
        } 
    });


    Auth::routes();

    // rotas acessíveis somente após autenticado
    Route::middleware('auth')->group(function () {
        Route::get('/isAuthenticated', function () {
            return response()->json(['authenticated' => Auth::check()]);
        });

        Route::get('/home', [HomeController::class, 'index'])->name('home');
        
        Route::get('/solicitacoes', [SolicitacoesController::class, 'index'])->name('solicitacoes');

        Route::controller(NotificationController::class)->group(function () {
            Route::get('/solicitar-troca', 'index')->name('solicitar-troca.index');
            Route::post('/solicitar-troca/solicitar', 'solicitar')->name('solicitar-troca');
            Route::post('/encpes/notifications/{id}/mark-as-read', 'markAsRead')->name('encpes.markAsRead');
            Route::get('/encpes/notifications/update', 'update')->name('encpes.notifications.update');
        });

        // acesso para todos os Gates: 'is_admin','is_encpes','is_cmt', 'is_chsec, 'is_sgtte', 'is_usuario'
        Route::controller(PessoaController::class)->group(function () {
            Route::get('/pessoas', 'index')->name('pessoa.index');
            Route::get('/pessoas/{user_id?}','index')->name('pessoa.editar')->middleware('checkUserAccess');
            Route::post('pessoas/store', 'store')->name('pessoa.store')->middleware('can:podeSalvarPessoa');
            Route::post('pessoas/edit', 'edit')->name('pessoa.edit');
            Route::post('pessoas/destroy', 'destroy')->name('pessoa.destroy');            
        });        

        Route::controller(ApresentacaoController::class)->group(function () {
            Route::get('/apresentacaos', 'index')->name('apresentacao.index');
            Route::post('apresentacaos/store', 'store')->name('apresentacao.store');
            Route::post('apresentacaos/edit', 'edit')->name('apresentacao.edit');
            Route::post('apresentacaos/destroy', 'destroy')->name('apresentacao.destroy');            
            Route::post('apresentacaos/homologar', 'homologar')->name('apresentacao.homologar');            
            Route::post('apresentacaos/getApresentacoesAbertas', 'getApresentacoesAbertas')->name('apresentacao.getApresentacoesAbertas');            
        });        

        Route::controller(PlanoChamadaController::class)->group(function () {
            Route::get('/planochamada', 'index')->name('planochamada.index');
            Route::get('/planochamada/{user_id?}', 'index')->name('planochamada.user')->middleware('checkUserAccess');
            Route::post('planochamada/store', 'store')->name('planochamada.store')->middleware('can:podeEditarPlanoChamada');
            Route::post('planochamada/edit', 'edit')->name('planochamada.edit');
        });        

        // acesso para Gates: 'is_admin','is_encpes'
        // Gestão
            Route::controller(SecaoController::class)->group(function () {
                Route::get('/secaos', 'index')->name('secao.index');
                Route::post('secaos/store', 'store')->name('secao.store')->middleware('can:podeSalvarSecao'); 
                Route::post('secaos/edit', 'edit')->name('secao.edit');
                Route::post('secaos/destroy', 'destroy')->name('secao.destroy');
            });        

            Route::controller(FuncaoController::class)->group(function () {
                Route::get('/funcaos', 'index')->name('funcao.index');
                Route::post('funcaos/store', 'store')->name('funcao.store');
                Route::post('funcaos/edit', 'edit')->name('funcao.edit');
                Route::post('funcaos/destroy', 'destroy')->name('funcao.destroy');            
            });        

            Route::controller(QualificacaoController::class)->group(function () {
                Route::get('/qualificacaos', 'index')->name('qualificacao.index');
                Route::post('qualificacaos/store', 'store')->name('qualificacao.store');
                Route::post('qualificacaos/edit', 'edit')->name('qualificacao.edit');
                Route::post('qualificacaos/destroy', 'destroy')->name('qualificacao.destroy');            
            });        

        // acesso para Gates: 'is_admin','is_encpes'
        // Cadastros
            Route::controller(BoletimController::class)->group(function () {
                Route::get('/boletins', 'index')->name('boletim.index');
                Route::post('boletins/store', 'store')->name('boletim.store');
                Route::post('boletins/edit', 'edit')->name('boletim.edit');
                Route::post('boletins/destroy', 'destroy')->name('boletim.destroy');            
            });

            Route::controller(DestinoController::class)->group(function () {
                Route::get('/destinos', 'index')->name('destino.index');
                Route::post('destinos/store', 'store')->name('destino.store');
                Route::post('destinos/edit', 'edit')->name('destino.edit');
                Route::post('destinos/destroy', 'destroy')->name('destino.destroy');            
            });

            Route::controller(SituacaoController::class)->group(function () {
                Route::get('/situacaos', 'index')->name('situacao.index');
                Route::post('situacaos/store', 'store')->name('situacao.store');
                Route::post('situacaos/edit', 'edit')->name('situacao.edit');
                Route::post('situacaos/destroy', 'destroy')->name('situacao.destroy');            
            });



        // acesso para Gates apenas 'is_admin'
        Route::middleware('can:is_admin')->group(function () {

            Route::get('/users', [UsersController::class, 'index'])->name('users.index');

            Route::get('/circulos', [CirculoController::class, 'index'])->name('circulos.index');

            Route::get('/nivelacessos', [NivelAcessoController::class, 'index'])->name('nivelacessos.index');

            Route::get('/municipios', [MunicipioController::class, 'index'])->name('municipios.index');

            Route::get('/religiaos', [ReligiaoController::class, 'index'])->name('religiaos.index');

            Route::controller(PgradController::class)->group(function () {
                Route::get('/pgrads', 'index')->name('pgrads.index');
                Route::post('pgrads/store', 'store')->name('pgrads.store');
                Route::post('pgrads/edit', 'edit')->name('pgrads.edit');
                Route::post('pgrads/destroy', 'destroy')->name('pgrads.destroy');            
            });

            Route::controller(OrganizacaoController::class)->group(function () {
                Route::get('/organizacaos', 'index')->name('organizacao.index');
                Route::post('organizacaos/store', 'store')->name('organizacao.store');
                Route::post('organizacaos/edit', 'edit')->name('organizacao.edit');
                Route::post('organizacaos/destroy', 'destroy')->name('organizacao.destroy');            
            });

        });        

    });        

});

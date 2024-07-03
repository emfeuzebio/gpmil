@extends('adminlte::page')


@section('content_header')
    <!-- <h1 class="m-0 text-dark">Dashboard</h1> -->
    <div class="row mb-2">
      <div class="m-0 text-dark col-sm-6">
        <h1>GPmil <small>Version 2.0</small></h1>
          <ol class="breadcrumb">
            <li class="active">Gestão de Pessoal Militar</li>
          </ol>
      </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
            </ol>
        </div>
    </div>

@stop

@section('content')

@if(session('incomplete_data_alert'))
  <!-- Modal -->
  <div class="modal fade" id="incompleteDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Dados Incompletos</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  @if(session('incomplete_data_alert')['address'] && session('incomplete_data_alert')['personal'])
                      <p>Há informações que ainda precisam ser preechidas. Gostaria de preenche-los?</p>
                      <button type="button" class="btn btn-primary mb-2" onclick="window.location.href='{{ url('planochamada', ['user_id' => Auth::user()->id]) }}'">Plano de Chamada</button>
                      <button type="button" class="btn btn-primary mb-2" onclick="window.location.href='{{ url('pessoas', ['user_id' => Auth::user()->id]) }}'">Dados Pessoais</button>
                  @elseif(session('incomplete_data_alert')['address'])
                      <p>Seu plano de chamada está incompleto. Gostaria de preeche-lo agora?</p>
                      <button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('planochamada', ['user_id' => Auth::user()->id]) }}'">Preencher Plano de Chamada</button>
                  @elseif(session('incomplete_data_alert')['personal'])
                      <p>Parece que seus dados pessoais estão incompletos. Gostaria de preeche-los agora?</p>
                      <button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('pessoas', ['user_id' => Auth::user()->id]) }}'">Preencher Dados Pessoais</button>
                  @endif
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Preencher Depois</button>
              </div>
          </div>
      </div>
  </div>

  <script>
  $(document).ready(function() {
      $('#incompleteDataModal').modal('show');
  });
  </script>
  @endif

  @if(session('incomplete_apresentacao_alert'))
  <!-- Modal para apresentação incompleta -->
  <div class="modal fade" id="incompleteApresentacaoModal" tabindex="-1" role="dialog" aria-labelledby="incompleteApresentacaoLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="incompleteApresentacaoLabel">Apresentação Incompleta</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>{{ session('incomplete_apresentacao_alert')['mensagem'] }}</p>
                  <button type="button" class="btn btn-primary mb-2" onclick="window.location.href='{{ url('apresentacaos') }}'">Inserir Apresentação de Término</button>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Preencher Depois</button>
              </div>
          </div>
      </div>
  </div>

  <script>
  $(document).ready(function() {
      $('#incompleteApresentacaoModal').modal('show');
  });
  </script>
@endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">Bem vindo <strong>{{$pessoa->pgrad->sigla}} {{$user->pessoa->nome_guerra}}</strong>!</p>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

      @if (Auth::user()->can('is_encpes') || Auth::user()->can('is_admin') || Auth::user()->can('is_cmt'))
        <div class="card">
          <div class="card-body">
            <p class="mb-0"><strong>{{$organizacao->descricao}}</strong>!</p> 
            {{-- <p class="mb-0"><strong>DIRETORIA DE CONTROLE DE EFETIVOS E MOVIMENTAÇÕES</strong>!</p>  --}}
          </div>
        </div>
      @elseif (!Auth::user()->can('is_encpes') || !Auth::user()->can('is_admin') || !Auth::user()->can('is_cmt'))
        <div class="card">
          <div class="card-body">
            <p class="mb-0"><strong>{{$secaos->descricao}}</strong>!</p> 
          </div>
        </div>
      @endif

      @cannot('is_usuario')
      <!-- Info boxes -->
      <div class="row justify-content-around">
        <div class="custom-col col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="ion ion-ios-gear-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Efetivo Pronto</span>
              <span class="info-box-number">{{ $qtdPessoasProntas }} <small>pessoas</small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      
        <div class="custom-col col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"></span>
            <div class="info-box-content">
              <span class="info-box-text">Em Férias</span>
              <span class="info-box-number">{{ $qtdPessoasFerias }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      
        <div class="custom-col col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Em Dispensa</span>
              <span class="info-box-number">{{ $qtdPessoasDispensa }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      
        <div class="custom-col col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="ion ion-ios-cart-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Em Afastamento de Sede</span>
              <span class="info-box-number">{{ $qtdPessoasAfasSede }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      
        <div class="custom-col col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Efetivo Total</span>
              <span class="info-box-number">{{ $qtdPessoasTotal }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      @endcannot

      <!-- Show presentations if user is a common user -->
      {{-- @can('user') --}}
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Minhas Apresentações</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                @if($apresentacoes->isEmpty())
                  <p class="text-center">Não há nenhuma apresentação para listar.</p>
                @else
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Data Apresentação</th>
                      <th>Data Inicial</th>
                      <th>Data Final</th>
                      <th>Publicado</th>
                      <th>Observação</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($apresentacoes as $apresentacao)
                      <tr>
                        <td>{{ $apresentacao->id }}</td>
                        <td>{{ $apresentacao->DtApresBr }}</td>
                        <td>{{ $apresentacao->DtInicialBr }}</td>
                        <td>{{ $apresentacao->DtFinalBr }}</td>
                        <td class="text-center">
                          @if($apresentacao->publicado == 'SIM')
                            <span class="text-primary">{{ $apresentacao->publicado }}</span>
                          @else
                            <span class="text-danger">{{ $apresentacao->publicado }}</span>
                          @endif
                        </td>
                        <td>{{ $apresentacao->observacao }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                @endif
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      {{-- @endcan --}}

      <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Aniversariantes da Semana</h3>
                </div>
                <div class="card-body">
                    @if ($aniversariantes->isEmpty())
                        <p>Não há aniversariantes esta semana.</p>
                    @else
                        <ul>
                            @foreach ($aniversariantes as $aniversariante)
                                <li>{{ $aniversariante->pgrad->sigla }}<strong> {{ $aniversariante->nome_guerra }}</strong> - {{ Carbon\Carbon::createFromFormat('Y-m-d', $aniversariante->dt_nascimento)->format('d/m') }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    </section>

@stop

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
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="ion ion-ios-gear-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Efetivo Pronto</span>
              <span class="info-box-number">{{ $qtdPessoasAtivas }} <small>pessoas</small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"></span>

            <div class="info-box-content">
              <span class="info-box-text">Em Férias</span>
              <span class="info-box-number">26</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Em Destinos</span>
              <span class="info-box-number">16</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
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
    </section>

@stop

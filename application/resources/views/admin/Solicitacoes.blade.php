@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="m-0 text-dark col-sm-6">
            <h1 class="m-0 text-dark"><i class="fas fa-exchange-alt"></i> Solicitações</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">Solicitações</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="container">

    <!-- Feedback Messages -->
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
{{-- Colocar o input: name="tipo" --}}
    <!-- Cards de Solicitação -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="card-title"><i class="fas fa-users"></i> Solicitar Troca de Seção</h5>
        </div>
        <div class="card-body">
            <form id="solicitacaoFormSecao" action="{{ route('solicitar-troca') }}" method="POST">
                @csrf
                <input type="hidden" name="tipo" value="secao">
                <div class="mb-3">
                    <label for="solicitacaoSecao" class="form-label">Motivo da Solicitação</label>
                    @if($temSolicitacaoSecao)
                        <div class="alert alert-warning">
                            Você já possui uma solicitação de seção pendente. Por favor, aguarde até que ela seja processada.
                        </div>
                    @else
                        <select class="form-control selectpicker" name="solicitacao" id="solicitacaoSecao" data-style="form-control" data-live-search="true" title="Selecione a Seção">
                            @foreach($solicitarSecaos as $secao)
                                <option value="{{$secao->sigla}}">{{$secao->sigla}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="card-title"><i class="fas fa-toggle-on"></i> Solicitar Troca de Status</h5>
        </div>
        <div class="card-body">
            <form id="solicitacaoFormStatus" action="{{ route('solicitar-troca') }}" method="POST">
                @csrf
                <input type="hidden" name="tipo" value="status">
                <div class="mb-3">
                    <label for="solicitacaoStatus" class="form-label">Motivo da Solicitação</label>
                    @if($temSolicitacaoStatus)
                        <div class="alert alert-warning">
                            Você já possui uma solicitação de status pendente.
                        </div>
                    @else
                        <select class="form-control selectpicker" name="solicitacao" id="solicitacaoStatus" data-style="form-control" data-live-search="true" title="Selecione o Status">
                            <option value="Ativa">Ativa</option>
                            <option value="Reserva">Reserva</option>
                            <option value="Civil">Civil</option>
                        </select>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="card-title"><i class="fas fa-key"></i> Solicitar Troca de Nível de Acesso</h5>
        </div>
        <div class="card-body">
            <form id="solicitacaoFormNivelAcesso" action="{{ route('solicitar-troca') }}" method="POST">
                @csrf
                <input type="hidden" name="tipo" value="nivel_acesso">
                <div class="mb-3">
                    <label for="solicitacaoNivelAcesso" class="form-label">Motivo da Solicitação</label>
                    @if($temSolicitacaoNivelAcesso)
                        <div class="alert alert-warning">
                            Você já possui uma solicitação de nível de acesso pendente.
                        </div>
                    @else
                        <select class="form-control selectpicker" name="solicitacao" id="solicitacaoNivelAcesso" data-style="form-control" data-live-search="true" title="Selecione o Nível de Acesso">
                            @foreach($solicitarNivelAcesso as $nivelAcesso)
                                @if($nivelAcesso->id == 1 && Auth::user()->Pessoa->nivelacesso_id != 1)
                                    <option value="{{$nivelAcesso->sigla}}" disabled>{{$nivelAcesso->nome}}</option>
                                @else
                                    <option value="{{$nivelAcesso->sigla}}">{{$nivelAcesso->nome}}</option>
                                @endif
                            @endforeach
                        </select>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
            </form>
        </div>
    </div>
</div>


@endsection

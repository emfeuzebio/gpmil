@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="m-0 text-dark col-sm-6">
        <h1 class="m-0 text-dark"></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">Notificações</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="container">
    <h1>Notificações</h1>

    @if($notifications->isEmpty())
        <div class="alert alert-info">
            Nenhuma notificação encontrada.
        </div>
    @else
        <div class="list-group">
            @foreach($notifications as $notification)
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $notification->data['title'] ?? 'Notificação' }}</h5>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1">{{ $notification->data['message'] ?? 'Você tem uma nova solicitação.' }}</p>
                    <form action="{{ url('pessoas/' . $notification->data['user_id']) }}" method="GET" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Editar seção do usuário</button>
                    </form>
                    <form action="{{ route('encpes.markAsRead', $notification->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Marcar como lida</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

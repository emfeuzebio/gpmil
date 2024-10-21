@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="m-0 text-dark col-sm-6">
            <h1 class="m-0 text-dark"><i class="fas fa-exchange-alt"></i> Autoridades Celotex</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">Autoridades Celotex</li>
            </ol>
        </div>
    </div>
@stop

@section('content')

<div id="app">
    <Autoridades />
</div>
@vite('resources/js/app.js')

@endsection

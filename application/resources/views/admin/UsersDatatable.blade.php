@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="m-0 text-dark col-sm-6">
            <h1 class="m-0 text-dark"></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item ">Administração</li>
                <li class="breadcrumb-item">Cadastros</li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </div>
    </div>
@stop
 
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3 text-left h5"><b>Cadastro de Usuários</b>
                    </div>
                    <div class="col-md-9 text-right">
                        <button id="btnRefresh" class="btn btn-default btn-sm btnRefresh" data-toggle="tooltip" title="Atualizar a tabela (Alt+R)">Refresh</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table table-striped table-bordered table-hover table-sm compact']) }}
            </div>
        </div>
    </div>
    {{ $dataTable->scripts() }}

    <script type="text/javascript">

        /*
        * Refresh button action
        */
        $('#btnRefresh').on("click", function (e) {
            e.stopImmediatePropagation();
            $('#users-table').DataTable().ajax.reload(null, false);    
        });        

    </script>    
@endsection
 
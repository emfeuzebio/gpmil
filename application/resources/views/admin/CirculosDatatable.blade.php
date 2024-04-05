@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Administração</h1>
@stop
 
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header"><b>Gestão de Circulos Militares</b> - Render</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    {{ $dataTable->scripts() }}

    <script type="text/javascript">

        // alert('Estou na Blade' );

    </script>    
    
@endsection
 


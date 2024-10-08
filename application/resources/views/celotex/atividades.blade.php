@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="m-0 text-dark col-sm-6">
            <h1 class="m-0 text-dark"><i class="fas fa-exchange-alt"></i> Atividades Celotex</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">Atividades Celotex</li>
            </ol>
        </div>
    </div>
@stop

@section('content')

<div id="app">

    <Atividades />
</div>

<!-- Carregar Vue e o Script -->
{{-- <script src="https://cdn.jsdelivr.net/npm/vue@3"></script> --}}
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}

@vite('resources/js/app.js')
<script>
    window.atividades = @json($atividades);
</script>
@endsection

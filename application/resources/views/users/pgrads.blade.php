@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table table-bordered']) }}
            </div>
        </div>
    </div>
    {{ $dataTable->scripts() }}

    <script type="text/javascript">

    $("#pgrads-table tbody").delegate('tr td .btnEdit', 'click', function (e) {
        e.stopImmediatePropagation();            

        id = $(this).data("id");
        alert('Editar ID: ' + id );

    });

    function editar() {
        alert('Editar');
        $('#pgrads-table').DataTable().ajax.reload(null, false);
    }

    $('.btnEdit').on("click", function (e) {
        e.stopImmediatePropagation();
        alert('Novo');

        // $('#formEntity').trigger('reset');            //clean de form data
        // $('#form-group-id').hide();                     //hide ID field
        // $('#id').val('');                               // reset ID field
        // $('#modalLabel').html('Novo Gênero de Livro');  //
        // $(".invalid-feedback").text('').hide();         // hide all error displayed
        // $('#edit-modal').modal('show');             // show modal 
    });

    </script>

@endsection
 
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush


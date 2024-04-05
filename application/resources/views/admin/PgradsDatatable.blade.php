@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Administração</h1>
@stop

@section('content')

    @foreach( $circulos as $user )
        <!-- <p> {{$user->id}}" = {{$user->sigla}}</p> -->
    @endforeach

    <!-- DataTables de Dados -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4 text-left"><b>Gestão de Postos e Graduações</b></div>
                        <div class="col-md-5 text-left">
                            <div id="alert" class="alert alert-success fade show" style="padding: 4px 15px 3px 15px; display: none; margin-bottom: 0px; display: true;">
                                <a class="close" onClick="$('.alert').hide()">&times;</a>  
                                <div class="alert-content">mensagens</div>
                            </div>
                        </div>
                        <div class="col-md-3 text-right">
                            <button id="btnRefresh" class=" btn btn-default btn-sm" href="">Refresh</button>
                            <button id="btnNovo" class="btnEdit btn btn-success btn-sm" href="">Inserir Novo</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- compact | stripe | order-column | hover | cell-border | row-border | table-dark-->
                    <table id="datatables" class="table table-striped table-bordered table-hover table-sm compact" style="width:100%">
                        <thead></thead>
                        <tbody></tbody>
                        <tfoot></tfoot>                
                    </table>                 
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Reg -->
    <div class="modal fade" id="edit-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Modal title</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="formEntity" name="formEntity"  action="javascript:void(0)" 
                    class="form-horizontal" method="post">

                        <div class="form-group" id="form-group-id">
                            <label class="form-label">ID</label>
                            <input class="form-control" value="" type="text" id="id" name="id" placeholder="" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Círculo</label>
                            <select name="circulo_id" id="circulo_id" class="form-select">
                                <option value=""> Selecione o Círculo </option>
                                @foreach( $circulos as $circulo )
                                <option value="{{$circulo->id}}">{{$circulo->sigla}}</option>
                                @endforeach
                            </select>
                            <div id="error-circulo_id" class="error invalid-feedback" style="display: none;"></div>
                        </div>                          

                        <div class="form-group">
                            <label class="form-label">Sigla</label>
                            <input class="form-control" value="" type="text" id="sigla" name="sigla" placeholder="" data-toggle="tooltip" data-placement="top" title="Hooray!" >
                            <div id="error-sigla" class="error invalid-feedback" style="display: none;"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Descrição</label>
                            <input class="form-control" value="" type="text" id="descricao" name="descricao" placeholder="" >
                            <div id="error-descricao" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="form-group">    
                        <label class="form-label">Ativo</label>                    
                            <input class="form-control" value="" type="text" id="ativo" name="ativo" placeholder="" >
                            <div id="error-ativo" class="invalid-feedback" style="display: none;"></div>
                        </div>
                </form>        

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="$('#edit-modal').modal('hide');">Fechar</button>
                <button type="button" class="btn btn-primary" id="btnSave">Save</button>
            </div>
            </div>
        </div>
    </div>

    <!-- modal excluir registro -->
    <div class="modal fade" id="confirmaExcluirModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Excluir Registro</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="$('#confirmaExcluirModal').modal('hide');">Fechar</button>
                    <button type="button" class="btn btn-danger" data-toggle="tooltip" title="Confirmar a Exclusão" id="confirm">Excluir</button>
                </div>
            </div>
        </div>
    </div>   

        <div id="loading" class="loading">
            <img id="loading-image" class="loading-image" src="{{ asset('loadingBlocos.gif') }}" alt=""/>
        </div>     

    <!-- javascript com configurações iniciais -->
    <script type="text/javascript" language="javascript" class="init">

        $(document).ready(function () {

            //controla a exibição do Loading da Página
            $("#loading").hide();

            // configura os Modais para terem seu conteúdo limpo ao serem fechados (hide)
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });

            //ativa o tooltip nas páginas
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            // ativa autofocus automático sempre no primeiro input dentro do modal
            $(document).on('shown.bs.modal', function (e) {
                $('select:input:visible:not([readonly]):first', e.target).focus();
            });

            //controla a exibição do Loading dos Ajax
            $(document).on({
                ajaxStart: function () {
                    $("#loading").show();
                },
                ajaxStop: function () {
                    $("#loading").hide();
                }
            });

        });

    </script>

    <script type="text/javascript">

        $(document).ready(function () {

            var id = '';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                }
            });

            /*
            * Create and drow DataTables
            * https://datatables.net/examples/basic_init/data_rendering.html
            * https://yajrabox.com/docs/laravel-datatables/10.0/engine-query
            * https://medium.com/@boolfalse/laravel-yajra-datatables-1847b0cbc680
            */
            $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: true,
                // order: [ 0, 'desc' ],
                lengthMenu: [[5, 10, 15, 30, 50, -1], [5, 10, 15, 30, 50, "Todos"]], 
                ajax: "{{url("pgrad")}}",
                language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },     
                columns: [
                    // { data: 'DT_RowIndex', name: 'DT_RowIndex' }, 
                    {"data": "id", "name": "pgrads.id", "class": "dt-right", "title": "#"},
                    /*
                    *   o parâmetro "name": "xxx" deve conter o nome do método Model->'belongsTo' que criou o relacionamento 
                    *                       seguido da coluna a que se deseja fazer a pesquisa
                    *                       no Controller deve estar o mesmo nome de coluna
                    */
                    // {"data": "circulo", "name": "circulos.sigla", "class": "dt-left", "title": "Círculo"},
                    {"data": "descricao", "name": "pgrads.descricao", "class": "dt-left", "title": "Descrição",
                        render: function (data) { return '<b>' + data + '</b>';}},
                    // {"data": "sigla", "name": "pgrads.sigla", "class": "dt-left", "title": "Sigla"},
                    {"data": "ativo", "name": "pgrads.ativo", "class": "dt-center", "title": "Ativo",  
                        render: function (data) { return '<span style="color:' + ( data == 'SIM' ? 'blue' : 'red') + ';">' + data + '</span>';}
                    },
                    // {"data": "created_at", "name": "created_at", "class": "dt-center", "title": "Criado em"},
                    {"data": "id", "botoes": "", "orderable": false, "class": "dt-center", "title": "Ações", 
                        render: function (data, type) { 
                            return '<button data-id="' + data + '" class="btnEditar btn btn-primary btn-sm" href="">Editar</button>\n<button data-id="' + data + '" class="btnExcluir btn btn-danger btn-sm" href="">Excluir</button>'; 
                        }
                    },
                ]
            });

            /*
            * Delete button action
            */
            $("#datatables tbody").delegate('tr td .btnExcluir', 'click', function (e) {
                e.stopImmediatePropagation();            

                id = $(this).data("id")
                //alert('Editar ID: ' + id );

                //abre Form Modal Bootstrap e pede confirmação da Exclusão do Registro
                $("#confirmaExcluirModal .modal-body p").text('Você está certo que deseja Excluir este registro ID: ' + id + '?');
                $('#confirmaExcluirModal').modal('show');

                //se confirmar a Exclusão, exclui o Registro via Ajax
                $('#confirmaExcluirModal').find('.modal-footer #confirm').on('click', function (e) {
                    e.stopImmediatePropagation();

                    // alert($id);
                    $.ajax({
                        type: "POST",
                        url: "{{url("pgrad/destroy")}}",
                        data: {"id": id},
                        dataType: 'json',
                        success: function (data) {
                            $("#alert .alert-content").text('Excluiu o registro ID ' + id + ' com sucesso.');
                            $('#alert').removeClass().addClass('alert alert-success').show();
                            $('#datatables').DataTable().ajax.reload(null, false);
                        }
                    });
                    $('#confirmaExcluirModal').modal('hide');            
                });

            });           

            /*
            * Edit button action
            */
            $("#datatables tbody").delegate('tr td .btnEditar', 'click', function (e) {
                e.stopImmediatePropagation();            

                const id = $(this).data("id")
                // alert('Editar ID: ' + id );

                $.ajax({
                    type: "POST",
                    url: "{{url("pgrad/edit")}}",
                    data: {"id": id},
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
                        $('#modalLabel').html('Editar Posto e Graduação');
                        $(".invalid-feedback").text('').hide();     //hide and clen all erros messages on the form
                        $('#form-group-id').show();
                        $('#edit-modal').modal('show');         //show the modal

                        // implementar que seja automático foreach   
                        $('#id').val(data.id);
                        $('#circulo_id').val(data.circulo_id);
                        $('#sigla').val(data.sigla);
                        $('#descricao').val(data.descricao);
                        $('#ativo').val(data.ativo);
                    }
                }); 

            });           

            /*
            * Save button action
            */
            $('#btnSave').on("click", function (e) {
                e.stopImmediatePropagation();
                $(".invalid-feedback").text('').hide();    //hide and clean all erros messages on the form

                //to use a button as submit button, is necesary use de .get(0) after
                const formData = new FormData($('#formEntity').get(0));
                // console.log(formData);

                //here there are a problem with de serialize the form
                $.ajax({
                    type: "POST",
                    url: "{{url("pgrad/store")}}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        //console.log(data);
                        $("#alert .alert-content").text('Salvou registro ID ' + data.id + ' com sucesso.');
                        $('#alert').removeClass().addClass('alert alert-success').show();
                        $('#edit-modal').modal('hide');
                        $('#datatables').DataTable().ajax.reload(null, false);
                    },
                    error: function (data) {
                        // validator: vamos exibir todas as mensagens de erro do validador
                        // como o dataType não é JSON, precisa do responseJSON
                        $.each( data.responseJSON.errors, function( key, value ) {
                            //console.log( key + '>' + value );
                            $("#error-" + key ).text(value).show(); //show all error messages
                        });
                    }
                });                
            });

            $('#btnNovo').on("click", function (e) {
                e.stopImmediatePropagation();
                //alert('Novo');

                $('#formEntity').trigger('reset');              //clean de form data
                $('#form-group-id').hide();                     //hide ID field
                $('#id').val('');                               // reset ID field
                $('#modalLabel').html('Novo Posto ou Graduação');  //
                $(".invalid-feedback").text('').hide();         // hide all error displayed
                $('#edit-modal').modal('show');                 // show modal 
            });

            // put the focus on de name field
            $('body').on('shown.bs.modal', '#edit-modal', function () {
                $('#sigla').focus();
            })

        });

        /*
        * Refresh button action
        */
        $('#btnRefresh').on("click", function (e) {
            e.stopImmediatePropagation();
            $('#datatables').DataTable().ajax.reload(null, false);    
        });        

    </script>    

@stop



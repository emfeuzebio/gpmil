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
                <li class="breadcrumb-item active">Destinos</li>
            </ol>
        </div>
    </div>
@stop

@section('content')

    <!-- datatables-destinos de Dados -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <!--área de título da Entidade-->
                        <div class="col-md-3 text-left h5"><b>Cadastro de Destinos</b></div>
                        <!--área de mensagens-->
                        <div class="col-md-6 text-left">
                            <div style="padding: 0px;  background-color: transparent;">
                                <div id="alert" class="alert alert-danger" style="margin-bottom: 0px; display: none; padding: 2px 5px 2px 5px;">
                                    <a class="close" onClick="$('.alert').hide()">&times;</a>  
                                    <div class="alert-content">Mensagem</div>
                                </div>
                            </div>                         
                        </div>
                        <!--área de botões-->
                        <div class="col-md-3 text-right">
                            <button id="btnRefresh" class="btn btn-default btn-sm btnRefresh" data-toggle="tooltip" title="Atualizar a tabela (Alt+R)">Refresh</button>
                            @can('is_admin')
                            <button id="btnNovo" class="btnInserirNovo btn btn-success btn-sm" data-toggle="tooltip" title="Adicionar um novo registro (Alt+N)" >Inserir Novo</button>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- compact | stripe | order-column | hover | cell-border | row-border | table-dark-->
                    <table id="datatables-destinos" class="table table-striped table-bordered table-hover table-sm compact" style="width:100%">
                        <thead></thead>
                        <tbody></tbody>
                        <tfoot></tfoot>                
                    </table>                 
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Registro -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Modal title</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');">&times;</button>
                </div>
                <div class="modal-body">

                    <form id="formEntity" name="formEntity"  action="javascript:void(0)" 
                        class="form-horizontal" method="post">

                            <div class="form-group" id="form-group-id">
                                <label class="form-label">ID</label>
                                <input class="form-control" value="" type="text" id="id" name="id" placeholder="" readonly>
                            </div>                         

                            <div class="form-group">
                                <label class="form-label">Sigla</label>
                                <input class="form-control" value="" type="text" id="sigla" name="sigla" placeholder="Pr Sv" data-toggle="tooltip" title="Digite a sigla do Destino" >
                                <div id="error-sigla" class="error invalid-feedback" style="display: none;"></div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Descrição</label>
                                <input class="form-control" value="" type="text" id="descricao" name="descricao" placeholder="Ex.: Pronto para o Serviço" data-toggle="tooltip" title="Digite o nome do Destino" >
                                <div id="error-descricao" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Ativo</label>
                                <div class="form-check">
                                    <label class="form-label" for="ativo">
                                        <input class="form-check-input" type="checkbox" checked data-toggle="toggle" id="ativo" data-style="ios" data-on="SIM" data-off="NÃO" data-onstyle="primary">
                                    </label>
                                </div>
                                <div id="error-ativo" class="invalid-feedback" style="display: none;"></div>
                            </div>
                    </form>        

                </div>
                <div class="modal-footer">
                    <div class="col-md-5 text-left">
                        <label id="msgOperacaoEditar" class="error invalid-feedback" style="color: red; display: none; font-size: 12px;"></label> 
                    </div>
                    <div class="col-md-5 text-right">
                        <button type="button" class="btn btn-secondary btnCancelar" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');">Cancelar</button>
                        @can('is_admin')
                        <button type="button" class="btn btn-primary btnSalvar" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal excluir registro -->
    <div class="modal fade" id="confirmaExcluirModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Excluir Registro</h4>
                    <button type="button" class="close btnCancelar" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#confirmaExcluirModal').modal('hide');">&times;</button>
                </div>
                <div class="modal-body">
                    <p></p>
                    <label id="msgOperacaoExcluir" class="error invalid-feedback" style="color: red; display: none; font-size: 12px;"></label> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#confirmaExcluirModal').modal('hide');">Cancelar</button>
                    <button type="button" class="btn btn-danger" data-toggle="tooltip" title="Confirmar a Exclusão" id="confirm">Excluir</button>
                </div>
            </div>
        </div>
    </div>    

    <script type="text/javascript">

        $(document).ready(function () {

            let id = '';
            let btnAcoes = '';
            const userNivelAcessoID = {{ Auth::user()->Pessoa->nivelacesso_id }};

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                statusCode: { 401: function() { window.location.href = "/"; } }
            });

            // Admin pode tudo
            @can('is_admin')
                btnAcoes = '<button class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>\n<button class="btnExcluir btn btn-danger btn-sm" data-toggle="tooltip" title="Excluir o registro atual">Excluir</button>'; 
            @else
                btnAcoes = '<button class="btnEditar btn btn-info btn-sm" data-toggle="tooltip" title="Ver os detalhes do registro">Ver</button> ';
            @endcan

            /*
            * Create and drow datatables-destinos
            * https://datatables-destinos.net/examples/basic_init/data_rendering.html
            * https://yajrabox.com/docs/laravel-datatables-destinos/10.0/engine-query
            * https://medium.com/@boolfalse/laravel-yajra-datatables-destinos-1847b0cbc680
            */
            $('#datatables-destinos').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: true,
                order: [ 1, 'asc' ],
                lengthMenu: [[5, 10, 15, 30, 50, -1], [5, 10, 15, 30, 50, "Todos"]], 
                pageLength: 10,
                ajax: "{{url("destinos")}}",
                language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },
                columns: [
                    {"data": "id", "name": "destinos.id", "class": "dt-right", "title": "#"},
                    {"data": "descricao", "name": "destinos.descricao", "class": "dt-left", "title": "Descrição",
                        render: function (data) { return '<b>' + data + '</b>';}},
                    {"data": "sigla", "name": "destinos.sigla", "class": "dt-left", "title": "Sigla"},
                    {"data": "ativo", "name": "destinos.ativo", "class": "dt-center", "title": "Ativo",  
                        render: function (data) { return '<span class="' + ( data == 'SIM' ? 'text-primary' : 'text-danger') + '">' + data + '</span>';}
                    },
                    {"data": "id", "botoes": "", "orderable": false, "class": "dt-center", "title": "Ações", 
                        render: function (data, type) { return btnAcoes; }
                    },
                ]
            });

            function getAtivoValue() {
                return $('#ativo:checked').val() ? 'SIM': 'NÃO';
            }

            /*
            * Delete button action
            */
            $("#datatables-destinos tbody").delegate('tr td .btnExcluir', 'click', function (e) {
                e.stopImmediatePropagation();            

                id = $(this).parents('tr').attr("id");

                //abre Form Modal Bootstrap e pede confirmação da Exclusão do Registro
                $("#confirmaExcluirModal .modal-body p").text('Você está certo que deseja Excluir este registro ID: ' + id + '?');
                $('#confirmaExcluirModal').modal('show');

                //se confirmar a Exclusão, exclui o Registro via Ajax
                $('#confirmaExcluirModal').find('.modal-footer #confirm').on('click', function (e) {
                    e.stopImmediatePropagation();

                    $.ajax({
                        type: "POST",
                        url: "{{url("destinos/destroy")}}",
                        data: {"id": id},
                        dataType: 'json',
                        success: function (data) {
                            $("#alert .alert-content").text('Excluiu o registro ID ' + id + ' com sucesso.');
                            $('#alert').removeClass().addClass('alert alert-success').show().delay(5000).fadeOut(1000);
                            $('#confirmaExcluirModal').modal('hide');
                            $('#datatables-destinos').DataTable().ajax.reload(null, false);
                        },
                        error: function (error) {
                            if (error.responseJSON || error.responseJSON.message || error.statusText === 'Unauthenticated') {
                                window.location.href = "{{ url('/') }}";
                            }
                            if(error.responseJSON.message.indexOf("1451") != -1) {
                                $('#msgOperacaoExcluir').text('Impossível EXCLUIR porque há registros relacionados. (SQL-1451)').show();
                            } else {
                                $('#msgOperacaoExcluir').text(error.responseJSON.message).show();
                            }
                        }
                    });
                    
                });

            });           

            /*
            * Edit button action
            */
            $("#datatables-destinos tbody").delegate('tr td .btnEditar', 'click', function (e) {
                e.stopImmediatePropagation();            

                const id = $(this).parents('tr').attr("id");

                $.ajax({
                    type: "POST",
                    url: "{{url("destinos/edit")}}",
                    data: {"id": id},
                    dataType: 'json',
                    success: function (data) {
                        $('#modalLabel').html('Editar Destino');
                        $(".invalid-feedback").text('').hide();     
                        $('#form-group-id').show();
                        $('#editarModal').modal('show');            

                        // implementar que seja automático foreach   
                        $('#id').val(data.id);
                        $('#sigla').val(data.sigla);
                        $('#descricao').val(data.descricao);
                        $('#ativo').bootstrapToggle(data.ativo == "SIM" ? 'on' : 'off');
                    },
                    error: function (error) {
                        if (error.responseJSON || error.responseJSON.message || error.statusText === 'Unauthenticated') {
                            window.location.href = "{{ url('/') }}";
                        }
                    }
                }); 

            });           

            /*
            * Edit record on doble click
            */
            $("#datatables-destinos tbody").delegate('tr', 'dblclick', function (e) {
                e.stopImmediatePropagation();            

                id = $(this).attr("id");

                $.ajax({
                    type: "POST",
                    url: "{{url("destinos/edit")}}",
                    data: {"id": id},
                    dataType: 'json',
                    success: function (data) {
                        $('#modalLabel').html('Editar Destino');
                        $(".invalid-feedback").text('').hide();     
                        $('#form-group-id').show();
                        $('#editarModal').modal('show');            

                        // implementar que seja automático foreach   
                        $('#id').val(data.id);
                        $('#sigla').val(data.sigla);
                        $('#descricao').val(data.descricao);
                        $('#ativo').bootstrapToggle(data.ativo == "SIM" ? 'on' : 'off');
                    },
                    error: function (error) {
                        if (error.responseJSON || error.responseJSON.message || error.statusText === 'Unauthenticated') {
                            window.location.href = "{{ url('/') }}";
                        }
                    }
                }); 

            });           

            /*
            * Save button action
            */
            $('#btnSave').on("click", function (e) {
                e.stopImmediatePropagation();
                $(".invalid-feedback").text('').hide();    
                var ativoValue = getAtivoValue();

                const formData = new FormData($('#formEntity').get(0));
                formData.append('ativo', ativoValue);

                $.ajax({
                    type: "POST",
                    url: "{{url("destinos/store")}}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $("#alert .alert-content").text('Salvou registro ID ' + data.id + ' com sucesso.');
                        $('#alert').removeClass().addClass('alert alert-success').show().delay(5000).fadeOut(1000);
                        $('#editarModal').modal('hide');
                        $('#datatables-destinos').DataTable().ajax.reload(null, false);
                    },
                    error: function (error) {
                        if (error.responseJSON || error.responseJSON.message || error.statusText === 'Unauthenticated') {
                            window.location.href = "{{ url('/') }}";
                        }
                        // validator: vamos exibir todas as mensagens de erro do validador
                        // como o dataType não é JSON, precisa do responseJSON
                        $.each( error.responseJSON.errors, function( key, value ) {
                            $("#error-" + key ).text(value).show(); 
                        });
                        // exibe mensagem sobre sucesso da operação
                        if(error.responseJSON.message.indexOf("1062") != -1) {
                            $('#msgOperacaoEditar').text("Impossível SALVAR! Registro já existe. (SQL-1062)").show();
                        } else if(error.responseJSON.exception) {
                            $('#msgOperacaoEditar').text(error.responseJSON.message).show();
                        }
                    }
                });                
            });

            /*
            * New Record button action
            */
            $('#btnNovo').on("click", function (e) {
                e.stopImmediatePropagation();

                $('#formEntity').trigger('reset');              // clean de form data
                $('#form-group-id').hide();                     // hide ID field
                $('#id').val('');                               // reset ID field
                $('#modalLabel').html('Novo Destino');          //
                $(".invalid-feedback").text('').hide();         // hide all error displayed
                $('#editarModal').modal('show');                // show modal 
            });

            // put the focus on de name field
            $('body').on('shown.bs.modal', '#editarModal', function () {
                $('#sigla').focus();
            })

            /*
            * Refresh button action
            */
            $('#btnRefresh').on("click", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-destinos').DataTable().ajax.reload(null, false);
                $('#alert').trigger('reset').hide();
            });      

        });

    </script>    

@stop



@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="m-0 text-dark col-sm-6">
            <h1></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item ">Administração</li>
                <li class="breadcrumb-item">Cadastros</li>
                <li class="breadcrumb-item active">Organizações</li>
            </ol>
        </div>
    </div>
@stop

@section('content')

    <!-- DataTables de Dados -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3 text-left h5"><b>Cadastro da Organização Militar</b></div>
                        
                        <!--área de mensagens-->
                        <div class="col-md-6 text-left">
                            <div style="padding: 0px;  background-color: transparent;">
                                <div id="alert" class="alert alert-danger" style="margin-bottom: 0px; display: none; padding: 2px 5px 2px 5px;">
                                    <a class="close" onClick="$('.alert').hide()">&times;</a>  
                                    <div class="alert-content">Mensagem</div>
                                </div>
                            </div>                         
                        </div>
                                                
                        <div class="col-md-3 text-right">
                            <button id="btnRefresh" class="btn btn-default btn-sm btnRefresh" data-toggle="tooltip" title="Atualizar a tabela (Alt+R)">Refresh</button>
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
                            <input class="form-control" value="" type="text" id="sigla" name="sigla" placeholder="S1" data-toggle="tooltip" title="Digite a sigla da Seção" >
                            <div id="error-sigla" class="error invalid-feedback" style="display: none;"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Descrição</label>
                            <input class="form-control" value="" type="text" id="descricao" name="descricao" placeholder="Ex.: 1ª Seção" data-toggle="tooltip" title="Digite o nome da Seção" >
                            <div id="error-descricao" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ativo</label>
                            <div class="form-check">
                                <label class="form-label" for="ativo">
                                    <input class="form-check-input" type="checkbox" data-toggle="toggle" id="ativo" data-style="ios" data-onstyle="primary" data-on="SIM" data-off="NÃO">
                                </label>
                            </div>
                            <div id="error-ativo" class="invalid-feedback" style="display: none;"></div>
                        </div>
                </form>        

            </div>
            <div class="modal-footer">
                <div class="col-md-5 text-left">
                    <label id="msgOperacao" class="error invalid-feedback" style="color: red; display: none; font-size: 12px;"></label> 
                </div>
                <div class="col-md-5 text-right">
                    <button type="button" class="btn btn-secondary btnCancelar" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');">Cancelar</button>
                    @can('is_admin')
                    <button type="button" class="btn btn-primary btnSalvar" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                    @endcan
                    @can('is_encpes')
                    <button type="button" class="btn btn-primary btnSalvar" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                    @endcan
                    @can('is_cmt')
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
                    <button type="button" class="close" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#confirmaExcluirModal').modal('hide');">&times;</button>
                </div>
                <div class="modal-body">
                    <p></p>
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

            var id = '';

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                statusCode: { 401: function() { window.location.href = "/";} }
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
                ajax: "{{url("organizacaos")}}",
                language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },     
                columns: [
                    {"data": "id", "name": "organizacaos.id", "class": "dt-right", "title": "#"},
                    {"data": "descricao", "name": "organizacaos.descricao", "class": "dt-left", "title": "Descrição",
                        render: function (data) { return '<b>' + data + '</b>';}},
                    {"data": "sigla", "name": "organizacaos.sigla", "class": "dt-left", "title": "Sigla"},
                    {"data": "ativo", "name": "organizacaos.ativo", "class": "dt-center", "title": "Ativo",  
                        render: function (data) { return '<span class="' + ( data == 'SIM' ? 'text-primary' : 'text-danger') + '">' + data + '</span>';}
                    },
                    {"data": "id", "botoes": "", "orderable": false, "class": "dt-center", "title": "Ações", 
                        render: function (data, type) { 
                            return '<button data-id="' + data + '" class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>'; 
                        }
                    },
                ]
            });

            function getAtivoValue() {
                if ($('input[id="ativo"]:checked').val()) {
                    return 'SIM';
                } else {
                    return 'NÃO';
                }
            }

            /*
            * Edit button action
            */
            $("#datatables tbody").delegate('tr td .btnEditar', 'click', function (e) {
                e.stopImmediatePropagation();            

                const id = $(this).data("id")
                // alert('Editar ID: ' + id );

                $.ajax({
                    type: "POST",
                    url: "{{url("organizacaos/edit")}}",
                    data: {"id": id},
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
                        $('#modalLabel').html('Editar Seção');
                        $(".invalid-feedback").text('').hide();     //hide and clen all erros messages on the form
                        $('#form-group-id').show();
                        $('#editarModal').modal('show');         //show the modal

                        // implementar que seja automático foreach   
                        $('#id').val(data.id);
                        $('#sigla').val(data.sigla);
                        $('#descricao').val(data.descricao);
                        if (data.ativo === "SIM") {
                            $('#ativo').bootstrapToggle('on');
                        } else if (data.ativo === "NÃO") {
                            $('#ativo').bootstrapToggle('off');
                        }
                    },
                    error: function (error) {
                        if (error.responseJSON === 401 || error.responseJSON.message && error.statusText === 'Unauthenticated') {
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
                $(".invalid-feedback").text('').hide();    //hide and clean all erros messages on the form
                var ativoValue = getAtivoValue();

                //to use a button as submit button, is necesary use de .get(0) after
                const formData = new FormData($('#formEntity').get(0));
                // console.log(formData);
                formData.append('ativo', ativoValue);

                //here there are a problem with de serialize the form
                $.ajax({
                    type: "POST",
                    url: "{{url("organizacaos/store")}}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        //console.log(data);
                        $("#alert .alert-content").text('Salvou registro ID ' + data.id + ' com sucesso.');
                        $('#alert').removeClass().addClass('alert alert-success').show().delay(5000).fadeOut(1000);
                        $('#editarModal').modal('hide');
                        $('#datatables').DataTable().ajax.reload(null, false);
                    },
                    error: function (error) {
                        if (error.responseJSON === 401 || error.responseJSON.message && error.statusText === 'Unauthenticated') {
                            window.location.href = "{{ url('/') }}";
                        }
                        // validator: vamos exibir todas as mensagens de erro do validador
                        // como o dataType não é JSON, precisa do responseJSON
                        $.each( error.responseJSON.errors, function( key, value ) {
                            //console.log( key + '>' + value );
                            $("#error-" + key ).text(value).show(); //show all error messages
                        });
                        $('#msgOperacao').text(error.responseJSON.message).show();
                    }
                });                
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
                $.ajax({
                    url: '/isAuthenticated',
                    method: 'GET',
                    success: function(response) {
                        if (!response.authenticated) window.location.href = "{{ url('/') }}";
                    },
                    error: function(jqXHR) {
                        if (jqXHR.status === 401) window.location.href = "{{ url('/') }}";
                    }
                });
                $('#datatables').DataTable().ajax.reload(null, false);    
                $('#alert').trigger('reset').hide();
            });        

        });

    </script>    

@stop



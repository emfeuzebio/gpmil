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
                <li class="breadcrumb-item active">P/Graduações</li>
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
                        <!--área de título da Entidade-->
                        <div class="col-md-4 text-left h5"><b>Cadastro de Postos e Graduações</b></div>
                        <!--área de mensagens-->
                        <div class="col-md-5 text-left">
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

    <!-- Modal Editiar Registro -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Modal title</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <form id="formEntity" name="formEntity"  action="javascript:void(0)" class="form-horizontal" method="post">

                            <div class="form-group" id="form-group-id">
                                <label class="form-label">ID</label>
                                <input class="form-control" value="" type="text" id="id" name="id" placeholder="" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Círculo</label>
                                <select name="circulo_id" id="circulo_id" class="form-control selectpicker" data-live-search="true" data-toggle="tooltip" data-placement="top" title="Selecione o Círculo">
                                    <option value=""> Selecione o Círculo </option>
                                    @foreach( $circulos as $circulo )
                                    <option value="{{$circulo->id}}">{{$circulo->sigla}}</option>
                                    @endforeach
                                </select>
                                <div id="error-circulo_id" class="error invalid-feedback" style="display: none;"></div>
                            </div>                          

                            <div class="form-group">
                                <label class="form-label">Sigla</label>
                                <input class="form-control" value="" type="text" id="sigla" name="sigla" placeholder="EX.:Al EPC" data-toggle="tooltip" data-placement="top" title="Digite a Sigla da Instituição" >
                                <div id="error-sigla" class="error invalid-feedback" style="display: none;"></div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Descrição</label>
                                <input class="form-control" value="" type="text" id="descricao" name="descricao" placeholder="Ex.:Aluno EsPCEx" data-toggle="tooltip" title="Digite a Descrição" >
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
                            <label id="msgOperacaoEditar" class="error invalid-feedback" style="color: red; display: none; font-size: 12px;"></label> 
                        </div>
                        <div class="col-md-5 text-right">
                            <button type="button" class="btn btn-secondary btnCancelar" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');">Cancelar</button>
                            @can('is_admin')
                            <button type="button" class="btn btn-primary btnSalvar" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                            @endcan
                            @can('is_encpes')
                            <button type="button" class="btn btn-primary btnSalvar" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function () {

            var id = '';

            // send token
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

            /*
            * Definitios of DataTables render
            */
            $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: true,
                order: [[4,'asc'],[ 0,'asc']],
                lengthMenu: [[5, 10, 15, 30, 50, -1], [5, 10, 15, 30, 50, "Todos"]], 
                pageLength: 10,
                ajax: "{{url("pgrads")}}",
                language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },     
                columns: [
                    {"data": "id", "name": "pgrads.id", "class": "dt-right", "title": "#"},
                    {"data": "circulo", "name": "circulo.sigla", "class": "dt-left", "title": "Círculo"},
                    {"data": "descricao", "name": "pgrads.descricao", "class": "dt-left", "title": "Descrição",
                        render: function (data) { return '<b>' + data + '</b>';}},
                    {"data": "sigla", "name": "pgrads.sigla", "class": "dt-left", "title": "Sigla"},
                    {"data": "ativo", "name": "pgrads.ativo", "class": "dt-center", "title": "Ativo",  
                        render: function (data) { return '<span style="color:' + ( data == 'SIM' ? 'blue' : 'red') + ';">' + data + '</span>';}
                    },
                    {"data": "id", "botoes": "", "orderable": false, "class": "dt-center", "title": "Ações", 
                        render: function (data, type) { 
                            return '<button data-id="' + data + '" class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>'; 
                        }
                    },
                ]
            });

            function getAtivoValue() {
                return $('#ativo:checked').val() ? 'SIM': 'NÃO';
            }

            /*
            * Edit button action
            */
            $("#datatables tbody").delegate('tr td .btnEditar', 'click', function (e) {
                e.stopImmediatePropagation();            

                const id = $(this).data("id")

                $.ajax({
                    type: "POST",
                    url: "{{url("pgrads/edit")}}",
                    data: {"id": id},
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
                        $('#modalLabel').html('Editar Posto e Graduação');
                        $(".invalid-feedback").text('').hide();     //hide and clen all erros messages on the form
                        $('#form-group-id').show();
                        $('#editarModal').modal('show');         //show the modal

                        // implementar que seja automático foreach   
                        $('#id').val(data.id);
                        $('#circulo_id').selectpicker('val', data.circulo_id);
                        $('#sigla').val(data.sigla);
                        $('#descricao').val(data.descricao);
                        $('#ativo').bootstrapToggle(data.ativo == "SIM" ? 'on' : 'off');
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
                    url: "{{url("pgrads/store")}}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        //console.log(data);
                        $("#alert .alert-content").text('Salvou registro ID ' + data.id + ' com sucesso.');
                        $('#alert').removeClass().addClass('alert alert-success').show();
                        $('#editarModal').modal('hide');
                        $('#datatables').DataTable().ajax.reload(null, false);
                    },
                    error: function (data) {
                        // validator: vamos exibir todas as mensagens de erro do validador, como dataType não é JSON, precisa do responseJSON
                        $.each( data.responseJSON.errors, function( key, value ) {
                            $("#error-" + key ).text(value).show(); //show all error messages
                        });
                        // exibe mensagem sobre sucesso da operação
                        if(data.responseJSON.message.indexOf("1062") != -1) {
                            $('#msgOperacaoEditar').text("Impossível SALVAR! Registro já existe. (SQL-1062)").show();
                        } else if(data.responseJSON.exception) {
                            $('#msgOperacaoEditar').text(data.responseJSON.message).show();
                        }
                    }
                });                
            });

            // put the focus on de name field
            $('body').on('shown.bs.modal', '#editarModal', function () {
                $('#circulo_id').focus();
            })

        });

        /*
        * Refresh button action
        */
        $('#btnRefresh').on("click", function (e) {
            e.stopImmediatePropagation();
            $('#datatables').DataTable().ajax.reload(null, false);    
            $('#alert').trigger('reset').hide();
        });        

    </script>    

@stop



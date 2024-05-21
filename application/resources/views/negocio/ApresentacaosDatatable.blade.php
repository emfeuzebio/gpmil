@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="m-0 text-dark col-sm-6">
            <h1 class="m-0 text-dark"></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">Apresentações</li>
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
                        <div class="col-md-3 text-left h5"><b>Apresentações</b></div>
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
                            @can('PodeInserirApresentacao','App\Models\Apresentacao')
                            <button id="btnNovo" class="btnInserirNovo btn btn-success btn-sm" data-toggle="tooltip" title="Adicionar um novo registro (Alt+N)" >Inserir Novo</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    <!--área de Filtros-->
                    <div class="row">
                        <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px; background-color: transparent;"> -->
                            <div class="col-md-4 form-group" style="margin-bottom: 0px;">
                                <label class="form-label">Filtro pela Seção</label>
                                <select id="filtro_secao" name="filtro_secao" class="form-control" data-toggle="tooltip" title="Selecione para filtrar">
                                    <option value=""> Todas Seções </option>
                                    @foreach( $secoes as $secao )
                                    <option value="{{$secao->sigla}}">{{$secao->sigla}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group" style="margin-bottom: 0px;">
                                <label class="form-label">Filtro pelo Motivo</label>
                                <select id="filtro_destino" name="filtro_destino" class="form-control" data-toggle="tooltip" title="Selecione para filtrar">
                                <option value=""> Todos Motivos </option>
                                    @foreach( $destinos as $destino )
                                    <option value="{{$destino->id}}">{{$destino->sigla}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group" style="margin-bottom: 0px;">
                                <label class="form-label">Filtro por Publicado</label>
                                <select id="filtro_publicado" name="destino" class="form-control" data-toggle="tooltip" title="Selecione para filtrar">
                                    <option value=""> Publicados ou não </option>
                                    <option value="SIM">SIM</option>
                                    <option value="NÃO">NÃO</option>
                                </select>
                            </div>
                        <!-- </div> -->
                    </div>
                </div>

                <div class="card-body">
                    <!-- compact | stripe | order-column | hover | cell-border | row-border | table-dark-->
                    <table id="datatables-apresentacao" class="table table-striped table-bordered table-hover table-sm compact" style="width:100%">
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
                    <button type="button" class="close" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');">&times;</button>
                </div>
                <div class="modal-body">

                    <form id="formEntity" name="formEntity"  action="javascript:void(0)" class="form-horizontal" method="post">

                        <div class="form-group" id="form-group-id">
                            <label class="form-label">ID</label>
                            <input class="form-control" value="" type="text" id="id" name="id" placeholder="" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pessoa</label>
                            <select name="pessoa_id" id="pessoa_id" class="form-control selectpicker" data-live-search="true" data-toggle="tooltip" title="Informe a Pessoa que esta se Apresentando">
                                <option value=""> Selecione a Pessoa </option>
                                @foreach( $pessoas as $pessoa )
                                <option value="{{$pessoa->id}}">{{$pessoa->pgrad->sigla}} {{$pessoa->nome_guerra}}</option>
                                @endforeach
                            </select>
                            <div id="error-pessoa_id" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Motivo</label>
                            <select name="destino_id" id="destino_id" class="form-control selectpicker" data-live-search="true" data-toggle="tooltip" title="Informe o Motivo da Apresentação">
                                @foreach( $destinos as $destino )
                                <option value="{{$destino->id}}">{{$destino->descricao}}</option>
                                @endforeach
                            </select>
                            <div id="error-destino_id" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Data Inicial</label>
                            <input class="form-control" value="" type="date" id="dt_inicial" name="dt_inicial" placeholder="" data-toggle="tooltip" title="Informe a Data Inicial">
                            <div id="error-dt_inicial" class="error invalid-feedback" style="display: none;"></div>
                        </div>    

                        <div class="form-group">
                            <label class="form-label">Data Final</label>
                            <input class="form-control" value="" type="date" id="dt_final" name="dt_final" placeholder="" data-toggle="tooltip" title="Informe a Data Final">
                            <div id="error-dt_final" class="error invalid-feedback" style="display: none;"></div>
                        </div>    

                        <div class="form-group">
                            <label class="form-label">Local de Destino</label>
                            <input class="form-control" value="" type="text" id="local_destino" name="local_destino" placeholder="Ex.: Salvador-BA" data-toggle="tooltip" title="Informe o Local de Destino">
                            <div id="error-local_destino" class="error invalid-feedback" style="display: none;"></div>
                        </div>    

                        <div class="form-group">
                            <label class="form-label">Fone para Contato</label>
                            <input class="form-control" value="" type="text" id="celular" name="celular" placeholder="Ex.: (61) 90000-0000" data-toggle="tooltip" title="Informe um celular para contato">
                            <div id="error-celular" class="error invalid-feedback" style="display: none;"></div>
                        </div>                          
                        
                        <div class="form-group">
                            <label class="form-label">Observação</label>                    
                            <input class="form-control" value="" type="text" id="observacao" name="observacao" placeholder="Ex.: visita à família" data-toggle="tooltip" title="Informe alguma observacao pertinente">
                            <div id="error-observacao" class="invalid-feedback" style="display: none;"></div>
                        </div>

                        <input class="form-control" value="NÃO" type="hidden" id="publicado" name="publicado" placeholder="Ex.: visita à família" data-toggle="tooltip" title="Informe se está publicado">
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
                        @can('is_sgtte')
                        <button type="button" class="btn btn-primary btnSalvar" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                        @endcan
                        @can('is_usuario')
                        <button type="button" class="btn btn-primary btnSalvar" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Homologar Registro -->
    <div class="modal fade" id="confirmahomologarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Publicar Apresentação</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#confirmaExcluirModal').modal('hide');" aria-label="Cancelar">&times;</button>
                </div>
                <div class="modal-body">
                    <p></p>
                    <form id="formEntity" name="formEntity"  action="javascript:void(0)" class="form-horizontal" method="post">

                        <div class="form-group">
                            <label class="form-label">Selecione o Boletim de Publicação</label>
                            <select name="boletim_id" id="boletim_id" class="form-control">
                                <option value=""> Cancelar a Publicação </option>
                                @foreach( $boletins as $boletim )
                                <option value="{{$boletim->id}}">{{$boletim->descricao}}, de {{$boletim->data}}</option>
                                @endforeach
                            </select>
                            <div id="error-sigla" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                    </form>                      

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#confirmahomologarModal').modal('hide');">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnHomologar" data-toggle="tooltip" title="Publicar a Apresentação atual (Alt+S)">Salvar</button>
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

        //variável global que recebe o ID do registro
        var id = '';
        var descricao = '';        

        $(document).ready(function () {

            // definitions of filds mask
            $('#celular').inputmask('(99) 99999-9999');

            // send token
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            /*
            * Definitios of DataTables render
            */
            $('#datatables-apresentacao').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{url("apresentacaos")}}",
                    data: {"paramFixo": "1" },
                },
                responsive: true,
                autoWidth: true,
                order: [ [8, 'desc'],[4, 'asc'] ],  //não publicados acima, depois em ordem de dt inicial
                lengthMenu: [[5, 10, 15, 30, 50, -1], [5, 10, 15, 30, 50, "Todos"]], 
                pageLength: 10,
                language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },
                columns: [
                    {"data": "id", "name": "apresentacaos.id", "class": "dt-right", "title": "#"},
                    {"data": "secao", "name": "secao.sigla", "class": "dt-left", "title": "Seção"}, //se a secao_id estiver na prórpria apresentacao
                    {"data": "pessoa", "name": "pessoa.nome_guerra", "class": "dt-left", "title": "P/G Pessoa"},
                    {"data": "destino", "name": "destino.sigla", "class": "dt-left", "title": "Motivo",
                        render: function (data) { return '<b>' + data + '</b>';}},
                    {"data": "dt_inicial", "name": "apresentacaos.dt_inicial", "class": "dt-center", "title": "Dt Início"},
                    {"data": "dt_final", "name": "apresentacaos.dt_final", "class": "dt-center", "title": "Dt Fim"},
                    {"data": "local_destino", "name": "apresentacaos.local_destino", "class": "dt-left", "title": "Local"},
                    {"data": "celular", "name": "apresentacaos.celular", "class": "dt-left", "title": "Contato"},
                    {"data": "publicado", "name": "apresentacaos.publicado", "class": "dt-center", "title": "Publ",
                        render: function (data) { return '<span class="' + ( data == 'SIM' ? 'text-primary' : 'text-danger') + '">' + data + '</span>';}
                    },
                    {"data": "boletim", "name": "boletim.descricao", "class": "dt-left", "title": "Bol Pub"},
                    {"data": "acoes", "name": "acoes", "class": "dt-left", "title": "Ações", "orderable": false, "width": "190px", "sortable": false},
                ]
            });

            // https://www.youtube.com/watch?v=e-HA2YQUoi0
            // Filtro - Ao mudar a Seção em filtro_secao, aplica filtro pela coluna 1
            $('#filtro_secao').on("change", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-apresentacao').DataTable().column('1').search( $(this).val() ).draw();
            });        
            
            // Filtro - Ao mudar o Motivo em filtro_destino, aplica filtro pela coluna 1
            $('#filtro_destino').on("change", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-apresentacao').DataTable().column('3').search( $(this).val() ).draw();
            });        
            
            // Filtro - Ao mudar o Publicado em filtro_publicado, aplica filtro pela coluna 1
            $('#filtro_publicado').on("change", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-apresentacao').DataTable().column('8').search( $(this).val() ).draw();
            });        

            /*
            * Delete button action
            */
            $("#datatables-apresentacao tbody").delegate('tr td .btnExcluir', 'click', function (e) {
                e.stopImmediatePropagation();            

                // id = $(this).data("id")
                let id = $(this).parents('tr').attr("id");
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
                        url: "{{url("apresentacaos/destroy")}}",
                        data: {"id": id},
                        dataType: 'json',
                        success: function (data) {
                            $("#alert .alert-content").text('Excluiu o registro ID ' + id + ' com sucesso.');
                            $('#alert').removeClass().addClass('alert alert-success').show();
                            $('#confirmaExcluirModal').modal('hide');            
                            $('#datatables-apresentacao').DataTable().ajax.reload(null, false);
                        },
                        error: function (data) {
                            if(data.responseJSON.message.indexOf("1451") != -1) {
                                $('#msgOperacaoExcluir').text('Impossível EXCLUIR porque há registros relacionados. (SQL-1451)').show();
                            } else {
                                $('#msgOperacaoExcluir').text(data.responseJSON.message).show();
                            }
                        }
                    });
                });

            });           

            /*
            * Homologar button action
            */
            $("#datatables-apresentacao tbody").delegate('tr td .btnHomologar', 'click', function (e) {
                e.stopImmediatePropagation();            

                var id = $(this).parents('tr').attr("id");
                // alert('btnHomologar ID: ' + id );

                //abre Form Modal Bootstrap e pede confirmação da Exclusão do Registro
                $("#confirmahomologarModal .modal-body p").text('Você está certo que deseja Publicar a Apresentação ID: ' + id + '?');
                $('#confirmahomologarModal').modal('show');

                //se confirmar a Homologação, exclui o Registro via Ajax
                $('#confirmahomologarModal').find('.modal-footer #btnHomologar').on('click', function (e) {
                    e.stopImmediatePropagation();

                    let boletim_id = $("#boletim_id").val();
                    // alert('id' + id + '; boletim_id: ' + boletim_id );

                    $.ajax({
                        type: "POST",
                        url: "{{url("apresentacaos/homologar")}}",
                        data: { "id":id, "boletim_id":boletim_id},
                        dataType: 'json',
                        async: false,
                        cache: false,                        
                        success: function (data) {
                            $("#alert .alert-content").text('Publicou a Apresentação ID ' + id + ' com sucesso.');
                            $('#alert').removeClass().addClass('alert alert-success').show();
                            $("#boletim_id").val('');
                            $('#confirmahomologarModal').modal('hide');      
                            $('#datatables-apresentacao').DataTable().ajax.reload(null, false);
                        },
                        error: function (data) {
                            if(data.responseJSON.message.indexOf("1451") != -1) {
                                $('#msgOperacaoExcluir').text('Impossível EXCLUIR porque há registros relacionados. (SQL-1451)').show();
                            } else {
                                $('#msgOperacaoExcluir').text(data.responseJSON.message).show();
                            }
                        }
                    });
                });                     
                
            });

            /*
            * Edit button action
            */
            $("#datatables-apresentacao tbody").delegate('tr td .btnEditar', 'click', function (e) {
                e.stopImmediatePropagation();            

                let id = $(this).parents('tr').attr("id");
                //alert('Editar ID: ' + id );

                $.ajax({
                    type: "POST",
                    url: "{{url("apresentacaos/edit")}}",
                    data: {"id": id},
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
                        $('#modalLabel').html('Editar Apresentação');
                        $(".invalid-feedback").text('').hide();     //hide and clen all erros messages on the form
                        $('#form-group-id').show();
                        $('#editarModal').modal('show');         //show the modal

                        // implementar que seja automático foreach   
                        $('#id').val(data.id);
                        $('#pessoa_id').selectpicker('val', data.pessoa_id);
                        $('#destino_id').selectpicker('val', data.destino_id);
                        $('#boletim_id').val(data.boletim_id);
                        $('#dt_inicial').val(data.dt_inicial);
                        $('#dt_final').val(data.dt_final);
                        $('#local_destino').val(data.local_destino);
                        $('#celular').val(data.celular);
                        $('#observacao').val(data.observacao);
                        $('#publicado').val(data.publicado);
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
                    url: "{{url("apresentacaos/store")}}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        //console.log(data);
                        $("#alert .alert-content").text('Salvou registro ID ' + data.id + ' com sucesso.');
                        $('#alert').removeClass().addClass('alert alert-success').show();
                        $('#editarModal').modal('hide');
                        $('#datatables-apresentacao').DataTable().ajax.reload(null, false);
                    },
                    error: function (data) {
                        // validator: vamos exibir todas as mensagens de erro do validador
                        // como o dataType não é JSON, precisa do responseJSON
                        $.each( data.responseJSON.errors, function( key, value ) {
                            //console.log( key + '>' + value );
                            $("#error-" + key ).text(value).show(); //show all error messages
                        });
                        // mostra mensagens de erro de Roles e Persistência em Banco
                        $('#msgOperacao').text(data.responseJSON.policyError).show();
                        $('#msgOperacaoExcluir').text(data.responseJSON.message).show();
                    }
                });                
            });

            /*
            * New Record button action
            */
            $('#btnNovo').on("click", function (e) {
                e.stopImmediatePropagation();

                $('#formEntity').trigger('reset');              //clean de form data
                $('#form-group-id').hide();                     //hide ID field
                $('#id').val('');                               // reset ID field
                $('#modalLabel').html('Nova Apresentação');     //
                $(".invalid-feedback").text('').hide();         // hide all error displayed
                $('#editarModal').modal('show');                // show modal 
            });

            // put the focus on de name field
            $('body').on('shown.bs.modal', '#editarModal', function () {
                $('#pessoa_id').focus();
            })

            /*
            * Refresh button action
            */
            $('#btnRefresh').on("click", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-apresentacao').DataTable().ajax.reload(null, false);
                $('#alert').trigger('reset').hide();
            });        

        });

    </script>    

@stop


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
                            <div class="col-md-3 form-group" style="margin-bottom: 0px;">
                                <label class="form-label">Filtro por Militar</label>
                                <select id="filtro_pessoa" name="filtro_pessoa" class="form-control selectpicker" data-live-search="true" data-style="form-control" data-toggle="tooltip" title="Selecione para filtrar">
                                    <option value=""> Todas os Militares </option>
                                    @foreach( $pessoas as $pessoa )
                                    <option value="{{$pessoa->nome_guerra}}">{{$pessoa->pgrad->sigla}} {{$pessoa->nome_guerra}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group" style="margin-bottom: 0px;">
                                <label class="form-label">Filtro pela Seção</label>
                                <select id="filtro_secao" name="filtro_secao" class="form-control selectpicker" data-live-search="true" data-style="form-control" data-toggle="tooltip" title="Selecione para filtrar">
                                    <option value=""> Todas Seções </option>
                                    @foreach( $secoes as $secao )
                                    <option value="{{$secao->sigla}}">{{$secao->sigla}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group" style="margin-bottom: 0px;">
                                <label class="form-label">Filtro pelo Motivo</label>
                                <select id="filtro_destino" name="filtro_destino" class="form-control selectpicker" data-live-search="true" data-style="form-control" data-toggle="tooltip" title="Selecione para filtrar">
                                <option value=""> Todos Motivos </option>
                                    @foreach( $destinos as $destino )
                                    <option value="{{$destino->sigla}}">{{$destino->sigla}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group" style="margin-bottom: 0px;">
                                <label class="form-label">Filtro por Publicado</label>
                                <select id="filtro_publicado" name="destino" class="form-control selectpicker" data-live-search="true" data-style="form-control" data-toggle="tooltip" title="Selecione para filtrar">
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
    <div class="modal fade" id="editarModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
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
                            <label class="form-label"><span style="color:red">Selecione a Pessoa</span></label>
                            <select name="pessoa_id" id="pessoa_id" class="form-control selectpicker" data-style="form-control" data-live-search="true" data-toggle="tooltip" title="Informe a Pessoa que esta se Apresentando">
                                <option value=""> Selecione a Pessoa </option>
                                @foreach( $pessoas as $pessoa )
                                <option value="{{$pessoa->id}}">{{$pessoa->pgrad->sigla}} {{$pessoa->nome_guerra}}</option>
                                @endforeach
                            </select>
                            <div id="error-pessoa_id" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nota</label>
                            <div id="nota" class="alert alert-default d-flex justify-content-between align-items-center"><i id="notaIcon"></i></div>
                            
                        </div>

                        <div id="dadosForm" style="display: none">
                            <div class="form-group">
                                <label class="form-label">Motivo</label>
                                <select name="destino_id" id="destino_id" class="form-control selectpicker" data-style="form-control" data-live-search="true" data-toggle="tooltip" title="Informe o Motivo da Apresentação">
                                    @foreach( $destinos as $destino )
                                    <option value="{{$destino->id}}">{{$destino->descricao}}</option>
                                    @endforeach
                                </select>
                                <div id="error-destino_id" class="error invalid-feedback" style="display: none;"></div>
                                <input value="" type="hidden" id="destino_input" name="destino_id" disabled>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Data da Apresentação</label>
                                <input class="form-control" value="" type="date" id="dt_apres" name="dt_apres" maxlength="10" data-toggle="tooltip" title="Data da Apresentação" readonly>
                                <div id="error-dt_apres" class="error invalid-feedback" style="display: none;"></div>
                            </div>    

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Data Inicial</label>
                                        <input class="form-control" value="" type="date" id="dt_inicial" name="dt_inicial" maxlength="10" data-toggle="tooltip" title="Informe a Data Inicial">
                                        <div id="error-dt_inicial" class="error invalid-feedback" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Quantidade de Dias</label>
                                        <input class="form-control" value="" type="number" id="qtd_dias" name="qtd_dias" data-toggle="tooltip" title="Informe a Quantidade de Dias">
                                        <div id="error-qtd_dias" class="error invalid-feedback" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Data Final</label>
                                <input class="form-control" value="" type="date" id="dt_final" name="dt_final" data-toggle="tooltip" title="Informe a Data Final" readonly>
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
                                <input class="form-control" value="" type="text" id="observacao" name="observacao" placeholder="Ex.: visita à família" data-toggle="tooltip" title="Informe alguma observação pertinente">
                                <div id="error-observacao" class="invalid-feedback" style="display: none;"></div>
                            </div>

                            <input class="form-control" value="NÃO" type="hidden" id="publicado" name="publicado">

                            <input class="form-control" value="" type="hidden" id="apresentacao_id" name="apresentacao_id">
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
    <div class="modal fade" id="confirmahomologarModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Publicar Apresentação</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#confirmaExcluirModal').modal('hide');" aria-label="Cancelar">&times;</button>
                </div>
                <div class="modal-body">
                    <p></p>
                    <form id="formHomologar" name="formHomologar"  action="javascript:void(0)" class="form-horizontal" method="post">

                        <div class="form-group">
                            <label class="form-label">Selecione o Boletim de Publicação</label>
                            <select name="boletim_id" id="boletim_id" class="form-control selectpicker" data-style="form-control" data-live-search="true">
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

        // variável global que recebe o ID do registro
        var id = '';
        var descricao = '';        

        $(document).ready(function () {

            $('#dt_inicial, #destino_id').on('change', function() {
                preencherQuantidadeDias();
                calcularDataFinal();
            });

            $('#qtd_dias').on('input', function() {
                calcularDataFinal();
            });

            function preencherQuantidadeDias() {
                const dataInicial = $('#dt_inicial').val();
                const selectedValue = $('#destino_id').val();
                let qtdDias = 0;

                if (dataInicial) {
                    switch (selectedValue) {
                        case '2':
                            qtdDias = 30;
                            $('#qtd_dias').prop('readonly', true);
                            break;
                        case '4':
                            qtdDias = 15;
                            $('#qtd_dias').prop('readonly', true);
                            break;
                        case '5':
                            qtdDias = 20;
                            $('#qtd_dias').prop('readonly', true);
                            break;
                        case '6':
                            qtdDias = 10;
                            $('#qtd_dias').prop('readonly', true);
                            break;
                        default:
                        $('#qtd_dias').prop('readonly', false);
                        break;
                    }

                    if (qtdDias > 0) {
                        $('#qtd_dias').val(qtdDias);
                    }
                }
            }

            function calcularDataFinal() {
                const dataInicial = $('#dt_inicial').val();
                const qtdDias = $('#qtd_dias').val();

                if (dataInicial && qtdDias) {
                    const data = new Date(dataInicial);
                    data.setDate(data.getDate() + parseInt(qtdDias));

                    const ano = data.getFullYear();
                    const mes = String(data.getMonth() + 1).padStart(2, '0');
                    const dia = String(data.getDate()).padStart(2, '0');

                    $('#dt_final').val(`${ano}-${mes}-${dia}`);
                }
            }

            // máscara dos campos
            $('#celular').inputmask('(99) 99999-9999');

            // Obtém a data atual no formato YYYY-MM-DD
            const today = new Date().toISOString().slice(0, 10);
            


            // token da página
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            /*
            * Definitios of DataTables render
            * https://datatables.net/examples/basic_init/data_rendering.html
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
                // order: [ [8, 'desc'],[4, 'asc'] ],  // não publicados acima, depois em ordem de dt inicial
                lengthMenu: [[5, 10, 15, 30, 50, -1], [5, 10, 15, 30, 50, "Todos"]], 
                pageLength: 15,
                language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },
                columns: [
                    {"data": "id", "name": "apresentacaos.id", "class": "dt-right", "title": "#"},
                    {"data": "secao", "name": "secao.sigla", "class": "dt-left", "title": "Seção"},     // se a secao_id estiver na prórpria apresentacao
                    {"data": "pessoa", "name": "pessoa.nome_guerra", "class": "dt-left", "title": "P/G Pessoa"},
                    {"data": "destino", "name": "destino.sigla", "class": "dt-left", "title": "Motivo",
                        render: function (data, type, row) { 
                            let color = 'success';
                            let texto = 'Início';
                            if(row.apresentacao_id) {
                                color = 'danger';
                                texto = 'Término';
                            } 
                            return '<span class="badge badge-pill badge-' + color + '">' + texto + '</span>' + ' <b>' + data + '</b>';
                            // return '<span class="badge badge-' + color + '">' + data + '</span>';
                        }},
                    {"data": "dt_apres", "name": "apresentacaos.dt_apres", "class": "dt-center", "title": "Dt Apresentação"},
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
            $('#filtro_pessoa').on("change", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-apresentacao').DataTable().column('2').search( $(this).val() ).draw();
            });

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
                $('#datatables-apresentacao').DataTable().column('9').search( $(this).val() ).draw();
            });        

            var isNovoClicked = false;

            /*
            * Delete button action
            */
            $("#datatables-apresentacao tbody").delegate('tr td .btnExcluir', 'click', function (e) {
                e.stopImmediatePropagation();            

                let id = $(this).parents('tr').attr("id");

                //abre Form Modal Bootstrap e pede confirmação da Exclusão do Registro
                $("#confirmaExcluirModal .modal-body p").text('Você está certo que deseja Excluir este registro ID: ' + id + '?');
                $('#confirmaExcluirModal').modal('show');

                //se confirmar a Exclusão, exclui o Registro via Ajax
                $('#confirmaExcluirModal').find('.modal-footer #confirm').one('click', function (e) {
                    e.stopImmediatePropagation();

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

                            setTimeout(function() {
                                $('#alert').fadeOut('slow');
                            }, 2000);
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

                //abre Form Modal Bootstrap e pede confirmação da Exclusão do Registro
                $("#confirmahomologarModal .modal-body p").text('Você está certo que deseja Publicar a Apresentação ID: ' + id + '?');
                $('#confirmahomologarModal').modal('show');

                //se confirmar a Homologação, exclui o Registro via Ajax
                $('#confirmahomologarModal').find('.modal-footer #btnHomologar').on('click', function (e) {
                    e.stopImmediatePropagation();

                    let boletim_id = $("#boletim_id").val();

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

                            setTimeout(function() {
                                $('#alert').fadeOut('slow');
                            }, 2000);
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
                
                isNovoClicked = false;

                let id = $(this).parents('tr').attr("id");

                $.ajax({
                    type: "POST",
                    url: "{{url("apresentacaos/edit")}}",
                    data: {"id": id},
                    dataType: 'json',
                    success: function (data) {
                        $('#modalLabel').html('Editar Apresentação');
                        $(".invalid-feedback").text('').hide();  
                        $('#form-group-id').show();
                        $('#editarModal').modal('show');         
                        $('#nota').addClass('alert alert-success').html('<span>Editar dados a baixo</span> <i class="fa-solid fa-arrow-down"></i>');

                        // implementar que seja automático foreach   
                        $('#id').val(data.id);
                        $('#pessoa_id').selectpicker('val', data.pessoa_id);

                        $('#destino_id').selectpicker('val', data.destino_id);
                        $('#destino_input').val(data.destino_id);
                        $('#boletim_id').val(data.boletim_id);
                        $('#dt_apres').val(today);
                        $('#dt_inicial').val(data.dt_inicial);
                        $('#dt_final').val(data.dt_final);
                        $('#local_destino').val(data.local_destino);
                        $('#celular').val(data.celular);
                        $('#observacao').val(data.observacao);
                        $('#publicado').val(data.publicado);

                        $('#dadosForm').show();
                        $('#btnSave').show();
                    }
                }); 

            });           

            $("#datatables-apresentacao tbody").delegate('tr', 'dblclick', function (e) {
                e.stopImmediatePropagation();         

                isNovoClicked = false;

                let id = $(this).attr("id");

                $.ajax({
                    type: "POST",
                    url: "{{url("apresentacaos/edit")}}",
                    data: {"id": id},
                    dataType: 'json',
                    success: function (data) {
                        if(data.boletim_id == null || data.boletim_id == 1) {
                            $('#modalLabel').html('Editar Apresentação');
                            $(".invalid-feedback").text('').hide();  
                            $('#form-group-id').show();
                            $('#editarModal').modal('show');         
                            $('#nota').addClass('alert alert-success').html('<span>Editar dados a baixo</span> <i class="fa-solid fa-arrow-down"></i>');

                            // implementar que seja automático foreach   
                            $('#id').val(data.id);
                            $('#pessoa_id').selectpicker('val', data.pessoa_id);
                            $('#destino_input').val(data.destino_id);
                            $('#boletim_id').val(data.boletim_id);
                            $('#dt_inicial').val(data.dt_inicial);
                            $('#dt_final').val(data.dt_final);
                            $('#dt_apres').val(today);
                            $('#local_destino').val(data.local_destino);
                            $('#celular').val(data.celular);
                            $('#observacao').val(data.observacao);
                            $('#publicado').val(data.publicado);

                            $('#dadosForm').show();
                            $('#btnSave').show();
                        }

                    }
                }); 

            });           

            /*
            * Save button action
            */
            $('#btnSave').on("click", function (e) {
                e.stopImmediatePropagation();
                $(".invalid-feedback").text('').hide();    // hide and clean all erros messages on the form

                // to use a button as submit button, is necesary use de .get(0) after: console.log(formData);
                const formData = new FormData($('#formEntity').get(0));

                $.ajax({
                    type: "POST",
                    url: "{{url("apresentacaos/store")}}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $("#alert .alert-content").text('Salvou registro ID ' + data.id + ' com sucesso.');
                        $('#alert').removeClass().addClass('alert alert-success').show();
                        $('#editarModal').modal('hide');
                        $('#datatables-apresentacao').DataTable().ajax.reload(null, false);

                        setTimeout(function() {
                            $('#alert').fadeOut('slow');
                        }, 2000);
                    },
                    error: function (data) {
                        // validator: vamos exibir todas as mensagens de erro do validador
                        // como o dataType não é JSON, precisa do responseJSON
                        $.each( data.responseJSON.errors, function( key, value ) {
                            $("#error-" + key ).text(value).show();
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

                isNovoClicked = true;

                $('#formEntity').trigger('reset');              // clean de form data
                $('#form-group-id').hide();                     // hide ID field
                $('#id').val('');                               // reset ID field
                $('#pessoa_id').selectpicker('val', '');        // reset selectpicker
                $('#destino_id').selectpicker('val','');        // reset selectpicker    
                $('#destino_input').val('').prop('disabled', true);
                $('#dt_apres').val(today);                           
                $('#modalLabel').html('Nova Apresentação');     //
                $(".invalid-feedback").text('').hide();         // hide all error displayed
                $('#editarModal').modal('show');                // show modal 
            });

            /*
            * Limpa o modal ao fechar
            */
            $('#editarModal').on('hidden.bs.modal', function () {
                if(!isNovoClicked || isNovoClicked) {
                    // Limpar todos os campos do formulário
                    $(this).find('form')[0].reset();
                    //Diferencia modal novo do editar no
                    $('#editarModal :input').not('#id').not('#dt_apres').prop('disabled', false).prop('readonly', false);
                    $('.selectpicker').prop('disabled', false).selectpicker('refresh');

                    // // Limpar campos específicos
                    $('#nota').removeClass('alert-danger alert-success alert-warning').html('');

                    // Ocultar mensagens de erro
                    $('.error.invalid-feedback').hide();

                    $('#dadosForm').hide();
                }
            });

            /*
            * Refresh button action
            */
            $('#btnRefresh').on("click", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-apresentacao').DataTable().ajax.reload(null, false);
                $('#alert').trigger('reset').hide();
            });        

            // put the focus on de name field
            $('body').on('shown.bs.modal', '#editarModal', function () {
                $('#pessoa_id').focus();
            })

            // ao encolher o selectpicker da pessoa
            $("#pessoa_id").on("hidden.bs.select", function(e, clickedIndex, newValue, oldValue) {
                e.stopImmediatePropagation();

                if (!isNovoClicked) {
                    return;
                }

                // Limpar todos os campos do formulário
                $('#editarModal :input').not('#id').not('#dt_apres').prop('disabled', false).prop('readonly', false);
                $('.selectpicker').prop('disabled', false).selectpicker('refresh');

                $('#dt_apres').val(today);     
                $('#dt_inicial').val('');
                $('#dt_final').val('').attr('readonly', true);
                $('#destino_id').selectpicker('val','');        // reset selectpicker    
                $('#destino_input').val('').prop('disabled', true);
                $('#local_destino').val('');
                $('#celular').val('');
                $('#observacao').val('');
                $('#dadosForm').hide();

                // Função para atualizar os campos de formulário
                function updateFormFields(registro, readonly) {
                    $('#destino_id').selectpicker('val', registro.destino_id).prop('disabled', readonly).selectpicker('refresh');
                    $('#destino_input').val(registro.destino_id).prop('disabled', false);
                    $('#dt_inicial').val(registro.dt_inicial).attr('readonly', readonly);
                    // $('#dt_final').val(registro.dt_final).attr('readonly', readonly);
                    $('#dt_apres').val(today);
                    $('#local_destino').val(registro.local_destino).attr('readonly', readonly);
                    $('#celular').val(registro.celular).attr('readonly', readonly);
                    $('#observacao').val(registro.observacao).attr('readonly', readonly);
                    $('#apresentacao_id').val(registro.apresentacao_id);
                }

                // Função para mostrar ou esconder elementos e ajustar classes de alerta
                function updateUI(showSaveButton, showHideElements, alertClass, message) {
                    $('#btnSave').toggle(showSaveButton);
                    $('#dadosForm').toggle(showHideElements);
                    $('#nota').removeClass('alert-danger alert-success alert-warning')
                                .addClass(alertClass)
                                .html('<span>' + message + '</span> <i class="fa-solid fa-arrow-down"></i>');
                }

                $.ajax({
                    type: "POST",
                    url: "{{url("apresentacaos/getApresentacoesAbertas")}}",
                    data: { "pessoa_id": this.value },
                    dataType: 'json',
                    async: false,
                    cache: false,                        
                    success: function (data) {
                        if (data.codigo === 1) {
                            updateUI(false, false, 'alert-danger', data.mensagem);
                        } else if (data.codigo === 2) {
                            updateUI(true, true, 'alert-success', data.mensagem);
                            updateFormFields(data.registro, true);
                        } else if (data.codigo === 3) {
                            updateUI(false, false, 'alert-danger', data.mensagem);
                        } else if ($('#pessoa_id').val() == '') {
                            $('#nota').addClass('alert alert-success').text('Selecione a Pessoa');
                            $('#dadosForm').hide();
                        } else {
                            updateUI(true, true, 'alert-success', data.mensagem);
                            updateFormFields(data.registro, false);
                            $('#destino_id').selectpicker('val', data.destino_id).prop('disabled', false).selectpicker('refresh');
                            $('#destino_input').val(data.destino_id).prop('disabled', false);
                        }

                    },
                    error: function (error) {
                        console.log(error);
                    }
                });                
            });

        });

    </script>    

@stop


@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Administração  @can('is_admin') ADMINISTRADOR @endcan  @can('is_gerente') GERENTE @endcan @can('is_usuario') USUÁRIO @endcan</h1>
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
                            <span class="badge badge-info">{{$nivelAcesso}}</span>

                            @can('isAdmin','App\Models\Apresentacao')
                            <label class="btn btn-default btn-sm">É Administrador</label>
                            @endcan
                            
                            <button id="btnRefresh" class="btn btn-default btn-sm" data-toggle="tooltip" title="Atualizar a tabela (Alt+R)">Refresh</button>
                            
                            @can('PodeInserirApresentacao','App\Models\Apresentacao')
                            <button id="btnNovo" class="btnEdit btn btn-success btn-sm" data-toggle="tooltip" title="Adicionar um novo registro (Alt+N)" >Inserir Novo</button>                            
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    <!--área de Filtros-->
                    <div class="row">

                    </div>
                </div>

                <div class="card-body">
                    <!-- compact | stripe | order-column | hover | cell-border | row-border | table-dark-->
                    <table id="datatables-plano-chamada" class="table table-striped table-bordered table-hover table-sm compact" style="width:100%">
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
                    isAdmin
                </form>        

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
            </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        //variável global que recebe o ID do registro
        window.id = '';
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
            $('#datatables-plano-chamada').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{url("planochamada")}}",
                    data: {"paramFixo": "1" },
                },
                responsive: true,
                autoWidth: true,
                order: [3, 'desc'],
                lengthMenu: [[5, 10, 15, 30, 50, -1], [5, 10, 15, 30, 50, "Todos"]], 
                language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },     
                columns: [
                    {"data": "id", "name": "pessoas.id", "class": "dt-right", "title": "#"},
                    {"data": "secao", "name": "secao.sigla", "class": "dt-left", "title": "Seção"},
                    {"data": "pgrad", "name": "pgrad.sigla", "class": "dt-left", "title": "P/Grad"},                    
                    {"data": "nome_guerra", "name": "pessoas.nome_guerra", "class": "dt-left", "title": "Pessoa"},
                    {"data": "endereco", "name": "pessoas.endereco", "class": "dt-left", "title": "Endereço"},
                    {"data": "bairro", "name": "pessoas.bairro", "class": "dt-left", "title": "Bairro"},
                    {"data": "cidade", "name": "pessoas.cidade", "class": "dt-left", "title": "Cidade"},
                    {"data": "uf", "name": "pessoas.uf", "class": "dt-left", "title": "UF"},
                    {"data": "cep", "name": "pessoas.cep", "class": "dt-left", "title": "CEP"},
                    {"data": "fone_celular", "name": "pessoas.fone_celular ", "class": "dt-left", "title": "F. Contato"},
                    {"data": "fone_emergencia", "name": "pessoas.fone_emergencia ", "class": "dt-left", "title": "F. Emergência"},
                    {"data": "acoes", "name": "acoes", "class": "dt-center", "title": "Ações", "orderable": false, "width": "50px", "sortable": false},
                ]
            });

            // Filtro - Ao mudar a Seção em filtro_secao, aplica filtro pela coluna 1
            $('#filtro_secao').on("change", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-plano-chamada').DataTable().column('1').search( $(this).val() ).draw();
            });        

            /*
            * Edit button action
            */
            $("#datatables-plano-chamada tbody").delegate('tr td .btnEditar', 'click', function (e) {
                e.stopImmediatePropagation();            

                let id = $(this).parents('tr').attr("id");

                $.ajax({
                    type: "POST",
                    url: "{{url("planochamada/edit")}}",
                    data: {"id": id},
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
                        $('#modalLabel').html('Editar Plano de Chamada');
                        $(".invalid-feedback").text('').hide();     
                        $('#form-group-id').show();
                        $('#editarModal').modal('show');         

                        // implementar que seja automático foreach   
                        $('#id').val(data.id);
                        $('#pessoa_id').val(data.pessoa_id);
                        $('#destino_id').val(data.destino_id);
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
                    url: "{{url("planochamada/store")}}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        //console.log(data);
                        $("#alert .alert-content").text('Salvou registro ID ' + data.id + ' com sucesso.');
                        $('#alert').removeClass().addClass('alert alert-success').show();
                        $('#editarModal').modal('hide');
                        $('#datatables-plano-chamada').DataTable().ajax.reload(null, false);
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

            // put the focus on de name field
            $('body').on('shown.bs.modal', '#editarModal', function () {
                $('#endereco').focus();
            })

            /*
            * Refresh button action
            */
            $('#btnRefresh').on("click", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-plano-chamada').DataTable().ajax.reload(null, false);    
            });        

        });

    </script>    

@stop


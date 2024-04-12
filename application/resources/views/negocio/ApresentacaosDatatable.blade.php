@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Administração</h1>
@stop

@section('content')

    <!-- DataTables de Dados -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 text-left"><b>Apresentações</b></div>
                        <div class="col-md-4 text-right">
                            <button id="btnRefresh" class="btn btn-default btn-sm" data-toggle="tooltip" title="Atualizar a tabela (Alt+R)">Refresh</button>
                            @can('is_admin')
                            <button id="btnNovo" class="btnEdit btn btn-success btn-sm" data-toggle="tooltip" title="Adicionar um novo registro (Alt+N)" >Inserir Novo</button>
                            @endcan
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
                <button type="button" class="close" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');"></button>
            </div>
            <div class="modal-body">

                <form id="formEntity" name="formEntity"  action="javascript:void(0)" 
                    class="form-horizontal" method="post">

                        <div class="form-group" id="form-group-id">
                            <label class="form-label">ID</label>
                            <input class="form-control" value="" type="text" id="id" name="id" placeholder="" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nome Completo</label>
                            <input class="form-control" value="" type="text" id="nome_completo" name="nome_completo" placeholder="" data-toggle="tooltip" data-placement="top" title="Hooray!" >
                            <div id="error-sigla" class="error invalid-feedback" style="display: none;"></div>
                        </div>    

                        <div class="form-group">
                            <label class="form-label">Nome de Guerra</label>
                            <input class="form-control" value="" type="text" id="nome_guerra" name="nome_guerra" placeholder="" data-toggle="tooltip" data-placement="top" title="Hooray!" >
                            <div id="error-sigla" class="error invalid-feedback" style="display: none;"></div>
                        </div>                          
                        
                        <div class="form-group">    
                            <label class="form-label">Ativo</label>                    
                            <select class="form-control" id="ativo" name="ativo">
                                <option value="SIM">SIM</option>
                                <option value="NÃO">NÃO</option>
                            </select>
                            <div id="error-ativo" class="invalid-feedback" style="display: none;"></div>
                        </div>
                </form>        

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Homologar Registro -->
    <div class="modal fade" id="confirmahomologarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Homologar Apresentação</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#confirmaExcluirModal').modal('hide');" aria-label="Cancelar"></button>
                </div>
                <div class="modal-body">

                    <form id="formEntity" name="formEntity"  action="javascript:void(0)" class="form-horizontal" method="post">

                        <div class="form-group">
                            <label class="form-label">Selecione o Boletim de Publicação</label>
                            <select name="boletim_id" id="boletim_id" class="form-control">
                                <option value=""> Selecione </option>
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
                    <button type="button" class="btn btn-primary" id="btnHomologar" data-toggle="tooltip" title="Homologar a Apresentação atual (Alt+S)">Homologar</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#confirmaExcluirModal').modal('hide');" aria-label="Cancelar"></button>
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
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                }
            });

            $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: true,
                // order: [ 0, 'desc' ],
                lengthMenu: [[5, 10, 15, 30, 50, -1], [5, 10, 15, 30, 50, "Todos"]], 
                ajax: "{{url("apresentacaos")}}",
                language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },     
                columns: [
                    {"data": "id", "name": "apresentacaos.id", "class": "dt-right", "title": "#"},
                    // {"data": "pessoa_id", "name": "apresentacaos.pessoa_id", "class": "dt-left", "title": "Pessoa"},
                    {"data": "pessoa", "name": "pessoas.nome_guerra", "class": "dt-left", "title": "Pessoa"},
                    // {"data": "destino_id", "name": "apresentacaos.destino_id", "class": "dt-left", "title": "Motivo"},
                    {"data": "destino", "name": "destinos.sigla", "class": "dt-left", "title": "Motivo",
                        render: function (data) { return '<b>' + data + '</b>';}},
                    {"data": "dt_inicial", "name": "apresentacaos.dt_inicial", "class": "dt-center", "title": "Dt Início"},
                    {"data": "dt_final", "name": "apresentacaos.dt_final", "class": "dt-center", "title": "Dt Fim"},
                    // {"data": "prtsv", "name": "apresentacaos.prtsv", "class": "dt-left", "title": "Pronto Sv"},
                    {"data": "local_destino", "name": "apresentacaos.local_destino", "class": "dt-left", "title": "Local"},
                    {"data": "celular", "name": "apresentacaos.celular", "class": "dt-left", "title": "Contato"},
                    {"data": "publicado", "name": "apresentacaos.publicado", "class": "dt-center", "title": "Publ",
                        render: function (data) { return '<span style="color:' + ( data == 'SIM' ? 'blue' : 'red') + ';">' + data + '</span>';}
                    },
                    {"data": "boletim_id", "name": "apresentacaos.boletim_id", "class": "dt-left", "title": "Bol Pub"},
                    // {"data": "celular", "name": "apresentacaos.celular", "class": "dt-left", "title": "Nome",
                    //     render: function (data) { return '<b>' + data + '</b>';}},
                    // {"data": "nome_guerra", "name": "pessoas.nome_guerra", "class": "dt-left", "title": "Nome de Guerra"},
                    // {"data": "ativo", "name": "pessoas.ativo", "class": "dt-center", "title": "Ativo",  
                    //     render: function (data) { return '<span style="color:' + ( data == 'SIM' ? 'blue' : 'red') + ';">' + data + '</span>';}
                    // },
                    {"data": "id", "botoes": "", "orderable": false, "class": "dt-center", "title": "Ações", 
                        render: function (data, type) { 
                            return '<button data-id="' + data + '" class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>\n<button data-id="' + data + '" class="btnExcluir btn btn-danger btn-sm" data-toggle="tooltip" title="Excluir o registro atual">Excluir</button>\n<button data-id="' + data + '" class="btnHomologar btn btn-info btn-sm" data-toggle="tooltip" title="Homologar esta Apresentação">Homlg</button>';
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
                        url: "{{url("apresentacaos/destroy")}}",
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
            * Homologar button action
            */
            $("#datatables tbody").delegate('tr td .btnHomologar', 'click', function (e) {
                e.stopImmediatePropagation();            

                const id = $(this).data("id")
                // alert('Editar ID: ' + id );

                //abre Form Modal Bootstrap e pede confirmação da Exclusão do Registro
                $("#confirmahomologarModal .modal-body p").text('Você está certo que deseja Homologar a Apresentação ID: ' + id + '?');
                $('#confirmahomologarModal').modal('show');

                //se confirmar a Exclusão, exclui o Registro via Ajax
                $('#confirmahomologarModal').find('.modal-footer #btnHomologar').on('click', function (e) {
                    e.stopImmediatePropagation();

                    // alert($id);
                    $.ajax({
                        type: "POST",
                        url: "{{url("apresentacaos/homologar")}}",
                        data: {"id": id},
                        dataType: 'json',
                        success: function (data) {
                            $("#alert .alert-content").text('Homologar a Apresentação ID ' + id + ' com sucesso.');
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
                    url: "{{url("apresentacaos/edit")}}",
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
                        $('#pgrad_id').val(data.pgrad_id);
                        $('#qualificacao_id').val(data.qualificacao_id);
                        $('#nome_completo').val(data.nome_completo);
                        $('#nome_guerra').val(data.nome_guerra);
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
                $('#editarModal').modal('show');                 // show modal 
            });

            // put the focus on de name field
            $('body').on('shown.bs.modal', '#editarModal', function () {
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



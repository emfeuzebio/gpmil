@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="m-0 text-dark col-sm-6">
            <h1 class="m-0 text-dark"> @can('is_admin') ADMINISTRADOR @endcan  @can('is_gerente') GERENTE @endcan @can('is_usuario') USUÁRIO @endcan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">Plano de Chamada</li>
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
                        <div class="col-md-3 text-left h5"><b>Plano de Chamada</b></div>
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
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    <!--área de Filtros-->
                    <div class="row">
                        <div class="col-md-4 form-group" style="margin-bottom: 0px;">
                            <label class="form-label">Filtro pela Seção</label>
                            <select id="filtro_secao" name="filtro_secao" class="form-control" data-toggle="tooltip" title="Selecione para filtrar">
                                <option value=""> Todas Seções </option>
                                @foreach( $secoes as $secao )
                                <option value="{{$secao->sigla}}">{{$secao->sigla}}</option>
                                @endforeach
                            </select>
                        </div>
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
                    <button type="button" class="close btnCancelar" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');">&times;</button>
                </div>
                <div class="modal-body">

                    <form id="formEntity" name="formEntity"  action="javascript:void(0)" class="form-horizontal" method="post">

                        <div class="form-group" id="form-group-id">
                            <label class="form-label">ID</label>
                            <input class="form-control" value="" type="text" id="id" name="id" placeholder="" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">CEP</label>
                            <input class="form-control" value="" type="text" id="cep" name="cep" placeholder="" data-toggle="tooltip" title="CEP do endereço de residência">
                            <div id="error-cep" class="error invalid-feedback" style="display: none;"></div>
                        </div>    

                        <div class="form-group">
                            <label class="form-label">Endereço</label>
                            <input class="form-control" value="" type="text" id="endereco" name="endereco" placeholder="" data-toggle="tooltip" title="Endereço de residência">
                            <div id="error-endereco" class="error invalid-feedback" style="display: none;"></div>
                        </div>    

                        <div class="form-group">
                            <label class="form-label">Complemento</label>
                            <input class="form-control" value="" type="text" id="complemento" name="complemento" placeholder="Ex. Quadra/Lote/Casa/Apto nº ..." data-toggle="tooltip" title="Complemento do Endereço de residência">
                            <div id="error-complemento" class="error invalid-feedback" style="display: none;"></div>
                        </div>    

                        <div class="form-group">
                            <label class="form-label">Bairro</label>
                            <input class="form-control" value="" type="text" id="bairro" name="bairro" placeholder="Digite o bairro" data-toggle="tooltip" data-placement="top" title="Bairro de residência">
                            <div id="error-bairro" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Cidade</label>
                            <input class="form-control" value="" type="text" id="cidade" name="cidade" placeholder="Digite a cidade" data-toggle="tooltip" data-placement="top" title="Cidade de residência">
                            <div id="error-cidade" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Município</label>
                            <input class="form-control" value="" type="text" id="municipio_id" name="municipio_id" placeholder="Selecione o Município" data-toggle="tooltip" data-placement="top" title="Selecione o Município de residência">
                            <div id="error-municipio_id" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="form-group" id="form-group-id">
                            <label class="form-label">Estado UF</label>
                            <input class="form-control" value="" type="text" id="uf" name="uf" placeholder="Digite o Estado" data-toggle="tooltip" data-placement="top" title="Estado de residência">
                            <div id="error-uf" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Telefone Celular</label>
                            <input class="form-control" value="" type="tel" id="fone_celular" name="fone_celular" placeholder="Digite o telefone celular" data-toggle="tooltip" data-placement="top" title="Telefone celular" >
                            <div id="error-fone_celular" class="error invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Telefone de Emergência</label>
                            <input class="form-control" value="" type="text" id="fone_emergencia" name="fone_emergencia" placeholder="Digite o telefone de emergência" data-toggle="tooltip" data-placement="top" title="Telefone de emergência" >
                            <div id="error-fone_emergencia" class="error invalid-feedback" style="display: none;"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Pessoa para Emergência</label>
                            <input class="form-control" value="" type="text" id="pessoa_emergencia" name="pessoa_emergencia" placeholder="Digite o telefone de emergência" data-toggle="tooltip" data-placement="top" title="Nome da Pessoa para caso de emergência" >
                            <div id="error-pessoa_emergencia" class="error invalid-feedback" style="display: none;"></div>
                        </div>
                        
                    </form>        

                </div>
                <div class="modal-footer">
                    <div class="col-md-5 text-left">
                        <label id="msgOperacao" class="error invalid-feedback" style="color: red; display: none; font-size: 12px;"></label> 
                    </div>
                    <div class="col-md-5 text-right">
                        <button type="button" class="btn btn-secondary btnCancelar" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');">Cancelar</button>
                        @if( in_array($nivelAcesso,[1,3,4,5,6]) )
                        <button type="button" class="btn btn-primary btnSalvar" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        //variável global que recebe o ID do registro
        var id = '';
        var descricao = '';

        $(document).ready(function () {

            // máscaras para entrada de dados
            $('#cep').inputmask('99999-999');
            $('#fone_celular').inputmask('(99) 99999-9999'); 
            $('#fone_emergencia').inputmask('(99) 99999-9999');

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
                    {"data": "pgrad", "name": "pgrad.sigla", "class": "dt-left", "title": "P/Grad"},                    
                    {"data": "nome_guerra", "name": "pessoas.nome_guerra", "class": "dt-left", "title": "Pessoa"},
                    {"data": "secao", "name": "secao.sigla", "class": "dt-left", "title": "Seção"},
                    {"data": "endereco", "name": "pessoas.endereco", "class": "dt-left", "title": "Endereço"},
                    {"data": "complemento", "name": "pessoas.complemento", "class": "dt-left", "title": "Compl"},
                    {"data": "bairro", "name": "pessoas.bairro", "class": "dt-left", "title": "Bairro"},
                    {"data": "fone_celular", "name": "pessoas.fone_celular ", "class": "dt-left", "title": "Fone Contato"},
                    {"data": "fone_emergencia", "name": "pessoas.fone_emergencia ", "class": "dt-left", "title": "Fone Emergência"},
                    {"data": "pessoa_emergencia", "name": "pessoas.pessoa_emergencia ", "class": "dt-left", "title": "Pessoa Emergência"},
                    {"data": "acoes", "name": "acoes", "class": "dt-center", "title": "Ações", "orderable": false, "width": "60px", "sortable": false},
                ]
            });

            // Filtro - Ao mudar a Seção em filtro_secao, aplica filtro pela coluna 1
            $('#filtro_secao').on("change", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-plano-chamada').DataTable().column('3').search( $(this).val() ).draw();
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
                        $('#cep').val(data.cep);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.cidade);
                        $('#endereco').val(data.endereco);
                        $('#complemento').val(data.complemento);
                        $('#fone_emergencia').val(data.fone_emergencia);
                        $('#fone_celular').val(data.fone_celular);
                        $('#pessoa_emergencia').val(data.pessoa_emergencia);
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
                        // validator: vamos exibir todas as mensagens de erro do validador de campos
                        // como o dataType não é JSON, precisa do responseJSON
                        $.each( data.responseJSON.errors, function( key, value ) {
                            $("#error-" + key ).text(value).show(); //mostra todas as messagens de erros dos campos do form
                        });
                        // mostra mensagens de erro de Roles e Persistência em Banco
                        $('#msgOperacao').text(data.responseJSON.policyError).show();
                    }
                });                
            });

            // put the focus on de name field
            $('body').on('shown.bs.modal', '#editarModal', function () {
                $('#cep').focus();
            })

            /*
            * Refresh button action
            */
            $('#btnRefresh').on("click", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-plano-chamada').DataTable().ajax.reload(null, false);    
            });

            // busca endereço pelo CEP se o campo cep foi alterado
            $("#cep").change(function() {
                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#endereco").val("...");
                    $("#complemento").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");
                    $("#uf").val("...");
                    $("#municipio_id").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#endereco").val(dados.logradouro);
                            $("#complemento").val(dados.complemento);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#uf").val(dados.uf);
                            $("#municipio_id").val(dados.ibge);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            alert("CEP não encontrado.");   
                            $('#cep').focus();
                        }
                    });
                } else {
                    //cep é inválido.
                    alert("Formato de CEP inválido.");
                    $('#cep').focus();
                }

            });

        });

    </script>    

@stop


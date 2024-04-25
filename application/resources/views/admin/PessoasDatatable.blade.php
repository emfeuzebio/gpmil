@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="m-0 text-dark col-sm-6">
            <h1>Pessoas</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item">Administração</li>
                <li class="breadcrumb-item">Pessoal</li>
                <li class="breadcrumb-item active">Pessoas</li>
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
                        <div class="col-md-8 text-left"><b>Gestão de Pessoal</b></div>
                        <div class="col-md-4 text-right">
                            <button id="btnRefresh" class="btn btn-default btn-sm btnRefresh" data-toggle="tooltip" title="Atualizar a tabela (Alt+R)">Refresh</button>
                            @can('is_admin')
                            <button id="btnNovo" class="btnInserirNovo btn btn-success btn-sm" data-toggle="tooltip" title="Adicionar um novo registro (Alt+N)" >Inserir Novo</button>
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
        <div class="modal-dialog" style="max-width: 150vh">
            <div class="modal-content"  style="width: 100%;">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Modal title</h4>
                    <button type="button" class="close btnCancelar" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="container modal-body" style=" padding: 20px">
                    <form id="formEntity" name="formEntity"  action="javascript:void(0)" 
                        class="form-horizontal col-12" method="post" style=" padding: 1vh">
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="form-group-id">
                                <label class="form-label">ID</label>
                                <input class="form-control" value="" type="text" id="id" name="id" placeholder="" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">P / G <span style="color: red">*</span></label>
                                <select name="pgrad_id" id="pgrad_id" class="form-control selectpicker" data-live-search="true" placeholder="" data-toggle="tooltip" data-placement="top" title="Posto / Graduação!">
                                    @foreach( $pgrads as $pgrad )
                                    <option value="{{$pgrad->id}}">{{$pgrad->sigla}}</option>
                                    @endforeach
                                </select>
                                <div id="error-pgrad" class="error invalid-feedback" style="display: none;"></div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">QM <span style="color: red">*</span></label>
                                <select name="qualificacao_id" id="qualificacao_id" class="form-control selectpicker" data-live-search="true" placeholder="" data-toggle="tooltip" data-placement="top" title="Quadro Militar">
                                    @foreach( $qualificacaos as $qualificacao )
                                    <option value="{{$qualificacao->id}}">{{$qualificacao->sigla}}</option>
                                    @endforeach
                                </select>
                                <div id="error-qm" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Linha de Ensino Militar</label>
                                <select class="form-control selectpicker" data-live-search="true" name="lem" id="lem" placeholder="" data-toggle="tooltip" data-placement="top" title="Linha de Ensino Militar">
                                    <option value="Bélica">Bélica</option>
                                    <option value="Técnica">Técnica</option>
                                    <option value="Civil">Civil</option>
                                </select>
                                <div id="error-lem" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nome Completo <span style="color: red">*</span></label>
                                <input class="form-control" value="" type="text" id="nome_completo" name="nome_completo" placeholder="Digite seu nome" data-toggle="tooltip" data-placement="top" title="Nome Completo!" >
                                <div id="error-nome_completo" class="error invalid-feedback" style="display: none;"></div>
                            </div>    

                            <div class="form-group">
                                <label class="form-label">Nome de Guerra <span style="color: red">*</span></label>
                                <input class="form-control" value="" type="text" id="nome_guerra" name="nome_guerra" placeholder="Digite seu nome de guerra" data-toggle="tooltip" data-placement="top" title="Nome de Guerra!" >
                                <div id="error-nome_guerra" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">CPF <span style="color: red">*</span></label>
                                <input class="form-control" value="" type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" data-toggle="tooltip" data-placement="top" title="CPF!" >
                                <div id="error-cpf" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Identidade <span style="color: red">*</span></label>
                                <input class="form-control" value="" type="text" id="idt" name="idt" placeholder="Digite sua Identidade" data-toggle="tooltip" data-placement="top" title="Identidade!" >
                                <div id="error-idt" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Prec CP</label>
                                <input class="form-control" value="" type="text" id="preccp" name="preccp" placeholder="Digite seu" data-toggle="tooltip" data-placement="top" title="Prec-CP!">
                                <div id="error-preccp" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input class="form-control" value="" type="email" id="email" name="email" placeholder="Digite seu E-mail" data-toggle="tooltip" data-placement="top" title="E-mail!" >
                                <div id="error-email" class="error invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Data de Nascimento</label>
                                <input class="form-control" value="" type="date" lang="pt-BR" id="dt_nascimento" name="dt_nascimento" placeholder="Digite sua data de nascimento" data-toggle="tooltip" data-placement="top" title="Data de Nascimento!" >
                                <div id="error-dt_nascimento" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Data de Apresentação na OM</label>
                                <input class="form-control" value="" type="date" id="dt_apres_om" name="dt_apres_om" placeholder="Digite sua data de apresentação na OM" data-toggle="tooltip" data-placement="top" title="Apresentação na OM!" >
                                <div id="error-dt_apres_om" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Data de Apresentação na Guarnição</label>
                                <input class="form-control" value="" type="date" id="dt_apres_gu" name="dt_apres_gu" placeholder="Digite sua data de apresentação na Guarnição" data-toggle="tooltip" data-placement="top" title="Apresentação na Guarnição!" >
                                <div id="error-dt_apres_gu" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Data da Última Promoção</label>
                                <input class="form-control" value="" type="date" id="dt_ult_promocao" name="dt_ult_promocao" placeholder="Digite a data da sua última promoção" data-toggle="tooltip" data-placement="top" title="Última Promoção!" >
                                <div id="error-dt_ult_promocao" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">    
                                <label class="form-label">Segmento</label>
                                <div class="form-check">
                                    <label class="form-check-label" for="segmentoM">
                                        <input class="form-check-input" type="radio" id="segmentoM" value="Masculino" name="segmento">Masculino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="segmentoF">
                                        <input class="form-check-input" type="radio" id="segmentoF" value="Feminino" name="segmento">Feminino
                                    </label>
                                </div>
                                <div id="error-segmento" class="invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Seção <span style="color: red">*</span></label>
                                <select name="secao_id" id="secao_id" class="form-control selectpicker" data-live-search="true" placeholder="" data-toggle="tooltip" data-placement="top" title="Seção">
                                    @foreach( $secaos as $secao )
                                    <option value="{{$secao->id}}">{{$secao->sigla}}</option>
                                    @endforeach
                                </select>
                                <div id="error-secao_id" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Função</label>
                                <input class="form-control" value="" type="text" id="funcao_id" name="funcao_id" placeholder="Digite a função" data-toggle="tooltip" data-placement="top" title="Função!" >
                                <div id="error-funcao_id" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Status <span style="color: red">*</span></label>
                                <select class="form-control selectpicker" name="status" id="status" data-live-search="true" placeholder="" data-toggle="tooltip" data-placement="top" title="Selecione o Status!">
                                    <option value="Ativa">Ativa</option>
                                    <option value="Reserva">Reserva</option>
                                    <option value="Civil">Civil</option>
                                </select>
                                <div id="error-status" class="invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nível Acesso</span></label>
                                <select name="nivelacesso_id" id="nivelacesso_id" class="form-control selectpicker" data-live-search="true" placeholder="" data-toggle="tooltip" data-placement="top" title="Quadro Militar">
                                    @foreach( $nivel_acessos as $nivel_acesso )
                                    <option value="{{$nivel_acesso->id}}">{{$nivel_acesso->nome}}</option>
                                    @endforeach
                                </select>
                                <div id="error-qm" class="error invalid-feedback" style="display: none;"></div>
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

                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnCancelar" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');">Cancelar</button>
                    <button type="button" class="btn btn-primary btnSalvar" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                </div>
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
                    <button type="button" class="btn-close btnCancelar" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#confirmaExcluirModal').modal('hide');" aria-label="Cancelar"></button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnCancelar" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#confirmaExcluirModal').modal('hide');">Cancelar</button>
                    <button type="button" class="btn btn-danger" data-toggle="tooltip" title="Confirmar a Exclusão" id="confirm">Excluir</button>
                </div>
            </div>
        </div>
    </div>   

    <script type="text/javascript">

        $(document).ready(function () {

            $('#cpf').inputmask('999.999.999-99'); //Mascara para CPF
            $('#idt').inputmask('999999999-9'); //Mascara para IDT          
            // $('#preccp').inputmask('999999999-99'); //Mascara para IDT

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
                ajax: "{{url("pessoas")}}",
                language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },     
                columns: [
                    // { data: 'DT_RowIndex', name: 'DT_RowIndex' }, 
                    {"data": "id", "name": "pessoas.id", "class": "dt-right", "title": "#"},
                    /*
                    *   o parâmetro "name": "xxx" deve conter o nome do método Model->'belongsTo' que criou o relacionamento 
                    *                       seguido da coluna a que se deseja fazer a pesquisa
                    *                       no Controller deve estar o mesmo nome de coluna
                    */
                    {"data": "pgrad", "name": "pgrad.sigla", "class": "dt-left", "title": "P / G"},
                    {"data": "qualificacao", "name": "qualificacao.sigla", "class": "dt-left", "title": "QM"},
                    // {"data": "action", "name": "", "class": "dt-left", "title": "Ações"},
                    {"data": "nome_completo", "name": "pessoas.nome_completo", "class": "dt-left", "title": "Nome",
                        render: function (data) { return '<b>' + data + '</b>';}},
                    {"data": "nome_guerra", "name": "pessoas.nome_guerra", "class": "dt-left", "title": "Nome de Guerra"},
                    {"data": "ativo", "name": "pessoas.ativo", "class": "dt-center", "title": "Ativo",  
                        render: function (data) { return '<span style="color:' + ( data == 'SIM' ? 'blue' : 'red') + ';">' + data + '</span>';}
                    },
                    {"data": "acoes", "name": "acoes", "class": "dt-center", "title": "Ações", "orderable": false, "width": "auto", "sortable": false},
                ]
            });

            function getSegmentoValue() {
                return $('input[name="segmento"]:checked').val();
            }

            function getAtivoValue() {
                if ($('input[id="ativo"]:checked').val()) {
                    return 'SIM';
                } else {
                    return 'NÃO';
                }
            }

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
                        url: "{{url("pessoas/destroy")}}",
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
                    url: "{{url("pessoas/edit")}}",
                    data: {"id": id},
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
                        $('#modalLabel').html('Editar Pessoa');
                        $(".invalid-feedback").text('').hide();     //hide and clen all erros messages on the form
                        $('#form-group-id').show();
                        $('#editarModal').modal('show');         //show the modal

                        // implementar que seja automático foreach   
                        $('#id').val(data.id);
                        $('#pgrad_id').selectpicker('val', data.pgrad_id);
                        $('#qualificacao_id').selectpicker('val', data.qualificacao_id);
                        $('#lem').selectpicker('val', data.lem);
                        $('#nome_completo').val(data.nome_completo);
                        $('#nome_guerra').val(data.nome_guerra);
                        $('#cpf').val(data.cpf);
                        $('#idt').val(data.idt);
                        $('#status').selectpicker('val', data.status);
                        if (data.ativo === "SIM") {
                            $('#ativo').bootstrapToggle('on');
                        } else if (data.ativo === "NÃO") {
                            $('#ativo').bootstrapToggle('off');
                        }

                        $('#email').val(data.email);
                        // $('#segmento').val(data.segmento);
                        if (data.segmento === "Masculino") {
                            $('#segmentoM').prop('checked', true);
                        } else if (data.segmento === "Feminino") {
                            $('#segmentoF').prop('checked', true);
                        } else {
                            $('#segmentoM').prop('checked', false);
                            $('#segmentoF').prop('checked', false);
                        }
                        $('#preccp').val(data.preccp);
                        $('#dt_nascimento').val(data.dt_nascimento);
                        $('#dt_praca').val(data.dt_praca);
                        $('#dt_apres_gu').val(data.dt_apres_gu);
                        $('#dt_apres_om').val(data.dt_apres_om);
                        $('#dt_ult_promocao').val(data.dt_ult_promocao);
                        $('#pronto_sv').val(data.pronto_sv);
                        $('#foto').val(data.foto);
                        $('#secao_id').selectpicker('val', data.secao_id);
                        $('#funcao_id').val(data.funcao);
                        $('#nivelacesso_id').selectpicker('val', data.nivelacesso_id);
                    }
                }); 

            });

            /*
            * Save button action
            */
            $('#btnSave').on("click", function (e) {
                e.stopImmediatePropagation();
                $(".invalid-feedback").text('').hide();    //hide and clean all erros messages on the form
                
                // Get the values
                var segmentoValue = getSegmentoValue();
                var ativoValue = getAtivoValue();

                //to use a button as submit button, is necesary use de .get(0) after
                const formData = new FormData($('#formEntity').get(0));

                // Add the values to formData
                formData.append('segmento', segmentoValue);
                formData.append('ativo', ativoValue);

                //here there are a problem with de serialize the form
                $.ajax({
                    type: "POST",
                    url: "{{url("pessoas/store")}}",
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
                $('#formEntityR').trigger('reset');              //clean de form data
                $('#form-group-id').hide();                     //hide ID field
                $('#id').val('');                               // reset ID field
                $('#modalLabel').html('Nova Pessoa');  //
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

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#endereco").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#uf").val("");
            // $("#ibge").val("");
        }

        //Quando o campo cep perde o foco.
        $("#cep").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#endereco").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");
                    $("#uf").val("...");
                    // $("#ibge").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#endereco").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#uf").val(dados.uf);
                            // $("#ibge").val(dados.ibge);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });

    </script>    

@stop



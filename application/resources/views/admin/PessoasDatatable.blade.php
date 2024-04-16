@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Administração</h1>
@stop

@section('content')

    {{-- @foreach( $pgrads as $user )
            <p> {{$user->id}}" = {{$user->sigla}}</p>
    @endforeach --}}

    <!-- DataTables de Dados -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 text-left"><b>Gestão de Pessoal</b></div>
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
        <div class="modal-dialog" style="max-width: 150vh">
            <div class="modal-content"  style="width: 100%;">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Modal title</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" data-toggle="tooltip" title="Cancelar a operação (Esc ou Alt+C)" onClick="$('#editarModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
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
                                <select name="pgrad_id" id="pgrad_id" class="form-control"placeholder="" data-toggle="tooltip" data-placement="top" title="Posto / Graduação!">
                                    <option value=""> Selecione o P / G </option>
                                    @foreach( $pgrads as $pgrad )
                                    <option value="{{$pgrad->id}}">{{$pgrad->sigla}}</option>
                                    @endforeach
                                </select>
                                <div id="error-pgrad" class="error invalid-feedback" style="display: none;"></div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">QM <span style="color: red">*</span></label>
                                <select name="qualificacao_id" id="qualificacao_id" class="form-control" placeholder="" data-toggle="tooltip" data-placement="top" title="Quadro Militar">
                                    <option value=""> Selecione a QM</option>
                                    @foreach( $qualificacaos as $qualificacao )
                                    <option value="{{$qualificacao->id}}">{{$qualificacao->sigla}}</option>
                                    @endforeach
                                </select>
                                <div id="error-qm" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Linha de Ensino Militar</label>
                                <select class="form-control" name="lem" id="lem" placeholder="" data-toggle="tooltip" data-placement="top" title="Linha de Ensino Militar">
                                    <option value="">Selecione a Linha de Ensino</option>
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
                        </div>

                        <div class="col-md-6">
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
                                <label class="form-label">Status <span style="color: red">*</span></label>
                                <select class="form-control" name="status" id="status" placeholder="" data-toggle="tooltip" data-placement="top" title="Selecione o Status!">
                                    <option value="">Selecione o Status</option>
                                    <option value="Ativa">Ativa</option>
                                    <option value="Reserva">Reserva</option>
                                    <option value="Civil">Civil</option>
                                </select>
                                <div id="error-status" class="invalid-feedback" style="display: none;"></div>
                            </div>
                            

                            <div class="form-group" id="form-group-id">
                                <label class="form-label">CEP</label>
                                <input class="form-control" value="" type="text" id="cep" name="cep" placeholder="Digite o CEP" placeholder="Digite a data da sua última promoção" data-toggle="tooltip" data-placement="top" title="CEP!">
                                <div id="error-cep" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group" id="form-group-id">
                                <label class="form-label">Estado UF</label>
                                <input class="form-control" value="" type="text" id="uf" name="uf" placeholder="Digite o Estado" data-toggle="tooltip" data-placement="top" title="Estado UF!">
                                <div id="error-uf" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group" id="form-group-id">
                                <label class="form-label">Endereço</label>
                                <input class="form-control" value="" type="text" id="endereco" name="endereco" placeholder="Digite o endereço" data-toggle="tooltip" data-placement="top" title="Endereço!">
                                <div id="error-endereco" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Bairro</label>
                                <input class="form-control" value="" type="text" id="bairro" name="bairro" placeholder="Digite o bairro" data-toggle="tooltip" data-placement="top" title="Bairro!">
                                <div id="error-bairro" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Cidade</label>
                                <input class="form-control" value="" type="text" id="cidade" name="cidade" placeholder="Digite a cidade" data-toggle="tooltip" data-placement="top" title="Cidade!">
                                <div id="error-cidade" class="error invalid-feedback" style="display: none;"></div>
                            </div>
                            
                            {{-- <div class="form-group">
                                <label class="form-label">Municipio</label>
                                <select name="qualificacao_id" id="qualificacao_id" class="form-control">
                                    <option value=""> Selecione a QM </option>
                                    @foreach( $qualificacaos as $qualificacao )
                                    <option value="{{$qualificacao->id}}">{{$qualificacao->sigla}}</option>
                                    @endforeach
                                </select>
                                <div id="error-sigla" class="error invalid-feedback" style="display: none;"></div>
                            </div>     --}}

                            <div class="form-group">
                                <label class="form-label">Ramal</label>
                                <input class="form-control" value="" type="tel" id="fone_ramal" name="fone_ramal" placeholder="Digite o ramal" data-toggle="tooltip" data-placement="top" title="Telefone Ramal!" >
                                <div id="error-fone_ramal" class="error invalid-feedback" style="display: none;"></div>
                            </div>    

                            <div class="form-group">
                                <label class="form-label">Telefone Celular</label>
                                <input class="form-control" value="" type="tel" id="fone_celular" name="fone_celular" placeholder="Digite o telefone celular" data-toggle="tooltip" data-placement="top" title="Telefone Celular!" >
                                <div id="error-fone_celular" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Telefone de Emergência</label>
                                <input class="form-control" value="" type="text" id="fone_emergencia" name="fone_emergencia" placeholder="Digite o telefone de emergência" data-toggle="tooltip" data-placement="top" title="Telefone de Emergência!" >
                                <div id="error-fone_emergencia" class="error invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Seção</span></label>
                                <select name="secao_id" id="secao_id" class="form-control" placeholder="" data-toggle="tooltip" data-placement="top" title="Quadro Militar">
                                    <option value=""> Selecione a Seção</option>
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
                                <label class="form-label">Nível Acesso</span></label>
                                <select name="nivelacesso_id" id="nivelacesso_id" class="form-control" placeholder="" data-toggle="tooltip" data-placement="top" title="Quadro Militar">
                                    <option value=""> Selecione o nível</option>
                                    @foreach( $nivel_acessos as $nivel_acesso )
                                    <option value="{{$nivel_acesso->id}}">{{$nivel_acesso->nome}}</option>
                                    @endforeach
                                </select>
                                <div id="error-qm" class="error invalid-feedback" style="display: none;"></div>
                            </div>
                            
                            <div class="form-group">    
                                <label class="form-label">Ativo <span style="color: red">*</span></label>                    
                                <select class="form-control" id="ativo" name="ativo" placeholder="" data-toggle="tooltip" data-placement="top" title="Ativo! Sim o Não?">
                                    <option value="SIM">SIM</option>
                                    <option value="NÃO">NÃO</option>
                                </select>
                                <div id="error-ativo" class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
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

            $('#cpf').inputmask('999.999.999-99'); //Mascara para CPF
            $('#idt').inputmask('999999999-9'); //Mascara para IDT
            $('#cep').inputmask('99999-999'); //Mascara para IDT
            $('#fone_ramal').inputmask('999 9999'); //Mascara para Ramal            
            $('#fone_celular').inputmask('(99) 99999-9999'); //Mascara para Celular            
            $('#fone_emergencia').inputmask('(99) 99999-9999'); //Mascara para Tel Emergência           

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
                    // {"data": "created_at", "name": "created_at", "class": "dt-center", "title": "Criado em"},
                    {"data": "id", "botoes": "", "orderable": false, "class": "dt-center", "title": "Ações", 
                        render: function (data, type) { 
                            return '<button data-id="' + data + '" class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>\n<button data-id="' + data + '" class="btnExcluir btn btn-danger btn-sm" data-toggle="tooltip" title="Excluir o registro atual">Excluir</button>'; 
                        }
                    },
                ]
            });

            function getSegmentoValue() {
                return $('input[name="segmento"]:checked').val();
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
                segmento = getSegmentoValue();
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
                        $('#pgrad_id').val(data.pgrad_id);
                        $('#qualificacao_id').val(data.qualificacao_id);
                        $('#nome_completo').val(data.nome_completo);
                        $('#nome_guerra').val(data.nome_guerra);
                        $('#cpf').val(data.cpf);
                        $('#idt').val(data.idt);
                        $('#status').val(data.status);
                        $('#ativo').val(data.ativo);
                        $('#lem').val(data.lem);
                        $('#email').val(data.email);
                        $('#segmento').val(data.segmento);
                        $('#preccp').val(data.preccp);
                        $('#dt_nascimento').val(data.dt_nascimento);
                        $('#dt_praca').val(data.dt_praca);
                        $('#dt_apres_gu').val(data.dt_apres_gu);
                        $('#dt_apres_om').val(data.dt_apres_om);
                        $('#dt_ult_promocao').val(data.dt_ult_promocao);
                        $('#pronto_sv').val(data.pronto_sv);
                        $('#endereco').val(data.endereco);
                        $('#cidade').val(data.cidade);
                        $('#bairro').val(data.bairro);
                        $('#municipio_id').val(data.municipio_id);
                        $('#uf').val(data.uf);
                        $('#cep').val(data.cep);
                        $('#fone_ramal').val(data.fone_ramal);
                        $('#fone_celular').val(data.fone_celular);
                        $('#fone_emergencia').val(data.fone_emergencia);
                        $('#foto').val(data.foto);
                        $('#secao').val(data.secao);
                        $('#funcao_id').val(data.funcao);
                        $('#nivelacesso_id').val(data.nivelacesso_id);
                    }
                }); 

            });

            /*
            * Save button action
            */
            $('#btnSave').on("click", function (e) {
                e.stopImmediatePropagation();
                $(".invalid-feedback").text('').hide();    //hide and clean all erros messages on the form
                getSegmentoValue();
                //to use a button as submit button, is necesary use de .get(0) after
                const formData = new FormData($('#formEntity').get(0));
                // console.log(formData);

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



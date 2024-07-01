@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="m-0 text-dark col-sm-6">
            <h1 class="m-0 text-dark"></h1>
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
                            <label class="form-label">Filtro por Militar</label>
                            <select id="filtro_pessoa" name="filtro_pessoa" class="form-control selectpicker" data-live-search="true" data-style="form-control" data-toggle="tooltip" title="Selecione para filtrar">
                                <option value=""> Todas os Militares </option>
                                @foreach( $pessoas as $pessoa )
                                <option value="{{$pessoa->nome_guerra}}">{{$pessoa->pgrad->sigla}} {{$pessoa->nome_guerra}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group" style="margin-bottom: 0px;">
                            <label class="form-label">Filtro pela Seção</label>
                            <select id="filtro_secao" name="filtro_secao" class="form-control selectpicker" data-style="form-control" data-live-search="true" data-toggle="tooltip" title="Selecione para filtrar">
                                <option value=""> Todas Seções </option>
                                @foreach( $secoes as $secao )
                                <option value="{{$secao->sigla}}">{{$secao->sigla}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group" style="margin-bottom: 0px;">
                            <label class="form-label">Filtro pelos P/Graduações</label>
                            <select id="filtro_pgrad" name="filtro_pgrad" class="form-control selectpicker" data-live-search="true" data-style="form-control" data-toggle="tooltip" title="Selecione para filtrar">
                            <option value=""> Todos os P/Graduações</option>
                                @foreach( $pgrads as $pgrad )
                                <option value="{{$pgrad->sigla}}">{{$pgrad->sigla}}</option>
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
    <div class="modal fade" id="editarModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
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
                            <input class="form-control" value="" type="text" id="municipio_id" name="municipio_id" placeholder="Selecione o Município" data-toggle="tooltip" data-placement="top" title="Selecione o Município de residência" readonly>
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
                            <input class="form-control" value="" type="text" id="pessoa_emergencia" name="pessoa_emergencia" placeholder="Nome da Pessoa para caso de emergência (parentesco)" data-toggle="tooltip" data-placement="top" title="Nome da Pessoa para caso de emergência" >
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
                        @can('podeSalvarPessoa')
                        <button type="button" class="btn btn-primary btnSalvar" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                        @endcan
                        <button type="button" class="btn btn-primary btnSalvar editable" style="display: none;" id="btnSave" data-toggle="tooltip" title="Salvar o registro (Alt+S)">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        //variável global que recebe o ID do registro
        var id = '';
        var descricao = '';
        const userNivelAcessoID = {{ Auth::user()->Pessoa->nivelacesso_id }};

        $(document).ready(function () {

            // máscaras para entrada de dados
            $('#cep').inputmask('99999-999');
            $('#fone_celular').inputmask('(99) 99999-9999'); 
            $('#fone_emergencia').inputmask('(99) 99999-9999');

            // send token
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            function getSecaoUsuario() {
                var secao_id = {{$user->pessoa->secao_id}};
                var secoes = {!! json_encode($secoes) !!}; // Supondo que $secoes seja uma variável PHP com todas as seções disponíveis
                
                var secaoUser = '';
                secoes.forEach(function(secao) {
                    if (secao.id === secao_id) {
                        secaoUser = secao.sigla;
                        return false; // Para sair do loop quando encontrar a correspondência
                    }
                });
                
                return secaoUser;
            }

            function getBase64Image(imgUrl, callback) {
                var img = new Image();
                img.crossOrigin = 'Anonymous';
                img.onload = function() {
                    var canvas = document.createElement('CANVAS');
                    var ctx = canvas.getContext('2d');
                    var dataURL;
                    canvas.height = this.naturalHeight;
                    canvas.width = this.naturalWidth;
                    ctx.drawImage(this, 0, 0);
                    dataURL = canvas.toDataURL('image/png');
                    callback(dataURL);
                };
                img.src = imgUrl;
            }

            getBase64Image('vendor/adminlte/dist/img/dcemlogo.png', function(base64image) {
                // console.log(base64image); // Use este valor na configuração do cabeçalho
                // return base64image;
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
                pageLength: 10,
                language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },     
                columns: [
                    {"data": "id", "name": "pessoas.id", "class": "dt-right", "title": "#"},
                    {"data": "pgrad", "name": "pgrad.sigla", "class": "dt-left font-weight-bold", "title": "P/Grad"},                    
                    {"data": "nome_guerra", "name": "pessoas.nome_guerra", "class": "dt-left font-weight-bold", "title": "Pessoa"},
                    {"data": "secao", "name": "secao.sigla", "class": "dt-left", "title": "Seção"},
                    {"data": "endereco", "name": "pessoas.endereco", "class": "dt-left", "title": "Endereço"},
                    {"data": "complemento", "name": "pessoas.complemento", "class": "dt-left", "title": "Compl"},
                    {"data": "bairro", "name": "pessoas.bairro", "class": "dt-left", "title": "Bairro"},
                    {"data": "fone_celular", "name": "pessoas.fone_celular ", "class": "dt-left", "title": "F. Contato"},
                    {"data": "fone_emergencia", "name": "pessoas.fone_emergencia ", "class": "dt-left", "title": "F. Emergência"},
                    {"data": "pessoa_emergencia", "name": "pessoas.pessoa_emergencia ", "class": "dt-left", "title": "Pessoa Emergência"},
                    {"data": "acoes", "name": "acoes", "class": "dt-center", "title": "Ações", "orderable": false, "width": "60px", "sortable": false},
                ],
                dom: '<"d-flex"<"col-sm-12 col-md-6 d-flex align-items-center"<"mr-2"l>B><"ml-auto p-2"f>>tipr',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf"></i> Exportar para PDF',
                        className: 'btn btn-danger',
                        filename: 'planodechamada_' + new Date().toLocaleDateString(),
                        title: function() {
                            var today = new Date();
                            var dd = String(today.getDate()).padStart(2, '0');
                            var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                            var yyyy = today.getFullYear();
                            if(userNivelAcessoID == 5) {
                                var secaoUser = getSecaoUsuario();
                                return 'Plano de Chamada - DCEM - ' + secaoUser + ' ' + dd + '/' + mm + '/' + yyyy;
                            }
                            return 'Plano de Chamada - DCEM - ' + dd + '/' + mm + '/' + yyyy;
                        },
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        },
                        orientation: 'landscape',
                        customize: function(doc) {
                            /*
                            * definição das variáveis para o cabeçalho e rodapé do documento
                            */
                            var d = new Date();
                            var dataAtual = d.toLocaleDateString('pt-BR');
                            var horaAtual = d.toLocaleTimeString('pt-BR');
                            doc.pageMargins = [30, 50, 10, 30]; //[esq,sup,dir,inf] - considerar que o header fica dentro dos (120) e o footer fica dentro dos (60)
                            doc.defaultStyle.fontSize = 8;                      //seta o tamanho do fonte de todo o documento
                            doc['header'] = ( function(currentPage, pageCount, pageSize) {
                            return {

                                columns:[
                                    { image: 'data:image/png;base64,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', width: 30 },
                                    { text: 'Diretoria de Controle de Efetivos e Movimentações', alignment: 'center', width: '*', bold: true, fontSize: 12 }
                                ],
                                margin: [30, 0, 10, 10],

                                table: {
                                    widths: ['100%'],
                                    headerRows: 1,
                                    body: [

                                        [ 
                                            {text: 'Título Relatório\n', bold: true, fontSize: 11, alignment: 'center', border: [false, false, false, false] },
                                            {text: 'Ano: 2023 - Mês: Março - Tipo: J,S - Qtd Presenças: pelo menos: 2', bold: false, fontSize: 10 , alignment: 'center', border: [false, false, false, false]},
                                        ]

                                    ]
                                }, 
                                margin: [30, 30, 10, 0]

                            }
                        });                         

                        // Adicionar linha horizontal
                        doc.content.splice(0, 0, {
                            canvas: [
                                {
                                    type: 'line',
                                    x1: 0, y1: 0,
                                    x2: 595 - 2 * 40, y2: 0, // largura do documento A4 em pontos menos as margens
                                    lineWidth: 1
                                }
                            ],
                            margin: [30, 30, 10, 0]
                        });
                        
                        doc['footer']=(function(page, pages) {              //seta o rodapé do documento com duas colunas
                            return {
                                columns: [
                                    { text: ['Impresso por ' + 'Fulano' + ', em : ' + dataAtual + ' ' + horaAtual + ''], alignment: 'left'},
                                    { text: ['página ', { text: page.toString() }, ' de ', { text: pages.toString() }], alignment: 'right' }
                                ],
                                margin: [30,5,10,5] 
                            }
                        });
                        
                        },
                        init: function(api, node, config) {
                            $(node).hide();
                            api.on('draw', function() {
                                if (userNivelAcessoID == 1 || userNivelAcessoID == 3 || userNivelAcessoID == 5) {
                                    $(node).show();
                                } 
                            });
                        }
                    }
                ],
                initComplete: function() {
                    var api = this.api();
                    api.buttons().container().appendTo($('.dataTables_wrapper .col-md-6:eq(0)'));
                }
            });
        

            // Filtro - Ao mudar a Seção em filtro_secao, aplica filtro pela coluna 1
            $('#filtro_secao').on("change", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-plano-chamada').DataTable().column('3').search( $(this).val() ).draw();
            });        

            $('#filtro_pessoa').on("change", function (e) {
                e.stopImmediatePropagation();
                $('#datatables-plano-chamada').DataTable().column('2').search( $(this).val() ).draw();
            });  
            
            // Filtro - Ao mudar o Motivo em filtro_destino, aplica filtro pela coluna 1
            $('#filtro_pgrad').on("change", function (e) {
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
                        $('#cep').val(data.cep);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.cidade);
                        $('#endereco').val(data.endereco);
                        $('#complemento').val(data.complemento);
                        $('#municipio_id').val(data.municipio_id);
                        $('#uf').val(data.uf);
                        $('#fone_emergencia').val(data.fone_emergencia);
                        $('#fone_celular').val(data.fone_celular);
                        $('#pessoa_emergencia').val(data.pessoa_emergencia);

                        // se o Usuário for o dono do registro, ou '1-is_admin', ou '3-is_encpes', ou '5-is_sgtte' permite editar e Salvar
                        if( data.id == {{ Auth::user()->id }} || userNivelAcessoID == 1 || userNivelAcessoID == 3 || userNivelAcessoID == 5) {
                            $('.editable').prop('disabled', false);
                            $('#btnSave').show();
                        } else {
                            $('.editable').prop('disabled', true);
                            $('#btnSave').hide();
                        }
                    }
                }); 

            });           

            /*
            * Doble Click on table line edit reg
            */
            $("#datatables-plano-chamada tbody").delegate('tr', 'dblclick', function (e) {
                e.stopImmediatePropagation();            

                let id = $(this).attr("id");

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
                        $('#municipio_id').val(data.municipio_id);
                        $('#uf').val(data.uf);
                        $('#fone_emergencia').val(data.fone_emergencia);
                        $('#fone_celular').val(data.fone_celular);
                        $('#pessoa_emergencia').val(data.pessoa_emergencia);

                        // se o Usuário for o dono do registro, ou '1-is_admin', ou '3-is_encpes', ou '5-is_sgtte' permite editar e Salvar
                        if( data.id == {{ Auth::user()->id }} || userNivelAcessoID == 1 || userNivelAcessoID == 3 || userNivelAcessoID == 5) {
                            $('.editable').prop('disabled', false);
                            $('#btnSave').show();
                        } else {
                            $('.editable').prop('disabled', true);
                            $('#btnSave').hide();
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

                //to use a button as submit button, is necesary use de .get(0) after
                const formData = new FormData($('#formEntity').get(0));

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

                        setTimeout(function() {
                            $('#alert').fadeOut('slow');
                        }, 2000);
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

            @can('podeEditarPlanoChamada') 
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
            @endcan

        });

    </script>    

@stop


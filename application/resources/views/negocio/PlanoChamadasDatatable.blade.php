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

                @cannot('is_usuario')
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
                @endcannot

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
                            <input class="form-control" value="" type="text" id="complemento" name="complemento" placeholder="Digite o complemento" data-toggle="tooltip" title="Complemento do Endereço de residência" maxlength="100">
                            <div id="error-complemento" class="error invalid-feedback" style="display: none;"></div>
                        </div>    

                        <div class="form-group">
                            <label class="form-label">Numero</label>
                            <input class="form-control" value="" type="text" id="numero" name="numero" placeholder="Ex. Quadra/Lote/Casa/Apto nº ..." data-toggle="tooltip" title="Complemento do Endereço de residência" maxlength="100">
                            <div id="error-numero" class="error invalid-feedback" style="display: none;"></div>
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
                            <input class="form-control" value="" type="text" id="pessoa_emergencia" name="pessoa_emergencia" placeholder="Nome da Pessoa para caso de emergência (parentesco)" data-toggle="tooltip" data-placement="top" title="Nome da Pessoa para caso de emergência" maxlength="100">
                            <div id="error-pessoa_emergencia" class="error invalid-feedback" style="display: none;"></div>
                        </div>
                        
                    </form>        

                </div>
                <div class="modal-footer">
                    <div class="col-md-6 text-left">
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
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                statusCode: { 401: function() { window.location.href = "/";} }
            });

            function getUsuario() {
                var pgrad = "{{ $pessoaAuth->pgrad->sigla }}";
                var nome_guerra = "{{ $pessoaAuth->nome_guerra }}";
                var userLogado = pgrad + " " + nome_guerra; // Adicione um espaço entre pgrad e nome_guerra se necessário
                return userLogado;
            }

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

            // getBase64Image('vendor/adminlte/dist/img/dcemlogo.png', function(base64image) {           
            // });

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
                    order: [[1, 'asc'], [2, 'asc']],
                    lengthMenu: [[5, 10, 15, 30, 50, -1], [5, 10, 15, 30, 50, "Todos"]], 
                    pageLength: 10,
                    language: { url: "{{ asset('vendor/datatables/DataTables.pt_BR.json') }}" },     
                    columns: [
                        {"data": "id", "name": "pessoas.id", "class": "dt-right", "title": "#"},
                        {"data": "pgrad", "name": "pgrad.sigla", "class": "dt-left font-weight-bold", "title": "P/Grad"},                    
                        {"data": "nome_guerra", "name": "pessoas.nome_guerra", "class": "dt-left font-weight-bold", "title": "Pessoa"},
                        {"data": "secao", "name": "secao.sigla", "class": "dt-left", "title": "Seção"},
                        {"data": "endereco", "name": "pessoas.endereco", "class": "dt-left", "title": "Endereço"},
                        {"data": "complemento", "name": "pessoas.complemento", "class": "dt-left", "title": "Complemento"},
                        {"data": "numero", "name": "pessoas.numero", "class": "dt-left", "title": "Numero"},
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
                            className: 'btn btn-sm',
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
                                var userLogado = getUsuario();
                                doc.pageMargins = [30, 50, 30, 30];                 //[esq,sup,dir,inf] - considerar que o header fica dentro dos (120) e o footer fica dentro dos (60)
                                doc.defaultStyle.fontSize = 8;                      //seta o tamanho do fonte de todo o documento
                                doc.styles.tableBodyOdd.margin =  [5, 5, 5, 5];
                                doc.styles.tableBodyEven.margin = [5, 5, 5, 5];      
                                doc.pageMargins = [30,60,30,30];                    //[esq,sup,dir,inf] - considerar que o header fica dentro dos (120) e o footer fica dentro dos (60)
                                doc.defaultStyle.fontSize = 8;                      //seta o tamanho do fonte de todo o documento
                                doc.defaultStyle.alignment = 'left';                //alinhamento do texto em todo o documento    

                                doc['header'] = ( function(currentPage, pageCount, pageSize) {
                                    return {

                                        columns:[
                                            { text: '', width: 25 },
                                            { 
                                                text: 'Diretoria de Controle de Efetivos e Movimentações', 
                                                alignment: 'center', 
                                                width: '*', 
                                                bold: true, 
                                                fontSize: 12
                                            }
                                        ],
                                        margin: [30, 0, 30, 10],
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
                                        margin: [30, 30, 30, 0]
                                    }
                                });                         

                                // Adicionar linha horizontal
                                doc.content.splice(0, 0, {
                                    canvas: [
                                        {
                                            type: 'line',
                                            x1: 0, y1: 0,
                                            x2: 780, y2: 0, // largura do documento A4 landscape em pontos menos as margens
                                            lineWidth: 1,
                                        }
                                    ],
                                    margin: [0, 10, 30, 10] // Ajusta a margem para alinhar horizontalmente
                                });
                            
                                doc['footer']=(function(page, pages) {              //seta o rodapé do documento com duas colunas
                                    return {
                                        columns: [
                                            { text: ['Impresso por ' + userLogado + ', em : ' + dataAtual + ' ' + horaAtual + ''], alignment: 'left'},
                                            { text: ['página ', { text: page.toString() }, ' de ', { text: pages.toString() }], alignment: 'right' }
                                        ],
                                        margin: [30,5,30,5] 
                                    }
                                });

                                // largura da tabela de dados
                                // doc.content[2].table.widths = '*';               // distribui as colunas automaticamente até 100% largura       
                                doc.content[2].table.widths = ['5%','*','*','20%','*','6%','*','10%','10%' ];

                                // Adicionar bordas sutis às células da tabela
                                doc.content[2].layout = {
                                    hLineWidth: function(i, node) {
                                        return (i === 0 || i === node.table.body.length) ? 1 : 0;
                                    },
                                    vLineWidth: function(i) {
                                        return 0.1; // Adiciona linhas verticais sutis
                                    },
                                    hLineColor: function(i) {
                                        return '#aaa';
                                    },
                                    vLineColor: function(i) {
                                        return '#ddd'; // Cor das linhas verticais
                                    },
                                    paddingLeft: function(i) {
                                        return 1;
                                    },
                                    paddingRight: function(i, node) {
                                        return 1;
                                    },
                                    paddingTop: function() {
                                        return 1;
                                    },
                                    paddingBottom: function() {
                                        return 1;
                                    }
                                };
                            
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
            * Edit vindo do pup-up da home
            */
            @if($user_id)
                var userId = {{ $user_id }};
                $.ajax({
                        type: "POST",
                        url: "{{url('planochamada/edit')}}",
                        data: {"id": userId},
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
                            $('#numero').val(data.numero);
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
                        },
                    error: function (error) {
                        if (error.responseJSON === 401 || error.responseJSON.message && error.statusText === 'Unauthenticated') {
                            window.location.href = "{{ url('/') }}";
                        }
                    }
                    }); 
            @endif

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
                        $('#numero').val(data.numero);
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
                    },
                    error: function (error) {
                        if (error.responseJSON === 401 || error.responseJSON.message && error.statusText === 'Unauthenticated') {
                            window.location.href = "{{ url('/') }}";
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
                        $('#numero').val(data.numero);
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
                        $('#alert').removeClass().addClass('alert alert-success').show().delay(5000).fadeOut(1000);
                        $('#editarModal').modal('hide');
                        $('#datatables-plano-chamada').DataTable().ajax.reload(null, false);
                    },
                    error: function (error) {
                        if (error.responseJSON === 401 || error.responseJSON.message && error.statusText === 'Unauthenticated') {
                            window.location.href = "{{ url('/') }}";
                        }
                        // validator: vamos exibir todas as mensagens de erro do validador de campos
                        // como o dataType não é JSON, precisa do responseJSON
                        $.each( error.responseJSON.errors, function( key, value ) {
                            $("#error-" + key ).text(value).show(); //mostra todas as messagens de erros dos campos do form
                        });
                        // mostra mensagens de erro de Roles e Persistência em Banco
                        $('#msgOperacao').text(error.responseJSON.policyError).show();
                        $('#msgOperacao').text(error.responseJSON.message).show();
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
                $('#datatables-plano-chamada').DataTable().ajax.reload(null, false);    
            });

            // se usuário pode editar o Plano de Chamada
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
                        $("#numero").val("...");
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
                                $("#numero").val(dados.unidade);
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


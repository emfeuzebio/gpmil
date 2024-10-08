<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="description" content="" />
    <meta name="keywords" content="sistema, software, exército" />
    <meta name="robots" content="index,follow" />
    <meta name="author" content="Exército Brasileiro" />
    <title>DCEM - Painel Permanência</title>

    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/owl.carousel.min.css') }}">
    <link rel="stylesheet"
        href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300|Raleway:100,300,400,500,600,700,800'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('vendor/css/style.css') }}">

    <!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/respond.js"></script>
        <![endif]-->

</head>

<body>

    <div class="outer">

        <header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <figure>
                            <img src="img/dcem.png" alt="">
                        </figure>
                        <h3 class="text-center">DIRETORIA DE CONTROLE DE EFETIVOS E MOVIMENTAÇÕES</h3>
                    </div>
                </div>
            </div>
        </header>

        <div class="content">
            <div class="container-fluid principal">
                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="autoridade" id="autoridade-2">
                                            <img id="autoridade2img" src="" class="icone">
                                            <div class="conteudo-autoridade" id="conteudo-autoridade-2">
                                                <figure>
                                                    <img id="autoridade2foto" src="" alt="">
                                                </figure>
                                                <p id="autoridade2grad" class="grad"></p>
                                                <p id="autoridade2nome" class="militar"></p>
                                                <p id="autoridade2cargo" class="cargo"></p>
                                                <hr/>
                                                <p class="destino">
                                                    DESTINO
                                                </p>
                                                <select name="" id="selectdir" class="destsubdiretor">
                                                    <option>--</option>
                                                    <option class="prontonaom" value="pronto">PRONTO NO QGEX</option>
                                                    <option class="despacho" value="despachoexterno">DESPACHO EXTERNO</option>
                                                    <option class="despacho" value="despachointerno">DESPACHO INTERNO</option>
                                                    <option>ALMOÇO</option>
                                                    <option>SOLENIDADE EXTERNA</option>
                                                    <option>FORMATURA</option>
                                                    <option>VOT CMA</option>
                                                    <option>VOT CML</option>
                                                    <option>VOT CMN</option>
                                                    <option>VOT CMNE</option>
                                                    <option>VOT CMS</option>
                                                    <option>VOT CMSE</option>
                                                    <option>VOT CMO</option>
                                                    <option>VOT CMP</option>
                                                    <option>VOT RM</option>
                                                    <option>GAB CMT EX</option>
                                                    <option>CIE</option>
                                                    <option>CCOMSEX</option>
                                                    <option>SGEX</option>
                                                    <option>EME</option>
                                                    <option>DGP</option>
                                                    <option>DEC</option>
                                                    <option>DCT</option>
                                                    <option>COTER</option>
                                                    <option>SEF</option>
                                                    <option>COLOG</option>
                                                    <option>DSM</option>
                                                    <option>DAPROM</option>
                                                    <option>DAP</option>
                                                    <option>DSAU</option>
                                                    <option>DOM</option>
                                                    <option>DGO</option>
                                                    <option>DPGO</option> 
                                                    <option>D CONT</option>
                                                    <option>CPEX</option>
                                                    <option>D ABST</option>
                                                    <option>D MNT</option>
                                                    <option>D MAVEX</option>
                                                    <option>DFPC</option>
                                                    <option>MD</option>
                                                    <option>EsSA</option>
                                                    <option>PCI OM</option>
                                                    <option>PCI EE</option>
                                                    <option>FÉRIAS</option>
                                                    <option>DISPENSA
                                                    <option>PASSAGEM DE FUNÇÃO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="autoridade" id="autoridade-1">
                                            <img id="autoridade1img" src="" class="icone">
                                            <div class="conteudo-autoridade" id="conteudo-autoridade-1">
                                                <figure>
                                                    <img id="autoridade1foto" src="" alt="">
                                                </figure>
                                                <p id="autoridade1grad" class="grad"></p>
                                                <p id="autoridade1nome" class="militar"></p>
                                                <p id="autoridade1cargo" class="cargo"></p>
                                                <hr/>
                                                <p class="destino">
                                                    DESTINO
                                                </p>
                                                <select name="" id="select" class="destdiretor">
                                                    <option>--</option>
                                                    <option class="prontonaom" value="pronto">PRONTO NO QGEX</option>
                                                    <option class="despacho" value="despachoexterno">DESPACHO EXTERNO</option>
                                                    <option class="despacho" value="despachointerno">DESPACHO INTERNO</option>
                                                    <option>ALMOÇO</option>
                                                    <option>INSTALAÇÃO</option>
                                                    <option>SOLENIDADE EXTERNA</option>
                                                    <option>FORMATURA</option>
                                                    <option>VOT CMA</option>
                                                    <option>VOT CML</option>
                                                    <option>VOT CMN</option>
                                                    <option>VOT CMNE</option>
                                                    <option>VOT CMS</option>
                                                    <option>VOT CMSE</option>
                                                    <option>VOT CMO</option>
                                                    <option>VOT CMP</option>
                                                    <option>VOT RM</option>
                                                    <option>GAB CMT EX</option>
                                                    <option>CIE</option>
                                                    <option>CCOMSEX</option>
                                                    <option>SGEX</option>
                                                    <option>EME</option>
                                                    <option>DGP</option>
                                                    <option>DEC</option>
                                                    <option>DCT</option>
                                                    <option>COTER</option>
                                                    <option>SEF</option>
                                                    <option>COLOG</option>
                                                    <option>DSM</option>
                                                    <option>DAPROM</option>
                                                    <option>DAP</option>
                                                    <option>DSAU</option>
                                                    <option>DOM</option>
                                                    <option>DGO</option>
                                                    <option>DPGO</option> 
                                                    <option>D CONT</option>
                                                    <option>CPEX</option>
                                                    <option>D ABST</option>
                                                    <option>D MNT</option>
                                                    <option>D MAVEX</option>
                                                    <option>DFPC</option>
                                                    <option>MD</option>
                                                    <option>EsSA</option>
                                                    <option>PCI OM</option>
                                                    <option>PCI EE</option>
                                                    <option>FÉRIAS</option>
                                                    <option>DISPENSA
                                                    <option>PASSAGEM DE FUNÇÃO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="aniversariante" id="aniversariante">
                                    <img src="{{ asset('vendor/img/celotex/figuras/aniversariantes.png') }}" class="icone">
                                    <h4>Aniversariantes da Semana</h4>
                                    <div class="conteudo-aniversariante" id="conteudo-aniversariante">
                                        @if ($aniversariantes->isEmpty())
                                            <p>Não há aniversariantes nesse mês.</p>
                                        @else
                                            <ul class="datas">
                                                @foreach ($aniversariantes as $aniversariante)
                                                @php
                                                    $meses = ['Jan' => 'Jan', 'Feb' => 'Fev', 'Mar' => 'Mar', 'Apr' => 'Abr', 'May' => 'Maio', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Ago', 'Sep' => 'Set', 'Oct' => 'Out', 'Nov' => 'Nov', 'Dec' => 'Dez'];
                                                    $mesAbreviado = $meses[Carbon\Carbon::parse($aniversariante->dt_nascimento)->format('M')];
                                                @endphp
                                                <li id="datas">{{ $aniversariante->status == 'Reserva' ? $aniversariante->pgrad->sigla . ' R1' : $aniversariante->pgrad->sigla }}<strong> {{ $aniversariante->nome_guerra }}</strong> - {{ Carbon\Carbon::createFromFormat('Y-m-d', $aniversariante->dt_nascimento)->format('d') . '/' . $mesAbreviado }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="guarnicao" id="guarnicao">
                                            <img src="{{ asset('vendor/img/celotex/figuras/guarnicao.png') }}" class="icone">
                                            <h4>Guarnição de Serviço</h4>
                                            <div class="conteudo-guarnicao" id="conteudo-guarnicao">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="titulo">
                                                            Permanência
                                                        </p>
                                                        <select id="permanencia" class="militares">
                                                        <?php
                                                            $listas = DB::table('pessoas')
                                                                ->join('pgrads', 'pessoas.pgrad_id', '=', 'pgrads.id')
                                                                ->select('pessoas.nome_guerra', 'pgrads.sigla')
                                                                ->where('pessoas.ativo', 'SIM')
                                                                ->whereIn('pgrad_id', [22, 23, 24]) // Usa whereIn para valores múltiplos
                                                                ->get();

                                                            $html = '';
                                                            $html .= '<option value="">Selecione</option>';
                                                            
                                                            foreach ($listas as $lista) {
                                                                $html .= '<option value="'.$lista->nome_guerra.'">'.$lista->sigla.' - '.$lista->nome_guerra.'</option>';
                                                            }

                                                            echo $html;
                                                            
                                                        ?>
                                                        </select>
        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="titulo">
                                                            Auxiliar
                                                        </p>
                                                        <select id="aux1piso" class="militares">
                                                            <?php
                                                            $listas = DB::table('pessoas')
                                                                ->join('pgrads', 'pessoas.pgrad_id', '=', 'pgrads.id')
                                                                ->select('pessoas.nome_guerra', 'pgrads.sigla')
                                                                ->where('pessoas.ativo', 'SIM')
                                                                ->whereIn('pgrad_id', [42, 44, 49]) // Usa whereIn para valores múltiplos
                                                                ->get();

                                                            $html = '';
                                                            $html .= '<option value="">Selecione</option>';
                                                            
                                                            foreach ($listas as $lista) {
                                                                $html .= '<option value="'.$lista->nome_guerra.'">'.$lista->sigla.' - '.$lista->nome_guerra.'</option>';
                                                            }

                                                            echo $html;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="datahora" id="datahora">
                                            <img src="{{ asset('vendor/img/celotex/figuras/dataehora.png') }}" class="icone">
                                            <h4>Data e Hora</h4>
                                            <div class="conteudo-datahora" id="conteudo-datahora">
                                                <div class="hora" id="hora"></div>
                                                <hr/>
                                                <div class="dia" id="dia"></div>
                                                <hr/>
                                                <div class="data" id="data"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="atividade" id="atividade" >
                                            <img src="{{ asset('vendor/img/celotex/figuras/atividade.png') }}" class="icone">
                                            <h4>Atividades Internas</h4>
                                            <div class="conteudo-atividade" id="conteudo-atividade">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <ul id="lista" class="lista">
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <section class="news" id="news">
                            <div class="owl-carousel" id="owl-carousel-news"></div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <p id="rodape">Controlando, Selecionando e Movimentando a Dimensão Humana da Força.</p>
                    </div>
                </div>
            </div>
        </footer>

    </div>
    <script>
        var informativosUrl = "{{ asset('vendor/img/informativos.txt') }}";
        var baseImageUrl = "{{ asset('vendor/img/') }}";
    </script>
    
    <script src="{{ asset('vendor/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('vendor/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/js/config.js') }}"></script>

</body>

</html>
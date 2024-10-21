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
    {{-- <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300|Raleway:100,300,400,500,600,700,800' rel='stylesheet' type='text/css'> --}}
    <link rel="stylesheet" href="{{ asset('vendor/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/googlefont.css') }}" type="text/css">

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
                            <img src="{{ asset('vendor/img/celotex/figuras/dcem.png') }}" alt="">
                        </figure>
                        <h3 class="text-center">DIRETORIA DE CONTROLE DE EFETIVOS E MOVIMENTAÇÕES</h3>
                    </div>
                </div>
            </div>
        </header>

        <div class="content"  id="app">
            <div class="container-fluid principal">
                <dikv class="row">
                    <div class="col-md-7">
                        <div class="row" >
                            {{-- ************************** AUTORIDADES ************************** --}}
                            <div class="col-md-8">
                                <Celotex />
                            </div>
                            <div class="col-md-4">
                                <Aniversariantes />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <Guarnicao />
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
                                                    <div id="scroll-infinito" class="col-md-12">
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
    
</body>

</html>
@vite('resources/js/app.js')
    <script>
        var informativosUrl = "{{ asset('vendor/img/informativos.txt') }}";
        var baseImageUrl = "{{ asset('vendor/img/') }}";
    </script>
    
    <script src="{{ asset('vendor/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('vendor/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/js/config.js') }}"></script>
    <script>
        var tempo;
        function rolar(e){
            if(e){
                tempo = setInterval(function(){
                    var doc_scrl = document.documentElement.scrollTop;
                    var maxScroll = document.documentElement.scrollHeight - window.innerHeight;
                    
                    if (doc_scrl >= maxScroll) {
                        // Se a rolagem chegar ao final, volta para o topo
                        window.scrollTo(0, 0);
                    } else {
                        // Continua rolando a página
                        window.scroll(0, doc_scrl + 2);
                    }
                }, 50);
            } else {
                clearInterval(tempo);
            }
        }
    </script>
    
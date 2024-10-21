$(document).ready(function () {

    function carregarBannerRotativo() {

        owlnews = $('#owl-carousel-news');
        newsoptions = {
            autoplay: true,
            loop: true,
            margin: 10,
            autoplayTimeout: 8000,
            smartSpeed: 1800,
            onInitialized: ajustaTamanhoDosQuadros,
            responsive: {
                0: {
                    items: 1
                },
                350: {
                    items: 1
                },
                490: {
                    items: 1
                },
                1000: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        }

        owlnews.owlCarousel(newsoptions);

    }

    function carregarInformativos() {
        var html = '';
    
        // Fazendo a requisição AJAX para buscar as imagens ativas
        $.get('/slides/ativos', function (slides) {
            $.each(slides, function (i, slide) {
                // Usando o caminho da imagem do banco de dados
                html += '<div><div class="box"><img src="' + slide + '" class="img-fluid" style="height: 86vh" /></div></div>';
            });
    
            // Atualizando o conteúdo da div #owl-carousel-news com o HTML gerado
            $('#owl-carousel-news').html(html);
        }).done(function () {
            carregarBannerRotativo();
        });
    }
    
    carregarInformativos();

    function ajustaTamanhoDosQuadros() {

        function ajusta() {

            var image = $('#news');
            // var imageHeight = 1000;
            var imageHeight = image.height();
            var painel = imageHeight / 2;
            $('.aniversariante').animate({ height: painel + 'px' }, 500);
            $('.autoridade').animate({ height: painel + 'px' }, 500);
            $('.datahora').animate({ height: (painel - 30) + 'px' }, 500);
            $('.guarnicao').animate({ height: (painel - 30) + 'px' }, 500);
            $('.atividade').animate({ height: (painel - 30) + 'px' }, 100);

        }
                
        function alinhaOsDemaisConteudos() {

            setTimeout(function () {

                janelas = ['aniversariante', 'autoridade-1', 'autoridade-2', 'datahora', 'guarnicao', 'atividade'];
                $.each(janelas, function (i, janela) {
                    var tamanhoAtualJanela = $('#' + janela).height();
                    var tamanhoAtualFilho = $('#conteudo-' + janela).height();
                    var tamanhoFinalCalc = (tamanhoAtualJanela - tamanhoAtualFilho) / 2;
                    $('#conteudo-' + janela).animate({ marginTop: tamanhoFinalCalc + "px" });
                });

            }, 1000);

        }

        setTimeout(function () {

            $.ajax({

                url: ajusta(),
                success: function () {
                    alinhaOsDemaisConteudos();
                }

            });

        }, 500);

    }

    function formatDataHora(dataHora) {
        if (!dataHora) return '';
        const date = new Date(dataHora);
        const day = String(date.getDate()).padStart(2, '0');

        const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        const month = meses[date.getMonth()];

        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
    
        return `${day} ${month} - ${hours}:${minutes}`;
    }

    function carregaAtividades() {
        var html = '';
    
        $.get('/atividades/ativos', function (atividades) {
            atividades.forEach(function (atividade) {
                html += '<li class="item">' + '<strong class="text-warning">' + atividade.nome + '</strong>' + '<br>' + '<strong>Local: </strong>' + atividade.local + '<br><strong>Data Hora: </strong>' + formatDataHora(atividade.data_hora) + '<br>' + atividade.descricao + '</li>';
            });
    
            $('#lista').html(html);

                        // Verifica se há mais de 3 itens
            if ($('#lista .item').length > 2) {
                $('#lista .item').each(function() {
                    let duplicado = $(this).clone(); // Clona o item
                    $('#lista').append(duplicado); // Adiciona o item clonado de volta à lista
                });

                $('#lista').addClass('scroll-infinito'); // Adiciona a classe que ativa a animação
                $('#scroll-infinito').addClass('scroll'); // Adiciona a classe que ativa a animação

            } else {
                $('#lista').removeClass('scroll-infinito'); // Remove a classe se não houver mais de 3 itens
                $('#scroll-infinito').removeClass('scroll'); // Remove a classe se não houver mais de 3 itens
            }
        });
    }
    
    carregaAtividades();
    

    function carregarHora() {

        function startTime() {

            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            return (h + ":" + m + ":" + s);

        }

        function checkTime(i) {

            if (i < 10) {
                i = "0" + i;
            }
            return i;

        }

        setInterval(function () {

            var hora = startTime();
            $('#hora').text(hora);

        }, 500);

    }

    carregarHora();

    function carregarData() {

        data = new Date();
        var day = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"][data.getDay()];
        var date = data.getDate();
        var month = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"][data.getMonth()];
        var year = data.getFullYear();
        $('#dia').text(`${day}`);
        $('#data').text(`${date} de ${month} de ${year}`);

    }

    carregarData();

    
    $(window).on('resize', function () {

        setTimeout(function () {

            ajustaTamanhoDosQuadros();

        }, 2000);

    }); 

    function carregarRodape() {

        var rodape = [];
        var html = '';

        $.get('rodape/rodape.txt', function (txt) {

            var lines = txt.split("\n");
            for (var i = 0, len = lines.length; i < len; i++) {

                rodape.push(lines[i]);

            }

            $('#rodape').text(rodape[0]);

        });

    }

    carregarRodape();

});
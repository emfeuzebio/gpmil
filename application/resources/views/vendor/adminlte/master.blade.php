<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'GPMil'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

        <!-- Implementa DataTables -->
        <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" >
        <link href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap4.min.css" rel="stylesheet">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">


        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        @if(config('adminlte.google_fonts.allowed', true))
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @endif
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

    <style>
        /*  Classe customizada para exibir o Efetivo na home  */
        .custom-col {
          flex: 0 0 19%;
          max-width: 19%;
          margin-right: 1%;
          position: relative;
          width: 100%;
          padding-right: 7.5px;
          padding-left: 7.5px;
        }
      
        .custom-col:last-child {
          margin-right: 0;
        }
      
      </style>

</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

        <!-- EUZ DataTables Buttons  -->
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>

        <!-- EUZ DataTables Buttons - https://cdn.datatables.net/ -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.colVis.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
        <script src="https://kit.fontawesome.com/ee8c259d94.js" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>


    <!-- EUZ javascript com configurações iniciais -->
    <script type="text/javascript" language="javascript" class="init">

        $(document).ready(function () {
            
            // configura os Modais para terem seu conteúdo limpo ao serem fechados (hide)
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
                $('.invalid-feedback').text('').hide();
                //alert('Fechou Modal');
            });

            //ativa o tooltip nas páginas
            $('body').tooltip({ selector: '[data-toggle="tooltip"]'});

            // ativa autofocus automático sempre no primeiro input dentro do modal
            $(document).on('shown.bs.modal', function (e) {
                $('select:input:visible:not([readonly]):first', e.target).focus();
            });

            //controla a exibição do Loading dos Ajax para todas as páginas
            $(document).on({
                ajaxStart: function () {
                    $("#datatables_processing").show(); // ID que puxa o loading do datatable
                },
                ajaxStop: function () {
                    $("#datatables_processing").hide(); // ID que puxa o loading do datatable
                }            
            });

        });

        // Seleciona todos os elementos select
        $('select').each(function() {
            // Adiciona o atributo data-style
            $(this).attr('data-style', 'form-control btn-light');
            // Adiciona uma leve borda
            $(this).addClass('border');
        });

    </script>  
    
    <!-- EUZ 5 Hotkeys manipular registros em todos CRUDs -->
    <script type="text/javascript">

        /*
        * Início 5 Hotkeys manipular registros
        * implementar usando uma classe específica em cada botão
        */
        document.addEventListener("keydown", function(event) {
    
                //hotkey tecla Alt+S - Salvar Registro
                if (event.altKey && event.code === "KeyS") {
                    // alert('Alt + S pressed!');Mov
                    $("button.btnSalvar").trigger('click');
                    event.preventDefault();
                }
    
                //hotkey tecla Alt+E - Excluir Registro
                if (event.altKey && event.code === "KeyE") {
                    // alert('Alt + E pressed!');
                    $(".btnExcluir").trigger('click');
                    event.preventDefault();
                }
    
                //hotkey tecla Alt+C - Cancelar Registro
                if (event.altKey && event.code === "KeyC") {
                    // alert('Alt + C pressed!');
                    $(".btnCancelar").trigger('click');
                    event.preventDefault();
                }

                //hotkey tecla Alt+N - Incluir Novo Registro
                if (event.altKey && event.code === "KeyN") {
                    // alert('Alt + N pressed!');
                    $(".btnInserirNovo").trigger('click');
                    event.preventDefault();
                }
    
                //hotkey tecla Alt+R - Refresh nos regristos do DataTables
                if (event.altKey && event.code === "KeyR") {
                    //alert('Alt + R pressed!');
                    $(".btnRefresh").trigger('click');
                    event.preventDefault();
                }
            /*
             * FIM 5 Hotkeys manipular registros
             * implementar usando uma classe específica em cada botão
             */
    
        });
    
    </script>

    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>

</html>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        @php
        $index = route('index');
        @endphp
        <title>{{$title}}</title>
        <meta name="description" content="Pesquisa Ensino Médio"/>
        <meta name="viewport" content="width=device-width, initia-scale=2.0"/>
        <!--<link rel="stylesheet" href="css/bootstrap.min.css"/>-->          
       
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        
        <link rel="stylesheet" href="{{$index}}/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{$index}}/css/controleAlunoStyle.css">
        
        
        <link  href="{{$index}}/css/select2.min.css" rel="stylesheet" />
        <script src="{{$index}}/js/jquery-1.12.4.js"></script>
        <script src="{{$index}}/js/jquery-ui.js"></script>
        <script src="{{$index}}/js/select2.full.min.js"></script>
        <script src="{{$index}}/js/js_controlealuno.js"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <header id="header" class="main-header">


        </header>
        <!--FECHA CABEÇALHO-->

        <div class="" style="min-height: 100px;">
            <main class="text-dark-blue bg-white">            
                <!--ARTIGO DESTAQUE-->
                @yield('content')
                <!--TÓPICOS-->
            </main>     
        </div>

        
    </body>
</html>

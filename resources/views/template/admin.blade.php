<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
 
  <title>SEG - Sistema de Segurança</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Select2 style -->
  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}"  />
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">

  <link rel="stylesheet" href="{{ asset('css/controleAlunoStyle.css') }}">
        
        
    
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{route('home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>EG</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><i class="fa fa-key"></i> Sis. Segurança</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
            @if (Auth::guest())
            <li><a href="{{ route('login') }}">Login</a></li>
            @else
            <li><a href="{{ route('register') }}">Registrar</a></li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!--<img src="{{ asset('dist/img/avatar.png') }}" class="user-image" alt="User Image">-->
                <span class="hidden-xs">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
<!--                    <img src="{{ asset('dist/img/avatar.png') }}" class="img-circle" alt="User Image">-->

                    <p>
                      {{ Auth::user()->name }}
                      <small>{{ Auth::user()->email }}</small>
                      CPF: {{ Auth::user()->cpf }}
                    </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                      
                      <div class="col-xs-4 text-center">
                        <a href="{{route('home')}}">Perfil</a>
                      </div>
                        <div class="col-xs-4 text-center">
                        <a href="{{route('edit')}}">Editar</a>
                      </div>
                        
                    </div>
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                      <!--<a href="#" class="btn btn-default btn-flat">Perfil</a>-->
                    </div>
                    <div class="pull-right">
                      <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          Sair
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                    </div>
                </li>
              </ul>
            </li>
            @endif
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  @if(Auth::check())
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menu Principal</li>       
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Usuários</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('buscarpessoa')}}"><i class="fa fa-circle-o"></i> Cadastrar</a></li>
            <li><a href="{{route('buscarusuarios')}}"><i class="fa fa-circle-o"></i>Gerenciar</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-group"></i> <span>Grupos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('grupos')}}"><i class="fa fa-circle-o"></i> Relação de Grupos</a></li>            
          </ul>
        </li>     
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
@endif
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
      @yield('content')
      
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <!--<b>Version</b> 2.4.0-->
    </div>
    <strong>Gerencia de Sistemas - <a href="http://seduc.to.gov.br/">Secretaria da Educação, Juventude e Esportes</a>.</strong><br>
    sistemas@seduc.to.gov.br 
  </footer>

  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- jQuery Mask  -->
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('bower_components/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<!-- bootstrap color picker -->
<script src="{{ asset('bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>

<script src="{{ asset('/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/js/js_controlealuno.js') }}"></script>
</body>
</html>

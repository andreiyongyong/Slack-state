<!DOCTYPE html> 
<html>
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">  

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>SQ Tecnology</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset("/bower_components/AdminBSB/plugins/bootstrap/css/bootstrap.css") }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset("/bower_components/AdminBSB/plugins/node-waves/waves.css") }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset("/bower_components/AdminBSB/plugins/animate-css/animate.css") }}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{ asset("/bower_components/AdminBSB/plugins/morrisjs/morris.css") }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset("/bower_components/AdminBSB/css/style.css") }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset("/bower_components/AdminBSB/css/themes/all-themes.css") }}" rel="stylesheet" />
  </head> 

  <body class="theme-red">
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <div class="overlay"></div>

    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>

    <!-- Main Header -->
    @include('layouts.header')
    <!-- Sidebar -->
    @include('layouts.sidebar')
    @yield('content')
    <!-- /.content-wrapper -->
    <!-- Footer -->
    @include('layouts.footer')
    <!-- ./wrapper -->
    <!-- REQUIRED JS SCRIPTS --> 

    <!-- Jquery Core Js -->
    <!-- <script src="{{ asset ("/bower_components/AdminBSB/plugins/jquery/jquery.min.js") }}"></script> -->
    
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


    <!-- Bootstrap Core Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/bootstrap/js/bootstrap.js") }}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/bootstrap-select/js/bootstrap-select.js") }}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/jquery-slimscroll/jquery.slimscroll.js") }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/node-waves/waves.js") }}"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/jquery-countto/jquery.countTo.js") }}"></script>

    <!-- Morris Plugin Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/raphael/raphael.min.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/morrisjs/morris.js") }}"></script>

    <!-- ChartJs -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/chartjs/Chart.bundle.js") }}"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/flot-charts/jquery.flot.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/flot-charts/jquery.flot.resize.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/flot-charts/jquery.flot.pie.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/flot-charts/jquery.flot.categories.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/flot-charts/jquery.flot.time.js") }}"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/jquery-sparkline/jquery.sparkline.js") }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/js/admin.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminBSB/js/pages/index.js") }}"></script>

    <!-- Demo Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/js/demo.js") }}"></script>
        
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
      <script>

            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!}; 

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
        
      $(document).ready(function() {
        //Date picker
        $('#birthDate').datepicker({
          autoclose: true,
          format: 'yyyy/mm/dd'
        });
        $('#hiredDate').datepicker({
          autoclose: true,
          format: 'yyyy/mm/dd'
        });
        $('#from').datepicker({
          autoclose: true,
          format: 'yyyy/mm/dd'
        });
        $('#to').datepicker({
          autoclose: true,
          format: 'yyyy/mm/dd'
        });
        $('#log_date').datepicker({
          autoclose: true,
          format: 'yyyy/mm/dd'
        });
    });
</script>
<script src="{{ asset('js/site.js') }}"></script>
  </body>
</html>
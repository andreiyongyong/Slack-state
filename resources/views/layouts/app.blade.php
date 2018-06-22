<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">  

    <!-- Bootstrap Core Css -->
    <link href="{{ asset("/bower_components/AdminBSB/plugins/bootstrap/css/bootstrap.css") }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset("/bower_components/AdminBSB/plugins/node-waves/waves.css") }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset("/bower_components/AdminBSB/plugins/animate-css/animate.css") }}" rel="stylesheet" />

    <link href="{{ asset("/bower_components/AdminBSB/css/style.css") }}" rel="stylesheet">

    <!-- Custom Css -->
    <link href="{{ asset("css/site.css") }}" rel="stylesheet"> 

    <title>{{ config('app.name', 'SQ Tec') }}</title> 
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">  
     <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous" -->
    <!-- Scripts -->
    <script> 
    </script>
</head>
<body  class="login-page signup-page">
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
    <div id="app">  
        @yield('content')
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/jquery/jquery.min.js") }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/bootstrap/js/bootstrap.js") }}"></script>    

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/node-waves/waves.js") }}"></script>
    <!-- Jquery Core Js --> 

    <!-- Validation Plugin Js -->
    <script src="{{ asset ("/bower_components/AdminBSB/plugins/jquery-validation/jquery.validate.js") }}"></script>

    <!-- Custom Js --> 
    <script src="{{ asset ("/bower_components/AdminBSB/js/admin.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminBSB/js/pages/examples/sign-in.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminBSB/js/pages/examples/sign-up.js") }}"></script> 
    <!-- Scripts -->
     
     <!--script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script -->
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script-->
    <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script-->
</body>
</html>

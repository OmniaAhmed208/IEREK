<!DOCTYPE html>
<html>
      <!-- START PLUGINS -->
      <head id="heads">
            <!-- Insert to your webpage before the </head> -->
            <script src="{{ asset('/front/carouselengine/jquery.js')}}"></script>
            <script src="{{ asset('/front/carouselengine/amazingcarousel.js')}}"></script>
            <link rel="stylesheet" type="text/css" href="{{ asset('/front/carouselengine/initcarousel-1.css')}}">
            <script src="{{ asset('/front/carouselengine/initcarousel-1.js')}}"></script>
            <!-- End of head section HTML codes -->
            <title id="head_title"> Ierek - Research & Knowledge Enrichment </title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="shortcut icon" type="image/x-icon" href="../uploads/images/logo-02.png">
            <meta name="_token" content="{{ csrf_token() }}">
            <link href="{{ asset('/front/font-awesome-4.3.0/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('/front/css/default.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('/front/font-awesome-4.3.0/css/font-awesome.min.css')}}" rel="styhttlesheet" type="text/css"/>
            <link href="{{ asset('/front/css/component.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('/front/css/pluginsCss.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('/front/css/animate.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('/front/css/newstyle.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('/front/css/custom.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('/front/css/jquery.mCustomScrollbar_1.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('/front/css/jquery-ui.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('/front/css/userpro.min.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('/front/css/userstyle.css')}}" rel="stylesheet" type="text/css"/>
            @stack('styles')
            <script type="text/javascript" src="{{ asset('/front/js/jssor.slider.min.js')}}"></script>
            <link href="{{ asset('/front/css/custom.css?v=0.9')}}" rel="stylesheet">
            <link href="{{ asset('/front/skins/all.css?v=0.9')}}" rel="stylesheet">
            <script src="{{ asset('/front/js/jquery.icheck.min.js?v=0.9')}}"></script>
            <script async src="{{asset('/front/scripts/jquery.mCustomScrollbar.concat.min.js')}}"></script>
            <script async src="{{asset('/front/scripts/jquery.scrollme.js')}}" type="text/javascript"></script>
            <script async src="{{asset('/front/bootstrap-sass-3.3.4/bootstrap-sass-3.3.4/assets/javascripts/bootstrap.min.js')}}" type="text/javascript"></script>
            <script async src="{{asset('/front/scripts/toucheffects.js')}}" type="text/javascript"></script>
            <script async src="{{asset('/front/scripts/jquery.newsTicker.min.js')}}" type="text/javascript"></script>
            <script async src="{{asset('/front/scripts/bootstrap-paginator.min.js')}}" type="text/javascript"></script>
            <script async src="{{asset('/front/scripts/scripts.js')}}" type="text/javascript"></script>
            <script async src="{{asset('/front/js/jquery-ui.js')}}" type="text/javascript"></script>
            
      </head>
      <body>
            @yield('content')
      </body>
</html>
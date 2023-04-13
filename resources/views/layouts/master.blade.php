<!DOCTYPE html>
<html>
<!-- START PLUGINS -->
<head id="heads">
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PDZLMWD');</script>
<!-- End Google Tag Manager -->
    <!-- Insert to your webpage before the </head> -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <script src="{{ asset('/front/carouselengine/jquery.js?v=3.4')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/carouselengine/initcarousel-1.css?v=3.4')}}">
    <!-- End of head section HTML codes -->
    <title id="head_title"> @if(isset($event)) {{ @$event->meta_title }} @else {{'IEREK - Research & Knowledge Enrichment'}} @endif </title>
    <meta name="description"
          content="@if(isset($event)) {{ @$event->meta_description }} @else Is an international institution that is concerned with the exchange of knowledge and enhancing research through organizing and managing conferences in all fields of knowledge. Organizing Workshops and Conferences in all fields. @endif">
    <meta name="keywords"
          content="@if(isset($event)) {{ @$event->meta_keywords }} @else research, conference, international conference organizer, workshops, workshop offer, scientific committee, scientific projects, architecture, engineering, urban design, ierek, irek, irik, iric, irec, abroad study offers @endif">
    <meta name="author" content="IEREK">
    <meta charset="UTF-8">
    
    <meta http-equiv=“Pragma” content=”no-cache”>

<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">

<meta name="google-site-verification"
content="KJ6zwrzl9nrW-4X_r6MYR_jaZ0dD-oFrLxXLkpzupB0" />


<meta http-equiv=“CACHE-CONTROL” content=”NO-CACHE”>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/front/images/IerekLogo.png')}}">
    <meta name="_token" content="{{ csrf_token() }}">
    @stack('styles')
    <link href="{{ asset('/css/font-awesome.min.css?v=3.4')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/front/bootstrap/css/bootstrap.min.css?v=3.4')}}">
    <link href="{{ asset('/front/css/jquery-ui.min.css?v=3.4')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('/front/css/newstyle.css?v=3.4')}}" rel="stylesheet" type="text/css"/>

    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id=409131099583923&ev=PageView&noscript=1"/>
              
    </noscript>
    <!-- End Facebook Pixel Code -->
</head>

<body>
    
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PDZLMWD"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div id="verified" style="display:none">

</div>

<!-- header -->
<div class="container">
    <nav class="navbar navbar-default">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header col-12 col-md-12">
            <div class="nav-icons-container">
                <div class="navbar-brand" href="#">
                    <a href="{{url('/')}}">
                        <img class="mainLogo" src="{{asset('/front/images/IerekLogo.png')}}"
                             alt="Research &amp; Knowledge Enrichment">
                    </a>
                </div>
                <div class="rightIcons">

                    <!-- Menu -->
                    <div class="menu_button-container activator collapsed-on-mobile">
                        <a href="#" data-toggle="collapse"
                           data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <div class="menu_button-container-contents" id="menuBtn">
                                <div class="menu_button-image hamburger_icon">
                                    <img src="{{asset('/front/images/menu-logo.png')}}" alt="menu">
                                </div>
                                <div class="menu_button-title">
                                    Menu
                                </div>
                            </div>
                        </a>
                    </div>

                    <!--login / logout Button -->
                    <div class="menu_button-container dropdown activator" id="closeLogin">
                        <a href="#" type="button" data-toggle="dropdown">
                            <div class="menu_button-container-contents" id="loginBtn">

                                <!-- logout html -->
                                <div class="menu_button-image">
                                    <!-- login html -->
                                    <img src="{{asset('/front/images/login.png')}}" alt="Login">
                                </div>
                                <div class="menu_button-title">
                                    @if( Auth::check() )
                                        {{'Profile'}}
                                        {{--{{ substr((Auth::user()->first_name), 0,5) }}--}}
                                        {{--@if(strlen(Auth::user()->first_name) > 6)--}}
                                        {{--{{ '..' }}--}}
                                        {{--@endif--}}
                                        <span class="caret"></span>
                                    @else
                                        {{ 'Sign in' }} <span class="caret"></span>
                                    @endif
                                </div>
                            </div>
                        </a>

                        <!-- drop down -->
                        @if( Auth::check() )

                            <ul class="dropdown-menu login-menu" id="mainLoginMenu">
                                <li class="activition username-showOnMobile-container">
                                    <a href="#"
                                       data-toggle="modal">
                                        You Logged in as:
                                        <br>
                                        {{Auth::user()->first_name." ".Auth::user()->last_name}}
                                    </a>

                                </li>
                                @if( Auth::user()->user_type_id >= 2)
                                    <li class="activition"><a href="{{ url('/admin') }}"
                                                              data-toggle="modal">Dashboard</a>
                                    </li>
                                @endif

                                <li class="activition">
                                    <a href="{{ url('profile') }}" data-toggle="modal">Profile</a>
                                </li>
                                <li class="activition">
                                    <a href="{{ url('messages') }}" data-toggle="modal">Messages <span
                                                class="msg-count"></span></a>
                                </li>
                                <li class="activition">
                                    <a href="{{ url('notifications') }}" data-toggle="modal">Notifications
                                        <span
                                                class="noti-count"></span></a>
                                </li>
                                <li class="activition">
                                    <a href="{{ url('/myevents') }}" data-toggle="modal">Manage Your
                                        Events</a>
                                </li>
                                <li class="activition">
                                    <a href="{{ url('/myabstracts') }}" data-toggle="modal">Manage Your
                                        Submissions</a>
                                </li>
                                <li class="activition">
                                    <a href="{{ url('/revision/abstract') }}" data-toggle="modal">Abstracts
                                        for
                                        Revision</a>
                                </li>
                                <li class="activition">
                                    <a href="{{ url('/revision/paper') }}" data-toggle="modal">Full Papers
                                        for
                                        Revision</a>
                                </li>
                                <li class="activition">
                                    <a href="{{ url('/billing') }}" data-toggle="modal">Billing</a>
                                </li>
                                <li class="activition">
                                    <a style="cursor:pointer"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                       href="{{ url('/logout') }}"
                                       data-toggle="modal">Logout</a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>

                            </ul>
                        @else
                            <ul class="dropdown-menu login-menu">
                                <li class="activation">
                                    <button type="button" class="btn-no-default-styles" data-toggle="modal"
                                            data-target="#signingInModal" id="signlink">
                                        Sign in
                                    </button>
                                </li>
                                <li class="activation">
                                    <button type="button" class="btn-no-default-styles" data-toggle="modal"
                                            data-target="#signingUpModal">Sign up
                                    </button>
                                </li>
                            </ul>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- Login overlay -->
        <div id="loginOverlay" class="loginModal" tabindex="-1" role="dialog" aria-hidden="true">

            <form class="login_modal-content animate" action="{$userBlockLoginUrl}" method="post">
                <div class="closeBtncontainer">
                <span id="closeModal" class="loginClose" title="Close Modal">
                    &times;
                </span>
                </div>
                <div class="loginOverlay-main_content-container">
                    <label for="username" class="inputField_label">
                        <b>username</b>
                    </label>
                    <input type="text" placeholder="username" name="username"
                           class="input_field" required>

                    <label for="password" class="inputField_label">
                        <b>Password</b>
                    </label>
                    <input type="password" placeholder="password" name="password"
                           class="input_field" required>

                    <button type="submit" class="loginButton">Login</button>
                    <label class="checkboxLabel">
                        <input type="checkbox" checked="checked" name="remember">
                        Remember me
                    </label>
                </div>

                <div class="loginOverlay-navigation_content-container">
                    <a href="#">
                        <button type="button" class="cancelbtn">
                        <span class="hidden-mobile">
                            Register
                        </span>
                        </button>
                    </a>
                    <span class="psw">
                    <a href="#">Forgot password</a>
                </span>
                </div>
            </form>

        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav border-around">

                <li class="menu-item dropdown activition">
                    <a href="/" data-toggle="dropdown" class="dropdown-toggle"><img class="iereklogosmall"
                                                                                    src="{{asset('ierek.png')}}"
                                                                                    height="20" data-toggle="dropdown"
                                                                                    class="dropdown-toggle">About<span
                                class="caret"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        {{--<li class="activition"><a href="/">Home</a></li>--}}
                        <li class="activition" data-url="/about-us"><a href="/about-us">About Us</a>
                        </li>
                           </li>
                <li class="activition" data-url="faq"><a
                            href="/faq">
                        FAQ
                    </a>
                </li>
                <li class="activition" data-url="contact-us"><a
                            href="/contact-us">
                        Contact Us
                    </a>
             
                        <li class="activition" data-url="/terms-conditions"><a href="/terms">Terms &
                                Conditions</a>
                        </li>
                    </ul>
                </li>

                <li id="menu-item-11198" class="menu-item dropdown activition" data-url="conference">
                    <a href="#"
                       data-toggle="dropdown"
                       class="dropdown-toggle">Conferences<span class="caret"></span>
                    </a>
                    <ul role="menu" class=" dropdown-menu">
                        <li class="menu-item" class="activition" data-url="conferences"><a href="/conferences">
                                Conferences</a></li>
<!--                        <li class="menu-item" class="activition" data-url="conferences"><a
                                    href="/conferences/previous">Previous
                                Conferences</a></li>
                        <li class="menu-item" class="activition" data-url="conferences"><a href="{{url("calendar ")}}">Calendar</a>
                        </li>-->
                        <li class="menu-item" class="activition" data-url="conferences"><a
                                    href="/conference_proceedings">Previous Publications</a></li>
                    </ul>
                </li>
                {{--<li class="activition menu-item" data-url="workshops"><a href="/workshops">Workshops</a></li>--}}
                <li class="menu-item dropdown activition" data-url="study_abroad_categories"><a href="/study_abroad"
                                                                                                data-toggle="dropdown"
                                                                                                class="dropdown-toggle">Study
                        Abroad<span class="caret"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        <li class="menu-item"><a href="/study_abroad">About Study Abroad</a></li>
                        <li class="menu-item"><a href="/study_abroad_categories#Summer-Schools">Summer
                                schools</a>
                        </li>
                        <li class="menu-item"><a href="/study_abroad_categories#Winter-Schools">Winter
                                schools</a>
                        </li>
                        <li class="menu-item"><a href="/study_abroad_categories/undergraduate-studies">Undergraduate
                                studies</a></li>
                        <li class="menu-item"><a href="/study_abroad_categories#Postgraduate-Studies">Postgraduate
                                studies</a></li>
                    </ul>
                </li>
                
             
<li id="menu-item-11198" class="menu-item dropdown activition" data-url="conference">
                    <a href="#"
                       data-toggle="dropdown"
                       class="dropdown-toggle">Scientific Committee<span class="caret"></span>
                    </a>
                    <ul role="menu" class=" dropdown-menu">
                        <li class="menu-item" class="activition" data-url=""><a href="/scientific-committee">
                                IEREK SC Members</a></li>

                        <li class="menu-item" class="activition" data-url="conferences"><a
                                    href="https://www.ierek.com/news/index.php/alliance/">WAPS Members</a></li>
                    </ul>
                </li>


              <li class="menu-item dropdown activition" data-url="ierek-press"><a href="https://www.ierek.com/news/">Media</a>
                </li>
                
                <li class="menu-item dropdown activition" data-url="ierek-press"><a href="https://press.ierek.com">IEREK Press</a>
                </li>
                <li class="menu-item dropdown activition" data-url="book-series"><a href="https://www.springer.com/series/15883"><img
                                src="{{asset('springer.png')}}" height="21"> Book Series</a></li>
                {{--<li class="menu-item dropdown activition" data-url="contact-us"><a href="#" data-toggle="dropdown"--}}
                {{--class="dropdown-toggle">Contacts<span--}}
                {{--class="caret"></span></a>--}}
                {{--<ul role="menu" class="dropdown-menu">--}}
                {{--<li class="activition" data-url="contact-us"><a href="/contact-us">Contact--}}
                {{--Us</a>--}}
                {{--</li>--}}
                {{--<li class="activition" data-url="faq"><a href="/faq">FAQ</a></li>--}}
                {{--</ul>--}}
                {{--</li>--}}
                <li class="menu-item dropdown activition" data-url="Additional"><a
                            href="https://www.ierek.com/news/index.php/iereks-additional-services/">
                        Additional Services
                    </a>
             

            </ul>
        </div>
    </nav>
</div>
<!--end header-->
<!-- CONTENT -->
@yield('content')
<!-- CONTENT END -->
{{--<footer class="main-footer">--}}
    {{--<div class="container">--}}
        {{--<div class="flex-footer">--}}
            {{--<div class="button-footer">--}}
                {{--<ul class="nav nav-pills">--}}
                    {{--<li role="presentation"><a href="/careers">Careers</a></li>--}}
                    {{--<li role="presentation"><a href="/suggest">Suggest</a></li>--}}
                    {{--<li role="presentation"><a href="/feedback">Feedback</a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}

            {{--<div class="banks">--}}
                {{--<!--                    <li><h6>We_accept</h6></li>-->--}}

                {{--<div><img class="mastercardlogo" src="{{asset('/front/images/Mastercard-Logo-Wallpapers-3.png')}}"--}}
                          {{--alt=""/></div>--}}
                {{--<div><img class="ciblogo" src="{{asset('/front/images/cib.jpg')}}" alt=""/></div>--}}
            {{--</div>--}}
            {{--<div class="social-icons">--}}
                {{--<ul>--}}
                {{--<!--                    <li><h6>Follow_us_on</h6></li>-->--}}
                {{--<li><a target="_blank" href="https://www.linkedin.com/company/ierek-institution/"><i--}}
                {{--class="fa fa-linkedin-square fa-2x"></i></a></li>--}}
                {{--<li><a target="_blank" href="https://fb.com/ierek.institute"><i--}}
                {{--class="fa fa-facebook-square fa-2x"></i></a></li>--}}
                {{--<li><a target="_blank" href="https://twitter.com/ierek_institute"><i--}}
                {{--class="fa fa-twitter-square fa-2x"></i></a></li>--}}
                {{--<li><a target="_blank" href="https://www.instagram.com/ierek_institute/"><i--}}
                {{--class="fa fa-instagram fa-2x"></i></a></li>--}}
                {{--<li><a target="_blank" href="https://www.youtube.com/channel/UCVp7eGOwMqTYtEYYxJL0uow"><i--}}
                {{--class="fa fa-youtube-square fa-2x"></i></a></li>--}}
                {{--<li><a target="_blank" href="https://play.google.com/store/apps/details?id=com.makdev.ierek"><i--}}
                {{--class="fa fa-android fa-2x"></i></a></li>--}}
                {{--<li><a target="_blank" href="https://itunes.apple.com/us/app/ierek/id1288803675?mt=8"><i--}}
                {{--class="fa fa-apple fa-2x"></i></a></li>--}}
                {{--</ul>--}}

                {{--<div class="agileinfo-social-grids">--}}
                    {{--<ul>--}}
                        {{--<a href="https://fb.com/ierek.institute"><i class="fa fa-facebook"></i></a>--}}
                        {{--<a href="https://twitter.com/ierek_institute"><i class="fa fa-twitter"></i></a>--}}
                        {{--<a href="https://www.youtube.com/channel/UCVp7eGOwMqTYtEYYxJL0uow"><i class="fa fa-youtube"></i></a>--}}
                        {{--<a href="https://www.linkedin.com/company/ierek-institution/"><i class="fa fa-linkedin"--}}
                                                                                         {{--aria-hidden="true"></i></a>--}}
                        {{--<a href="https://www.instagram.com/ierek_institute/"><i class="fa fa-instagram"--}}
                                                                                {{--aria-hidden="true"></i></a>--}}
                        {{--<a href="https://play.google.com/store/apps/details?id=com.makdev.ierek"><i--}}
                                    {{--class="fa fa-android"></i></a>--}}
                        {{--<a href="https://itunes.apple.com/us/app/ierek/id1288803675?mt=8"><i--}}
                                    {{--class="fa fa-apple"></i></a>--}}

                    {{--</ul>--}}
                {{--</div>--}}

            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}

{{--</footer>--}}
<div class="container-fluid footer">
    <!-- Footer -->
    <footer>

        <!-- Footer Links -->
        <div class="container">


            <!-- Footer links -->
            <div class="row">
                <div class="col-md-3 col-lg-3 col-xl-3 grid-column">
                    <h4 class="grid-column-h4">
                        <span class="underline">Educational Services</span>
                    </h4>
                    <hr class="grid-column-hr">
                    <p>
                        <a href="/conferences">Conferences
                        </a>
                    </p>
                    <p>
                        <a href="/workshops">Workshops
                        </a>
                    </p>
                    <p>
                        <a href="/study_abroad">Study Abroad
                        </a>
                    </p>
                    <p>
                    </p>
                </div>
                <!-- Grid column -->


                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 grid-column">
                    <h4 class="grid-column-h4">
                        <span class="underline">Publishing Services</span>
                    </h4>
                    <hr class="grid-column-hr">
                    <p>
                        <a href="/book-series">Book Series
                        </a>
                    </p>
                    <p>
                        <a href="/ierek-press">IEREK Press
                        </a>
                    </p>
                    <p>
                        <a href="/scientific-committee">Scientific Committee
                        </a>
                    </p>
                </div>
                <!-- Grid column -->


                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 grid-column">
                    <h4 class="grid-column-h4">
                        <span class="underline">Media</span>
                    </h4>
                    <hr class="grid-column-hr">
                    <p>
                        <a target="_blank" href="/news/index.php/category/blog/">
                            Blog
                        </a>
                    </p>
                    <p>
                        <a href="/news/index.php/category/news/">Announcements</a>
                    </p>
                </div>
                <!-- Grid column -->


                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 grid-column">
                    <h4 class="grid-column-h4">
                        <span class="underline">About</span>
                    </h4>
                    <hr class="grid-column-hr">
                    <p>
                        <a target="_blank" href="/about-us">
                            About us
                        </a>
                    </p>
                    {{--<p>--}}
                        {{--<a href="http://press.ierek.com/index.php/index/about/siteMap">Terms & Conditions</a>--}}
                    {{--</p>--}}
                    <p>
                        <a href="/faq">FAQ</a>
                    </p>
                    <p>
                        <a href="/contact-us">Contacts</a>
                    </p>
                </div>
                <!-- Grid column -->

            </div>

            <!-- Footer links -->

            <hr class="grid-column-hr grid-column-hr-separator">

            <!-- Grid row -->
            <div class="row copyrights-row">

                {{--<div class="flex-footer">--}}
                    {{--<div class="button-footer">--}}
                        {{--<ul class="nav nav-pills">--}}
                            {{--<li role="presentation"><a href="/careers">Careers</a></li>--}}
                            {{--<li role="presentation"><a href="/suggest">Suggest</a></li>--}}
                            {{--<li role="presentation"><a href="/feedback">Feedback</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}

                    {{--<div class="banks">--}}
                        {{--<!--                    <li><h6>We_accept</h6></li>-->--}}

                        {{--<div><img class="mastercardlogo" src="{{asset('/front/images/Mastercard-Logo-Wallpapers-3.png')}}"--}}
                                  {{--alt=""/></div>--}}
                        {{--<div><img class="ciblogo" src="{{asset('/front/images/cib.jpg')}}" alt=""/></div>--}}
                    {{--</div>--}}
                    {{----}}

                {{--</div>--}}

                <!-- Grid column -->
                <div class="col-xs-12 col-sm-4 grid-column ">

                   {{--careers--}}
                    <div class="button-footer ">
                        <ul class="nav ">
                            <li role="presentation"><a href="/careers">Careers</a></li>
                            <li role="presentation"><a href="/suggest">Suggest</a></li>
                            <li role="presentation"><a href="/feedback">Feedback</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-xs-12 col-sm-10 copyright_container">
                    <!--Copyright-->

<div class="col-sm-9">
			© Copyright 2013 - <script>document.write(new Date().getFullYear());</script> <a href="“https://ierek.com”" target="&quot;_blank&quot;"></a> All Rights Reserved by <a href="http://ierek.com">IEREK</a>			</div>
                </div>

                <!-- Grid column -->
                <div class="col-xs-12 col-sm-4 grid-column">

                    <!-- Social buttons -->
                    <div class="social-icons">

                        <div class="agileinfo-social-grids">
                            <ul class="pl-0">
                                <a href="https://fb.com/ierek.institute"><i class="fa fa-facebook"></i></a>
                                <a href="https://twitter.com/ierek_institute"><i class="fa fa-twitter"></i></a>
                                <a href="https://www.youtube.com/channel/UCVp7eGOwMqTYtEYYxJL0uow"><i class="fa fa-youtube"></i></a>
                                <a href="https://www.linkedin.com/company/ierek-institution/"><i class="fa fa-linkedin"
                                                                                                 aria-hidden="true"></i></a>
                                <a href="https://www.instagram.com/ierek_institute/"><i class="fa fa-instagram"
                                                                                        aria-hidden="true"></i></a>
                                <a href="https://play.google.com/store/apps/details?id=com.makdev.ierek"><i
                                            class="fa fa-android"></i></a>
                        <!--        <a href="https://itunes.apple.com/us/app/ierek/id1288803675?mt=8"><i
                                            class="fa fa-apple"></i></a>
                        -->
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
            <!-- Grid column -->

        </div>
        <!-- Grid row -->

    </footer>
</div>
<!-- Modal -->
<div class="modal fade signingInModals" id="signingInModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body">
                <div class="profile">
                    <div class="w3layouts-top-grids">
                        <div class="slider">
                            <div class="callbacks_container">
                                <div class="w3ls-subscribe w3ls-subscribe1">
                                    <div class="agileits-border agileits-border1">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <h4>Already have an account? Sign In</h4>
                                        <form method="post" id="login_form" action="">
                                            <input type="email" id="email" name="email" placeholder="Username / Email"
                                                   required="">

                                            <input type="password" id="password" name="password" placeholder="Password"
                                                   required="" autocomplete="off">

                                            {{--<input type="submit" value="Login">--}}

                                            <p>
                                                <input type="checkbox" name="remember" value="1">
                                                Remember Me
                                            </p>

                                            <input type="submit" class="btn buttonstyle" id="login" value="Login"/>

                                            <div class="userpro-input"><p id="error_login"
                                                                          style="color: #F00 ; display: none;">Invalid
                                                    Email or Password.</p></div>
                                            <img src="{{ url('loading.gif') }}" alt="Loading" style="display:none"
                                                 id="login_gif">

                                        </form>
                                        <div class="agileinfo-follow">
                                            <h4>OR</h4>
                                        </div>
                                        <div class="agile-signin">
                                            <h4>You don't have an account?
                                                <button type="button" class="btn-no-default-styles" data-toggle="modal"
                                                        data-target="#signingUpModal" data-dismiss="modal">
                                                    Sign Up
                                                </button>
                                            </h4>
                                        </div>
                                        <div class="agile-signin forget-password">
                                            <h4><a href="#"
                                                   onclick="window.open('{{url('/password/reset')}}','_self');">Forgot
                                                    your password?</a></h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade signingInModals" id="signingUpModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body">
                <div class="profile">
                    <div class="w3layouts-top-grids">
                        <div class="slider">
                            <div class="callbacks_container">

                                <div class="w3ls-subscribe">
                                    <div class="agileits-border">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <h4>Register an Account</h4>
                                        <p>Join IEREK community</p>
                                        <form method="post" id="register_form" action="#">
                                            <select name="user_title">
                                                <option>Choose Title</option>
                                                <option value="1">Dr</option>
                                                <option value="2">Prof.</option>
                                                <option value="3">Asst. Prof.</option>
                                                <option value="4">Researcher</option>
                                                <option value="5">Master Student</option>
                                                <option value="6">PHD Student</option>
                                            </select>

                                            <label id="user_title_err" class="regErrors"></label>

                                            <div class="signUpField">
                                                <input type="text" name="first_name" id="fname" placeholder="First Name"
                                                       required="">
                                                <label class="regErrors" id="fname_err"> </label>
                                            </div>
                                            <div class="signUpField">
                                                <input type="text" name="last_name" id="lname" placeholder="Last Name"
                                                       required="">
                                                <label class="regErrors" id="lname_err"> </label>
                                            </div>
                                            <div class="signUpField">
                                                <input type="radio" name="gender" value="1" checked>
                                                <div class="gender">Male</div>
                                                <input type="radio" name="gender" value="2">
                                                <div class="gender">Female</div>
                                            </div>
                                                <input type="radio" name="gender" value="0" checked>
                                                <div class="gender">Prefer not to say</div>
                                            <div class="signUpField">

                                                <input type="email" name="email" placeholder="Email" required="">
                                                <label id="email_err" class="regErrors"></label>
                                            </div>
                                            <div class="signUpField">
                                                <input type="date" name="age"><br>
                                                <label class="regErrors" id="age_err"> </label>
                                            </div>

                                            <div class="signUpField">

                                                <input type="text" id="slug_id" name="slug" placeholder="Slug"
                                                       required="">
                                                <label id="slug_err" class="regErrors"> </label>
                                            </div> <div class="signUpField">

                                                <div data-key="country" class="userpro-field userpro-field-country ">
                                                    <div class="userpro-label iconed">
                                                                                <span class="userpro-field-icon">
                                                                                    <i class="userpro-icon-map-marker"></i>
                                                                                </span>
                                                    </div>
                                                    <div class="userpro-input">
                                                        <select class="form-control" name="country" id="country">

                                                        </select>
                                                    </div>
                                                </div>
                                                <label id="country_err" class="regErrors"> </label>
                                            </div>
                                            <div class="signUpField">

                                                <input type="text" name="phone" placeholder="Phone No. +2xxxxxxxxxxx"
                                                       required="">
                                                <label id="phone_err" class="regErrors"> </label>
                                            </div>
                                            
                                            <div class="signUpField">
                                                <input type="password" name="password" placeholder="Password"
                                                       required="">
                                                <label id="password_err" class="regErrors"> </label>
                                            </div>
                                            <input type="submit" value="Sign Up" id="register">
                                        </form>
                                        <div class="agileinfo-follow">
                                            <h4>OR</h4>
                                        </div>
                                        <div class="agile-signin">
                                            <h4>Do You have an account
                                                <button type="button" class="btn-no-default-styles" data-toggle="modal"
                                                        data-target="#signingInModal" data-dismiss="modal">
                                                    Sign in
                                                </button>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

<script src="{{asset('/front/bootstrap/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('/front/bootstrap/js/bootstrap.min.js')}}"></script>

<script async src="{{asset('/front/scripts/bootstrap-paginator.min.js')}}" type="text/javascript"></script>

<script src="{{ asset('/front/js/jquery.icheck.min.js?v=0.9')}}"></script>

<script src="{{asset('/front/bootstrap/js/jquery-ui.min.js')}}"></script>


<script async src="{{asset('/front/scripts/scripts.js')}}" type="text/javascript"></script>

<script type="application/javascript">

    $(document).ready(function () {

            $( "#datepicker" ).datepicker();
            $("#datepicker").datepicker("option", "dateFormat", "yy-mm-dd" ).val()

        $('#fname,#lname').on('keyup', function () {

            var fName = $('#fname').val();
            var lName = $('#lname').val();

            var slugName = fName + '_' + lName;
            $('#slug_id').val(slug(slugName));
            });

        function slug(val) {
            var sVal = val;
            var noSpec = sVal.replace(/[^\w\s]/gi, '');
            var slug = noSpec.replace(/\s+/g, '-').toLowerCase();
            return slug;
        }

        var notHome = 0;
        $('.activition').each(function () {
            var target = $(this).data('url');
            var url = location.pathname;

            if (url.indexOf(target) > -1) {
                $(this).addClass('active');
                notHome = 1;
            }
        })
        if (notHome == '0') {
            $('.homeurl').addClass('active');
        }
        // AJAX LOGIN
        $("#login").click(function (e) {
            e.preventDefault();
            loging(0);
        });
        $('#logout').on('click', function () {
            $.ajax({
                type: 'GET',
                url: '{{ url("/logout") }}',
                beforeSend: function (xhr) {
                    //loading ajax animation
                },
                success: function (response) {
                    //
                    window.open(location.protocol + '//' + location.host + location.pathname, '_self');
                },
                error: function (response) {

                }
            });
        });
        // AJAX REGISTER
        $("#register").click(function (e) {
            e.preventDefault();
            var loading = document.getElementById('reg_gif');
            var err = document.getElementById('error_login');
            $(err).hide(500);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            var formData = $('#register_form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ url("/register") }}',
                data: formData,
                dataType: 'json',
                beforeSend: function (xhr) {
                    //loading ajax animation
                    $(loading).show();
                    $('.regErrors').each(function () {
                        $(this).html('');
                    })
                },
                success: function (response) {

                    window.open(location.protocol + '//' + location.host + location.pathname, '_self');
                    $(loading).hide();
                    $('#regErrors_all').html('');

                },
                error: function (response) {
                    $(loading).hide();
                    var objOut = response.responseText;
                    if (objOut.match("^<")) {
                        // do this if begins with Hello
                        $(loading).hide();
                        window.open(location.protocol + '//' + location.host + location.pathname, '_self');
                    } else {
                        var obj = $.parseJSON(response.responseText);
                        var errors = obj.errs;

                        if (errors.first_name != undefined && errors.first_name[0] != undefined) {
                            $('#fname_err').html(errors.first_name[0]);
                        }
                        if (errors.last_name != undefined && errors.last_name[0] != undefined) {
                            $('#lname_err').html(errors.last_name[0]);
                        }
                        if (errors.email != undefined && errors.email[0] != undefined) {
                            $('#email_err').html(errors.email[0]);
                        }
                        if (errors.email != undefined && errors.email[1] != undefined) {
                            $('#email_err').html(errors.email[1]);
                        }
                        if (errors.password != undefined && errors.password[0] != undefined) {
                            $('#password_err').html(errors.password[0]);
                        }
                        if (errors.password != undefined && errors.password[1] != undefined) {
                            $('#password_err').html(errors.password[1]);
                        }
                        if (errors.age != undefined && errors.age[0] != undefined) {
                            $('#age_err').html(errors.age[0]);
                        }
                        if (errors.phone != undefined && errors.phone[0] != undefined) {
                            $('#phone_err').html(errors.phone[0]);
                        }
                        if (errors.slug != undefined && errors.slug[0] != undefined) {
                            $('#slug_err').html(errors.slug[0]);
                        }
                        if (errors.country != undefined && errors.country[0] != undefined) {
                            $('#country_err').html(errors.country[0]);
                        }
                        $('#regErrors_all').html('Please enter all required information');
                    }
                }
            });
        });
    });

    function loging(event_id) {
        var err = document.getElementById('error_login');
        $(err).hide(500);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = $('#login_form').serialize();
        var loading = document.getElementById('login_gif');
        $.ajax({
            type: 'POST',
            url: '{{ url("/login") }}',
            data: formData,
            dataType: 'json',
            beforeSend: function (xhr) {
                //loading ajax animation
                $(loading).show();
            },
            success: function (response) {
                //
                $(loading).hide();
                @if(Session::has('url'))
                if (response >= 0) {
                    window.open('/{{ Session::get('url') }}', '_self');
                }
                @else
                if (response != 2) {
                    window.open(location.protocol + '//' + location.host + location.pathname, '_self');
                } else {
                    window.open('/admin', '_self');
                }
                @endif
            },
            error: function (response) {
                $(loading).hide();
                if (response.responseText == 'match') {

                } else {
                    $(err).show(500);
                    $(err).html(response.responseText);
                }
            }
        });
    }

    function conf_register(event_id) {
        $.ajax({
            type: 'GET',
            url: '/conference/register/' + event_id,
            dataType: 'json',
            beforeSend: function (xhr) {
                //loading ajax animation
            },
            success: function (response) {
                //
                window.open(location.protocol + '//' + location.host + location.pathname, '_self');
            },
            error: function (response) {
                window.open(location.protocol + '//' + location.host + location.pathname, '_self');
            }
        });
    }
</script>

@if(Session::has('status'))
    <script type="text/javascript">
        $(document).ready(function () {
            returnN('<?php echo Session::get('status') ?>', 'darkgreen', 20000);
        });
    </script>
@endif
@if(Session::has('url'))
    <script type="text/javascript">
        $(document).ready(function () {
            functionX('<?php echo Session::get('alert') ?>', 'open_log()', 'Login', 'Close');
        });
    </script>
@endif


@stack('scripts')


</body>
</html>

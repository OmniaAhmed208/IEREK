<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title>IEREK Dashboard @yield('title')</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- <link rel="icon" href="favicon.ico" type="image/x-icon" /> -->
        <!-- END META SECTION -->
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('/css/admin/theme-serenity.css') }}"/>
        <script type="text/javascript" src="{{ asset('js/admin/plugins/jquery/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('js/admin/plugins/jquery/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('js/admin/plugins/bootstrap/bootstrap.min.js')}}"></script>
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="/">IEREK</a>
                        <a href="/" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        
                        <div class="profile">
                            <div class="profile-data">
                                <div class="profile-data-name">{{ substr(Auth::user()->first_name, 0, 10) }}</div>
                                <div class="profile-data-title">{{ Auth::user()->first_name }}</div>
                            </div>
                            <br>
                            <div class="profile-controls">
                                <a href="/pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                                <a href="/pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                            </div>
                            <br><br><br>
                        </div>
                    </li>
                    <li class="xn-title">Navigation</li>
                    <li data-home="admin">
                        <a href="{{url('admin')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
                    </li>
                    <li data-active="mail">
                        <a href="{{url('admin/mail')}}"><span class="fa fa-envelope"></span> <span class="xn-text">Mail Settings</span></a>
                    </li>
                    <li data-active="notifications">
                        <a href="{{url('admin/notifications')}}"><span class="fa fa-bell"></span> <span class="xn-text">Notifications</span></a>
                    </li>
                    <li data-active="messages">
                        <a href="{{url('admin/messages')}}"><span class="fa fa-comment"></span> <span class="xn-text">Messages</span></a>
                    </li>
                    <li data-active="logs">
                        <a href="{{url('admin/logs')}}"><span class="fa fa-file-text-o"></span> <span class="xn-text">Logs</span></a>
                    </li>
                    <li class="xn-openable"  data-active="events">
                        <a href="/#"><span class="fa fa-calendar"></span> <span class="xn-text">Events</span></a>
                        <ul>
                            <li class="xn-openable" data-active="conference"><a href="/#"><span class="fa fa-bullhorn"></span> Conference</a>
                            <ul>
                                <li data-active="conference/create"><a href="{{url('admin/events/conference/create')}}"><span class="fa fa-align-center"></span> Create</a></li>
                                <li data-active="conference"><a href="{{url('admin/events/conference')}}"><span class="fa fa-align-justify"></span> Manage</a></li>
                            </ul>
                        </li>
                        <li class="xn-openable"><a href="/#"><span class="fa fa-briefcase"></span> Workshops</a>
                        <ul>
                            <li ><a href="{{url('admin/events/workshop/create')}}"><span class="fa fa-align-center"></span> Create</a></li>
                            <li><a href="{{url('admin/events/workshop')}}"><span class="fa fa-align-justify"></span> Manage</a></li>
                        </ul>
                    </li>
                    <li class="xn-openable"><a href="/#"><span class="fa fa-certificate"></span> Study Abroad</a>
                    <ul>
                        <li ><a href="{{url('admin/events/studyabroad/create')}}"><span class="fa fa-align-center"></span> Create</a></li>
                        <li><a href="{{url('admin/events/studyabroad')}}"><span class="fa fa-align-justify"></span> Manage</a></li>
                    </ul>
                    <li data-active="events/settings"><a href="{{url('admin/events/settings/important_dates')}}"><span class="fa fa-cogs"></span>Events Settings</a></li>
                </li>
            </ul>
        </li>
        <li class="xn-openable">
            <a href="/#"><span class="fa fa-dollar"></span> <span class="xn-text">Payments</span></a>
            <ul>
                <li><a href="/admin/payments/create"><span class="fa fa-plus"></span> New</a></li>
                <li><a href="/admin/payments/home"><span class="fa fa-cogs"></span> Manage</a></li>
            </ul>
        </li>
        <li class="xn-openable" data-active="pages">
            <a><span class="fa fa-files-o"></span> <span class="xn-text">Pages</span></a>
            <ul>
                <li class="xn-openable" data-active="home"><a><span class="fa fa-home"></span> Home</a>
                <ul>
                    <li data-active="slider" ><a href="{{url('admin/pages/home/slider')}}"><span class="fa fa-image"></span> Slider</a></li>
                    <li data-active="featured_conferences"><a href="{{url('admin/pages/home/featured_conferences')}}"><span class="fa fa-align-justify"></span> Featured Conferences</a></li>
                    <li data-active="featured_workshops"><a href="{{url('admin/pages/home/featured_workshops')}}"><span class="fa fa-align-justify"></span> Featured Workshops</a></li>
                </ul>
            </li>
            <li data-active="static" class="xn-openable"><a href="/#"><span class="fa fa-file"></span> Static Pages</a>
            <ul>
                <!--<li><a href="/admin/pages/static/speakers"><span class="fa fa-file-text-o"></span> Speakers</a></li>
                <li><a href="/admin/pages/static/sponsores"><span class="fa fa-file-text-o"></span> Sponsors</a></li>
                <li><a href="/admin/pages/static/media"><span class="fa fa-file-text-o"></span> Media Coverage</a></li> -->
                <!-- <li><a href="/admin/pages/static/careers"><span class="fa fa-file-text-o"></span> Careers</a></li>
                <li><a href="/admin/pages/static/suggest"><span class="fa fa-file-text-o"></span> Suggest</a></li>
                <li><a href="/admin/pages/static/feedback"><span class="fa fa-file-text-o"></span> Feedback</a></li> -->
                <li data-active="contact"><a href="/admin/pages/static/contact"><span class="fa fa-headphones"></span> Contact Us</a></li>
                <li data-active="faq"><a href="/admin/pages/static/faq"><span class="fa fa-info"></span> FAQ</a></li>
                <li data-active="terms"><a href="/admin/pages/static/terms"><span class="fa fa-ban"></span> Terms & Conditions</a></li>
                <li data-active="press"><a href="/admin/pages/static/press"><span class="fa fa-file-text-o"></span> IEREK Press </a></li>
                <li data-active="about"><a href="/admin/pages/static/about"><span class="fa fa-asterisk"></span> About Us </a></li>
            </ul>
        </li>
        <!-- <li><a href="/pages/contact"><span class="fa fa-file-text-o"></span> Contact Us</a></li>
        i class="xn-openable"><a href="/#"><span class="fa fa-image"></span> News</a>
        <ul>
            <li><a href="/pages/news/create"><span class="fa fa-align-center"></span> Create</a></li>
            <li><a href="/pages/news"><span class="fa fa-align-justify"></span> Manage</a></li>
        </ul>
    </li>
    <li class="xn-openable"><a href="/#"><span class="fa fa-image"></span> Blog</a>
    <ul>
        <li><a href="/pages/blog/create"><span class="fa fa-align-center"></span> Create</a></li>
        <li><a href="/pages/blog"><span class="fa fa-align-justify"></span> Manage</a></li>
    </ul>
</li> -->
<!-- <li class="xn-openable"><a href="/#"><span class="fa fa-image"></span> Gallery</a>
<ul> -->
<!-- <li class="xn-openable"><a href="/#"><span class="fa fa-image"></span> Images</a>
<ul>
    <li><a href="/pages/gallery/images/add"><span class="fa fa-align-center"></span> Add</a></li>
    <li><a href="/pages/gallery/images"><span class="fa fa-align-justify"></span> Manage</a></li>
</ul>
</li> -->
<!-- <li class="xn-openable"><a href="/#"><span class="fa fa-image"></span> Video</a>
<ul>
<li><a href="/pages/gallery/video/add"><span class="fa fa-align-center"></span> Add</a></li>
<li><a href="/pages/gallery/video"><span class="fa fa-align-justify"></span> Manage</a></li>
</ul>
</li> -->
<!-- </ul>
</li> -->
</ul>
</li>
<li class="xn-openable">
<a href="/#"><span class="fa fa-users"></span> <span class="xn-text">Users</span></a>
<ul>
<li data-active="admins"><a href="/admin/users/admins"><span class="fa fa-trophy"></span> Admins</a></li>
<li data-active="scientific"><a href="/admin/users/scientific"><span class="fa fa-user"></span> Scientific Committee</a></li>
<li data-active="all-users"><a href="/admin/all-users"><span class="fa fa-square-o"></span> All users</a></li>
</ul>
</li>
<li class="xn-openable">
<a href="/#"><span class="fa fa-pencil"></span> <span class="xn-text">Newsletter</span></a>

<ul>
<li><a href="/admin/newsletter/create"><span class="fa fa-align-center"></span> Add</a></li>
<li><a href="/admin/newsletter"><span class="fa fa-align-justify"></span> Manage</a></li>
</ul>
</li>
</ul>
<!-- END X-NAVIGATION -->
</div>
<!-- END PAGE SIDEBAR -->
<!-- PAGE CONTENT -->
<div class="page-content">
<!-- START X-NAVIGATION VERTICAL -->
<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
<!-- TOGGLE NAVIGATION -->
<li class="xn-icon-button">
<a href="/#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
</li>
<!-- END TOGGLE NAVIGATION -->
<!-- SEARCH -->
<li class="xn-search">
<form role="form">
<input type="text" name="search" placeholder="Search..."/>
</form>
</li>
<!-- END SEARCH -->
<!-- SIGN OUT -->
<li class="xn-icon-button pull-right">
<a href="/#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
</li>
<!-- END SIGN OUT -->
<!-- MESSAGES -->
<li class="xn-icon-button pull-right hidden">
<a href="/#"><span class="fa fa-comments"></span></a>
<div class="informer informer-danger">4</div>
<div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
<div class="panel-heading">
<h3 class="panel-title"><span class="fa fa-comments"></span> Messages</h3>
<div class="pull-right">
<span class="label label-danger">4 new</span>
</div>
</div>
<div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
<a href="/#" class="list-group-item">
<div class="list-group-status status-online"></div>
<img src="" class="pull-left" alt="John Doe"/>
<span class="contacts-title">John Doe</span>
<p>Praesent placerat tellus id augue condimentum</p>
</a>
<a href="/#" class="list-group-item">
<div class="list-group-status status-away"></div>
<img src="" class="pull-left" alt="Dmitry Ivaniuk"/>
<span class="contacts-title">Dmitry Ivaniuk</span>
<p>Donec risus sapien, sagittis et magna quis</p>
</a>
<a href="/#" class="list-group-item">
<div class="list-group-status status-away"></div>
<img src="" class="pull-left" alt="Nadia Ali"/>
<span class="contacts-title">Nadia Ali</span>
<p>Mauris vel eros ut nunc rhoncus cursus sed</p>
</a>
<a href="/#" class="list-group-item">
<div class="list-group-status status-offline"></div>
<img src="" class="pull-left" alt="Darth Vader"/>
<span class="contacts-title">Darth Vader</span>
<p>I want my money back!</p>
</a>
</div>
<div class="panel-footer text-center">
<a href="/pages-messages.html">Show all messages</a>
</div>
</div>
</li>
<!-- END MESSAGES -->
<!-- TASKS -->
<li class="xn-icon-button pull-right">
<a href="/#"><span class="fa fa-bell"></span></a>
<div class="informer informer-warning"></div>
<div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
<div class="panel-heading">
<h3 class="panel-title"><span class="fa fa-bell"></span> Notifications</h3>
<div class="pull-right">
<span class="label label-warning">3 active</span>
</div>
</div>
<div class="panel-body list-group scroll" style="height: 200px;">
<a class="list-group-item" href="#">
<strong>Phasellus augue arcu, elementum</strong>
<div class="progress progress-small progress-striped active">
</div>
<small class="text-muted">John Doe, 25 Sep 2014 / 50%</small>
</a>
<a class="list-group-item" href="#">
<strong>Aenean ac cursus</strong>
<div class="progress progress-small progress-striped active">
</div>
<small class="text-muted">Dmitry Ivaniuk, 24 Sep 2014 / 80%</small>
</a>
<a class="list-group-item" href="#">
<strong>Lorem ipsum dolor</strong>
<div class="progress progress-small progress-striped active">
</div>
<small class="text-muted">John Doe, 23 Sep 2014 / 95%</small>
</a>
<a class="list-group-item" href="#">
<strong>Cras suscipit ac quam at tincidunt.</strong>
<div class="progress progress-small">
</div>
<small class="text-muted">John Doe, 21 Sep 2014 /</small><small class="text-success"> Done</small>
</a>
</div>
<div class="panel-footer text-center">
<a href="{{ url('admin/notifications') }}">Show all</a>
</div>
</div>
</li>
<!-- END TASKS -->
</ul>
<!-- END X-NAVIGATION VERTICAL -->
<div style="height:20px;width:100%;display:inline-block"></div>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

<div id="alert_messages">
<div class="alert alert-success" style="margin-top:1em; display:none;">
<button type="button" class="close" data-dismiss="alert">
<span aria-hidden="true">&times;</span>
<span class="sr-only">Close</span>
</button>
<span>
<strong class="content"></strong>
</span>
</div>
<div class="alert alert-danger" style="margin-top:1em; display:none;">
<button type="button" class="close" data-dismiss="alert">
<span aria-hidden="true">&times;</span>
<span class="sr-only">Close</span>
</button>
<span class="content"></span>
</div>
</div>
{{-- This part will be displayed if session has a success msg --}}
@if(Session::has('success'))
<section id="session_success" class="info-box success">
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">
<span aria-hidden="true">&times;</span>
<span class="sr-only">Close</span>
</button>
<span>
<strong class="content">{{ Session::get('success') }}</strong>
</span>
</div>
</section>
@endif
@yield('content')
</div>
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
<div class="mb-container">
<div class="mb-middle">
<div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
<div class="mb-content">
<p>Are you sure you want to log out?</p>
<p>Press No if you want to continue work. Press Yes to logout.</p>
</div>
<div class="mb-footer">
<div class="pull-right">
<a href="{{ url('logout') }}" class="btn btn-success btn-lg">Yes</a>
<button class="btn btn-default btn-lg mb-control-close">No</button>
</div>
</div>
</div>
</div>
</div>
<!-- END MESSAGE BOX-->
<!-- START PRELOADS -->
<audio id="audio-alert" src="{{ asset('/audio/admin/alert.mp3')}}" preload="auto"></audio>
<audio id="audio-fail" src="{{ asset('/audio/admin/fail.mp3')}}" preload="auto"></audio>
<!-- END PRELOADS -->
<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<script type="text/javascript" src="{{ asset('js/admin/plugins/smartwizard/jquery.smartWizard-2.0.min.js') }}"></script>
<!-- END PLUGINS -->
<!-- START THIS PAGE PLUGINS-->
<script type='text/javascript' src="{{ asset('js/admin/plugins/icheck/icheck.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/owl/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/moment.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- END THIS PAGE PLUGINS-->
<script type="text/javascript" src="{{ asset('js/admin/plugins/fileinput/fileinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/bootstrap/bootstrap-select.js') }}"></script>
<!-- START TEMPLATE-->
<!---->
<script type="text/javascript" src="{{ asset('js/admin/plugins.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/admin/conference.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/admin/actions.js')}}"></script>
<!-- END TEMPLATE -->
<script type="text/javascript" charset="utf-8" async defer>
$(document).ready(function(){

var pathName = window.location.pathname;

$('li[data-active]').each(function(){

var liActive = $(this).data('active');
if(pathName.indexOf(liActive)>=0){
$(this).addClass('active');
}
});
});
</script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/noty/jquery.noty.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/noty/layouts/topCenter.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/noty/layouts/center.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/noty/layouts/topRight.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/noty/themes/default.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/css/admin/main.css') }}"/>
<script type="text/javascript" src="{{ asset('js/admin/common.js')}}"></script>
<script type="text/javascript">
// >>>>>>>>>>>>>>>>>>>> DIALOGS <<<<<<<<<<<<<<<<<<<<<<<<
$(function(){
var typeN = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAB3RJTUUH4AQbDwkj0PFKegAAAAlwSFlzAAAewgAAHsIBbtB1PgAAAARnQU1BAACxjwv8YQUAAAFYSURBVHja7dqxagJBEMZxkdR5gbR5gZRWkvZaO5uDIJK0SXF5AAtrC7G0FdKJjWIpvoBgmxQ2FlppI6jfySwEwS3udmZvZQb+IKfO3q+wUUslHR2dXFN7a+YpQXu0o8eZd/mEdNARnagjXQsKEv8DXBeHBBlZIKOQIDMLZBYCJEJjdLBADvSaqIiQJzS03PythvTeQkBe0CoDwrSiHV4hz2idA2Fa0y4vkDKaO0CY5rRTHPLuEGH6kIY8oCUDZEm7xSAVBoSpIgn5ZIR8SUK6jJCuJKTPCOkrRCEKUYhCFKIQYUiPEdKThCSMkEQSUmWEVLkhj6iBftCCEbKgMxp0plPIK/pjvPlb/dLZTiDpF2lbDwhTenbkArLxiDBtXEB8Iy4p5B4hAzTx3MAFpBApJCekjtqodVWbngsGMrV8cKchQWILJA4JknYXv7ObvmtF+eeDjk62OQPJEGhqOr30GQAAAABJRU5ErkJggg==';
var typeX = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAB3RJTUUH4AQbDyMJZCFPhAAAAAlwSFlzAAAewgAAHsIBbtB1PgAAAARnQU1BAACxjwv8YQUAAAOlSURBVHja7Vn3axVBEP7sLXZEsYsNUVFjQUywoISAiCKKoomJhRhQLOiDiEoi0QRUYkNUrIjYEEWNJRrNmVjiL+qf5Ay7y+6er9y9vHsb5D742Ly3s/dmZmdmdy5AjBgxYsT4T5EgfiYedq1IV3CM+IXoyTHhWqFssI34UxrRJkf+vNm1YmEwhvgWYhfaDLYTm4mjXCsYFCeJPwwDOoy/+fsa1woGQSGE5z3okLoFvTue5FzXiqZDD+IN4lepNI+3iYOJ94zvvxGvulY2HTZAh5QHEVJL5VyxNMST89+Ja10rnAzDiS8gwkopWu+TaZTfq8R/RhziWnE/+MBTu8H50EKc4JOZQvwInS8sv8+14iZmQpzenqHg7hSy1T6DW4lTXRugcAEigVWpfUQckEK2gPgUuiRzqJ11bQBjjWGEqkirM6wphc4VT65Z4dKIgcTH0N5lhZrk3EKI8KowyJ/nyfnLsHfxAbGfK0P2wC63nCcz5NwO4m85r8ift8j52cY6lVcVLoyYCFGZzAp0yJgvgQ4fRf683JBJwE78d8Sx+TbkNOwzgc+QYcb8IuiTXHme5eYYMiOJr6DPHjaqNp9G8GndATss1vtkpsEOHR651I73yW2CHZ7t0gmRozfxLux703WIe5aJ0cT30KHHI3t/qE+uF8R9zLyf3ST2jNqQrT4PsoILksgNIj6HDhseHxL7JJFdjH93eGOURnBD9Bp2TJ9IIcuevg9dmtnT19I8+xTsnHtJHBGVITWwq8wbiG4wFa7ADsEzaWTHwQ5F/p0jURjBjZAHe/vLMqxpIP6CPkMyvXzYCTtseZyVa0O4EVInMXuZw6ZvhjVFxCriLjkWZpDvD5FH5k3hUi6N4AbIvBuxIcW59pTEKth3N/7dklw8mBsfboDMhqkx4NolxEpiuRyD9unnDcfx7jyBqIJdwn7YCc6N0eSAa49C37f+QORAEEwnfoKdj1VdMYIbnlbYlaQ6xPqDhhN4LA+x9oDPgR+Ik7I1hBsec4u5ISoIsd7cER6D7giDbwDmgcp6NGRjxEqIpPOMB5WGfMYy4l6IPoTH+SHXr4NdjrnIFIV5ACe4/1Q+l403coCLsO9hdyAaukCog94JFVb8GpSbIj4Et+eBZfL36mC/cmW9Ar/VV/8KMJsi9kYn7I4vanbC7mmUIS1BDWmCfRvtLvSkXvUICL4q1MK+W7mm0uU4krcCacHVprkbGMO/z+1DZVgDYsSIESNGpPgLghiH8ul3sG8AAAAASUVORK5CYII=';
var nStyle = document.createElement('style');
nStyle.type = 'text/css';
document.getElementsByTagName('head')[0].appendChild(nStyle);
nStyle.innerHTML = '.notificationsx{z-index: 1000;position: fixed;height:auto;width:360px;max-width:100vw;left:0.41em;top:0;}'+
'.rnHolder{position: relative;width: 100%;font-family: "Tahoma", sans-serif;font-size: 120%;text-align: center;background-color: #fff;margin-top:0.41em;padding: 0.1em;border: 1px #e7e7e7 solid;box-shadow: 0 0 5px 0 rgba(0,0,0,0.2);display: none;}'+
'.rnHolder a{position: absolute;right: 0.4em;top: 0;color: #999;font-size: 16px;cursor: pointer;font-family: "Arial Black";transition: 0.5s}'+
'.rnHolder a:hover{color: #333}'+
'.rnHolder p{cursor: default;text-align:left;padding:0 20px 0 45px;direction:ltr}'+
'.rnIconN{position:absolute;left:10px;top:50%;margin-top:-12.5px;width: 25px;height: 25px;background: url('+typeN+') no-repeat center center;background-size:25px 25px;}'+
'.rnIconX{position:absolute;left:10px;top:50%;margin-top:-12.5px;width: 25px;height: 25px;background: url('+typeX+') no-repeat center center;background-size:25px 25px;}'+
'.cBlocker{position:fixed;z-index: 1001!important;top:0;height:100vh;width:100vw;background-color:rgba(255,255,255,0.8);display:none;}'+
'.cHolder{width:50%;min-width:300px;background-color:#fff;box-shadow:0 4px 15px 0 rgba(0,0,0,0.19);padding:1em 0.5em;position:absolute;left:50%;-webkit-transform: translateX(-50%) translateY(-50%);transform: translateX(-50%) translateY(-50%);top:50%}'+
'.cHolder p{padding:0 1em; font-family:"Tahoma", sans-serif;margin-bottom:1em;font-weight:400;font-size:120%;text-align:left;}'+
'.cOk{cursor:pointer;padding: 0.75em 1.75em;box-shadow: 0 0 5px 0 rgba(0,0,0,0.067)inset;vertical-align:middle;'+
'background-color:#aa822c;color:#fff;border-radius:1px;text-align:center;transition:0.3s;margin-right:1em;float:right;font-weight:400;font-family:"Tahoma", sans-serif;font-size: 120%;}'+
'.cOk:hover {background-color:#0c3852;color:#fff;box-shadow: 0 -1px 1px 1px rgba(0,0,0,0.3)inset}'+
'.cOk:active {background-color:#0c3852;color:#fff;box-shadow: 0 1px 1px 1px rgba(0,0,0,0.3)inset}'+
'.cNo{cursor:pointer;padding: 0.75em 1.75em;vertical-align:middle;'+
'background-color:#fff;color:#aa822c;border:1px #fff solid;border-bottom:2px #fff'+
'solid;border-radius:1px;text-align:center;margin-right:1em;float:right;font-weight:400;font-family:"Tahoma", sans-serif;font-size: 120%;}'+
'.cNo:hover {border:1px #e7e7e7 solid;border-bottom:2px #e7e7e7 solid;}'+
'.cNo:active {background-color:#f1f1f1;border:1px #e7e7e7 solid;border-top:2px #e7e7e7 solid;border-bottom:1px #e7e7e7 solid;}';
var notifications = document.createElement('div');
notifications.className = 'notificationsx';
var cBlocker = document.createElement('div');
cBlocker.className = 'cBlocker';
var holder = document.getElementsByTagName('html')[0];
holder.appendChild(notifications);
holder.appendChild(cBlocker);
});
function makeid()
{
var text = "";
var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
for( var i=0; i < 5; i++ )
text += possible.charAt(Math.floor(Math.random() * possible.length));
return text;
}
function returnN(message,color,duration){
var rnHolder = document.createElement('div');
rnName = makeid();
rnHolder.id = rnName;
rnHolder.className = 'rnHolder';
document.getElementsByClassName('notificationsx')[0].appendChild(rnHolder);
var target = document.getElementById(rnName);
var rnText = document.createElement('p');
var rnIcon = document.createElement('div');
rnIcon.className = "rnIconN";
var rnClose = document.createElement('a');
rnClose.innerHTML = 'x';
$(rnClose).on('click', function(){
$(this).closest('div').slideUp(200);
})
target.appendChild(rnClose);
rnText.innerHTML = message;
rnText.style.color = color;
rnText.appendChild(rnIcon);
target.appendChild(rnText);
$(target).slideDown(200)
setTimeout(function(){
$(target).slideUp(200);
}, duration);
}
function alertX(message){
var rnHolder = document.createElement('div');
rnName = makeid();
rnHolder.id = rnName;
rnHolder.className = 'rnHolder';
document.getElementsByClassName('notificationsx')[0].appendChild(rnHolder);
var target = document.getElementById(rnName);
var rnText = document.createElement('p');
var rnIcon = document.createElement('div');
rnIcon.className = "rnIconX";
var rnClose = document.createElement('a');
rnClose.innerHTML = 'x';
$(rnClose).on('click', function(){
$(this).closest('div').slideUp(200);
})
target.appendChild(rnClose);
rnText.innerHTML = message;
rnText.style.color = 'red';
rnText.appendChild(rnIcon);
target.appendChild(rnText);
$(target).slideDown(200)
}
function informX(message){
var cHolder = document.createElement('div');
cName = makeid();
cHolder.id = cName;
cHolder.className = 'cHolder';
document.getElementsByClassName('cBlocker')[0].appendChild(cHolder);
var target = document.getElementById(cName);
var cText = document.createElement('p');
var cOk = document.createElement('div');
cOk.className = "cOk";
cOk.innerHTML = 'Close';
$(cOk).on('click', function(){
$(this).closest('.cHolder').fadeOut(500);
$('.cBlocker').fadeOut(500);
})
cText.innerHTML = message;
cText.style.color = '#888';
target.appendChild(cText);
target.appendChild(cOk);
$(target).fadeIn(500);
$('.cBlocker').fadeIn(500);
}
function confirmX(message, url, ok, cancel){
var cHolder = document.createElement('div');
cName = makeid();
cHolder.id = cName;
cHolder.className = 'cHolder';
document.getElementsByClassName('cBlocker')[0].appendChild(cHolder);
var target = document.getElementById(cName);
var cText = document.createElement('p');
var cOk = document.createElement('a');
cOk.className = "cOk";
cOk.innerHTML = ok;
$(cOk).on('click', function(){
$(this).closest('.cHolder').fadeOut(500);
$('.cBlocker').fadeOut(500);
window.open(url,'_self');
})
var cNo = document.createElement('a');
cNo.className = "cNo";
cNo.innerHTML = cancel;
$(cNo).on('click', function(){
$(this).closest('.cHolder').fadeOut(500);
$('.cBlocker').fadeOut(500);
})
cText.innerHTML = message;
cText.style.color = '#888';
target.appendChild(cText);
target.appendChild(cNo);
target.appendChild(cOk);
$(target).fadeIn(500);
$('.cBlocker').fadeIn(500);
}
function functionX(message, func, ok, cancel){
var cHolder = document.createElement('div');
cName = makeid();
cHolder.id = cName;
cHolder.className = 'cHolder';
document.getElementsByClassName('cBlocker')[0].appendChild(cHolder);
var target = document.getElementById(cName);
var cText = document.createElement('p');
var cOk = document.createElement('a');
cOk.className = "cOk";
cOk.innerHTML = ok;
$(cOk).attr('onclick', func);
$(cOk).on('click', function(){
$(this).closest('.cHolder').fadeOut(500);
$('.cBlocker').fadeOut(500);
})
var cNo = document.createElement('a');
cNo.className = "cNo";
cNo.innerHTML = cancel;
$(cNo).on('click', function(){
$(this).closest('.cHolder').fadeOut(500);
$('.cBlocker').fadeOut(500);
})
cText.innerHTML = message;
cText.style.color = '#888';
target.appendChild(cText);
target.appendChild(cNo);
target.appendChild(cOk);
$(target).fadeIn(500);
$('.cBlocker').fadeIn(500);
}
$(document).ready(function(){
@if(Session::has('status'))
returnN('<?php echo Session::get('status') ?>','darkgreen',20000);
@endif
});
</script>
<!--Scripts and css in views will be inserted here-->
@stack('scripts')
<!--end inserting scripts and css-->
<!-- END SCRIPTS -->
</body>
</html>
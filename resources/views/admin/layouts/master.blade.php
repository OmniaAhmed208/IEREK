<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- META SECTION -->
    <title>IEREK Dashboard @yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="icon" href="favicon.ico" type="image/x-icon" /> -->
    <!-- END META SECTION -->
    <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('/css/admin/theme-serenity.css') }}"/>
    <script type="text/javascript" src="{{ asset('js/admin/plugins/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/plugins/jquery/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/plugins/bootstrap/bootstrap.min.js')}}"></script>
    <script>
    (function (factory) {
    if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
    } else if (typeof module === 'object' && typeof module.exports === 'object') {
    factory(require('jquery'));
    } else {
    // Browser globals
    factory(jQuery);
    }
    }(function ($) {
    $.timeago = function(timestamp) {
    if (timestamp instanceof Date) {
    return inWords(timestamp);
    } else if (typeof timestamp === "string") {
    return inWords($.timeago.parse(timestamp));
    } else if (typeof timestamp === "number") {
    return inWords(new Date(timestamp));
    } else {
    return inWords($.timeago.datetime(timestamp));
    }
    };
    var $t = $.timeago;
    $.extend($.timeago, {
    settings: {
    refreshMillis: 60000,
    allowPast: true,
    allowFuture: false,
    localeTitle: false,
    cutoff: 0,
    autoDispose: true,
    strings: {
    prefixAgo: null,
    prefixFromNow: null,
    suffixAgo: "ago",
    suffixFromNow: "from now",
    inPast: 'any moment now',
    seconds: "less than a minute",
    minute: "about a minute",
    minutes: "%d minutes",
    hour: "about an hour",
    hours: "about %d hours",
    day: "a day",
    days: "%d days",
    month: "about a month",
    months: "%d months",
    year: "about a year",
    years: "%d years",
    wordSeparator: " ",
    numbers: []
    }
    },
    inWords: function(distanceMillis) {
    if (!this.settings.allowPast && ! this.settings.allowFuture) {
    throw 'timeago allowPast and allowFuture settings can not both be set to false.';
    }
    var $l = this.settings.strings;
    var prefix = $l.prefixAgo;
    var suffix = $l.suffixAgo;
    if (this.settings.allowFuture) {
    if (distanceMillis < 0) {
    prefix = $l.prefixFromNow;
    suffix = $l.suffixFromNow;
    }
    }
    if (!this.settings.allowPast && distanceMillis >= 0) {
    return this.settings.strings.inPast;
    }
    var seconds = Math.abs(distanceMillis) / 1000;
    var minutes = seconds / 60;
    var hours = minutes / 60;
    var days = hours / 24;
    var years = days / 365;
    function substitute(stringOrFunction, number) {
    var string = $.isFunction(stringOrFunction) ? stringOrFunction(number, distanceMillis) : stringOrFunction;
    var value = ($l.numbers && $l.numbers[number]) || number;
    return string.replace(/%d/i, value);
    }
    var words = seconds < 45 && substitute($l.seconds, Math.round(seconds)) ||
    seconds < 90 && substitute($l.minute, 1) ||
    minutes < 45 && substitute($l.minutes, Math.round(minutes)) ||
    minutes < 90 && substitute($l.hour, 1) ||
    hours < 24 && substitute($l.hours, Math.round(hours)) ||
    hours < 42 && substitute($l.day, 1) ||
    days < 30 && substitute($l.days, Math.round(days)) ||
    days < 45 && substitute($l.month, 1) ||
    days < 365 && substitute($l.months, Math.round(days / 30)) ||
    years < 1.5 && substitute($l.year, 1) ||
    substitute($l.years, Math.round(years));
    var separator = $l.wordSeparator || "";
    if ($l.wordSeparator === undefined) { separator = " "; }
    return $.trim([prefix, words, suffix].join(separator));
    },
    parse: function(iso8601) {
    var s = $.trim(iso8601);
    s = s.replace(/\.\d+/,""); // remove milliseconds
    s = s.replace(/-/,"/").replace(/-/,"/");
    s = s.replace(/T/," ").replace(/Z/," UTC");
    s = s.replace(/([\+\-]\d\d)\:?(\d\d)/," $1$2"); // -04:00 -> -0400
    s = s.replace(/([\+\-]\d\d)$/," $100"); // +09 -> +0900
    return new Date(s);
    },
    datetime: function(elem) {
    var iso8601 = $t.isTime(elem) ? $(elem).attr("datetime") : $(elem).attr("title");
    return $t.parse(iso8601);
    },
    isTime: function(elem) {
    // jQuery's `is()` doesn't play well with HTML5 in IE
    return $(elem).get(0).tagName.toLowerCase() === "time"; // $(elem).is("time");
    }
    });
    // functions that can be called via $(el).timeago('action')
    // init is default when no action is given
    // functions are called with context of a single element
    var functions = {
    init: function() {
    var refresh_el = $.proxy(refresh, this);
    refresh_el();
    var $s = $t.settings;
    if ($s.refreshMillis > 0) {
    this._timeagoInterval = setInterval(refresh_el, $s.refreshMillis);
    }
    },
    update: function(timestamp) {
    var date = (timestamp instanceof Date) ? timestamp : $t.parse(timestamp);
    $(this).data('timeago', { datetime: date });
    if ($t.settings.localeTitle) {
    $(this).attr("title", date.toLocaleString());
    }
    refresh.apply(this);
    },
    updateFromDOM: function() {
    $(this).data('timeago', { datetime: $t.parse( $t.isTime(this) ? $(this).attr("datetime") : $(this).attr("title") ) });
    refresh.apply(this);
    },
    dispose: function () {
    if (this._timeagoInterval) {
    window.clearInterval(this._timeagoInterval);
    this._timeagoInterval = null;
    }
    }
    };
    $.fn.timeago = function(action, options) {
    var fn = action ? functions[action] : functions.init;
    if (!fn) {
    throw new Error("Unknown function name '"+ action +"' for timeago");
    }
    // each over objects here and call the requested function
    this.each(function() {
    fn.call(this, options);
    });
    return this;
    };
    function refresh() {
    var $s = $t.settings;
    //check if it's still visible
    if ($s.autoDispose && !$.contains(document.documentElement,this)) {
    //stop if it has been removed
    $(this).timeago("dispose");
    return this;
    }
    var data = prepareData(this);
    if (!isNaN(data.datetime)) {
    if ( $s.cutoff === 0 || Math.abs(distance(data.datetime)) < $s.cutoff) {
    $(this).text(inWords(data.datetime));
    } else {
    if ($(this).attr('title').length > 0) {
    $(this).text($(this).attr('title'));
    }
    }
    }
    return this;
    }
    function prepareData(element) {
    element = $(element);
    if (!element.data("timeago")) {
    element.data("timeago", { datetime: $t.datetime(element) });
    var text = $.trim(element.text());
    if ($t.settings.localeTitle) {
    element.attr("title", element.data('timeago').datetime.toLocaleString());
    } else if (text.length > 0 && !($t.isTime(element) && element.attr("title"))) {
    element.attr("title", text);
    }
    }
    return element.data("timeago");
    }
    function inWords(date) {
    return $t.inWords(distance(date));
    }
    function distance(date) {
    return (new Date().getTime() - date.getTime());
    }
    // fix for IE6 suckage
    document.createElement("abbr");
    document.createElement("time");
    }));
    </script>
  </head>
  <body>
    <!-- START PAGE CONTAINER -->
    <div class="page-container" id="toggle-target">
      <!-- START PAGE SIDEBAR -->
      <div class="page-sidebar">
        <!-- START X-NAVIGATION -->
        <ul class="x-navigation">
          <li class="xn-logo">
            <a href="/admin">IEREK</a>
            <a href="/admin" class="x-navigation-control"></a>
          </li>
          <li class="xn-profile">
            <?php if(Auth::user()->gender == 1 OR Auth::user()->gender == 0){ $gender = 'male'; }elseif(Auth::user()->gender == 2){ $gender = 'female'; } ?>
            <a href="#" class="profile-mini">
              <img src="@if(Auth::user()->image == '') /uploads/default_avatar_{{ $gender }}.jpg @else /storage/uploads/users/profile/{{ Auth::user()->image }}.jpg @endif" alt="{{ Auth::user()->first_name.' '.Auth::user()->last_name }}" width="36px" height="36px">
            </a>
            <div class="profile">
              <div class="profile-image">
                <img src="@if(Auth::user()->image == '') /uploads/default_avatar_{{ $gender }}.jpg @else /storage/uploads/users/profile/{{ Auth::user()->image }}.jpg @endif" alt="{{ Auth::user()->first_name.' '.Auth::user()->last_name }}" width="100px" height="100px">
              </div>
              <div class="profile-data">
                <div class="profile-data-name">{{ substr(Auth::user()->first_name, 0, 10) }}</div>
                <div class="profile-data-title">{{ substr(Auth::user()->email, 0, 30) }}</div>
              </div>
                @if(Auth::user()->user_type_id == 4)
              <div class="profile-controls">
                <a href="/admin/all-users/profile/{{Auth::user()->user_id}}" class="profile-control-left"><span class="fa fa-cog"></span></a>
                <a href="/admin/messages" class="profile-control-right"><span class="fa fa-envelope"></span></a>
              </div>
                @endif
            </div>
          </li>
          <li class="xn-title">Navigation</li>
          <li data-home="admin">
            <a href="{{url('admin')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
          </li>
           @if(Auth::user()->user_type_id == 4)
          <li data-active="mail">
            <a href="{{url('admin/mail')}}"><span class="fa fa-envelope"></span> <span class="xn-text">Mail Settings</span></a>
          </li>
          <li data-active="notifications">
            <a href="{{url('admin/notifications')}}"><span class="fa fa-bell"></span> <span class="xn-text">Notifications</span> <span class="label label-warning pull-right" id="menu-noti"></span></a>
          </li>
          <li data-active="messages">
            <a href="{{url('admin/messages')}}"><span class="fa fa-envelope"></span> <span class="xn-text">Messages</span> <span class="label label-danger pull-right" id="msg-numbers"></a>
          </li>
          <li data-active="logs">
            <a href="{{url('admin/logs')}}"><span class="fa fa-file-text-o"></span> <span class="xn-text">Logs</span></a>
          </li>
          @endif
          <li class="xn-openable"  data-active="events">
            <a href="#"><span class="fa fa-calendar"></span> <span class="xn-text">Events</span></a>
            <ul>
              <li class="xn-openable" data-active="conference"><a href="#"><span class="fa fa-bullhorn"></span> Conference</a>
              <ul>
                   @if(Auth::user()->user_type_id == 4)
                <li data-active="conference/create"><a href="{{url('admin/events/conference/create')}}"><span class="fa fa-align-center"></span> Create</a></li>
                @endif
                <li data-active="conference"><a href="{{url('admin/events/conference')}}"><span class="fa fa-align-justify"></span> Manage</a></li>
              </ul>
            </li>
            <li data-active="bookseries" class="xn-openable"><a href="#"><span class="fa fa-book"></span> Book Series</a>
            <ul>
               @if(Auth::user()->user_type_id == 4)
              <li data-active="create" ><a href="{{url('admin/events/bookseries/create')}}"><span class="fa fa-align-center"></span> Create</a></li>
              @endif
              <li  data-active="bookseries"><a href="{{url('admin/events/bookseries')}}"><span class="fa fa-align-justify"></span> Manage</a></li>
            @if(Auth::user()->user_type_id >= 3)
              <li data-active="categories"><a href="{{url('admin/events/bookseries/categories/show')}}"><span class="fa fa-sitemap"></span> Categories</a></li>
            @endif
            </ul>
          </li>
            <li data-active="workshop" class="xn-openable"><a href="#"><span class="fa fa-briefcase"></span> Workshops</a>
            <ul>
               @if(Auth::user()->user_type_id == 4)
              <li data-active="create" ><a href="{{url('admin/events/workshop/create')}}"><span class="fa fa-align-center"></span> Create</a></li>
              @endif
              <li  data-active="workshop"><a href="{{url('admin/events/workshop')}}"><span class="fa fa-align-justify"></span> Manage</a></li>
            </ul>
          </li>
          <li data-active="studyabroad" class="xn-openable"><a href="#"><span class="fa fa-certificate"></span> Study Abroad</a>
          <ul>
              @if(Auth::user()->user_type_id == 4)
            <li data-active="create" ><a href="{{url('admin/events/studyabroad/create')}}"><span class="fa fa-align-center"></span> Create</a></li>
            @endif
            <li data-active="studyabroad"><a href="{{url('admin/events/studyabroad')}}"><span class="fa fa-align-justify"></span> Manage</a></li>
             @if(Auth::user()->user_type_id == 4)
            <li data-active="categories"><a href="{{url('admin/events/studyabroad/categories/show')}}"><span class="fa fa-sitemap"></span> Categories</a></li>
            @endif
          </ul>
          <li data-active="studies"><a href="{{url('admin/events/studies')}}"><span class="fa fa-graduation-cap"></span> Studies</a></li>
          @if(Auth::user()->user_type_id == 4)
          <li data-active="events/settings"><a href="{{url('admin/events/settings/important_dates')}}"><span class="fa fa-cogs"></span>Events Settings</a></li>
          @endif
        </li>
      </ul>
    </li>
    @if(Auth::user()->user_type_id == 4)
<!--    <li class="xn-openable">
      <a href="#"><span class="fa fa-dollar"></span> <span class="xn-text">Payments</span></a>
      <ul>
        <li class="hidden"><a href="/admin/payments/create"><span class="fa fa-plus"></span> New</a></li>
        <li><a href="/admin/payments"><span class="fa fa-cogs"></span> Manage</a></li>
      </ul>
    </li>-->
    
    
    <li class="xn-openable" data-active="pages">
      <a><span class="fa fa-files-o"></span> <span class="xn-text">Pages</span></a>
      <ul>
        <li class="xn-openable" data-active="home"><a><span class="fa fa-home"></span> Home</a>
        <ul>
          <li data-active="slider" ><a href="{{url('admin/pages/home/slider')}}"><span class="fa fa-image"></span> Slider</a></li>
          <li data-active="featured_conferences"><a href="{{url('admin/pages/home/featured_conferences')}}"><span class="fa fa-bullhorn"></span> Featured Conferences</a></li>
          <li data-active="featured_workshops"><a href="{{url('admin/pages/home/featured_workshops')}}"><span class="fa fa-briefcase"></span> Featured Workshops</a></li>
           <li data-active="featured_summer_schools"><a href="{{url('admin/pages/home/featured_summer_schools')}}"><span class="fa fa-briefcase"></span> Featured Summer Schools</a></li>
            <li data-active="featured_winter_schools"><a href="{{url('admin/pages/home/featured_winter_schools')}}"><span class="fa fa-briefcase"></span> Featured Winter Schools</a></li>
            <li data-active="announcement"><a href="{{url('admin/pages/home/announcement')}}"><span class="fa fa-briefcase"></span>Announcement</a></li>
          <li data-active="video" ><a href="{{url('admin/pages/home/video')}}"><span class="fa fa-youtube"></span> Video</a></li>
          <li data-active="video" ><a href="{{url('admin/pages/home/partners')}}"><span class="fa fa-youtube"></span> Partners</a></li>

        </ul>
      </li>
      
      <li data-active="static" class="xn-openable"><a href="#"><span class="fa fa-file"></span> Static Pages</a>
      <ul>
        <!--<li><a href="/admin/pages/static/speakers"><span class="fa fa-file-text-o"></span> Speakers</a></li>
        <li><a href="/admin/pages/static/sponsores"><span class="fa fa-file-text-o"></span> Sponsors</a></li>
        <li><a href="/admin/pages/static/media"><span class="fa fa-file-text-o"></span> Media Coverage</a></li> -->
        <!-- <li><a href="/admin/pages/static/careers"><span class="fa fa-file-text-o"></span> Careers</a></li>
        <li><a href="/admin/pages/static/suggest"><span class="fa fa-file-text-o"></span> Suggest</a></li>
        <li><a href="/admin/pages/static/feedback"><span class="fa fa-file-text-o"></span> Feedback</a></li> -->
        <li data-active="about"><a href="/admin/pages/static/about"><span class="fa fa-asterisk"></span> About Us </a></li>
        <li data-active="press"><a href="/admin/pages/static/press"><span class="fa fa-file-text-o"></span> IEREK Press </a></li>
        <li data-active="sc"><a href="/admin/pages/static/sc"><span class="fa fa-user"></span> Scientific Committee </a></li>
        <li data-active="sc"><a href="/admin/pages/static/translation_service"><span class="fa fa-globe"></span> Translation Service </a></li>
        <li data-active="faq"><a href="/admin/pages/static/faq"><span class="fa fa-info"></span> FAQ</a></li>
        <li data-active="contact"><a href="/admin/pages/static/contact"><span class="fa fa-headphones"></span> Contact Us</a></li>
        <li data-active="terms"><a href="/admin/pages/static/terms"><span class="fa fa-ban"></span> Terms & Conditions</a></li>
        <li data-active="careers"><a href="/admin/pages/static/careers"><span class="fa fa-briefcase"></span> Careers </a></li>
        <li data-active="suggest"><a href="/admin/pages/static/suggest"><span class="fa fa-lightbulb-o"></span> Suggest </a></li>
        <li data-active="feedback"><a href="/admin/pages/static/feedback"><span class="fa fa-bullhorn"></span> Feedback </a></li>
        <li data-active="feedback"><a href="/admin/pages/static/study_abroad_intro"><span class="fa fa-graduation-cap"></span> Study Abroad </a></li>
        <li data-active="feedback"><a href="/admin/pages/static/undergraduate_studies"><span class="fa fa-sun-o"></span> Undergraduate Studies</a></li>
        <li data-active="feedback"><a href="/admin/pages/static/postgraduate_studies"><span class="fa fa-cloud"></span> Postgraduate Studies</a></li>
        <li data-active="feedback"><a href="/admin/pages/static/bookseries"><span class="fa fa-book"></span> Book Series</a></li>
        <li data-active="feedback"><a href="/admin/pages/static/conference_proceedings"><span class="fa fa-users"></span> Conference Proceeding</a></li>
        <li data-active="feedback"><a href="/admin/pages/static/projects_managemnet"><span class="fa fa-dollar"></span> Projects Management</a></li>
        <li data-active="feedback"><a href="/admin/pages/static/scientists_forum"><span class="fa fa-search"></span> Scientists Forum</a></li>
      </ul>
    </li>
    <!-- <li><a href="/pages/contact"><span class="fa fa-file-text-o"></span> Contact Us</a></li>
    i class="xn-openable"><a href="#"><span class="fa fa-image"></span> News</a>
    <ul>
      <li><a href="/pages/news/create"><span class="fa fa-align-center"></span> Create</a></li>
      <li><a href="/pages/news"><span class="fa fa-align-justify"></span> Manage</a></li>
    </ul>
  </li>
  <li class="xn-openable"><a href="#"><span class="fa fa-image"></span> Blog</a>
  <ul>
    <li><a href="/pages/blog/create"><span class="fa fa-align-center"></span> Create</a></li>
    <li><a href="/pages/blog"><span class="fa fa-align-justify"></span> Manage</a></li>
  </ul>
</li> -->
<!-- <li class="xn-openable"><a href="#"><span class="fa fa-image"></span> Gallery</a>
<ul> -->
  <!-- <li class="xn-openable"><a href="#"><span class="fa fa-image"></span> Images</a>
  <ul>
    <li><a href="/pages/gallery/images/add"><span class="fa fa-align-center"></span> Add</a></li>
    <li><a href="/pages/gallery/images"><span class="fa fa-align-justify"></span> Manage</a></li>
  </ul>
</li> -->
<!-- <li class="xn-openable"><a href="#"><span class="fa fa-image"></span> Video</a>
<ul>
  <li><a href="/pages/gallery/video/add"><span class="fa fa-align-center"></span> Add</a></li>
  <li><a href="/pages/gallery/video"><span class="fa fa-align-justify"></span> Manage</a></li>
</ul>
</li> -->
<!-- </ul>
</li> -->
</ul>
</li>

<li data-active="users" class="xn-openable">
<a href="#"><span class="fa fa-users"></span> <span class="xn-text">Users</span></a>
<ul>
<li data-active="create"><a href="/admin/all-users/create"><span class="fa fa-plus"></span> New User</a></li>
<li data-active="admins"><a href="/admin/users/admins"><span class="fa fa-trophy"></span> Admins</a></li>
<li data-active="admins"><a href="/admin/users/editor"><span class="fa fa-cogs"></span> Editors</a></li>
<li data-active="scientific"><a href="/admin/users/scientific"><span class="fa fa-user"></span> Scientific Committee</a></li>
<li data-active="scientific"><a href="/admin/users/accountant"><span class="fa fa-dollar"></span>Accountant</a></li>
<li data-active="all-users"><a href="/admin/all-users"><span class="fa fa-square-o"></span> All users</a></li>
</ul>
@endif

@if(Auth::user()->user_type_id == 5)
 <li data-active="logs">
            <a href="{{url('admin/invoices')}}"><span class="fa fa-dollar"></span> <span class="xn-text">Inovices</span></a>
          </li>@endif

          <li data-active="logs">
            <a href="{{url('admin/hostConference')}}"><span class="fa fa-dollar"></span> <span class="xn-text">Host Conference</span></a>
          </li>
          
            <li data-active="logs">
            <a href="{{url('admin/studyAbroadApplications')}}"><span class="fa fa-dollar"></span> <span class="xn-text">Study Abroad Applications</span></a>
          </li>
{{-- </li>
<li class="xn-openable">
<a href="#"><span class="fa fa-pencil"></span> <span class="xn-text">Newsletter</span></a>
<ul>
<li><a href="/admin/newsletter/create"><span class="fa fa-align-center"></span> Add</a></li>
<li><a href="/admin/newsletter"><span class="fa fa-align-justify"></span> Manage</a></li>
</ul>
</li> --}}
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
<a href="#" class="x-navigation-minimize"><span class="fa fa-chevron-left"></span></a>
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
<a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
</li>
<!-- END SIGN OUT -->
<!-- MESSAGES -->
<!-- <li class="xn-icon-button pull-right">
<a href="#"><span class="fa fa-comments"></span></a>
<div class="informer informer-danger">4</div>
<div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
<div class="panel-heading">
<h3 class="panel-title"><span class="fa fa-comments"></span> Messages</h3>
<div class="pull-right">
<span class="label label-danger">4 new</span>
</div>
</div>
<div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
<a href="#" class="list-group-item">
<div class="list-group-status status-online"></div>
<img src="" class="pull-left" alt="John Doe"/>
<span class="contacts-title">John Doe</span>
<p>Praesent placerat tellus id augue condimentum</p>
</a>
<a href="#" class="list-group-item">
<div class="list-group-status status-away"></div>
<img src="" class="pull-left" alt="Dmitry Ivaniuk"/>
<span class="contacts-title">Dmitry Ivaniuk</span>
<p>Donec risus sapien, sagittis et magna quis</p>
</a>
<a href="#" class="list-group-item">
<div class="list-group-status status-away"></div>
<img src="" class="pull-left" alt="Nadia Ali"/>
<span class="contacts-title">Nadia Ali</span>
<p>Mauris vel eros ut nunc rhoncus cursus sed</p>
</a>
<a href="#" class="list-group-item">
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
</li> -->
<!-- END MESSAGES -->
<!-- TASKS -->
@if(Auth::user()->user_type_id == 4)
<li class="xn-icon-button pull-right">
<a href="#"><span class="fa fa-bell"></span></a>
<div class="informer informer-warning" id="noti-number"></div>
<div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
<div class="panel-heading">
<h3 class="panel-title"><span class="fa fa-bell"></span> Notifications</h3>
<div class="pull-right">
<span class="label label-warning" id="noti-count"></span>
</div>
</div>
<div class="panel-body list-group scroll" id="noti-place" style="max-height: 300px;overflow:auto">
<!-- NOTIFICATIONS HERE -->
</div>
<div class="panel-footer text-center">
<a href="{{ url('admin/notifications') }}">Show all</a>
</div>
</div>
</li>
<li class="xn-icon-button pull-right">
<a href="#"><span class="fa fa-envelope"></span></a>
<div class="informer informer-danger" id="msg-number"></div>
<div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
<div class="panel-heading">
<h3 class="panel-title"><span class="fa fa-comment"></span> Messages</h3>
<div class="pull-right">
<span class="label label-danger" id="msg-count"></span>
</div>
</div>
<div class="panel-body list-group scroll" id="msg-place" style="max-height: 300px;overflow:auto">
<!-- NOTIFICATIONS HERE -->
</div>
<div class="panel-footer text-center">
<a href="{{ url('admin/messages') }}">Show all</a>
</div>
</div>
</li>
@endif
<!-- END TASKS -->
</ul>
<!-- END X-NAVIGATION VERTICAL -->
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
@if(Session::has('danger'))
<section id="session_danger" class="info-box danger">
<div class="alert alert-danger">
<button type="button" class="close" data-dismiss="alert">
<span aria-hidden="true">&times;</span>
<span class="sr-only">Close</span>
</button>
<span>
<strong class="content">{{ Session::get('danger') }}</strong>
</span>
</div>
</section>
@endif
<ul class="breadcrumb">
<?php
$navs = explode('/', $_SERVER['REQUEST_URI']);
$count = 1;
unset($navs[0]);
$x = count($navs);
$url = '/';
foreach($navs as $nav){
$url = $url.$nav.'/';
if(!in_array($nav, array("users", "events", "filter", "pages", "home","fees","create","widgets","topics","sections","conference-details","section","admins","scommittee","dates","attendance","paper"))){
$urlx = $url;
}else{
$urlx= '#';
}
if(!is_numeric($nav)){
if($count < $x){
echo '<li><a href="'.$urlx.'">'.ucwords(str_replace('-',' ',$nav)).'</a></li>';
}
//echo $x.' '.$count;
if($count == $x){
echo '<li class="active">'.ucwords(str_replace('-',' ',$nav)).'</li>';
}
}
$count++;
}
?>
</ul>
@if(!isset($dashboard))
<div class="page-title">
<h2><a href="@yield('return-url')"><span class="fa fa-arrow-circle-o-left"></span></a> @yield('panel-title')</h2>
</div>
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
<a href="{{ url('logout') }}"  onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-success btn-lg">Yes</a>
<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>
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
'.rnHolder a{position: absolute;right: 0.4em;top: 0;color: #999;font-size: 16px;cursor: pointer;font-family: "Tahoma";transition: 0.5s}'+
'.rnHolder a:hover{color: #333}'+
'.rnHolder p{cursor: default;text-align:left;padding:7px 20px 0 45px;direction:ltr;font-family: "Tahoma";font-weight: 300;white-space:wrap;}'+
'.rnIconN{position:absolute;left:10px;top:50%;margin-top:-12.5px;width: 25px;height: 25px;background: url('+typeN+') no-repeat center center;background-size:25px 25px;}'+
'.rnIconX{position:absolute;left:10px;top:50%;margin-top:-12.5px;width: 25px;height: 25px;background: url('+typeX+') no-repeat center center;background-size:25px 25px;}'+
'.cBlocker{position:fixed;z-index: 1001!important;top:0;height:100vh;width:100vw;background-color:rgba(255,255,255,0.8);display:none;}'+
'.cHolder{width:50%;min-width:300px;background-color:#fff;box-shadow:0 4px 15px 0 rgba(0,0,0,0.19);padding:1em 0.5em;position:absolute;left:50%;-webkit-transform: translateX(-50%) translateY(-50%);transform: translateX(-50%) translateY(-50%);top:50%}'+
'.cHolder p{padding:0 1em; font-family:"Tahoma", sans-serif;margin-bottom:1em;font-weight:400;font-size:120%;text-align:left;white-space:wrap;}'+
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
@if(Session::has('redirect') && Session::has('status'))confirmX('<?php echo Session::get('status'); ?><br><br>You are now going to be redirected','{{Session::get('redirect')}}','Confirm','Stay');
@elseif(Session::has('status'))
returnN('<?php echo Session::get('status'); ?>','darkgreen',20000);
@endif
});
$.ajax({
type: 'GET',
url: '/admin/get/menu',
dataType: 'json',
beforeSend: function() {
},
success: function(response) {
if(response.success == true)
{
var target = document.getElementById('toggle-target');
var html = response.result;
if(html == 1)
{
$(".page-container").addClass("page-navigation-toggled");
$(".x-navigation-minimize").trigger("click");
}
}
},
error: function(response) {
}
});
var toggleing = 0;
function toggleMenu(val){
if(toggleing == 0){
if(val == 0){
var off = '-off';
}else{
var off = '';
}
$.ajax({
type: 'GET',
url: '/admin/get/menu-toggle'+off,
dataType: 'json',
beforeSend: function(){
toggleing = 1;
},
success: function(){
toggleing = 0;
},
error: function(){
toggleing = 0;
}
});
}
}
var lastNotiId = null;
var fetchNotiId = null;
var oldNotiTot = 0;
var newNotiTot = 0;
var getNotifications = function() {
$.ajax({
type: 'GET',
url: '/admin/get/notifications',
dataType: 'json',
beforeSend: function() {

},
success: function(response) {
if(response.success == true)
{
var target = document.getElementById('noti-place');
var count = document.getElementById('noti-count');
var countNumber = document.getElementById('noti-number');
var sideMenu = document.getElementById('menu-noti');
var result = response.result;
var countTot = result.length;
var html = '';
newNotiTot = 0;
for (i = 0; i < countTot; i++) {
var sGet = '<a style="border-left:5px solid '+result[i]['color']+';cursor: pointer" class="list-group-item" id="noti'+result[i]['notification_id']+'" onclick="readThis('+result[i]['notification_id']+');" data-url="'+result[i]['url']+'">'+
'<i class="fa fa-'+result[i]['icon']+'"></i>'+
'<strong>'+result[i]['title']+'</strong>'+
'<br><time class="timeago text-muted pull-right" id="timex'+i+'" datetime="'+result[i]['created_at']+'">'+result[i]['created_at']+'</time><div class="clearfix"></div>'+
'</a>';
html = html + sGet;
if(result[i]['show'] == 0){
newNotiTot = newNotiTot + 1;
}
}
fetchNotiId = result[0]['notification_id'];
$(countNumber).html(countTot);
$(sideMenu).html(countTot);
$(count).html(result.length +' Unread');
$(target).html(html);
if(fetchNotiId > lastNotiId){
countTot = newNotiTot - oldNotiTot;
if(newNotiTot > 0){
returnN('You have '+newNotiTot+' new notifications', 'green', 20000);
}
}
lastNotiId = fetchNotiId;
oldNotiTot = newNotiTot;
$(".timeago").timeago();
}

},
error: function(response) {

}
});
}
function readThis(id)
{
var target = document.getElementById('noti'+id);
var url = $(target).data('url');
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
type: 'POST',
url: '/admin/notifications/read/'+id,
dataType: 'json',
beforeSend: function() {

},
success: function(response) {
if(response.success == true)
{
window.open(url,'_self');
}

},
error: function(response) {

}
});
}
var lastMsgId = null;
var fetchMsgId = null;
var oldMsgTot = 0;
var newMsgTot = 0;
var getMessages = function() {
$.ajax({
type: 'GET',
url: '/admin/get/messages',
dataType: 'json',
beforeSend: function() {

},
success: function(response) {
if(response.success == true)
{
var target = document.getElementById('msg-place');
var count = document.getElementById('msg-count');
var countNumber = document.getElementById('msg-number');
var countNumbers = document.getElementById('msg-numbers');
var result = response.result;
var countTotx = result.length;
var html = '';
newMsgTot = 0;
for (i = 0; i < countTotx; i++) {
var sGet = '<a href="/admin/messages/'+result[i]['message_id']+'" style="border-left:5px solid '+result[i]['color']+';cursor: pointer" class="list-group-item" id="msg'+result[i]['message_id']+'" >'+
'<strong>'+result[i]['title']+'</strong>'+
'<br><time class="timeago text-muted pull-right" id="timex'+i+'" datetime="'+result[i]['created_at']+'">'+result[i]['created_at']+'</time><div class="clearfix"></div>'+
'</a>';
html = html + sGet;
if(result[i]['show'] == 0){
newMsgTot = newMsgTot + 1;
}
}
fetchMsgId = result[0]['message_id'];
$(countNumber).html(countTotx);
$(countNumbers).html(countTotx);
$(count).html(result.length +' Unread');
$(target).html(html);
if(fetchMsgId > lastMsgId){
countTotx = newMsgTot - oldMsgTot;
if(newMsgTot > 0){
var toOpen = "window.open('{{url("admin/messages")}}','_self');";
returnN('<span style="cursor:pointer" onclick="'+toOpen+'">You have '+newMsgTot+' new message(s)</span>', 'green', 20000);
}
}
lastMsgId = fetchMsgId;
oldMsgTot = newMsgTot;
$(".timeago").timeago();
}

},
error: function(response) {

}
});
}
@if(Auth::check())
$(document).ready(function(){
getNotifications();
getMessages();
});
setInterval(getNotifications, 15000);
setInterval(getMessages, 20000);
@endif
</script>
<!--Scripts and css in views will be inserted here-->
@stack('scripts')
<!--end inserting scripts and css-->
<!-- END SCRIPTS -->
</body>
</html>
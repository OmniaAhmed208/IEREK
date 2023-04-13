@extends('layouts.master') @section('content')
    <?php
    function cleanText($text)
    {
        // $text = strip_tags($text);
        // $text = str_replace('&nbsp;','', $text);
        // $text = str_replace('&nbsp; ','', $text);
        // $text = preg_replace('/(<[^>\n]+) style=".*?"/i', '$1', $text);
        $text = str_replace('&nbsp;', '', $text);
        $text = str_replace(' .', '.', $text);
        // $text = str_replace('\n\n','\n', $text);
        // $text = preg_replace('/[^0-9a-zA-Z \n]/','', $text);
        // $text = trim($text);
        // $text = var_dump($text);
        return '<div class="col-md-12" style="padding:0 1em;"><p>' . $text . '</p></div>';
    }


    ?>
    <title>
        {{ $event->title_en }}
    </title>
    <?php $call = 'IEREK Workshop'; ?>
    <div id="CONDETAILP">
        <div class="container">
            <figure class="cover-img">
                @if(file_exists('storage/uploads/workshops/'.$event->event_id.'/cover_img.jpg'))<img
                        src="/storage/uploads/workshops/{{ $event->event_id }}/cover_img.jpg" class="img-responsive"
                        alt=""/>@endif
            </figure>
            <div class="row">
                <div class="col-md-3 hidden-sm hidden-xs">
                    <div id="bs-example-navbar-collapse-3" class="navbar-collapse collapse ">
                        <div class="quick-links" style="margin-bottom:10px;">
                            <div class="frame-title blue-title">Quick Links</div>
                            <ul id="menu-quick-links" class="menu">
                                <li id="menu-item-4028"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4028">
                                    <a href="/speaker/{{ $event->event_id  }}">Become a speaker</a>
                                </li>
                                <li id="menu-item-4029"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4029">
                                    <a href="/sponsor/{{ $event->event_id  }}">Become a sponsor</a>
                                </li>
                                <li id="menu-item-4684"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4684">
                                    <a href="/media-coverage/{{ $event->event_id  }}">Media Coverage Request</a>
                                </li>
                                <li id="menu-item-4030"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                    <a href="#">Scientists Forum</a>
                                </li>
                                <li id="menu-item-40311"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030"><a
                                            href="{{url('terms-conditions')}}">Terms & Conditions</a></li>
                            </ul>
                        </div>
                        <div class="quick-links">
                            <div class="frame-title">Navigation</div>
                            <ul class="additional-menu">
                                @foreach($sections as $section)
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                        <a href="#{{ strtolower(str_replace(' ', '-', $section->title_en)) }}"
                                           class="navx"
                                           data-section="{{ strtolower(str_replace(' ', '-', $section->title_en)) }}"
                                           style="<?php if ($section->section_type_id == 1) {
                                               echo 'background:#f9f9f9';
                                           } ?>">{{ ucwords(strtolower($section->title_en)) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="hidden-xs hidden-sm">
                        @if(isset($widgets))
                            @foreach($widgets as $widget)
                                @if($widget->widget_type_id == 1)
                                    <div class="styled-box">
                                        <div class="box-title">
                                            {{ $widget->widget_title }}
                                        </div>
                                        <div>
                                            @if($widget->img != '' && file_exists('storage/uploads/workshops/'.$widget->event_id.'/widgets/'.$widget->img))
                                                <a href="{{$widget->img_url}}"><img
                                                            src="/storage/uploads/workshops/{{$widget->event_id}}/widgets/{{$widget->img}}"
                                                            style="width:100%;"></a>@endif
                                        </div>
                                        <div class="box-content">
                                            <p style="white-space: pre-wrap;"><?php echo $widget->widget_description; ?></p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    {{--<div class="plain-box hidden-sm hidden-xs">--}}
                    {{--@if(file_exists('uploads/images/Events.jpg'))<a href="/calendar"> <img style="width: 100%" src="/uploads/images/Events.jpg"> </a>@endif--}}
                    {{--</div>--}}
                    <div class="plain-box hidden-sm hidden-xs">

                        <a href="/workshops" class="quick-links-btn-mob sidebar-btn">
                            Upcoming Events
                            <i class="fa fa-caret-right"></i>
                        </a>

                    </div>
                </div>
                <div class="col-md-9 padle " style="position: static; ">
                    <div class="framed-box">
                        <div class="frame-title">
                            {{ $event->title_en }}
                        </div>
                        <div class="framed-content">
                            <div class="styled-box">
                                <div class="box-content row">
                                    <div class="col-md-3 hidden-xs hidden-sm">
                                        <div class="conference-cover">
                                            @if(file_exists('storage/uploads/workshops/'.$event->event_id.'/slider_img.jpg'))
                                                <img style="width: 100%; max-height: 218px;"
                                                     src="/storage/uploads/workshops/{{ $event->event_id }}/slider_img.jpg"> @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h2 class="box-title pulse1">
                                            <center>{{$call}}</center>
                                        </h2>
                                        <div style="text-align: center;">
                                            <?php echo str_replace('span', 'div', $event->custome); ?>
                                        </div>
                                        <div class="conference-data">
                                            <ul>
                                                <li>
                                                    {{ date("d, M", strtotime($event->start_date)) }}
                                                    / {{ date("d, M Y", strtotime($event->end_date)) }}
                                                </li>
                                                <li><b>{{ $event->location_en }}</b></li>
                                            </ul>
                                            <div class="addthis_sharing_toolbox"
                                                 style="text-align: center;margin-top: 15px;"></div>
                                            <span class="conference-email">
                                            Workshop Email
                                            <br> 
                                            <a href="mailto:{{ $event->email }}">{{ $event->email }}</a>
                                        </span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <center>
                                            @if(file_exists('storage/uploads/workshops/'.$event->event_id.'/featured_img.jpg'))
                                                <img src="/storage/uploads/workshops/{{ $event->event_id }}/featured_img.jpg"
                                                     alt="" style="max-width: 100%;  max-height: 232px;"
                                                     class="hidden-xs hidden-sm" align="center"> @endif
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <p class="bg-success message">

                        </p> -->

                        <div class="styled-box">
                            <div class="box-content">
                                @if( strtotime(date("d-m-Y", strtotime($event->start_date))) > strtotime(date("d-m-Y")))
                                    @if(Auth::check())
                                        @if($isreg == 1)
                                            <a href="{{ url('/payment/'.$event->slug) }}" id="regconf" style=""
                                               class="popup-register conference-registration-btn">Fees<span
                                                        class="hidden-xs">Payment</span> </a>
                                        @else
                                            <a href="javascript:void(0);
                                        " id="regconf" style="" class="popup-register conference-registration-btn"
                                               onclick="conf_register({{ $event->event_id }})">Register<span
                                                        class="hidden-xs">For Audience</span> </a>
                                        @endif
                                    @else
                                        <a href="javascript:void(0);" id="regconf" style=""
                                           class="popup-register conference-registration-btn" onclick="display_log(0)">Login<span
                                                    class="hidden-xs">To Register</span> </a>
                                    @endif
                                @else
                                    <a class="conference-registration-btn"
                                       style="background:#eee;color:#666;padding-right:5px;border-color:#666">Registraion
                                        Closed</a>
                                @endif
                            </div>
                        </div>
                        {{--<button type="button" class="navbar-toggle collapsed buttonx hidden-md hidden-lg" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false" style="margin-right: 0px !important;     border-radius: 0px;">--}}
                        {{--Quick Links & More Details <i class="fa fa-caret-down" style="background: #0C3852; margin-top: 0px !important; font-weight: 600; font-size: large; width: 9%; float: right;    padding: 4px; color: red;"></i>--}}
                        {{--</button>--}}
                        <div class="styled-box quick-links-btn-container hidden-md hidden-lg">
                            <div class="plain-box">
                                <button href="/conferences" data-toggle="collapse"
                                        data-target="#bs-example-navbar-collapse-2"
                                        class="quick-links-btn-mob sidebar-btn">
                                    Quick Links &amp; More Details
                                    <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                        </div>
                        <div class="hidden-md hidden-lg">
                            <div id="bs-example-navbar-collapse-2" class="navbar-collapse collapse">
                                <div class="quick-links" style="margin-bottom:10px;">
                                    <div class="frame-title blue-title">
                                        Quick Links
                                    </div>
                                    <ul id="menu-quick-links" class="menu">
                                        <li id="menu-item-4028"
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4028">
                                            <a href="#become_speaker">
                                                Become Speaker
                                            </a>
                                        </li>
                                        <li id="menu-item-4029"
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4029">
                                            <a href="#become_sponser">
                                                Become Sponsor
                                            </a>
                                        </li>
                                        <li id="menu-item-4684"
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4684">
                                            <a href="#media_coverage">
                                                Media Coverage Request
                                            </a>
                                        </li>
                                        <li id="menu-item-4030"
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                            <a href="#scientists-forms">
                                                Scientists Forum
                                            </a>
                                        </li>
                                        <li id="menu-item-40311"
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                            <a href="{{url('terms-conditions')}}">Terms & Conditions</a></li>
                                    </ul>
                                </div>
                                <div class="quick-links">
                                    <div class="frame-title">
                                        Navigation
                                    </div>
                                    <ul class="additional-menu">
                                        @foreach($sections as $section)
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                                <a href="#{{ strtolower(str_replace(' ', '-', $section->title_en)) }}"
                                                   class="navs"
                                                   data-section="{{ strtolower(str_replace(' ', '-', $section->title_en)) }}"
                                                   id="navs{{ $section->section_id }}" <?php if ($section->section_type_id == 1) {
                                                    echo 'style="background:#f9f9f9"';
                                                } ?>>{{ ucwords(strtolower($section->title_en)) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if(isset($widgets))
                            @foreach($widgets as $widget)
                                @if($widget->widget_type_id == 3)
                                    <div class="styled-box">
                                        <div class="box-title">
                                            {{ $widget->widget_title }}
                                        </div>
                                        <div>
                                            @if($widget->img != '' && file_exists('storage/uploads/workshops/'.$widget->event_id.'/widgets/'.$widget->img))
                                                <a href="{{$widget->img_url}}"><img
                                                            src="/storage/uploads/workshops/{{$widget->event_id}}/widgets/{{$widget->img}}"
                                                            style="width:100%;"></a>@endif
                                        </div>
                                        <div class="box-content">
                                            <p style="white-space: pre-wrap;"><?php echo $widget->widget_description; ?></p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        @foreach($sections as $section)
                            <div style="overflow: hidden;"
                                 class="styled-box section" <?php if ($section->section_type_id != 1) {
                                echo 'style="display:none';
                            } ?>" id="{{ strtolower(str_replace(' ', '-', $section->title_en)) }}">
                            <div class="box-title">
                                {{ ucwords(strtolower($section->title_en)) }}
                            </div>
                            <div class="box-content">
                                <section>
                                    @if($section->section_type_id == 2)
                                        <?php echo preg_replace('/(<[^>]+) style=".*?"/i', '$1', $section->description_en); ?>
                                        @if(isset($topics) && count($topics) > 0)
                                            <ol class="styled-list">
                                                @foreach($topics as $topic)
                                                    <li>
                                                        {{ $topic->position.'. '.ucwords(strtolower($topic->title_en)) }}
                                                        <div class="topic-description">
                                                            <p><?php echo $topic->description_en; ?></p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        @endif
                                    @elseif($section->section_type_id == 6)
                                        <?php echo preg_replace('/(<[^>]+) style=".*?"/i', '$1', $section->description_en); ?>
                                        @if(isset($dates) && count($dates) > 0)
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Date</th>
                                                    <th>Notes</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($dates as $date)
                                                    @if($date->to_date != '0000-00-00 00:00:00')
                                                        <tr>
                                                            <td>{{ $date->title }}</td>
                                                            <td>{{ date("jS F Y", strtotime($date->to_date) ) }}</td>
                                                            <td>{{ $date->title_en }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    @elseif($section->section_type_id == 3)
                                        <?php echo preg_replace('/(<[^>]+) style=".*?"/i', '$1', $section->description_en); ?>
                                        @if(isset($fees) && count($fees) > 0)
                                            <table class="table table-bordered table-hover">
                                                <tbody>
                                                @foreach($fees as $fee)
                                                    @if($fee->deleted != 1)
                                                        <tr>
                                                            <td>{{ $fee->title_en }}</td>
                                                            <td>{{$fee->currency.' '}}{{ $fee->amount }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    @elseif($section->section_type_id == 10)
                                        <input type="hidden" id="gmap_geocoding_address"
                                               value="{{$event->location_en}}">
                                        <?php echo preg_replace('/(<[^>]+) style=".*?"/i', '$1', $section->description_en); ?>
                                        <div class="box-content" id="gmap_geocoding" style="height: 250px;">

                                        </div>
                                    @else
                                        <?php //echo preg_replace('/(<[^>]+) style=".*?"/i', '$1',$section->description_en); ?>
                                        <?php echo $section->description_en; ?>
                                    @endif
                                </section>
                            </div>
                    </div>
                    @endforeach
                </div>

                <div class="styled-box first-tab-only conferencesContainer conference-page-featured-conf">
                    <div class="box-title">
                        Featured Workshops
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            @foreach($featured as $conf)
                                <div class="col-12 col-md-6">

                                    <div class="featured-conferences-item"
                                         style=" float: left; list-style: outside none none; position: relative;width: 100%; ">
                                        <div>
                                            <a class="conference-content-container"
                                               href="{{ url('events/') }}{{ '/'.$conf->slug }}">
                                                <div class="featured-conferences-item-thumb">
                                                    <div class="conference-main-img-container">
                                                        <img class="conference-main-img"
                                                             src="/storage/uploads/conferences/{{ $conf->event_id }}/list_img.jpg">
                                                    </div>
                                                </div>
                                                <div class="feature-conferences-item-text-container">
                                                    <div class="conference-item-title">
                                                        {{$conf->title_en}}

                                                    </div>
                                                    <div class="conference-item-location">
                                                        {{$conf->location_en}}
                                                    </div>

                                                    <div class="conference-item-detail">

                                                        {{date("d M", strtotime($conf->start_date))}}
                                                        / {{date("d M Y", strtotime($conf->end_date))}}
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="hidden-lg hidden-md">
                    @if(isset($widgets))
                        @foreach($widgets as $widget)
                            @if($widget->widget_type_id == 1)
                                <div class="styled-box">
                                    <div class="box-title">
                                        {{ $widget->widget_title }}
                                    </div>
                                    <div>
                                        @if($widget->img != '' && file_exists('storage/uploads/workshops/'.$widget->event_id.'/widgets/'.$widget->img))
                                            <a href="{{$widget->img_url}}"><img
                                                        src="/storage/uploads/workshops/{{$widget->event_id}}/widgets/{{$widget->img}}"
                                                        style="width:100%;"></a>@endif
                                    </div>
                                    <div class="box-content">
                                        <p style="white-space: pre-wrap;"><?php echo $widget->widget_description; ?></p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        function showSection(id, asset) {
            $('.section').each(function () {
                $(this).slideUp(200);
            });
            $('.navx').each(function () {
                $(this).css('background', '#fff');
            });
            $(asset).css('background', '#f1f1f1');
            $('#' + id).slideDown(200);
            setTimeout(function () {
                window.open('#' + id, '_self')
            }, 200);
        }

        function startSection(id, asset) {
            $('.section').each(function () {
                $(this).slideUp(200);
            });
            $('.navx').each(function () {
                $(this).css('background', '#fff');
            });
            $(asset).css('background', '#f1f1f1');
            $('#' + id).slideDown(200);
        }

        function fixTables() {
            $('table').each(function () {
                $(this).attr('style', 'min-width:100%');
                $(this).css('width', '100%!important');
            });
        }

        $(document).ready(function () {
            $('.navs').each(function () {
                $(this).on('click', function () {
                    var section_id = $(this).data('section');
                    showSection(section_id, this);
                });
            });
            $('.navx').each(function () {
                $(this).on('click', function () {
                    var section_id = $(this).data('section');
                    showSection(section_id, this);
                });
            });

            var current = window.location.hash;
            current = current.replace('#', '');
            var asset = document.getElementsByClassName('navx')[0];
            var first = document.getElementsByClassName('section')[0];
            if (current != '' && current != undefined) {
                showSection(current, asset);
            } else {
                var current = $(first).attr('id');
                startSection(current, asset);
            }
            fixTables()
            @if((Auth::check()))
            @if( strtotime(date("d-m-Y", strtotime($event->start_date))) > strtotime(date("d-m-Y")))
            @if(@$postpone < date('Y-m-d') && $isreg == 1)
            confirmX('<strong>Dear Colleague</strong>,<br>You have successfully registered in this Workshop: <b>{{$event->title_en}}</b>, please confirm your registration as you should pay the required fees to be confirmed.<br>', '{{ url('/payment/'.$event->slug) }}', 'Payment', '<a href="/event/{{ $event->slug }}/postpone">Remind Me Later</a>');
            @endif
            @endif
            @endif
        });
    </script>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_oi2nm63GIooUF7aJNMORXycgzoty04o"
            async defer></script>
    <script src="{{asset('assets/admin/gmap.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script type="text/javascript">
        var mapGeocoding = function () {

            var map = new GMaps({
                div: '#gmap_geocoding',
                lat: 0.00,
                lng: 0.00
            });

            var handleAction = function () {
                var text = $.trim($('#gmap_geocoding_address').val());
                GMaps.geocode({
                    address: text,
                    callback: function (results, status) {
                        if (status == 'OK') {
                            var latlng = results[0].geometry.location;
                            map.setCenter(latlng.lat(), latlng.lng());
                            map.addMarker({
                                lat: latlng.lat(),
                                lng: latlng.lng()
                            });
                        }
                    }
                });
            }

            handleAction();
        }
        $(window).bind('load', function () {
            setTimeout(mapGeocoding());
        });
    </script>
@endpush

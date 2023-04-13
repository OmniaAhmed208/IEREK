@extends('layouts.master') @section('content')
    <title>
        {{$event->title_en}}
    </title>
    <div id="CONDETAILP">
        <div class="container book_series">
            <figure class="cover-img">
                @if(file_exists('storage/uploads/bookseries/'.$event->event_id.'/cover_img.jpg'))<img
                        src="/storage/uploads/bookseries/{{ $event->event_id }}/cover_img.jpg" class="img-responsive"
                        alt=""/>@endif
            </figure>
            <div class="row">
                <div class="col-md-3">
                    <div class="col-12 hidden-sm hidden-xs">
                        <div id="bs-example-navbar-collapse-3" class="navbar-collapse collapse ">

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
                                            @if($widget->img != '' && file_exists('storage/uploads/bookseries/'.$widget->event_id.'/widgets/'.$widget->img))
                                                <div>
                                                    <a href="{{$widget->img_url}}"><img
                                                                src="/storage/uploads/bookseries/{{$widget->event_id}}/widgets/{{$widget->img}}"
                                                                style="width:100%;"></a>
                                                </div>
                                            @endif
                                            <div class="box-content">
                                                <p style="white-space: pre-wrap;"><?php echo $widget->widget_description; ?></p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="hidden-sm hidden-xs sidebar-btn-container">
                        <a href="/study_abroad" class="quick-links-btn-mob sidebar-btn"> Upcoming Events <i class="fa fa-caret-right"></i> </a>
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
                                        <div class="studyabroad-cover">
                                            <img style="width: 100%; max-height: 218px;"
                                                 src="/storage/uploads/bookseries/{{ $event->event_id }}/featured_img.jpg">
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <h2 class="box-title">
                                            <!--    Call For Paper -->
                                        </h2>

                                        <div class="studyabroad-data">
                                            <ul>
                                                <li>
                                                    {{ date("d, M", strtotime($event->start_date)) }}
                                                    / {{ date("d, M Y", strtotime($event->end_date)) }}
                                                </li>
                                                <li><b>{{ $event->location_en }}</b></li>
                                            </ul>
                                            <div class="addthis_sharing_toolbox"
                                                 style="text-align: center;margin-top: 15px;"></div>
                                            <span class="studyabroad-email">
                                            Book Series Editors: @if(isset($sc) && count($sc) > 0)
                                                    @foreach($sc as $s)
                                                        <strong>{{ $s->first_name.' '.substr(0,1,$s->last_name) }}
                                                            ,</strong>
                                                    @endforeach
                                                @endif
                                                <br>
                                            <a href="mailto:{{ $event->email }}">{{ $event->email }}</a>
                                        </span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <center>
                                            {{-- @if(file_exists('storage/uploads/bookseries/'.$event->event_id.'/featured_img.jpg')) <img src="/storage/uploads/bookseries/{{ $event->event_id }}/featured_img.jpg" alt="" style="max-width: 100%;  max-height: 232px;" class="hidden-xs hidden-sm" align="center"> @endif --}}
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <p class="bg-success message">

                        </p> -->

                        <div class="styled-box">
                            <div class="box-content">
                                @if(Auth::check())
                                    <a href="{{ url('/abstract/'.$master->slug) }}"
                                       class="conference-registration-btn pull-right">Publish<span class="hidden-xs">In This Series</span>
                                    </a>
                                @else
                                    <a href="javascript:void(0);" onclick="display_log(0)"
                                       class="conference-registration-btn pull-right">Login<span class="hidden-xs">To Publish In This Series</span>
                                    </a>
                                @endif
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="hidden-md hidden-lg">
                            <div class="styled-box quick-links-btn-container">
                                <button type="button"
                                        class="navbar-toggle collapsed buttonx hidden-md hidden-lg quick-links-btn-mob"
                                        data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false"
                                        style="margin-right: 0px !important;">
                                    Quick Links & More Details <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                            <div id="bs-example-navbar-collapse-2" class="navbar-collapse collapse">
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
                                {{--<div class="plain-box">--}}
                                    {{--<a href="#Scientific Committee" class="event-navigation"--}}
                                       {{--onclick="change_section({{ $section->section_id }})">--}}
                                        {{--<img src="/uploads/images/NEW.jpg" style="width:100%; "> </a>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                        @foreach($sections as $section)
                            <div class="styled-box section" <?php if ($section->section_type_id != 1) {
                                echo 'style="display:none';
                            } ?>" id="{{ strtolower(str_replace(' ', '-', $section->title_en)) }}">
                            <div class="box-title">
                                {{ $section->title_en }}
                            </div>
                            <div class="box-content">
                                <section>
                                    @if($section->section_type_id == 2)
                                        @if(isset($topics) && count($topics) > 0)
                                            @foreach($topics as $topic)
                                                <div class="topic-title">{{ $topic->position.'. '.$topic->title_en }}</div>
                                                <?php if (strlen($topic->description_en) > 11) {
                                                    echo '<div class="col-md-12" style="margin-bottom:5px;margin-top:5px;"><div class="topic-description" style="width:98%;float:right"><p style="text-align: justify;text-justify: inter-word;">';
                                                    echo $topic->description_en;
                                                    echo '</p></div></div>';
                                                } ?>
                                            @endforeach
                                        @endif
                                    @elseif($section->section_type_id == 6)
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
                                        @if(isset($fees) && count($fees) > 0)
                                            <table class="table table-bordered table-hover">
                                                <tbody>
                                                @foreach($fees as $fee)
                                                    @if($fee->deleted != 1)
                                                        <tr>
                                                            <td>{{ $fee->title_en }}</td>
                                                            <td>{{$event->currency.' '}}{{ $fee->amount }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    @else
                                        <?php if ($section->section_type_id == 7 && file_exists('storage/uploads/bookseries/' . $event->event_id . '/featured_img.jpg')) {
                                            echo '<img src="/storage/uploads/bookseries/' . $event->event_id . '/featured_img.jpg" class="procedia-right">';
                                        } echo $section->description_en; ?>
                                    @endif
                                </section>
                            </div>
                    </div>
                    @endforeach

                </div>
                <div class="framed-box hidden-lg hidden-md">
                    <div class="framed-content">
                        @if(isset($widgets))
                            @foreach($widgets as $widget)
                                @if($widget->widget_type_id == 1)
                                    <div class="styled-box">
                                        <div class="box-title">
                                            {{ $widget->widget_title }}
                                        </div>
                                        <div>
                                            @if($widget->img != '' && file_exists('storage/uploads/bookseries/'.$widget->event_id.'/widgets/'.$widget->img))
                                                <a href="{{$widget->img_url}}"><img
                                                            src="/storage/uploads/bookseries/{{$widget->event_id}}/widgets/{{$widget->img}}"
                                                            style="width:100%;"></a>@endif
                                        </div>
                                        <div class="box-content">
                                            <p style="white-space: pre-wrap;"><?php echo $widget->widget_description; ?></p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div class="plain-box" style="  margin: 15px 0px;
">
                            @if(file_exists('uploads/images/Events.jpg'))
                                <a href="/study_abroad" class="quick-links-btn-mob sidebar-btn"> Upcoming Events <i class="fa fa-caret-right"></i> </a>
                            @endif
                        </div>


                    </div>
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
                $(this).attr('style', '');
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
            var current = window.location.hash;
            current = current.replace('#section', '');
            fixTables()

        });
    </script>
@endpush

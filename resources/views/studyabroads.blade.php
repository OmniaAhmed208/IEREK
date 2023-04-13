@extends('layouts.master')

@section('content')
    <div id="CONFERENCEP">
        <div class="container conferences-page-container summerSchools">

            <figure class="cover-img">
               <img src="uploads/images/study_abroad_intro.jpg" alt=""/>
            </figure>

            <div class="margin-btm-30-mob">
                <div class="framed-box frame-box-mobile" style=" margin-bottom: 2%;">
                    <div class="frame-title">
                        Brief Introduction
                    </div>
                    <div class="mCustomScrollbar brief-description">
                        <p>
                         IEREK provides a variety of study abroad services and organizes programs that include undergraduate/ postgraduate services, summer schools and winter schools for students of all ages. With programs offering a hands-on experience, an opportunity to study and gain a deeper understanding of a certain topic/ subject and a chance to meet students from different backgrounds. IEREK will assist you in/throughout your:
                        </p>
       
                        <ul>
                            <li>Identifying the right university and right programme based on your area of interest, academic and financial background</li>
                            <li> visa application process and preparation</li>
                            <li>Arranging pre-departure briefing</li>
                            <li>provide airport pick-up where applicable </li>
                            <li>Finding the right accommodation
                             <br>
                                <p class="margin-b-0"> and more... </p>
                            </li>
                           
                        </ul>

                        <p class="padding-t-0"> If you are interested in expanding your knowledge and experiences, register to one of our programs or contact us on info@ierek.com and we can suggest the most suitable course for you!</p>
                    </div>
                </div>
                <div class="breifing hidden-xs hidden-sm">
                    <div class="quick-links" style="margin-bottom:10px;">
                        <ul id="menu-quick-links" class="menu">
                        </ul>
                    </div>
                    <figure class="hidden-xs hidden-sm">
                    </figure>

                </div>
            </div>

            <div class="tabsyears tabyears-study-abroad">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php $s = count($studyabroadYears); $cur = null; ?>
                    @foreach($studyabroadYears as $studyabroadYear)
                        @if($s == 1)
                            <li role="presentation" class="active navs"
                                data-year="{{str_replace(' ', '-', $studyabroadYear->title)}}"><a
                                        href="#{{str_replace(' ', '-', $studyabroadYear->title)}}"
                                        onclick="window.open('#{{str_replace(' ', '-', $studyabroadYear->title)}}', '_self')"
                                        aria-controls="con{{$studyabroadYear->sub_category_id}}" role="tab"
                                        data-toggle="tab">{{$studyabroadYear->title}}</a></li>
                            <?php $s = 0; $cur = $studyabroadYear->sub_category_id; ?>
                        @else
                            <?php $s = $s - 1; ?>
                            <li role="presentation" class="navs"
                                data-year="{{str_replace(' ', '-', $studyabroadYear->title)}}"><a
                                        href="#{{str_replace(' ', '-', $studyabroadYear->title)}}"
                                        onclick="window.open('#{{str_replace(' ', '-', $studyabroadYear->title)}}', '_self')"
                                        aria-controls="con{{$studyabroadYear->sub_category_id}}" role="tab"
                                        data-toggle="tab">{{$studyabroadYear->title}}</a>
                            </li>

                        @endif
                    @endforeach


                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    @foreach($studyabroadYears as $studyabroadYear)
                        @if($studyabroadYear->sub_category_id == $cur)
                            <div role="tabpanel" class="tab-pane active"
                                 id="{{str_replace(' ', '-', $studyabroadYear->title)}}">
                                @else
                                    <div role="tabpanel" class="tab-pane "
                                         id="{{str_replace(' ', '-', $studyabroadYear->title)}}">

                                        @endif
                                        <div class="row">
                                            <div class="col-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        {{--<div class="margin-btm-30-mob">--}}
                                                            {{--<div class="framed-box frame-box-mobile"--}}
                                                                 {{--style=" margin-bottom: 2%;">--}}
                                                                {{--<div class="frame-title">--}}
                                                                    {{--{{$studyabroadYear->title}}--}}
                                                                {{--</div>--}}
                                                                {{--<div class="mCustomScrollbar brief-description">--}}
                                                                    {{--<p>--}}
                                                                        {{--{!!$studyabroadYear->description!!}--}}
                                                                    {{--</p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="breifing hidden-xs hidden-sm">--}}
                                                                {{--<div class="quick-links" style="margin-bottom:10px;">--}}
                                                                    {{--<ul id="menu-quick-links" class="menu">--}}
                                                                    {{--</ul>--}}
                                                                {{--</div>--}}
                                                                {{--<figure class="hidden-xs hidden-sm">--}}
                                                                {{--</figure>--}}

                                                            {{--</div>--}}
                                                        {{--</div>--}}

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="row">
                                                    <div class="conferencesContainer">
                                                        @foreach($eventLists as $eventList)
                                                            @if($eventList->sub_category_id == $studyabroadYear->sub_category_id)
                                                                {{-- @if(file_exists('storage/uploads/studyabroads/{{ $eventList->event_id }}/list_img.jpg')) --}}
                                                                <div class="col-md-4">
                                                                    <div class="featured-conferences-item conferences-page-conf-container">
                                                                        <div>
                                                                            <a class="conference-content-container"
                                                                               href="{{ url('events/') }}{{ '/'.$eventList->slug }}">
                                                                                <div class="featured-conferences-item-thumb">
                                                                                    <div class="conference-main-img-container">
                                                                                        <img src="/storage/uploads/studyabroads/{{ $eventList->event_id }}/list_img.jpg"
                                                                                             width="100%" height="100%">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="feature-conferences-item-text-container">
                                                                                    <div class="conference-item-title">
                                                                                        {{$eventList->title_en}}
                                                                                    </div>
                                                                                    <div class="conference-item-location">
                                                                                        <b>Country: </b>{{$eventList->location_en}}
                                                                                    </div>

                                                                                    <div class="conference-item-detail">
                                                                                        <b>University:</b> {{@$eventList->title_ar}}
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- @endif --}}
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                            </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var current = window.location.hash;
            current = current.replace('#', '');
            if (current != '' && current != undefined) {
                $('li[data-year]').each(function () {
                    $(this).removeClass('active');
                    var year = $(this).data('year');
                    if (year == current) {
                        $(this).children('a').click();
                        $(this).addClass('active');
                        $('.tab-pane').each(function () {
                            $(this).removeClass('active');
                        });
                        $('#' + year).addClass('active');
                    }

                });
            }
        });
    </script>
@endpush
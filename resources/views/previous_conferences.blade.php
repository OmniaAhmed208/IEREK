@extends('layouts.master')

@section('content')
    <div id="CONFERENCEP">
        <div class="container">
            <figure class="cover-img">
                <img src="{{url('/uploads/images/designs-02.jpg')}}" class="img-responsive" alt=""/>
            </figure>
            <div class="margin-btm-30-mob">
                <div class="framed-box frame-box-mobile" style=" margin-bottom: 2%;">
                    <div class="frame-title">
                        Brief Introduction
                    </div>
                    <div class="brief-description mCustomScrollbar">
                        <p class="frame-box-content-mobile">Conferences are well-known
                            devices for gathering a community together, both for the
                            formal and the informal exchanges they promote.
                            <br>
                            IEREK plans and organizes numerous conferences annually, in
                            order to bring together academics and policymakers.
                            <br>
                            Very reputable universities become partners to these
                            conferences, and outstanding key speakers are invited to
                            contribute with their success.
                            <br>
                            Organizing a conference involves several phases:
                            – Creating an organizing structure – putting together the
                            group of people who are going to organize and run the
                            conference, and planning how they will work together.
                            – Planning the conference.
                            – Publicizing the conference and recruiting and registering
                            participants.
                            – Running the conference.
                            – Evaluating the conference and the conference-organizing
                            process.</p>
                    </div>
                </div>

            </div>

            <div class="tabsyears">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($conferenceYears as $conferenceYear)
                        @if($conferenceYear->title==date('Y')-1 && $eventsCount != 0)
                            <li role="presentation" class="active navs" data-year="{{$conferenceYear->title}}"><a class="nav-styles"
                                                                                                                  href="#{{$conferenceYear->title}}"
                                                                                                                  onclick="window.open('#{{$conferenceYear->title}}', '_self')"
                                                                                                                  aria-controls="con{{$conferenceYear->sub_category_id}}" role="tab"
                                                                                                                  data-toggle="tab">{{$conferenceYear->title}}</a></li>

                        @elseif($eventsCount == 0 && $conferenceYear->title==date('Y'))
                        <li role="presentation" class="active navs" data-year="{{$conferenceYear->title}}"><a class="nav-styles"
                                                                                                                  href="#{{$conferenceYear->title}}"
                                                                                                                  onclick="window.open('#{{$conferenceYear->title}}', '_self')"
                                                                                                                  aria-controls="con{{$conferenceYear->sub_category_id}}" role="tab"
                                                                                                                  data-toggle="tab">{{$conferenceYear->title}}</a></li>
                        @else
                            <li role="presentation" class="navs" data-year="{{$conferenceYear->title}}"><a class="nav-styles"
                                                                                                           href="#{{$conferenceYear->title}}"
                                                                                                           onclick="window.open('#{{$conferenceYear->title}}', '_self')"
                                                                                                           aria-controls="con{{$conferenceYear->sub_category_id}}" role="tab"
                                                                                                           data-toggle="tab">{{$conferenceYear->title}}</a></li>

                        @endif
                    @endforeach


                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    @foreach($conferenceYears as $conferenceYear)
                        @if($conferenceYear->title==date('Y')-1  && $eventsCount != 0)
                            <div role="tabpanel" class="tab-pane active" id="{{$conferenceYear->title}}">
                                
                        @elseif($eventsCount == 0 && $conferenceYear->title==date('Y'))
                            <div role="tabpanel" class="tab-pane active" id="{{$conferenceYear->title}}">
                                @else
                                    <div role="tabpanel" class="tab-pane " id="{{$conferenceYear->title}}">

                                        @endif

                                        <div class="row">
                                            <div class="col-md-12">

                                            </div>


                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="conferencesContainer">
                                                        @foreach($eventLists as $eventList)
                                                            @if($eventList->sub_category_id==$conferenceYear->sub_category_id)
                                                                <div class="col-md-4">
                                                                    <div class="featured-conferences-item conferences-page-conf-container"
                                                                         style=" float: left; list-style: outside none none; position: relative;width: 100%; ">
                                                                        <div>
                                                                            <a class="conference-content-container"
                                                                               href="{{ url('events/') }}{{ '/'.$eventList->slug }}">
                                                                                <div class="featured-conferences-item-thumb">
                                                                                    <div class="conference-main-img-container">
                                                                                        <img class="conference-main-img"
                                                                                             src="/storage/uploads/conferences/{{ $eventList->event_id }}/list_img.jpg">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="feature-conferences-item-text-container">
                                                                                    <div class="conference-item-title">
                                                                                        {{$eventList->title_en}}

                                                                                    </div>
                                                                                    <div class="conference-item-location">
                                                                                        {{$eventList->location_en}}
                                                                                    </div>

                                                                                    <div class="conference-item-detail">

                                                                                        {{date("d M", strtotime($eventList->start_date))}}
                                                                                        / {{date("d M Y", strtotime($eventList->end_date))}}
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        @foreach($finished as $eventList)
                                                            @if($eventList->sub_category_id==$conferenceYear->sub_category_id)
                                                                <div class="col-md-4">
                                                                    <div class="featured-conferences-item conferences-page-conf-container"
                                                                         style=" float: left; list-style: outside none none; position: relative;width: 100%; ">
                                                                        <div>
                                                                            <a class="conference-content-container"
                                                                               href="{{ url('events/') }}{{ '/'.$eventList->slug }}">
                                                                                <div class="featured-conferences-item-thumb">
                                                                                    <div class="conference-main-img-container">
                                                                                        <img class="conference-main-img"
                                                                                             src="/storage/uploads/conferences/{{ $eventList->event_id }}/list_img.jpg">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="feature-conferences-item-text-container">

                                                                                    <div class="conference-item-title">
                                                                                        {{$eventList->title_en}}
                                                                                        <h3>
                                                                                            <span class="badge badge-pill badge-warning overview_badge">Overview</span>
                                                                                        </h3>
                                                                                    </div>
                                                                                    <div class="conference-item-location">
                                                                                        {{$eventList->location_en}}
                                                                                    </div>

                                                                                    <div class="conference-item-detail">

                                                                                        {{date("d M", strtotime($eventList->start_date))}}
                                                                                        / {{date("d M Y", strtotime($eventList->end_date))}}
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
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
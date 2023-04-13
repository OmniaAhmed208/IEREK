@extends('layouts.master')

@section('content')
    <div id="CONFERENCEP" class="workshop-layout">
        <div class="container">
            <figure class="cover-img">
                <img src="{{url('/uploads/images/workshops-banner-01.jpg')}}" class="img-responsive" alt=""/>
            </figure>
            <div class="margin-btm-30-mob">
                <div class="framed-box" style=" margin-bottom: 2%;">
                    <div class="frame-title">Brief Introduction</div>
                    <div class="brief-description mCustomScrollbar">
                        <p>IEREK offers workshops to
                            Practice, exchange and enrich knowledge to inspire
                            researchers, and develop their capabilities to impact the
                            ever-changing world.
                            IEREK workshops are crucial to researchers and students
                            whether Under-graduates or post-graduates. Workshops in
                            IEREK help the audiences engage and stay motivated.
                            Workshops are considered a practical training on specific
                            topics, such as , design methods, building materials. The
                            main goal is not only to pass knowledge to the participants,
                            but also to enable them to use this knowledge in a creative
                            and an innovative way.
                            Consequently, the participant will be able to achieve many
                            improvements in the practical and professional levels in all
                            fields of Architecture and Engineering.
                            Some of the most important workshops that IEREK offer are:

                            • Primavera Course:
                            - Using the Project management software to create a work
                            breakdown structure.
                            - Schedule the projects and optimizing the project plan.
                            - Time management and Cost Estimation

                            • Project Management Professional (PMP):
                            - Having the most industry-recognized certification in
                            project management.
                            - Scope management, Time & Cost Management, Quality
                            Management.
                            - Communication Management and Risk Management.

                            • BIM (Revit Architecture):
                            - Applying design ideas and concepts in a suitable modelling
                            techniques.
                            - How to produce an efficient Building Information Model.
                            - How to produce an efficient 3D-Model which is accurate
                            enough to be constructed.

                            • BIM (Revit Structure):
                            - Setting-up levels and a grid of columns in buildings.
                            - Construction design analysis.
                            - Link the constructed works to fit with Architectural works
                            as well.</p>
                    </div>
                </div>


            </div>

            <div class="tabsyears">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($workshopYears as $workshopYear)
                        @if($workshopYear->title==date('Y'))
                            <li role="presentation" class="active"><a href="#con{{$workshopYear->sub_category_id}}"
                                                                      aria-controls="con{{$workshopYear->sub_category_id}}"
                                                                      role="tab"
                                                                      data-toggle="tab">{{$workshopYear->title}}</a>
                            </li>


                        @else
                            <li role="presentation"><a href="#con{{$workshopYear->sub_category_id}}"
                                                       aria-controls="con{{$workshopYear->sub_category_id}}" role="tab"
                                                       data-toggle="tab">{{$workshopYear->title}}</a></li>

                        @endif
                    @endforeach


                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    @foreach($workshopYears as $workshopYear)
                        @if($workshopYear->title==date('Y'))
                            <div role="tabpanel" class="tab-pane active" id="con{{$workshopYear->sub_category_id}}">
                                @else
                                    <div role="tabpanel" class="tab-pane " id="con{{$workshopYear->sub_category_id}}">

                                        @endif

                                        <div class="row">


                                            <div class="col-md-12">
                                                <div class="row">
                                                    @foreach($eventLists as $eventList)
                                                        @if($eventList->sub_category_id==$workshopYear->sub_category_id)
                                                            <div class="col-12 col-sm-3">
                                                                <div class="conferences-list-item">
                                                                    <a href="{{ url('events/') }}{{ '/'.$eventList->slug }}">
                                                                        <div class="conference-item-cover">
                                                                            <img src="/storage/uploads/workshops/{{ $eventList->event_id }}/list_img.jpg">
                                                                            {{--<img src="http://via.placeholder.com/255x361">--}}
                                                                        </div>
                                                                        <div class="conference-details-text">
                                                                            <div class="conference-item-title">
                                                                                {{$eventList->title_en}}                                                   </div>
                                                                            <div class="conference-item-location">
                                                                                {{$eventList->location_en}}                                                </div>

                                                                            <div class="conference-item-detail">

                                                                                {{date("d M Y", strtotime($eventList->start_date))}}
                                                                                / {{date("d M Y", strtotime($eventList->end_date))}}
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
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

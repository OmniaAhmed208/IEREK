@extends('layouts.master')

@section('content')
<div id="CONFERENCEP">
    <div class="container">
        <figure class="cover-img">
            <img src="{{url('/uploads/images/con-series-01.png')}}" class="img-responsive" alt=""/>
        </figure>
        <div class="tabsyears">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                @foreach($conferenceYears as $conferenceYear)
                @if($conferenceYear->title==date('Y'))
                <li role="presentation" class="active navs" data-year="{{$conferenceYear->title}}"><a href="#{{$conferenceYear->title}}" onclick="window.open('#{{$conferenceYear->title}}', '_self')" aria-controls="con{{$conferenceYear->sub_category_id}}" role="tab" data-toggle="tab">{{$conferenceYear->title}}</a></li>


                @else
                <li role="presentation" class="navs" data-year="{{$conferenceYear->title}}"><a href="#{{$conferenceYear->title}}" onclick="window.open('#{{$conferenceYear->title}}', '_self')"  aria-controls="con{{$conferenceYear->sub_category_id}}" role="tab" data-toggle="tab">{{$conferenceYear->title}}</a></li>

                @endif
                @endforeach


            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                @foreach($conferenceYears as $conferenceYear)
                @if($conferenceYear->title==date('Y'))
                <div role="tabpanel" class="tab-pane active" id="{{$conferenceYear->title}}">
                    @else
                    <div role="tabpanel" class="tab-pane " id="{{$conferenceYear->title}}">

                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                
                            </div>


                            <div class="col-md-3">
                                <div class="framed-box" style=" margin-bottom: 2%;">
                                    <div class="frame-title">
                                        Brief Introduction {{$conferenceYear->title}}
                                    </div>
                                    <div class="framed-content conbref mCustomScrollbar">
                                        <p style="white-space:pre-wrap">Conferences are well-known devices for gathering a community together, both for the formal and the informal exchanges they promote. 

IEREK plans and organizes numerous conferences annually, in order to bring together academics and policymakers. 

Very reputable universities become partners to these conferences, and outstanding key speakers are invited to contribute with their success.

Organizing a conference involves several phases:
– Creating an organizing structure – putting together the group of people who are going to organize and run the conference, and planning how they will work together.
– Planning the conference.
– Publicizing the conference and recruiting and registering participants.
– Running the conference.
– Evaluating the conference and the conference-organizing process.</p>        
                                    </div>
                                </div>
                                <div class="breifing hidden-xs hidden-sm">
                                    <div class="quick-links" style="margin-bottom:10px;">
                                        <ul id="menu-quick-links" class="menu">
                                        </ul></div>
                                    <figure class="hidden-xs hidden-sm">
                                        <a href="/calendar">
                                            <img src="/uploads/images/Events.jpg" style="padding-bottom:10px;" alt=""/>
                                        </a>
                                    </figure>
                                    <figure class="hidden-xs hidden-sm">
                                    </figure>

                                </div>
                            </div>
                            <div class="col-md-9">
                                 <div class="box-title">Advanced Conferences Series</div>
                                <div class="row">
                                    @foreach($eventLists as $eventList)
                                    @if($eventList->sub_category_id==$conferenceYear->sub_category_id)
                                    <div class="col-md-6 col-md-4 padle">
                                        <div class="conferences-list-item" style="height: 295px">
                                            <a href="{{ url('events/') }}{{ '/'.$eventList->slug }}">
                                                <div class="conference-item-cover" style="width:100%;height:150px;background: url(/storage/uploads/conferences/{{ $eventList->event_id }}/list_img.jpg) no-repeat center center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
                                                </div>
                                                <div class="conference-item-title">
                                                    {{$eventList->title_en}}	     
                                                    
                                                </div>
                                                <div class="conference-item-location">
                                                    {{$eventList->location_en}}		
                                                </div>

                                                <div class="conference-item-detail">

                                                      {{date("d M", strtotime($eventList->start_date))}} / {{date("d M Y", strtotime($eventList->end_date))}}	
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

    @endsection
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function(){
                var current = window.location.hash;
                current = current.replace('#','');
                if(current != '' && current != undefined){
                    $('li[data-year]').each(function(){
                        $(this).removeClass('active');
                        var year = $(this).data('year');
                        if(year == current){
                            $(this).addClass('active');
                            $('.tab-pane').each(function(){
                                $(this).removeClass('active');
                            });
                            $('#'+year).addClass('active');
                        }
                        
                    });
                }
            });
        </script>
    @endpush
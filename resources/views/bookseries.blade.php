@extends('layouts.master')

@section('content')
    <div id="CONFERENCEP">
        <div class="container">
            <figure class="cover-img">
                <img src="{{url('/uploads/images/bookseries.jpg')}}" class="img-responsive" alt=""/>
            </figure>
            <div class="panel panel-default">
                <div class="framed-box">
                    <div class="frame-title">
                        Brief Introduction
                    </div>
                    <div class="mCustomScrollbar brief-description brief-description-book-series">
                        <div class="container-fluid">
                            @if(isset($content)) <?php echo $content->content; ?> @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tabsyears tabyears-book-service">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($bookseriesYears as $bookseriesYear)
                        @if($bookseriesYear->title== (date('Y') + 1))
                            <li role="presentation" class="active navs" data-year="{{$bookseriesYear->title}}"><a
                                        href="#{{$bookseriesYear->title}}"
                                        onclick="window.open('#{{$bookseriesYear->title}}', '_self')"
                                        aria-controls="con{{$bookseriesYear->sub_category_id}}" role="tab"
                                        data-toggle="tab">{{$bookseriesYear->title}}</a></li>


                        @else
                            <li role="presentation" class="navs" data-year="{{$bookseriesYear->title}}"><a
                                        href="#{{$bookseriesYear->title}}"
                                        onclick="window.open('#{{$bookseriesYear->title}}', '_self')"
                                        aria-controls="con{{$bookseriesYear->sub_category_id}}" role="tab"
                                        data-toggle="tab">{{$bookseriesYear->title}}</a></li>

                        @endif
                    @endforeach


                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    @foreach($bookseriesYears as $bookseriesYear)
                        @if($bookseriesYear->title== (date('Y') + 1))
                            <div role="tabpanel" class="tab-pane active" id="{{$bookseriesYear->title}}">
                                @else
                                    <div role="tabpanel" class="tab-pane " id="{{$bookseriesYear->title}}">

                                        @endif

                                        <div class="row">
                                            <div class="col-md-12">

                                            </div>


                                            <div class="col-12 col-md-12">
                                                <div class="row">
                                                    @foreach($eventLists as $eventList)
                                                        @if($eventList->sub_category_id==$bookseriesYear->sub_category_id)
                                                            <div class="col-md-4 padle">
                                                                <div class="conferences-list-item"
                                                                     style="height: 330px">
                                                                    <a href="{{ url('events/') }}{{ '/'.$eventList->slug }}">
                                                                        <div class="conference-item-cover"
                                                                             style="width:100%;height:210px;background: url(/storage/uploads/bookseries/{{ $eventList->event_id }}/list_img.jpg) no-repeat center center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
                                                                        </div>
                                                                        <div class="conference-item-title">
                                                                            {{$eventList->title_en}}

                                                                        </div>
                                                                        <div class="conference-item-location">
                                                                            {{$eventList->location_en}}
                                                                        </div>

                                                                        <div class="conference-item-detail">

                                                                            {{date("d M Y", strtotime($eventList->end_date))}}
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
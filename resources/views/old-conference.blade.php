@extends('layouts.master') @section('content')
@if($event->slug == 'ebql')
<style>
	.padri{
		margin-top: 70px;
	}
	.thum{
		border-top:4px solid #AA822C;
		height:270px;
	}
	.scimg{
		border: 5px solid #ECECEC;
		box-shadow: 0 0 1px 1px #CBCBCB;
		border-radius: 23px;
		background: #fff;
		margin-top: -90px;
		-webkit-filter: grayscale(100%);
		filter: grayscale(100%);
		height:110px;
		width: 110px;
	}
</style>
@endif
<?php
function cleanText($text){
  // $text = strip_tags($text);
  // $text = str_replace('&nbsp;','', $text);
  // $text = str_replace('&nbsp; ','', $text);
  // $text = preg_replace('/(<[^>\n]+) style=".*?"/i', '$1', $text);
  $text = str_replace('&nbsp;','', $text);
  $text = str_replace(' .','.', $text);
  // $text = str_replace('\n\n','\n', $text);
  // $text = preg_replace('/[^0-9a-zA-Z \n]/','', $text);
  // $text = trim($text);
  // $text = var_dump($text);
  return '<div class="col-md-12" style="padding:0 1em;"><p>'.$text.'</p></div>';
}

foreach($scs as $sc){
    $name = $sc->users['first_name'];
}

?>
<title>
    {{$event->title_en}}
</title>

    <?php 
    $sd = $event->start_date; //event start date
    $ed = $event->end_date; //event end date
    $cd = date('Y-m-d'); //today
    $call = '';
    $abst = 0; 
    $ced = ''; 
    $cp = 1; 
    $rp_closed = ''; //ealry payment closed
    $sp_closed = ''; //regular paymnet closed
    $lp_closed = ''; //late paymnet closed
    ?>
    @if($cd > @$iDates[5]) <!-- if early payment date is ended -->
        <?php $rp_closed = 'style="text-decoration: line-through;color:red"'; ?>
    @endif
    @if($cd > @$iDates[6]) <!-- if regular payment date is ended -->
        <?php $sp_closed = 'style="text-decoration: line-through;color:red"'; ?>
    @endif
    @if($cd > @$iDates[7]) <!-- if late payment date is ended -->
        <?php $lp_closed = 'style="text-decoration: line-through;color:red"'; ?>
    @endif
    @if($ifDates == 1) <!-- if the conf. has important dates -->
        @if($cd < @$iDates[2]) <!-- if the last day of submit an abstract is greater than today -->
            <?php $abst = 1; ?> 
        @endif
        @if($cd < @$iDates[1])  <!-- if the submit an abstract date is greater than today -->
            <?php $call = 'Call For Abstracts'; $ced = @$cd; ?>
        @elseif($cd > @$iDates[1] && $cd < @$iDates[2]) <!-- if the submit an abstract date is less than today  
        and the last day o submission is greater than today-->
            <?php $call = 'Last Call For Abstracts'; $ced = @$iDates[1]; ?>
        @elseif($cd > @$iDates[2] && $cd < @$iDates[3]) <!-- if the last day of submission is less 
           than today and submit paper is greater than today-->
            <?php $call = 'Call For Papers'; $ced = @$iDates[2]; ?>
        @elseif($cd > @$iDates[3] && $cd < @$iDates[4]) <!-- if the day of submit paper is less 
           than today and the last day of paper submission is greater than today-->
            <?php $call = 'Last Call For Papers'; $ced = @$iDates[3]; ?>
        @elseif($cd > @$iDates[4] && $cd < @$iDates[5])
        <!-- if today is greater than last call for paper and less than early payment -->
            <?php $call = 'Early Payment'; $ced = @$iDates[4]; ?>
        @elseif($cd > @$iDates[5] && $cd < @$iDates[6])
         <!-- if today is greater than early payment  and less than regular payment -->
            <?php $call = 'Payment Open'; $ced = @$iDates[5]; ?>
        @elseif($cd > @$iDates[6] && $cd < @$iDates[7])
        <!-- if today is greater than regular payment  and less than late payment -->
            <?php $call = 'Late Payment'; $ced = @$iDates[6]; ?>
        @elseif($cd > @$iDates[7] && $cd < @$iDates[8])
        <!-- if today is greater than late payment  and less than visa letter -->
            <?php $call = 'Registration Closed'; $ced = @$iDates[7]; ?>
        @elseif($cd > @$iDates[8] && $cd < @$iDates[9])
        <!-- if today is greater than visa letter  and less than final acceptance -->
            <?php $call = 'Conference Program is Comming Soon'; $ced = @$iDates[8]; ?>
        @elseif($cd > @$iDates[9] && $cd < @$iDates[10])
        <!-- if today is greater than final acceptance and less than Conference program -->
            <?php $call = 'Conference Program Released';  $ced = @$iDates[9]; ?>
        @elseif($cd > @$iDates[10] && $cd < @$iDates[11])
         <!-- if today is greater than Conference program and less than Conference launching -->
        @if($cd > @$iDates[7])
             <!-- if today is greater than late payment -->
            <?php $cp = 0; ?>
        @endif
            <?php
                 $ced = @$iDates[10]; //conference program date
            function dateDiff($d1,$d2){
                $date1 = new DateTime($d1);
                $date2 = new DateTime($d2);

                
                $interval = $date1->diff($date2);
                // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 

                // shows the total amount of days (not divided into years, months and days like above)
                return $interval->days;
            }
             $call = dateDiff($cd,$sd).' Days To Launch'; // get the days between today and event start date 
             //if today is greater than the late payment date?> 
        @elseif($cd > $sd && $cd < $ed)
        <!-- if today is greater than event start date and less than event end date -->
            <?php $call = 'Conference Has Started'; ?>
        @elseif($cd > $ed)
        <!-- if today is greater than event end date (event is ended) -->
            <?php $call = 'Conference Overview'; ?>
        @elseif($cd > $iDates[8])
        <!-- if today is greater than visa letter date -->
            <?php $call = 'Registeration Is Open'; ?>
        @else
            <?php $call = 'IEREK Conference'; ?>
        @endif
    @else <!-- if conference does not has important dates -->
        <?php $call = 'IEREK Conference'; ?>
    @endif
    @if(date('Y-m-d') > $event->end_date || $event->overview == 1)
        <?php $call = 'Conference Overview'; ?>
    @endif
<div id="CONDETAILP">
    <div class="container">
        <figure class="cover-img">
            @if(file_exists('storage/uploads/conferences/'.$event->event_id.'/cover_img.jpg'))<img src="/storage/uploads/conferences/{{ $event->event_id }}/cover_img.jpg" class="img-responsive" alt="" />@endif
        </figure>
        <div class="row">
            <div class="col-md-3 hidden-sm hidden-xs">
                <div id="bs-example-navbar-collapse-3" class="navbar-collapse collapse ">
                    <div class="quick-links" style="margin-bottom:10px;">
                        <div class="frame-title blue-title">Quick Links</div>
                        <ul id="menu-quick-links" class="menu">
                            <li id="menu-item-4028" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4028">
                                <a href="/speaker/{{ $event->event_id  }}">Become a speaker</a>
                            </li>
                            <li id="menu-item-4029" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4029">
                                <a href="/sponsor/{{ $event->event_id  }}">Become a sponsor</a>
                            </li>
                            <li id="menu-item-4684" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4684">
                                <a href="/media-coverage/{{ $event->event_id  }}">Media Coverage Request</a>
                            </li>
                            <li id="menu-item-4030" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                <a href="#">Scientists Forum</a>
                            </li>
                            <li id="menu-item-40311" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030"><a href="{{url('terms-conditions')}}">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="quick-links">
                        <div class="frame-title">Navigation</div>
                        <ul class="additional-menu">
                        @foreach($sections as $section)
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                <a href="#{{ strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '', $section->title_en))) }}" class="navx @if($section->section_type_id == 7)  @endif" data-section="{{ strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '', $section->title_en))) }}" style="<?php if($section->section_type_id == 1){echo 'background:#f9f9f9';} ?>" >{{ ucwords(strtolower($section->title_en)) }}</a>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="plain-box">
                        <a href="@if(count($scs) == 0){{url('scientific-committee')}}@else{{'#scientific_committee'}}@endif" data-section="@if(count($scs) > 0){{'scientific_committee'}}@endif" class="event-navigation @if(count($scs) > 0){{'navx'}}@endif">
                            <img src="/uploads/images/NEW.jpg" style="width:100%;">
                        </a>
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
                                        @if($widget->img != '' && file_exists('storage/uploads/conferences/'.$widget->event_id.'/widgets/'.$widget->img))<a href="{{$widget->img_url}}"><img src="/storage/uploads/conferences/{{$widget->event_id}}/widgets/{{$widget->img}}" style="width:100%;"></a>@endif
                                    </div>
                                    <div class="box-content">
                                        <p style="white-space: pre-wrap;"><?php echo $widget->widget_description; ?></p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="plain-box hidden-sm hidden-xs">
                    @if(file_exists('uploads/images/Events.jpg'))<a href="/calendar"> <img style="width: 100%" src="/uploads/images/Events.jpg"> </a>@endif
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
                                        @if(file_exists('storage/uploads/conferences/'.$event->event_id.'/slider_img.jpg')) <img style="width: 100%; max-height: 218px;" src="/storage/uploads/conferences/{{ $event->event_id }}/slider_img.jpg"> @endif
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
                                                {{ date("d, M", strtotime($event->start_date)) }} / {{ date("d, M Y", strtotime($event->end_date)) }}
                                            </li>
                                            <li><b>{{ $event->location_en }}</b></li>
                                        </ul>
                                        <div class="addthis_sharing_toolbox" style="text-align: center;margin-top: 15px;"></div><span class="conference-email">
                                            Conference Email
                                            <br> 
                                            <a href="mailto:{{ $event->email }}">{{ $event->email }}</a>
                                        </span></div>
                                    {{------------------------------------------------------------------------------------------}}
                                      <div class="styled-box social-sharing-icons" >
                                            <div class="box-title" >
                                                Share on Social Media
                                            </div>
                                            <div class="box-content" style="text-align: center;margin-top: 15px;">
                                                <div class="effect jaques" >
                                                    <div class="buttons a2a_kit a2a_kit_size_32" >
                                                        <a class="fb a2a_button_facebook" title="Share on Facebook"><i
                                                                    class="fa fa-facebook" aria-hidden="true"></i></a>
                                                        <a class="tw a2a_button_twitter" title="Share on Twitter"><i
                                                                    class="fa fa-twitter" aria-hidden="true"></i></a>
                                                        <a class="in a2a_button_linkedin" title="Share on LinkedIn"><i
                                                                    class="fa fa-linkedin" aria-hidden="true"></i></a>
                                                 
                                                        <a class="in a2a_button_skype" title="Share on skype"><i
                                                                    class="fa fa-skype" aria-hidden="true"></i></a>
                                                        <a class="in a2a_button_outlook_com" title="Share on outlook"><i
                                                                    class="fa fa-envelope" aria-hidden="true"></i></a>
                                                        <a class="in a2a_button_pocket" title="Share on pocket"><i
                                                                    class="fa fa-get-pocket" aria-hidden="true"></i></a>
                                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{-------------------------------------------------------------------------------------}}
                                </div>
                                <div class="col-md-3">
                                    <center>
                                        @if(file_exists('storage/uploads/conferences/'.$event->event_id.'/featured_img.jpg')) <img src="/storage/uploads/conferences/{{ $event->event_id }}/featured_img.jpg" alt="" style="max-width: 100%;  max-height: 232px;" class="hidden-xs hidden-sm" align="center"> @endif
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <p class="bg-success message">
                        
                    </p> -->
                   <!-- if event start date is greater than today -->
                    @if( strtotime(date("d-m-Y", strtotime($event->start_date))) > strtotime(date("d-m-Y")))
                    <div class="styled-box">
                        <div class="box-content">
                            </a>
                                @if(Auth::check() && $cp == 1 && $paid != 1)
                                    @if($isreg == 1)
                                        <a href="{{ url('/payment/'.$event->slug) }}" id="regconf" style="" class="popup-register conference-registration-btn">Fees<span class="hidden-xs">Payment</span> </a>
                                    @else
                                        <a href="javascript:void(0);
                                        " id="regconf" style="" class="popup-register conference-registration-btn" onclick="conf_register({{ $event->event_id }})">Register<span class="hidden-xs">For Audience</span> </a>
                                    @endif
                                @elseif($cd < @$iDates[11] && $cp == 1 && !Auth::check())
                                <a href="javascript:void(0);" id="regconf" style="" class="popup-register conference-registration-btn" onclick="display_log(0)">Login<span class="hidden-xs">To Register</span> </a>
                                @elseif(Auth::check() && $paid == 1 && $isreg == 1)
                                    <a class="conference-registration-btn" style="background:green;color:#fff;padding-right:5px;border-color:darkgreen">Paid</a>
                                @else
                                    @if($isreg == 1 && $paid != 1)
                                    <a class="conference-registration-btn" style="background:#eee;color:#666;padding-right:5px;border-color:#666">Payment Closed</a>
                                    @else
                                    <a class="conference-registration-btn" style="background:#eee;color:#666;padding-right:5px;border-color:#666">Registraion Closed</a>
                                    @endif
                                @endif
                                @if($event->fullpaper == 1)<?php $abst = 1; ?>@endif
                                <!--@if($event->submission != 1 && $abst == 1)-->
                                    @if(Auth::check())
                                        <!--@if($isreg == 1)-->
                                            <a href="{{ url('/abstract/'.$event->slug) }}" class="conference-registration-btn pull-right">Submit an Abstract<span class="hidden-xs">For Authors</span> </a>
                                        <!--@else-->
                                            <a href="javascript:void(0);" onclick="conf_register({{ $event->event_id }})" class="conference-registration-btn pull-right">Register<span class="hidden-xs">To Submit an Abstract</span> </a>
                                        <!--@endif-->
                                    @else
                                        <a href="javascript:void(0);" onclick="display_log(0)" class="conference-registration-btn pull-right">Login<span class="hidden-xs">To Submit an Abstract</span> </a>
                                    @endif
<!--                                @else
                                    <a class="conference-registration-btn pull-right" style="background:#eee;color:#666;padding-right:5px;border-color:#666">Submission Closed</a>
                                @endif-->
                        </div>
                    </div>
                    @endif
                    <button type="button" class="navbar-toggle collapsed buttonx hidden-md hidden-lg" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false" style="margin-right: 0px !important;     border-radius: 0px;">
                        Quick Links & More Details <i class="fa fa-caret-down" style="background: #0C3852; margin-top: 0px !important; font-weight: 600; font-size: large; width: 9%; float: right;    padding: 4px; color: red;"></i>
                    </button>
                    <div class="hidden-md hidden-lg">
                        <div id="bs-example-navbar-collapse-2" class="navbar-collapse collapse">
                            <div class="quick-links" style="margin-bottom:10px;">
                                <div class="frame-title blue-title">
                                    Quick Links
                                </div>
                                <ul id="menu-quick-links" class="menu">
                                    <li id="menu-item-4028" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4028">
                                        <a href="/speaker/{{ $event->event_id  }}">Become a speaker</a>
                                    </li>
                                    <li id="menu-item-4029" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4029">
                                        <a href="/sponsor/{{ $event->event_id  }}">Become a sponsor</a>
                                    </li>
                                    <li id="menu-item-4684" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4684">
                                        <a href="/media-coverage/{{ $event->event_id  }}">Media Coverage Request</a>
                                    </li>
                                    <li id="menu-item-4030" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                        <a href="#">Scientists Forum</a>
                                    </li>
                                    <li id="menu-item-40311" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030"><a href="{{url('terms-conditions')}}">Terms & Conditions</a></li>
                                </ul>
                            </div>
                            <div class="quick-links">
                                <div class="frame-title">
                                    Navigation
                                </div>
                                <ul class="additional-menu">
                                    @foreach($sections as $section)
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                            <a href="#{{ strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '', $section->title_en))) }}" class="navs @if($section->section_type_id == 7)  @endif" data-section="{{ strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '', $section->title_en))) }}" id="navs{{ $section->section_id }}" <?php if($section->section_type_id == 1){echo 'style="background:#f9f9f9"';} ?>>{{ ucwords(strtolower($section->title_en)) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="plain-box">
                                <a href="@if(count($scs) == 0){{url('scientific-committee')}}@else{{'#scientific_committee'}}@endif" data-section="@if(count($scs) > 0){{'scientific_committee'}}@endif" class="event-navigation @if(count($scs) > 0){{'navx'}}@endif">
                                    <img src="/uploads/images/NEW.jpg" style="width:100%; ">
                                </a>
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
                                        @if($widget->img != '' && file_exists('storage/uploads/conferences/'.$widget->event_id.'/widgets/'.$widget->img))<a href="{{$widget->img_url}}"><img src="/storage/uploads/conferences/{{$widget->event_id}}/widgets/{{$widget->img}}" style="width:100%;"></a>@endif
                                    </div>
                                    <div class="box-content">
                                        <p style="white-space: pre-wrap;"><?php echo $widget->widget_description; ?></p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    @foreach($sections as $section)
                    <div style="overflow: hidden;" class="styled-box section" <?php if($section->section_type_id != 1){echo 'style="display:none';} ?>" id="{{ strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '', $section->title_en))) }}">
                        <div class="box-title">
                            {{ ucwords(strtolower($section->title_en)) }}
                        </div>
                        <div class="box-content">
                            <section>
                            @if($section->section_type_id == 2)
                                <?php echo $section->description_en; ?>
                                @if(isset($topics) && count($topics) > 0)
                                    <ol class="styled-list">
                                        @foreach($topics as $topic)
                                        <li>
                                            {{ $topic->position.'. '.ucwords(strtolower($topic->title_en)) }}
                                            @if(strlen($topic->description_en) > 20)
                                            <div class="topic-description">
                                                <p><?php  echo $topic->description_en; ?></p>
                                            </div>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ol>
                                @endif
                            @elseif($section->section_type_id == 6)
                                <?php echo $section->description_en; ?>
                                @if(isset($dates) && count($dates) > 0)
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                
                                        @foreach($dates as $date)
                                            @if($date->to_date != '0000-00-00 00:00:00')
                                                <tr <?php if(date("Y-m-d", strtotime($date->to_date)) == $ced){?> class="success" style="box-shadow: 0 2px 5px rgba(0,0,0,0.4);" <?php }elseif (date("Y-m-d", strtotime($date->to_date)) < $ced) {
                                                    echo 'style="background:#eee;text-decoration:line-through;color:red"';
                                                }elseif ($cd > $ed) {
                                                    echo 'style="background:#eee;"';
                                                }?> >
                                                    <td style="color:#666!important">{{ $date->title }}</td>
                                                    <td style="color:#666!important">{{ date("jS F Y", strtotime($date->to_date) ) }}</td>
                                                    <td style="color:#666!important">{{ $date->title_en }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                            @elseif($section->section_type_id == 7)
                            <?php if(file_exists('storage/uploads/conferences/'.$event->event_id.'/featured_img.jpg')){echo '<img src="/storage/uploads/conferences/'.$event->event_id.'/featured_img.jpg" style="float: right;margin: 0px 0px 15px 15px;" class="procedia-right;width:125px">'; echo strip_tags($section->description_en);}else{ echo $section->description_en;} ?>
                            @elseif($section->section_type_id == 3)
                                <?php echo $section->description_en; ?>
                                @if(isset($fees) && count($fees) > 0)
                                    <table class="table table-bordered table-hover">
                                        <caption><b>Regular Attendance Fees</b></caption>
                                        <tbody>                                
                                        @foreach($fees as $fee)
                                            @if($fee->deleted != 1)
                                                @if($fee->event_attendance_type_id == 1)
                                                    <tr @if($fee->event_date_type_id == 5)<?php echo $rp_closed;?>@elseif($fee->event_date_type_id == 6)<?php echo $sp_closed;?>@elseif($fee->event_date_type_id == 7)<?php echo $lp_closed;?>@endif >
                                                        <td style="color:#666!important"><b>{{ $fee->title_en }}</b></td>
                                                        <td style="color:#666!important">{{$fee->currency.' '}}{{ $fee->amount }}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-hover">
                                        <caption><b>Co-Authors Fees</b></caption>
                                        <tbody>                                
                                        @foreach($fees as $fee)
                                            @if($fee->deleted != 1)
                                                @if($fee->event_attendance_type_id == 2)
                                                    <tr @if($fee->event_date_type_id == 5)<?php echo $rp_closed;?>@elseif($fee->event_date_type_id == 6)<?php echo $sp_closed;?>@elseif($fee->event_date_type_id == 7)<?php echo $lp_closed;?>@endif >
                                                        <td style="color:#666!important"><b>{{ $fee->title_en }}</b></td>
                                                        <td style="color:#666!important">{{$fee->currency.' '}}{{ $fee->amount }}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-hover">
                                        <caption><b>Authors & Publication Fees</b></caption>
                                        <tbody>                                
                                        @foreach($fees as $fee)
                                            @if($fee->deleted != 1)
                                                @if($fee->event_attendance_type_id == 3)
                                                    <tr @if($fee->event_date_type_id == 5)<?php echo $rp_closed;?>@elseif($fee->event_date_type_id == 6)<?php echo $sp_closed;?>@elseif($fee->event_date_type_id == 7)<?php echo $lp_closed;?>@endif >
                                                        <td style="color:#666!important"><b>{{ $fee->title_en }}</b></td>
                                                        <td style="color:#666!important">{{$fee->currency.' '}}{{ $fee->amount }}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered table-hover">
                                        <caption><b>Other Services Fees</b></caption>
                                        <tbody>                                
                                        @foreach($fees as $fee)
                                            @if($fee->deleted != 1)
                                                @if($fee->event_attendance_type_id == 0)
                                                    <tr @if($fee->event_date_type_id == 5)<?php echo $rp_closed;?>@elseif($fee->event_date_type_id == 6)<?php echo $sp_closed;?>@elseif($fee->event_date_type_id == 7)<?php echo $lp_closed;?>@endif >
                                                        <td style="color:#666!important"><b>{{ $fee->title_en }}</b></td>
                                                        <td style="color:#666!important">{{$fee->currency.' '}}{{ $fee->amount }}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            @elseif($section->section_type_id == 10)
                                <input type="hidden" id= "gmap_geocoding_address" value="{{$event->location_en}}">
                                <?php echo $section->description_en; ?>
                                <div class="box-content" id="gmap_geocoding" style="height: 250px;">
                                    
                                </div>
                            @else
                                <?php echo $section->description_en; ?>
                            @endif
                            </section>
                        </div>
                    </div>
                    @endforeach
                    <div class="styled-box section" id="scientific_committee" style="display: none">
                        @if($event->slug == 'ebql')
                        <div class="box-title">
                            Head Of Scientific Committee
                        </div>
                        
                        <div class="row">
		<div class="col-md-12">
			<div class="row">
				<?php if($headOfScien->gender == 1 OR $headOfScien->gender == 0){ $gender = 'male'; }elseif($headOfScien->gender == 2){ $gender = 'female'; } ?>
					<div class="col-sm-6 col-md-4 padri">
						<center>
						<div class="thumbnail thum"><br>
							<a @if($headOfScien->slug != '') href="{{ url('comittee/'.$headOfScien->slug) }}" @endif>
								<figure>
									<div style="background:url(@if($headOfScien->image == '') /uploads/default_avatar_{{ $gender }}.jpg @else /storage/uploads/users/profile/{{ $headOfScien->image }}.jpg @endif)  no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;" class="scimg"></div>
								</figure>
							</a>
							<div class="caption">
								<h3><a @if($headOfScien->slug != '') href="{{ url('comittee/'.$headOfScien->slug) }}" @endif>{{ $headOfScien->first_name.' '.$headOfScien->last_name }}</a></h3>
								<p><?php echo substr($headOfScien->abbreviation, 0, 200) ?></p>
							</div>
						</div>
						</center>
					</div>
			</div>
		</div>
	</div>
                        
                        @endif
                        <div class="box-title">
                            Scientific Committee
                        </div>
                        <div class="box-content">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Organization</th>
                                        <th>Country</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($scs) > 0)
                                        @foreach($scs as $sc)
                                            <tr>
                                                <td>
                                                    <?php if($sc->gender == 1 OR $sc->gender == 0){ $gender = 'male'; }elseif($sc->gender == 2){ $gender = 'female'; } ?>
                                                    <img src="@if($sc->image == '') /uploads/default_avatar_{{ $gender }}.jpg @else /storage/uploads/users/profile/{{ $sc->image }}.jpg @endif" style="max-width:200px;border:1px #a97f18 solid;box-shadow: 0 2px 14px 0 rgba(0,0,0,0.1)" width="100px" height="100px">
                                                    <br><center><b>{{$sc->first_name.' '.$sc->last_name}}</b></center>
                                                </td>
                                                <td>
                                                    <?php if(strlen($sc->abbreviation) < 300){echo $sc->abbreviation;}else{ echo substr($sc->abbreviation, 0, 300).'..'; } ?><br><br><a class="btn btn-default btn-sm @if($sc->slug == ''){{'hide'}}@endif" href="{{url('comittee/'.$sc->slug)}}">Visit Profile</a>
                                                </td>
                                                <td style="min-width: 33%">
                                                    <center>@if($sc->countries['name'] != 'HOST'){{$sc->countries['name']}}@endif</center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="styled-box" style="text-align:justify;display:none">
                        <p style="clear:both">
                        @foreach($sections as $section)
                            @if($section->section_type_id == 7)
                            <div class="box-title">
                                {{ ucwords(strtolower($section->title_en)) }}
                            </div>
                            <?php if(file_exists('storage/uploads/conferences/'.$event->event_id.'/featured_img.jpg')){echo '<img src="/storage/uploads/conferences/'.$event->event_id.'/featured_img.jpg" style="float: right;margin: 0px 0px 15px 15px;" class="procedia-right;width:125px">'; echo strip_tags($section->description_en);}else{ echo $section->description_en;} ?>
                                <div class="clearfix"></div>
                            @endif
                        @endforeach    
                        </p>
                    </div>
                    <div class="styled-box first-tab-only" style="height:370px;overflow:hidden">
                        <div class="box-title">
                            Featured Conferences
                        </div>
                        <div class="box-content">
                            @foreach($featured as $conf)
                            <div class="col-md-6">
                                <div class="conferences-list-item" style="height:300px;">
                                    <a href="{{ url('events/') }}{{ '/'.$conf->slug }}">
                                        <div class="workshop-item-cover" style="width:100%;height:150px;background: url({{ url('/storage/uploads/conferences/'.$conf->event_id.'/list_img.jpg')}}) no-repeat center center; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover; ">
                                        </div>
                                        <div class="conference-item-title">
                                            {{$conf->title_en}}
                                        </div>
                                        <div class="conference-item-location">
                                            {{$conf->location_en}}
                                        </div>
                                        <div class="conference-item-detail">
                                            {{date("d M Y", strtotime($conf->start_date))}}
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
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
                                            @if($widget->img != '' && file_exists('storage/uploads/conferences/'.$widget->event_id.'/widgets/'.$widget->img))<a href="{{$widget->img_url}}"><img src="/storage/uploads/conferences/{{$widget->event_id}}/widgets/{{$widget->img}}" style="width:100%;"></a>@endif
                                        </div>
                                        <div class="box-content">
                                            <p style="white-space: pre-wrap;"><?php echo $widget->widget_description; ?></p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div class="plain-box">
                            @if(file_exists('uploads/images/Events.jpg'))<a href="/calendar"> <img style="width: 100%" src="/uploads/images/Events.jpg"> </a>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@if($event->slug == 'atcm')
<script src="{{asset('/js/tabNavJS.js')}}" type="text/javascript"></script>
<link href="{{ asset('/css/tabNavCSS.css')}}" rel="stylesheet">
@endif
<script type="text/javascript">
    function showSection(id, asset)
    {
        $('.section').each(function(){
            $(this).slideUp(200);
        });
        $('.navx').each(function(){
            $(this).css('background','#fff');
        });
        $(asset).css('background','#f1f1f1');
        $('#'+id).slideDown(200);
        setTimeout(function(){window.open('#'+id, '_self')}, 200);
    }
    function startSection(id, asset)
    {
        $('.section').each(function(){
            $(this).slideUp(200);
        });
        $('.navx').each(function(){
            $(this).css('background','#fff');
        });
        $(asset).css('background','#f1f1f1');
        $('#'+id).slideDown(200);
    }
    function fixTables(){
        $('table').each(function(){
            $(this).attr('style', '');
            $(this).css('width','100%!important');
        });
    }

        $(document).ready(function(){
            $('.navs').each(function(){
                $(this).on('click', function(){
                    var section_id = $(this).data('section');
                    showSection(section_id, this);
                });
            });
            $('.navx').each(function(){
                $(this).on('click', function(){
                    var section_id = $(this).data('section');
                    showSection(section_id, this);
                });
            });

            var current = window.location.hash;
            current = current.replace('#','');
            var first = document.getElementsByClassName('section')[0];
            if(current != '' && current != undefined){
                var asset = $('.navx[data-section='+current+']');
                startSection(current, asset);
            }else{
                var asset = document.getElementsByClassName('navx')[0];
                var current = $(first).attr('id');
                showSection(current, asset);
            }
            fixTables()
    @if((Auth::check()))
        @if($cp == 1 && $paid != 1)
            @if(@$postpone < date('Y-m-d') && $isreg == 1)
                @if($cd < $ed)
                    @if($promoCode === null)
                      confirmX('<strong>Dear Colleague</strong>,<br>You have successfully registered in this conference: <b>{{$event->title_en}}</b>, please confirm your registration as you should pay the required fees to be confirmed.@if($event->submission != 1 && $abst == 1)<br><br><strong>For Authors</strong>,<br>Please delay your payment until {{$event->submission.' '.$abst}} your abstract is accepted.<br><a style="text-decoration: underline" href="{{ url('/abstract/'.$event->slug) }}">Click to submit an abstract</a>@endif','{{ url('/payment/'.$event->slug) }}', 'Payment', '<a href="/event/{{ $event->slug }}/postpone">Remind Me Later</a>');
                    @else
                      confirmX('<strong>Dear Colleague</strong>,<br>You have successfully registered in this conference: <b>{{$event->title_en}}</b>, please confirm your registration as you should pay the required fees to be confirmed. <br/><br/> You can enter this promo code and enjoy our discount <b> {{ $promoCode["promo_code"]}} </b>. @if($event->submission != 1 && $abst == 1)<br><br><strong>For Authors</strong>,<br>Please delay your payment until {{$event->submission.' '.$abst}} your abstract is accepted.<br><a style="text-decoration: underline" href="{{ url('/abstract/'.$event->slug) }}">Click to submit an abstract</a>@endif','{{ url('/payment/'.$event->slug) }}', 'Payment', '<a href="/event/{{ $event->slug }}/postpone">Remind Me Later</a>');
               @endif
            @endif
        @endif
    @endif
    @endif
        });
</script>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkADnyDespyXXSSn282L2CbE57BaVbirg&callback="
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
    $(window).bind('load', function(){
        setTimeout(mapGeocoding());
    });
    </script>
@endpush

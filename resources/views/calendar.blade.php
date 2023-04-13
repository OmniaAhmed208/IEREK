@extends('layouts.master')
@push('styles')
<style type="text/css">
.none{ display:none;}
.dropdown{color: #444444;font-size:17px;}
#calender_section{ width:100%; margin:30px auto 0;}
#calender_section>div{ background-color:#efefef; color:#444444; font-size:17px; text-align:right; line-height:40px;}
#calender_section h2 a{ color:#F58220; float:none;}
#calender_section_top{ width:100%; float:left; margin-top:0px;background:#fff!important;}
#calender_section_top ul{padding:0; list-style-type:none;background:#fff;}
#calender_section_top ul li{ float:left; display:block; width:14.2857%; border-right:1px solid #fff;  text-align:center; font-size:14px; min-height:0; box-shadow:none; margin:0; padding:0;}
#calender_section_bot{ width:100%; margin-top:0px; float:left; border-left:1px solid #ccc; border-bottom:1px solid #ccc;}
#calender_section_bot ul{ margin:0; padding:0; list-style-type:none;}
#calender_section_bot ul li{ float:left; width:14.2857%; height:auto; text-align:center; border-top:1px solid #ccc; border-right:1px solid #ccc; min-height:0; background:none; box-shadow:none; margin:0; padding:0; position:relative;}
#calender_section_bot ul li span{ margin-top:7px; float:left; margin-left:7px; text-align:center;}

.grey{ background-color:#DDDDDD !important;}
.light_sky{ background-color:#B9FFFF !important;}

/*========== Hover Popup ===============*/
.date_cell { cursor: pointer; cursor: hand;}
.date_cell .empty {background-color: #fff !important; }
.date_cell:hover { background: #DDDDDD !important; }
.date_popup_wrap {
	position: absolute;
	width: 143px;
	height: 115px;
	z-index: 9999;
	top: -115px;
	left:-55px;
	background: transparent url(add-new-event.png) no-repeat top left;
	color: #666 !important;
}
.events_window {
	overflow: hidden;
	overflow-y: auto;
	width: 133px;
	height: 115px;
	margin-top: 28px;
	margin-left: 25px;
}
.event_wrap {
	margin-bottom: 10px; padding-bottom: 10px;
	border-bottom: solid 1px #E4E4E7;
	font-size: 12px;
	padding: 3px;
}
.date_window {
	margin-top:20px;
	margin-bottom: 2px;
	padding: 5px;
	font-size: 16px;
	margin-left:9px;
	margin-right:14px
}
.popup_event {
	margin-bottom: 2px;
	padding: 2px;
	font-size: 16px;
	width:100%;
}

.toshow{
	display: none;
}
.popup_event a {color: #000000 !important;}
.packeg_box a {color: #F58220;float: right;}
a:hover {color: #181919;text-decoration: underline;}
@media only screen and (min-width:480px) and (max-width:767px) {
#calender_section{}
#calender_section_top ul li{ }
#calender_section_bot ul li{ }
.tohide{
	display: none
}
.toshow{
	display: block;
}
}
@media only screen and (min-width: 320px) and (max-width: 479px) {
#calender_section{}
#calender_section_top ul li{ font-size:11px;}
#calender_section_bot ul li{ }
#calender_section_bot{}
#calender_section_bot ul li{}
.tohide{
	display: none
}
.toshow{
	display: block;
}
}

@media only screen and (min-width: 768px) and (max-width: 1023px) {
#calender_section{}
#calender_section_top ul li{ }
#calender_section_bot ul li{}
#calender_section_bot{ }
#calender_section_bot ul li{}
.tohide{
	display: none
}
.toshow{
	display: block;
}
}
</style>
@endpush
@section('content')    
    <div class="container">
        <figure class="cover-img">
            <img src="uploads/images/calendar.jpg">
        </figure>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Calendar</h3>
            </div>
            <div class="panel-body">
                <div class="framed-content">
					<div id="calendar_div">
						<div id="calender_section">
						<div class="col-md-12 toshow" style="text-align: left;">
							<div class="col-md-3">		
								<label class="label label-success">C</label> = Conference
							</div>
							<div class="col-md-3">	
								<label class="label label-warning">W</label> = Workshop
							</div>
							<div class="col-md-3">	
								<label class="label label-danger">S</label> = Study Abroad
							</div>
						
						</div>
							<?php
								$year = date('Y');
								$month = date('m');
							?>
							<div class="col-md-12">
					            <select name="month_dropdown" class="month_dropdown dropdown">
					            	<option value="01" @if($month == '01'){{'selected'}}@endif>January</option>
					            	<option value="02" @if($month == '02'){{'selected'}}@endif>February</option>
					            	<option value="03" @if($month == '03'){{'selected'}}@endif>March</option>
					            	<option value="04" @if($month == '04'){{'selected'}}@endif>April</option>
					            	<option value="05" @if($month == '05'){{'selected'}}@endif>May</option>
					            	<option value="06" @if($month == '06'){{'selected'}}@endif>June</option>
					            	<option value="07" @if($month == '07'){{'selected'}}@endif>July</option>
					            	<option value="08" @if($month == '08'){{'selected'}}@endif>August</option>
					            	<option value="09" @if($month == '09'){{'selected'}}@endif>September</option>
					            	<option value="10" @if($month == '10'){{'selected'}}@endif>October</option>
					            	<option value="11" @if($month == '11'){{'selected'}}@endif>November</option>
					            	<option value="12" @if($month == '12'){{'selected'}}@endif>December</option>
					            </select>
								<select name="year_dropdown" class="year_dropdown dropdown">
									@foreach($years as $y)
										<option value="{{$y}}" @if($year == $y){{'selected'}}@endif>{{$y}}</option>
									@endforeach
								</select>
					        </div>
							<div id="event_list" class="none"></div>
							<div id="calender_section_top">
								<ul>
									<li>Sun</li>
									<li>Mon</li>
									<li>Tue</li>
									<li>Wed</li>
									<li>Thu</li>
									<li>Fri</li>
									<li>Sat</li>
								</ul>
							</div>
							<div id="calender_section_bot">
								<ul id="target">
								<?php
								$dateYear = ($year != '')?$year:date("Y");
								$dateMonth = ($month != '')?$month:date("m");
								$date = $dateYear.'-'.$dateMonth.'-01';
								$currentMonthFirstDay = date("N",strtotime($date));
								$totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
								$totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
								$boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
									@$dayCount = 1;
									for(@$cb=1;@$cb<=@$boxDisplay;@$cb++){
										if((@$cb >= @$currentMonthFirstDay+1 || @$currentMonthFirstDay == 7) && @$cb <= (@$totalDaysOfMonthDisplay)){
											//Current date
											@$currentDate = @$dateYear.'-'.@$dateMonth.'-'.@$dayCount;
											@$eventNum = 0;
											@$eventTitle = '';
											@$eventSlug = '#';
											@$title = '';

											foreach ($events as $e) {
												if($e->start_date == $currentDate){
													$eventNum = 1;
													if($e->category_id == 1){
														$eventTitle = '<label class="label label-success">C<label class="tohide">onference</label></label>';
													}elseif($e->category_id == 2){
														$eventTitle = '<label class="label label-warning">W<label class="tohide">orkshop</label></label>';
													}elseif($e->category_id == 3){
														$eventTitle = '<label class="label label-danger">S<label class="tohide">tudy Abroad</label></label>';
													}
													$title = $e->title_en;
													$eventSlug = '/events/'.$e->slug;
												}
											}
											//Define date cell color
											if(strtotime(@$currentDate) == strtotime(date("Y-m-d"))){
												echo '<li date="'.@$currentDate.'" class="grey date_cell">';
											}elseif(@$eventNum > 0){
												echo '<li date="'.@$currentDate.'" class="light_sky date_cell">';
											}else{
												echo '<li date="'.@$currentDate.'" class="date_cell">';
											}
											//Date cell
											echo '<span>';
											echo @$dayCount;
											echo '</span>';
											
											//Hover event popup
											echo '<div>';
											echo '<a href="'.$eventSlug.'" title="'.$title.'"  data-placement="left" data-toggle="tooltip">'.$eventTitle.'</a>';
											echo '</div>';
											
											echo '</li>';
											@$dayCount++;
								?>
								<?php }else{ ?>
									<li class="date_cell empty"><span>&nbsp;</span></li>
								<?php } } ?>
								</ul>
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
		function getCalendar(target_div,year,month){
			$.ajax({
				type:'GET',
				url:'/getCalendar/'+year+'/'+month,
				success:function(html){
					$('#'+target_div).html(html);
					dHx = $('#target').width();
					$('.date_cell').each(function(){
						$(this).height(dHx/7);
					});
					$('[data-toggle="tooltip"]').tooltip(); 
				}
			});
		}
		
		function getEvents(date){
			$.ajax({
				type:'POST',
				url:'functions.php',
				data:'func=getEvents&date='+date,
				success:function(html){
					$('#event_list').html(html);
					$('#event_add').slideUp('slow');
					$('#event_list').slideDown('slow');
				}
			});
		}
		
		$(window).on('resize', function(){
			dHx = $('#target').width();
			$('.date_cell').each(function(){
				$(this).height(dHx/7);
			});
		});

		var dHx = $('#target').width();
		$(document).ready(function(){
			$('.date_cell').mouseenter(function(){
				date = $(this).attr('date');
				$(".date_popup_wrap").fadeOut();
				$("#date_popup_"+date).fadeIn();	
			});
			$('.date_cell').mouseleave(function(){
				$(".date_popup_wrap").fadeOut();		
			});
			$('.month_dropdown').on('change',function(){
				getCalendar('target',$('.year_dropdown').val(),$('.month_dropdown').val());
			});
			$('.year_dropdown').on('change',function(){
				getCalendar('target',$('.year_dropdown').val(),$('.month_dropdown').val());
			});
			$(document).click(function(){
				$('#event_list').slideUp('slow');
			});
			// $('#calender_section').height(dHx);
			$('.date_cell').each(function(){
				$(this).height(dHx/7);
			});
			$('[data-toggle="tooltip"]').tooltip(); 
		});
	</script>
@endpush
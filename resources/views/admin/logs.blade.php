@extends('admin.layouts.master')
@section('return-url'){{url('/admin')}}@endsection
@section('panel-title') System Logs @endsection
@section('content')
<style type="text/css">
	#logs{
		background: #333;
		padding: 1em;
		height: 70vh;
		width: 100%;
		overflow-y: auto;
		overflow-x: hidden;
		font-family: "Courier New", Courier, monospace;
		font-size: 16px;
		color: #fff;
	}
	.log{
		padding: 0.5em;
		padding-bottom: 0;
		border: 1px #999 solid;
		margin-bottom: 10px;
	}
	#bg-color{
		padding: 0;
		border: 0;
	}
	pre{
		color: #fff;
		font-family: "Courier New", Courier, monospace;
		font-size: 16px;
		background: rgba(255,255,255,0.1);
		color: #e7e7e7;
		overflow-x: hidden;
		border-radius: 0px;
		border: #666 1px dashed;
		max-height: 150px!important;
		overflow: hidden!important;
	}
	.toxp{
		color: #fff;
		font-family: "Courier New", Courier, monospace;
		font-size: 16px;
		background: rgba(255,255,255,0.1);
		color: #e7e7e7;
		padding: 0.4em;
		margin-bottom: 0.5em;
		border-radius: 0px;
		border: #666 1px dashed;
		max-height: 150px;
		overflow: hidden;
	}
	.expand{
		float: right;
		color: #f9f9f9;
		cursor: pointer;
	}
	.expand:hover{
		color: gold;
		font-weight: 700;
	}

	.full{
		text-align: right;
		color: #333;
		cursor: pointer;
	}
	.full.ful{
		color: #fff;
	}
	.full:hover{
		color: #111;
		font-weight: 700;
	}
	.full.ful:hover{
		color: gold;
	}
	.fullHeight{
		height: auto;
		max-height: 100%;
	}
	.full-screen{
		height: 100vh!important;
		width: 100vw!important;
		z-index: 10000!important;
		position: fixed;
		top: 0;
		left: 0;
		padding-top: 75px!important;
	}
	.top-bar{
		height: 75px!important;
		width: 100vw!important;
		z-index: 10001!important;
		position: fixed;
		top: 0;
		left: 0;
		padding: 0.5em;
		background: rgba(0,0,0,0.7);
	}
	.exit{
		display: none;
	}
	hr{
		border: transparent 1px solid;
		box-shadow: 0 0 35px 0 rgba(0,0,0,0.5);
	}
</style>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div id="top-bar">

				<div class="row" style="padding-bottom: 5px!important">
					<div class="col-md-3">
						<div class="form-group">
							<label class="col-md-3">Type</label>
							<div class="col-md-9">
								<select class="form-control select" onchange="filterLogs();" name="category" id="cat">
									<option value="all" selected>All</option>
									@foreach($cats as $cat)
										<?php $caty = str_replace('_', ' ', $cat->type); $caty = str_replace('-', ' ', $caty); ?>
										<option value="{{$cat->type}}">{{ ucwords($caty) }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="col-md-3">Date</label>
							<div class="col-md-9">
								<select class="form-control select" onchange="filterLogs();" name="daterange" id="datarange">
									<option value="0">All</option>
									<option value="-1">Yesterday</option>
									<option value="1">Today</option>
									<option value="2">This Week</option>
									<option value="3">This Month</option>
									<option value="4">Custome Range</option>
								</select>
							</div>
							<div class="clearfix"></div>
							<script type="text/javascript">
								$(document).ready(function(){
									$('#datarange').val(1);
									$('input[name=dfrom]').datepicker('setDate','{{ date('Y-m-d') }}');
									$('input[name=dto]').datepicker('setDate','{{ date('Y-m-d', strtotime( date('Y-m-d') . '+1 day') ) }}');
									$('#datarange').on('change', function(){
										var val = $(this).val();
										if(val == 4)
										{
											$('.c_dates').each(function(){
												$(this).removeClass('hidden');
											});
											$('input[name=dfrom]').datepicker('setDate','{{ date('Y-m-d') }}');
											$('input[name=dto]').datepicker('setDate','{{ date('Y-m-d', strtotime( date('Y-m-d') . '+1 day') ) }}');
											
										}
										else
										{
											$('.c_dates').each(function(){
												$(this).addClass('hidden');
											});
										}

										if(val == 0)
										{
											$('input[name=dfrom]').datepicker('setDate','1970-01-01');
											$('input[name=dto]').datepicker('setDate','{{ date('Y-m-d', strtotime( date('Y-m-d') . '+1 day') ) }}');
										}

										if(val == -1)
										{
											$('input[name=dfrom]').datepicker('setDate','{{ date('Y-m-d', strtotime( date('Y-m-d') . '-1 day') ) }}');
											$('input[name=dto]').datepicker('setDate','{{ date('Y-m-d', strtotime( date('Y-m-d') . '-1 day') ) }}');
										}

										if(val == 1)
										{
											$('input[name=dfrom]').datepicker('setDate','{{ date('Y-m-d') }}');
											$('input[name=dto]').datepicker('setDate','{{ date('Y-m-d', strtotime( date('Y-m-d') . '+1 day') ) }}');
											
										}

										if(val == 2)
										{
											$('input[name=dfrom]').datepicker('setDate','{{ date('Y-m-d', strtotime('-1 week +1 day') ) }}');
											$('input[name=dto]').datepicker('setDate','{{ date('Y-m-d') }}');
											
										}

										if(val == 3)
										{
											$('input[name=dfrom]').datepicker('setDate','{{ date('Y-m-01') }}');
											$('input[name=dto]').datepicker('setDate','{{ date('Y-m-01', strtotime( date('Y-m-01') . '+1 months') ) }}');
											
										}
									});
								});
							</script>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group c_dates hidden">
							<label class="col-md-3">From</label>
							<div class="col-md-9">
								<input type="text" onchange="filterLogs();" name="dfrom" id="dfrom" value="1970-01-01" class="form-control datepicker" id="datepicker1">
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="col-md-3">
						<div class="form-group c_dates hidden">
							<label class="col-md-3">To</label>
							<div class="col-md-9">
								<input type="text" onchange="filterLogs();" name="dto" id="dto" value="{{ date('Y-m-d', strtotime( date('Y-m-d') . '+1 day') ) }}" class="form-control datepicker" id="datepicker2">
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="row" style="padding-bottom: 5px!important">
					<div class="col-md-2">
						<div class="form-group">
							<label class="col-md-3">Color</label>
							<div class="col-md-9">
								<input type="color" class="form-control" id="bg-color" value="#111111">
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="col-md-3">Font</label>
							<div class="col-md-9">
								<input type="number" class="form-control" min="6" max="44" id="font" value="16">
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
                            <div class="col-md-12">
                            	<label class="check"><input type="checkbox" id="autos" class="icheckbox" name="autos" value="1" checked />Enable Auto Scroll</label>
                            </div>
                        </div>
                    </div>
					<div class="col-md-2">
						<div class="form-group">
							<labeL class="btn btn-info btn-block" style="cursor:pointer" onclick="printDiv()"><i class="fa fa-print"></i> Print</labeL>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<span class="full pull-right" id="full-s">[<b class="exit" id="exit">Exit</b> Full Screen] </span>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div id="logs">
				
			</div>
        </div>
    </div>
</div>
<script type="text/javascript">
var tLast = 0;
var last = 0;
var scrollDown = function() {
	if($('#autos').is(':checked')){
		$("#logs").animate({ scrollTop: $('#logs').prop("scrollHeight")}, 400);
	}
}
var getLogs = function() {
	var cat = document.getElementById('cat').value;
	var dfrom = document.getElementById('dfrom').value + ' 00:00:00';
	var dto = document.getElementById('dto').value + ' 23:59:59';
	var target = document.getElementById('logs');
    $.ajax({
        type: 'GET',
        url: '/admin/get/logs',
        data: 'from='+dfrom+'&to='+dto+'&category='+cat,
        dataType: 'json',
        beforeSend: function() {
        	if(tLast == 0 && last == 0){
        		$(target).html('<center><img src="/loading-g.gif"> Loading System Logs...</center>');
        	}
        },
        success: function(response) {
            if(response.success == true)
            {
                var resultx = response.result;
                var countTot = resultx.length;
                var html = '';
                for (i = 0; i < countTot; i++) {
                	try {
					    json = JSON.parse(resultx[i]['description']);
                        json = JSON.stringify(json);
                        json = json.replace(/<:/g, '</td></tr><tr><td><span>');
                        json = json.replace(/:>/g, '</span>');
                        json = json.replace(/{/g, '');
                        json = json.replace(/}/g, '');
                        json = json.replace(/,/g, '');
                        json = json.replace(/"/g, '');
                        json = json.replace(/:/g, '');
                        json = json.replace(/&&/g, '<td style="background:rgba(0,255,0,0.05)">');
                        json = json.replace(/##/g, '</td><td style="background:rgba(255,0,0,0.05)">');
                        json = '<table class="table table-bordered"><tbody><tr><td>Value</td><td><span style="color:green">New</span></td><td><span style="color:red">Old</span></td></tr></tbody><tbody>'+json+'</tbody></table>'
					} catch (e) {
					    json = resultx[i]['description'];
					}
                    var sGet = '<div class="log" style="color:'+resultx[i]['color']+'">'+
									'<pre><i class="fa fa-'+resultx[i]['icon']+'" style="color:'+resultx[i]['color']+'"></i> <span style="color:#e1e1e1">'+resultx[i]['created_at']+'</span> <time id="time'+i+'" style="color:#999" class="timeago" datetime="'+resultx[i]['created_at']+'"></time></pre> <pre><span style="color:'+resultx[i]['color']+'">'+resultx[i]['title']+'</span></pre>'
									+'<div class="toxp" id="toExpand'+i+'">'+json+'</div>'+'<span class="expand" onclick="expandThis('+i+',this)">[+]</span>'+
								'</div><hr>';
                    html = html + sGet;
                    last = resultx[i]['created_at'];
                }
                if(last != tLast){
                	$(target).html(html);
                	tLast = last;
                	scrollDown();
                }
                $(".timeago").timeago();
            }else{
            	$(target).html('<center><br><br><br>No logs for type: '+cat+' were found.</center>');
            }
            $(target).css('background',$('#bg-color').val());
        },
        error: function(response) {
            $(target).css('background',$('#bg-color').val());
        }
    });
}
var filtering = 0;
function filterLogs(){
	if(filtering == 0){
		filtering = 1;
		setTimeout(function(){tLast = 0; last = 0; getLogs(); filtering = 0;}, 1000)
	}
};
$(document).ready(function(){
    getLogs();
	setInterval(getLogs, 4000);

    $('#bg-color').on('change', function(){
    	$('#logs').css('background',$(this).val());
    });
    $('#font').on('keyup', function(){
    	$('pre').css('font-size',$(this).val()+'px');
    	if($(this).val() < 6){
    		$('pre').css('font-size','6px');
    		$(this).val(6);
    	}
    	if($(this).val() > 44){
    		$('pre').css('font-size','44px');
    		$(this).val(44);
    	}
    });
    $('.expand').on('click', function(){
    	$(this).toggleClass('fullHeight');
    });

    $('#full-s').on('click', function(){
    	$(this).toggleClass('ful');
    	$('#logs').toggleClass('full-screen');
    	$('#exit').toggleClass('exit');
    	$('#top-bar').toggleClass('top-bar');
    });
});

function expandThis(id, toggler)
{
	var inr = $(toggler).html();
	if(inr == '[+]'){
		$(toggler).html('[-]');
		$('#toExpand'+id).addClass('fullHeight');
	}else{
		$(toggler).html('[+]');
		$('#toExpand'+id).removeClass('fullHeight');
	}
}

function printDiv() 
{

  var divToPrint=document.getElementById('logs');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><title>IEREK Logs Print</title><link rel="icon" href="favicon.ico" type="image/x-icon" /><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
</script>
@endsection
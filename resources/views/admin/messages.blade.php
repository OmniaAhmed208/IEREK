@extends('admin.layouts.master')
@section('return-url'){{url('/admin')}}@endsection
@section('panel-title') Messages @endsection
@section('content')
<style type="text/css">
	.msgs-list{
		list-style: none;
		padding: 0;
		margin: 0;
	}
	#message-body.body-head{
		display: none;
	}
	.msgs-list li{
		margin: 0;
		padding: 0.75em;
		min-height: 60px;
		border-bottom: 1px solid #f1f1f1;
		cursor: pointer;
		border-left: 3px #e9e9e9 solid;
	}
	.msgs-list li.active{
		background: #f1f1f1;
		border-left: 3px #e7e7e7 solid;
	}
	.msgs-list li.active:hover{
		background: #f1f1f1;
		border-left: 3px #e7e7e7 solid;
		cursor: default;
	}
	.msgs-list li.unread{
		font-weight: 700;
	}
	.msgs-list li:hover{
		background: #f9f9f9;
		border-left: 3px #a97f18 solid;
	}
</style>
<div class="container">
	<div class="panel panel-default" id="view-profile">
		<div class="panel-body" style="background:#f9f9f9">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-4">
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title">Inbox</h3>
								<a href="#" class="btn btn-danger pull-right" onclick="compose();"><i class="fa fa-edit"></i> Compose</a>
							</div>
							<div class="panel-body" style="padding:0;margin:0;max-height:400px;overflow:hidden;overflow-y: auto;">
								<div class="row" style="padding:0;margin:0">
									<ul class="msgs-list">
										@if(isset($msg))
											<li id="li-msg{{$msg->message_id}}" data-title="{{$msg->title}}" data-md="li-msg{{$msg->message_id}}" class="active aMsg" onclick="getMessage({{$msg->message_id}})">
												<a href="#message" style="display:inline-block;">@if($msg->piority == 1) <i style="color:red" class="fa fa-info"></i> @else <i style="color:gold;font-size:8px" class="fa fa-circle"></i> @endif {{$msg->title}}</a><br><small style="font-weight: 300!important;color:#777">From: {{$msg->sender['first_name']}} ({{$msg->sender['email']}})</small><br>
												<small class="pull-right" style="display:inline-block">{{date('jS F, Y h:i A' ,strtotime($msg->created_at))}}</small>
											</li>
											<?php $msgId = $msg->message_id; ?>
										@else
											<?php $msgId = null ; ?>
										@endif
										@foreach($messages as $message)
											@if($message->message_id != $msgId)
												<li id="li-msg{{$message->message_id}}" data-title="{{$message->title}}" data-md="li-msg{{$message->message_id}}" class="aMsg @if($message->read == 0) unread @endif" onclick="getMessage({{$message->message_id}})">
													<a href="#message" style="display:inline-block;">@if($message->piority == 1) <i style="color:red" class="fa fa-info"></i> @else <i style="color:gold;font-size:8px" class="fa fa-circle"></i> @endif {{$message->title}}</a><br><small style="font-weight: 300!important;color:#777">From: {{$message->sender['first_name']}} ({{$message->sender['email']}})</small><br>
													<small class="pull-right" style="display:inline-block">{{date('jS F, Y h:i A' ,strtotime($message->created_at))}}</small>
												</li>
											@endif
										@endforeach
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-8" id="message">
						<div class="panel">
							<div class="panel-body" id="message-body" style="max-height:auto;overflow:hidden;">
							@if(isset($msg))
							<?php echo $title; ?><p style="white-space: pre-wrap; padding:0em 1em;font-size: 16px"><?php echo $msg->body; ?></p>
							<div class="panel-footer" id="delArea"><a class="btn btn-danger" id="delBtn" onclick="deleteMsg();">Delete</a></div>
							@else
								<br><br><br>
								<center><h1 style="color:#f1f1f1;font-size:50px!imoortant">IEREK</h1></center>
								<br><br><br>
							@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script>
var iix = 0;
	function compose(){

		var form = '<form name="compose'+iix+'" id="compose'+iix+'"><div class="form-group"><center><h2>Compose Message</h2></center><input type="text" name="to" class="form-control" id="to'+iix+'" placeholder="To: use [,] to separate emails"></div><div class="form-group"><input type="text" name="subject" id="subject'+iix+'" class="form-control" placeholder="Subject"></div><div class="form-group"><textarea name="message" id="message'+iix+'"></textarea></div><div class="form-group"><label class="check" style="color:red"><input type="checkbox" value="1" id="msg_only'+iix+'" checked name="msg_only"> Message only, do not send email/s.</label></div></from>';

		functionX(form, 'sendMsg('+iix+')', 'Send', 'Close');

		tinymce.init({
			selector: 'textarea',
			height: 300,
			plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste code'
			],
			toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			content_css: [
				
				'//www.tinymce.com/css/codepen.min.css'
			]
		});

		iix++;
	}
	function urldecode(url) {
	  return decodeURIComponent(url.replace(/\+/g, ' '));
	}
	function composeTo(to,title,body){

		var form = '<form name="compose'+iix+'" id="compose'+iix+'"><div class="form-group"><center><h2>Compose Message</h2></center><input type="text" name="to" class="form-control" id="to'+iix+'" placeholder="To: use [,] to separate emails" value="'+urldecode(to)+'"></div><div class="form-group"><input type="text" name="subject" id="subject'+iix+'"  value="RE: '+urldecode(title)+'" class="form-control" placeholder="Subject"></div><div class="form-group"><textarea name="message" id="message'+iix+'"><br>'+urldecode(body)+'</textarea></div><div class="form-group"><label class="check" style="color:red"><input type="checkbox" value="1" id="msg_only'+iix+'" checked name="msg_only"> Message only, do not send email/s.</label></div></from>';

		functionX(form, 'sendMsg('+iix+')', 'Send', 'Close');

		tinymce.init({
			selector: 'textarea',
			height: 300,
			plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste code'
			],
			toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			content_css: [
				
				'//www.tinymce.com/css/codepen.min.css'
			]
		});

		iix++;
	}

	function sendMsg(id){
		var to = document.getElementById('to'+id).value;
		var subject = document.getElementById('subject'+id).value;
		var message = tinymce.get('message'+id).getContent(); //document.getElementById('message'+id).value;
		var msgOnly = document.getElementById('msg_only'+id);
		var msg_only = msgOnly.checked ? msgOnly.value : '';
		var formData = 'to='+to+'&subject='+subject+'&message='+message+'&msg_only='+msg_only;
		$.ajax({
			type: 'GET',
			url: '/admin/message/compose',
			data: formData,
	        dataType: 'json',
			beforeSend: function(){

			},
			success: function(response){
				var success = response.sent;
				if(success == true){
					returnN('Message Sent Successfully.!','green',5000);
				}else{
					alertX(response.result);
				}
			},
			error: function(response){

			}
		});
	}

		var curMsg;
		@if(isset($msg))
			curMsg = 'li-msg'+{{$msg->message_id}} ;
		@endif
		var curTitle;
		var gettingMsg = 0;
		function getMessage(id)
		{
	        var target = document.getElementById('message-body');
	        if(gettingMsg == 0){
				$.ajax({
		            type: 'GET',
		            url: '/admin/messages/body/'+id,
		            dataType: 'json',
		            timeOut: 10000,
		            beforeSend: function() {
		            	$(target).html('<br><br><br><br><center><img src="/loading.gif"></center><br><br><br><br>');
		            	$('#delArea').remove();
		            	gettingMsg = 1;
		            },
		            success: function(response) {
		                if(response.success == true)
		                {
		                    var html = response.result;
		                    if(html != '')
		                    {
		                        $(target).html(html);
		            			$('#message-body').parent('div.panel').append('<div class="panel-footer" id="delArea"><a class="btn btn-danger" id="delBtn" onclick="deleteMsg();">Delete</a></div>');
		            			gettingMsg = 0;
		            			$(".niceScroll").mCustomScrollbar();
		                    }
		                }
		            },
		            error: function(response) {
		            	informX('Your session was ended, please refresh the page.')
		            }
		        });
		    }else{
		    	informX('Be patient please, I am working to bring your message =)');
		    }
		}

		$(document).ready(function(){
			$('.aMsg').each(function(){
				$(this).on('click', function(){
					$('.aMsg').each(function(){
						$(this).removeClass('active');
					});
					curMsg = $(this).data('md');
					curTitle = $(this).data('title');
					$(this).addClass('active');
					$(this).removeClass('unread');
				});
			});
		});

		function deleteMsg()
		{
			
			var target = document.getElementById('message-body');
			var id = curMsg.replace( /^\D+/g, '');
			$.ajax({
	            type: 'GET',
	            url: '/messages/delete/'+id,
	            dataType: 'json',
	            timeOut: 10000,
	            beforeSend: function() {
	            	$(target).html('<br><br><br><br><center><img src="/loading.gif"></center><br><br><br><br>');
	            },
	            success: function(response) {
	                if(response.success == true)
	                {
	                	$(target).html('<br><br><br><br><center><p style="color:#f1f1f1;font-size:50px!important">IEREK</p></center><br><br><br><br>');
	                    $('#delArea').fadeOut(400, function(){$('#delArea').remove()});
						$('#'+curMsg).slideUp(400, function(){$('#'+curMsg).remove()});
						returnN('<i class="fa fa-trash"></i><small style="font-family: Tahoma!important"> Message deleted successfully.</small>', '#666', 20000);


	                }
	            },
	            error: function(response) {
	            	informX('Your session was ended, please refresh the page.')
	            }
	        });

		}
	</script>
@endpush
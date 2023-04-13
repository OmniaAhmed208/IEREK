@extends('admin.layouts.master')
@section('panel-title') Export Study Abroad Attendance <small>{{$event->title_en}}</small>@endsection
@section('return-url'){{'/admin/events/studyabroad/attendance/'.$event->event_id}}@endsection
@section('content')
	<div class="row">
		<div class="panel">
			<div class="col-md-12 row">
				<div class="panel-heading">
					<h3 class="panel-title">Export Attendances</h3>
					<div class="pull-right">
						<button class="btn btn-danger toggle" data-toggle="exportTable">Export Data</button>
					</div>
				</div>
				<div class="panel-body" id="exportTable" style="display: none;">
					<div class="row">
						<div class="col-md-12">
							<div class="list-group border-bottom">
								<a href="#" class="list-group-item" onClick ="$('#customers').tableExport({type:'excel',escape:'false'});"><img src='{{ asset('img/icons/xls.png') }}' width="24"/> XLS</a>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table id="customers" class="table datatable">
						<thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Tel</th>
                                <th>Nationality</th>
                                <th>Type</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if(isset($attendances))
                                    @foreach($attendances as $attendance)
                                        <tr id="event{{ $attendance->event_attendace_id }}" class="inactive">
                                            <td>
                                            <?php
                                                if($attendance['users']->gender == 1 OR $attendance['users']->gender == 0){ $gender = 'male'; }elseif($attendance['users']->gender == 2){ $gender = 'female'; }
                                            ?>
                                            <img src="@if($attendance['users']->image == '') /uploads/default_avatar_{{ $gender }}.jpg @else /storage/uploads/users/profile/{{ $attendance['users']->image }}.jpg @endif" style="max-width:35px;border:1px #a97f18 solid;box-shadow: 0 2px 14px 0 rgba(0,0,0,0.1)">&ensp;{{ $attendance['users']->first_name.' '.$attendance['users']->last_name }}</td>
                                            <td>
                                                {{ $attendance['users']->email }}
                                            </td>
                                            <td>
                                                {{ str_replace('+', '00 ', $attendance['users']->phone) }}
                                            </td>
                                            <td>
                                                @if($attendance['users']->countries['name'] == 'HOST' OR $attendance['users']->countries['name'] == NULL) {{ 'N/A' }} @else {{ $attendance['users']->countries['name'] }} @endif
                                            </td>
                                            <td><?php $types = [1 => 'Audience', 2 => 'Co-Author', 3 => 'Author']; ?>
                                                {{$types[$attendance->event_attendance_type_id]}}
                                            </td>
                                            <td>{{ $attendance->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    {{ "There is no attendances for this study abroad's filter" }}
                                @endif
                        </tbody>
					</table>
				</div>
				<div class="panel-footer">

				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel">
			<div class="col-md-12 row">
				<div class="panel-heading">
					<h3 class="panel-title">Send Message</h3>
				</div>
				<div class="panel-body">
					<style type="text/css">
					h3{
						color:#fff;
					}
					</style>
					<form method="POST" id="send_form" action="{{url('message/send')}}">
							<h3>Sending A Message To: {{ $type }}</h3>
					        <div class="form-group panel">
					            <label class="col-md-3 col-xs-12 control-label">Options</label>
					            <div class="col-md-6 col-xs-12" id="checks">         
					                <label class="check col-md-4"><input type="checkbox" class="icheckbox" id="message-c" name="message" value="1" /> Message</label>
					                <label class="check col-md-4"><input type="checkbox" class="icheckbox" name="notification" value="1" /> Notification</label>
					                <label class="check col-md-4"><input type="checkbox" class="icheckbox" name="email" value="1" /> Email</label>
					                <label class="check col-md-4"><input type="checkbox" class="icheckbox" name="piority" value="1" /> High Piority</label>
					            </div>
					        </div>
					        <input type="hidden" name="_token" value="{{ csrf_token() }}">
					        @if(isset($attendances))
								@foreach($attendances as $attendance)
					        	<input type="hidden" name="users[]" value="{{ $attendance['users']->user_id }}">
					        	@endforeach
					        @endif
					        <input type="hidden" name="type" value="{{ $type }}">
					        <input type="hidden" name="event_email" value="{{ $event->email }}">
							<div class="form-group">
								<input class="form-control" type="text" name="title" value="" placeholder="Message Title">
							</div>
							<div class="form-group">
								<textarea class="form-control" rows="10" name="body">Dear %first_name%,

This email is regarding {{$event->title_en}}

Best Regards,
IEREK Team.
								</textarea>
							</div>
							<div class="form-group">
								<input type="submit" id="send" name="Send" class="btn btn-success">&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('js/admin/plugins/tableexport/tableExport.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/tableexport/jquery.base64.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/tableexport/html2canvas.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/tableexport/jspdf/libs/sprintf.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/tableexport/jspdf/jspdf.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/plugins/tableexport/jspdf/libs/base64.js') }}"></script>
	<script type="text/javascript">
	// 
    var checked = false;
	$('#send').on('click', function(event) {
        event.preventDefault();
	    if(checked == true)
	    {
	        var err = document.getElementsByClassName('error');
	        $(err).hide(500);
	        $.ajaxSetup({
	        headers: {
	        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
	        }
	        })
	        var myForm = document.getElementById('send_form');
	        var formData = new FormData(myForm);
	        $.ajax({

	        type: 'POST',
	        url: '{{ url("admin/message/send_group") }}',
	        data: formData,
	        dataType: 'json',
	        cache: false,
	        contentType: false,
	        processData: false,
	            beforeSend: function(xhr) {
	                $('#loading').delay(350).fadeIn(200);
	            },
	            success: function (response) {
	                //check if response with success : true/false
	                informX('Message Sent');
	                $('#loading').fadeOut(200);
	            	function ter()
	            	{
	            		$('#send').fadeIn();
	            	}
	            	$('#send').fadeOut();
	            	setTimeout(ter, 10000);
	            },
	            error: function (response) {
	                          
	            }
	        });
	    }else{
	    	informX('Please choose 1 sending option at least');
	    }
    });

    $(document).ready(function(){
    	$('.check').on('click', function(){
    		isChecked();
    	});
    	$('ins').on('click', function(){
    		isChecked();
    	});
    });
    function isChecked()
    {
    	var count = 0;
    	$('input[type="checkbox"]:checked').each(function(){
    		count++;
    	});
    	if(count >= 1)
    	{
    		checked = true;
    	}
    	else
    	{
    		checked = false;
    	}
    }
	</script>
@endpush
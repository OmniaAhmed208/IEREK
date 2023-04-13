@extends('admin.layouts.window')

@section('content')
<style type="text/css">
h3{
	color:#fff;
}
</style>
<form method="POST" id="send_form" action="{{url('message/send')}}">
	<div class="container" style="padding-bottom:1em;">
		<h3>Sending A Message To: {{$user->email}}</h3>
        <div class="form-group panel">
            <label class="col-md-3 col-xs-12 control-label">Options</label>
            <div class="col-md-6 col-xs-12">         
                <label class="check col-md-4"><input type="checkbox" class="icheckbox" id="message-c" name="message" value="1" /> Message</label>
                <label class="check col-md-4"><input type="checkbox" class="icheckbox" name="notification" value="1" /> Notification</label>
                <label class="check col-md-4"><input type="checkbox" class="icheckbox" name="email" value="1" /> Email</label>
                <label class="check col-md-4"><input type="checkbox" class="icheckbox" name="piority" value="1" /> High Piority</label>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ $user->user_id }}">
        <input type="hidden" name="event_email" value="{{ $event->email }}">
		<div class="form-group">
			<input class="form-control" type="text" name="title" value="" placeholder="Message Title">
		</div>
		<div class="form-group">
			<textarea class="form-control" rows="10" name="body">Dear {{$user->first_name}},

This email is regarding @if($event->category_id == 1) {{'conference'}} @endif {{$event->title_en}}

Best Regards,
IEREK Team.
			</textarea>
		</div>
		<div class="form-group">
			<input type="submit" id="send" name="Send" class="btn btn-success">&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
		</div>
	</div>
</form>
@endsection
@push('scripts')
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
	        url: '{{ url("admin/message/send") }}',
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
	            		window.close();
	            	}
	            	$('#send').fadeOut();
	            	setTimeout(ter, 1000);
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
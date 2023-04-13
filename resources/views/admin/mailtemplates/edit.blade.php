@extends('admin.layouts.master')
@section('return-url'){{url('admin/mail')}}@endsection
@section('panel-title')Manage Mail <small>{{ @$template->title }}</small>
@endsection
@section('content')
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" method="post" id="update_form">
            {{ csrf_field() }}
            <input type="hidden" name="mail_id" value="{{$template->mail_id}}">
				<div class="panel panel-default">                            
                    <div class="panel-body">
						<div class="row">
							<div class="col-md-8 col-offset-md-2">
								<div class="form-group">
									<label class="col-md-3 control-label">Status</label>
									<div class="col-md-9">
										<label class="radio-inline"><input type="radio" name="inactive" @if($template->inactive == 0) checked @endif value="0"> <span class="label label-success">Active</span> </label>
										<label class="radio-inline"><input type="radio" name="inactive" @if($template->inactive == 1) checked @endif value="1"> <span class="label label-danger">Inactive</span></label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Subject</label>
									<div class="col-md-9">
										<input type="text" name="title" class="form-control" value="{{ $template->title }}" placeholder="Email Title">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Send Blind Copy To</label>
									<div class="col-md-9">
										<input type="text" name="bcc_mails" class="form-control" value="{{ $template->bcc_mails }}" placeholder="Enter Email">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">CC</label>
									<div class="col-md-9">
										<input type="text" name="cc_mails" class="form-control" value="{{ $template->cc_mails }}" placeholder="Enter Email">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Text (No HTML)</label>
									<div class="col-md-9">
										<textarea name="message" rows="10" class="form-control">{{$template->message}}</textarea>
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label class="col-md-3 control-label">Admin Subject</label>
									<div class="col-md-9">
										<input type="text" name="admin_title" class="form-control" value="{{ $template->admin_title }}" placeholder="Admin Email Title">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Admin Copy Email</label>
									<div class="col-md-9">
										<input type="text" name="admin_email" class="form-control" value="{{ $template->admin_email }}" placeholder="Enter Email">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Admin Text (No HTML)</label>
									<div class="col-md-9">
										<textarea name="admin_message" rows="10" class="form-control">{{$template->admin_message}}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"></label>
									<div class="col-md-9">
				                        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
				                            <span><strong id="welcome">Mail Template updated successfuly!</strong> </span>
				                        </div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<a class="btn btn-success pull-right" id="update">Update</a>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h3>Template Variables</h3>
								<div class="col-md-4">
									<table class="table">
									<caption><b>User Variables</b></caption>
										<thead>
											<tr>
												<th>Variable</th>
												<th>Description</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>%first_name%</td>
												<td>First name</td>
											</tr>
											<tr>
												<td>%last_name%</td>
												<td>Last name</td>
											</tr>
											<tr>
												<td>%email%</td>
												<td>User Email</td>
											</tr>
											<tr>
												<td>%phone%</td>
												<td>User Phone</td>
											</tr>
										</tbody>
									</table>
									<table class="table">
									<caption><b>Submission Variables</b></caption>
										<thead>
											<tr>
												<th>Variable</th>
												<th>Description</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>%abstract_title%</td>
												<td>Abstract Title</td>
											</tr>
											<tr>
												<td>%abstract_conference%</td>
												<td>Abstract Conference</td>
											</tr>
											<tr>
												<td>%paper_title%</td>
												<td>Paper Title</td>
											</tr>
											<tr>
												<td>%paper_conference%</td>
												<td>Paper Conference</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-4">
									<table class="table">
									<caption><b>Event Variables</b></caption>
										<thead>
											<tr>
												<th>Variable</th>
												<th>Description</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>%event_title%</td>
												<td>Event title</td>
											</tr>
											<tr>
												<td>%event_url%</td>
												<td>Event Button URL</td>
											</tr>
											<tr>
												<td>%payment_url%</td>
												<td>Payment Button URL</td>
											</tr>
											<tr>
												<td>%submit_url%</td>
												<td>Submit Abstract Button URL</td>
											</tr>
											<tr>
												<td>%event_start%</td>
												<td>Event start date</td>
											</tr>
											<tr>
												<td>%event_end%</td>
												<td>Event end date</td>
											</tr>
											<tr>
												<td>%payment_deadline%</td>
												<td>Late Payment Deadline</td>
											</tr>
											<tr>
												<td>%abstract_deadline%</td>
												<td>Abstract Submissions Deadline</td>
											</tr>
											<tr>
												<td>%paper_deadline%</td>
												<td>Full Paper Submission Deadline</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-4">
									<table class="table">
										<caption><b>General Variables</b></caption>
										<thead>
											<tr>
												<th>Variable</th>
												<th>Description</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>%payment_total%</td>
												<td>Total Payment Amount</td>
											</tr>
											<tr>
												<td>%payment_id%</td>
												<td>Payment ID</td>
											</tr>
											<tr>
												<td>%creation_date%</td>
												<td>Created At</td>
											</tr>
											<tr>
												<td>%creation_date%</td>
												<td>Created At</td>
											</tr>
											<tr>
												<td>%abstract_title%</td>
												<td>Abstract Title</td>
											</tr>
											<tr>
												<td>%conferences_url%</td>
												<td>Conferences Category Link</td>
											</tr>
											<tr>
												<td>%workshops_url%</td>
												<td>Workshops Category Link</td>
											</tr>
											<tr>
												<td>%study_abroad_url%</td>
												<td>Study Abroad Category Link</td>
											</tr>
											<tr>
												<td>%hr%</td>
												<td>Insert Horizontal Line</td>
											</tr>
											<tr>
												<td>%br%</td>
												<td>New Line</td>
											</tr>
											<tr>
												<td>%center% Text %/center%</td>
												<td>Replace [Text] with your centered text</td>
											</tr>
											<tr>
												<td>%h1% Text %/h1%</td>
												<td>Head Line 1 (Replace [Text] with your text and [1] with (1~6) for all sizes)</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
                    </div>
                </div>      
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" charset="utf-8" async defer>
$(document).ready( function() {
    $('#update').on('click', function(event) {
        event.preventDefault();
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
        })
        var myForm = document.getElementById('update_form');
        var formData = new FormData(myForm);
        $.ajax({

        type: 'POST',
        url: '/admin/mail',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
            beforeSend: function(xhr) {
                $('#success').fadeOut(200);
                $('#loading').delay(350).fadeIn(200);
            },
            success: function (response) {
                //check if response with success : true/false
                var success = response.success;
                if(success == false)
                {
                    $(alertArea).fadeIn(200);
                    alertContent = '<strong id="welcome">Please fix these errors</strong>';
                    $(alertPlace).html(alertContent);
                    $.each(errors, function(key, value){
                        $('#'+key).addClass('has-error');
                        $('#'+key+'_err').html(value);
                    });
                }
                else
                {
                    $('#success').delay(350).fadeIn(200);
                }
                $('#loading').fadeOut(200);
            },
            error: function (response) {
                $('#loading').fadeOut(200);        
            }
        });
    });
});
</script>
@endpush

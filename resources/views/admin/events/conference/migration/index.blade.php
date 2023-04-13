@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')Migrations <small>{{ $event->title_en }}</small>
@endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-6 hide">
        	<div class="panel panel-default">
        		<div class="panel-heading">
                    <h3>Register User</h3>
                </div>
                <div class="panel-body">

                </div>
            </div>
        </div>
        <div class="col-md-6">
        	<div class="panel panel-default">
        		<div class="panel-heading">
                    <h3>Add Abstract</h3>
                </div>
                <div class="panel-body">
                	<form id="add_abstract" action="/admin/events/conference/migration/_abstract" method="post" enctype="multipart/form-data" >
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="event_id" value="{{ $event->event_id }}">
						<p>Fields with (<span style="color:red"> * </span>) is required.</p>
						<h4>User Email: <span style="color:red">*</span></h4>
						<div class="form-group">
							<input type="text" class="form-control" name="user_email" required="required" placeholder="Enter user email">
						</div>
						<h4>Topic: <span style="color:red">*</span></h4>
						<div class="form-group">
							<select class="form-control" id="topic_id" name="topic_id" required="required">
								<option value="0">Select Topic</option>
								@foreach($topics as $topic)
								<option value="{{ $topic->topic_id }}">{{ $topic->position.'. '.$topic->title_en }}</option>
								@endforeach
							</select>
						</div>
						<h4>Paper Title: <span style="color:red">*</span></h4>
						<div class="form-group">
							<input type="text" class="form-control" name="abstract_title" required="required" placeholder="Enter paper title">
						</div>
						<h4>Paste abstract content here:</h4>
						<div class="form-group">
							<textarea class="textarea" name="abstract_content" id="content"></textarea>
						</div>
						<h4>Or upload abstract file: <small>(Allowed Extinsions: PDF, DOC AND DOCX)</small></h4>
						<div class="form-group">
							<input type="file" class="hidden" accept="application/msword, application/pdf" name="abstractfile" id="abstractfile">
							<label for="abstractfile" class="btn btn-default">Choose File</label>
							<label class="btn btn-danger hidden" id="remove">Remove</label>
							<small id="filename">No file</small>
						</div>
                </div>
                <div class="panel-footer">
					<div class="row">
						<div class="col-md-3 pull-right">
							<button class="btn btn-success btn-block">Add Abstract</button>
						</div>
						<div class="pull-right hide" id="aloading" style="padding-top: 4px;">
							<img class="pull-right" src="/loadingx.gif">
						</div>
					</div>
				</div>
				</form>
            </div>
        </div>
        <div class="col-md-6">
        	<div class="panel panel-default">
        		<div class="panel-heading">
                    <h3>Add Paper</h3>
                </div>
                <div class="panel-body">
                	<form id="add_paper" action="/admin/events/conference/migration/paper" method="post" name="paper" enctype="multipart/form-data" novalidate>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="event_id" value="{{ $event->event_id }}">
						<p>Fields with (<span style="color:red"> * </span>) is required.</p>
						<h4>Abstract: <span style="color:red">*</span></h4>
						<div class="form-group">
							<select class="form-control" id="abstract_id" name="abstract_id" required="required">
								<option value="0">Select Abstract</option>
								@foreach($abstracts as $abstract)
								<option value="{{ $abstract->abstract_id }}">{{$abstract->title.'  ('.$abstract->users->email.')'.' '.$abstract->created_at}}</option>
								@endforeach
							</select>
						</div>
						<h4>Paper Title: <span style="color:red">*</span></h4>
						<div class="form-group">
							<input type="text" class="form-control" name="paper_title" required="required" placeholder="Enter paper title">
						</div>
						<h4>Upload paper file: <small>(Allowed Extinsions: DOC AND DOCX, Max Size: 50 MB)</small></h4>
						<div class="form-group">
							<input type="file" class="hidden" required="required" accept="application/msword, application/pdf" name="fullfile" id="fullfile">
							<label for="fullfile" class="btn btn-default">Choose File</label>
							<label class="btn btn-danger hidden" id="removef">Remove</label>
							<small id="filenamef">No file</small>
						</div>
                </div>
                <div class="panel-footer">
					<div class="row">
						<div class="col-md-3 pull-right">
							<button class="btn btn-success btn-block">Add Paper</button>
						</div>
						<div class="pull-right hide" id="aloading" style="padding-top: 4px;">
							<img class="pull-right" src="/loadingx.gif">
						</div>
					</div>
				</div>
				</form>
            </div>
        </div>
        <div class="col-md-6">
        	<div class="panel panel-default">
        		<div class="panel-heading">
                    <h3>Register User In Conference</h3>
                </div>
                <div class="panel-body">
                	<form id="add_user" action="/admin/events/conference/migration/register" method="post" enctype="multipart/form-data" >
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="event_id" value="{{ $event->event_id }}">
						<p>Fields with (<span style="color:red"> * </span>) is required.</p>
						<h4>Email: <span style="color:red">*</span></h4>
						<div class="form-group">
							<input type="email" class="form-control" name="user_email" required="required" placeholder="Enter email">
						</div>
                </div>
                <div class="panel-footer">
					<div class="row">
						<div class="col-md-3 pull-right">
							<button class="btn btn-success btn-block">Register User</button>
						</div>
						<div class="pull-right hide" id="aloading" style="padding-top: 4px;">
							<img class="pull-right" src="/loadingx.gif">
						</div>
					</div>
				</div>
					</form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
	tinymce.init({
		selector: '.textarea',
		height: 200,
		plugins: [
		'advlist autolink lists link image charmap print preview anchor',
		'searchreplace visualblocks fullscreen',
		'insertdatetime media table contextmenu paste'
		],
		toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		content_css: [
		
		'//www.tinymce.com/css/codepen.min.css'
		]
	});

	$(document).ready(function(){
		$('#abstractfile').on('change', function(){
			var file = $(this)[0].files[0]['name'];
			if(file){
				$('#filename').html(file);
				$('#remove').removeClass('hidden');
			}else{
				$('#filename').html('No file');
				$('#remove').addClass('hidden');
			}
		});
		$('#remove').on('click', function(){
			$('#abstractfile').val('');
			$('#filename').html('No file');
			$('#remove').addClass('hidden');
		});
		$('#fullfile').on('change', function(){
			var file = $(this)[0].files[0]['name'];
			if(file){
				$('#filenamef').html(file);
				$('#removef').removeClass('hidden');
			}else{
				$('#filenamef').html('No file');
				$('#removef').addClass('hidden');
			}
		});
		$('#removef').on('click', function(){
			$('#fullfile').val('');
			$('#filenamef').html('No file');
			$('#removef').addClass('hidden');
		});
	});
</script>
@endpush
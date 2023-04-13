@extends('admin.layouts.master')
@section('return-url'){{url('/admin/all-users')}}@endsection
@section('panel-title') Edit User Profile <small>{{ @$user->email }}</small> @endsection
@section('content')
<?php 
	if(Auth::user()->user_type_id != 4){
		die('<h1>Your account is not authorized to edit this profile.</h1>');
	} 
?>
<style>
	.regErrors{
		color:red;
		display: none;
	}
	.regErrorsx{
		color:red;
		padding: 0.2em 0.5em;
		font-weight: 300!important;
	}
</style>
<div class="container">
	<div class="panel panel-default" id="view-profile">
		<div class="panel-heading">
			<h3 class="panel-title">Profile</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<div class="col-md-4">
					<center>
					<?php if($user->gender == 1 OR $user->gender == 0){ $gender = 'male'; }elseif($user->gender == 2){ $gender = 'female'; } ?>
					<img src="@if($user->image == '') /uploads/default_avatar_{{ $gender }}.jpg @else /storage/uploads/users/profile/{{ $user->image }}.jpg @endif" style="max-width:200px;border:1px #a97f18 solid;box-shadow: 0 2px 14px 0 rgba(0,0,0,0.1)">
					</center>
				</div>
				
				<div class="col-md-8">
					<table class="table">
						<tbody>
							<tr>
								<td style="border:none;"></td>
								<td style="border:none;"></td>
							</tr>
							<tr>
								<td style="width:35%;">First Name</td>
								<td>{{ $user->first_name }} @if($user->first_name == '') {{ 'N/A' }} @endif</td>
							</tr>
							<tr>
								<td style="width:35%;">Last Name</td>
								<td>{{ $user->last_name }} @if($user->last_name == '') {{ 'N/A' }} @endif</td>
							</tr>
							<tr>
								<td style="width:35%;">Phone</td>
								<td>{{ $user->phone }} @if($user->phone == '') {{ 'N/A' }} @endif</td>
							</tr>
							<tr>
								<td style="width:35%;">Email</td>
								<td>{{ $user->email }}</td>
							</tr>
							<tr>
								<td style="width:35%;">Gender</td>
								<td>@if($user->gender == 1) {{ 'Male' }} @elseif($user->gender == 2) {{ 'Female' }} @elseif($user->gender == 0) {{ 'N/A' }}  @endif</td>
							</tr>
							<tr>
								<td style="width:35%;">Country/Region</td>
								<td>@if($user->countries['name'] == 'HOST' OR $user->countries['name'] == NULL) {{ 'N/A' }} @else {{ $user->countries['name'] }} @endif</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-12" style="display:none">
					<div class="col-md-3 pull-right">
						<a class="btn btn-success pull-right" id="edit">Edit Profile</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default" id="edit-profile" style="display:block;">
		<form method="post" id="register_form" action="">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="user_id" value="{{ $user->user_id }}">
		<input type="hidden" name="old_password" value="{{ $user->password }}">
		<div class="panel-heading">
			<h3 class="panel-title">User Details</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-8 col-md-offset-2" style="background:#f9f9f9; padding:1em;border-radius:2px;border:1px #f3f3f3 solid;">
				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Profile Details</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-4 control-label">Profile Image</label>
							<div class="col-md-8">
								<img id="image-view" class="img-responsive img-thumbnail" src="@if($user->image == ''){{'/uploads/default_avatar_'.$gender.'.jpg'}}@else /storage/uploads/users/profile/{{ $user->image }}.jpg @endif" style="max-height:120px;max-width:100px;border:1px #a97f18 solid;margin-bottom:10px;">
								<input class="form-control" style="margin-bottom:10px;" type="file" id="image" name="image" value="" accept="image/jpg, image/jpeg, image/png, image/gif">
								<script>
									function readURL(input) {
									if (input.files && input.files[0]) {
									var reader = new FileReader();
									reader.onload = function (e) {
									$('#image-view').attr('src', e.target.result);
									}
									reader.readAsDataURL(input.files[0]);
									}
									}
									$('#image').on('change', function(){
										readURL(this);
									});
								</script>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Title</label>
							<div class="col-md-8">
								<select name="user_title_id" class="form-control">
									<option value="0">Choose Title</option>}
									@foreach($titles as $title)
										<option @if($user->user_title_id == $title->user_title_id) {{'selected'}} @endif value="{{ $title->user_title_id }}">{{ $title->title }}</option>
									@endforeach
								</select>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">First Name</label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="text" name="first_name" id="first_name" value="{{ $user->first_name }}">
								<label id="first_name_err" class="regErrors" style="font-size:12px;font-weight:400;"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Last Name </label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="text" name="last_name" id="last_name" value="{{ $user->last_name }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Birth Date </label>
							<div class="col-md-8">
								<input class="form-control datepicker"  style="margin-bottom:10px;" type="text" name="age" placeholder="YYYY-MM-DD" value="@if($user->age == null or $user->age == '0000-00-00' or $user->age < '1900-00-00'){{''}}@else{{ $user->age }}@endif">
							</div>
							<script type="text/javascript">
							$(document).ready(function(){
								$('.datepicker').datepicker();
							});
							</script>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Country</label>
							<div class="col-md-8">
								<select name="country_id" class="form-control">
									<option value="0">Choose Country</option>}
									@foreach($countries as $country)
										<option @if($user->country_id == $country->country_id) {{'selected'}} @endif value="{{ $country->country_id }}">{{ $country->name.', '.$country->sortname }}</option>
									@endforeach
								</select>
								<label class="regErrors hidden" style="font-size:12px;font-weight:400;">This Field is Required</label>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Phone </label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="text" name="phone" value="{{ $user->phone }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Affiliation </label>
							<div class="col-md-8">
								<textarea class="form-control" style="margin-bottom:10px;" name="abbreviation">{{ $user->abbreviation }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Biography </label>
							<div class="col-md-8">
								<textarea class="form-control" style="margin-bottom:10px;" rows="5" id="content" name="biography">{{ $user->biography }}</textarea>
								<label style="font-size:12px;font-weight:400;">Maximum: 2000</label>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">C.V.</label>
							<div class="col-md-8">
								<label>{{ $user->cv }}</label>
								<input class="form-control" style="margin-bottom:10px;" type="file" id="cv" name="cv" value="" accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf">
							</div>
							<div class="clearfix"></div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Gender </label>
							<div class="col-md-8">
								<div class="userpro-radio-wrap" data-required="0"><label class="userpro-radio"><span class="checked"></span><input type="radio" value="1" name="gender" @if($user->gender == 1) checked @endif >&ensp;Male</label>&ensp;&ensp;<label class="userpro-radio"><span class=""></span><input type="radio" value="2" name="gender"  @if($user->gender == 2) checked @endif >&ensp;Female</label></div>
								<script>
									$(document).ready(function(){
										$('input[name=gender]').on('change', function(){
											var val = $(this).val();
											var src = $('#image-view').attr('src');
											console.log(val+' '+src);
											if(val == 1 && src == '/uploads/default_avatar_female.jpg'){
												$('#image-view').attr('src', '/uploads/default_avatar_male.jpg');
											}
											if(val == 2 && src == '/uploads/default_avatar_male.jpg'){
												$('#image-view').attr('src', '/uploads/default_avatar_female.jpg');
											}
										});
									});
								</script>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">User Type / Role </label>
							<div class="col-md-8">
								<div class="userpro-radio-wrap" data-required="0">
                                                                    <label class="userpro-radio">
                                                                        <span class="checked"></span>
                                                                        <input type="radio" value="0" name="role" @if($user->user_type_id == 0) checked @endif >
                                                                               &ensp;Regular</label>&ensp;&ensp;
                                                                               <label class="userpro-radio">
                                                                                   <span class=""></span>
                                                                                   <input type="radio" value="1" name="role" @if($user->user_type_id == 1) checked @endif >
                                                                                          &ensp;Scientific Committee
                                                                               </label>
                                                                               &ensp;&ensp;
                                                                               <label class="userpro-radio">
                                                                                   <span class=""></span>
                                                                                   <input type="radio" value="2" name="role"  @if($user->user_type_id == 2) checked @endif >
                                                                                          &ensp;Event Admin
                                                                               </label>
                                                                               &ensp;&ensp;
                                                                               <label class="userpro-radio" >
                                                                                   <input type="radio" value="3" @if($user->user_type_id == 3) checked @endif name="role" >
                                                                                          &ensp;Event Editor
                                                                                          <span></span>
                                                                               </label>
                                                                               &ensp;&ensp;
                                                                               <label class="userpro-radio" >
                                                                                   <input type="radio" value="5" @if($user->user_type_id == 5) checked @endif name="role" >
                                                                                          &ensp;Accountant
                                                                                          <span></span>
                                                                               </label>
                                                                               &ensp;&ensp;
                                                                               <label class="userpro-radio" style="color:red!important">
                                                                                   <input type="radio" value="4" @if($user->user_type_id == 4) checked @endif name="role" >
                                                                                          &ensp;Super Admin&ensp;
                                                                                          <span class="fa fa-cogs"></span>
                                                                               </label>
                                                                </div>
							</div>
							<div class="clearfix"></div>
						</div>
<!--						<div class="form-group">
							<label class="col-md-4 control-label">URL</label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="text" name="slug" value="{{$user->slug}}">
								<label id="slug_err" class="regErrors" style="font-size:12px;font-weight:400;"></label>
							</div>
						</div>-->
 <div class="form-group" id="slug">
                                <label class="col-md-4 control-label">Slug</label>
                                <div class="col-md-6 col-xs-12">  
                                    <div class="input-group">
                                        <span class="input-group-addon">URL <span class="redl">*</span></span>
                                        <input type="text" name="slug" id="slug_input" onchange="isDuplicated(this.value);" class="form-control" value="{{$user->slug}}"/>
                                    </div>
                              	<label class="regErrors" id="slug_err" style="font-size:12px;font-weight:400;"></label>

                                </div>
                            </div>
					</div>
				</div>
				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Social Profile</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-4 control-label">LinkedIn (URL)</label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="url" name="linkedin" value="{{ $user->linkedin }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Twitter (URL)</label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="url" name="twitter" value="{{ $user->twitter }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Facebook (URL)</label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="url" name="facebook" value="{{ $user->facebook }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Website (URL)</label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="url" name="url" value="{{ $user->url }}">
							</div>
						</div>

					</div>
				</div>
				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Account Details</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-4 control-label">Email</label>
							<div class="col-md-8">
								<input autocomplete="off" class="form-control" style="margin-bottom:10px;" type="email" name="email" value="{{ $user->email }}">
								<label class="regErrors" id="email_err" style="font-size:12px;font-weight:400;"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-8">
								<input autocomplete="off" class="form-control" style="margin-bottom:10px;" type="password" name="password" value="{{ $user->password }}">
								<label class="regErrors" id="password_err" style="font-size:12px;font-weight:400;"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-8">
								<input autocomplete="off" class="form-control" style="margin-bottom:10px;" type="password" name="password_confirmation" value="{{ $user->password }}">
								<label class="regErrors" id="password_c_err" style="font-size:12px;font-weight:400;"></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<img src="{{ url('loading.gif') }}" alt="Loading" style="display:none" id="reg_gif">&ensp;<input type="submit" id="register" class="btn btn-success btn-sm pull-right" id="save" class="pull-right" value="Update User">
			<div class="clearfix"></div>
		</div>
		</form>
	</div>
</div>
@endsection
@push('style')

@endpush
@push('scripts')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){	
	tinymce.init({
	selector: '#content',
	height: 300,
	plugins: [
	''
	],
	toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	content_css: [
	
	'//www.tinymce.com/css/codepen.min.css'
	]
	});
});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		// AJAX REGISTER
        $("#register").click(function (e) {
            e.preventDefault();
            var content = tinymce.get('content').getContent();
            $('#content').text(content);
            var loading = document.getElementById('reg_gif');
            $.ajaxSetup({
	            headers: {
	            'X-CSRF-TOKEN': $('input[name="_token"]').val()
	            }
	            })
            	var myForm = document.getElementById('register_form');
	            var formData = new FormData(myForm);
	            $.ajax({
	            type: 'POST',
	            url: '{{ url("admin/all-users/update") }}',
	            data: formData,
	            dataType: 'json',
		        cache: false,
		        contentType: false,
		        processData: false,
	            beforeSend: function(xhr) {
	            //loading ajax animation
		            $(loading).show();
		            $('.regErrors').each(function(){
		            	$(this).html('');
		            	$(this).hide();
		            })
	            },
	            success: function (response) {
	            window.open(location.protocol+'//'+location.host+location.pathname,'_self');
	            $(loading).hide();
	            },
	            error: function (response) {
	            $(loading).hide();
	                var objOut = response.responseText; 
	                if (objOut.match("^<")) {
	                    // do this if begins with Hello
	                    $(loading).hide();
	                }else{
	                	var err = '<strong>Please fix these errors:</strong><br><br><ul>';
	                	var obj = $.parseJSON(response.responseText);
	                	var errors = obj.errs;
	                    if(errors.first_name != undefined && errors.first_name[0] != undefined){
	                        $('#first_name_err').html('This Field is Required').show();
	                        err = err+'<li class="regErrorsx">First Name is required.</li>';
	                    }
	                    if(errors.email != undefined && errors.email[0] != undefined){
	                        $('#email_err').html(errors.email[0]).show();
	                        err = err+'<li class="regErrorsx">'+errors.email[0]+'</li>';
	                    }
	                    if(errors.password != undefined && errors.password[0] != undefined)
	                    {
	                        $('#password_err').html(errors.password[0]).show();
	                        err = err+'<li class="regErrorsx">'+errors.password[0]+'</li>';
	                    }
	                    if(errors.password != undefined && errors.password[1] != undefined)
	                    {
	                        $('#password_c_err').html(errors.password[1]).show();
	                    	err = err+'<li class="regErrorsx">'+errors.password[1]+'</li>';
	                    }
	                    if(errors.slug != undefined && errors.slug[0] != undefined)
	                    {
	                        $('#slug_err').html(errors.slug[0]).show();
	                        err = err+'<li class="regErrorsx">'+errors.slug[0]+'</li>';
	                    }
                    
	                    informX(err+'</ul>');
	                }
	            }
	            });
            });
        });
        
           function slug(val)
    {
        var sVal = val;
        var noSpec = sVal.replace(/[^\w\s]/gi, '');
        var slug = noSpec.replace(/\s+/g, '-').toLowerCase();
        return slug;
    }
        
          $('#first_name,#last_name').on('keyup', function(){
            var fName = $('#first_name').val();
            var lName = $('#last_name').val();
            
            var slugName = fName +'_'+lName;
           
            $('#slug_input').val(slug(slugName));
             
    });
</script>
@endpush

@extends('layouts.master')
@section('content')
@if(!isset($paper))
	@if(@$abstract->status >= 4 && @$abstract->status <= 8)
	<script>window.open('{{ url('/fullpaper/status/'.@$abstract->abstract_id) }}', '_self')</script>
	@endif
@endif
@if(@$abstract->status == 9)
	<div id="CONDETAILP">
		<div class="container">
			<div class="col-md-12 order">
				<div class="panel">
					<div class="panel-heading">
						<h4>ABSTRACT STATUS&ensp;&ensp;<small style="color:#fff">{{ $event->title_en }}</small></h4>
					</div>
					<div class="panel-body">
						<div class="accordion">
							<div class="bg-danger message">
								<strong>Abstract <strong style="color:red">Rejected</strong></strong>,<br>
								Dear Colleague, Your abstract didn't match our requirments for submit abstract, kindly review our abstract instructions then submit your abstract again.
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@else
<div id="CONDETAILP">
	<div class="container submit-your-paper">
		<div class="col-md-12">
			<figure class="cover-img">
	            @if(file_exists('storage/uploads/conferences/'.$event->event_id.'/cover_img.jpg'))<img src="/storage/uploads/conferences/{{ $event->event_id }}/cover_img.jpg" class="img-responsive" alt="" />@endif
	        </figure>
		</div>
		<form>
			<div class="col-md-8 order">
				<div class="panel @if(isset($abstract)){{ 'hidden' }}@endif">
					<div class="panel-heading">
						<h4>SUBMIT ABSTRACT&ensp;&ensp;<small style="color:#fff">{{ $event->title_en }}</small></h4>
					</div>
					<div class="panel-body">
						<div class="accordion">
							<div class="bg-warning message" id="instructions">
								<strong>Dear Colleague</strong>,<br>
								Please choose the conference topic most relevant to that of your submission, provide a title for your abstract/paper and upload your 
								abstract as a document or by copying and pasting it into the text box below. Include all names and emails of contributors 
								(author and corresponding coauthor(s)) as well as the relevant keywords.<br>
								<br>
								* Please postpone the payment of the conference fees until your abstract is accepted.
								<br>
								** Once and if your abstract is accepted, you will be informed by email. Please regularly check your registered email and spam folder.
								<br>
								*** Once a full paper is submitted, it is subject to a preliminary peer review process. Once approved, you will havebe requested to complete 
								payment of the conference fees. Then, we will send you the full information, conference program and letter of visa, if needed.
							</div>
							<form method="post" id="form">
							</form>
							<form id="submit_form">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="event_id" value="{{ $event->event_id }}">
								<p>Fields with (<span style="color:red"> * </span>) is required.</p>
								<h4>Topic: <span style="color:red">*</span></h4>
								<div class="form-group">
									<select class="form-control" id="topic_id" name="topic_id">
										<option value="0">Select Topic</option>
										@foreach($topics as $topic)
										<option value="{{ $topic->topic_id }}">{{ $topic->position.'. '.$topic->title_en }}</option>
										@endforeach
									</select>
								</div>
								<h4>Paper Title: <span style="color:red">*</span></h4>
								<div class="form-group">
									<input type="text" class="form-control" name="abstract_title" placeholder="Enter your paper title">
								</div>
								<h4>Paste your abstract content here:</h4>
								<div class="bg-danger message">
								<p>*Please make sure to add at least 3 keywords with your abstract*</p>
							    </div>
								<div class="form-group">
									<textarea class="textarea" name="abstract_content" id="content"></textarea>
								</div>
								<h4>Or upload your abstract file: <small>(Allowed Extinsions: pdf, doc, docm and docx)</small></h4>
								<div class="form-group">
									<input type="file" class="hidden" accept=".docm, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf" name="abstractfile" id="abstractfile">
									<label for="abstractfile" class="btn btn-defaultx">Choose File</label>
									<label class="btn btn-danger hidden" id="remove">Remove</label>
									<small id="filename">No file</small>
								</div>
							</form>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-8" id="inst">
								<input type="checkbox" name="terms" class="form-control" value="1" id="terms" style="position:absolute;width:17px;padding:0;margin:0;height:17px;top:4px">
								<label for="terms" style="text-indent:23px;">Please Confirm that you Read <strong><a style="cursor:pointer" onclick="toDiv('instructions', 250, 1)">Instructions</a></strong>.</label>
							</div>
							<div class="col-md-3 pull-right">
								<a class="btn btn-success btn-block" onclick="submitAbstract()">Submit Abstract</a>
							</div>
							<div class="pull-right hide" id="aloading" style="padding-top: 4px;">
								<img class="pull-right" src="/loadingx.gif">
							</div>
						</div>
					</div>
				</div>
				<div class="panel @if(isset($abstract) && $abstract->status <= 2){{ '' }}@else{{ 'hidden' }}@endif" data-show="1">
					<div class="panel-heading">
						<h4>ABSTRACT STATUS&ensp;&ensp;<small style="color:#fff">{{ $event->title_en }}</small></h4>
					</div>
					<div class="panel-body">
						<div class="accordion">
							<table class="table" style="font-size:14px;">
								<thead>
									<tr>
										<th>Title</th>
										<th>Submission Date</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<?php
										$status = array(
											0 => 'Pending Approval',
											1 => 'Under Revision',
											2 => 'Accetped <a class="btn btn-defaultx btn-sm" href="/upload/fullpaper/'.@$abstract->abstract_id.'">Upload Paper</a>'
										);
										?>
										<td>{{ @$abstract->title }}</td>
										<td>{{ @$abstract->created_at }}</td>
										<td><?php echo @$status[$abstract->status] ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="panel @if(isset($abstract) && $abstract->status == 3){{ '' }}@else{{ 'hidden' }}@endif" data-show="2">
					<div class="panel-heading">
						<h4>UPLOAD FULL PAPER&ensp;&ensp;<small style="color:#fff">{{ $event->title_en }}</small></h4>
					</div>
					<div class="panel-body">
						<div class="accordion">
							<div class="bg-success message">
								<strong>Abstract <strong style="color:darkgreen">Accepted</strong></strong>,<br>
								It is the time now to upload your paper for revision, we will review your paper and make sure it meets with our requirments before sending it to the scientific committee for revision, you will be able to check your revision status of your paper by going to My Account > Manage My Abstracts, then to choose the paper you want to check from the list.
								<br><br>
								Please enter a descriptive title for your paper and upload your paper file.
							</div>
							<div class="bg-warning message" id="instructionsf">
								<strong>Instructions</strong>,<br>
								* Please upload your paper using provided writing template.
							</div>
							<form method="post" id="form">
							</form>
							<form id="paper_form">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="event_id" value="{{ $event->event_id }}">
								<p>Fields with (<span style="color:red"> * </span>) is required.</p>
								<h4>Topic: </h4>
								<div class="form-group">
									<h3>{{ @$topic->position.'. '.@$topic->title_en }}</h3>
								</div>
								<h4>Paper Title: <span style="color:red">*</span></h4>
								<div class="form-group">
									<input type="text" class="form-control" name="paper_title" placeholder="Enter descriptive title for your paper">
								</div>
								<h4>Please upload your paper file: <small>(Allowed Extinsions: doc, docm and docx, Max Size: 50 MB)</small></h4>
								<div class="form-group">
									<input type="file" class="hidden" accept=".docm,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf" name="fullfile" id="fullfile">
									<label for="fullfile" class="btn btn-defaultx">Choose File</label>
									<label class="btn btn-danger hidden" id="removef">Remove</label>
									<small id="filenamef">No file</small>
								</div>
                                                                <div class="form-group">
									<input type="file" class="hidden" accept=".docm,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf" name="blindfile" id="blindfile">
									<label for="blindfile" class="btn btn-defaultx">Choose Blind File</label>
									<label class="btn btn-danger hidden" id="blindremovef">Remove</label>
									<small id="blindfilenamef">No file</small>
								</div>
                                                                <input type="radio" name="paper_kind" value="1" id='paper_id'> long paper<br>
                                                                 <input type="radio" name="paper_kind" value="2" id='paper_id'> short paper<br>
							</form>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-8" id="instf">
								<input type="checkbox" name="termsf" class="form-control" value="1" id="termsf" style="position:absolute;width:17px;padding:0;margin:0;height:17px;top:4px">
								<label for="termsf" style="text-indent:23px;">Please Confirm that you Read <strong><a style="cursor:pointer" onclick="toDiv('instructionsf', 250, 1)">Instructions</a></strong>.</label>
							</div>
							<div class="col-md-3 pull-right">
								<a class="btn btn-success btn-block" onclick="submitPaper()">Upload Paper</a>
							</div>
							<div class="pull-right hide" id="ploading" style="padding-top: 4px;">
								<img class="pull-right" src="/loadingx.gif">
							</div>
						</div>
					</div>
				</div>
				<div class="panel @if(isset($paper) && ($abstract->status >= 4 && $abstract->status <= 8)){{ '' }}@else{{ 'hidden' }}@endif" data-show="1">
					<div class="panel-heading">
						<h4>PAPER STATUS&ensp;&ensp;<small style="color:#fff">{{ $event->title_en }}</small></h4>
					</div>
					<div class="panel-body">
						<div class="accordion">
							<table class="table" style="font-size:14px;">
								<thead>
									<tr>
										<th>Title</th>
										<th>Submission Date</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<?php
										$status = array(
											0 => 'Pending Approval',
											1 => 'Approved',
											2 => 'Awaiting Editors Decision',
											3 => '<strong style="color:darkgreen">Accepted</strong>',
											4 => '<strong style="color:red">Rejected</strong>'
										);
										?>
										<td>{{ @$paper->title }}</td>
										<td>{{ @$paper->created_at }}</td>
										<td><?php echo @$status[$paper->status] ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="panel @if(isset($paper) && ($abstract->status >= 4 && $abstract->status <= 8)){{ '' }}@else{{ 'hidden' }}@endif" data-show="1">
					<div class="panel-heading">
						<h4>Paper Co-Authors&ensp;&ensp;<small style="color:#fff">{{ @$paper->title }}</small></h4>
					</div>
					<div class="panel-body">
						<h4>Co-Authors</h4>
						<table id="cothers" class="table table-striped table-hover  @if(isset($coauthors) && count($coauthors) > 0) @else{{'hide'}}@endif">
							<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="theco">
							@if(isset($coauthors) && count($coauthors) > 0)
									@foreach($coauthors as $co)
									<tr id="coauthor{{$co->user_id}}">
										<td>{{$co->name}}</td>
										<td>{{$co->email}}</td>
										<td><a style="color:red" class="btn" onclick="removeCo({{$co->user_id}})">Remove</a></td>
									</tr>
									@endforeach
							@endif
							</tbody>
						</table>
						<p id="nocowar" class="message bg-danger @if(isset($coauthors) && count($coauthors) > 0){{'hide'}}@else @endif">No Co-Authors are set for this paper yet</p>
					<form id="coauthors_form">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="paper_id" value="{{ @$paper->paper_id }}">
							<input type="hidden" name="event_id" value="{{ @$paper->event_id }}">
							<h4>Add Co-Author</h4>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input type="text" class="form-control" name="co_name" placeholder="Co-Author Name">
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<input type="email" class="form-control" name="co_email" placeholder="Co-Author Email">
									</div>
								</div>
							</div>
							<div class="form-group">
								<p class="message bg-warning"><i class="glyphicon glyphicon-warning-sign"></i> <strong>Warning</strong><br>By clicking "Add Co-Author" button, you confirm that the name and email provided is real and represnting true Co-Author of this paper.</p>
							</div>
							<div class="form-group">
								<a class="btn btn-success" onclick="add_coauthor()">Add Co-Author</a>
								<div class="pull-right hide" id="caloading" style="padding-top: 4px;">
									<img class="pull-right" src="/loadingx.gif">
								</div>
							</div>
						</form>
					</div>
				</div>
				@if(isset($paper))
				@if(@$paper->status > 0 && @$paper->notes != '')
					<div class="panel">
						<div class="panel-heading">
							<h4>PAPER NOTES&ensp;&ensp;<small style="color:#fff"></small></h4>
						</div>
						<div class="panel-body">
							<div class="accordion">
								<div class="bg-warning message">
									<p style="white-space: pre-wrap;">{{@$paper->notes}}</p>
								</div>
							</div>
						</div>
					</div>
				@endif
				@if($paper->status == 3)
				<div class="panel">
					<div class="panel-body">
						<div class="message bg-success">
							<p><strong>Congratulations!</strong><br>Your Paper reviewed and accepted, please make sure you have made your payment before deadline.</p>
						</div>
					</div>
				</div>
				@endif
				@if($paper->status == 4)
				<div class="panel">
					<div class="panel-body">
						<div class="message bg-warning">
							<p><strong>Alert!</strong><br>Your Paper reviewed and rejected, please follow the reviewers comments in comments panel below to guide you to the requirements and what you should do in the next step.</p>
						</div>
					</div>
				</div>
				@endif
				@endif
				<div class="panel @if(isset($paper) && ($abstract->status >= 4 && $abstract->status <= 8)){{ '' }}@else{{ 'hidden' }}@endif">
					<div class="panel-heading">
						<h4>Comments</h4>
					</div>
					<div class="panel-body" id="comments">
						@if(isset($comments))
						@foreach($comments as $comment)
						@if($comment->user_type == 0)
						@if(($comment->filename == '') AND ($comment->message != ''))
						<div class="col-md-12">
							<div class="col-md-2 ">
								<label class="pull-right top10 simg">ME</label>
								<small>Author</small>
							</div>
							<div class="col-md-10 message msg" style="background:#d1f2cc">
								<p style="white-space:pre-wrap">{{ $comment->message }}</p>
							</div>
							<br>
						</div>
						@endif
						@if(($comment->filename != '') AND ($comment->message == ''))
						<div class="col-md-12">
							<div class="col-md-2 ">
								<label class="pull-right top10 simg">ME</label>
								<small>Author</small>
							</div>
							<br>
							<div class="col-md-10 pull-right afile">
								<span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: {{@$comment->file}}</small></span><small class="pull-right"><a href="{{ url('comments/'.@$paper->event_id.'/'.@$comment->filename) }}"><i class="fa fa-download"></i> [Download]</a></small>
							</div>
							<br>
						</div>
						@endif
						@if(($comment->filename != '') AND ($comment->message != ''))
						<div class="col-md-12">
							<div class="col-md-2 ">
								<label class="pull-right top10 simg">ME</label>
								<small>Author</small>
							</div>
							<div class="col-md-10 message msg" style="background:#d1f2cc">
								<p style="white-space:pre-wrap">{{ $comment->message }}</p>
							</div>
							<div class="col-md-10 pull-right afile">
								<span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: {{@$comment->file}}</small></span><small class="pull-right"><a href="{{ url('comments/'.@$paper->event_id.'/'.@$comment->filename) }}"><i class="fa fa-download"></i> [Download]</a></small>
							</div>
							<br>
						</div>
						@endif
						@endif
						{{-- @if($comment->user_type == 1)
							@if(($comment->filename == '') AND ($comment->message != ''))
							<div class="col-md-12">
								<div class="col-md-10 message msg" style="background:#ccf0f2">
									<p style="white-space:pre-wrap">{{ $comment->message }}</p>
								</div>
								<div class="col-md-2">
									<label class="pull-left top10 scimg">SC</label>
									<small class="pull-right">Reviewer</small>
								</div>
								<br>
							</div>
							@endif
							@if(($comment->filename != '') AND ($comment->message == ''))
							<div class="col-md-12">
								<div class="col-md-2 pull-right">
									<label class="pull-left top10 scimg">SC</label>
									<small class="pull-right">Reviewer</small>
								</div>
								<br>
								<div class="col-md-10 top13 afile">
									<span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: {{@$comment->file}}</small></span><small class="pull-right"><a href="{{ url('comments/'.@$paper->event_id.'/'.@$comment->filename) }}"><i class="fa fa-download"></i> [Download]</a></small>
								</div>
								<br>
							</div>
							@endif
							@if(($comment->filename != '') AND ($comment->message != ''))
							<div class="col-md-12">
								<div class="col-md-2 pull-right">
									<label class="pull-left top10 scimg">SC</label>
									<small class="pull-right">Reviewer</small>
								</div>
								<div class="col-md-10 message msg" style="background:#ccf0f2">
									<p style="white-space:pre-wrap">{{ $comment->message }}</p>
								</div>
								<div class="col-md-10 afile">
									<span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: {{@$comment->file}}</small></span><small class="pull-right"><a href="{{ url('comments/'.@$paper->event_id.'/'.@$comment->filename) }}"><i class="fa fa-download"></i> [Download]</a></small>
								</div>
								<br>
							</div>
							@endif
						@endif --}}
						@if($comment->user_type == 2)
						@if(($comment->filename == '') AND ($comment->message != ''))
						<div class="col-md-12">
							<div class="col-md-10 message msg" style="background:#f2f1cc">
								<p style="white-space:pre-wrap">{{ $comment->message }}</p>
							</div>
							<div class="col-md-2">
								<label class="pull-left top10 eimg">ED</label>
								<small class="pull-right">Editor</small>
							</div>
							<br>
						</div>
						@endif
						@if(($comment->filename != '') AND ($comment->message == ''))
						<div class="col-md-12">
							<div class="col-md-2 pull-right">
								<label class="pull-left top10 eimg">ED</label>
								<small class="pull-right">Editor</small>
							</div>
							<br>
							<div class="col-md-10 top13 afile">
								<span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: {{@$comment->file}}</small></span><small class="pull-right"><a href="{{ url('comments/'.@$paper->event_id.'/'.@$comment->filename) }}"><i class="fa fa-download"></i> [Download]</a></small>
							</div>
							<br>
						</div>
						@endif
						@if(($comment->filename != '') AND ($comment->message != ''))
						<div class="col-md-12">
							<div class="col-md-2 pull-right">
								<label class="pull-left top10 eimg">ED</label>
								<small class="pull-right">Editor</small>
							</div>
							<div class="col-md-10 message msg" style="background:#f2f1cc">
								{{ $comment->message }}
							</div>
							<div class="col-md-10 afile">
								<span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: {{@$comment->file}}</small></span><small class="pull-right"><a href="{{ url('comments/'.@$paper->event_id.'/'.@$comment->filename) }}"><i class="fa fa-download"></i> [Download]</a></small>
							</div>
							<br>
						</div>
						@endif
						@endif
						@endforeach
						@endif
					</div>
					<div class="panel-footer">
						@if(isset($paper))
						@if($paper->status != 3)
						<div class="bg-danger message hidden" id="instructions">
							<i class="glyphicon glyphicon-warning-sign"></i> Do not include any personal details in your comments or attachments.
						</div>
						@endif
						@endif
						<div class="row">
							<form id="commentsform">
								<div class="col-md-10">
									<textarea class="form-control" id="messagetext" name="message" rows="3" placeholder="Place your comment text here"></textarea>
									<input type="hidden" name="attachmentname"><input type="hidden" name="attachmentfilename"><input type="hidden" name="event_id" value="{{ @$paper->event_id }}">
									<small id="attachmentname"></small><span class="hidden" id="removeattachment" style="color:red;cursor:pointer"> <small>Remove</small></span>
								</div>
								<div class="col-md-2">
									<a onclick="sendMessage()" id="sendmsg" class="btn btn-success btn-block pull-right"><i class="glyphicon glyphicon-send"></i> Send</a>
									<label for="attachment" class="btn btn-default btn-block pull-right"><i class="glyphicon glyphicon-paperclip"></i><input type="file" class="hidden" id="attachment" name="attachment"> File</label>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="col-md-4">
			<div class="panel">
				<div class="panel-body">
					<div class="col-md-12 step @if(!isset($abstract)){{ 'actv' }}@endif @if(isset($abstract)){{ 'done' }}@endif">
						<span><i class="glyphicon glyphicon-cloud-upload xlarge"></i></span>
						<span class="step_text">1. Abstract</span><br>
						<small>Upload your abstract for revision.</small>
					</div>
					<div class="col-md-12 step @if(isset($abstract) && ($abstract->status >= 0 && $abstract->status <= 2)){{ 'actv' }}@endif @if(isset($abstract) && ($abstract->status > 2)){{ 'done' }}@endif">
						<span><i class="fa fa-eye xlarge"></i></span>
						<span class="step_text">2. Status</span><br>
						<small>Check your abstract revision status.</small>
					</div>
					<div class="col-md-12 step @if(isset($abstract) && ($abstract->status == 3)){{ 'actv' }}@endif  @if(isset($abstract) && ($abstract->status > 3)){{ 'done' }}@endif">
						<span><i class="fa fa-upload xlarge"></i></span>
						<span class="step_text">3. Paper</span><br>
						<small>Upload your paper for revision.</small>
					</div>
					<div class="col-md-12 step @if(isset($abstract) && ($abstract->status >= 4 && $abstract->status <= 5)){{ 'actv' }}@endif  @if(isset($abstract) && ($abstract->status > 6)){{ 'done' }}@endif">
						<span><i class="fa fa-laptop xlarge"></i></span>
						<span class="step_text">4. Revision</span><br>
						<small>Check your paper revision status.</small>
					</div>
					<div class="col-md-12 step @if(isset($abstract) && ($abstract->status >= 7 && $abstract->status <= 8)){{ 'actv' }}@endif  @if(isset($abstract) && ($abstract->status > 8)){{ 'done' }}@endif">
						<span><i class="glyphicon glyphicon-link xlarge"></i></span>
						<span class="step_text">5. Result</span><br>
						<small>Paper revision result.</small>
					</div>
				</div>
				<div class="panel-body">
					@if(isset($abstract))
					@if(($abstract->payment == 0) && ($abstract->status >= 2))
					<a class="btn btn-success btn-block @if(@$paper->paid == 1){{'hide'}}@endif" href="{{ url('/payment') }}/{{$event->slug}}"><i class="fa fa-dollar"></i>&ensp;Payment</a>
					@endif
					@endif
					<?php $file = 'storage/uploads/conferences'.'/'.$event->event_id.'/'.$event->writing_template; ?>
					@if(file_exists($file))
					<a class="btn btn-defaultx btn-block" href="{{url($file)}}"><i class="fa fa-file"></i>&ensp;Download Writing Template</a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endif

@endsection
@push('styles')
<style rel="stylesheet" type="text/css">
	.step{
		cursor: pointer;
		padding: 0.75em 0.75em;
		transition: 0.2s;
		border:1px solid #f1f1f1;
		background: #f9f9f9;
		cursor: default;!important;
	}/*
	.step:hover{
		background: #f1f1f1;
	}*/
	.step.actv{
		background: #aa822c;
		color:#fff;
	}
	.step.done{
		text-decoration: line-through;
		background: #e1e1e1;
	}
	.xlarge{
		font-size: 20px;
		padding: 0.2em;
		border: 1px solid #777;
		background: rgba(0,0,0,0.05);
		border-radius: 50%;
	}
	.step.actv .xlarge{
		border: 2px solid #fff;
		background: rgba(0,0,0,0.3);
	}
	.step_text{
		font-size: 20px;
		padding: 0.125em;
	}
	.custome-control{
		width: 100%;
		font-size: 13px!important;
		font-weight: 300!important;
		border:0px;
		background: transparent;
		text-indent: 5px;
		border-radius: 3px;
		height: 2em!important;
		transition: 0.2s;
	}
	.custome-control:focus{
		background: #fff;
		color:#666;
	}
	.head{
		border-radius: 0%!important;
		border: 1px solid #f1f1f1!important;
		border:0px;
	}
	.body{
		display: none;
		border: 1px solid #f1f1f1!important;
		padding: 1em;
	}
	.body.active{
		display: block;
	}
	.fees-title{
		border-bottom:1px #f1f1f1 solid;
	}
	.btn-defaultx{
		background:#0c3852!important;
		color:#fff!important;
		cursor: pointer;
		transition: 0.3s;
	}
	.btn-defaultx:hover{
		background:#a97f18!important;
		color:#000;
	}
	#comments{
		max-height:320px;
		overflow:auto;
	}
	.top10{
		padding-top: 13px;
	}
	.top13{
		padding-top: 18px;
	}
	.msg{
		box-shadow: 0px 1px 2px 0px rgba(0,0,0,0.2);
	}
	.afile{
		background:#e9e9e9;
		margin-top:-10px;
		padding:0.225em;
		box-shadow: 0px 1px 2px 0px rgba(0,0,0,0.2);
	}
	.eimg{
		border-radius: 50%;
		background: #e9e79e;
		margin-top: 10px;
		width:40px;
		text-align: center;
		vertical-align: middle;
		line-height: 18px;
		box-shadow: 0 0 0 4px rgba(0,0,0,0.05);
		height: 40px;
		font-size: 18px;
	}
	.scimg{
		border-radius: 50%;
		background: #a1e0e3;
		margin-top: 10px;
		width:40px;
		text-align: center;
		vertical-align: middle;
		line-height: 18px;
		box-shadow: 0 0 0 4px rgba(0,0,0,0.05);
		height: 40px;
		font-size: 18px;
	}
	.simg{
		border-radius: 50%;
		background: #b1e7a8;
		margin-top: 10px;
		width:40px;
		text-align: center;
		vertical-align: middle;
		line-height: 18px;
		box-shadow: 0 0 0 4px rgba(0,0,0,0.05);
		height: 40px;
		font-size: 18px;
	}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

@endpush
@push('scripts')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" charset="utf-8" async defer>
	function makeid()
	{
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	for( var i=0; i < 5; i++ )
	text += possible.charAt(Math.floor(Math.random() * possible.length));
	return text;
	}
    function informX(message) {
        var cHolder = document.createElement('div');
        cName = makeid();
        cHolder.id = cName;
        cHolder.className = 'cHolder';
        document.getElementsByClassName('cBlocker')[0].appendChild(cHolder);
        var target = document.getElementById(cName);
        var cText = document.createElement('p');
        var cOk = document.createElement('div');
        cOk.className = "cOk";
        cOk.innerHTML = 'Close';
        $(cOk).on('click', function () {
            $(this).closest('.cHolder').fadeOut(500);
            $('.cBlocker').fadeOut(500);
        })
        cText.innerHTML = message;
        cText.style.color = '#888';
        target.appendChild(cText);
        target.appendChild(cOk);
        $(target).fadeIn(500);
        $('.cBlocker').fadeIn(500);
    }
	function ext(fname)
	{
		return '.'+fname.slice((fname.lastIndexOf(".") - 1 >>> 0) + 2);
	}
	(function($){
$(window).on("load",function(){
// $("#comments").mCustomScrollbar({
// 	theme:"dark",
// 	scrollInertia:100
// });
// $("#comments").mCustomScrollbar("scrollTo","bottom",{
// 	scrollInertia:10
// });
});
})(jQuery);
	tinymce.init({
	selector: '.textarea',
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
	function sendMessage()
	{
		var text = $('textarea#messagetext').val();
		var file = $('input#attachment').val();
		if(text == '' && file == ''){
			informX("You can't send an empty message")
		}else{
		if(text != '' && file != '')
		{
			file = $('input#attachment')[0].files[0]['name'];
			var filename = $('input[name="attachmentfilename"]').val();
			var body = '<div class="col-md-12">'+
								'<div class="col-md-2 ">'+
										'<label class="pull-right top10 simg">ME</label>'+
										'<small>Author</small>'+
								'</div>'+
								'<div class="col-md-10 message msg" style="background:#d1f2cc">'+text+'</div>'+
								'<br>'+
								'<div class="col-md-10 pull-right afile">'+
										'<span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: '+file+'</small></span><small class="pull-right"><a href="{{ url("comments/".@$abstract->event_id) }}/'+filename+'" target="_blank"><i class="fa fa-download"></i> [Download]</a></small>'+
								'</div>'+
						'</div>';
		}
		if(text != '' && file == '')
		{
			var body = '<div class="col-md-12">'+
									'<div class="col-md-2 ">'+
											'<label class="pull-right top10 simg">ME</label>'+
											'<small>Author</small>'+
									'</div>'+
									'<div class="col-md-10 message msg" style="background:#d1f2cc">'+text+'</div>'+
							'</div>';
		}
		if(text == '' && file != '')
		{
		file = $('input#attachment')[0].files[0]['name'];
		var filename = $('input[name="attachmentfilename"]').val();
			var body = '<div class="col-md-12">'+
								'<div class="col-md-2 ">'+
										'<label class="pull-right top10 simg">ME</label>'+
										'<small>Author</small>'+
								'</div>'+
								'<br>'+
								'<div class="col-md-10 pull-right afile">'+
										'<span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: '+file+'</small></span><small class="pull-right"><a href="{{ url("comments/".@$abstract->event_id) }}/'+filename+'" target="_blank"><i class="fa fa-download"></i> [Download]</a></small>'+
								'</div>'+
						'</div>';
		}
		var myForm = document.getElementById('commentsform');
var formData = new FormData(myForm);
		$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
	}
});
		$.ajax({
		type: 'POST',
	url: '{{ url("comment/submit/".@$paper->paper_id) }}',
	data: formData,
	dataType: 'json',
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function(xhr) {
	//loading ajax animation
		$('#sendmsg').html('<img src="https://static-v.tawk.to/a-v3-33/images/ajax-loader-3.gif"> Sending');
	},
	success: function (response) {
		var target = document.getElementById('mCSB_1_container');
				$(target).append(body);
				$("#comments").mCustomScrollbar("scrollTo","bottom",{
			scrollInertia:250
		});
				$('textarea#messagetext').val('');
				$('#removeattachment').click();
				$('#sendmsg').html('<i class="glyphicon glyphicon-send"></i> Send');
	},
	error: function (response) {
	if(response.responseText != ''){
			informX('<strong style="color:red;border-bottom:2px #f1f1f1 solid">Error</strong><br>'+response.responseText);
		}
	}
	});
		}
	}
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
                
                $('#blindfile').on('change', function(){
			var file = $(this)[0].files[0]['name'];
			if(file){
				$('#blindfilenamef').html(file);
				$('#blindremovef').removeClass('hidden');
			}else{
				$('#blindfilenamef').html('No file');
				$('#blindremovef').addClass('hidden');
			}
		});
                
                $('#blindremovef').on('click', function(){
			$('#blindfile').val('');
			$('#blindfilenamef').html('No file');
			$('#blindremovef').addClass('hidden');
		});
                
		$('#attachment').on('change', function(){
			var file = $(this)[0].files[0]['name'];
			$('input[name="attachmentname"]').val(file);
			var filename = makeid()+ext(file);
			$('input[name="attachmentfilename"]').val(filename);
			if(file){
				$('#attachmentname').html('<i class="glyphicon glyphicon-paperclip"></i> Attachment: '+file);
				$('#attachmentname').slideDown();
				$('#removeattachment').removeClass('hidden');
			}else{
				$('#attachmentname').html('');
				$('#attachmentname').slideUp();
				$('#removeattachment').addClass('hidden');
			}
		});
		$('#removeattachment').on('click', function(){
			$('#attachment').val('');
			$('#attachmentname').html('');
			$('#removeattachment').addClass('hidden');
			$('input[name="attachmentname"]').val('');
			$('input[name="attachmentfilename"]').val('');
		});
	});
    function toDiv(id, speed, alarm) {
        $('html, body').animate({
            scrollTop: $("#" + id).offset().top
        }, speed);
        if (alarm == 0) {
        } else {
            $("#" + id).css({'transition': '0.3s'});
            setTimeout(function () {
                $("#" + id).css({'box-shadow': '0px 0px 250px 0px rgba(255,0,0,0.2)', 'color': 'red'})
            }, speed);
            setTimeout(function () {
                $("#" + id).css({'box-shadow': '0px 0px 0px 0px rgba(255,0,0,0.2)', 'color': '#666'})
            }, speed * 1.5);
            setTimeout(function () {
                $("#" + id).css({'box-shadow': '0px 0px 250px 0px rgba(255,0,0,0.2)', 'color': 'red'})
            }, speed * 2);
            setTimeout(function () {
                $("#" + id).css({'box-shadow': '0px 0px 0px 0px rgba(255,0,0,0.2)', 'color': '#666'})
            }, speed * 2.5);
            setTimeout(function () {
                $("#" + id).css({'box-shadow': '0px 0px 250px 0px rgba(255,0,0,0.2)', 'color': 'red'})
            }, speed * 3);
            setTimeout(function () {
                $("#" + id).css({'box-shadow': '0px 0px 0px 0px rgba(255,0,0,0.2)', 'color': '#666'})
            }, speed * 3.5);
        }
    }
	function submitAbstract()
	{
		var topic 	= $('#topic_id').val();
		var title 	= $('input[name=abstract_title').val();
		var content = tinymce.get('content').getContent();
		$('#content').text(content);
		var file 	= $('#abstractfile').val();
		var myForm = document.getElementById('submit_form');
		var formData = new FormData(myForm);
		$('#topic_id').css('border','1px #ccc solid');
		$('input[name=abstract_title]').css('border','1px #ccc solid');
		if(topic == 0 || title == '')
		{
			informX('Please fill the required data.');
			if(topic == 0){
				$('#topic_id').css('border','1px red solid');
			}
			if(title == ''){
				$('input[name=abstract_title]').css('border','1px red solid');
			}
			toDiv('topic_id', 250, 0);
		}else if(content == '' && file == ''){
			informX('You must enter content or upload abstract file.');
		}else{
			if($('#terms').is(':checked')){
				$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			}
		});
		$.ajax({
			type: 'POST',
			url: '{{ url("abstract/submit") }}',
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function(xhr) {
			//loading ajax animation
			$('#aloading').removeClass('hide');
			},
			success: function (response) {
				$('#aloading').addClass('hide');
				console.log(response);
				window.open('/abstract/status/'+response,'_self');
			},
			error: function (response) {
			$('#aloading').addClass('hide');
			if(response.responseText != ''){
					informX('<strong style="color:red;border-bottom:2px #f1f1f1 solid">Error</strong><br>'+response.responseText);
				}
			}
			});
			}else{
				toDiv('inst', 250, 1);
				setTimeout(informX('<span style="color:red">Please Confirm you read instructions before submit.</span>'), 1000)
			}
		}
	}
	function submitPaper()
	{
		var title 	= $('input[name=paper_title').val();
		var file 	= $('#fullfile').val();
                var blindfile 	= $('#blindfile').val();
	var myForm = document.getElementById('paper_form');
var formData = new FormData(myForm);
		$('input[name=paper_title]').css('border','1px #ccc solid');
		if(title == '')
		{
			informX('Please fill the required data.');
			$('input[name=paper_title]').css('border','1px red solid');
		}else if(file == ''){
			informX('Please select paper upload file.');
		}else if(blindfile == ''){
			informX('Please select blind paper upload file.');
		}
                else if (!$("input[name='paper_kind']:checked").val()) 
                {
                    informX("please select paper type");
                }

                else{
			if($('#termsf').is(':checked')){
				$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			}
		});
				$.ajax({
				type: 'POST',
			url: '{{ url("fullpaper/submit/".@$abstract->abstract_id) }}',
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function(xhr) {
			//loading ajax animation
			$('#ploading').removeClass('hide');
			},
			success: function (response) {
			$('#ploading').addClass('hide');
			if(response == 101){

				informX('<strong style="color:red;border-bottom:2px #f1f1f1 solid">Error</strong><br><p>Uploaded file must be minimum 25 MB and maximum 50 MB in MS Word formate</p>');
			}else{
				console.log(response);
				window.open('/fullpaper/status/'+response,'_self');
			}
			},
			error: function (response) {
			$('#ploading').addClass('hide');
			if(response.responseText != ''){
				var err = response.responseText;

					informX('<strong style="color:red;border-bottom:2px #f1f1f1 solid">Error</strong><br>'+err);
				}
			}
			});
			}else{
				toDiv('instf', 250, 1);
				setTimeout(informX('<span style="color:red">Please Confirm you read instructions before submit.</span>'), 1000)
			}
		}
	}

	function add_coauthor()
	{
		$('input[name=co_name]').css('border','1px #ccc solid');
		$('input[name=co_email]').css('border','1px #ccc solid');
		var name 	= $('input[name=co_name]').val();
		var email 	= $('input[name=co_email]').val();
		var myForm = document.getElementById('coauthors_form');
		var formData = new FormData(myForm);
		if(name == '' || email == '')
		{
			informX('Please fill the required data.');
			if(name == ''){
				$('input[name=co_name]').css('border','1px red solid');
			}
			if(email == ''){
				$('input[name=co_email]').css('border','1px red solid');
			}
		}else{
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			}
		});
		$.ajax({
			type: 'POST',
			url: '{{ url("fullpaper/add_coauthor") }}',
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function(xhr) {
			//loading ajax animation
				$('#caloading').removeClass('hide');
			},
			success: function (response) {
				$('#caloading').addClass('hide');
				var old = $('#theco').html();
				$('#cothers').removeClass('hide');
				$('#nocowar').addClass('hide');
				$('#theco').html(old+'<tr id="coauthor'+response+'"><td>'+name+'</td><td>'+email+'</td><td><a class="btn" style="color:red" onclick="removeCo('+response+')">Remove</a></td></tr>');
				$('input[name=co_name]').val('');
				$('input[name=co_email]').val('');
				returnN('Co-Author added successfully','green',5000);
			},
			error: function (response) {
				$('#caloading').addClass('hide');
				if(response.responseText != ''){
					informX('<strong style="color:red;border-bottom:2px #f1f1f1 solid">Error</strong><br>'+response.responseText);
				}
			}
		});
		}
	}
	function removeCo(id){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			}
		});
		$.ajax({
			type: 'POST',
			url: '{{ url("fullpaper/remove_coauthor") }}/'+id,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function(xhr) {
			//loading ajax animation
			},
			success: function (response) {

			},
			error: function (){

			}
		});
		$('#coauthor'+id).remove();
	}
</script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
</script>
@endpush
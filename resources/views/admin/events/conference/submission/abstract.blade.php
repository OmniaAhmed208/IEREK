@extends('admin.layouts.master')
@section('panel-title')Abstract View @endsection
<?php
    $status = array(
        0 => 'Abstract Pending Approval',
        1 => 'Abstract Under Revision',
        2 => '<span style="color:green">Abstract Accepted</span>',
        3 => 'Upload Your Full Paper',
        4 => 'Full Paper Pending Approval',
        5 => '<span style="color:green">Full Paper Approved</span>',
        6 => 'Full Paper Awaiting Reviewers Decision',
        7 => '<span style="color:green">Full Paper Accepted</span>',
        8 => '<span style="color:red">Full Paper Rejected</span>',
        9 => '<span style="color:red">Abstract Rejected</span>'
    );
?>
@section('title') {{ $abstract->title }}@endsection
@section('return-url'){{'/admin/events/conference/submission/'.$abstract->event_id}}@endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{ $abstract->title }} [<?php echo $status[$abstract->status]; ?>]
                    <div class="pull-right row">
                		<a href="/admin/events/conference/abstract/approve/{{ $abstract->abstract_id }}" class="btn btn-success btn-sm @if($abstract->status > 0){{ 'hidden' }}@endif">Approve</a>
                        <a href="/admin/events/conference/abstract/reject/{{ $abstract->abstract_id }}" class="btn btn-danger btn-sm @if($abstract->status > 1){{ 'hidden' }}@endif">Reject</a>
                	</div>
                	</h3>
                </div>
                <div class="panel-body">
                	<div class="col-md-12"><h3>File: <small style="font-size:15px;">{{ $abstract->file }}</small> @if($abstract->file != 'No File') 
                                <a href="{{url('file/1/'.$abstract->abstract_id)}}" class="btn btn-success btn-sm pull-right">Download</a> 
                                @endif</h3></div>
                    <h3>@if($abstract->status != 9 && $abstract->status < 2)    
                    <div class="col-md-12 row" style="padding:0;margin:0;">
                        <form method="post" action="/admin/events/conference/abstract/sc">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="abstract_id" value="{{ $abstract->abstract_id }}">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-3" style="padding:0;margin:0;">Reviewer: </label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="reviewer_id">
                                                <option value="0">Choose Scientific Committee</option>
                                                @foreach($scs as $sc)
                                                    <option @if($sc->user_id == $abstract->reviewer_id) {{ 'selected' }} @endif value="{{ $sc->user_id }}">{{ $sc->first_name.' '.$sc->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-3" style="padding:0;margin:0;">Expire Date: </label>
                                        <div class="input-group col-md-9" id="expire_date">
                                            <?php $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y'))); ?>
                                            <input type="text" name="expire" class="form-control datepicker"  value="{{ $date }}">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="btn btn-success btn-block" type="submit" value="@if($abstract->reviewer_id == '') {{ 'Assign' }} @else {{ 'Re Assign' }} @endif">
                                    </div>
                                    <div class="clear-fix"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                    </h3>
                    <h3>@if($abstract->status != 9 && $abstract->status < 2)
                    <div class="col-md-12 row" style="padding:0;margin:0;">
                        
                        <form method="post" action="/admin/events/conference/abstract_as/sc">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="abstract_id" value="{{ $abstract->abstract_id }}">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-3" style="padding:0;margin:0;">Accept: </label>
                                        <div class="col-md-9">  
                                            <select class="form-control" name="reviewer_id">
                                                <option value="0">Choose Scientific Committee</option>
                                                @foreach($scs as $sc)
                                                    <option @if($sc->user_id == $abstract->reviewer_id) {{ 'selected' }} @endif value="{{ $sc->user_id }}">{{ $sc->first_name.' '.$sc->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="btn btn-success btn-block" type="submit" value="{{ 'Accept' }}">
                                    </div>
                                    <div class="clear-fix"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                	<div class="col-md-12">Topic: <small style="font-size:15px;">{{ $topic }}</small></div>
                	<div class="col-md-12">Content: @if($abstract->abstract == '') <small style="font-size:15px;">No Content</small> @endif</div>
                	<div class="col-md-12"><?php echo $abstract->abstract; ?></div>
                    </h3>
                </div>
                <div class="panel-footer">
                	<div class="pull-right row">
                		<a href="/admin/events/conference/abstract/approve/{{ $abstract->abstract_id }}" class="btn btn-success btn-sm @if($abstract->status > 0){{ 'hidden' }}@endif">Approve</a>
                        <a href="/admin/events/conference/abstract/reject/{{ $abstract->abstract_id }}" class="btn btn-danger btn-sm @if($abstract->status > 1){{ 'hidden' }}@endif">Reject</a>
                	</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>
                    Abstract History
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Reviewer</th>
                                <th>Comment</th>
                                <th>Expire</th>
                                <th>Action Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $h)
                            <tr>
                                <td>{{$h->title}}</td>
                                <td>{{$h->users['first_name'].' '.$h->users['last_name']}}</td>
                                <td>{{$h->comment}}</td>
                                <td>@if($h->updated_at != ''){{date('Y-m-d',strtotime($h->updated_at))}}@endif</td>
                                <td>{{$h->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('table').each(function(){
				$(this).addClass('table');
				$(this).addClass('table-striped');
				$(this).addClass('table-hover');
				$(this).addClass('table-bordered');
				$(this).addClass('table-condensed');
			});
		})
	</script>
@endpush

@extends('admin.layouts.master')
@section('return-url'){{url('/admin')}}@endsection
@section('panel-title') Manage Mails @endsection
@section('content')
	<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-hover datatable table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Trigger</th>
                                <th>BCC</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
							@if(isset($templates))
								@foreach($templates as $template)
								<tr>
									<td>{{ $template->mail_id }}</td>
									<td>{{ $template->title }}</td>
									<td>{{ $template->trigger }}</td>
									<td>
									<?php 
										$bccs = explode(',',$template->bcc_mails); ?>
										@for($i = 0; $i < count($bccs); $i++)
											<span class="label label-info">{{ $bccs[$i] }}</span>
										@endfor 
									</td>
									<td>
									@if($template->inactive == 0)
										<span class="label label-success">Active</span> 
									@else
										<span class="label label-danger">Inactive</span>
									@endif
									</td>
									<td><a href="{{ url('admin/mail/'.$template->mail_id) }}" class="btn btn-default">Manage</a></td>
								</tr>
								@endforeach
							@endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')Conference Admins 
	<small  data-toggle="tooltip" data-placement="bottom" title="{{ $event['title_en'] }}">{{ substr($event['title_en'], 0,45) }}@if( strlen($event['title_en']) > 45 ){{ '...' }} @endif</small>@endsection
@section('content')
<div class="panel">
	<form class="form-horizontal" method="post" id="create_form" action="{{ route('updateConferenceAdmins', $event['event_id']) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="put">
        <input type="hidden" id="confArray" name="confArray" value="@foreach($eAdmins as $eAdmin) {{ $eAdmin->user_id.',' }} @endforeach">
        <input type="hidden" id="confDelArray" name="confDelArray" value="">
		<div class="panel-body" id="conf_a">
		    <p>Choose from list of <strong>admins</strong> to asgin or remove admins of conference.</p>
		    <div class="col-md-12">
		        <div class="col-md-6">
		            <!-- SC LIST -->
		            <div class="panel panel-default">
		                <div class="panel-heading">
		                    <h3 class="panel-title">Admins List</h3>
		                </div>
		                <div class="panel-body list-group list-group-contacts" id="alist" style="max-height:300px;overflow:auto">
		                @foreach($uAdmins as $uAdmin)
		                    <a style="cursor:default" class="list-group-item" data-cond="alist" data-toggle="tooltip" data-placement="bottom" title="Click to move admin">
		                        <div class="list-group-status status-offline"></div>
		                        <span class="contacts-title">{{ $uAdmin->first_name. ' ' .$uAdmin->last_name }}</span>
		                        <p>{{ $uAdmin->user_type->description }}</p>
		                        <input type="hidden" class="cAdmin" value="{{ $uAdmin->user_id }}" placeholder="">
		                    </a>
						@endforeach
		                </div>
		            </div>
		            <!-- END SC LIST -->
		        </div>
		        <div class="col-md-6">
		            <!-- SC LIST -->
		            <div class="panel panel-default">
		                <div class="panel-heading">
		                    <h3 class="panel-title">Conference Admins</h3>
		                </div>
		                <div class="panel-body list-group list-group-contacts" id="confa" style="max-height:300px;overflow:auto">
		                @foreach($eAdmins as $eAdmin)
		                    <a style="cursor:default" class="list-group-item"  data-cond="confa" data-toggle="tooltip" data-placement="bottom" title="Click to move admin">
		                        <div class="list-group-status status-online"></div>
		                        <span class="contacts-title">{{ $eAdmin->users['first_name']. ' ' .$eAdmin->users['last_name'] }}</span>
		                        <p>Studies {{ $eAdmin->users->user_type->description }}</p>
		                        <input type="hidden" class="cAdmin" value="{{ $eAdmin->user_id }}" placeholder="">
		                    </a>
						@endforeach
		                </div>
		            </div>
		            <!-- END SC LIST -->
		        </div>
		    </div>
		</div>
		<div class="panel-footer">                                                                        
		    <button class="btn btn-default pull-right" id="update">Update<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
		</div>
	</form>
</div>
@endsection
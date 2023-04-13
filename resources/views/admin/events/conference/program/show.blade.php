@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')Manage Conference Fees <small>{{ $event }}</small><br><br><small>Currency: <span style="color:darkgreen;font-weight:700;background:#fff;padding:0.25em;border-radius:5px;">@if($event_currency == ''){{'Not Set'}}@else{{$event_currency}}@endif</span></small> @endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-2 pull-right">
                        <a href="/admin/events/conference/fees/create/{{ $event_id }}" class="btn btn-success btn-block"><span class="fa fa-plus"></span> Add conference program</a>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">
    </div>
    
</div>
@endsection
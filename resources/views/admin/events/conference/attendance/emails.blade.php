@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')Manage Conference Attendance <small>{{ $event->title_en }}</small>@endsection
@section('content')	
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
    
        	<div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Conference Registered Users</h3>
                </div>
                <div class="panel-body">
            	
                    <table class="table table-hover table-striped datatable">
                        <thead>
                            <tr>
                                 <th>User id</th>
                                <th>Name</th>
                                <th>Email</th>
                                
                               
                            </tr>
                        </thead>
                        <tbody>
                                @if(isset($emails))
                                    @foreach($emails as $email)
                                        <tr>
                                            <td>
                                            {{$email->user_id}}
                                            <td>
                                                {{$email->first_name}}
                                            </td>
                                            <td>
                                                 {{$email->email}}
                                            </td>
                                           
                                        </tr>
                                    @endforeach
                                @else
                                    {{ 'There is no attendances for this conferences' }}
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>	
@endsection
@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')Manage Conference Submissions <small>{{ $event }}</small>@endsection
@section('content')	
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Abstracts</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Submission Date</th>
                                <th>Title</th>
                                <th>User</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Expire</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($abstracts as $abstract)
                            <?php 
                                $str = strtotime(date("Y-m-d")) - (strtotime($abstract->expire));
                                $diff = floor(($str/3600/24) * -1 );
                            ?>
                            <tr class="@if($diff < -5 && $diff > -10000 && $abstract->status < 3) danger @elseif($diff < -10000) @elseif($diff < 0 && $diff > -5) warning @elseif($diff > 0) success @endif" style="@if($abstract->status >= 2) background:#e1e1e1 @endif">
                                <td>{{ $abstract->created_at }}</td>
                                <td>{{ $abstract->title }}</td>
                                <td>{{ $abstract['users']->first_name.' '.$abstract['users']->last_name }}</td>
                                <td>{{ $abstract->code }}</td>
                                <td>
                                    <?php
                                        $status = array(
                                            0 => 'Abstract Pending Approval',
                                            1 => 'Abstract Under Revision',
                                            2 => 'Abstract Accepted',
                                            3 => 'Upload Your Full Paper',
                                            4 => 'Full Paper Pending Approval',
                                            5 => 'Full Paper Approved',
                                            6 => 'Full Paper Awaiting Reviewers Decision',
                                            7 => 'Full Paper Accepted',
                                            8 => 'Full Paper Rejected',
                                            9 => 'Abstract Rejected'
                                        );
                                    ?>
                                    {{ $status[$abstract->status] }}
                                </td>
                                <td>
                                @if($diff < 0 && $diff > -17000)<small>({{ $diff }} days)</small> @elseif($diff > 0) {{ $diff }} days <small>({{ date('d M, Y', strtotime(@$abstract->expire)) }})@else  @endif {{@$abstract['reviewer']->first_name.' '.@$abstract['reviewer']->last_name}}</small>
                                </td>
                                <td>
                                    <a href="/admin/events/conference/abstract/approve/{{ $abstract->abstract_id }}" class="btn btn-success btn-sm @if($abstract->status > 0){{ 'hidden' }}@endif">Approve</a>
                                    <a href="/admin/events/conference/abstract/reject/{{ $abstract->abstract_id }}" class="btn btn-danger btn-sm @if($abstract->status > 1){{ 'hidden' }}@endif">Reject</a>
                                    <a href="/admin/events/conference/abstract/{{ $abstract->abstract_id }}" class="btn btn-default btn-sm">Manage</a>
                                    @if($abstract->status > 3) <a href="/admin/events/conference/paper/{{ @$abstract['paper']->paper_id }}" class="btn btn-info btn-sm">Paper</a> @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Full Papers</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Submission Date</th>
                                <th>Title</th>
                                <th>User</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($papers as $paper)
                            <tr class="
                                <?php
                                    $color = array(
                                        0 => 'info',
                                        1 => '',
                                        2 => 'warning',
                                        3 => 'success',
                                        4 => 'danger'
                                    );
                                ?>
                                {{ $color[$paper->status] }}
                            ">
                                <td>{{ $paper->created_at }}</td>
                                <td>{{ $paper->title }}</td>
                                <td>{{ $paper['users']->email }}</td>
                                <td>{{ $paper->code }}</td>
                                <td>
                                    <?php
                                        $status = array(
                                            0 => 'Pending Approval',
                                            1 => 'Approved',
                                            2 => 'Awaiting Reviewers Decision',
                                            3 => 'Accepted',
                                            4 => 'Rejected'
                                        );
                                    ?>
                                    {{ $status[$paper->status] }}
                                </td>
                                <td>
                                    <a href="/admin/events/conference/paper/approve/{{ $paper->paper_id }}" class="btn btn-success btn-sm @if($paper->status > 0){{ 'hidden' }}@endif">Approve</a>
                                    <a href="/admin/events/conference/paper/reject/{{ $paper->paper_id }}" class="btn btn-danger btn-sm  hide @if($paper->status > 0){{ 'hidden' }}@endif">Reject</a>
                                    <a href="/admin/events/conference/paper/{{ $paper->paper_id }}" class="btn btn-default btn-sm">Manage</a>
                                    <a href="/admin/events/conference/abstract/{{ $paper->abstract_id }}" class="btn btn-warning btn-sm">Abstract</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    function windowOpen(url){
        window.open (url,"mywin","resizable=0,width=1024");
    }
    $(document).ready(function(){
        @if(Session::has('close'))
            window.close();
        @endif
    });
</script>
@endpush
@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')
   Announcements
@endsection


@section('content')
    <div class="row col-md-12">
        <div class="panel panel-default tabs">
                <div class="panel-body">
                    <table class="table table-hover table-striped
                    @if(count($announcements) > 0)
                            datatable
                        @endif
                    ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Url</th>
                                <th>Active/InActive</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($announcements) > 0)
                                @foreach($announcements as $announcement)
                                <tr>
                                    <td>{{$announcement->announce_position}}</td>
                                    <td>
       <img id="image-view" class="img-responsive img-thumbnail" src="{{asset('/storage/uploads/announcement/'.$announcement->announce_image)}}" style="max-height:120px;max-width:100px;border:1px #a97f18 solid;margin-bottom:10px;">
                                    </td>
                                    <td>{{ $announcement->announce_url}}</td>
                                    <td>
                                        @if($announcement->announce_active == 0)
                                        {{"Active"}}
                                        @else
                                        {{ "In Active"}}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a style="cursor:pointer;color:green" href="{{ route('editAnnouncement', $announcement->announce_id) }}">Edit</a>
                                                </li>
                                                <li>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['deleteAnnouncement', $announcement->announce_id]]) !!}
                                                    <input type="hidden" name="announcement_id" value="{{ $announcement->announce_id }}">
                                                    {!! Form::button( 'Delete<i class="fa fa-trash fa-lg"></i>', ['type' => 'submit',
                                                    'class' => 'btn btn-default btn-block delete_topic', 'style' => 'border:none!important;border-radius:0px;text-align:left;color:red', 'data-id' => $announcement->announce_id] ) !!}
                                                    {!! Form::close() !!}
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                    <td colspan="4" style="text-align: center;">No announcements found</td>
                                @endif
                        </tbody>
                    </table>

                    <div class="panel-footer">
                        <div class="col-md-4 pull-right">
                            <div class="btn-group" style="float:right">
                                <a href="{!! route('createAnnouncement') !!}" id="add_new_announcement" class="btn btn-success">
                                    <span class="fa fa-plus"></span> New Announcement
                                </a>
                            </div>
                            <div class="pull-right">&ensp;</div>
                            @if(count($announcements) > 1)
                            <div class="btn-group" style="float:right">
                                <a href="{{ route('orderAnnouncements', @$announcement->announce_id) }}" id="order_announcement" class="btn btn-default">
                                    <span class="fa fa-list"></span> Reorder
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
    </div>

@endsection
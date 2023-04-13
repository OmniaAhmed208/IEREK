@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')
    Conference Topics <small>{{ $event['title_en'] }}</small>
@endsection


@section('content')
    <div class="row col-md-12">
        <div class="panel panel-default tabs">
                <div class="panel-body">
                    <table class="table table-hover table-striped
                    @if(count($topics) > 0)
                            datatable
                        @endif
                    ">
                        <thead>
                            <tr>
                                <th>Pos</th>
                                <th>Title</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($topics) > 0)
                                @foreach($topics as $topic)
                                <tr>
                                    <td>{{ $topic->position }}</td>
                                    <td>{{ $topic->title_en }}</td>
                                    <td>{{ $topic->created_at->format('j M, Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a style="cursor:pointer;color:green" href="{{ route('editConferenceTopics', $topic->topic_id) }}">Edit</a>
                                                </li>
                                                <li>
                                                    {!! Form::open(['method' => 'DELETE',
                                                    'route' => ['deleteConferenceTopics', $topic->topic_id]]) !!}
                                                    <input type="hidden" name="event_id" value="{{ $topic->event_id }}">
                                                    {!! Form::button( 'Delete<i class="fa fa-trash fa-lg"></i>', ['type' => 'submit',
                                                    'class' => 'btn btn-default btn-block delete_topic', 'style' => 'border:none!important;border-radius:0px;text-align:left;color:red', 'data-id' => $topic->topic_id] ) !!}
                                                    {!! Form::close() !!}
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                    <td colspan="4" style="text-align: center;">No topics found</td>
                                @endif
                        </tbody>
                    </table>

                    <div class="panel-footer">
                        <div class="col-md-4 pull-right">
                            <div class="btn-group" style="float:right">
                                <a href="{!! route('createConferenceTopics') !!}" id="add_new_topic" class="btn btn-success">
                                    <span class="fa fa-plus"></span> New Topic
                                </a>
                            </div>
                            <div class="pull-right">&ensp;</div>
                            @if(count($topics) > 1)
                            <div class="btn-group" style="float:right">
                                <a href="{{ route('orderConferenceTopics', @$topic->event_id) }}" id="order_topic" class="btn btn-default">
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
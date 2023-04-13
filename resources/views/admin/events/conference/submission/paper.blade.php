@extends('admin.layouts.master')
@section('return-url'){{ '/admin/events/conference/submission/'.$paper->event_id }}@endsection
@section('panel-title')Full Paper Manage <small>{{ $paper->title }}</small> @endsection
@section('content')
<style rel="stylesheet" type="text/css">
    .message{
        padding: 1em;
        margin: 0.79em 0;
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
<div class="page-content-wrap">
    <div class="row col-md-8">

        <div class="panel">
            <div class="panel-heading">
                <h3>Paper Reviewers</h3>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <th>Reviewer</th>
                        <th>Expire</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($reviewers as $rev)
                            <?php 
                                $str = strtotime(date("Y-m-d")) - (strtotime($rev->expire));
                                $diff = floor(($str/3600/24) * -1 );
                            ?>
                            <tr  class="@if($rev->result == NULL) @if($diff < 0 && $diff < -5) danger @elseif($diff >= -5 && $diff < 0) warning @elseif($diff > 0) success @endif @endif">
                                <td><a href="/admin/all-users/profile/{{$rev['reviewer']->user_id}}" target="_blank">{{$rev['reviewer']->first_name.' '.$rev['reviewer']->last_name}}</a></td>
                                <td>@if($rev->result == NULL) @if($diff >= 0) {{ $diff }} days <small>({{ date('d M, Y', strtotime(@$rev->expire)) }})@else {{ $diff }} Days <small>({{ date('d M, Y', strtotime(@$rev->expire)) }}) @endif @endif</td>
                                <td>@if($rev->result == 1) Accepted @elseif($rev->result == 2) Accepted with comments @elseif($rev->result == 3) Rejected @elseif($rev->result == 4) I'm busy @elseif($rev->result == 5) Conflict of interest @elseif($rev->result == 6) Not in my domain @else Not Set @endif</td>
                                <td><a href="/admin/events/conference/review/{{$rev->id}}" target="_blank" class="btn btn-default">View</a></td>
                            </tr>
                        @endforeach
                    <!-- @foreach($scxs as $scx)
                        @if($paper->first_reviewer == $scx->user_id)
                            <?php 
                                $str = strtotime(date("Y-m-d")) - (strtotime($paper->expire_first));
                                $diff = floor(($str/3600/24) * -1 );
                            ?>
                            <tr class="@if($paper->result_first == NULL) @if($diff < 0 && $diff < -5) danger @elseif($diff >= -5 && $diff < 0) warning @elseif($diff > 0) success @endif @endif" style="@if($paper->result_first != NULL) background-color: silver @endif">
                                <td>{{ $scx['users']->first_name.' '.$scx['users']->last_name }}</td>
                                <td>{{ $scx['users']->email }}</td>
                                <td>{{ $scx['users']->phone }}</td>
                                <?php 
                                    $str = strtotime(date("Y-m-d")) - (strtotime($paper->expire_first));
                                    $diff = floor(($str/3600/24) * -1 );
                                ?>
                                <td>@if($diff >= 0) {{ $diff }} Days <small>({{ date('d M, Y', strtotime(@$paper->expire_first)) }})@else {{ $diff }} Days <small>({{ date('d M, Y', strtotime(@$paper->expire_third)) }}) @endif</small></td>
                                <?php
                                $status = array(
                                    NULL => 'N/A',
                                    1 => 'Faild',
                                    2 => 'Passed'
                                );
                                ?>
                                <td><?php echo @$status[$paper->result_first] ?></td>
                                <td><?php if($paper->mark_first == NULL){echo 'N/A';}else{echo $paper->mark_first.'/10';} ?></td>
                                <td><a href="/admin/events/conference/paper/{{ $paper->paper_id }}/{{ $paper->first_reviewer }}/first_reviewer/remove" class="btn btn-sm btn-default @if($paper->status == 3) hidden @endif">Remove</a></td>
                            </tr>
                        @endif
                        @if($paper->second_reviewer == $scx->user_id)
                            <?php 
                                $str = strtotime(date("Y-m-d")) - (strtotime($paper->expire_second));
                                $diff = floor(($str/3600/24) * -1 );
                            ?>
                            <tr class="@if($paper->result_second == NULL) @if($diff < 0 && $diff < -5) danger @elseif($diff >= -5 && $diff < 0) warning @elseif($diff > 0) success @endif @endif" style="@if($paper->result_second != NULL) background-color: silver @endif">
                                <td>{{ $scx['users']->first_name.' '.$scx['users']->last_name }}</td>
                                <td>{{ $scx['users']->email }}</td>
                                <td>{{ $scx['users']->phone }}</td>
                                <?php 
                                    $str = strtotime(date("Y-m-d")) - (strtotime($paper->expire_second));
                                    $diff = floor(($str/3600/24) * -1 );
                                ?>
                                <td>@if($diff >= 0) {{ $diff }} Days <small>({{ date('d M, Y', strtotime(@$paper->expire_second)) }})@else {{ $diff }} Days <small>({{ date('d M, Y', strtotime(@$paper->expire_third)) }}) @endif</small></td>
                                <?php
                                $status = array(
                                    NULL => 'N/A',
                                    1 => 'Faild',
                                    2 => 'Passed'
                                );
                                ?>
                                <td><?php echo @$status[$paper->result_second] ?></td>
                                <td><?php if($paper->mark_second == NULL){echo 'N/A';}else{echo $paper->mark_second.'/10';} ?></td>
                                <td><a href="/admin/events/conference/paper/{{ $paper->paper_id }}/{{ $paper->second_reviewer }}/second_reviewer/remove" class="btn btn-sm btn-default @if($paper->status == 3) hidden @endif>Remove">Remove</a></td>
                            </tr>
                        @endif
                        @if($paper->third_reviewer == $scx->user_id)
                            <?php 
                                $str = strtotime(date("Y-m-d")) - (strtotime($paper->expire_third));
                                $diff = floor(($str/3600/24) * -1 );
                            ?>
                            <tr class="@if($paper->result_third == NULL) @if($diff < 0 && $diff < -5) danger @elseif($diff >= -5 && $diff < 0) warning @elseif($diff > 0) success @endif @endif" style="@if($paper->result_third != NULL) background-color: silver @endif">
                                <td>{{ $scx['users']->first_name.' '.$scx['users']->last_name }}</td>
                                <td>{{ $scx['users']->email }}</td>
                                <td>{{ $scx['users']->phone }}</td>
                                <?php 
                                    $str = strtotime(date("Y-m-d")) - (strtotime($paper->expire_third));
                                    $diff = floor(($str/3600/24) * -1 );
                                ?>
                                <td>@if($diff >= 0) {{ $diff }} Days <small>({{ date('d M, Y', strtotime(@$paper->expire_third)) }})@else {{ $diff }} Days <small>({{ date('d M, Y', strtotime(@$paper->expire_third)) }}) @endif</small></td>
                                <?php
                                $status = array(
                                    NULL => 'N/A',
                                    1 => 'Faild',
                                    2 => 'Passed'
                                );
                                ?>
                                <td><?php echo @$status[$paper->result_third] ?></td>
                                <td><?php if($paper->mark_third == NULL){echo 'N/A';}else{echo $paper->mark_third.'/10';} ?></td>
                                <td><a href="/admin/events/conference/paper/{{ $paper->paper_id }}/{{ $paper->third_reviewer }}/third_reviewer/remove" class="btn btn-sm btn-default @if($paper->status == 3) hidden @endif>Remove">Remove</a></td>
                            </tr>
                        @endif
                    @endforeach -->
                    </tbody>
                </table>
                <div class="col-md-12">
                    <form method="post" action="/admin/events/conference/paper/{{$paper->paper_id}}/assign">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-md-4">
                            <label>Reviewer:</label>
                            <select class="form-control select" name="reviewer_id">
                                <option value="0">Choose Reviewer</option>
                                @foreach($scs as $sc)
                                    <option value="{{ $sc->user_id }}">{{ $sc['users']->first_name.' '.$sc['users']->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            
                            <label>Expire: </label>
                                <?php $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y'))); ?>
                                <input type="text" name="expire" class="form-control datepicker" value="{{ $date }}">
                        </div>
                        <div class="col-md-3">
                            <label style="color:transparent" class="col-md-12">.</label>
                            <label class="check"><input type="checkbox" class="icheckbox" name="email" value="1" /> Send Email</label>
                        </div>
                        <div class="col-md-2">
                            <label style="color:transparent" class="col-md-12">.</label>
                            <input type="submit" class="btn btn-success btn-block" name="submit" value="Assign">
                        </div>
                    </form>
                </div>
            </div>
        </div>  
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="panel">
            <div class="panel-heading">
                <h3>Reviewer Edition</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="/admin/events/conference/reviewer_edition/{{$paper->paper_id}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="event_id" value="{{$paper->event_id}}">
                    <input type="hidden" name="paper_id" value="{{$paper->paper_id}}">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Reviewer Edition</label>
                        <div class="col-md-6 col-xs-12">
                            <a href="{{url('/storage/uploads/conferences/')}}{{'/'.$paper->event_id}}{{'/'.$paper->paper_id}}{{'/reviewer_edition.docx'}}" target="_blank">Download</a>                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">New Edition</label>
                        <div class="col-md-6 col-xs-12">                                                
                            <input type="file" accept=".docx,.doc" class="image_file" name="reviewer_edition" class="form-control" />
                        </div>
                    </div>
            </div>
            <div class="panel-footer">

                    <div class="form-group">
                        <input type="submit" value="Submit" class="btn btn-success pull-right">
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h3>Final Edition</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="/admin/events/conference/final_edition/{{$paper->paper_id}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="event_id" value="{{$paper->event_id}}">
                    <input type="hidden" name="paper_id" value="{{$paper->paper_id}}">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Final Edition</label>
                        <div class="col-md-6 col-xs-12">
                            <a href="{{url('/storage/uploads/fullpapers/')}}{{'/'.$paper->event_id}}{{'/'.$paper->paper_id}}{{'/final_edition.docx'}}" target="_blank">Download</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">New Edition</label>
                        <div class="col-md-6 col-xs-12">                                                
                            <input type="file" accept=".docx,.doc" class="image_file" name="final_edition" class="form-control" />
                        </div>
                    </div>
            </div>
            <div class="panel-footer">

                    <div class="form-group">
                        <input type="submit" value="Submit" class="btn btn-success pull-right">
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <div class="panel @if(isset($paper) && ($abstract->status >= 4 && $abstract->status <= 8)){{ '' }}@else{{ 'hidden' }}@endif">
                    <div class="panel-heading">
                        <h3>Comments</h3>
                    </div>
                    <div class="panel-body" id="comments">
                        @if(isset($comments))
                        @foreach($comments as $comment)
                        @if($comment->user_type == 0)
                            @if(($comment->filename == '') AND ($comment->message != ''))
                            <div class="col-md-12">
                                <div class="col-md-2 ">
                                    <label class="pull-right top10 simg">AU</label>
                                    <small>Author</small>
                                </div>
                                <div class="col-md-10 message msg" style="background:#d1f2cc">
                                    <p style="white-space:pre-wrap;">{{ $comment->message }}</p>
                                </div>
                                <br>
                            </div>
                            @endif
                            @if(($comment->filename != '') AND ($comment->message == ''))
                            <div class="col-md-12">
                                <div class="col-md-2 ">
                                    <label class="pull-right top10 simg">AU</label>
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
                                    <label class="pull-right top10 simg">AU</label>
                                    <small>Author</small>
                                </div>
                                <div class="col-md-10 message msg" style="background:#d1f2cc">
                                    <p style="white-space:pre-wrap;">{{ $comment->message }}</p>
                                </div>
                                <div class="col-md-10 pull-right afile">
                                    <span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: {{@$comment->file}}</small></span><small class="pull-right"><a href="{{ url('comments/'.@$paper->event_id.'/'.@$comment->filename) }}"><i class="fa fa-download"></i> [Download]</a></small>
                                </div>
                                <br>
                            </div>
                            @endif
                        @endif
                        <!-- @if($comment->user_type == 1)
                            @if(($comment->filename == '') AND ($comment->message != ''))
                            <div class="col-md-12">
                                <div class="col-md-10 message msg" style="background:#ccf0f2">
                                    {{ $comment->message }}
                                </div>
                                <div class="col-md-2">
                                    <label class="pull-left top10 scimg">SC</label>
                                    <small class="pull-right">{{$comment->Users['first_name'].' '.$comment->Users['last_name']}}</small>
                                </div>
                                <br>
                            </div>
                            @endif
                            @if(($comment->filename != '') AND ($comment->message == ''))
                            <div class="col-md-12">
                                <div class="col-md-2 pull-right">
                                    <label class="pull-left top10 scimg">SC</label>
                                    <small class="pull-right">{{$comment->Users['first_name'].' '.$comment->Users['last_name']}}</small>
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
                                    <small class="pull-right">{{$comment->Users['first_name'].' '.$comment->Users['last_name']}}</small>
                                </div>
                                <div class="col-md-10 message msg" style="background:#ccf0f2">
                                    {{ $comment->message }}
                                </div>
                                <div class="col-md-10 afile">
                                    <span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: {{@$comment->file}}</small></span><small class="pull-right"><a href="{{ url('comments/'.@$paper->event_id.'/'.@$comment->filename) }}"><i class="fa fa-download"></i> [Download]</a></small>
                                </div>
                                <br>
                            </div>
                            @endif
                        @endif -->
                        @if($comment->user_type == 2)
                            @if(($comment->filename == '') AND ($comment->message != ''))
                            <div class="col-md-12">
                                <div class="col-md-10 message msg" style="background:#f2f1cc">
                                    <p style="white-space:pre-wrap;">{{ $comment->message }}</p>
                                </div>
                                <div class="col-md-2">
                                    <label class="pull-left top10 eimg">@if($comment->user_id == Auth::user()->first_name) ME @else ED @endif</label>
                                    <small class="pull-right">{{$comment->Users['first_name'].' '.$comment->Users['last_name']}}</small>
                                </div>
                                <br>
                            </div>
                            @endif
                            @if(($comment->filename != '') AND ($comment->message == ''))
                            <div class="col-md-12">
                                <div class="col-md-2 pull-right">
                                    <label class="pull-left top10 eimg">@if($comment->user_id == Auth::user()->first_name) ME @else ED @endif</label>
                                    <small class="pull-right">{{$comment->Users['first_name'].' '.$comment->Users['last_name']}}</small>
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
                                    <label class="pull-left top10 eimg">@if($comment->user_id == Auth::user()->first_name) ME @else ED @endif</label>
                                    <small class="pull-right">{{$comment->Users['first_name'].' '.$comment->Users['last_name']}}</small>
                                </div>
                                <div class="col-md-10 message msg" style="background:#f2f1cc">
                                    <p style="white-space:pre-wrap">{{ $comment->message }}</p>
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
                        <div class="row">
                            <form id="commentsform">
                                <input type="hidden" name="user_type" value="2">
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
        <div class="panel">
            <div class="panel-heading">
                <h3>Result</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post" action="/admin/events/conference/paper/paper_status/{{$paper->paper_id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="event_id" value="{{$paper->event_id}}">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Status</label>
                        <div class="col-md-6 col-xs-12">         
                            <label class="check col-md-4"><input @if($paper->status == 3) checked @endif type="radio" class="icheckbox" name="status" value="3" /> Accepted</label>
                            <label class="check col-md-4"><input  @if($paper->status == 4) checked @endif type="radio" class="icheckbox" name="status" value="4" /> Rejected</label>
                            <label class="check col-md-4"><input  @if($paper->status == 0) checked @endif type="radio" class="icheckbox" name="status" value="0" /> Not Set</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Notes</label>
                        <div class="col-md-6 col-xs-12">
                            <textarea class="form-control" rows="4" name="notes">{{$paper->notes}}</textarea>
                        </div>
                    </div>
            </div>
            <div class="panel-footer">

                    <div class="form-group">
                        <input type="submit" value="Submit" class="btn btn-success pull-right">
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
    <div class="row col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <h3>Paper Info</h3>
            </div>
            <div class="panel-body">
                <table class="table" style="font-size:14px;">
                    <tbody>
                        <tr>
                            <td>Title</td>
                            <td>{{ $paper->title }}</td>
                        </tr>
                        <tr>
                            <td>Code</td>
                            <td>{{$paper->code}}</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>{{$paper->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Author</td>
                            <td>{{ $paper['users']->first_name.' '.$paper['users']->last_name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $paper['users']->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $paper['users']->phone }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ @$paper['users']['countries']->name }}</td>
                        </tr>
                        <tr>
                            <td>Payment</td>
                            <td>@if($paper->paid == 0){{'No'}}@else{{'Done'}}@endif</td>
                        </tr>
                        <tr>
                            <?php
                            $status = array(
                                0 => 'Pending Editors Approval',
                                1 => 'Editors Approved',
                                2 => 'Awaiting Reviewers Decision',
                                3 => '<strong style="color:darkgreen">Accepted</strong>',
                                4 => '<strong style="color:red">Rejected</strong>'
                            );
                            ?>
                            <td><strong>Status</strong></td>
                            <td><?php echo @$status[$paper->status] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <div class="col-md-12">
                    <a href="/admin/events/conference/paper/approve/{{ $paper->paper_id }}" class="btn btn-success btn-block @if($paper->status > 0){{ 'hidden' }}@endif">APPROVE</a>
                    <a href="/admin/events/conference/paper/reject/{{ $paper->paper_id }}" class="btn btn-danger btn-block hide">REJECT</a>
                    <a href="{{url('file/'.$download_type.'/'.$paper->paper_id)}}" class="btn btn-info btn-block">DOWNLOAD PAPER SOURCE</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" charset="utf-8" async defer>

    function makeid()
    {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < 5; i++ )
    text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
    }
    function ext(fname)
    {
        return '.'+fname.slice((fname.lastIndexOf(".") - 1 >>> 0) + 2);
    }
    (function($){
$(window).on("load",function(){
$("#comments").mCustomScrollbar({
    theme:"dark",
    scrollInertia:100
});
$("#comments").mCustomScrollbar("scrollTo","bottom",{
    scrollInertia:10
});
});
})(jQuery);
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
                                '<div class="col-md-2 pull-right">'+
                                        '<label class="pull-left top10 eimg">ME</label>'+
                                        '<small class="pull-right">Editor</small>'+
                                '</div>'+
                                '<div class="col-md-10 message msg" style="background:#f2f1cc"><p style="white-space:pre-wrap;">'+text+'</p></div>'+
                                '<div class="col-md-10 pull-left afile">'+
                                        '<span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: '+file+'</small></span><small class="pull-right"><a href="{{ url("comments/".@$abstract->event_id) }}/'+filename+'" target="_blank"><i class="fa fa-download"></i> [Download]</a></small>'+
                                '</div>'+
                        '</div>';
        }
        if(text != '' && file == '')
        {
            var body = '<div class="col-md-12">'+
                                    '<div class="col-md-10 message msg" style="background:#f2f1cc"><p style="white-space:pre-wrap;">'+text+'</p></div>'+
                                    '<div class="col-md-2 ">'+
                                            '<label class="pull-left top10 eimg">ME</label>'+
                                            '<small class="pull-right">Editor</small>'+
                                    '</div>'+
                            '</div>';
        }
        if(text == '' && file != '')
        {
        file = $('input#attachment')[0].files[0]['name'];
        var filename = $('input[name="attachmentfilename"]').val();
            var body = '<div class="col-md-12">'+
                                '<div class="col-md-2 pull-right">'+
                                        '<label class="pull-left top10 eimg">ME</label>'+
                                        '<small class="pull-right">Editor</small>'+
                                '</div>'+
                                '<br><br>'+
                                '<div class="col-md-10 pull-right afile">'+
                                        '<span><small><i class="glyphicon glyphicon-paperclip"></i> Attachment: '+file+'</small></span><small class="pull-right"><a href="{{ url("comments/".@$abstract->event_id) }}/'+filename+'" target="_blank"><i class="fa fa-download"></i> [Download]</a></small>'+
                                '</div>'+
                                '<br>'+
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
    url: '{{ url("/comment/submit/".@$paper->paper_id) }}',
    data: formData,
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function(xhr) {
    //loading ajax animation
        $('#sendmsg').html('<img src="/loading.gif"> Sending');
    },
    success: function (response) {
        var target = document.getElementById('mCSB_3_container');
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
</script>
<script type="text/javascript" charset="utf-8" async defer>
  $(".image_file").fileinput({
          showUpload: false,
          browseClass: "btn btn-default",
          fileType: "['pdf']"
  });
</script>
@endpush
<script type="text/javascript" src="{{ asset('js/admin/plugins/jquery/jquery.min.js')}}"></script>

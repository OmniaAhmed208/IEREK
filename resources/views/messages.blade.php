@extends('layouts.master')
@section('content')
    <style type="text/css">
        .msgs-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .msgs-list li {
            margin: 0;
            padding: 0.75em;
            min-height: 60px;
            border-bottom: 1px solid #f1f1f1;
            cursor: pointer;
            border-left: 3px #e9e9e9 solid;
        }

        .msgs-list li.active {
            background: #f1f1f1;
            border-left: 3px #e7e7e7 solid;
        }

        .msgs-list li.active:hover {
            background: #f1f1f1;
            border-left: 3px #e7e7e7 solid;
            cursor: default;
        }

        .msgs-list li.unread {
            font-weight: 700;
        }

        .msgs-list li:hover {
            background: #f9f9f9;
            border-left: 3px #a97f18 solid;
        }
    </style>
    <div class="container">
        <div class="panel panel-default" id="view-profile">
            <div class="panel-heading">
                <h3 class="panel-title">Messages</h3>
            </div>
            <div class="panel-body" style="background:#f9f9f9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Inbox</h3>
                                    </div>
                                    <div class="panel-body niceScroll"
                                         style="padding:0;margin:0;max-height:400px;overflow-y:scroll">
                                        <div class="row" style="padding:0;margin:0">
                                            <ul class="msgs-list">
                                                @foreach($messages as $message)

                                                    <li id="li-msg{{$message->message_id}}"
                                                        data-title="{{$message->title}}"
                                                        data-md="li-msg{{$message->message_id}}"
                                                        class="aMsg @if($message->read == 0) unread @endif"
                                                        onclick="getMessage({{$message->message_id}})">
                                                        <a href="#message"
                                                           style="display:inline-block;">@if($message->piority == 1) <i
                                                                    style="color:red" class="fa fa-info"></i> @else <i
                                                                    style="color:gold;font-size:8px"
                                                                    class="fa fa-circle"></i> @endif {{$message->title}}
                                                        </a><br>
                                                        <small class="pull-right"
                                                               style="display:inline-block">{{date('jS F, Y h:i A' ,strtotime($message->created_at))}}</small>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8" id="message">
                                <div class="panel">
                                    <div class="panel-body" id="message-body" style="max-height:auto;overflow:hidden;">
                                        <br><br><br>
                                        <center><h1 style="color:#f1f1f1;font-size:50px!imoortant">IEREK</h1></center>
                                        <br><br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var curMsg;
        var curTitle;
        var gettingMsg = 0;

        function getMessage(id) {
            var target = document.getElementById('message-body');
            if (gettingMsg == 0) {
                $.ajax({
                    type: 'GET',
                    url: '/messages/body/' + id,
                    dataType: 'json',
                    timeOut: 10000,
                    beforeSend: function () {
                        $(target).html('<br><br><br><br><center><img src="loading.gif"></center><br><br><br><br>');
                        $('#delArea').remove();
                        gettingMsg = 1;
                    },
                    success: function (response) {
                        if (response.success == true) {
                            var html = response.result;
                            if (html != '') {
                                $(target).html(html);
                                $('#message-body').parent('div.panel').append('<div class="panel-footer" id="delArea"><a class="btn btn-danger delete-btn" id="delBtn" onclick="deleteMsg();">Delete</a></div>');
                                gettingMsg = 0;
                                // $(".niceScroll").mCustomScrollbar();
                            }
                        }
                    },
                    error: function (response) {
                        informX('Your session was ended, please refresh the page.')
                    }
                });
            } else {
                informX('Be patient please, I am working to bring your message =)');
            }
        }

        $(document).ready(function () {
            $('.aMsg').each(function () {
                $(this).on('click', function () {
                    $('.aMsg').each(function () {
                        $(this).removeClass('active');
                    });
                    curMsg = $(this).data('md');
                    curTitle = $(this).data('title');
                    $(this).addClass('active');
                    $(this).removeClass('unread');
                });
            });
        });

        function deleteMsg() {

            var target = document.getElementById('message-body');
            var id = curMsg.replace(/^\D+/g, '');
            $.ajax({
                type: 'GET',
                url: '/messages/delete/' + id,
                dataType: 'json',
                timeOut: 10000,
                beforeSend: function () {
                    $(target).html('<br><br><br><br><center><img src="loading.gif"></center><br><br><br><br>');
                },
                success: function (response) {
                    if (response.success == true) {
                        $(target).html('<br><br><br><br><center><p style="color:#f1f1f1;font-size:50px!important">IEREK</p></center><br><br><br><br>');
                        $('#delArea').fadeOut(400, function () {
                            $('#delArea').remove()
                        });
                        $('#' + curMsg).slideUp(400, function () {
                            $('#' + curMsg).remove()
                        });
                        returnN('<i class="fa fa-trash"></i><small style="font-family: Tahoma!important"> Message deleted successfully.</small>', '#666', 20000);


                    }
                },
                error: function (response) {
                    informX('Your session was ended, please refresh the page.')
                }
            });

        }
    </script>
@endpush
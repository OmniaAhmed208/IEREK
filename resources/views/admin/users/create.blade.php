@extends('admin.layouts.master')
@section('return-url'){{url('/admin/users/'.$type)}}@endsection
@section('panel-title')Add User to {{$title}} @endsection
@section('content')
<!-- PAGE CONTENT WRAPPER -->
<script type="text/javascript" charset="utf-8" async defer>
$(document).ready(function() {
    $('#create').on('click', function(event) {
        event.preventDefault();
        var err = document.getElementsByClassName('error');
        $(err).hide(500);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })
        var myForm = document.getElementById('create_form');
        var formData = new FormData(myForm);
        var alertArea = document.getElementById('alert');
        var alertPlace = $(alertArea).children('span');
        var alertContent = $(alertPlace).html();
        $.ajax({

            type: 'POST',
            url: '/admin/users/{{$type}}/make',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                $(alertArea).fadeOut(200);
                $(alertPlace).html('');
                $('.form-group').each(function() {
                    $(this).removeClass('has-error');
                });
                $('.help-block').each(function() {
                    $(this).text('');
                });
                $('.input-group').each(function() {
                    $(this).removeClass('has-error');
                });
                $('#success').fadeOut(200);
                $('#loading').delay(350).fadeIn(200);
            },
            success: function(response) {
                //check if response with success : true/false
                var success = response.success;
                var errors = (response.errs);
                if (success == false) {
                    $(alertArea).fadeIn(200);
                    alertContent = '<strong id="welcome">Please fix these errors</strong>';
                    $(alertPlace).html(alertContent);
                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('has-error');
                        $('#' + key + '_err').html(value);
                    });
                } else {
                    $('input').each(function() {
                        $(this).val('');
                    });
                    $('#success').delay(350).fadeIn(200);
                    setTimeout(
                        function() {
                            window.open('/admin/users/{{ $type }}', '_self');
                            $('#success').fadeOut(200);
                        }, 2000);
                }
                $('#loading').fadeOut(200);
            },
            error: function(response) {
            }
        });
    });
});
</script>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="post" id="create_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="post">
                <input type="hidden" name="type" value="{{$type}}">
                <div class="panel panel-default">
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            <p>Type and existing user email to make {{$title}}.</p>
                            <p>Fields with <span class="redl">*</span> is required.</p>
                            <div class="form-group" id="title_en">
                                <label class="col-md-3 col-xs-12 control-label">Email</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">@ <span class="redl">*</span></span>
                                        <input type="text" name="email" id="email_input" class="form-control" />
                                    </div>
                                    <label id="email_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3"></label>
                                <label class="help-block col-md-7"></label>
                            </div>
                        </div>
                        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
                            <span><strong id="welcome">User successfully added to {{$title}}!</strong> </span>
                        </div>
                        <div id="alert" class="alert alert-danger" style="margin-top:1em; display:none;">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span></span>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default pull-right" id="create">Add<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->
@endsection

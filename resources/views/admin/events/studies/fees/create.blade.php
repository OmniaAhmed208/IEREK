@extends('admin.layouts.master') @section('return-url'){{route('showConferenceFees', $event_id)}}@endsection @section('panel-title')Create New Fees <small>{{ $event }}</small>@endsection @section('content')
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
            url: '/admin/events/conference/fees/store/{{ $event_id }}',
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
                            window.open('/admin/events/conference/fees/{{ $event_id }}', '_self');
                            $('#success').fadeOut(200);
                        }, 1000);
                }
                $('#loading').fadeOut(200);
            },
            error: function(response) {
                //console.log(response);           
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
                <input type="hidden" name="event_id" value="{{ $event_id }}">
                <div class="panel panel-default">
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            <p>Fill in conference fees information.</p>
                            <p>Fields with <span class="redl">*</span> is required.</p>
                            <div class="form-group" id="title_en">
                                <label class="col-md-3 col-xs-12 control-label">Title</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">En <span class="redl">*</span></span>
                                        <input type="text" name="title_en" id="title_en_input" class="form-control" />
                                    </div>
                                    <label id="title_en_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <!-- <div class="form-group" id="title_ar">
                                <label class="col-md-3 col-xs-12 control-label">Title Arabic</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control ar" name="title_ar" placeholder="" />
                                        <span class="input-group-addon">ع</span>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group hidden" id="event_date_type_id">
                                <label class="col-md-3 col-xs-12 control-label">Condition</label>
                                <div class="col-md-7 col-xs-12" data-toggle="tooltip" data-placement="left" title="Choose condition to apply payment">
                                    <select name="event_date_type_id" class="form-control select">
                                        <option value="0">All</option>
                                        @foreach($condition as $cond)
                                        <option value="{{ $cond->event_date_type_id }}">{{ ucwords(str_replace("_"," ", $cond->event_date_type_title)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group hidden" id="event_attendance_type_id">
                                <label class="col-md-3 col-xs-12 control-label">For</label>
                                <div class="col-md-7 col-xs-12" data-toggle="tooltip" data-placement="left" title="Choose audiance type to apply payment for">
                                    <select name="event_attendance_type_id" class="form-control select">
                                        @foreach($for as $fo)
                                        <option value="{{ $fo->event_attendance_type_id }}">{{ $fo->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group hidden" id="fees_category_id">
                                <label class="col-md-3 col-xs-12 control-label">Category</label>
                                <div class="col-md-7 col-xs-12" data-toggle="tooltip" data-placement="left" title="Choose the category of payment">
                                    <select name="fees_category_id" class="form-control select">
                                        @foreach($category as $cat)
                                        <option value="{{ $cat->fees_category_id }}">{{ $cat->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="amount">
                                <label class="col-md-3 col-xs-12 control-label">Amount</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-9 row" style="padding-left: 0;">                                    
                                            <input type="number" step="any" min="0" class="form-control" name="amount" placeholder="" />
                                            <label id="amount_err" class="help-block redl"></label>
                                        </div>
                                        <div class="col-md-3 row" style="padding-right: 0;">
                                            <select name="currency" class="form-control select">
                                                <option value="{{$event_currency}}">{{$event_currency}}</option>
                                                <option value="EGP">EGP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3"></label>
                                <label class="help-block col-md-7"></label>
                            </div>
                        </div>
                        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
                            <span><strong id="welcome">Conference Fees created successfully !</strong> </span>
                        </div>
                        <div id="alert" class="alert alert-danger" style="margin-top:1em; display:none;">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span></span>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default pull-right" id="create">Create<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel">
        <div class="panel-body">
            <table class="table table-stripped">
                <caption>Conference Fees</caption>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Condition</th>
                        <th>For</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @if($fees) @foreach($fees as $afee)
                        <tr id="event{{ $afee->event_id }}" class="inactive">
                            <td>{{ $afee->title_en }}</td>
                            <td>
                                @if($afee->event_date_type_id == 0) {{ 'All' }} @else {{ ucwords(str_replace("_"," ",$afee->event_date_type['event_date_type_title'])) }} @endif
                            </td>
                            <td>
                                @if($afee->event_attendance_type_id == 0) {{ 'All' }} @else {{ $afee->event_attendance_type['title'] }} @endif
                            </td>
                            <td>{{ $afee->fees_category_type['title'] }}</td>
                            <td>@if($afee->amount > 0)
                                <span class="label label-@if($event_currency != $afee->currency){{'warning'}}@else{{'info'}}@endif" data-toggle="tooltip" data-placement="top">{{ $afee->currency }}</span> {{ $afee->amount }}.00
                                @endif
                            </td>
                            <td>
                                @if($afee->deleted == 1)
                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="fee Is Inactive">I</span> @endif @if($afee->deleted == 0)
                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="fee Is Active">A</span> @endif 
                            </td>
                        </tr>
                        @endforeach @else
                        <tr>
                            <td>
                                {{ 'No Fees for this conference' }}
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->
@endsection
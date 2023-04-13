@extends('admin.layouts.master') @section('return-url'){{route('showStudyabroadWidgets', $event_id)}}@endsection @section('panel-title')Create New Widgets <small>{{ $event }}</small>@endsection @section('content')
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
            url: '/admin/events/studyabroad/widgets/store/{{ $event_id }}',
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
                            window.open('/admin/events/studyabroad/widgets/{{ $event_id }}', '_self');
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
                            <p>Fill in study abroad widgets information.</p>
                            <p>Fields with <span class="redl">*</span> is required.</p>
                            
                            <div class="form-group" id="widget_type_id">
                                <label class="col-md-3 col-xs-12 control-label">Type</label>
                                <div class="col-md-7 col-xs-12" data-toggle="tooltip" data-placement="left" title="Choose the Type of widget">
                                    <select name="widget_type_id" class="form-control select">
                                        @foreach($widgetTypes as $widgetType)
                                        <option value="{{ $widgetType->widget_type_id }}">{{ $widgetType->widget_type_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="position">
                                <label class="col-md-3 col-xs-12 control-label">Position</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <!--<span class="input-group-addon"> <span class="redl">*</span></span>-->
                                        <input type="number" min="0" max="99" name="position" id="position_input" class="form-control" />
                                    </div>
                                    <label id="position_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="widget_title">
                                <label class="col-md-3 col-xs-12 control-label">Title</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl"></span></span>
                                        <input type="text" name="widget_title" id="widget_title_input" class="form-control" />
                                    </div>
                                    <label id="widget_title_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Image</label>
                                <div class="col-md-6 col-xs-12">                                                
                                    <input type="file" accept="image/*" class="image_file" name="widget_img" id="widget_img" class="form-control" />
                                </div>
                            </div>
                            
                            <div class="form-group" id="img_url">
                                <label class="col-md-3 col-xs-12 control-label">Image URL</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl"></span></span>
                                        <input type="text" name="img_url" id="img_url_input" class="form-control" />
                                    </div>
                                    <label id="img_url_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="widget_description">
                                <label class="col-md-3 col-xs-12 control-label">Description</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl"></span></span>
                                        <textArea name="widget_description" id="widget_description_input" class="form-control" ></textarea>
                                    </div>
                                    <label id="widget_description_err" class="help-block redl"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3"></label>
                                <label class="help-block col-md-7"></label>
                            </div>
                        </div>
                        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
                            <span><strong id="welcome">Study abroad Widgets created successfully !</strong> </span>
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
                <caption>Study abroad Widgets</caption>
                <thead>
                    <tr>
                        <th>Widget Title</th>
                        <th>Widget Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @if($widgets) @foreach($widgets as $widget)
                        <tr id="event{{ $widget->event_id }}" class="inactive">
                            <td>{{ $widget->widget_title }}</td>
                            <td>{{ $widget->widget_description }}</td>
                            <td>
                                @if($widget->deleted == 1)
                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="widget Is Inactive">I</span> @endif @if($widget->deleted == 0)
                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="widget Is Active">A</span> 
                                @endif
                            </td>
                        </tr>
                        @endforeach @else
                        <tr>
                            <td>
                                {{ 'No Widgets for this study abroad' }}
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
<script type="text/javascript" src="{{ asset('js/admin/plugins/fileinput/fileinput.min.js') }}"></script> 
<script type="text/javascript" charset="utf-8" async defer>
  $(".image_file").fileinput({
          showUpload: false,
          showCaption: false,
          browseClass: "btn btn-default",
          fileType: "any"
  });
</script>
<!-- END PAGE CONTENT WRAPPER -->
@endsection

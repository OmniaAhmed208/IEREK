@extends('admin.layouts.master') @section('return-url'){{route('showStudyabroadCategories','show')}}@endsection @section('panel-title')Update Study Abroad Category@endsection 
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
            url: '{{ route("updateStudyabroadCategories", $category->sub_category_id) }}',
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
                    $('#success').delay(350).fadeIn(200);
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
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="category_id" value="{{$category->category_id}}">
                <div class="panel panel-default">
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            <p>Fill in study abroad categories information.</p>
                            <p>Fields with <span class="redl">*</span> is required.</p>
                            
                            <div class="form-group" id="category_title">
                                <label class="col-md-3 col-xs-12 control-label">Title</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl"></span></span>
                                        <input type="text" name="title" id="category_title_input" class="form-control" value="{{$category->title}}" />
                                    </div>
                                    <label id="category_title_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="category_description">
                                <label class="col-md-3 col-xs-12 control-label">Description</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl"></span></span>
                                        <textArea name="description" id="category_description_input" class="form-control" >{{$category->description}}</textarea>
                                    </div>
                                    <label id="category_description_err" class="help-block redl"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3"></label>
                                <label class="help-block col-md-7"></label>
                            </div>
                        </div>
                        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
                            <span><strong id="welcome">Study abroad Category updated successfully !</strong> </span>
                        </div>
                        <div id="alert" class="alert alert-danger" style="margin-top:1em; display:none;">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span></span>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default pull-right" id="create">Update<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                    </div>
                </div>
            </form>
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

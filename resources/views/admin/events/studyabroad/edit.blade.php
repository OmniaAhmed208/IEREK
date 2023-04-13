@extends('admin.layouts.master')
@section('return-url'){{route('indexStudyabroad')}}@endsection
@section('panel-title')Update Studyabroad <small>{{ $event->title_en }} <?php if($event->deleted == 1){ echo '<b style="color:red">Deleted</b>'; } ?></small>
@endsection
@section('content')
<!-- PAGE CONTENT WRAPPER -->
<script type="text/javascript" charset="utf-8" async defer>
$(document).ready( function() {
    $('#update').on('click', function(event) {
        event.preventDefault();
        var err = document.getElementsByClassName('error');
        $(err).hide(500);
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
        })
        var myForm = document.getElementById('update_form');
        var formData = new FormData(myForm);
        var alertArea = document.getElementById('alert');
        var alertPlace = $(alertArea).children('span');
        var alertContent = $(alertPlace).html();

        $.ajax({

        type: 'POST',
        url: '{{ route("updateStudyabroad", $event->event_id) }}',
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
            success: function (response) {
                //check if response with success : true/false
                var success = response.success;
                var errors = (response.errs);
                if(success == false)
                {
                    $(alertArea).fadeIn(200);
                    alertContent = '<strong id="welcome">Please fix the errors</strong>';
                    $(alertPlace).html(alertContent);
                    $.each(errors, function(key, value){
                        $('#'+key).addClass('has-error');
                        $('#'+key+'_err').html(value);
                    });
                }
                else
                {
                    if(response == 1){
                        $('#success').delay(350).fadeIn(200);
                        setTimeout(
                            function(){
                                $('#success').fadeOut(200);
                            }
                        ,5000);
                    }
                }
                $('#loading').fadeOut(200);
            },
            error: function (response) {
               //console.log(response);           
            }
        });
    });

        function slug(val)
        {
            var sVal = val;
            var noSpec = sVal.replace(/[^\w\s]/gi, '');
            var slug = noSpec.replace(/\s+/g, '-').toLowerCase();
            return slug;
        }

        $('#title_en_input').on('keyup', function(){
            var val = $(this).val();
            var target = document.getElementById('slug_input');

            $(target).val(slug(val));
        })
});
</script>
<style type="text/css">
.redl{
    color:red!important;
}    
</style>
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" method="post" id="update_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">
                <input type="hidden" name="_method" value="PUT">                                                         
                <div class="panel panel-default tabs">                            
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#tab-General" role="tab" data-toggle="tab">General</a></li>
                        <li><a href="#tab-Images" role="tab" data-toggle="tab">Images</a></li>
                    </ul>
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            <p>Fill in studyabroad general information.</p>
                            <p>Fields with <span style="color:red">*</span> is required.</p>
                            <div class="form-group" id="sub_category_id">                                        
                                <label class="col-md-3 col-xs-12 control-label">Category</label>
                                <div class="col-md-6 col-xs-12">
                                  <select class="form-control select" name="sub_category_id">
                                      @foreach($categories as $category)
                                        <option @if($event->sub_category_id == $category->sub_category_id){{'selected'}}@endif value="{{ $category->sub_category_id }}">{{ $category->title }}</option>
                                      @endforeach
                                  </select>
                                </div>                                            
                            </div>
                            <div class="form-group" id="title_en">
                                <label class="col-md-3 col-xs-12 control-label">Title</label>
                                <div class="col-md-6 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon">En <span style="color:red">*</span></span>
                                        <input type="text" name="title_en" id="title_en_input" value="{{ $event->title_en }}" class="form-control"/>
                                    </div>
                                    <label id="title_en_err" class="help-block redl"></label> 
                                </div>
                            </div>
                            <div class="form-group" id="slug">
                                <label class="col-md-3 col-xs-12 control-label">Slug</label>
                                <div class="col-md-6 col-xs-12">  
                                    <div class="input-group">
                                        <span class="input-group-addon">URL <span style="color:red">*</span></span>
                                        <input type="text" name="slug" value="{{ $event->slug }}" id="slug_input" class="form-control" />
                                    </div>
                                <label id="slug_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Meta Title</label>
                                <div class="col-md-6 col-xs-12">  
                                    <div class="input-group">
                                        <span class="input-group-addon">T</span>
                                        <input type="text" name="meta_title" value="{{ $event->meta_title }}" class="form-control" />
                                    </div>
                                    <label id="slug_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Meta Keywords</label>
                                <div class="col-md-6 col-xs-12">  
                                    <div class="input-group">
                                        <span class="input-group-addon">K</span>
                                        <input type="text" name="meta_keywords" value="{{ $event->meta_keywords }}" class="form-control" placeholder="sprat keywords with [,]" />
                                    </div>
                                    <label id="slug_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Meta Discription</label>
                                <div class="col-md-6 col-xs-12">  
                                    <div class="input-group">
                                        <span class="input-group-addon">D</span>
                                        <input type="text" name="meta_description"  value="{{ $event->meta_description }}" class="form-control" placeholder="Maximum: 300 (Recommended)" />
                                    </div>
                                    <label id="slug_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Options</label>
                                <div class="col-md-6 col-xs-12">         
                                    <label class="check col-md-6"><input type="checkbox" class="icheckbox" @if($event->publish == 1) {{ 'checked' }} @endif name="publish" value="1" /> Publish</label>

                                    <!--
                                    <label class="check col-md-6"><input type="checkbox" class="icheckbox" name="submission" value="1" @if($event->submission == 1) {{ 'checked' }} @endif name="publish" value="1" /> Close Submission</label>
                                    <label class="check col-md-6"><input type="checkbox" class="icheckbox" name="fullpaper" value="1" @if($event->fullpaper == 1) {{ 'checked' }} @endif name="publish" value="1" /> Full Paper Open</label>
                                    -->
                                </div>
                            </div>
                            <div class="form-group" id="email">
                                <label class="col-md-3 col-xs-12 control-label">Email</label>
                                <div class="col-md-6 col-xs-12">         
                                    <div class="input-group">
                                        <span class="input-group-addon">@ <span style="color:red">*</span></span>
                                        <input type="email" name="email"  value="{{ $event->email }}" class="form-control" placeholder=""/>
                                    </div>
                                <label id="email_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="location_en">
                                <label class="col-md-3 col-xs-12 control-label">Location</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">En</span>
                                        <input type="text"  name="location_en"  value="{{ $event->location_en }}" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="title_ar">
                                <label class="col-md-3 col-xs-12 control-label">University</label>
                                <div class="col-md-6 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon">*</span>
                                        <input type="text" name="title_ar" id="title_ar_input" value="{{ $event->title_ar }}" class="form-control"/>
                                    </div>
                                    <label id="title_ar_err" class="help-block redl"></label> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Studyabroad Dates</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="col-md-6">
                                      <label class="col-md-3 control-label">Start</label>
                                      <div class="col-md-9">
                                          <div class="input-group" id="start_date">
                                                <input type="text" name="start_date" class="form-control datepicker"   value="{{ date('Y-m-d', strtotime($event->start_date) ) }}">
                                                <span class="input-group-addon"><span style="color:red">*</span> <span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                            <label id="start_date_err" class="help-block redl"></label>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <label class="col-md-3 control-label">End</label>
                                      <div class="col-md-9">
                                          <div class="input-group" id="end_date">
                                                <input type="text"  name="end_date" class="form-control datepicker"  value="{{ date('Y-m-d', strtotime($event->end_date) ) }}">
                                                <span class="input-group-addon"><span style="color:red">*</span> <span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                            <label id="end_date_err" class="help-block redl"></label>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="currency">
                                <label class="col-md-3 col-xs-12 control-label">Currency</label>
                                <div class="col-md-6 col-xs-12">
                                    <select class="select form-control" name="currency">
                                        @if($event->currncy == '')
                                        <option value="0">Choose Currncy</option>
                                        @endif
                                        <option @if($event->currency == 'USD') selected @endif value="USD">USD</option>
                                        <option @if($event->currency == 'EUR') selected @endif value="EUR">EUR</option>
                                        <option @if($event->currency == 'GBP') selected @endif value="GBP">GBP</option>
                                        <option @if($event->currency == 'EGP') selected @endif value="EGP">EGP</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="tab-Images">
                            <p>Insert Studyabroad Images for all following views (Cover Image, Out View Image, Slider Image and Publisher Image.</p>
                            

                            <img src="{{ $url['cover'] }}" alt="No cover image uploaded" width="200">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Cover Image</label>
                                <div class="col-md-6 col-xs-12">                                                
                                    <input type="file" accept="image/*" class="image_file" name="cover_img" id="cover_img" class="form-control" />
                                </div>
                            </div>

                            <img src="{{ $url['list'] }}" alt="No out view image uploaded" width="200">

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Out View Image</label>
                                <div class="col-md-6 col-xs-12">                                                
                                    <input type="file" accept="image/*" class="image_file" name="list_img" id="list_img" class="form-control" />
                                </div>
                            </div>

                            <img src="{{ $url['slider'] }}" alt="No slider image uploaded" width="200">
                            
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Slider Image</label>
                                <div class="col-md-6 col-xs-12">                                                
                                    <input type="file" accept="image/*" class="image_file" name="slider_img" id="slider_img" class="form-control" />
                                </div>
                            </div>
                            
                            <img src="{{ $url['featured'] }}" alt="No featured image uploaded" width="200">
                            
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Publisher Image</label>
                                <div class="col-md-6 col-xs-12">                                                
                                    <input type="file" accept="image/*" class="image_file" name="featured_img" id="featured_img" class="form-control" />
                                </div>
                            </div> 
                        </div>
                        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
                            <span><strong id="welcome">Event updated successfully !</strong> </span>
                        </div>
                        <div id="alert" class="alert alert-danger" style="margin-top:1em; display:none;">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span></span>
                        </div>
                    </div>
                    <div class="panel-footer">                                                                        
                        <button class="btn btn-default pull-right" id="update">Update<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
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
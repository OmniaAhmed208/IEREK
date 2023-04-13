@extends('admin.layouts.master')
@section('return-url'){{route('showConferenceWidgets', $event_id)}}@endsection
@section('panel-title')Update Conference Widgets <small>{{ $event['title_en'] }}</small>
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
        var content = tinymce.get('content').getContent();
        $('#content').text(content);
        var myForm = document.getElementById('update_form');
        var formData = new FormData(myForm);
        var alertArea = document.getElementById('alert');
        var alertPlace = $(alertArea).children('span');
        var alertContent = $(alertPlace).html();
        $.ajax({

        type: 'POST',
        url: '{{ route("updateConferenceWidgets", $eventWidget->event_widget_sid) }}',
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
                    alertContent = '<strong id="welcome">Please fix these errors</strong>';
                    $(alertPlace).html(alertContent);
                    $.each(errors, function(key, value){
                        $('#'+key).addClass('has-error');
                        $('#'+key+'_err').html(value);
                    });
                }
                else
                {
                    $('input').each(function() {
                        $(this).val('');
                    });
                    $('#success').delay(350).fadeIn(200);
                    setTimeout(
                        function(){
                            window.open('/admin/events/conference/widgets/{{ $event_id }}', '_self');
                            $('#success').fadeOut(200);
                        }
                    ,1000);
                }
                $('#loading').fadeOut(200);
            },
            error: function (response) {
               //console.log(response);           
            }
        });
    });
});
</script>
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" method="post" id="update_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="event_id" value="{{ $event_id }}">
                <div class="panel panel-default">                            
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            <p>Update conference widgets information.</p>
                            <p>Fields with <span class="redl">*</span> is required.</p>

                            <div class="form-group" id="widget_type_id">                                        
                                <label class="col-md-3 col-xs-12 control-label">Type</label>
                                <div class="col-md-6 col-xs-12">
                                  <select class="form-control select" name="widget_type_id">
                                        
                                        <!--<option value="0" selected="selected"> Choose Widget Type</option>}-->
                                        
                                      @foreach($widgetTypes as $widgetType)
                                        <option value="{{ $widgetType['widget_type_id'] }}" @if($eventWidget->widget_type_id == $widgetType['widget_type_id']) {{ 'selected' }} @endif>{{ $widgetType['widget_type_description'] }}  @if($eventWidget->widget_type_id == $widgetType['widget_type_id']) {{ '(Current)' }} @endif</option>
                                      @endforeach
                                  </select>
                                </div>                                            
                            </div>    
                            <div class="form-group" id="position">
                                <label class="col-md-3 col-xs-12 control-label">Order</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        
                                        <input type="text" name="position" id="position_input" class="form-control" value="{{ $eventWidget->position }}"/>
                                    </div>
                                    <label id="position_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="widget_title">
                                <label class="col-md-3 col-xs-12 control-label">Title</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="widget_title" id="widget_title_input" class="form-control" value="{{ $eventWidget->widget_title }}"/>
                                    </div>
                                    <label id="widget_title_err" class="help-block redl"></label>
                                </div>
                            </div>

                            <img src="{{ $url['widget_img'] }}" alt="No widget image uploaded" width="200">
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
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="img_url" id="img_url_input" class="form-control" value="{{ $eventWidget->img_url }}"/>
                                    </div>
                                    <label id="img_url_err" class="help-block redl"></label>
                                </div>
                            </div>

                            <div class="form-group" id="widget_description">
                                <label class="col-md-3 col-xs-12 control-label">Description</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <textarea name="widget_description" id="content" class="form-control textarea" >{{ $eventWidget->widget_description }}</textarea>

                                        

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
                            <span><strong id="welcome">Conference Widgets updated successfully !</strong> </span>
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
</div>

<script type="text/javascript" src="{{ asset('js/admin/plugins/fileinput/fileinput.min.js') }}"></script>
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" charset="utf-8" async defer>
  var editor_config = {
        path_absolute : "/",
        selector: "#content",
        theme:'modern',
        plugins: [
          "advlist autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen",
          "insertdatetime media nonbreaking save table contextmenu directionality",
          "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        image_advtab: true,
        relative_urls: false,
        file_browser_callback : function(field_name, url, type, win) {
          var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
          var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

          var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
          if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
          } else {
            cmsURL = cmsURL + "&type=Files";
          }

          tinyMCE.activeEditor.windowManager.open({
            file : cmsURL,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            resizable : "yes",
            close_previous : "no"
          });
        }
      };

      tinymce.init(editor_config);
  $(".image_file").fileinput({
          showUpload: false,
          showCaption: false,
          browseClass: "btn btn-default",
          fileType: "any"
  });
</script>
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


@extends('admin.layouts.master')
@section('return-url'){{ url('admin') }}@endsection
@section('panel-title')Manage {{ ucfirst($page->type) }}@endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{ url('admin/pages/static/'.$page->page_id) }}" enctype="multipart/form-data">
            <div class="panel panel-default">
            	@if(in_array($page->type,array('suggest','careers','terms'))) @else <img src="/uploads/images/{{$page->type}}.jpg" alt="No cover image uploaded" width="100%" alt="No Image or Page has no Image" style="padding: 1em;">
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Cover Image (1000x240)</label>
                    <div class="col-md-6 col-xs-12">                                                
                        <input type="file" accept="image/*" class="image_file" name="cover_img" id="cover_img" class="form-control" />
                    </div>
                </div>
                @endif
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            	<input type="hidden" name="type" value="{{ $page->type }}">
                <div class="panel-body" style="min-height:450px;">
            			<textarea class="textarea" name="content">
            				<?php echo $page->content; ?>
            			</textarea>
                </div>
                <div class="panel-footer">
                	<input type="submit" class="btn btn-success pull-right" value="Update">
                	<div class="clearfix"></div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
	<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
	<script>
		$(document).ready(function(){
      var editor_config = {
        path_absolute : "/",
        selector: ".textarea",
        height: 300,
        setup: function (editor) {
          editor.on('change', function () {
              tinymce.triggerSave();
          });
        },
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
		});
	</script>
@endpush
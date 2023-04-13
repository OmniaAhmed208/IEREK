@extends('admin.layouts.master')
@section('panel-title')
Create New topic
@endsection

@section('title')
Create New topic
@endsection

@section('content')

    @include('admin.events.conference.topics.includes.createForm')
<!-- END PAGE CONTENT WRAPPER -->     
@endsection
@push('scripts')
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        var editor_config = {
        path_absolute : "/",
          setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
          },
        selector: "textarea",
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



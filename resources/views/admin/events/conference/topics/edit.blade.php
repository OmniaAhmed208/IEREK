@extends('admin.layouts.master')
@section('return-url'){{route('showConferenceTopics', $event_id)}}@endsection
@section('panel-title')
    Edit Topic <small>{{ $event->title_en }}</small>
@endsection

@section('content')
    <div id="edit_topics">
        @include('admin.events.conference.topics.includes.ajaxEdit')
    </div>

@endsection

@push('scripts')
<!--    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        tinymce.init({
          selector: 'textarea',
          setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
          },
          height: 300,
          theme: 'modern',
          plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample'
          ],
          toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
          toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
          image_advtab: true,
          templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
          ],
          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
          ]
         });

        $('#submit').on('click',function(event){
            event.preventDefault();
            $.ajax({
                url: $('form[name=frm_update_topic]').attr('action'),
                type: 'POST',
                headers:{ 'X-CSRF-Token': '{{ Session::token() }}' },
                data: $('form[name=frm_update_topic]').serialize(),
                success: function(response) {
                    var selSuccessMessage = $("#alert_messages .alert-success .content");
                    var selSuccessMessageContainer = $("#alert_messages .alert-success");
                    selSuccessMessage.html(response.msg);
                    selSuccessMessageContainer.show();
                    window.open('#alert_messages','_self');
                    setTimeout(function(){window.open('/admin/events/conference-details/topics/{{ $event_id }}','_self');}, 1000);
                },
                error: function() {

                }
            });
        })
    })
    </script>-->
  <script>
        $(function() {
            // activate sorting
            activateSorting();

        });


        function activateSorting(){
            $("#sort-topic").sortable({
                connectWith: "#edit_topics",
                stop: function( event, ui ) {
                    // update positions when order changes
                    //ajaxChangePosition();
                }
            });
            $( "#sort-topic" ).sortable( "refresh" );

        }

        function confirmDelete(msgText, frmCaller, isSaved){

            noty({
                text: msgText,
                layout: 'center',
                buttons: [
                    {
                        addClass: 'btn btn-success btn-clean',
                        text: 'Ok',
                        onClick: function($noty) {
                            $noty.close();

                            if(isSaved){
                                // call the ajax to delete the section
                                ajaxCaller(frmCaller);
                            }
                            else{
                                $(".to_be_deleted").remove();
                            }


                        }
                    },
                    {
                        addClass: 'btn btn-danger btn-clean',
                        text: 'Cancel',
                        onClick: function($noty) {
                            $noty.close();
                        }
                    }
                ]
            })
        }

        function ajaxCaller(frmCaller){

            var url = frmCaller.attr("action");
            var requestData = frmCaller.serialize();
            var frmName = frmCaller.attr("name");

            var selSuccessMessage = $("#alert_messages .alert-success .content");
            var selSuccessMessageContainer = $("#alert_messages .alert-success");

            var selFailMessage = $("#alert_messages .alert-danger .content");
            var selFailMessageContainer = $("#alert_messages .alert-danger");

            selSuccessMessageContainer.hide();
            selFailMessageContainer.hide();
        }


        function ajaxChangePosition(){
            console.log("I'm here");

            var arrSection = [];

            $( ".section .section-item" ).each(function( index ) {

                arrSection.push({
                    'topic_id':$(this).find("input[name=topic_id]").val(),
                    'position': index + 1
                });
            });
            console.log(arrSection);

            $.ajax({
                
                url: "{{ route('changePositionConferenceTopics') }}",
                type: 'POST',
                headers:{ 'X-CSRF-Token': '{{ Session::token() }}' },
                data: {'positions': arrSection},
                success: function() {
                    console.log("then here");
                    var selSuccessMessage = $("#alert_messages .alert-success .content");
                    var selSuccessMessageContainer = $("#alert_messages .alert-success");
                    selSuccessMessage.html('Reorder updated successfully!');
                    selSuccessMessageContainer.show();
                    window.open('#alert_messages','_self');
                    setTimeout(function(){window.open('/admin/events/conference-details/topics/{{ $event_id }}','_self');}, 1000);
                    
                },
                error: function() {
console.log("then here error");
                }
            });
        }
    </script>
@endpush


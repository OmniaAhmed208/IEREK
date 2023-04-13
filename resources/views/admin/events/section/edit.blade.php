@extends('admin.layouts.master')
@section('return-url'){{route('showSection', $event->event_id)}}@endsection
@section('panel-title')
Reorder Sections <small>{{ $event->title_en }}</small>
@endsection

@section('content')
    <div id="edit_sections">
        @include('admin.events.section.includes.ajaxEdit')
    </div>

@endsection
    @push('scripts')

    <script>
        $(function() {
            // activate sorting
            activateSorting();

        });


        function activateSorting(){
            $("#sort-section").sortable({
                connectWith: "#edit_sections",
                stop: function( event, ui ) {
                    // update positions when order changes
                    //ajaxChangePosition();
                }
            });
            $( "#sort-section" ).sortable( "refresh" );

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

            var arrSection = [];

            $( ".section .section-item" ).each(function( index ) {

                arrSection.push({
                    'section_id':$(this).find("input[name=section_id]").val(),
                    'position': index + 1
                });
            });

            $.ajax({
                url: "{!! route('changePositionSection') !!}",
                type: 'POST',
                headers:{ 'X-CSRF-Token': '{{ Session::token() }}' },
                data: {'positions': arrSection},
                success: function() {
                    var selSuccessMessage = $("#alert_messages .alert-success .content");
                    var selSuccessMessageContainer = $("#alert_messages .alert-success");
                    selSuccessMessage.html('Reorder updated successfully!');
                    selSuccessMessageContainer.show();
                    window.open('#alert_messages','_self');
                    setTimeout(function(){window.open('/admin/events/section/{{ $event_id }}','_self');}, 1000);
                    
                },
                error: function() {

                }
            });
        }
    </script>
    @endpush



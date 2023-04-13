@extends('admin.layouts.master')
@section('panel-title')
    Edit Announcement <small> Order </small>
@endsection

@section('content')
    <div id="edit_announcements">
        @include('admin.pages.home.announcement.ajaxEdit')
    </div>

@endsection

@push('scripts')

  <script>
        $(function() {
            // activate sorting
            activateSorting();

        });


        function activateSorting(){
            $("#sort-announcement").sortable({
                connectWith: "#edit_announcements",
                stop: function( event, ui ) {
                    // update positions when order changes
                    //ajaxChangePosition();
                }
            });
            $( "#sort-announcement" ).sortable( "refresh" );

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
                    'announce_id':$(this).find("input[name=announce_id]").val(),
                    'position': index + 1
                });
            });
            console.log(arrSection);

            $.ajax({
                
                url: "{{ route('changePositionAnnouncements') }}",
                type: 'POST',
                headers:{ 'X-CSRF-Token': '{{ Session::token() }}' },
                data: {'positions': arrSection},
                success: function() {
                    console.log("then here success");
                    var selSuccessMessage = $("#alert_messages .alert-success .content");
                    var selSuccessMessageContainer = $("#alert_messages .alert-success");
                    selSuccessMessage.html('Reorder updated successfully!');
                    selSuccessMessageContainer.show();
                    window.open('#alert_messages','_self');
                    setTimeout(function(){window.open('/admin/pages/home/announcement/','_self');}, 1000);
                    
                },
                error: function() {
console.log("then here error");
                }
            });
        }
    </script>
@endpush


@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')
Sections <small>{{ $event->title_en }}</small>
@endsection
@section('content')
<div class="row col-md-12">
    <div class="panel panel-default tabs">
        <div class="panel-body">
            <div class="panel-body">
                <h3>Sections</h3>
                <table id="tbl_all_sections" class="table table-hover table-striped
                    @if(count($sections) > 0)
                    datatable
                    @endif
                    ">
                    <thead>
                        <tr>
                            <th>Pos</th>
                            <th>Title</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($sections) > 0)
                        @foreach($sections as $section)
                        <tr>
                            <td>{{ $section->position }}</td>
                            <td>{{ $section->title_en }}</td>
                            <td>{{ $section->created_at->format('j M, Y g:i A') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a style="cursor:pointer;color:green" href="<?php if($section->section_type_id == 6){ echo route('editConferenceDates', $section->event_id);}else{echo route('editSection', $section->section_id);} ?>">Edit</a>
                                        </li>
                                        <li>
                                            @include('admin.events.section.includes.deleteForm', ['section_id' => $section->section_id])
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <td colspan="4" style="text-align: center;">No sections found</td>
                        @endif
                    </tbody>
                </table>
                <div class="panel-footer">
                    <div class="col-md-4 pull-right">
                        <div class="btn-group" style="float:right">
                            <a href="{!! route('createSection') !!}" id="add_new_section" class="btn btn-success">
                                <span class="fa fa-plus"></span> New Section
                            </a>
                        </div>
                        <div class="pull-right">&ensp;</div>
                        <div class="btn-group" style="float:right">
                            @if(count($sections) > 1)
                            <a href="{{ route('orderSection', @$section->event_id) }}" id="add_new_section" class="btn btn-default">
                                <span class="fa fa-list"></span> Reorder
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
//            $("#tbl_all_sections").on("click", ".delete_section", function (event) {
$(".delete_section").click(function (event) {
event.preventDefault();
var msgText = '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete section ?';
// add class to main tr to mark this row
$(this).closest('tr') .addClass("to_be_deleted");
// get the section id
var section_id = $(this).attr('data-id');
var isSaved = true;
if(section_id == 0){
isSaved = false;
}
// show the confirm message
confirmDelete(msgText, $(this).closest("form"), isSaved);
return false;
}); // end delete section click event
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
deleteSection(frmCaller);
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
function deleteSection(frmCaller){
var url = frmCaller.attr("action");
var requestData = frmCaller.serialize();
var frmName = frmCaller.attr("name");
var selSuccessMessage = $("#alert_messages .alert-success .content");
var selSuccessMessageContainer = $("#alert_messages .alert-success");
var selFailMessage = $("#alert_messages .alert-danger .content");
var selFailMessageContainer = $("#alert_messages .alert-danger");
selSuccessMessageContainer.hide();
selFailMessageContainer.hide();
// call the ajax method
$.ajax({
url: url,
type: 'POST',
data: requestData,
success: function( retData ) {
if ( retData.status === 'success' ) {
// show the deleted confirmation to the user
selSuccessMessage.html(retData.msg);
selSuccessMessageContainer.fadeIn(200);
// in case of success only
// remove the deleted section div
$(".to_be_deleted").remove();
}
else{
selFailMessageContainer.fadeIn(200);
if (retData.msg instanceof Array || typeof retData.msg === 'object'){
// show the error messages
var alertContent = '<strong id="welcome">Please fix the following errors:</strong><br>';
selFailMessage.html(alertContent);
$.each(retData.msg, function(key, value){
$('#'+key).addClass('has-error');
selFailMessage.html(selFailMessage.html() + value + '<br>');
});
}
else{
selFailMessage.html(retData.msg);
}
$(".to_be_deleted").removeClass("to_be_deleted");
}
},
error: function( retData ) {
selFailMessage.html("Error , Please try again later");
selFailMessageContainer.fadeIn(200);
// remove the class that mark the row to be deleted
$(".to_be_deleted").removeClass("to_be_deleted");
}
});
}
</script>
@endpush
@endsection
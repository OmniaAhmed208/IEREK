@extends('admin.layouts.master')
@section('return-url'){{route('showConferenceMediaCoverages', $eventMediaCoverage->event_id)}}@endsection
@section('panel-title')View media coverage requist details for the conference  <small>{{ $event['title_en'] }}</small>
@endsection
@section('content')




<!-- PAGE CONTENT WRAPPER -->
<script type="text/javascript" charset="utf-8" async defer>
$(document).ready( function() {
    $('#accept').on('click', function(event) {
        event.preventDefault();
        submitAjax(1);
    });
    $('#reject').on('click', function(event) {
        event.preventDefault();
        submitAjax(2);
    });
});
function submitAjax(val)
{
    var err = document.getElementsByClassName('error');
    var statusVal = document.getElementById('media_coverage_status');
    $(statusVal).val(val);
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
        url: '{{ route("updateConferenceMediaCoverages", $eventMediaCoverage->event_media_coverage_sid)}}',
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
                            window.open('/admin/events/conference/media_coverages/{{ $eventMediaCoverage->event_id }}', '_self');
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
}
</script>
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" method="post" id="update_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="put">
                <input type="hidden", name="media_coverage_status" id="media_coverage_status">
                <input type="hidden" name="event_id" value="{{ $eventMediaCoverage->event_id }}">
                <div class="panel panel-default">                            
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            
                            
                           <div class="form-group" id="organization">
                                <label class="col-md-3 col-xs-12 control-label">Organization</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="organization" id="organization_input" class="form-control" value="{{ $eventMediaCoverage->organization }}"/>
                                    </div>
                                    <label id="organization_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="email">
                                <label class="col-md-3 col-xs-12 control-label">Email</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="email" id="email_input" class="form-control" value="{{ $eventMediaCoverage->email }}"/>
                                    </div>
                                    <label id="email_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Logo</label>
                                <img src="{{ $url['img'] }}" alt="No media_coverage image uploaded" width="200">
                            </div>

                           <div class="form-group" id="brief_description">
                                <label class="col-md-3 col-xs-12 control-label">Proposal</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <textarea name="brief_description" id="brief_description_input" class="form-control" >{{ $eventMediaCoverage->brief_description }}</textarea>

                                    </div>
                                    <label id="brief_description_err" class="help-block redl"></label>
                                </div>
                            </div>

                            <div class="form-group" id="media_type">
                                <label class="col-md-3 col-xs-12 control-label">Media Type</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="media_type" id="media_type_input" class="form-control" value="{{ $eventMediaCoverage->media_type }}"/>
                                    </div>
                                    <label id="media_type_err" class="help-block redl"></label>
                                </div>
                            </div>
                            

                            
                            <div class="form-group">
                                <label class="col-md-3"></label>
                                <label class="help-block col-md-7"></label>
                            </div>
                        </div>
                        
                        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
                            <span><strong id="welcome">Conference Media Coverages Accepted successfully !</strong> </span>
                        </div>
                       

                        <div id="alert" class="alert alert-danger" style="margin-top:1em; display:none;">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span></span>
                        </div>
                    </div>
                    <div class="panel-footer">                                                                        
                        
                        <button class="btn btn-default pull-right" id="accept">Accept<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<button class="btn btn-default pull-right" id="reject">Reject<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">



                    </div>
                </div>                                
            
            </form>
            
        </div>

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


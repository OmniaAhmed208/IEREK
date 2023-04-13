@extends('admin.layouts.master')
@section('return-url'){{route('showConferenceSponsors', $eventSponsor->event_id)}}@endsection
@section('panel-title')View sponsor requist details for the conference  <small>{{ $event['title_en'] }}</small>
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
    var statusVal = document.getElementById('sponsor_status');
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
        url: '{{ route("updateConferenceSponsors", $eventSponsor->event_sponsor_sid) }}',
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
                            window.open('/admin/events/conference/sponsors/{{ $eventSponsor->event_id }}', '_self', '_self');
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
                <input type="hidden", name="sponsor_status" id="sponsor_status">
                <input type="hidden" name="event_id" value="{{ $eventSponsor->event_id }}">
                <div class="panel panel-default">                            
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            
                            
                           <div class="form-group" id="company_name">
                                <label class="col-md-3 col-xs-12 control-label">Company Name</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="company_name" id="company_name_input" class="form-control" value="{{ $eventSponsor->company_name }}"/>
                                    </div>
                                    <label id="company_name_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="brief_description">
                                <label class="col-md-3 col-xs-12 control-label">Brief Description</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <textarea name="brief_description" id="brief_description_input" class="form-control" >{{ $eventSponsor->brief_description }}</textarea>

                                    </div>
                                    <label id="brief_description_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Logo</label>
                                <img src="{{ url('file/3/'.$eventSponsor->event_sponsor_sid) }}" alt="No sponsor image uploaded" width="200">
                            </div>
                            <div class="form-group" id="website">
                                <label class="col-md-3 col-xs-12 control-label">Website</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="website" id="website_input" class="form-control" value="{{ $eventSponsor->website }}"/>
                                    </div>
                                    <label id="website_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="contact_person_name">
                                <label class="col-md-3 col-xs-12 control-label">Contact Person Name</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="contact_person_name" id="contact_person_name_input" class="form-control" value="{{ $eventSponsor->contact_person_name }}"/>
                                    </div>
                                    <label id="contact_person_name_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="phone">
                                <label class="col-md-3 col-xs-12 control-label">Phone Number</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="phone" id="phone_input" class="form-control" value="{{ $eventSponsor->phone }}"/>
                                    </div>
                                    <label id="phone_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="email">
                                <label class="col-md-3 col-xs-12 control-label">Email</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="email" id="email_input" class="form-control" value="{{ $eventSponsor->email }}"/>
                                    </div>
                                    <label id="email_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="proposal">
                                <label class="col-md-3 col-xs-12 control-label">Proposal</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <textarea name="proposal" id="proposal_input" class="form-control" >{{ $eventSponsor->proposal }}</textarea>

                                    </div>
                                    <label id="proposal_err" class="help-block redl"></label>
                                </div>
                            </div>

                                 
                            <div class="form-group" id="facebook">
                                <label class="col-md-3 col-xs-12 control-label">Facebook</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="facebook" id="facebook_input" class="form-control" value="{{ $eventSponsor->facebook }}"/>
                                    </div>
                                    <label id="facebook_err" class="help-block redl"></label>
                                </div>
                            </div>

                           <div class="form-group" id="twitter">
                                <label class="col-md-3 col-xs-12 control-label">Twitter</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="twitter" id="twitter_input" class="form-control" value="{{ $eventSponsor->twitter }}"/>
                                    </div>
                                    <label id="twitter_err" class="help-block redl"></label>
                                </div>
                            </div>
                            
                            <div class="form-group" id="linkedin">
                                <label class="col-md-3 col-xs-12 control-label">Linkedin</label>
                                <div class="col-md-7 col-xs-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="redl"></span></span>
                                        <input type="text" name="linkedin" id="linkedin_input" class="form-control" value="{{ $eventSponsor->linkedin }}"/>
                                    </div>
                                    <label id="linkedin_err" class="help-block redl"></label>
                                </div>
                            </div>
                            

                            
                            <div class="form-group">
                                <label class="col-md-3"></label>
                                <label class="help-block col-md-7"></label>
                            </div>
                        </div>
                        
                        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
                            <span><strong id="welcome">Conference Sponsors Accepted successfully !</strong> </span>
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


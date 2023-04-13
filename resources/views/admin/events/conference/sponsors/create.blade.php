@extends('admin.layouts.master') @section('panel-title')Become a sponsor <small>{{ $event }}</small>@endsection @section('content')
<!-- PAGE CONTENT WRAPPER -->
<script type="text/javascript" charset="utf-8" async defer>
$(document).ready(function() {
    $('#create').on('click', function(event) {
        event.preventDefault();
        var err = document.getElementsByClassName('error');
        $(err).hide(500);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })
        var myForm = document.getElementById('create_form');
        var formData = new FormData(myForm);
        var alertArea = document.getElementById('alert');
        var alertPlace = $(alertArea).children('span');
        var alertContent = $(alertPlace).html();
        $.ajax({

            type: 'POST',
            url: '/admin/events/conference/sponsors/store/{{ $event_id }}',
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
            success: function(response) {
                //check if response with success : true/false
                var success = response.success;
                var errors = (response.errs);
                if (success == false) {
                    $(alertArea).fadeIn(200);
                    alertContent = '<strong id="welcome">Please fix these errors</strong>';
                    $(alertPlace).html(alertContent);
                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('has-error');
                        $('#' + key + '_err').html(value);
                    });
                } else {
                    $('input').each(function() {
                        $(this).val('');
                    });
                    $('#success').delay(350).fadeIn(200);
                    setTimeout(
                        function() {
                            window.open('/admin/events/conference/sponsors/{{ $event_id }}', '_self');
                            $('#success').fadeOut(200);
                        }, 1000);
                }
                $('#loading').fadeOut(200);
            },
            error: function(response) {
                //console.log(response);           
            }
        });
    });
});
</script>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="post" id="create_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="post">
                <input type="hidden" name="event_id" value="{{ $event_id }}">
                <div class="panel panel-default">
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            <p>Fill in sponsors information.</p>
                            <p>Fields with <span class="redl">*</span> is required.</p>
                            
                            <div class="form-group" id="company_name">
                                <label class="col-md-3 col-xs-12 control-label">Company Name</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl">*</span></span>
                                        <input type="text" name="company_name" id="company_name_input" class="form-control" />
                                    </div>
                                    <label id="company_name_err" class="help-block redl"></label>
                                </div>
                            </div>
                            
                            <div class="form-group" id="brief_description">
                                <label class="col-md-3 col-xs-12 control-label">Brief Description </label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl">*</span></span>
                                        <textArea name="brief_description" id="brief_description_input" class="form-control" ></textarea>
                                    </div>
                                    <label id="brief_description_err" class="help-block redl"></label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Logo <span class="redl"></span></label>
                                
                                <div class="col-md-6 col-xs-12">                                                
                                    <input type="file" accept="image/*" class="image_file" name="img" id="img" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group" id="website">
                                <label class="col-md-3 col-xs-12 control-label">Website</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl"></span></span>
                                        <input type="text" name="website" id="website_input" class="form-control" />
                                    </div>
                                    <label id="website_err" class="help-block redl"></label>
                                </div>
                            </div>

                            <div class="form-group" id="contact_person_name">
                                <label class="col-md-3 col-xs-12 control-label">Name</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl">*</span></span>
                                        <input type="text" name="contact_person_name" id="contact_person_name_input" class="form-control" />
                                    </div>
                                    <label id="contact_person_name_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="phone">
                                <label class="col-md-3 col-xs-12 control-label">Phone Number</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl"></span></span>
                                        <input type="text" name="phone" id="phone_input" class="form-control" />
                                    </div>
                                    <label id="phone_err" class="help-block redl"></label>
                                </div>
                            </div>
                            <div class="form-group" id="email">
                                <label class="col-md-3 col-xs-12 control-label">Email</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl">*</span></span>
                                        <input type="text" name="email" id="email_input" class="form-control" />
                                    </div>
                                    <label id="email_err" class="help-block redl"></label>
                                </div>
                            </div>


                             <div class="form-group" id="proposal">
                                <label class="col-md-3 col-xs-12 control-label">Please describe your proposal </label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl">*</span></span>
                                        <textArea name="proposal" id="proposal_input" class="form-control" ></textarea>
                                    </div>
                                    <label id="proposal_err" class="help-block redl"></label>
                                </div>
                            </div>


                            
                            
                            <div class="form-group" id="facebook">
                                <label class="col-md-3 col-xs-12 control-label">Facebook Page</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="redl"></span></span>
                                        <input type="text" name="facebook" id="facebook_input" class="form-control" />
                                    </div>
                                    <label id="facebook_err" class="help-block redl"></label>
                                </div>
                            </div>
                            
                            <div class="form-group" id="twitter">
                                <label class="col-md-3 col-xs-12 control-label">Twitter Page</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="red1"></span></span>
                                        <input type="text" name="twitter" id="twitter_input" class="form-control" />
                                    </div>
                                    <label id="twitter_err" class="help-block redl"></label>
                                </div>
                            </div>

                            <div class="form-group" id="linkedin">
                                <label class="col-md-3 col-xs-12 control-label">Linkedin Page</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="red1"></span></span>
                                        <input type="text" name="linkedin" id="linkedin_input" class="form-control" />
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
                            <span><strong id="welcome">Your Request has been sent successfully !</strong> </span>
                        </div>
                        <div id="alert" class="alert alert-danger" style="margin-top:1em; display:none;">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span></span>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default pull-right" id="create">Send Request<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
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

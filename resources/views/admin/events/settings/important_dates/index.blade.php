@extends('admin.layouts.master')
@section('panel-title')Important Dates Settings @endsection
@section('content')
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
        var myForm = document.getElementById('update_form');
        var formData = new FormData(myForm);
        $.ajax({

        type: 'POST',
        url: '{{ route("updateImportantDatesSettings", 1) }}',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
            beforeSend: function(xhr) {
                $('#success').fadeOut(200);
                $('#loading').delay(350).fadeIn(200);
            },
            success: function (response) {
                //check if response with success : true/false
                console.log(response);
                if(response == 1){
                    $('#success').delay(350).fadeIn(200);
                    setTimeout(
                        function(){
                            $('#success').fadeOut(200);
                        }
                    ,5000);
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
<div class="panel">
    <div class="panel-body">
        <form id="update_form" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">
            <input type="hidden" name="_method" value="PUT">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Abstract Submissions Deadline</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="submission_close" value="{{ $settings->submission_close }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Last Notification for Abstract Acceptance</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="submission_last" value="{{ $settings->submission_last }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Full Paper Submission Deadline</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="full_paper_close" value="{{ $settings->full_paper_close }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Last Notification for Full-Paper Acceptance</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="full_paper_last" value="{{ $settings->full_paper_last }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Early Payment Deadline</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="early_payment"  value="{{ $settings->early_payment }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Regular Payment Deadline</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="regular_payment"  value="{{ $settings->regular_payment }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Late Payment Deadline</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="late_payment"  value="{{ $settings->late_payment }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Final Issuing of Letter of Visa (for delegates who need visa entry)</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="visa_letter"  value="{{ $settings->visa_letter }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Letter of Final Acceptance</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="final_acceptance"  value="{{ $settings->final_acceptance }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Conference Program</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="conference_program"  value="{{ $settings->conference_program }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                    <div class="form-group  col-md-12">
                        <label class="col-md-7 col-xs-12 control-label">Conference Launch</label>
                        <div class="col-md-5 col-xs-12"> 
                            <input type="number" class="form-control" min="0" name="conference_launch"  value="{{ $settings->conference_launch
                             }}">
                            <label class="help-block">Days before conference</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
            <span><strong id="welcome">Important Dates Settings updated successfully !</strong> </span>
        </div>
    </div>
    <div class="panel-footer">                                    
        <button class="btn btn-success pull-right" id="update">Update</button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none;margin-right:1em;" class="pull-right" id="loading">
    </div>
</div>
@endsection
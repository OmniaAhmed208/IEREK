@extends('admin.layouts.master')
@section('panel-title')Conference Important Dates @endsection
@section('content')
<script type="text/javascript" charset="utf-8" async defer>
$(document).ready( function() {
    $('#update').on('click', function(event) {
        event.preventDefault();
        var myForm = document.getElementById('update_form');
        var formData = new FormData(myForm);
        $.ajax({
        type: 'POST',
        url: '{{ route("updateConferenceDates", @$apply["id"]) }}',
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
                if(response.success == true){
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
            }
        });
    });
});
</script>
<div class="panel">
    <div class="panel-body">
        <form id="update_form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <div class="col-md-12">
                <div class="col-md-12">
                    <input type="button" id="defaults" onclick="confirmDefaults()" class="btn btn-danger" name="defaults" value="Apply Default Conference Important Dates Settings">
                </div>
                <hr>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Abstract Submissions Deadline</label> 
                        <input type="text" class="form-control datepicker" name="submission_close" data-default="{{ @$apply['submission_close'] }}" value="@if(@$iDates[0]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[0]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="submission_close_en" class="form-control">{{ @$iDates[0]->title_en }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Last Notification for Abstract Acceptance</label> 
                        <input type="text" class="form-control datepicker" name="submission_last" data-default="{{ @$apply['submission_last'] }}" value="@if(@$iDates[1]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[1]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="submission_last_en" class="form-control">{{ @$iDates[1]->title_en }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Full Paper Submission Deadline</label> 
                        <input type="text" class="form-control datepicker" name="full_paper_close" data-default="{{ @$apply['full_paper_close'] }}" value="@if(@$iDates[2]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[2]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="full_paper_close_en" class="form-control">{{ @$iDates[2]->title_en }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Last Notification for Full-Paper Acceptance</label> 
                        <input type="text" class="form-control datepicker" name="full_paper_last" data-default="{{ @$apply['full_paper_last'] }}" value="@if(@$iDates[3]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[3]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="full_paper_last_en" class="form-control">{{ @$iDates[3]->title_en }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Early Payment Deadline</label> 
                        <input type="text" class="form-control datepicker" name="early_payment" data-default="{{ @$apply['early_payment'] }}" value="@if(@$iDates[4]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[4]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="early_payment_en" class="form-control">{{ @$iDates[4]->title_en }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Regular Payment Deadline</label> 
                        <input type="text" class="form-control datepicker" name="regular_payment" data-default="{{ @$apply['regular_payment'] }}" value="@if(@$iDates[5]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[5]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="regular_payment_en" class="form-control">{{ @$iDates[5]->title_en }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Late Payment Deadline</label> 
                        <input type="text" class="form-control datepicker" name="late_payment" data-default="{{ @$apply['late_payment'] }}" value="@if(@$iDates[6]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[6]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="late_payment_en" class="form-control">{{ @$iDates[6]->title_en }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Final Issuing of Letter of Visa (for delegates who need visa entry)</label> 
                        <input type="text" class="form-control datepicker" name="visa_letter" data-default="{{ @$apply['visa_letter'] }}" value="@if(@$iDates[7]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[7]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="visa_letter_en" class="form-control">{{ @$iDates[7]->title_en }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Letter of Final Acceptance</label> 
                        <input type="text" class="form-control datepicker" name="final_acceptance" data-default="{{ @$apply['final_acceptance'] }}" value="@if(@$iDates[8]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[8]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="final_acceptance_en" class="form-control">{{ @$iDates[8]->title_en }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Conference Program</label> 
                        <input type="text" class="form-control datepicker" name="conference_program" data-default="{{ @$apply['conference_program'] }}" value="@if(@$iDates[9]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[9]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="conference_program_en" class="form-control">{{ @$iDates[9]->title_en }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group  col-md-4">
                        <label>Conference Launch</label> 
                        <input type="text" class="form-control datepicker" name="conference_launch" data-default="{{ @$apply['conference_launch'] }}" value="@if(@$iDates[10]->to_date != '0000-00-00 00:00:00')  {{ @date('Y-m-d', strtotime(@$iDates[10]->to_date)) }} @endif">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="formGroupExampleInput">Description</label>
                        <textarea name="conference_launch_en" class="form-control">{{ @$iDates[10]->title_en }}</textarea>
                    </div>
                </div>
            </div>
        </form>
        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
            <span><strong id="welcome">Conference Important Dates Updated Successfully !</strong> </span>
        </div>
    </div>
    <div class="panel-footer">                                    
        <button class="btn btn-success pull-right" id="update">Update</button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none;margin-right:1em;" class="pull-right" id="loading">
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/noty/jquery.noty.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/noty/layouts/topCenter.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/noty/layouts/center.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/admin/plugins/noty/layouts/topRight.js') }}"></script>            

<script type='text/javascript' src="{{ asset('js/admin/plugins/noty/themes/default.js') }}"></script>
<script>
    function confirmDefaults(){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure you want to apply default conference important date settings, this will override all your current conference important dates and replace them with default settings ?',
            layout: 'center',
            buttons: [
                    {addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
                        $noty.close();
                        $('input[type=text]').each(function(){
                            var dDate = $(this).data('default');
                            $(this).val(dDate);
                        })
                    }
                    },
                    {addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
                        $noty.close();
 
                        }
                    }
                ]
            });
    }
</script>
@endsection
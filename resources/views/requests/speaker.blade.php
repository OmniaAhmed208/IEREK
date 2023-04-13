@extends('layouts.master')
@section('content')
@section('panel-title')Become a speaker
<small>{{ $event }}</small>@endsection

<!-- PAGE CONTENT WRAPPER -->
<style>
    #full_name_err, #img_err, #cv_err, #email_err {
        color: red;
    }
</style>

<div class="container">
    <div class="">
        <div class="col-md-12" id="becomeASpeaker">
            <form class="form-horizontal" method="post" id="create_form">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" id="method" value="post">
                <input type="hidden" name="event_id" id="event_id" value="{{ $event_id }}">
                <div class="panel panel-default">
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active becomeASpeakerTemplate" id="tab-General">
                            <div class="becomeASpeakerTitleMobile">
                                Become A Speaker
                            </div>
                            <div class="becomeASpeakerImg"
                                 style="width:100%;height:200px;background-image:url('{{url('/uploads/images/become_speaker.jpg')}}');background-size:cover;background-repeat:no-repeat;background-position:center center;margin-bottom: 30px;">

                            </div>
                            <div class="container-fluid inputs-container">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="form-group" id="full_name">
                                            <label class="col-md-3 col-xs-12">Full Name<span
                                                        class="redl">*</span></label>
                                            <div class="col-md-9 col-xs-12 centering-text">
                                                <div class="input-group">
                                                    <input type="text" name="full_name" id="full_name_input"/>
                                                </div>
                                                <label id="full_name_err" class="help-block redl"></label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="email">
                                            <label class="col-md-3 col-xs-12">Email<span class="redl">*</span></label>
                                            <div class="col-md-9 col-xs-12 centering-text">
                                                <div class="input-group">
                                                    <input type="text" name="email" id="email_input"/>
                                                </div>
                                                <label id="email_err" class="help-block redl"></label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12">Image (High Resolution) <span
                                                        class="redl">*</span></label>

                                            <div class="col-md-9 col-xs-12 centering-text new_input_field_container">

                                                <input type="file" accept="image/*" name="img" id="img"
                                                       class="inputfile inputfile-2"/>
                                                <label for="img">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                                         viewBox="0 0 20 17">
                                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                    </svg>
                                                    <span>Choose a file&hellip;</span>
                                                </label>
                                                <label id="img_err" class="help-block redl"></label>
                                            </div>


                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12">CV <span class="redl">*</span></label>
                                            <div class="col-md-9 col-xs-12 centering-text new_input_field_container">

                                                <input type="file" accept=".doc, .docx, .pdf" name="cv" id="cv"
                                                       class="inputfile inputfile-2"/>
                                                <label for="cv">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                                         viewBox="0 0 20 17">
                                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                    </svg>
                                                    <span>Choose a file&hellip;</span>
                                                </label>
                                                <label id="cv_err" class="help-block redl"></label>
                                            </div>

                                        </div>
                                        <div class="form-group" id="brief_description">
                                            <label class="col-md-3 col-xs-12">Brief about your lecture </label>
                                            <div class="col-md-9 col-xs-12 centering-text">
                                                <div class="input-group">
                                                    <span class="redl"></span>
                                                    <textArea name="brief_description" id="brief_description_input"
                                                              class="text-brief"></textarea>
                                                </div>
                                                <label id="brief_description_err" class="help-block redl"></label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="university">
                                            <label class="col-md-3 col-xs-12">University | Institute</label>
                                            <div class="col-md-9 col-xs-12 centering-text">
                                                <div class="input-group">
                                                    <span class="red1"></span>
                                                    <input type="text" name="university" id="university_input"/>
                                                </div>
                                                <label id="university_err" class="help-block redl"></label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="linkedin">
                                            <label class="col-md-3 col-xs-12">Linkedin</label>
                                            <div class="col-md-9 col-xs-12 centering-text">
                                                <div class="input-group">
                                                    <span class="red1"></span>
                                                    <input type="text" name="linkedin" id="linkedin_input"/>
                                                </div>
                                                <label id="linkedin_err" class="help-block redl"></label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="twitter">
                                            <label class="col-md-3 col-xs-12">Twitter</label>
                                            <div class="col-md-9 col-xs-12 centering-text">
                                                <div class="input-group">
                                                    <span class="red1"></span>
                                                    <input type="text" name="twitter" id="twitter_input"/>
                                                </div>
                                                <label id="twitter_err" class="help-block redl"></label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="facebook">
                                            <label class="col-md-3 col-xs-12">Facebook</label>
                                            <div class="col-md-9 col-xs-12 centering-text">
                                                <div class="input-group">
                                                    <span class="redl"></span>
                                                    <input type="text" name="facebook" id="facebook_input"/>
                                                </div>
                                                <label id="facebook_err" class="help-block redl"></label>
                                            </div>
                                        </div>
                                        {{--<div class="form-group">--}}
                                        {{--<label class="col-md-3"></label>--}}
                                        {{--<label class="help-block col-md-9"></label>--}}
                                        {{--</div>--}}

                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12"></label>
                                            <div class="col-md-9 col-xs-12 centering-text">
                                                <div>
                                                    <div id="success" class="alert alert-success"
                                                         style="margin-top:1em; display:none;">
                                                        <span><strong id="welcome">Your Request has been sent successfully !</strong> </span>
                                                    </div>
                                                    <div id="alert" class="alert alert-danger" style="display:none;">
                                                        <button type="button" class="close" data-dismiss="alert"><span
                                                                    aria-hidden="true">&times;</span><span
                                                                    class="sr-only">Close</span></button>
                                                        <span></span>
                                                    </div>
                                                    <button type="button"
                                                            class="btn btn-default centringClass main-submit-button"
                                                            id="create">
                                                        Send Request
                                                    </button>&ensp;
                                                    <br>
                                                    <img
                                                            src="{{ asset('loading.gif') }}" alt="loading"
                                                            style="display:none" id="loading">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<script type="text/javascript" charset="utf-8" async defer>


    (function (document, window, index) {
        var inputs = document.querySelectorAll('.inputfile');
        Array.prototype.forEach.call(inputs, function (input) {
            var label = input.nextElementSibling,
                labelVal = label.innerHTML;

            input.addEventListener('change', function (e) {
                var fileName = '';
                if (this.files && this.files.length > 1)
                    fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                else
                    fileName = e.target.value.split('\\').pop();

                if (fileName)
                    label.querySelector('span').innerHTML = fileName;
                else
                    label.innerHTML = labelVal;
            });

            // Firefox bug fix
            input.addEventListener('focus', function () {
                input.classList.add('has-focus');
            });
            input.addEventListener('blur', function () {
                input.classList.remove('has-focus');
            });
        });
    }(document, window, 0));
    $(document).ready(function () {
        $('#create').on('click', function (event) {

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
                url: '/speaker/store/{{ $event_id }}',

                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function (xhr) {
                    $(alertArea).fadeOut(200);
                    $(alertPlace).html('');
                    $('.form-group').each(function () {
                        $(this).removeClass('has-error');
                    });
                    $('.help-block').each(function () {
                        $(this).text('');
                    });
                    $('.input-group').each(function () {
                        $(this).removeClass('has-error');
                    });
                    $('#success').fadeOut(200);
                    $('#loading').delay(350).fadeIn(200);
                },
                success: function (response) {
                    //check if response with success : true/false
                    var success = response.success;
                    var errors = (response.errs);
                    if (success == false) {
                        console.log("in false");
                        $(alertArea).fadeIn(200);
                        alertContent = '<strong id="welcome">Please fix these errors</strong>';
                        $(alertPlace).html(alertContent);
                        $.each(errors, function (key, value) {
                            $('#' + key).addClass('has-error');
                            $('#' + key + '_err').html(value);
                        });
                    } else {
                        console.log("success");
                        $('input').each(function () {
                            $(this).val('');
                        });
                        $('#success').delay(350).fadeIn(200);
                        setTimeout(
                            function () {
                                window.open('/events/{{ $slug }}', '_self');
                                $('#success').fadeOut(200);
                            }, 1000);
                    }
                    $('#loading').fadeOut(200);
                },
                error: function (response) {

                    $('input').each(function () {
                        $(this).val('');
                    });
                    $('#success').delay(350).fadeIn(200);
                    setTimeout(
                        function () {
                            window.open('/events/{{ $slug }}', '_self');
                            $('#success').fadeOut(200);
                        }, 1000);
                    $('#loading').fadeOut(200);
                }

            });

        });
    });
</script>
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
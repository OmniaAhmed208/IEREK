@extends('layouts.master')
@push('styles')
    <style>
        figure {
            min-height: 60px;
        }

        #regconf {
            /*position: absolute;*/
            /*top: 0;*/
            /*right: 0;*/
            margin-right: 25px;
            margin-top: 10px;
        }

        input[type=checkbox] {
            position: absolute;
            width: 17px;
            padding: 0;
            margin: 0;
            height: 17px;
            top: 4px
        }
    </style>
@endpush
@php $cd = 0; $ed = 0; @endphp
@section('content')
    <div class="container normal-table-layout" id="applying-area">
        <figure class="cover-img">
            <img src="/storage/uploads/studies/{{ @$event->event_id }}/cover_img.jpg" alt="{{ @$event->title_en }}"/>
            @if(Auth::check())
                @if($isreg == 1)
                    <a href="/payment/{{ @$event->slug }}" id="regconf"
                       class="popup-register conference-registration-btn">Fees<span class="hidden-xs">Payment</span>
                    </a>
                @else
                    <a href="javascript:void(0);" onclick="showSection('register','register')" id="regconf"
                       class="popup-register conference-registration-btn"><i class="fa fa-graduation-cap"></i>
                        Apply<span class="hidden-xs">For Students</span> </a>
                @endif
            @else
                <a href="javascript:void(0);" onclick="display_log(0)" id="regconf"
                   class="popup-register conference-registration-btn"><i class="fa fa-graduation-cap"></i> Login<span
                            class="hidden-xs">For Apply</span> </a>
            @endif
        </figure>
        <div class="row">
            <div class="col-md-3">
                <div class="quick-links">
                    <div class="frame-title">Navigation</div>
                    <ul class="additional-menu">
                        @foreach($sections as $section)
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                <a href="#{{ strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '', $section->title_en))) }}"
                                   class="navx @if($section->section_type_id == 7)  @endif"
                                   data-section="{{ strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '', $section->title_en))) }}"
                                   style="<?php if ($section->section_type_id == 1) {
                                       echo 'background:#f9f9f9';
                                   } ?>">{{ ucwords(strtolower($section->title_en)) }}</a>
                            </li>
                        @endforeach
                        @if(Auth::check())
                            @if($isreg != 1)
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                    <a href="javascript:void(0);" onclick="showSection('register','register')">Registration</a>
                                </li>
                            @endif
                        @else
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4030">
                                <a href="javascript:void(0);" onclick="display_log(0)">Registration</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                @foreach($sections as $section)
                    <div style="overflow: hidden;margin-top:0px" class="styled-box section"
                         <?php if ($section->section_type_id != 1) {
                             echo 'style="display:none"';
                         } ?> id="{{ strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '', $section->title_en))) }}">
                        <div class="box-title">
                            {{ ucwords(strtolower($section->title_en)) }}
                        </div>
                        <div class="box-content">
                            <section>
                                @if($section->section_type_id == 2)
                                    <?php echo $section->description_en; ?>
                                    @if(isset($topics) && count($topics) > 0)
                                        <ol class="styled-list">
                                            @foreach($topics as $topic)
                                                <li>
                                                    {{ $topic->position.'. '.ucwords(strtolower($topic->title_en)) }}
                                                    @if(strlen($topic->description_en) > 20)
                                                        <div class="topic-description">
                                                            <p><?php  echo $topic->description_en; ?></p>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                @elseif($section->section_type_id == 6)
                                    <?php echo $section->description_en; ?>
                                    @if(isset($dates) && count($dates) > 0)
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Notes</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($dates as $date)
                                                @if($date->to_date != '0000-00-00 00:00:00')
                                                    <tr <?php if(date("Y-m-d", strtotime($date->to_date)) == $ced){?> class="success"
                                                        style="box-shadow: 0 2px 5px rgba(0,0,0,0.4);" <?php }elseif (date("Y-m-d", strtotime($date->to_date)) < $ced) {
                                                        echo 'style="background:#eee;text-decoration:line-through;color:red"';
                                                    }elseif ($cd > $ed) {
                                                        echo 'style="background:#eee;"';
                                                    }?> >
                                                        <td style="color:#666!important">{{ $date->title }}</td>
                                                        <td style="color:#666!important">{{ date("jS F Y", strtotime($date->to_date) ) }}</td>
                                                        <td style="color:#666!important">{{ $date->title_en }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                @elseif($section->section_type_id == 7)
                                    <?php if (file_exists('storage/uploads/conferences/' . @$event->event_id . '/featured_img.jpg')) {
                                        echo '<img src="/storage/uploads/conferences/' . @$event->event_id . '/featured_img.jpg" style="float: right;margin: 0px 0px 15px 15px;" class="procedia-right;width:125px">';
                                        echo strip_tags($section->description_en);
                                    } else {
                                        echo $section->description_en;
                                    } ?>
                                @elseif($section->section_type_id == 3)
                                    <?php echo $section->description_en; ?>
                                    @if(isset($fees) && count($fees) > 0)
                                        <table class="table table-bordered table-hover hidden">
                                            <caption><b>Regular Attendance Fees</b></caption>
                                            <tbody>
                                            @foreach($fees as $fee)
                                                @if($fee->deleted != 1)
                                                    @if($fee->event_attendance_type_id == 1)
                                                        <tr @if($fee->event_date_type_id == 5)<?php echo $rp_closed;?>@elseif($fee->event_date_type_id == 6)<?php echo $sp_closed;?>@elseif($fee->event_date_type_id == 7)<?php echo $lp_closed;?>@endif >
                                                            <td style="color:#666!important"><b>{{ $fee->title_en }}</b>
                                                            </td>
                                                            <td style="color:#666!important">{{$fee->currency.' '}}{{ $fee->amount }}</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-hover hidden">
                                            <caption><b>Co-Authors Fees</b></caption>
                                            <tbody>
                                            @foreach($fees as $fee)
                                                @if($fee->deleted != 1)
                                                    @if($fee->event_attendance_type_id == 2)
                                                        <tr @if($fee->event_date_type_id == 5)<?php echo $rp_closed;?>@elseif($fee->event_date_type_id == 6)<?php echo $sp_closed;?>@elseif($fee->event_date_type_id == 7)<?php echo $lp_closed;?>@endif >
                                                            <td style="color:#666!important"><b>{{ $fee->title_en }}</b>
                                                            </td>
                                                            <td style="color:#666!important">{{$fee->currency.' '}}{{ $fee->amount }}</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-hover hidden">
                                            <caption><b>Authors & Publication Fees</b></caption>
                                            <tbody>
                                            @foreach($fees as $fee)
                                                @if($fee->deleted != 1)
                                                    @if($fee->event_attendance_type_id == 3)
                                                        <tr @if($fee->event_date_type_id == 5)<?php echo $rp_closed;?>@elseif($fee->event_date_type_id == 6)<?php echo $sp_closed;?>@elseif($fee->event_date_type_id == 7)<?php echo $lp_closed;?>@endif >
                                                            <td style="color:#666!important"><b>{{ $fee->title_en }}</b>
                                                            </td>
                                                            <td style="color:#666!important">{{$fee->currency.' '}}{{ $fee->amount }}</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>

                                        <table class="table table-bordered table-hover">
                                            <caption><b>Services Fees</b></caption>
                                            <tbody>
                                            @foreach($fees as $fee)
                                                @if($fee->deleted != 1)
                                                    @if($fee->event_attendance_type_id == 0)
                                                        <tr @if($fee->event_date_type_id == 5)<?php echo $rp_closed;?>@elseif($fee->event_date_type_id == 6)<?php echo $sp_closed;?>@elseif($fee->event_date_type_id == 7)<?php echo $lp_closed;?>@endif >
                                                            <td style="color:#666!important"><b>{{ $fee->title_en }}</b>
                                                            </td>
                                                            <td style="color:#666!important">{{$fee->currency.' '}}{{ $fee->amount }}</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                @elseif($section->section_type_id == 10)
                                    <input type="hidden" id="gmap_geocoding_address" value="{{@$event->location_en}}">
                                    <?php echo $section->description_en; ?>
                                    <div class="box-content" id="gmap_geocoding" style="height: 250px;">

                                    </div>
                                @else
                                    <?php echo $section->description_en; ?>
                                @endif
                            </section>
                        </div>
                    </div>
                @endforeach

                @if(Auth::check() && $isreg === 0)
                    <div style="overflow: hidden;margin-top:0px;display:none" class="styled-box section" id="register">
                        <form name="application" id="application" action="/study_abroad_categories/register"
                              method="post">
                            {{ csrf_field() }}
                            <div class="container-fluid">
                                <input type="hidden" name="event_id" value="{{ @$event->event_id }}">
                                <div class="styled-box">
                                    <center>
                                        <h4>FUTURE EDUCATION</h4>
                                    </center>
                                    <div class="form-group">
                                        <select name="degree" class="form-control requiredz">
                                            <option value="0" selected disabled>Choose Degree Program</option>
                                            <option value="Bachelors">Bachelors</option>
                                            <option value="Master">Master</option>
                                            <option value="Online">Online</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="field" class="form-control requiredz"
                                               placeholder="Specialty/Field of Study">
                                    </div>
                                    <div class="form-group">
                                        <label>University you would like to enter:</label>
                                        <input type="text" name="uni1" class="form-control" placeholder="1st Option">
                                    </div>
                                    <div class="form-group">
                                        <span>You can leave the fields empty and we will choose for you the appropriate university</span>

                                        <input type="text" name="uni2" class="form-control" placeholder="2nd Option">

                                    </div>
                                    <div class="form-group">
                                        <label>Year you want to apply?</label>
                                        <input type="text" name="apply_year" class="form-control"
                                               placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                                <hr class="main-hr">

                                <div class="styled-box">
                                    <center>
                                        <h4>PERSONAL DATA</h4>
                                    </center>
                                    <div class="form-group">
                                        <input type="text" name="full_name" class="form-control requiredz"
                                               placeholder="Full Name"
                                               value="{{ @$data = auth()->user()->first_name.' '.@$data = auth()->user()->last_name }}">
                                    </div>
                                    <div class="form-group form-group-centeredContent">
                                        <div class="row">
                                            <div class="col-md-6 pl-0">
                                                <select name="gender" class="form-control requiredz">
                                                    <option value="0" {{ @$data = auth()->user()->gender === 0 ? 'selected disabled' : '' }} >
                                                        Gender
                                                    </option>
                                                    <option value="Male" {{ @$data = auth()->user()->gender === 1 ? 'selected' : '' }}>
                                                        Male
                                                    </option>
                                                    <option value="Female" {{ @$data = auth()->user()->gender === 2 ? 'selected' : '' }}>
                                                        Female
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 pr-0">
                                                <input type="text" name="birth_date" class="form-control"
                                                       placeholder="Date of Birth"
                                                       value="{{ @$data = auth()->user()->age }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="nationality" class="form-control requiredz"
                                                       placeholder="Nationality"
                                                       value="{{ @$data = auth()->user()->countries->name }}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="pp_no" class="form-control"
                                                       placeholder="Passport No.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="pp_issue" class="form-control"
                                                       placeholder="Passport Issue Date">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="pp_expire" class="form-control"
                                                       placeholder="Passport Expire Date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="address" class="form-control"
                                               placeholder="Present Address">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="phone" class="form-control requiredz"
                                                       placeholder="Phone with country code"
                                                       value="{{ @$data = auth()->user()->phone }}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="email" class="form-control requiredz"
                                                       placeholder="Email" value="{{ @$data = auth()->user()->email }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <select name="travel" class="form-control">
                                            <option value="0" selected disabled>Did you travel before?</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="where" class="form-control"
                                               placeholder="Where? (please specify)">
                                    </div>
                                </div>
                                <hr class="main-hr">

                                <div class="styled-box">
                                    <center>
                                        <h4>EDUCATIONAL BACKGROUND</h4>
                                    </center>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" name="school" class="form-control"
                                                       placeholder="School Name">
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="school_address" class="form-control"
                                                       placeholder="School Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Years of study:</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" name="from" class="form-control"
                                                       placeholder="FROM YYYY-MM-DD">
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="to" class="form-control"
                                                       placeholder="TO YYYY-MM-DD">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="school_cert" class="form-control"
                                               placeholder="Received Certificate">
                                    </div>
                                    <div class="form-group">
                                        <label>English Level</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="toefl_level" class="form-control"
                                                       placeholder="TOEFL Level">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="ielts_level" class="form-control"
                                                       placeholder="IELTS Level">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="main-hr">

                                <div class="styled-box">
                                    <center>
                                        <h4>COLLEGE/UNIVERSITY</h4>
                                    </center>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" name="college" class="form-control"
                                                       placeholder="Name">
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="college_address" class="form-control"
                                                       placeholder="Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="college_cert" class="form-control"
                                               placeholder="Received Certificate">
                                    </div>
                                </div>
                                <hr class="main-hr">

                                <div class="styled-box">
                                    <center>
                                        <h4>PREFERENCES</h4>
                                    </center>
                                    <div class="form-group">
                                <textarea name="study_location" class="form-control"
                                          placeholder="Which geographic area or country would you like to study in?"></textarea>
                                    </div>

                                    <div class="form-group">
                                <textarea name="study_budget" class="form-control"
                                          placeholder="How much budget per year can you afford?"></textarea>
                                    </div>

                                    <div class="form-group">
                                <textarea name="study_domain" class="form-control"
                                          placeholder="Which domain of study you like?"></textarea>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" onclick="submitApplication(event);"
                                                class="btn btn-primary btn-lg undergrad_studies_btn"><i
                                                    class="fa fa-graduation-cap"></i> Submit My Application
                                        </button>
                                        <div class="pull-right hide" id="caloading" style="padding-top: 4px;">
                                            <img class="pull-right" src="/loadingx.gif">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                @else
                    <div style="overflow: hidden;margin-top:0px;display:none" class="styled-box section" id="applied">
                        <h3>Success!</h3>
                        <p>You have been successfully applied for {{ @$event->title_en }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function showSection(id, asset) {
            $('.section').each(function () {
                $(this).slideUp(200);
            });
            $('.navx').each(function () {
                $(this).css('background', '#fff');
            });
            $(asset).css('background', '#f1f1f1');
            $('#' + id).slideDown(200);
            setTimeout(function () {
                window.open('#' + id, '_self')
            }, 200);
        }

        function startSection(id, asset) {
            $('.section').each(function () {
                $(this).slideUp(200);
            });
            $('.navx').each(function () {
                $(this).css('background', '#fff');
            });
            $(asset).css('background', '#f1f1f1');
            $('#' + id).slideDown(200);
        }

        function fixTables() {
            $('table').each(function () {
                $(this).attr('style', '');
                $(this).css('width', '100%!important');
            });
        }

        function submitApplication(event) {
            event.preventDefault();
            $('.form-group').each(function () {
                $(this).removeClass('has-error');
            });
            formErrors = 0;
            $('select.requiredz').each(function () {
                if ($(this).val() == 0 || $(this).val() == undefined) {
                    $(this).parent('.form-group').addClass('has-error');
                    formErrors++;
                }
            });
            $('input.requiredz').each(function () {
                if ($(this).val() == '') {
                    $(this).parent('.form-group').addClass('has-error');
                    formErrors++;
                }
            });
            if (formErrors > 0) {
                showSection('register', 'register');
                informX('Please fill in the required frields!');
            } else {
                var myForm = document.getElementById('application');
                var formData = new FormData(myForm);
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                //     }
                // });
                $.ajax({
                    type: 'POST',
                    url: '{{ url("study_abroad_categories/register") }}',
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function (xhr) {
                        //loading ajax animation
                        $('#caloading').removeClass('hide');
                    },
                    success: function (response) {
                        $('#caloading').addClass('hide');
                        if (response.success === true) {
                            window.location.href = "/study_abroad_categories/undergraduate-studies#applied";
                            location.reload();
                        } else {
                            alertX('Error: please try again, or contact our support');
                        }
                    },
                    error: function (response) {
                        $('#caloading').addClass('hide');
                        informX('An error has been occured, please try again, or contact our support');
                    }
                });
            }
        }

        $(document).ready(function () {
            $('.navs').each(function () {
                $(this).on('click', function () {
                    var section_id = $(this).data('section');
                    showSection(section_id, this);
                });
            });
            $('.navx').each(function () {
                $(this).on('click', function () {
                    var section_id = $(this).data('section');
                    showSection(section_id, this);
                });
            });

            var current = window.location.hash;
            current = current.replace('#', '');
            var first = document.getElementsByClassName('section')[0];
            if (current != '' && current != undefined) {
                var asset = $('.navx[data-section=' + current + ']');
                startSection(current, asset);
            }
            // else{
            //     var asset = document.getElementsByClassName('navx')[0];
            //     var current = $(first).attr('id');
            //     showSection(current, asset);
            // }

            fixTables()
            @if((Auth::check()))
            @if($paid != 1)
            @if(@$postpone < date('Y-m-d') && $isreg == 1)
            @if($cd < $ed)
            confirmX('<strong>Dear Colleague</strong>,<br>You have successfully registered in this conference: <b>{{@$event->title_en}}</b>, please confirm your registration as you should pay the requiredz fees to be confirmed.@if(@$event->submission != 1 && $abst == 1)<br><br><strong>For Authors</strong>,<br>Please delay your payment until {{@$event->submission.' '.$abst}} your abstract is accepted.<br><a style="text-decoration: underline" href="{{ url('/abstract/'.@$event->slug) }}">Click to submit an abstract</a>@endif', '{{ url('/payment/'.@$event->slug) }}', 'Payment', '<a href="/event/{{ @$event->slug }}/postpone">Remind Me Later</a>');
            @endif
            @endif
            @endif
            @endif
        });
    </script>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkADnyDespyXXSSn282L2CbE57BaVbirg&callback="
            async
            defer></script>
    <script src="{{asset('assets/admin/gmap.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script type="text/javascript">
        var mapGeocoding = function () {

            var map = new GMaps({
                div: '#gmap_geocoding',
                lat: 0.00,
                lng: 0.00
            });

            var handleAction = function () {
                var text = $.trim($('#gmap_geocoding_address').val());
                GMaps.geocode({
                    address: text,
                    callback: function (results, status) {
                        if (status == 'OK') {
                            var latlng = results[0].geometry.location;
                            map.setCenter(latlng.lat(), latlng.lng());
                            map.addMarker({
                                lat: latlng.lat(),
                                lng: latlng.lng()
                            });
                        }
                    }
                });
            }

            handleAction();
        }
        $(window).bind('load', function () {
            setTimeout(mapGeocoding());
        });
    </script>
@endpush
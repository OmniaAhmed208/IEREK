@extends('layouts.master')
@section('content')
    <div class="container">
        <div  id="applying-area">
            <div class="framed-box">
                <div class="frame-title">Careers</div>
                <div class="framed-content applying-area">
                    <div class="container-fluid">
                        <?php echo $content->content; ?>

                        <div class="caldera-grid" id="caldera_form_1" data-cf-ver="1.4.1"
                             data-cf-form-id="CF54cf84bddccd1">
                            <div id="caldera_notices_1" data-spinner="/wp-admin/images/spinner.gif"></div>
                            <form data-instance="1" class="CF54cf84bddccd1 caldera_forms_form cfajax-trigger _tisBound"
                                  method="POST" enctype="multipart/form-data" role="form" id="CF54cf84bddccd1_1"
                                  data-target="#caldera_notices_1" data-template="#cfajax_CF54cf84bddccd1-tmpl"
                                  data-cfajax="CF54cf84bddccd1" data-load-element="_parent"
                                  data-load-class="cf_processing"
                                  data-post-disable="0" data-action="cf_process_ajax_submit"
                                  data-request="/cf-api/CF54cf84bddccd1">
                                <input type="hidden" id="_cf_verify" name="_cf_verify" value="a7f80e8aa1"><input
                                        type="hidden" name="_wp_http_referer" value="/careers/"><input type="hidden"
                                                                                                       name="_cf_frm_id"
                                                                                                       value="CF54cf84bddccd1">
                                <input type="hidden" name="_cf_frm_ct" value="1">
                                <input type="hidden" name="cfajax" value="CF54cf84bddccd1">
                                <input type="hidden" name="_cf_cr_pst" value="2696">
                                <!--<div class="row  first_row">-->
                                <!--    <div class="col-sm-12  single">-->
                                <!--        <div role="field" data-field-wrapper="fld_5106822" class="form-group">-->
                                <!--            <label id="fld_5106822Label" for="fld_5106822_1" class="control-label">Name-->
                                <!--                <span aria-hidden="true" role="presentation" class="field_required"-->
                                <!--                      style="color:#ff2222;">*</span></label>-->
                                <!--            <div class="">-->
                                <!--                <input type="text" data-field="fld_5106822" class="form-control"-->
                                <!--                       id="fld_5106822_1" name="fld_5106822" value=""-->
                                <!--                       required="required"-->
                                <!--                       aria-labelledby="fld_5106822Label">-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="row ">-->
                                <!--    <div class="col-sm-12  single">-->
                                <!--        <div role="field" data-field-wrapper="fld_6709562" class="form-group">-->
                                <!--            <label id="fld_6709562Label" for="fld_6709562_1" class="control-label">Email-->
                                <!--                <span aria-hidden="true" role="presentation" class="field_required"-->
                                <!--                      style="color:#ff2222;">*</span></label>-->
                                <!--            <div class="">-->
                                <!--                <input type="email" data-field="fld_6709562" class="form-control"-->
                                <!--                       id="fld_6709562_1" name="fld_6709562" value=""-->
                                <!--                       required="required"-->
                                <!--                       aria-labelledby="fld_6709562Label">-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="row ">-->
                                <!--    <div class="col-sm-12  single">-->
                                <!--        <div role="field" data-field-wrapper="fld_6579905" class="form-group">-->
                                <!--            <label id="fld_6579905Label" for="fld_6579905_1" class="control-label">Phone-->
                                <!--                <span aria-hidden="true" role="presentation" class="field_required"-->
                                <!--                      style="color:#ff2222;">*</span></label>-->
                                <!--            <div class="">-->
                                <!--                <input type="text" data-field="fld_6579905" class="form-control"-->
                                <!--                       id="fld_6579905_1" name="fld_6579905" value=""-->
                                <!--                       required="required"-->
                                <!--                       aria-labelledby="fld_6579905Label">-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="row ">-->
                                <!--    <div class="col-sm-12  single">-->
                                <!--        <div role="field" data-field-wrapper="fld_2267162" class="form-group">-->
                                <!--            <label id="fld_2267162Label" for="fld_2267162_1" class="control-label">Career-->
                                <!--                Title <span aria-hidden="true" role="presentation"-->
                                <!--                            class="field_required"-->
                                <!--                            style="color:#ff2222;">*</span></label>-->
                                <!--            <div class="">-->
                                <!--                <input type="text" data-field="fld_2267162" class="form-control"-->
                                <!--                       id="fld_2267162_1" name="fld_2267162" value=""-->
                                <!--                       required="required"-->
                                <!--                       aria-labelledby="fld_2267162Label">-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="row ">-->
                                <!--    <div class="col-sm-12  single">-->
                                <!--        <script>-->
                                <!--            jQuery(function ($) {-->
                                <!--                function init_recaptcha() {-->
                                <!--                    var captch = $('#capfld_7686139_1');-->
                                <!--                    captch.empty();-->
                                <!--                    grecaptcha.render(captch[0], {-->
                                <!--                        "sitekey": "6LdJXgETAAAAAOYFxXM2OEO-knpckdBSMzwTdpF4",-->
                                <!--                        "theme": "white"-->
                                <!--                    });-->
                                <!--                }-->

                                <!--                jQuery(document).on('click', '.reset_fld_7686139_1', function (e) {-->
                                <!--                    e.preventDefault();-->
                                <!--                    init_recaptcha();-->
                                <!--                });-->
                                <!--            });-->
                                <!--        </script>-->
                                <!--        <div role="field" data-field-wrapper="fld_7686139" class="form-group">-->
                                <!--            <label id="fld_7686139Label" for="fld_7686139_1" class="control-label">Recaptcha-->
                                <!--                <span aria-hidden="true" role="presentation" class="field_required"-->
                                <!--                      style="color:#ff2222;">*</span></label>-->
                                <!--            <div class="">-->
                                <!--                <input type="hidden" name="fld_7686139" value="fld_7686139_1"-->
                                <!--                       data-field="fld_7686139">-->
                                <!--                <div id="capfld_7686139_1" class="g-recaptcha" data-theme="white"-->
                                <!--                     data-sitekey="6LdJXgETAAAAAOYFxXM2OEO-knpckdBSMzwTdpF4"></div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="row ">-->
                                <!--    <div class="col-sm-12  single">-->
                                <!--        <div role="field" data-field-wrapper="fld_1176472" class="form-group">-->
                                <!--            <label id="fld_1176472Label" for="fld_1176472_1" class="control-label">Upload-->
                                <!--                your CV <span aria-hidden="true" role="presentation"-->
                                <!--                              class="field_required"-->
                                <!--                              style="color:#ff2222;">*</span></label>-->
                                <!--            <div class="file-prevent-overflow">-->
                                <!--                <div id="fld_1176472_1_file_list" class="cf-multi-uploader-list"></div>-->

                                <!--                <div class="new_input_field_container">-->

                                <!--                    <input data-controlid="trupl57f8fe977f78f" type="file" data-field="fld_1176472" name="fld_1176472" id="fld_1176472_1" class="inputfile inputfile-2" required="required" aria-labelledby="fld_1176472Label">-->
                                <!--                    <label for="fld_1176472_1">-->
                                <!--                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">-->
                                <!--                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>-->
                                <!--                        </svg>-->
                                <!--                        <span>Choose a file…</span>-->
                                <!--                    </label>-->
                                <!--                    <label id="cv_err" class="help-block redl"></label>-->
                                <!--                </div>-->


                                <!--                <input type="hidden" name="fld_1176472" value="trupl57f8fe977f78f">-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="row  last_row">-->
                                <!--    <div class="col-sm-12  single">-->
                                <!--        <script>-->
                                <!--            jQuery(function ($) {-->
                                <!--                $(document).on('click dblclick', '#fld_7019858_1', function (e) {-->
                                <!--                    $('#fld_7019858_1_btn').val(e.type).trigger('change');-->
                                <!--                });-->
                                <!--            });-->
                                <!--        </script>-->
                                <!--        <div role="field" data-field-wrapper="fld_7019858" class="form-group">-->
                                <!--            <div class="pull-right">-->
                                <!--                <input data-field="fld_7019858" class="btn btn-default centringClass main-submit-button" type="submit"-->
                                <!--                       name="fld_7019858_btn" value="Send" id="fld_7019858_1"-->
                                <!--                       aria-labelledby="fld_7019858Label">-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <input class="button_trigger_1" type="hidden" data-field="fld_7019858"-->
                                <!--               id="fld_7019858_1_btn" name="fld_7019858" value="">-->
                                <!--    </div>-->
                                <!--</div>-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
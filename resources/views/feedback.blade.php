@extends('layouts.master')
@section('content')
    <div id="content" class="container site-content container">
        <script type="text/javascript">var switchTo5x = true;</script>
        <script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript" src="https://ss.sharethis.com/loader.js"></script>
        <style>
            .sthoverbuttons-label {
                display: none;
            }
        </style>
        <img width="100%" src="/uploads/images/feedback.jpg" class="img-responsive" alt="Feedback"
             10683330_1472142813068612_1213931060_o"">
        <br>
        <div class="col-md-12 pl-0 pr-0">
            <div class="frame-title col-md-12 mr-top ">
               Feedback
            </div>
        </div>
        <div class="single-wrapper ">
            <div class="col-md-12 framed-content" id="applying-area">
                <div class="framed-box">
                    {{--<div class="frame-title">Feedback</div>--}}
                    <div class="framed-content applying-area">
                        <div class="container-fluid">
                            <?php echo $content->content; ?>

                            <div class="caldera-grid" id="caldera_form_1" data-cf-ver="1.4.1"
                                 data-cf-form-id="CF54391ee7dbcc1">
                                <div id="caldera_notices_1" data-spinner="/wp-admin/images/spinner.gif"></div>
                                <form data-instance="1"
                                      class="CF54391ee7dbcc1 caldera_forms_form cfajax-trigger _tisBound"
                                      method="POST" enctype="multipart/form-data" role="form" id="CF54391ee7dbcc1_1"
                                      data-target="#caldera_notices_1" data-template="#cfajax_CF54391ee7dbcc1-tmpl"
                                      data-cfajax="CF54391ee7dbcc1" data-load-element="_parent"
                                      data-load-class="cf_processing" data-post-disable="0"
                                      data-action="cf_process_ajax_submit" data-request="/cf-api/CF54391ee7dbcc1"
                                      data-hiderows="true">
                                    <input type="hidden" id="_cf_verify" name="_cf_verify" value="04ae093238"><input
                                            type="hidden" name="_wp_http_referer" value="/feed-back/"><input
                                            type="hidden"
                                            name="_cf_frm_id"
                                            value="CF54391ee7dbcc1">
                                    <input type="hidden" name="_cf_frm_ct" value="1">
                                    <input type="hidden" name="cfajax" value="CF54391ee7dbcc1">
                                    <input type="hidden" name="_cf_cr_pst" value="915">
                                    <div class="row  first_row">
                                        <div class="col-sm-12  single">
                                            <div role="field" data-field-wrapper="fld_9883345" class="form-group">
                                                <label id="fld_9883345Label" for="fld_9883345_1" class="control-label">Name
                                                    <span aria-hidden="true" role="presentation" class="field_required"
                                                          style="color:#ff2222;">*</span></label>
                                                <div class="">
                                                    <input type="text" data-field="fld_9883345" class="form-control"
                                                           id="fld_9883345_1" name="fld_9883345" value=""
                                                           required="required" aria-labelledby="fld_9883345Label">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-sm-12  single">
                                            <div role="field" data-field-wrapper="fld_6507094" class="form-group">
                                                <label id="fld_6507094Label" for="fld_6507094_1" class="control-label">Email
                                                    <span aria-hidden="true" role="presentation" class="field_required"
                                                          style="color:#ff2222;">*</span></label>
                                                <div class="">
                                                    <input type="email" data-field="fld_6507094" class="form-control"
                                                           id="fld_6507094_1" name="fld_6507094" value=""
                                                           required="required" aria-labelledby="fld_6507094Label">
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                jQuery(function ($) {
                                                    function fld_252238_1_stars() {
                                                        $('#fld_252238_1_stars').raty({
                                                            starOff: 'raty-star-off',
                                                            starOn: 'raty-star-on',
                                                            target: '#fld_252238_1',
                                                            spaceWidth: 3,
                                                            targetKeep: true, targetType: 'score',

                                                            hints: [1, 2, 3, 4, 5],
                                                            number: 5,
                                                            starType: 'f',
                                                            starColor: '#FFAA00',
                                                            numberMax: 100,
                                                            click: function (e) {
                                                                $('#fld_252238_1').trigger('change');
                                                            }
                                                        });
                                                    }

                                                    fld_252238_1_stars();
                                                    $(document).on('cf.add', fld_252238_1_stars);
                                                });
                                            </script>
                                            <div role="field" data-field-wrapper="fld_252238" class="form-group">
                                                <div class="">
                                                    <div style="position: relative;">
                                                        <div id="fld_252238_1_stars"
                                                             style="color:#AFAFAF;font-size:13px;"></div>
                                                        <input id="fld_252238_1" type="text" data-field="fld_252238"
                                                               name="fld_252238" value="" required="required"
                                                               style="position: absolute; width: 0px; height: 0px; padding: 0px; bottom: 0px; left: 12px; opacity: 0; z-index: -1000;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-sm-12  single">
                                            <div role="field" data-field-wrapper="fld_286910" class="form-group">
                                                <label id="fld_286910Label" for="fld_286910_1" class="control-label">Your
                                                    Feedback</label>
                                                <div class="">
                                                <textarea data-field="fld_286910" class="form-control" rows="4"
                                                          id="fld_286910_1" name="fld_286910"
                                                          aria-labelledby="fld_286910Label"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row  last_row">
                                        <div class="col-sm-12  single">
                                            <script>
                                                jQuery(function ($) {
                                                    $(document).on('click dblclick', '#fld_5407447_1', function (e) {
                                                        $('#fld_5407447_1_btn').val(e.type).trigger('change');
                                                    });
                                                });
                                            </script>
                                            <div role="field" data-field-wrapper="fld_5407447" class="form-group">
                                                <div class="pull-right">
                                                    <input data-field="fld_5407447" class="btn btn-default centringClass main-submit-button"
                                                           type="submit"
                                                           name="fld_5407447_btn" value="Send" id="fld_5407447_1"
                                                           aria-labelledby="fld_5407447Label">
                                                </div>
                                            </div>
                                            <input class="button_trigger_1" type="hidden" data-field="fld_5407447"
                                                   id="fld_5407447_1_btn" name="fld_5407447" value="">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">stLight.options({
                publisher: "5bcb41c7-05b0-4c64-9307-404e57c3cfb9",
                doNotHash: false,
                doNotCopy: false,
                hashAddressBar: false
            });</script>
        <script>
            var options = {
                "publisher": "5bcb41c7-05b0-4c64-9307-404e57c3cfb9",
                "position": "left",
                "ad": {"visible": false, "openDelay": 5, "closeDelay": 0},
                "chicklets": {"items": ["facebook", "twitter", "linkedin", "googleplus", "pinterest", ""]}
            };
            var st_hover_widget = new sharethis.widgets.hoverbuttons(options);
        </script>
    </div>
@endsection
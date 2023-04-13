@extends('layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container">
        <div class="row">
            <div class="steps col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <figure class="cover-img">
                            @if(file_exists('storage/uploads/conferences/'.$event->event_id.'/cover_img.jpg'))<img
                                    src="/storage/uploads/conferences/{{ $event->event_id }}/cover_img.jpg"
                                    class="img-responsive"
                                    alt=""/>@endif
                        </figure>
                    </div>
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-md-4 step actv orderS" onclick="toOrder()">
                                    <center><span><i class="glyphicon glyphicon-edit xlarge"></i></span>
                                        <span class="step_text">Order</span></center>
                                    <br>
                                    <center>
                                        <small>Choose your fees and additional services</small>
                                    </center>
                                </div>
                                <div class="col-md-4 step reviewS" onclick="toReview()">
                                    <center><span><i class="glyphicon glyphicon-ok xlarge"></i></span>
                                        <span class="step_text">Review</span></center>
                                    <br>
                                    <center>
                                        <small>Review your order</small>
                                    </center>
                                </div>
                                <div class="col-md-4 step checkoutS" onclick="toCheckout()">
                                    <center><span><i class="glyphicon glyphicon-ok xlarge"></i></span>
                                        <span class="step_text">Checkout</span></center>
                                    <br>
                                    <center>
                                        <small>Confirm your payment and checkout</small>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row payment-content">
                    <div class="col-md-8 order">
                        <form method="post" id="payments" name="payments" action="/test">
                            <input type="hidden" name="event_id" value="{{ $event->event_id }}" id="event_id">
                            <input type="hidden" name="token" value="" id="c_Token">
                            <input type="hidden" name="name" value="" id="c_ccName">
                            <input type="hidden" name="email" value="" id="c_ccEmail">
                            <input type="hidden" name="phone" value="" id="c_ccPhone">
                            <input type="hidden" name="caddress" value="" id="c_ccAddress">
                            <input type="hidden" name="city" value="" id="c_ccCity">
                            <input type="hidden" name="state" value="" id="c_ccState">
                            <input type="hidden" name="zip" value="" id="c_ccZip">
                            <input type="hidden" name="country" value="" id="c_ccCountry">
                            <input type="hidden" name="currency" value="{{$event->currency}}">
                            <!-- type of payment -->
                            <input type="hidden" name="paymentType" id="paymentType" value="hello">
                            <!-- -->
                            <input type="hidden" name="amount" id="amount_online" value="">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">
                            <div class="process">
                                <div class="">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4>PAYMENT&ensp;&ensp;<small
                                                        style="color:#fff">{{ $event->title_en }}</small>
                                            </h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="accordion">
                                                <h3>Pay For This Account</h3>
                                                <div class="group">
                                                    <div class="head account-block-container">
                                                        <div>
                                                            <input type="hidden"
                                                                   name="unique_id[{{$user->user_id}}]"
                                                                   value="{{$user->user_id}}">
                                                        </div>

                                                        <div class="">
                                                            Your attendance name:
                                                            <input type="text" name="names[{{$user->user_id}}]"
                                                                   class="custome-control data-input-field"
                                                                   value="@if($user->first_name != $user->email) {{ $user->first_name.' '.$user->last_name }} @endif"
                                                                   placeholder="Attendance Name">
                                                        </div>
                                                        <div class="">
                                                            Your email:
                                                            <input type="text" name="emails[{{$user->user_id}}]"
                                                                   class="custome-control data-input-field"
                                                                   value="{{ $user->email }}"
                                                                   readonly="readonly">
                                                        </div>
                                                    </div>
                                                    <div class="body active fees-required">
                                                        <p>Fees with (<i class="red"> * </i>) is required.</p>
                                                    @if(isset($attfees[0])) <!-- not author -->
                                                        <?php $count = 1; ?>
                                                        <h3 class="fees-title"><label for="audience">Attendance
                                                                Fees</label><i
                                                                    class="red"> *</i></h3>
                                                        <table class="table-fees">
                                                            <tbody>
                                                            @foreach($attfees as $attfee)
                                                                <tr>
                                                                    <td><input class="rfeeval attendance"
                                                                               data-feeval="{{ $attfee->amount }}"
                                                                               data-name="{{ $user->first_name.' '.$user->last_name }}"
                                                                               data-title="{{ $attfee->title_en }}"
                                                                               type="radio"
                                                                               @if($count == 1){{ 'checked="checked"' }}@endif name="attendance[{{$user->user_id}}]"
                                                                               id="attendance1{{ $count }}"
                                                                               value="{{ $attfee->event_fees_id }}">
                                                                        <label
                                                                                style="cursor:pointer"
                                                                                for="attendance1{{ $count }}">{{ $attfee->title_en }}</label>
                                                                    </td>
                                                                    <td style="min-width:120px"><label
                                                                                class="pull-right"
                                                                                dir="ltr">{{ number_format($attfee->amount) }}
                                                                            .00 <span class="pull-right"
                                                                            style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;</span></label>
                                                                    </td>
                                                                </tr>
                                                                <?php $count++ ?>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        @endif
                                                        @if(isset($accfees[0]))
                                                            <?php $count = 1; ?>
                                                            <h3 class="fees-title">
                                                                <input type="hidden"
                                                                       name="afees[{{$user->user_id}}]"
                                                                       id="afees{{$user->user_id}}" value="0">
                                                                <input type="checkbox" class="check-toggle"
                                                                       onclick="toggle_fee('afees{{$user->user_id}}')"
                                                                       data-children="feeval{{ $accfees[0]->event_fees_id }}"
                                                                       name="accommodation_fees[{{$user->user_id}}]"
                                                                       id="accommodation_fees"> <label
                                                                        for="accommodation_fees">Accommodation
                                                                    Fees</label></h3>
                                                            <table class="table-fees" style="display:none">
                                                                <tbody>
                                                                @foreach($accfees as $accfee)
                                                                    <tr>
                                                                        <td>
                                                                            <input class="feeval{{ $accfees[0]->event_fees_id }}"
                                                                                   data-feeval="{{ $accfee->amount }}"
                                                                                   data-name="{{ $user->first_name.' '.$user->last_name }}"
                                                                                   data-title="{{ $accfee->title_en }}"
                                                                                   data-feeid="{{ $accfee->event_fees_id }}"
                                                                                   type="radio"
                                                                                   @if($count == 1){{ 'checked="checked"' }}@endif value="{{ $accfee->event_fees_id }}"
                                                                                   name="accommodation[{{$user->user_id}}]"
                                                                                   id="accommodation1{{ $accfee->event_fees_id }}">
                                                                            <label style="cursor:pointer"
                                                                                   for="accommodation1{{ $accfee->event_fees_id }}">{{ $accfee->title_en }}</label>
                                                                        </td>
                                                                        <td style="min-width:120px"><label
                                                                                    class="pull-right"
                                                                                    dir="ltr"
                                                                                    data-feeval="{{ $accfee->amount }}">{{ number_format($accfee->amount) }}
                                                                                .00 <span class="pull-right"
                                                                                 style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;</span></label>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $count++ ?>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        @endif
                                                        @if(isset($vifees[0]))
                                                            <?php $count = 1 ?>
                                                            <h3 class="fees-title">
                                                                <input type="hidden"
                                                                       name="vfees[{{$user->user_id}}]"
                                                                       id="vfees{{$user->user_id}}" value="0">
                                                                <input type="checkbox" class="check-toggle"
                                                                       onclick="toggle_fee('vfees{{$user->user_id}}')"
                                                                       data-children="feeval{{ $vifees[0]->event_fees_id }}"
                                                                       name="visa_fees[{{$user->user_id}}]"
                                                                       id="visa_fees"> <label
                                                                        for="visa_fees">Visa Application</label>
                                                            </h3>
                                                            <table class="table-fees" style="display:none">
                                                                <tbody>
                                                                @foreach($vifees as $vifee)
                                                                    <tr>
                                                                        <td>
                                                                            <input class="feeval{{ $vifees[0]->event_fees_id }}"
                                                                                   data-feeval="{{ $vifee->amount }}"
                                                                                   data-name="{{ $user->first_name.' '.$user->last_name }}"
                                                                                   data-title="{{ $vifee->title_en }}"
                                                                                   data-feeid="{{ $vifee->event_fees_id }}"
                                                                                   type="radio"
                                                                                   @if($count == 1){{ 'checked="checked"' }}@endif name="visa[{{$user->user_id}}]"
                                                                                   value="{{ $vifee->event_fees_id }}"
                                                                                   id="visa1{{ $vifee->event_fees_id }}">
                                                                            <label
                                                                                    style="cursor:pointer"
                                                                                    for="visa1{{ $vifee->event_fees_id }}">{{ $vifee->title_en }}</label>
                                                                        </td>
                                                                        <td style="min-width:120px"><label
                                                                                    class="pull-right"
                                                                                    dir="ltr">{{ number_format($vifee->amount) }}
                                                                                .00 <span class="pull-right"
                                                                                 style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;</span></label>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $count++ ?>
                                                                @endforeach
                                                                <tr>
                                                                    <td>Please Fill In Visa Application Form
                                                                        Below
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <div class="col-md-4">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       name="fname[{{$user->user_id}}]"
                                                                                       placeholder="First Name">
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       name="mname[{{$user->user_id}}]"
                                                                                       placeholder="Middle Name">
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       name="lname[{{$user->user_id}}]"
                                                                                       placeholder="Last Name">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <div class="col-md-4">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       name="passport[{{$user->user_id}}]"
                                                                                       placeholder="Passport No.">
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       name="issued_at[{{$user->user_id}}]"
                                                                                       placeholder="Issued At">
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <input type="text"
                                                                                       class="form-control datepicker"
                                                                                       name="expires_on[{{$user->user_id}}]"
                                                                                       placeholder="Expires On">
                                                                            </div>
                                                                            <script>
                                                                                $(function () {
                                                                                    $(".datepicker").datepicker();
                                                                                });
                                                                            </script>
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <div class="col-md-12">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       name="address[{{$user->user_id}}]"
                                                                                       placeholder="Address">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <div class="col-md-12">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       name="empassy_address[{{$user->user_id}}]"
                                                                                       placeholder="Nearest Empassy Address">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <div class="col-md-12">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       name="additional_info[{{$user->user_id}}]"
                                                                                       placeholder="Additional Visa Information">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        @endif
                                                        @if(isset($papers[0]) AND isset($paperfees[0]))
                                                            <h3 class="fees-title"><label>Papers & Publishing
                                                                    Fees</label><i
                                                                        class="red"> *</i></h3>
                                                            <table class="table-fees">
                                                                <tbody>
                                                                <?php $count = 1 ?>
                                                                @foreach($papers as $paper)
                                                                    <tr style="font-weight:700;">
                                                                        <td>
                                                                            <label for="paper1{{ $count }}"
                                                                                   style="cursor:pointer">
                                                                                {{ $paper->title }}
                                                                            </label>
                                                                        </td>
                                                                        <td dir="ltr" style="min-width:110px;">
                                                                            <span style="font-weight: 300;color:green">{{ $event->currency }}</span>
                                                                            <span></span>
                                                                            {{number_format($tot = $paperfees[0]->amount)}}
                                                                            .00

                                                                        </td>
                                                                    </tr>
                                                                    <h4></h4>
                                                                    @if(isset($paperfees[0]))
                                                                        <tr>
                                                                            <td>
                                                                                <input class="rfeeval paperFees"
                                                                                       data-feeval="{{ $tot }}"
                                                                                       data-fees-discount="{{ ($count > 1) ? (($paperfees[0]->amount * 40) / 100) : 0 }}"
                                                                                       data-title="Paper ({{ substr($paper->title, 0, 16) }}...)"
                                                                                       data-name="{{ $user->first_name.' '.$user->last_name }}"
                                                                                       type="checkbox"
                                                                                       value="{{ $paper->paper_id }}_{{ $paperfees[0]->event_fees_id }}"
                                                                                       checked="checked"
                                                                                       name="paper[{{$paper->paper_id}}]"
                                                                                       id="paper1{{ $count }}">
                                                                                <label style="cursor:pointer"
                                                                                       for="paper1{{ $count }}">{{ $paperfees[0]->title_en }}</label>
                                                                            </td>
                                                                            <td style="min-width:120px"
                                                                                data-paper-fees-value="{{$paperfees[0]->amount}}"
                                                                                data-paper-fees-with-discount="{{ ($count > 1) ? $paperfees[0]->amount - ($paperfees[0]->amount* 40 /100) : $paperfees[0]->amount}}">
                                                                                <label class="pull-right"
                                                                                       dir="ltr">
                                                                                    {{ number_format($paperfees[0]->amount) }}
                                                                                    .00
                                                                                    <span class="pull-right"
                                                                                 style="font-size: 10px;font-weight: 700;color:green">
                                                                                                                                            {{$event->currency}}&ensp;
                                                                                                                                        </span>
                                                                                </label>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    <?php $count++ ?>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        @endif

                                                        @if(isset($papers[0]) AND isset($shortpaperfees[0]))
                                                            <h3 class="fees-title"><label> Short Papers </label><i
                                                                        class="red">
                                                                    *</i>
                                                            </h3>
                                                            <table class="table-fees">
                                                                <tbody>
                                                                <?php $count = 1 ?>
                                                                @foreach($papers as $paper)
                                                                    <tr style="font-weight:700;">
                                                                        <td>
                                                                            <label for="paper1{{ $count }}"
                                                                                   style="cursor:pointer">
                                                                                {{ $paper->title }}
                                                                            </label>
                                                                        </td>
                                                                        <td dir="ltr" style="min-width:110px;">
                                                                            <span style="font-weight: 300;color:green">{{ $event->currency }}</span>
                                                                            <span></span>
                                                                            {{number_format($tot = $shortpaperfees[0]->amount)}}
                                                                            .00

                                                                        </td>
                                                                    </tr>
                                                                    <h4></h4>
                                                                    @if(isset($shortpaperfees[0]))
                                                                        <tr>
                                                                            <td>
                                                                                <input class="rfeeval paperFees"
                                                                                       data-feeval="{{ $tot }}"
                                                                                       data-fees-discount="{{ ($count > 1) ? (($shortpaperfees[0]->amount * 40) / 100) : 0 }}"
                                                                                       data-title="Paper ({{ substr($paper->title, 0, 16) }}...)"
                                                                                       data-name="{{ $user->first_name.' '.$user->last_name }}"
                                                                                       type="checkbox"
                                                                                       value="{{ $paper->paper_id }}_{{ $shortpaperfees[0]->event_fees_id }}"
                                                                                       checked="checked"
                                                                                       name="paper[{{$paper->paper_id}}]"
                                                                                       id="paper1{{ $count }}">
                                                                                <label style="cursor:pointer"
                                                                                       for="paper1{{ $count }}">{{ $shortpaperfees[0]->title_en }}</label>
                                                                            </td>
                                                                            <td style="min-width:120px"
                                                                                data-paper-fees-value="{{$shortpaperfees[0]->amount}}"
                                                                                data-paper-fees-with-discount="{{ ($count > 1) ? $shortpaperfees[0]->amount - ($shortpaperfees[0]->amount* 40 /100) : $shortpaperfees[0]->amount}}">
                                                                                <label class="pull-right"
                                                                                       dir="ltr">
                                                                                    {{ number_format($shortpaperfees[0]->amount) }}
                                                                                    .00
                                                                                    <span class="pull-right"
                                                                                 style="font-size: 10px;font-weight: 700;color:green">
                                                                                                                                            {{$event->currency}}&ensp;
                                                                                                                                        </span>
                                                                                </label>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    <?php $count++ ?>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        @endif

                                                        @if(isset($cusfees[0]))
                                                            <h3 class="fees-title"><label>Additional
                                                                    Services</label>
                                                            </h3>
                                                            <table class="table-fees">
                                                                <tbody>
                                                                <?php $count = 1 ?>
                                                                @foreach($cusfees as $cusfee)
                                                                    <tr>
                                                                        <td><input class="rfeeval"
                                                                                   data-feeval="{{$cusfee->amount}}"
                                                                                   data-title="{{ $cusfee->title_en }}"
                                                                                   data-name="{{ $user->first_name.' '.$user->last_name }}"
                                                                                   type="checkbox"
                                                                                   value="{{$user->user_id}}_{{ $cusfee->event_fees_id }}"
                                                                                   name="cus[{{$count}}]"
                                                                                   id="cusfee1{{ $count }}">
                                                                            <label style="cursor:pointer"
                                                                                   for="cusfee1{{ $count }}">{{ $cusfee->title_en }}</label>
                                                                        </td>
                                                                        <td style="min-width:120px"><label
                                                                                    class="pull-right"
                                                                                    dir="ltr">{{ number_format($cusfee->amount) }}
                                                                                .00 <span class="pull-right"
                                                                                 style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;</span></label>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $count++ ?>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($promoCode)
                                            <div class="panel-body">
                                                <h3>Promo Code</h3>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control"
                                                           value="{{$promoCode['promo_code']}}"
                                                           placeholder="Add Promo code here!" name="promo_code">
                                                    <input type="hidden" id="promo_code_amount"
                                                           value="{{$promoCode['discount_amount']}}"
                                                           data-name="{{ $user->first_name.' '.$user->last_name }}"
                                                           name="promo_code_amount">
                                                </div>

                                            </div>
                                        @endif
                                        <div class="panel-body">
                                            <h3>Pay For Others</h3>
                                            <div class="accordion" id="fees-others">
                                            </div>
                                            <div class="accordion">
                                                <div class="group">
                                                    <div class="panel-body">
                                                        <form id="addpay" method="post"
                                                              action="conference/get/payment">
                                                            <input type="hidden" name="event_id"
                                                                   value="{{ $event->event_id }}">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                       placeholder="Name"
                                                                       name="add_name">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="email" class="form-control"
                                                                       placeholder="email"
                                                                       name="add_email">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select class="form-control" name="add_type">
                                                                    <option value="1">Audience</option>
                                                                    <option value="2">Co-Author</option>
                                                                    <option value="3">Author</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <a onclick="addpay()"
                                                                   class="btn btn-success btn-block"><i></i><i
                                                                            class="glyphicon glyphicon-plus"></i>&ensp;Add</a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8 review" style="display:none">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4>REVIEW PAYMENT&ensp;&ensp;<small style="color:#fff">{{ $event->title_en }}</small>
                                </h4>
                            </div>
                            <div class="panel-body">
                                <table class="table-sumx table table-hover table-stripped">
                                    <thead>
                                    <th>Order</th>
                                    <th>Attendance</th>
                                    <th class="value-mobile">Value</th>
                                    </thead>
                                    <tbody id="fees-sumx">

                                    </tbody>
                                    <tfoot>
                                    <tr style="font-weight:700;">
                                        <td>TOTAL</td>
                                        <td></td>
                                        <td dir="ltr" style="min-width:150px;">
                                            <span id="totalx">0</span>.00
                                            <span
                                                    style="font-weight: 700;color:green">{{$event->currency}}&ensp;</span>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 checkout" style="display:none">
                        <?php
                        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                        $uri_segments = explode('/', $uri_path);
                        $event_title = $uri_segments[2];
                        ?>
                        {{--<a href="mailto:info@ierek-scholar.org?subject=Payment%20problem">Send mail</a>--}}
                        <input type="hidden" id="custom_money">
                        {{--pay from this link <a href="#" onclick="CustomLink('/custom/payment/{{$event_title}}')">pay custom</a>--}}
                        <div class="panel">
                            <div class="panel-heading">
                                <h4>CHECKOUT PAYMENT&ensp;&ensp;<small style="color:#fff">{{ $event->title_en }}</small>
                                </h4>
                            </div>
                            <div class="panel-body">
                                <h3>Choose Your Payment Method</h3>
                                <div class="paymethod creditcard" data-method="cc"><i
                                            class="glyphicon glyphicon-credit-card"></i>
                                    Pay
                                    with Credit Card
                                </div>
                                <div class="creditcardform" style="display:none;">
                                    <form id="payForm" name="payForm" method="post" action="/pay">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input name="token" type="hidden" value="">
                                        <h4>To pay using Paypal,  <a href="mailto:financialservices@ierek.com">Contact Us</a> <a href="mailto:financialservices@ierek.com"> <img width="100px" class="pull-right" src="/uploads/payment/paypal.png"></a></h4>
                                        <br>
                                        <h4>Billing Information <img width="100px" class="pull-right"
                                                                     src="/uploads/payment/cards_no_master.png"></h4>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-md-3">Card Holder</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control copier" data-copy="c_ccName"
                                                       id="ccName"
                                                       name="ccName" value="" required>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">Email</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control copier" data-copy="c_ccEmail"
                                                       id="ccEmail"
                                                       name="email" value="" required>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">Phone</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control copier" data-copy="c_ccPhone"
                                                       id="ccPhone"
                                                       name="phone" value="" required>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">Billing Address</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control copier" data-copy="c_ccAddress"
                                                       id="ccAddress"
                                                       name="address" value="" required>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-2" style="padding-right:0px;">
                                                <input type="text" class="form-control copier" data-copy="c_ccCity"
                                                       id="ccCity"
                                                       name="city" value="" placeholder="CITY" required>
                                            </div>
                                            <div class="col-md-2" style="padding-right:0px;">
                                                <input type="text" class="form-control copier" data-copy="c_ccState"
                                                       id="ccState"
                                                       name="state" value="" placeholder="STATE" required>
                                            </div>
                                            <div class="col-md-2" style="padding-right:0px;">
                                                <input type="text" class="form-control copier" data-copy="c_ccZip"
                                                       id="ccZip"
                                                       name="zip"
                                                       value="" placeholder="ZIP" required>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control copier" data-copy="c_ccCountry"
                                                       id="ccCountry"
                                                       name="country" value="" placeholder="COUNTRY" required>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">Card Number</label>
                                            <div class="col-md-6" style="padding-right:0px;">
                                                <input type="text" class="form-control secure" name="ccNo" id="ccNo"
                                                       value=""
                                                       placeholder="CARD NUMBER" required>
                                                <small id="invCc" style="color:red; font-size:9px"></small>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control secure" name="cvv" id="cvv"
                                                       size="3"
                                                       value=""
                                                       placeholder="CVV" required>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">Expiration Date</label>
                                            <div class="col-md-3" style="padding-right:0px;">
                                                <input type="text" class="form-control secure" name="expMonth"
                                                       id="expMonth"
                                                       size="2"
                                                       value="" placeholder="MM" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control secure" name="expYear"
                                                       id="expYear"
                                                       size="4"
                                                       value="" placeholder="YYYY" required>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <p style="color:green;"><i class="fa fa-lock" style="font-size:18px;"></i>&ensp;Your
                                            billing
                                            information is highly secured and will be used only at this page. (<a
                                                    href="/terms-conditions/#fees" target="_blank">Read our policy</a>)
                                        </p>
                                    </form>
                                </div>
                                <div class="processing message message-success" style="display:none">
                                    <center><img src="/loading.gif">&ensp;Processing your payment...</center>
                                </div>
                                <div class="paymethod bank" data-method="bank"><i class="glyphicon glyphicon-send"></i>
                                    Pay with
                                    Bank
                                    Transfer
                                </div>
                                <div class="bankform" style="display:none;">
                                    <form name="payBank" method="post" action="payBank" id="payBank">
                                    <!--									<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
                                    <!--							<input type="hidden" name="currency" value="{{$event->currency}}">-->

                                        <div class="box-content">
                                            <p class="bg-warning message">
                                                If you select wire transfer, kindly use the following details:<br>
                                                <br>
                                                Bank: CIB Alexandria Sanstefano Egypt.<br>
                                                Bank account name: IEREK – International Experts for Research Enrichment and Knowledge Exchange<br>
                                               Bank account number: 100023143822 (Euro account)<br>
                                               Bank account number: 100023143814 (USD account)<br>
                                               Bank account number: 100027093878 (GBP account)<br>
                                               Bank account number: 100019650628 (EGP account)<br>
                                                Swift code: CIBEEGCXXXX<br>
                                                
                </p><h4 style="color:red;">**NOTE*: The transaction fee is solely the
                                                participants'
                                                responsibility.</h4><br>
                                            After you have completed the payment, kindly do the following;<br>
                                            <br>
                                            - Inform us with all the transaction details.<br>
                                            - The registration marked as pending until we confirm the transaction.
                                            <em>Note: You have to select fees first to show our relative bank account to
                                                the
                                                selected
                                                currency!</em>
                                            <div class="bank-payment-area" style="display: none;">
                                                <p>You can easily pay through our partner:</p>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Bank Name</th>
                                                        <th>Account Name</th>
                                                        <th>Account Number</th>
                                                        <th>Swift code</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="currency-EGP currency-row" style="display: none;">
                                                        <td>Commercial International Bank (CIB)</td>
                                                        <td>IEREK</td>
                                                        <td>2543420026</td>
                                                        <td>CIBEEGCX056</td>
                                                    </tr>
                                                    <tr class="currency-USD currency-row" style="display: none;">
                                                        <td>Commercial International Bank (CIB)</td>
                                                        <td>IEREK</td>
                                                        <td>100023143814</td>
                                                        <td>CIBEEGCX056</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br>
                                            <b>After you make your transfer, Kindly send us a scanned copy of the
                                                receipt to</b>
                                            <a
                                                    href="mailto:info@ierek.com">info@ierek-scholar.org</a>
                                            <p class="bg-info message">
                                                A confirmation message will be sent to you after we receive the
                                                receipt</p>
                                            <input type="hidden" name="event_id" value="{{ $event->event_id }}">
                                            <input type="hidden" name="fees[]" id="fees_id">
                                            <input type="hidden" id="amountBank" name="amountBank">
                                            <input type="hidden" id="order_type" name="order_type" value="1">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="currency" value="{{$event->currency}}">
                                            <h4>Contact Information</h4>
                                            <hr>
                                            <div class="form-group">
                                                <label class="col-md-3">Name</label>
                                                <div class="col-md-9">
                                                    <input id="userBankName" type="text" class="form-control"
                                                           name="name"
                                                           required>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3">Email</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="userBankEmail" class="form-control"
                                                           name="email"
                                                           required>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3">Phone</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="userBankPhone" class="form-control"
                                                           name="phone"
                                                           required>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </form>
                                    <p style="color:green;"><i class="fa fa-phone" style="font-size:18px;"></i>&ensp;You
                                        will be
                                        contacted by our representative regulary within 24 hours. (<strong>Need help? <a
                                                    href="/contact-us">Contact Us</a></strong>)</p>
                                </div>
                                <div class="paymethod cash" data-method="cash"><i class="glyphicon glyphicon-usd"></i>
                                    Pay with
                                    Cash
                                </div>
                                <div class="cashform" style="display:none;">
                                    <div class="box-content">
                                        <p>
                                            You can pay in cash at our office: 11 El Behera St. Ganaklis – Alexandria,
                                            Egypt OR
                                            39
                                            Lebanon
                                            St. El Mohandseen - Cairo, Egypt.</p>
                                        <form id="payOffice" name="payOffice" method="post" action="/pay">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <h4>Contact Information</h4>
                                            <hr>
                                            <div class="form-group">
                                                <label class="col-md-3">Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="userCashName" class="form-control"
                                                           name="name"
                                                           value=""
                                                           required>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3">Email</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="userCashEmail" class="form-control"
                                                           name="email"
                                                           value=""
                                                           required>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3">Phone</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="userCashPhone" class="form-control"
                                                           name="phone"
                                                           value=""
                                                           required>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </form>
                                        <p style="color:green;"><i class="fa fa-phone" style="font-size:18px;"></i>&ensp;You
                                            will be
                                            contacted by our representative regulary within 24 hours. (<strong>Need
                                                help? <a
                                                        href="/contact-us">Contact Us</a></strong>)</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="checkbox" name="terms" value="1" id="terms">
                                    <label for="terms">Please Read and Agree to our <a href="/terms-conditions/"
                                                                                       target="_blank">Terms
                                            &amp; Conditions</a></label>
                                </div>
                                {{--<div class="col-md-4 checkbtn">--}}
                                    {{--<a class="btn btn-success btn-block checkout" onclick="checkout()"--}}
                                       {{--style="font-size:18px;display:none">Checkout&ensp;<i--}}
                                                {{--class="glyphicon glyphicon-ok"></i></a>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 payment-sidebar">
                        <div class="panel">
                            <div class="panel-body">
                                <div>
                                    <div class="group">
                                        <h3>Order Summary</h3>
                                        <div>
                                            <table class="table-sum">
                                                <tbody id="fees-sum">

                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td>
                                                        <hr>
                                                    </td>
                                                    <td>
                                                        <hr>
                                                    </td>
                                                </tr>
                                                <tr style="font-weight:700;">
                                                    <td>TOTAL</td>
                                                    <td dir="ltr" style="min-width:110px;">
                                                        <span id="total"></span>.00
                                                        <span
                                                                style="font-weight: 700;color:green">{{$event->currency}}&ensp;</span>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel checkbtn">
                            <div class="panel-body">
                                <div>
                        
                                   <div class="group for_all_close" style="position: relative;">
                                        <div class="for_close" id="flower_gulp">
                                            <a class="btn btn-success btn-block checkout btn-full-width-mob disableOnPayment" onclick="checkout()"
                                           style="font-size:18px;display:none">Checkout&ensp;<i
                                                    class="glyphicon glyphicon-ok"></i></a>     
                                        </div>

                                        <a class="btn btn-success btn-block order" onclick="toReview()"
                                           style="font-size:18px;">Proceed
                                            to Checkout&ensp;<i class="glyphicon glyphicon-chevron-right"></i></a>
                                        <a class="btn btn-success btn-block review" onclick="toCheckout()"
                                           style="font-size:18px;display:none">Finish and Checkout&ensp;<i
                                                    class="glyphicon glyphicon-chevron-right"></i></a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="panel pay-custome" style="display:none;">
                            <div class="panel-body">
                                <div>
                                    <div class="group">
                                        <h3>Pay with alternative method</h3>
                                        <div>
                                        <?php
                                        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                        $uri_segments = explode('/', $uri_path);
                                        $event_title = $uri_segments[2];
                                        ?>
                                        <!--                            <a href="mailto:info@ierek-scholar.org?subject=Payment%20proplem">Send mail</a>-->
                                            <input type="hidden" id="custom_money">
                                            <h6>if you have any problem, You can use This link </h6>

                                        </div>

                                    </div>
                                    <div class="group">
                                        <a class="btn btn-success btn-block alt-link btn-full-width-mob"
                                           onclick="CustomLink('/custom/payment/{{$event_title}}')"
                                           style="font-size:18px;">Alternative link&ensp;<i
                                                    class="glyphicon glyphicon-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel send-email" style="display:none;">
                            <div class="panel-body">
                                <div>
                                    <div class="group">
                                        <h3>Send Email</h3>
                                        <div>
                                            <!--                            <a href="mailto:info@ierek-scholar.org?subject=Payment%20proplem">Send mail</a>-->
                                            <input type="hidden" id="custom_money">
                                            <h6>if you have any problem, with payment You can send mail </h6>

                                        </div>

                                    </div>
                                    <div class="group">
                                        <a href="mailto:info@ierek-scholar.org?subject=Payment%20proplem"
                                           class="btn btn-success btn-block alt-link btn-full-width-mob"
                                           style="font-size:18px; ">Send Email&ensp;<i
                                                    class="glyphicon glyphicon-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="successForm" style="display:none;">
                        <div class="col-md-12 row">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <p class="successMessage"></p>
                                </div>
                            </div>
                            <div class="col-md-3">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('styles')
    <style rel="stylesheet" type="text/css">
        .step {
            cursor: pointer;
            padding: 1em 0em;
            transition: 0.2s;
            border: 1px solid #f1f1f1;
        }

        .step:hover {
            background: #f1f1f1;
        }

        .step.actv {
            background: #aa822c;
            color: #fff;
        }

        .xlarge {
            font-size: 26px;
            padding: 0.25em;
            border: 1px solid #777;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 50%;
        }

        .step.actv .xlarge {
            border: 2px solid #fff;
            background: rgba(0, 0, 0, 0.3);
        }

        .step_text {
            font-size: 26px;
            padding: 0.125em;
        }

        .table-fees {
            width: 100%;
            border: 0px #f1f1f1 solid;
        }

        .table-fees tr {
            cursor: pointer;
            padding: 0.125em;
            border-bottom: 1px solid #f1f1f1;
        }

        .table-fees tr:hover {
            background: #f9f9f9;
        }

        .table-fees input {
            margin: 0.5em;
        }

        .table-fees td:nth-child(2), .table-sum td:nth-child(2), .table-sumx td:nth-child(3) {
            width: 10%;
        }

        .table-fees label {
            /*width: 90%;*/
            padding: 0.25em;
            font-size: 15px;
            font-weight: 500 !important;
        }

        .red {
            color: red;
            font-style: normal;
            font-size: 14px;
            font-weight: 700;
            font-family: tahoma;
        }

        .table-sum {
            width: 100%;
        }

        .table-sum tr {
            padding: 0.125em !important;
            background: #f1f1f1;
            transition: 0.3s;
        }

        .table-sum tr:nth-child(odd) {
            background: #fff;
        }

        .sumitem {
            transition: 0.3s;
        }

        .table-sumx {
            width: 100%;
        }

        .table-sumx tr:nth-child(odd) {
            background: #f9f9f9;
        }

        .table-sumx thead tr {
            background-color: #fff !important;
        }

        .table-sumx tfoot tr {
            background-color: #f1f1f1 !important;
        }

        .custome-control {
            width: 100%;
            font-size: 13px !important;
            font-weight: 300 !important;
            border: 0px;
            background: transparent;
            text-indent: 5px;
            border-radius: 3px;
            height: 2em !important;
            transition: 0.2s;
        }

        .custome-control:focus {
            background: #fff;
            color: #666;
        }

        .head {
            border-radius: 0% !important;
            border: 1px solid #f1f1f1 !important;
            border: 0px;
        }

        .body {
            display: none;
            border: 1px solid #f1f1f1 !important;
            padding: 1em;
        }

        .body.active {
            display: block;
        }

        .fees-title {
            border-bottom: 1px #f1f1f1 solid;
        }

        .btn-defaultx {
            background: #0c3852 !important;
            color: #fff !important;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-defaultx:hover {
            background: #a97f18 !important;
            color: #000;
        }

        .paymethod {
            padding: 1em;
            margin: 0.25em 0;
            cursor: pointer;
            font-size: 20px;
            transition: 0.3s;
            background-color: #f1f1f1;
        }

        .secure {
            background-color: rgb(245, 255, 245);
        }

        .valid {
            /*background: url('/uploads/check.png') no-repeat 98% center;*/
            background-size: 20px 20px;
            background-color: rgb(245, 255, 245);
        }

        .invalid {
            /*background: url('/uploads/cross.png') no-repeat 98% center;*/
            background-size: 20px 20px;
            background-color: rgb(255, 245, 245);
        }

        .creditcardform, .bankform, .cashform {
            padding: 1em;
            margin: 0.25em 1em;
        }

        .paymethod i {
            padding: 0.125em;
            padding-right: 1em;
            font-size: 26px;
        }

        .paymethod:hover {
            background: #e1e1e1;
            color: #666;
        }

        .paymethod.actv {
            background: #aa822c;
            color: #fff;
        }
    </style>
    <style type="text/css" media="screen and (max-width:500px)">
        .form-group div {
            padding: 0px !important;
        }

        input {
            border-radius: 0px !important;
        }
    </style>
@endpush
@push('scripts')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="/js/creditcard.js" type="text/javascript"></script>
    <script>
        function CustomLink(customLink) {
            var payCustom = $('#custom_money').val();
            window.location.replace(customLink + '/' + payCustom);

        }
    </script>
    <script>
        var isTotal = 0;
        var currency = '{{$event->currency}}';

        function amount(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }

        $("input[name=promo_code]").on("keyup", function () {
            if ($(this).val() != "") {
                $.ajax({
                    type: 'GET',
                    url: '{{ url("payment/check-promo") }}/' + $(this).val() + "/{{$event->event_id}}",
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        //loading ajax animation
                    },
                    success: function (response) {
                        if (response.success) {
                            $("#promo_code_amount").val(response.promocode.discount_amount);
                        } else if (!response.success) {
                            $("#promo_code_amount").val(null);
                        }
                        SumTotal();
                    },
                    error: function (response) {

                    }
                });
            } else {
                $("#promo_code_amount").val(null);
                SumTotal();
            }

        });
        var inOtherPay = [];
        var ix = {{ $user->user_id }} +1;

        function addpay() {
            var formData = $('#addpay').serialize();
            var addname = $('input[name=add_name]').val();
            var addemail = $('input[name=add_email]').val();
            if (addname == '' || addemail == '') {
                informX('<strong style="color:red;border-bottom:2px #f1f1f1 solid">Error</strong><br>Please enter attendant Name and Email');
            } else if (inOtherPay.indexOf(addemail) > -1) {
                informX('<strong style="color:red;border-bottom:2px #f1f1f1 solid">Error</strong><br>This Email is already in your Orders List');
            } else {
                $.ajax({
                    type: 'POST',
                    url: '{{ url("/conference/get/payment") }}',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        //loading ajax animation
                    },
                    success: function (response) {
                        //
                        var attfees = response.attfees;
                        var accfees = response.accfees;
                        var vifees = response.vifees;
                        var pubfees = response.pubfees;
                        var paperfees = response.paperfees;
                        var papers = response.papers;
                        var cusfees = response.cusfees;
                        var user = response.user;

                        var attfeesHtml = '';
                        var accfeesHtml = '';
                        var vifeesHtml = '';
                        var paperHtml = '';
                        var cusHtml = '';
                        for (i = 0; i < attfees.length; i++) {
                            var checked = '';
                            if (attfees[i].event_fees_id == attfees[0].event_fees_id) {
                                checked = 'checked';
                            }
                            var attItem = '<tr>' +
                                '<td><input class="rfeeval" data-feeval="' + attfees[i].amount + '" value="' + attfees[i].event_fees_id + '" data-name="' + addname + '" data-title="' + attfees[i].title_en + '" ' + checked + ' type="radio" name="attendance[' + ix + ']" id="attendance1' + i + ix + '"> <label style="cursor:pointer"  for="attendance1' + i + ix + '">' + attfees[i].title_en + '</label></td>' +
                                '<td style="min-width:120px"><label class="pull-right" dir="ltr">' + attfees[i].amount + '.00 <span class="" style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;</span></label></td>' +
                                '</tr>';
                            attfeesHtml = attfeesHtml + attItem;
                        }
                        for (i = 0; i < accfees.length; i++) {
                            var checked = '';
                            if (accfees[i].event_fees_id == accfees[0].event_fees_id) {
                                checked = 'checked';

                            }
                            var accItem = '<tr>' +
                                '<td><input class="feeval' + ix + '" ' + checked + ' data-feeval="' + accfees[i].amount + '" value="' + accfees[i].event_fees_id + '" data-name="' + addname + '" data-title="' + accfees[i].title_en + '" data-feeid="' + accfees[i].event_fees_id + '" type="radio" name="accommodation[' + ix + ']" id="accommodation1' + ix + accfees[i].event_fees_id + '"> <label style="cursor:pointer" for="accommodation1' + ix + accfees[i].event_fees_id + '">' + accfees[i].title_en + '</label></td>' +
                                '<td style="min-width:120px"><label  class="pull-right" dir="ltr" data-feeval="' + accfees[i].amount + '">' + accfees[i].amount + '.00 <span class="" style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;</span></label></td>' +
                                '</tr>';
                            accfeesHtml = accfeesHtml + accItem;
                        }
                        for (i = 0; i < vifees.length; i++) {
                            var checked = '';
                            if (vifees[i].event_fees_id == vifees[0].event_fees_id) {
                                checked = 'checked';
                            }
                            var viItem = '<tr>' +
                                '<td><input class="vfeeval' + ix + '" ' + checked + ' data-feeval="' + vifees[i].amount + '"  value="' + vifees[i].event_fees_id + '" data-name="' + addname + '" data-title="' + vifees[i].title_en + '" data-feeid="' + vifees[i].event_fees_id + '" type="radio" name="visa[' + ix + ']" id="visa1' + ix + vifees[i].event_fees_id + '"> <label style="cursor:pointer" for="visa1' + ix + vifees[i].event_fees_id + '">' + vifees[i].title_en + '</label></td>' +
                                '<td style="min-width:120px"><label  class="pull-right" dir="ltr" data-feeval="' + vifees[i].amount + '">' + vifees[i].amount + '.00 <span class="" style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;</span></label></td>' +
                                '</tr>';
                            vifeesHtml = vifeesHtml + viItem;
                        }


                        if (pubfees[0] == undefined) {
                            paperHtml = '';
                        } else if (paperfees[0] == undefined) {
                            paperHtml = '';
                        } else {
                            for (i = 0; i < papers.length; i++) {
                                var checked = 'checked';
                                var paperItem = '<tr>' +
                                    '<tr style="font-weight:700;">' +
                                    '<td><label for="paperfees1' + 0 + ix + '"  style="cursor:pointer">' + papers[i].title + '</label></td>' +
                                    '<td dir="ltr" style="min-width:110px;"><span style="font-weight: 300;color:green">{{$event->currency}}&ensp;</span> <span></span>' + (paperfees[0].amount + pubfees[0].amount) + '.00</td>' +
                                    '</tr>' +

                                    '<tr>' +
                                    '<td><input class="rfeeval" data-feeval="' + (paperfees[0].amount + pubfees[0].amount) + '"  value="' + papers[i].paper_id + '_' + paperfees[0].event_fees_id + '" data-name="' + addname + '" data-title="Paper (' + papers[i].title.substring(0, 16) + '...)" ' + checked + ' type="checkbox" name="paper[' + papers[i].paper_id + ']" id="paperfees1' + 0 + ix + '"> <label style="cursor:pointer"  for="paperfees1' + 0 + ix + '">' + paperfees[0].title_en + '</label></td>' +
                                    '<td style="min-width:120px"><label class="pull-right" dir="ltr">' + paperfees[0].amount + '.00 <span class="p style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;</span></label></td>' +
                                    '</tr>' +

                                    '<tr>' +
                                    '<td><input class="rfeeval" data-feeval="' + pubfees[0].amount + '"  value="' + papers[i].paper_id + '_' + pubfees[0].event_fees_id + '" data-name="' + addname + '" data-title="' + pubfees[0].title_en + '" ' + checked + ' type="hidden" name="publish[' + papers[i].paper_id + ']" id="publish1' + 0 + ix + '"> <label style="cursor:pointer;padding-left:2.45em;color: #888"  for="paperfees1' + 0 + ix + '">' + pubfees[0].title_en + '</label></td>' +
                                    '<td style="min-width:120px"><label class="pull-right" dir="ltr">' + pubfees[0].amount + '.00 <span class="p style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;</span></label></td>' +
                                    '</tr>' +

                                    '<tr>' +
                                    '<td>&ensp;</td><td>&ensp;</td>' +
                                    '</tr>' +
                                    '</tr>';
                                paperHtml = paperHtml + paperItem;
                            }
                        }

                        for (i = 0; i < cusfees.length; i++) {
                            var cusItem = '<tr>' +
                                '<td><input class="rfeeval" data-feeval="' + cusfees[i].amount + '"  value="' + ix + '_' + cusfees[i].event_fees_id + '" data-name="' + addname + '" data-title="' + cusfees[i].title_en + '" data-feeid="' + cusfees[i].event_fees_id + '" type="checkbox" name="cus[' + ix + ']" id="cus1' + ix + cusfees[i].event_fees_id + '"> <label style="cursor:pointer" for="cus1' + ix + cusfees[i].event_fees_id + '">' + cusfees[i].title_en + '</label></td>' +
                                '<td style="min-width:120px"><label  class="pull-right" dir="ltr" data-feeval="' + cusfees[i].amount + '">' + cusfees[i].amount + '.00 <span class="" style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;</span></label></td>' +
                                '</tr>';
                            cusHtml = cusHtml + cusItem;
                        }

                        if (attfees[0] == undefined) {
                            var isHidden = 'hidden';
                            var hiddenx = '';
                        } else {
                            var isHidden = '';
                            var hiddenx = 'hidden';
                        }

                        if (accfees[0] == undefined) {
                            var accHidden = 'hidden';
                        } else {
                            var accHidden = '';
                        }

                        if (vifees[0] == undefined) {
                            var viHidden = 'hidden';
                        } else {
                            var viHidden = '';
                        }

                        if (cusfees[0] == undefined) {
                            var cusHidden = 'hidden';
                        } else {
                            var cusHidden = '';
                        }

                        var addNewPay = '<div class="group" id="addpay' + ix + '" style="display: none" data-email="' + addemail + '">' +
                            '<div class="col-md-12 head btn btn-success btn-block">' +
                            '<input type="hidden" name="unique_id[' + ix + ']" value="' + ix + '" >' +
                            '<div class="col-md-5">' +
                            '<input type="text" name="names[' + ix + ']" class="custome-control" value="' + user.first_name + '"  placeholder="Attendance Name">' +
                            '</div>' +
                            '<div class="col-md-7">' +
                            '<input type="text" name="emails[' + ix + ']" class="custome-control" value="' + user.email + '" readonly="readonly">' +
                            '</div>' +
                            '</div>' +
                            '<div class="body active">' +
                            '<p>Fees with (<i class="red"> * </i>) is required.</p>' +
                            '<h3 class="fees-title ' + isHidden + '"><label for="audience">Attendance Fees</label><i class="red"> *</i></h3>' +
                            '<table class="table-fees">' +
                            '<tbody>' + attfeesHtml + '</tbody>' +
                            '</table>' +
                            '<h3  class="fees-title ' + accHidden + '"><input type="hidden" name="afees[' + ix + ']" id="afees' + ix + '" value="0"><input type="checkbox" class="check-toggle" data-children="feeval' + ix + '" name="accommodation_fees[' + ix + ']" id="accommodation_fees' + ix + '"> <label for="accommodation_fees' + ix + '" data-toggle="afees' + ix + '">Accommodation Fees</label></h3>' +
                            '<table class="table-fees" style="display:none">' +
                            '<tbody>' + accfeesHtml + '</tbody>' +
                            '</table>' +
                            '<h3 class="fees-title ' + viHidden + '"><input type="hidden" name="vfees[' + ix + ']" id="vfees' + ix + '" value="0"><input type="checkbox" class="check-toggle" data-children="vfeeval' + ix + '" name="visa[' + ix + ']" id="visa_fees' + ix + '"> <label for="visa_fees' + ix + '" data-toggle="vfees' + ix + '" >Visa Application</label></h3>' +
                            '<table class="table-fees" style="display:none">' +
                            '<tbody>' +
                            vifeesHtml +
                            '<tr>' +
                            '<td>Please Fill In Visa Application Form Below</td>' +
                            '<td></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>' +
                            '<div class="form-group">' +
                            '<div class="col-md-4">' +
                            '<input type="text" class="form-control" name="fname[' + ix + ']" placeholder="First Name">' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<input type="text" class="form-control" name="mname[' + ix + ']" placeholder="Middle Name">' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<input type="text" class="form-control" name="lname[' + ix + ']" placeholder="Last Name">' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '<td></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>' +
                            '<div class="form-group">' +
                            '<div class="col-md-4">' +
                            '<input type="text" class="form-control" name="passport[' + ix + ']" placeholder="Passport No.">' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<input type="text" class="form-control" name="issued_at[' + ix + ']" placeholder="Issued At">' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<input type="text" class="form-control datepicker" name="expires_on[' + ix + ']" placeholder="Expires On">' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '<td></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>' +
                            '<div class="form-group">' +
                            '<div class="col-md-12">' +
                            '<input type="text" class="form-control" name="address[' + ix + ']" placeholder="Address">' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '<td></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>' +
                            '<div class="form-group">' +
                            '<div class="col-md-12">' +
                            '<input type="text" class="form-control" name="empassy_address[' + ix + ']" placeholder="Nearest Empassy Address">' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '<td></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>' +
                            '<div class="form-group">' +
                            '<div class="col-md-12">' +
                            '<input type="text" class="form-control" name="additional_info[' + ix + ']" placeholder="Additional Visa Information">' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '<td></td>' +
                            '</tr>' +
                            '</tbody>' +
                            '</table>' +
                            '<h3 class="fees-title ' + hiddenx + '"><label>Papers & Publishing Fees</label><i class="red"> *</i></h3>' +
                            '<table class="table-fees">' +
                            '<tbody>' + paperHtml + '</tbody>' +
                            '</table>' +
                            '<h3 class="fees-title ' + cusHidden + '"><label>Additional Services</label></h3>' +
                            '<table class="table-fees">' +
                            '<tbody>' + cusHtml + '</tbody>' +
                            '</table>' +
                            '</div>' +
                            '<div class="panel-footer"><div class="row"><a onclick="removePay(' + ix + ')" class="regErrors pull-right" style="cursor: pointer;padding:0.5em;"><i class="glyphicon glyphicon-trash"></i>&ensp;Remove&ensp;</a></div></div>' +
                            '</div>';
                        inOtherPay.push(addemail);
                        $('.body').each(function () {
                            $(this).removeClass("active");
                        });
                        $(".head").each(function () {
                            $(this).removeClass("btn-success");
                            $(this).addClass("btn-defaultx");
                        });
                        $('#fees-others').append(addNewPay);
                        var scroll = ($(window).scrollTop() + 1000) + "px";
                        $('#addpay' + ix).slideDown('200', function () {
                            $("html, body").animate({scrollTop: scroll}, 1000);
                        });
                        $(function () {
                            $(".datepicker").datepicker();
                        });
                        accordion();
                        SumTotal();
                        toggleer();
                        $('.rfeeval').each(function () {
                            $(this).on('change', function () {
                                SumTotal();
                            });
                        });
                        $('input[name=add_name]').val('');
                        $('input[name=add_email]').val('');
                        $('select[name=add_type]').val(1);
                        returnN('New Payment added Successfuly for: ' + addname, '#777', 10000);
                        ix++;

                    },
                    error: function (response) {
                        if (response.responseText != '') {
                            informX('<strong style="color:red;border-bottom:2px #f1f1f1 solid">Error</strong><br>' + response.responseText);
                        }
                    }
                });
            }
        }

        function toggleer() {
            $('label[data-toggle]').each(function () {
                var target = $(this).data('toggle');
                $(this).on('click', function () {
                    var val = $('#' + target).val();
                    if (val == 0) {
                        $('#' + target).val(1);
                    }
                    if (val == 1) {
                        $('#' + target).val(0);
                    }
                });
            });
        }

        function accordion() {
            $('.head').each(function () {
                $(this).on('click', function () {
                    if ($(this).next('.body').hasClass('active')) {
                    } else {
                        $('.body').each(function () {
                            $(this).removeClass("active");
                        });
                        $(".head").each(function () {
                            $(this).removeClass("btn-success");
                            $(this).addClass("btn-defaultx");
                        });
                        $(this).next('.body').addClass("active");
                        $(this).addClass("btn-success");
                        $(this).removeClass("btn-defaultx");
                    }
                });
            });
            $('.check-toggle').each(function () {
                $(this).on('change', function () {
                    var children = $(this).data('children');
                    if ($(this).is(':checked')) {
                        $(this).parent('h3').next('table').show();
                        $("." + children).each(function () {
                            $(this).addClass('rfeeval');
                            $(this).on('click', function () {
                                SumTotal();
                            });
                        })
                    } else {
                        $(this).parent('h3').next('table').hide();
                        $("." + children).each(function () {
                            $(this).removeClass('rfeeval');
                        })
                    }
                    SumTotal();
                });
            });
        }

        function SumTotal() {
            $('#total').html('');
            $('#totalx').html('');
            $('#fees-sum').html('');
            $('#fees-sumx').html('');
            var total = 0;
            var fees = 0;
            var noOfPapers = $(".paperFees:checked").length;
            var paperIndex = 1;
            var paperFeesDiscount = 0;
            $('.rfeeval').each(function () {
                fees = $(this).data('feeval');
                var title = $(this).data('title');
                var name = $(this).data('name');

                if ($(this).is(':checked')) {

                    var newSum = '<tr class="sumitem">' +
                        '<td>' + title + '</td>' +
                        '<td dir="ltr" style="min-width: 86px">' + amount(fees) + '.00 <span class="" style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;&ensp;</span></td>' +
                        '</tr>';
                    var newSumx = '<tr class="sumitemx">' +
                        '<td>' + title + '</td>' +
                        '<td>' + name + '</td>' +
                        '<td dir="ltr" style="min-width: 86px">' + amount(fees) + '.00 <span class="" style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;&ensp;</span></td>' +
                        '</tr>';
                    $('#fees-sum').append(newSum);
                    $('#fees-sumx').append(newSumx);
                    total = Number(total) + fees;

                    if ($(this).hasClass("paperFees") && noOfPapers > 1 && paperIndex > 1) {
                        paperFeesDiscount = $(this).data("fees-discount");
                        var newSum = '<tr class="sumitem">' +
                            '<td>' + title + ' Discount</td>' +
                            '<td dir="ltr" style="min-width: 86px">' + amount(paperFeesDiscount) + '.00 - <span class="" style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;&ensp;</span></td>' +
                            '</tr>';
                        var newSumx = '<tr class="sumitemx">' +
                            '<td>' + title + ' Discount</td>' +
                            '<td>' + name + '</td>' +
                            '<td dir="ltr" style="min-width: 86px">' + amount(paperFeesDiscount) + '.00 - <span class="" style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;&ensp;</span></td>' +
                            '</tr>';
                        $('#fees-sum').append(newSum);
                        $('#fees-sumx').append(newSumx);
                        total = Number(total) - paperFeesDiscount;

                    }
                    paperIndex = 2;


                }
            });
            if ($("#promo_code_amount").val()) {
                discount = Math.floor((Number(total) * Number($("#promo_code_amount").val())) / 100);
                var newSum = '<tr class="sumitem">' +
                    '<td>Promo Code Discount</td>' +
                    '<td dir="ltr" style="min-width: 86px"> ' + discount + '.00 - <span class="" style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;&ensp;</span></td>' +
                    '</tr>';
                var newSumx = '<tr class="sumitemx">' +
                    '<td>Promo Code Discount</td>' +
                    '<td>' + $("#promo_code_amount").data('name') + '</td>' +
                    '<td dir="ltr" style="min-width: 86px"> ' + discount + '.00 - <span class="" style="font-size: 10px;font-weight: 700;color:green">{{$event->currency}}&ensp;&ensp;</span></td>' +
                    '</tr>';
                $('#fees-sum').append(newSum);
                $('#fees-sumx').append(newSumx);
                total = Number(total) - discount;
            }
            isTotal = total + '.00';
            $('#totalx').html(amount(total));
            $('#amount_online').val(total + '.00');
            $('#amountBank').val(total + '.00');
            $('#custom_money').val(amount(total));
            return $('#total').html(amount(total));
        };

        function removePay(id) {
            var target = document.getElementById('addpay' + id);
            var email = $(target).data('email');
            $(target).slideUp("500", function () {
                $(this).remove();
                SumTotal();
            });
            inOtherPay.splice(email);
        }

        function toReview() {
            $('.order').each(function () {
                $(this).fadeOut(200);
            });
            $('.checkout').each(function () {
                $(this).fadeOut(200);
            });
            $('.review').each(function () {
                $(this).fadeIn(200);
            });
            $('.step').each(function () {
                $(this).removeClass('actv');
            })
            $('.reviewS').addClass('actv');
        }

        function toOrder() {
            $('.order').each(function () {
                $(this).fadeIn(200);
            });
            $('.checkout').each(function () {
                $(this).fadeOut(200);
            });
            $('.review').each(function () {
                $(this).fadeOut(200);
            });
            $('.step').each(function () {
                $(this).removeClass('actv');
            })
            $('.orderS').addClass('actv');
        }
        
        function disableButtons() {
            var paymentButtons = document.getElementsByClassName('disableOnPayment');
  var len = paymentButtons.length;
            for(i = 0; i < len; i++) {
              paymentButtons[i].style.display = 'none';
            }
        }
        
        function enableButtons () {
            var paymentButtons = document.getElementsByClassName('disableOnPayment');
  var len = paymentButtons.length;
            for(i = 0; i < len; i++) {
              paymentButtons[i].style.display = '';
            }
        }
        
        function toCheckout() {
            // $('#payments').submit();
            
            $('.order').each(function () {
                $(this).fadeOut(200);
            });
            $('.checkout').each(function () {
                $(this).fadeIn(200);
            });
            $('.pay-custome').each(function () {
                $(this).fadeIn(200);
            });
            $('.send-email').each(function () {
                $(this).fadeIn(200);
            });
            $('.review').each(function () {
                $(this).fadeOut(200);
            });
            $('.step').each(function () {
                $(this).removeClass('actv');
            })
            $('.checkoutS').addClass('actv');
        }

        function checkout() {
            disableButtons();
            if (isTotal < 1) {
                informX('Please choose services to checkout');
                enableButtons();
            } else {
                if ($('#terms').is(':checked')) {
                    if (payMethod == '') {
                        informX('Please choose a payment method');
                        enableButtons();
                    } else {
                        $('input').each(function () {
                            $(this).css('box-shadow', '0 0 0 0 red')
                        });
                        var errs = 0;
                        if (payMethod == 'cc') {
                            $('#paymentType').val('2');
                            var ccName = $('#ccName').val();
                            if (ccName == '') {
                                $('#ccName').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var ccEmail = $('#ccEmail').val();
                            if (ccEmail == '') {
                                $('#ccEmail').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var ccPhone = $('#ccPhone').val();
                            if (ccPhone == '') {
                                $('#ccPhone').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var ccAddress = $('#ccAddress').val();
                            if (ccAddress == '') {
                                $('#ccAddress').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var ccCity = $('#ccCity').val();
                            if (ccCity == '') {
                                $('#ccCity').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var ccState = $('#ccState').val();
                            if (ccState == '') {
                                $('#ccState').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var ccZip = $('#ccZip').val();
                            if (ccZip == '') {
                                $('#ccZip').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var ccCountry = $('#ccCountry').val();
                            if (ccCountry == '') {
                                $('#ccCountry').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var ccNo = $('#ccNo').val();
                            if (ccNo == '') {
                                $('#ccNo').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var cvv = $('#cvv').val();
                            if (cvv == '') {
                                $('#cvv').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var expMonth = $('#expMonth').val();
                            if (expMonth == '') {
                                $('#expMonth').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var expYear = $('#expYear').val();
                            if (expYear == '') {
                                $('#expYear').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }

                            if (errs == 0) {
                                if ($('#ccNo').hasClass('valid')) {
                                    var totalFinal = $('input[name=amount]').val();
                                    var originCur = $('input[name=currency]').val();
                                    if (totalFinal == isTotal && originCur == currency) {
                                        tokenRequest();
                                    } else {
                                        informX('<p style="color:red"><i class="fa fa-warning"></i> We believe that your web browser or connection is unsecured, we are sorry, we can not process your payment right now. !<br>Please try again later, use a better secured connection or contact your IT support.<br><br>If you think this is not correct, please let us know (<strong>Need support? <a href="/contact-us">Contact Us</a></strong>)</p>');
                                        $('#ccNo').val('');
                                        $('#ccNo').removeClass('valid').removeClass('invalid');
                                        $('#cvv').val('');
                                        $('#expMonth').val('');
                                        $('#expYear').val('');
                                    }
                                } else {
                                    informX('<p style="color:red"><i class="fa fa-info"></i> Your entered credit card is invalid or not supported, please check your card number and try again.</p>');
                                    enableButtons();
                                }
                            } else {
                                informX('<p style="color:red">Please fill in all required information.</p>');
                                enableButtons();
                            }
                        } else if (payMethod == 'bank') {
                            $('#paymentType').val('3');
                            var userBankName = $('#userBankName').val();
                            if (userBankName == '') {
                                $('#userBankName').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var userBankEmail = $('#userBankEmail').val();
                            if (userBankEmail == '') {
                                $('#userBankEmail').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var userBankPhone = $('#userBankPhone').val();
                            if (userBankPhone == '') {
                                $('#userBankPhone').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            if (errs == 1) {
                                informX('<p style="color:red">Please fill in all required information.</p>');
                                enableButtons();
                            }

                            var formData = $('#payments').serialize();
                            $.ajax({
                                type: 'POST',
                                url: '/payBank',
                                dataType: 'json',
                                data: formData,
                                beforeSend: function (xhr) {
                                    $('.processing').fadeIn(200);
                                    $('.creditcardform').hide();
                                    $('.cash').hide();
                                    $('.checkbtn').hide();
                                    $('.steps').hide();
                                    $('.bank').slideUp(200);
                                },
                                success: function (response) {
                                    console.log(response);
                                },
                                error: function (response) {
                                    enableButtons();
                                    console.log(response);
                                    $('.steps').fadeOut();
                                    $('.process').fadeOut();
                                    $('.successForm').slideDown(200);
                                    $('.successMessage').html('<strong>Thanks for your payment But it is pending until paying in the bank!</strong>.<br>You will receive email from us soon confirming your registration.');
                                }

                            });

                        } else if (payMethod == 'cash') {
                            $('#paymentType').val('4');
                            var userCashName = $('#userCashName').val();
                            if (userCashName == '') {
                                $('#userCashName').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var userCashEmail = $('#userCashEmail').val();
                            if (userCashEmail == '') {
                                $('#userCashEmail').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            var userCashPhone = $('#userCashPhone').val();
                            if (userCashPhone == '') {
                                $('#userCashPhone').css('box-shadow', '0 0 0 1px red');
                                errs = 1;
                            }
                            if (errs == 1) {
                                informX('<p style="color:red">Please fill in all required information.</p>');
                            }
                            var formData = $('#payments').serialize();
                            $.ajax({
                                type: 'POST',
                                url: '/payBank',
                                dataType: 'json',
                                data: formData,
                                beforeSend: function (xhr) {
                                    $('.processing').fadeIn(200);
                                    $('.creditcardform').hide();
                                    $('.bank').hide();
                                    $('.checkbtn').hide();
                                    $('.steps').hide();
                                    $('.cash').slideUp(200);
                                },
                                success: function (response) {
                                    console.log(response);
                                },
                                error: function (response) {
                                    console.log(response);
                                    $('.steps').fadeOut();
                                    $('.process').fadeOut();
                                    $('.successForm').slideDown(200);
                                    $('.successMessage').html('<strong>Thanks for your payment But it is pending until paying in the our office!</strong>.<br>You will receive email from us soon confirming your registration.');
                                }

                            });
                        }
                    }
                } else {
                    informX('Please check Read and Agree to our Terms & Conditions after you read it well, then click Checkout');
                    enableButtons();
                }
            }

        }

        function toggle_fee(id) {
            var target = document.getElementById(id);
            var val = target.value;
            if (val == 0) {
                target.value = 1;
            }
            if (val == 1) {
                target.value = 0;
            }
        }

        var payMethod = '';
        $(document).ready(function () {
            accordion();
            SumTotal();
            $('.rfeeval').each(function () {
                $(this).on('change', function () {
                    SumTotal();
                });
            });

            $('.paymethod').each(function () {
                $(this).on('click', function () {
                    $('.paymethod').each(function () {
                        $(this).removeClass('actv');
                        $(this).next('div').slideUp(200);
                    });
                    $(this).addClass('actv');
                    $(this).next('div').slideDown(200);
                    payMethod = $(this).data('method');
                });
            });

            $('.copier').each(function () {
                $(this).on('change keyup', function () {
                    var copyTo = $(this).data('copy');
                    var target = document.getElementById(copyTo);
                    target.value = this.value;
                });
            });

            //Validate CC
            $('#ccNo').on('keyup change', function () {
                var val = $(this).val();
                if (val.length >= 13) {
                    var vvld = 0;
                    var mvld = 0;
                    var dvld = 0;
                    var avld = 0;
                    var jvld = 0;
                    var cvld = 0;
                    if (checkCreditCard(val, 'Visa')) {
                        var vvld = 0;
                    } else {
                        var vvld = 1;
                    }
                    if (checkCreditCard(val, 'MasterCard')) {
                        var mvld = 0;
                    } else {
                        var mvld = 1;
                    }
                    if (checkCreditCard(val, 'Discover')) {
                        var dvld = 0;
                    } else {
                        var dvld = 1;
                    }
                    if (checkCreditCard(val, 'AmEx')) {
                        var avld = 0;
                    } else {
                        var avld = 1;
                    }
                    if (checkCreditCard(val, 'JCB')) {
                        var jvld = 0;
                    } else {
                        var jvld = 1;
                    }
                    if (checkCreditCard(val, 'DinersClub')) {
                        var cvld = 0;
                    } else {
                        var cvld = 1;
                    }

                    if (vvld == 0 || mvld == 0 || dvld == 0 || avld == 0 || jvld == 0 || cvld == 0) {
                        $(this).addClass('valid').removeClass('invalid');
                        $('#invCc').html('');
                    } else {
                        $(this).addClass('invalid').removeClass('valid');
                        $('#invCc').html(ccErrors[ccErrorNo]);
                    }
                } else {
                    $(this).removeClass('invalid').removeClass('valid');
                    $('#invCc').html('');
                }
            });
        });
    </script>
    <script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
    <script type="text/javascript">
        // Called when token created successfully.
        var successCallback = function (data) {
            var myForm = document.getElementById('payForm');
            $('#ccNo').val('');
            $('#ccNo').removeClass('valid').removeClass('invalid');
            $('#cvv').val('');
            $('#expMonth').val('');
            $('#expYear').val('');
            // Set the token as the value for the token input
            myForm.token.value = data.response.token.token;

            $('#c_Token').val(data.response.token.token);

            // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
            // myForm.submit();
            makePayment();
        };

        // Called when token creation fails.
        var errorCallback = function (data) {
            if (data.errorCode === 200) {
                // This error code indicates that the ajax call failed. We recommend that you retry the token request.
            } else {
                informX(data.errorMsg);
            }
        };

        var tokenRequest = function () {
            // Setup token request arguments
            var args = {
                sellerId: "102563668",
                publishableKey: "34AAFD4C-0977-470C-B0CB-61611C1164BE",
//       sellerId: "901381413",
//       publishableKey: "C578C187-BB3C-41A5-8581-8F6B5B68A3A5",
                ccNo: $("#ccNo").val(),
                cvv: $("#cvv").val(),
                expMonth: $("#expMonth").val(),
                expYear: $("#expYear").val()
            };

            // Make the token request
            TCO.requestToken(successCallback, errorCallback, args);
        };

        $(function () {

            // Pull in the public encryption key for our environment
            TCO.loadPubKey('production');
//        TCO.loadPubKey('sandbox');

            $("#payments").submit(function (e) {
                // Call our token request function

                // tokenRequest();
                // Prevent form from submitting
                return false;
            });
        });

        function makePayment() {
            var myForm = document.getElementById('payments');
            var formData = new FormData(myForm);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/pay',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function (xhr) {
                    $('.processing').fadeIn(200);
                    $('.bank').hide();
                    $('.cash').hide();
                    $('.checkbtn').hide();
                    $('.steps').hide();
                    $('.creditcardform').slideUp(200);
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (response) {
                    console.log(response);
                    //check if response with success : true/false
                    if (response.responseText == 'APPROVED') {
                        $('.steps').fadeOut();
                        $('.process').fadeOut();
                        $('.successForm').slideDown(200);
                        $('.successMessage').html('<strong>Thanks for your payment!</strong>.<br>You will receive email from us soon confirming your registration.');
                    } else {
                        $('.processing').fadeOut();
                        $('.bank').show();
                        $('.cash').show();
                        $('.steps').show();
                        $('.checkbtn').show();
                        $('.creditcardform').slideDown(200);
                        informX('<strong>Payment Faild</strong>,<br><br>' + response.responseText + ' (<strong>Need help? <a href="/contact-us">Contact Us</a></strong>)');
                        enableButtons();
                    }
                }
            });
        }

        $(window).bind('load', function () {
            setTimeout(ifPayment());
        });

        function ifPayment() {
            var count = $('[data-feeval]').length;
            if (count <= 0) {
                informX('There is no fees to pay at this moment, please checkback later.');
                $('.cOk').on('click', function () {
                    window.open('/events/{{$event->slug}}', '_self');
                });
            }
        }

        function makeid() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 5; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            return text;
        }

        function informX(message) {
            var cHolder = document.createElement('div');
            cName = makeid();
            cHolder.id = cName;
            cHolder.className = 'cHolder';
            document.getElementsByClassName('cBlocker')[0].appendChild(cHolder);
            var target = document.getElementById(cName);
            var cText = document.createElement('p');
            var cOk = document.createElement('div');
            cOk.className = "cOk";
            cOk.innerHTML = 'Close';
            $(cOk).on('click', function () {
                $(this).closest('.cHolder').fadeOut(500);
                $('.cBlocker').fadeOut(500);
            })
            cText.innerHTML = message;
            cText.style.color = '#888';
            target.appendChild(cText);
            target.appendChild(cOk);
            $(target).fadeIn(500);
            $('.cBlocker').fadeIn(500);
        }
        
                var gulp = document.getElementById("flower_gulp");
        gulp.onclick = function gorwn () {
          
          gulp.classList.add("v_clos");
           setTimeout(function(){
            gulp.classList.remove("v_clos");
           },3500);
        }
    gorwn();

    </script>
@endpush
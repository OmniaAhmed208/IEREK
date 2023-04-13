@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row" >

        <div class="col-md-12  applying-area">
            <img width="100%" src="/uploads/images/become_sponsor.jpg" class="img-responsive" alt="Feedback"
                 10683330_1472142813068612_1213931060_o"">

            <div class="frame-title col-md-12 mr-top">
                BOOKING FORM SPONSORSHIP PACKAGES
            </div>
             {{-- success-msg --}}
                   @if(Session::has('message'))
                       <h4 class="applying-area green font text-center">{{Session::get('message')}}</h4>
                   </div>
                   @endif
            {{--<h4 class="font  marg-lef applying-area">Contact Details</h4>--}}
            <form class="padl applying-area" action="/sponsor_store" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">
                <input type="hidden" name="sponsor_event" value="{{$event_id}}" placeholder="">
<div >
    <label>Contact Details</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="sponsor_gendar" id="exampleRadios1" value="mr"  <?php if(old('sponsor_gendar') == "mr") echo "checked" ?>  >
            Mr

    </div>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="sponsor_gendar" id="exampleRadios2" value="ms" <?php if(old('sponsor_gendar') == "ms") echo "checked" ?>  >

           Ms

    </div>
</div>
                 <div>
                                <p class="error-text">{{$errors->first('sponsor_gendar')}}</p>
                            </div>

                <div >
                    <label>Title</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sponsor_title" id="exampleRadios3" value="prof"<?php if(old('sponsor_title') == "prof") echo "checked" ?>>

                          Prof

                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sponsor_title" id="exampleRadios4" value="dr" <?php if(old('sponsor_title') == "dr") echo "checked" ?>>

                           Dr

                    </div>
                    
                     <div>
                                <p class="error-text">{{$errors->first('sponsor_title')}}</p>
                            </div>
                </div>


                <div class="form-group">
                    <label >Full Name</label>
                    <input type="text" name="sponsor_name" class="form-control" value="{{old('sponsor_name')}}">
 
                    <div>
                                <p class="error-text">{{$errors->first('sponsor_name')}}</p>
                            </div>
                </div>


                <div class="form-group">
                    <label >Organization Name</label>
                    <input type="text" name="sponsor_organization" class="form-control" value="{{old('sponsor_organization')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_organization')}}</p>
                            </div>
                </div>


                <div class="form-group">
                    <label >Website</label>
                    <input type="text" name="sponsor_website" class="form-control" value="{{old('sponsor_website')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_website')}}</p>
                            </div>
                </div>

                <div class="form-group">
                    <label >Department</label>
                    <input type="text" name="sponsor_department" class="form-control" value="{{old('sponsor_department')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_department')}}</p>
                            </div>
                </div>

                <div class="form-group">
                    <label >Street</label>
                    <input type="text" name="sponsor_street" class="form-control" value="{{old('sponsor_street')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_street')}}</p>
                            </div>
                </div>

                <div class="form-group">
                    <label >Postal Code</label>
                    <input type="text" name="sponsor_code" class="form-control" value="{{old('sponsor_code')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_code')}}</p>
                            </div>
                </div>

                <div class="form-group">
                    <label >City</label>
                    <input type="text" name="sponsor_city" class="form-control" value="{{old('sponsor_city')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_city')}}</p>
                            </div>
                </div>

                <div class="form-group">
                    <label >Country</label>
                    <input type="text" name="sponsor_country" class="form-control" value="{{old('sponsor_country')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_country')}}</p>
                            </div>
                </div>

                <div class="form-group">
                    <label >Phone</label>
                    <input type="text" name="sponsor_phone" class="form-control" value="{{old('sponsor_phone')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_phone')}}</p>
                            </div>
                </div>

                <div class="form-group">
                    <label >Fax</label>
                    <input type="text" name="sponsor_fax" class="form-control" value="{{old('sponsor_fax')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_fax')}}</p>
                            </div>
                </div>

                <div class="form-group">
                    <label >Mobile</label>
                    <input type="text" name="sponsor_mobile" class="form-control" value="{{old('sponsor_mobile')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_mobile')}}</p>
                            </div>
                </div>

                <div class="form-group">
                    <label >Email</label>
                    <input type="text" name="sponsor_email" class="form-control" value="{{old('sponsor_email')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_email')}}</p>
                            </div>
                </div>

<label>Please indicate which sponsorship package you are interested in:
</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sponsor_package"  value="platinum" <?php if(old('sponsor_package') == "platinum") echo "checked" ?> >

                        Platinum : $10,000

                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sponsor_package"  value="gold" <?php if(old('sponsor_package') == "gold") echo "checked" ?> >

                        Gold : $7,000

                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sponsor_package"  value="silver" <?php if(old('sponsor_package') == "silver") echo "checked" ?> >

                        Silver : $5,000

                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sponsor_package"  value="bronze" <?php if(old('sponsor_package') == "bronze") echo "checked" ?> >

                        Bronze : $3,000

                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sponsor_package"  value="1booth" <?php if(old('sponsor_package') == "1booth") echo "checked" ?> >

                        1 Booth : $2,000

                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sponsor_package"  value="2booths" <?php if(old('sponsor_package') == "2booths") echo "checked" ?> >

                        2 Booths : $3,500

                </div>
                            <div>
                                <p class="error-text">{{$errors->first('sponsor_package')}}</p>
                            </div>
<label class="margin-top">Payment Information</label>
                You will receive an invoice by IEREK.
                A sponsorship is secured only on receipt of the sponsorship contribution.

                <div class="form-group">
                    <label >Signature</label>
                    <input type="text" name="sponsor_signature" class="form-control" value="{{old('sponsor_signature')}}">

                    <div>
                                <p class="error-text">{{$errors->first('sponsor_signature')}}</p>
                            </div>
                </div>

<!--                <div class="form-group">
                    <label >Date</label>
                    <input type="text" name="date" class="form-control" value="{{old('date')}}">

                    <div>
                                <p class="error-text">{{$errors->first('date')}}</p>
                            </div>
                </div>

                <div class="form-group">
                    <label >Name</label>
                    <input type="text" name="full_name" class="form-control" value="{{old('full_name')}}">

                    <div>
                                <p class="error-text">{{$errors->first('full_name')}}</p>
                            </div>
                </div>


                <div class="form-group">
                    <label >Affiliation</label>
                    <input type="text" name="affliation" class="form-control" value="{{old('affliation')}}">

                    <div>
                                <p class="error-text">{{$errors->first('affliation')}}</p>
                            </div>
                </div>-->
                <div class="text-center">
                <button class="btn btn-primary btn-lg">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
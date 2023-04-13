
@extends('layouts.master')
@section('content')

    <div class="container">
        <img width="100%" src="/images/Host_Aconference.jpg" class="img-responsive" alt="Host a conference" 10683330_1472142813068612_1213931060_o""="">
        <div class="frame-title col-md-12 mr-top">
            Host a conference in your university
        </div>
        <div class="row" id="applying-area">


            <div class="col-md-12" >
                {{-- main title --}}


            </div>

            <div class="col-md-12  ">

                <form class="form" method="post" action="/host_conference/store">

                 <input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">

               <div class="col-md-12 framed-content">
                   {{-- success-msg --}}
                   @if(Session::has('message'))
                   <div class="text-center sucess-msg">
                       <h4 class="font">{{Session::get('message')}}</h4>
                   </div>
                   @endif
                   <!--
                   {{-- error-msg --}}
                   <div class="text-center error-msg">
                       <h4 class="font">sibmiting failed</h4>
                   </div>
                   {{-- tetx --}}-->
                   <div class="col-md-12 mr-top">

                       <p class="mr-bottom">IEREK annually invites interested universities and colleges to submit a comprehensive proposal to host a future annual conference (one year prior to the actual event). 
                           </p>

                   </div>
                   {{-- form info ---}}
                    <div class="form-group mr-top ">
                        <label  class="col-xs-12 col-form-label regular-label ">University name</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control mar-bottom" name="host_university" value="{{old('host_university')}}">
                            <div>
                                <p class="error-text">{{$errors->first('host_university')}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label  class="col-xs-12 col-form-label regular-label">Contact person name</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control mar-bottom" name="host_contact_name" value="{{old('host_contact_name')}}">
                            <div>
                                <p class="error-text">{{$errors->first('host_contact_name')}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label  class="col-xs-12 col-form-label regular-label">Contact person email</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control mar-bottom" name="host_contact_email" value="{{old('host_contact_email')}}">
                            <div>
                                <p class="error-text">{{$errors->first('host_contact_email')}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label  class="col-xs-12 col-form-label regular-label">Contact person affiliation</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control mar-bottom" name="host_contact_affliation" value="{{old('host_contact_affliation')}}">
                            <div>
                                <p class="error-text">{{$errors->first('host_contact_affliation')}}</p>
                            </div>
                        </div>
                    </div>



                    {{-- tetx --}}
                    <div class="form-group col-md-12 mr-top">
                        <label  class="col-xs-12 col-form-label pl-0">Kindly attach/upload your proposal and make sure to provide the details below. Complete Proposals will include:</label>


                    </div>

                        <div class="form-group mr-top">
                            <label  class="col-xs-12 col-form-label regular-label mr-bottom ">Conference facilities overview and capacity</label>
                            <div class="col-xs-12">
                            <textarea class="form-control" rows="7" name="host_conference_overview">{{old('host_conference_overview')}}</textarea>
                                <div>
                                    <p class="error-text">{{$errors->first('host_conference_overview')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mr-top">
                            <label  class="col-xs-12 col-form-label regular-label mr-bottom mr-top">Residential hall overview and on/off campus accommodations capacity
                            </label>
                            <div class="col-xs-12">
                            <textarea class="form-control" rows="7" name="host_residential_overview" >{{old('host_residential_overview')}}</textarea>
                                <div>
                                    <p class="error-text">{{$errors->first('host_residential_overview')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mr-top">
                            <label  class="col-xs-12 col-form-label regular-label mr-bottom mr-top">Catering, meals, and reception</label>
                            <div class="col-xs-12">
                                <textarea class="form-control" rows="7" name="host_catering" >{{old('host_catering')}}</textarea>
                                <div>
                                    <p class="error-text">{{$errors->first('host_catering')}}</p>
                                </div>
                            </div>
                        </div>
                    
                       <div class="form-group mr-top">
                            <label  class="col-xs-12 col-form-label regular-label mr-bottom mr-top">Location</label>
                            <div class="col-xs-12">
                                <textarea class="form-control" rows="7" name="host_location" >{{old('host_location')}}</textarea>
                                <div>
                                    <p class="error-text">{{$errors->first('host_location')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mr-top">
                            <label  class="col-xs-12 col-form-label regular-label mr-bottom mr-top">Pre-conference programming
                               </label>
                            <div class="col-xs-12" >
                                <textarea class="form-control" rows="7" name="host_conference_program" >{{old('host_conference_program')}}</textarea>
                                <div>
                                    <p class="error-text">{{$errors->first('host_conference_program')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mr-top ">
                            <label  class="col-xs-12 single col-form-label regular-label mr-bottom mr-top">Budget (pre and post-conference) </label>
                            <div class="col-xs-12" >
                            <textarea class="form-control" rows="7" name="host_budget" >{{old('host_budget')}}</textarea>
                                <div>
                                    <p class="error-text">{{$errors->first('host_budget')}}</p>
                                </div>
                            </div>


                        </div>

                        <div class="form-group mr-top ">

                            <div class="col-xs-12 mr-top text-right">
                                <button class="btn btn-default centringClass main-submit-button">Send</button>
                            </div>

                        </div>
               </div>
                </form>

        </div>



        </div>
    </div>

@endsection
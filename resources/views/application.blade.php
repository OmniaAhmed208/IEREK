
@extends('layouts.master')
@section('content')
    <div class="container">
        <img width="100%" src="/storage/uploads/studyabroads/{{$event}}/cover_img.jpg" class="img-responsive" alt="Host a conference" 10683330_1472142813068612_1213931060_o""="">
        <div class="row">
            <div class="col-md-12">


            </div>

            <div class="col-md-12">
                {{-- main title --}}
            <div class="frame-title col-md-12 mr-top">
                APPLICATION FORM
            </div>

            </div>

            <div class="col-md-12  ">

                <form class="form" method="post" action="/study_abroad/storeApplication">

                 <input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">
                 <input type="hidden" name="app_event_id" value="{{$event}}" placeholder="">
                 <input type="hidden" name="app_category" value="{{$category}}" placeholder="">
                 <input type="hidden" name="app_sub_category" value="{{$sub_category}}" placeholder="">

               <div class="col-md-12 framed-content" id="applying-area">
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

                       <p class="mr-bottom">(the form, duly filled in, must be uploaded in the on-line procedure of admission to the master course)(the form, duly filled in, must be uploaded in the on-line procedure of admission to the master course)
                           </p>

                   </div>
                   {{-- form info ---}}
                    <div class="form-group mr-top ">
                        <label  class="col-xs-12 col-form-label regular-label ">The undersigned (FORENAME, SURNAME)</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control mar-bottom" name="app_undersigned_name" value="{{old('app_undersigned_name')}}">
                            <div>
                                <p class="error-text">{{$errors->first('app_undersigned_name')}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label  class="col-xs-12 col-form-label regular-label">Date of birth</label>
                        <div class="col-xs-12">
                            <input id="datepicker"  class="form-control mar-bottom" name="app_date_birth_day" value="{{old('app_date_birth_day')}}">
                            <div>
                                <p class="error-text">{{$errors->first('app_date_birth_day')}}</p>
                            </div>
                        </div>
                    </div>


                    <div class="form-group ">
                        <label  class="col-xs-12 col-form-label regular-label">City</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control mar-bottom" name="app_city" value="{{old('app_city')}}">
                            <div>
                                <p class="error-text">{{$errors->first('app_city')}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label  class="col-xs-12 col-form-label regular-label">State</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control mar-bottom" name="app_state" value="{{old('app_state')}}">
                            <div>
                                <p class="error-text">{{$errors->first('app_state')}}</p>
                            </div>
                        </div>
                    </div>


                    <div class="form-group ">
                        <label  class="col-xs-12 col-form-label regular-label">State of residence</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control mar-bottom" name="app_state_of_residence" value="{{old('app_state_of_residence')}}">
                            <div>
                                <p class="error-text">{{$errors->first('app_state_of_residence')}}</p>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group mr-top">
                            <label  class="col-xs-12 col-form-label regular-label mr-bottom ">Permanent address</label>
                            <div class="col-xs-12">
                            <textarea class="form-control" rows="7" name="app_permanent_address">{{old('app_permanent_address')}}</textarea>
                                <div>
                                    <p class="error-text">{{$errors->first('app_permanent_address')}}</p>
                                </div>
                            </div>
                        </div>
                   

                    <div class="form-group ">
                        <label  class="col-xs-12 col-form-label regular-label">Email</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control mar-bottom" name="app_email" value="{{old('app_email')}}">
                            <div>
                                <p class="error-text">{{$errors->first('app_email')}}</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- tetx --}}
                    <div class="col-md-12 mr-top">

                      <div class="text-center">
                          <h5 class="font ">
                              APPLIES
                          </h5>
                          <p>For admission to the aforementioned master course</p>
                          <h5 class="font ">
                              And   ATTACHES
                          </h5>
                      </div>
                        <p>
to the formal admission form the following papers to be submitted mandatorily for the application evaluation:</p>
                        <ol type="1">
                            <li>photocopy of the personal ID document/passport uploaded during the on-line registration procedure</li>
                            <li>transcript of records/self declaration of the passed exams during the Italian academic career reading relevant marks.</li>
                            <li>In addition, whoever achieved a foreign academic title must attach:
                                copy of the Degree diploma with diploma supplement
                               <ul>
                                   <li>-	copy of the Degree diploma with diploma supplement
                                   </li>
                                   <li>-	copy of the “declaration of value” issued by the Italian Embassy/Consulate in the State where the academic title had been released (only if already available)
                                   </li>
                               </ul>
                            </li>
                            <li>reference letter</li>
                            <li>motivational letter</li>
                            <li>CV listing professional experiences in working environments pertaining the above master</li>
                        </ol>

                        


                    </div>
                    
                    <div class="form-group ">
                        <label  class="col-xs-12 col-form-label regular-label">Signature</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control mar-bottom" name="app_signature" value="{{old('app_signature')}}">
                            <div>
                                <p class="error-text">{{$errors->first('app_signature')}}</p>
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

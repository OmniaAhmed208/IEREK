@extends('admin.layouts.master')
@section('panel-title')Edit Invoice 
@endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-body">
            
                     @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    	<form method="post" id="invoice_form" action="{{url('/')}}/admin/invoices/update">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="panel-heading">
			<h3 class="panel-title">New Inovice</h3>
		</div>
                <div class="panel-body">
                    
                      <input class="form-control" type="hidden" name="order_id"  value="{{$orderId}}">
                      
                <div class="form-group">
							<label class="col-md-4 control-label">User Email</label>
							<div class="col-md-8">
                                                            <input class="form-control" style="margin-bottom:10px;" type="text" name="user_id" id="user_id"  value="{{$userEmail}}" disabled>
								<label id="user_id" class="regErrors" style="font-size:12px;font-weight:400;"></label>
							</div>
						</div>
                                    <div class="form-group">
							<label class="col-md-4 control-label">Event</label>
							<div class="col-md-8">
								<select name="event_id" class="form-control">
                                                                    {
                                                                    <option value="0">Choose Event</option>
                                                                      @foreach($events as $event)
                                                                      <option value="{{$event->event_id}}"
                                                                              @if($event->event_id == $eventId) 
                                                                              selected  
                                                                              @endif
                                                                              >{{$event->title_en}}</option>
								          @endforeach   
								</select>
							</div>
							<div class="clearfix"></div>
                                                        
                                                        
						</div>
                    
                    	<div class="form-group">
							<label class="col-md-4 control-label">Amount</label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="text" name="amount" value="{{$amount}}">
								<label id="amount_id" class="regErrors" style="font-size:12px;font-weight:400;"></label>
							</div>
						</div>
                    
                                         <div class="form-group">
							<label class="col-md-4 control-label">Currency</label>
							<div class="col-md-8">
								<select name="currency_id" class="form-control">
									<option value="0">Choose Currency</option>
										 @foreach($currencies as $currency)
										<option
                                                                                      @if($currency->currency_code == $currencymov) 
                                                                              selected  
                                                                              @endif    
                                                                                    value="{{$currency->currency_code}}">{{$currency->currency_code}}</option>
								          @endforeach  
								</select>
							</div>
							<div class="clearfix"></div>
                                                        
                                                        
						</div>
                    
                                                             <div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-8">
								<select name="type" class="form-control">
									<option value="0">Choose Type</option>
                                                                       
										<option value="4"
                                                                                    @if($type == 4) 
                                                                              selected  
                                                                              @endif        
                                                                                        
                                                                                        >Office</option>
                                                                                <option value="3"
                                                                                           @if($type == 3) 
                                                                              selected  
                                                                              @endif        
                                                                                      
                                                                                        >Bank</option>
                                                                                
                                                                                
                                                                                <option value="5"
                                                                                        @if($type == 5) 
                                                                              selected  
                                                                              @endif   
                                                                                        >Ierek bank account</option>
                                                                                <option value="6"
                                                                                        @if($type == 6) 
                                                                              selected  
                                                                              @endif   
                                                                                        >Dr.Mourad Bank account</option>
                                                                                <option value="7"
                                                                                        @if($type == 7) 
                                                                              selected  
                                                                              @endif   
                                                                                        >Cairo Office</option>
                                                                                <option value="8"
                                                                                        @if($type == 8) 
                                                                              selected  
                                                                              @endif   
                                                                                        >Alex office</option>
								</select>
							</div>
							<div class="clearfix"></div>
                                                        
                                                        
						</div>
                    </div>
                
                 <input type="submit" id="submit" name="submit" value="update">
                
                        </form>
     
                </div>
            </div>
        </div>
    </div>
<input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">


</div>



@endsection
@extends('admin.layouts.master')
@section('panel-title')Create Invoice 
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
                    	<form method="post" id="invoice_form" action="{{url('/')}}/admin/invoices/save">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="panel-heading">
			<h3 class="panel-title">New Inovice</h3>
		</div>
                <div class="panel-body">
                <div class="form-group">
							<label class="col-md-4 control-label">User Email</label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="text" name="email" id="user_id" value="">
								<label id="user_id" class="regErrors" style="font-size:12px;font-weight:400;"></label>
							</div>
						</div>
                                    <div class="form-group">
							<label class="col-md-4 control-label">Event</label>
							<div class="col-md-8">
								<select name="event_id" id="event_id" class="form-control">
                                                                    <option value="">Choose Event</option>
                                                                      @foreach($events as $event)
										<option value="{{$event->event_id}}">{{$event->title_en}}</option>
								          @endforeach   
								</select>
							</div>
							<div class="clearfix"></div>
                                                        
                                                        
						</div>
                    
                    	<div class="form-group">
							<label class="col-md-4 control-label">Amount</label>
							<div class="col-md-8">
								<input class="form-control" style="margin-bottom:10px;" type="text" name="amount" value="">
								<label id="amount_id" class="regErrors" style="font-size:12px;font-weight:400;"></label>
							</div>
						</div>
                    
                                         <div class="form-group">
							<label class="col-md-4 control-label">Currency</label>
							<div class="col-md-8">
								<select name="currency_id" class="form-control">
									<option value="">Choose Currency</option>
										 @foreach($currencies as $currency)
										<option value="{{$currency->currency_code}}">{{$currency->currency_code}}</option>
								          @endforeach  
								</select>
							</div>
							<div class="clearfix"></div>
                                                        
                                                        
						</div>
                    
                                                             <div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-8">
								<select name="type" class="form-control">
									<option value="">Choose Type</option>
                                                                       
										<option value="5">Ierek bank account</option>
                                                                                <option value="6">Dr.Mourad Bank account</option>
                                                                                <option value="7">Cairo Office</option>
                                                                                <option value="8">Alex office</option>
								</select>
							</div>
							<div class="clearfix"></div>
                                                        
                                                        
						</div>
                    </div>
                
                 <input type="submit" id="submit" name="submit" value="send">
                
                        </form>
     
                </div>
            </div>
        </div>
    </div>
<input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">


</div>

<link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script>
    $(function()
{
	 $( "#user_id" ).autocomplete({
             
	  source: "/admin/invoices/autocomplete",
	  minLength: 3,
	  select: function(event, ui) {
             
	  	$('#user_id').val(ui.item.value);
	  }
	});
});
</script>

@endsection
@extends('admin.layouts.master')
@section('return-url'){{url('/admin')}}@endsection
@section('panel-title') Payments Management @endsection

@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><i class="fa fa-dollar"></i> New Payments</h3>
                </div>
                <div class="panel-body">
                	<table class="table">
                		<thead>
                			<tr>
                				<th>Payment ID</th>
                				<th>Event</th>
                				<th>User</th>
                				<th>Date</th>
                				<th>Amount</th>
                				<th>Currency</th>
                				<th>Type</th>
                				<th>Action</th>
                			</tr>
                		</thead>
                		<tbody>
                			@foreach($orders as $order)
                			<tr>
                				<td>{{$order->payment_id}}</td>
                				<td>{{$order['event']->title_en}}</td>
                				<td>{{$order['parent']->first_name.' '.$order['parent']->last_name.' ('.$order['parent']->email.')'}}</td>
                				<td>{{$order->created_at}}</td>
                				<td>{{$order['total']}}</td>
                				<td>{{$order['currency']}}</td>
                				<td>@if($order->order_type == 2){{'Online CC'}}@elseif($order->order_type == 1){{'Online Custome'}}@else{{'Cash'}}@endif</td>
                				<td><a href="{{url('admin/payments/approve/'.$order->order_id)}}" class="btn">Approve</a><a href="{{url('admin/payments/decline/'.$order->order_id)}}" class="btn" style="color:red">Decline</a></td>
                			</tr>
                			@endforeach
                		</tbody>
                	</table>
                	{{$orders->links()}}
                </div>
            </div>	
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><i class="fa fa-search"></i> Search</h3>
                </div>
                <div class="panel-body">
					<div class="col-md-12 hide">
						<h4><i class="fa fa-clock-o"></i> Date Range</h4>
						<div class="col-md-4">
							<div class="form-group">
								<select class="select form-control" name="daterange" id="datarange">
									<option value="0" selected>All</option>
									<option value="1">Today</option>
									<option value="2">This Week</option>
									<option value="3">This Month</option>
									<option value="4">Custome Range</option>
								</select>
								<script type="text/javascript">
									$(document).ready(function(){
										$('#datarange').on('change', function(){
											var val = $(this).val();
											if(val == 4)
											{
												$('.c_dates').each(function(){
													$(this).removeClass('hidden');
												});
												$('input[name=from_date]').datepicker('setDate','{{ date('Y-m-d') }}');
												$('input[name=to_date]').datepicker('setDate','{{ date('Y-m-d', strtotime( date('Y-m-d') . '+1 day') ) }}');
												
											}
											else
											{
												$('.c_dates').each(function(){
													$(this).addClass('hidden');
												});
											}

											if(val == 0)
											{
												$('input[name=from_date]').datepicker('setDate','1970-01-01');
												$('input[name=to_date]').datepicker('setDate','{{ date('Y-m-d', strtotime( date('Y-m-d') . '+1 day') ) }}');
											}

											if(val == 1)
											{
												$('input[name=from_date]').datepicker('setDate','{{ date('Y-m-d') }}');
												$('input[name=to_date]').datepicker('setDate','{{ date('Y-m-d', strtotime( date('Y-m-d') . '+1 day') ) }}');
												
											}

											if(val == 2)
											{
												$('input[name=from_date]').datepicker('setDate','{{ date('Y-m-d', strtotime('last monday', strtotime('tomorrow')) ) }}');
												$('input[name=to_date]').datepicker('setDate','{{ date('Y-m-d') }}');
												
											}

											if(val == 3)
											{
												$('input[name=from_date]').datepicker('setDate','{{ date('Y-m-01') }}');
												$('input[name=to_date]').datepicker('setDate','{{ date('Y-m-01', strtotime( date('Y-m-01') . '+1 months') ) }}');
												
											}
										});
									});
								</script>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group c_dates hidden">
								<input type="text" name="from_date" value="1970-01-01" class="form-control datepicker" id="datepicker1">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group c_dates hidden">
								<input type="text" name="to_date" value="{{ date('Y-m-d', strtotime( date('Y-m-d') . '+1 day') ) }}" class="form-control datepicker" id="datepicker2">
							</div>
						</div>
					</div>
					<div class="col-md-12 hide">
						<hr>
						<div class="clearfix"></div>
					</div>
					<div class="col-md-4">
						<h4><i class="fa fa-user"></i> By User</h4>
						<form>
							<div class="form-group">
								<label class="control-label">User Email</label>
								<input type="text" class="form-control" name="user_email">
							</div>
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-success" value="Find">
							</div>
							<div class="clearfix"></div>
						</form>
						{{-- <h4><i class="fa fa-file"></i> By Paper</h4>
						<form>
							<div class="form-group">
								<label class="control-label">Paper Title</label>
								<input type="text" class="form-control" name="user_email">
							</div>
							<div class="form-group">
								<label class="control-label">Paper Code</label>
								<input type="text" class="form-control" name="paper_code">
							</div>
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-success" value="Find">
							</div>
						</form> --}}
					</div>
					<div class="col-md-4">
						<h4><i class="fa fa-calendar"></i> By Event</h4>
						<form>
							<div class="form-group">
								<label class="control-label">Event</label>
								<select class="form-control select" name="event_id">
									<option value="0">Choose Event</option>
									<optgroup label="Conferences">@foreach($events as $event)
										@if($event->category_id == 1)
											<option value="{{ $event->event_id }}">{{ $event->title_en }}</option>
										@endif
									@endforeach
									</optgroup>
									
									<optgroup label="Workshops">
									@foreach($events as $event)
										@if($event->category_id == 2)
											<option value="{{ $event->event_id }}">{{ $event->title_en }}</option>
										@endif
									@endforeach
									</optgroup>
									
									<optgroup label="Study Abroad">
									@foreach($events as $event)
										@if($event->category_id == 3)
											<option value="{{ $event->event_id }}">{{ $event->title_en }}</option>
										@endif
									@endforeach
									</optgroup>
								</select>
							</div>
                            <div class="form-group hide">
                                <label class="col-md-12 col-xs-12 control-label">Filters</label>
                                <div class="col-md-12 col-xs-12">         
                                    <label class="check col-md-6"><input type="checkbox" class="icheckbox" checked name="attendance" value="1" /> Attendance</label>
                                    <label class="check col-md-6"><input type="checkbox" class="icheckbox" checked name="accommodation" value="1" /> Accommodation</label>
                                    <label class="check col-md-6"><input type="checkbox" class="icheckbox" checked name="visa" value="1" /> Visa</label>
                                    <label class="check col-md-6"><input type="checkbox" class="icheckbox" checked name="publish" value="1" /> Publish</label>
                                    <label class="check col-md-6"><input type="checkbox" class="icheckbox" checked name="papers" value="1" /> Papers</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
							<div class="form-group hide">
								<label class="control-label">User Email (Optional)</label>
								<input type="text" class="form-control" name="user_email">
							</div>
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-success" value="Find">
							</div>
						</form>
					</div>
					<div class="col-md-4">
						<h4><i class="fa fa-barcode"></i> By Payment Id.</h4>
						<form>
							<div class="form-group">
								<label class="control-label">Payment Id.</label>
								<input type="text" class="form-control" name="payment_id">
							</div>
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-success" value="Find">
							</div>
							<div class="clearfix"></div>
						</form>
						{{-- <h4><i class="fa fa-bank"></i> By Invoice</h4>
						<form>
							<div class="form-group">
								<label class="control-label">Invoice No.</label>
								<input type="text" class="form-control" name="invoice_no">
							</div>
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-success" value="Find">
							</div>
						</form> --}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
	<script type="text/javascript">

	</script>
@endpush
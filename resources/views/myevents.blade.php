@extends('layouts.master')
@section('content')
<div id="CONDETAILP">
	<div class="container">
		<div class="col-md-12 order">
			<div class="panel">
				<div class="panel-heading">
					<h4>MY EVENTS</h4>
				</div>
				<div class="panel-body" id="myEvents">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Event</th>
								<th>Launch</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@if(isset($events) && count($events) > 0)
								@foreach($events as $event)
									@if( strtotime(date("d-m-Y", strtotime($event->events->start_date))) > strtotime(date("d-m-Y")))
									<tr>
										<?php 
										$status = array(
											0 => 'Awaiting Payment',
											1 => 'Paid'
										);
										$payment = array(
											0 => '<li><a href="/payment/'.$event->events->slug.'">Payment</a></li><li><a href="/events/'.$event->events->slug.'">View</a></li><li><a href="/unregister/'.$event->event_attendance_id.'">Unregister</a></li>',
											1 => '<li><a href="/events/'.$event->events->slug.'">View</a></li><li><a href="/">Ticket</a></li>'
										);
										?>
										<td>{{ $event->events->title_en }}</td>
										<td>{{ date("d M, Y" ,strtotime($event->events->start_date)) }}</td>
										<td>{{ $status[$event->payment] }}</td>
										<td>
											<div class="dropdown">
											  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Manage
											  <span class="caret"></span></button>
											  <ul class="dropdown-menu">
											    <?php echo $payment[$event->payment]; ?>
											  </ul>
											</div>
										</td>
									</tr>
									@endif
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style type="text/css">
	.btn-defaultx{
		background:#0c3852!important;
		color:#fff!important;
		cursor: pointer;
		transition: 0.3s;
	}
	.btn-defaultx:hover{
		background:#a97f18!important;
		color:#000;
	}
	.evgo{
		float: right;
		margin-right: 10px;
		margin-top: -30px;
	}
</style>
@endpush
@push('scripts')
@endpush
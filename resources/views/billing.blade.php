@extends('layouts.master')
@section('content')
<div id="CONDETAILP">
	<div class="container">
		<div class="col-md-12 order">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-dollar"></i> Billing History</h4>
                </div>
                <div class="panel-body">
                	<table class="table payment-table-mobile">
                		<thead>
                			<tr>
                				<th>Payment ID</th>
                				<th>Event</th>
                				<th>Date</th>
                				<th>Amount</th>
                				<th>Currency</th>
                				<th>Type</th>
                				<th>Status</th>
                			</tr>
                		</thead>
                		<tbody>
                			@foreach($orders as $order)
                			<tr>
                				<td><span class="table-header-onMobile">Payment ID</span>{{$order->payment_id}}</td>
                				<td><span class="table-header-onMobile">Event</span><a href="/events/{{$order['event']->slug}}">{{substr($order['event']->title_en,0,25)}}..</a></td>
                				<td><span class="table-header-onMobile">Date</span>{{date('F jS Y', strtotime($order->created_at))}}</td>
                				<td><span class="table-header-onMobile">Amount</span>{{$order->amount}}</td>
                				<td><span class="table-header-onMobile">Currency</span>{{$order->currency}}</td>
                				<td><span class="table-header-onMobile">Type</span>@if($order->order_type == 2){{'Online CC'}}@elseif($order->order_type == 1){{'Bank Transfer'}}@else{{'Cash'}}@endif</td>
                				<td><span class="table-header-onMobile">Status</span>{{$order->status}}</td>
                			</tr>
                			@endforeach
                		</tbody>
                	</table>
                	{{$orders->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection	
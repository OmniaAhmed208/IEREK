@extends('admin.layouts.master')
@section('return-url'){{url('/admin')}}@endsection
@section('panel-title') Payments Search @endsection

@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><i class="fa fa-calendar"></i> Event Payments</h3>
                </div>
                <div class="panel-body">
                	<table class="table">
                		<thead>
                			<tr>
                				<th>Payment ID</th>
                				<th>User</th>
                				<th>Date</th>
                				<th>Amount</th>
                				<th>Currency</th>
                				<th>Type</th>
                                <th>Status</th>
                				<th>Action</th>
                			</tr>
                		</thead>
                		<tbody>
                			@foreach($orders as $order)
                			<tr>
                				<td>{{$order->payment_id}}</td>
                				<td>{{$order['parent']->first_name.' '.$order['parent']->last_name.' ('.$order['parent']->email.')'}}</td>
                				<td>{{$order->created_at}}</td>
                				<td>{{$order->amount}}</td>
                				<td>{{$order->currency}}</td>
                				<td>@if($order->order_type == 2){{'Online CC'}}@elseif($order->order_type == 1){{'Bank Transfer'}}@else{{'Cash'}}@endif</td>
                                <td>{{$order->status}}</td>
                				<td><a href="{{url('admin/payments/approve/'.$order->order_id)}}" class="btn">Approve</a><a href="{{url('admin/payments/decline/'.$order->order_id)}}" class="btn" style="color:red">Decline</a></td>
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
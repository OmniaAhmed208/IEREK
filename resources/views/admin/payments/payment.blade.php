@extends('admin.layouts.master')
@section('return-url'){{url('/admin')}}@endsection
@section('panel-title') Payments Search @endsection

@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><i class="fa fa-barcode"></i> Payment Details</h3>
                </div>
                <div class="panel-body">
                	<table class="table">
                		<thead>
                			<tr>
                				<th>User</th>
                                <th>Event</th>
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
                                <td>{{$order['parent']->first_name.' '.$order['parent']->last_name.' ('.$order['parent']->email.')'}}</td>
                                <td>{{$order['event']->title_en}}</td>
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
                    <hr>
                    <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Event</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
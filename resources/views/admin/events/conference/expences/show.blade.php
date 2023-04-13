@extends('admin.layouts.master')
@section('panel-title')Manage Conference Expences <small>{{ "first Event" }} @endsection
@section('content')

<style>
    .total_amount {
        font-size: 2em;
        text-align: end;
        margin-right: 160px;
    }
</style>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-2 pull-right">
                        <a href="/admin/events/conference/expences/create/{{ $event_id }}" class="btn btn-success btn-block"><span class="fa fa-plus"></span> Add Expnces</a>
                    </div>
                   
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Event</th>
                                <th>Amount</th>
                                <th>Currency</th>
                                <th>Status</th>
                                <th>Actions</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                   $totalAmount = 0;
                                 @endphp
                                 
                          @foreach($expenses as $expenses_row)
                          
                                
                            <tr>
                                <td>{{$expenses_row->event->title_en}}</td>
                                <td>{{$expenses_row->event_id}}</td>
                                <td>{{$expenses_row->amount}}</td>
                                <td>{{$expenses_row->currency}}</td>
                                <td>{{$expenses_row->status}}</td>
                                 @php 
                                   $totalAmount += $expenses_row->amount;
                                 @endphp 
                                <td>
   <a href="#" class="btn btn-warning">Edit</a>                                  
    <a href="#" class="btn btn-danger">Delete</a>                                 
                                </td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                    
                  <div class="total_amount" />
    <label>Total</label>
    <label>{{$totalAmount}} {{$event_currency}}</label>
</div>
                </div>
                  
            </div>
           
        </div>
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">
    </div>
   
</div>
@endsection
@extends('admin.layouts.master') @section('return-url'){{route('showConferenceFees', $event_id)}}@endsection @section('panel-title')Create New Fees @endsection @section('content')
<!-- PAGE CONTENT WRAPPER -->
<style>
    .total_amount {
        font-size: 2em;
        text-align: end;
        margin-right: 160px;
    }
</style>
<div class="page-content-wrap">
    <div class="row">
          @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="col-md-12">
            <form class="form-horizontal" method="post" id="create_form" action="/admin/events/conference/expences/store">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="post">
                <input type="hidden" name="event_id" value="{{ $event_id }}">
                <div class="panel panel-default">
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            <p>Fill in conference fees information.</p>
                            <p>Fields with <span class="redl">*</span> is required.</p>
                            <div class="form-group" id="title_en">
                                <label class="col-md-3 col-xs-12 control-label">Title</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">En <span class="redl">*</span></span>
                                        <input type="text" name="title" id="title_input" class="form-control" />
                                    </div>
                                    <label id="title_err" class="help-block redl"></label>
                                </div>
                            </div>
                            
                            
                    
                            
                            <div class="form-group" id="amount">
                                <label class="col-md-3 col-xs-12 control-label">Amount</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-9 row" style="padding-left: 0;">                                    
                                            <input type="number" step="any" min="0" class="form-control" name="amount" placeholder="" />
                                            <label id="amount_err" class="help-block redl"></label>
                                        </div>
                                        <div class="col-md-3 row" style="padding-right: 0;">
                                            <select name="currency" class="form-control select">
                                                 <option value="{{$event_currency}}">{{$event_currency}}</option>
                                                <option value="EGP">EGP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
                            <span><strong id="welcome">Conference Fees created successfully !</strong> </span>
                        </div>
                        <div id="alert" class="alert alert-danger" style="margin-top:1em; display:none;">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span></span>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default pull-right" id="create">Create<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel">
        <div class="panel-body">
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
<!-- END PAGE CONTENT WRAPPER -->
@endsection

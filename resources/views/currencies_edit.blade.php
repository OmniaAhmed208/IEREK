@extends('layouts.master') 

@section('content')

<?php $token = csrf_token(); ?>

<br>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>SID</th>
            <th>Currency Code</th>
            <th>Currency Name</th>
            <th>Currency Symbol</th>
            <th>Action</th>
            
        </tr>
    </thead>
    <tbody>                                
        
        <form action="currencies/save" method="post" class="col-md-6">
        <tr>
            <td>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="currency_sid" value="{{ $currency->currency_sid }}">
            </td>
            
            <td><input type="text" name="currency_code" class="form-control"  value="{{ $currency->currency_code }}"></td>
            <td><input type="text" name="currency_name" class="form-control"  value="{{ $currency->currency_name }}"></td>
            <td><input type="text" name="currency_symbol" class="form-control"  value="{{ $currency->currency_symbol }}"></td>

            <td><input type="submit" name="submit"  class="btn btn-success" value="Update Currency Data"></td>
        </tr>
        
        </form>
    </tbody>
</table>

@push('scripts')

    <script type="text/javascript">
        $(document).ready(function(){
            @if(Session::has('status'))
            informX("{{ Session::get('status') }}")
            @endif
        })
    </script>
             
@endpush
 
 
 
 


@endsection
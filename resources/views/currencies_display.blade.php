@extends('layouts.master') 

@section('content')

<?php $token = csrf_token(); ?>


<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Currency SID</th>
            <th>Currency Code</th>
            <th>Currency Name</th>
            <th>Currency Symbol</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>                                
        @foreach($currencies as $currency)
        
        	<form action="currencies/edit" method="post" class="col-md-6">    
	            <tr>
	                <td>
		                <input type="hidden" name="_token" value="{{ csrf_token() }}">
		                <input type="hidden" name="currency_sid" value="{{ $currency->currency_sid }}">{{ $currency->currency_sid }}
	                </td>
	                
                    <td><input type="hidden" name="currency_code" value="{{ $currency->currency_code }}">{{ $currency->currency_code }}</td>
	                <td><input type="hidden" name="currency_name" value="{{ $currency->currency_name }}">{{ $currency->currency_name }}</td>
                    <td><input type="hidden" name="currency_symbol" value="{{ $currency->currency_symbol }}">{{ $currency->currency_symbol }}</td>

	               	<td><input type="submit" name="Edit"  class="btn btn-success" value="Edit Currency"></td>
	               	<td><input type="submit" name="Delete"  class="btn btn-success" value="Delete Currency"></td>
	            </tr>
			</form>            
        @endforeach
        <form action="currencies/create" method="post" class="col-md-6">
        <tr>
        	<td>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="currency_sid" value="{{ $currency->currency_sid }}">
            </td>
            
            <td><input type="text" name="currency_code" class="form-control" placeholder="Enter Currency Code"></td>
            <td><input type="text" name="currency_name"  class="form-control" placeholder="Enter Currency Name"></td>
            <td><input type="text" name="currency_symbol"  class="form-control" placeholder="Enter Currency Symbol"></td>

            <td><input type="submit" name="submit"  class="btn btn-success" value="Add Currency"></td>
            <td></td>
        </tr>
        <tr>
        	<td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
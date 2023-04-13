@extends('layouts.master') 

@section('content')

<?php $token = csrf_token(); ?>

{{ $description}}
<br>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Birth Date</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>                                
        @foreach($staffs as $staff)
        
        	<form action="staffs/edit" method="post" class="col-md-6">    
	            <tr>
	                <td>
		                <input type="hidden" name="_token" value="{{ csrf_token() }}">
		                <input type="hidden" name="staff_id" value="{{ $staff->staff_id }}">{{ $staff->staff_id }}
	                </td>
	                <td><input type="hidden" name="name" value="{{ $staff->staff_name }}">{{ $staff->staff_name }}</td>
	                <td><input type="hidden" name="birth_date" value="{{ $staff->birth_date }}">{{ $staff->birth_date }}</td>
	               	<td><input type="submit" name="Edit"  class="btn btn-success" value="Edit Staff"></td>
	               	<td><input type="submit" name="Delete"  class="btn btn-success" value="Delete Staff"></td>
	            </tr>
			</form>            
        @endforeach
        <form action="staffs/create" method="post" class="col-md-6">
        <tr>
        	<td><input type="hidden" name="_token" value="{{ csrf_token() }}"></td>
            <td><input type="text" name="name" class="form-control" placeholder="Enter Staff's Name"></td>
            <td><input type="date" name="birthdate" class="form-control" placeholder="Enter Staff's Birth Date"></td>
            <td><input type="submit" name="submit"  class="btn btn-success" value="Add Staff"></td>
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
@extends('layouts.master') 

@section('content')

<?php $token = csrf_token(); ?>

<br>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Birth Date</th>
            <th>Action</th>
            
        </tr>
    </thead>
    <tbody>                                
        
        <form action="staffs/save" method="post" class="col-md-6">
        <tr>
        	<td>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="staff_id" value="{{ $staff->staff_id }}">
            </td>
            <td><input type="text" name="name" class="form-control"  value="{{ $staff->staff_name }}"></td>
            <td><input type="date" name="birthdate" class="form-control"  value="{{ $staff->birth_date }}"></td>
            <td><input type="submit" name="submit"  class="btn btn-success" value="Update Staff Data"></td>
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
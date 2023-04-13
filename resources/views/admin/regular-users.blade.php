@extends('admin.layouts.master')
@section('return-url'){{url('/admin')}}@endsection
@section('panel-title') Manage Users @endsection

@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-body">
                	<div class="col-md-3 pull-right">
                		<a href="/admin/all-users/create" class="btn btn-success btn-block"><span class="fa fa-plus"></span> Register New User</a>
                	    <br>
                    </div>
                    <table class="table table-hover table-striped" id="users_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Tel</th>
                                <th>Nationality</th>
                                <th>Registred</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">
<input type="hidden" name="users_url" id="users_url" value="{{url("admin/searchUsers")}}" placeholder="">
<input type="hidden" name="user_profile" id="user_profile" value="{{url('admin/all-users/profile')}}" placeholder="">

@endsection
@push('scripts')
<script type="text/javascript">
        $(document).ready(function(){
            var url =  $("#users_url").val();
            
        
               var userTable =  $("#users_table").DataTable({
                    "ordering": false,
                    "info": true, 
                    "searching": true,
                    "serverSide": true,
                    "paging" : true,
                    "pageLength" : 25,
                    "pagingType": "full_numbers",
                    "lengthChange": false,
                    "processing": true,
                    "ajax": {
                        url : $("#users_url").val(),
                        dataSrc : 'data'
                     },
                     columns: [
                        { 
                                data: 'title',
                                render : function (data, type, full, meta) {
                                 return '<img src="'+data.image+'" style="max-width:35px;border:1px #a97f18 solid;box-shadow: 0 2px 14px 0 rgba(0,0,0,0.1)">  ' + data.name;

                                 }
                          }
                        ,
                        { data: 'email' },
                        { data: 'phone' },
                        { data: 'country' },
                        { data: 'register_date' },
                        { 
                            data: "id",
                            render: function(data){
                                var editUrl =  $("#user_profile").val() + "/" + data;
                                return '<a class="btn btn-warning" href="'+editUrl+'">Edit</a>';
                           }
                        }
                    ]
                    });

        
           
    });

</script>
@endpush
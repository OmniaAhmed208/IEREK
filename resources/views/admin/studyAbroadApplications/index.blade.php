@extends('admin.layouts.master')
@section('panel-title')Manage Studyabroad Apllications
@endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-hover table-striped" id="studyAbroad_apps">
                        <thead>
                          
                            <tr>
                                <th>Event</th>
                                <th>Category</th>
                                <th>SURNAME</th>
                                <th>City</th>
                                <th>Date Of Birth</th>
                                <th>Actions</th>
                            </tr>
                          <tbody></tbody>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
       <input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">
       <input type="hidden" name="apps_url" id="apps_url" value="{{url("admin/studyAbroadApplications/search")}}" placeholder="">
       <input type="hidden" name="apps_details" id="apps_details" value="{{url('admin/studyAbroadApplications/show')}}" placeholder="">

</div>

     

 

@endsection

@push('scripts')
<script type="text/javascript">
        $(document).ready(function(){
            
           
         
        
               var hostConferenceTable =  $("#studyAbroad_apps").DataTable({
                    "ordering": false,
                    "info": true, 
                    "searching": true,
                    "serverSide": true,
                    "paging" : true,
                    "pageLength" : 20,
                    "pagingType": "full_numbers",
                    "lengthChange": false,
                    "processing": true,
                    "ajax": {
                        url : $("#apps_url").val(),
                        dataSrc : 'data'
                     },
                     columns: [
                        
                        { data: 'event_name' },
                        { data: 'category_name' },
                        { data: 'surname' },
                        { data: 'city' },
                        { data: 'date_of_birth' },
                       
                      
                            { 
                            data: 'app_id' ,
                            
                            render: function(data){
                                var res = data;
                                
                             var detailsUrl =  $("#apps_details").val() + "/" + res;
                               
    
  var details = '<a  href="'+detailsUrl+'">show</a>';
  return details;                 
                           }
                        }
                      
                    ]
                    });

        
           
    });

</script>


@endpush
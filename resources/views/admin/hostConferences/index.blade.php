@extends('admin.layouts.master')
@section('panel-title')Manage Invoices 
@endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-hover table-striped" id="host_conference">
                        <thead>
                          
                            <tr>
                                <th>University Name</th>
                                <th>Contact Name</th>
                                <th>Contact Email</th>
                                <th>Location</th>
                                <th>Budget</th>
                                <th>Date</th>
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
    <input type="hidden" name="hosts_url" id="hosts_url" value="{{url("admin/hostConference/search")}}" placeholder="">
    <input type="hidden" name="hosts_details" id="hosts_details" value="{{url('admin/hostConference/show')}}" placeholder="">
</div>

     

 

@endsection

@push('scripts')
<script type="text/javascript">
        $(document).ready(function(){
            
           
         
        
               var hostConferenceTable =  $("#host_conference").DataTable({
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
                        url : $("#hosts_url").val(),
                        dataSrc : 'data'
                     },
                     columns: [
                        
                        { data: 'host_university' },
                        { data: 'host_contact_name' },
                        { data: 'host_contact_email' },
                        { data: 'host_location' },
                        { data: 'host_budget' },
                        { data: 'created_at' },
                      
                            { 
                            data: 'host_id' ,
                            
                            render: function(data){
                                var res = data;
                                
                             var detailsUrl =  $("#hosts_details").val() + "/" + res;
                               
    
  var details = '<a  href="'+detailsUrl+'">show</a>';
  return details;                           
                           }
                        }
                      
                    ]
                    });

        
           
    });

</script>


@endpush
@extends('admin.layouts.master')
@section('panel-title')Manage Invoices 
@endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-body">
            	<div class="col-md-3 pull-right">
                		<a href="invoices/create" class="btn btn-success btn-block"><span class="fa fa-plus"></span>Add Invoice</a>
                	   
                    </div>
                    <table class="table table-hover table-striped" id="invoices_id">
                        <thead>
                          
                            <tr>
                                <th>Payment Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Event</th>
                                <th>Type</th>
                                <th>Total</th>
                                <th>Currency</th>
                                <th>Date</th>
                                <th>Status</th>
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
<input type="hidden" name="invoices_url" id="invoices_url" value="{{url("admin/searchInvoices")}}" placeholder="">
<input type="hidden" name="invoice_edit" id="invoice_edit" value="{{url('admin/invoices/edit')}}" placeholder="">
<input type="hidden" name="invoice_details" id="invoice_details" value="{{url('admin/invoices/show')}}" placeholder="">
    <input type="hidden" name="send_email" id="send_email" value="{{url('admin/send_email/')}}" placeholder="">

</div>

     

 

@endsection

@push('scripts')
<script type="text/javascript">
        $(document).ready(function(){
           // var url =  $("#users_url").val();
           var today = new Date(); 
           
           var dd = today.getDate();
           var mm = today.getMonth()+1; 
           var yyyy = today.getFullYear();
           
           today = yyyy+'-'+mm+'-'+dd;
           
           var dateOne = new Date(today); //Year, Month, Date
        
               var invoiceTable =  $("#invoices_id").DataTable({
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
                        url : $("#invoices_url").val(),
                        dataSrc : 'data'
                     },
                     columns: [
                        
                        { data: 'payment' },
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'event' },
                        { data: 'order_type' },
                        { data: 'amount' },
                        { data: 'currency' },
                        { data: 'date' },
                        { data: 'status'},

                        { 
                            data: 'id' ,
                            
                            render: function(data){
                                var res = data.split(".");
                                var editUrl =  $("#invoice_edit").val() + "/" + res[0];
                                var detailsUrl =  $("#invoice_details").val() + "/" + res[0];
                                var send_email =  $("#send_email").val() + "/" + res[0];

                                var decline="";
                                var approve="";
                                var edit="";
                                var dateTwo = new Date(res['3']); //Year, Month, Date
   if(res['2'] != '2' && dateTwo >= dateOne && res['2'] != 1)
   {
  var edit = '<a  href="'+editUrl+'"><i class="fa fa-pencil"  style="color:orange;font-size: 1.5em" aria-hidden="true"></i></a>';
   }
  if(res['1'] == "Approved" || res['1'] == "Pending" ){
   decline = '<a style="border:none;background: none;" onclick="decline('+res[0]+')"  id="decline_"'+res[0]+'"><i class="fa fa-times fa-6"  style="color:red;font-size: 1.5em" aria-hidden="true"></i></a>';
  }if(res['1'] == "Decline" || res['1'] == "Pending" ){
   approve = '<a onclick="approving('+res[0]+')"  id="approve_"'+res[0]+'"><i class="fa fa-check fa-6"  style="color:green;font-size: 1.5em" aria-hidden="true"></i></a>';
   

  }


  var details = '<a  href="'+detailsUrl+'"><i class="fa fa-usd fa-6" style="color:blue;font-size: 1.5em" aria-hidden="true"></i></a>';


  var send_email = '<a  href="'+send_email+'"><i class="fa fa-envelope" style="color:blue;font-size: 1.5em" aria-hidden="true"></i></a>';

  return edit+" "+decline+" "+approve+" "+details + " " +send_email;
                           }
                        }
                    ]
                    });

        
           
    });

</script>

<script>   
function approving(id) {

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
  
        $.ajax({
            url: '/admin/invoices/approveOrdecline',
            type: 'post',
            data: {
                order_id: id,
                status:"Approved"
            },
            success: function(data) {
                console.log("Success with data " + data);
                $('#invoices_id').DataTable().ajax.reload();
               
            },
            error: function(data) {
                console.log("Error with data " + data);
            }
        });
  
}
 </script>
 
<script>   
function decline(id) {

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
  
        $.ajax({
            url: '/admin/invoices/approveOrdecline',
            type: 'post',
            data: {
                order_id: id,
                status:"Decline"
            },
            success: function(data) {
                console.log("Success with data " + data);
               $('#invoices_id').DataTable().ajax.reload();
            },
            error: function(data) {
                console.log("Error with data " + data);
            }
        });
  
}
 </script>
@endpush
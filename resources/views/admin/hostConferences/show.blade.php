
@extends('admin.layouts.master')
@section('panel-title')Host Conference 
@endsection
@section('content')

<style>
    #invoiceDetails {
        table-layout: fixed;
    }
    #invoiceDetails td {
        word-wrap: break-word;    
    }
    .barcode-generator{
        text-align: center;
    }
    
    .fees-class{
        
        font-size: 14px;
    }
</style>
<div class="panel panel-default" id="view-profile">
		<div class="panel-heading">
			<h3 class="panel-title">Host Conference Details</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<div class="col-md-4">
					
				</div>
				
				<div class="col-md-8">
                                    <table class="table" id="invoiceDetails">
						<tbody>
							<tr>
								<td style="border:none;"></td>
								<td style="border:none;"></td>
							</tr>
							<tr>
								<td style="width:35%;">University name</td>
								<td>{{$data['host_university']}}</td>
							</tr>
                                                        
                                                        <tr>
								<td style="width:35%;">Contact person name</td>
								<td>{{$data['host_contact_name']}}</td>
							</tr>
						
							<tr>
								<td style="width:35%;">Contact person email</td>
								<td>{{$data['host_contact_email']}}</td>
							</tr>
                                                      
                                                            <tr>
                                                                    <td style="width:35%;">Contact person affiliation</td>
                                                                    <td>{{$data['host_contact_affliation']}}</td>
                                                            </tr>
                                                    
                                                        
                                                        <tr>
								<td style="width:35%;">Conference facilities overview and capacity</td>
								<td>{{$data['host_conference_overview']}}</td>
							</tr>
                                                     
                                                        <tr>
								<td style="width:35%;">Residential hall overview and on/off campus accommodations capacity </td>
								<td>{{$data['host_residential_overview']}}</td>
							</tr>
                                 
                                                               <tr>
								<td style="width:35%;">Catering, meals, and reception </td>
								<td>{{$data['host_catering']}}</td>
							</tr>
                                                        
                                                               <tr>
								<td style="width:35%;">Location</td>
								<td>{{$data['host_location']}}</td>
							</tr>
                                                       
                                                        
                                                         <tr>
								<td style="width:35%;"> Pre-conference programming </td>
								<td>{{$data['host_conference_program']}}</td>
							</tr>
                                                        
                                                           <tr>
								<td style="width:35%;">Budget (pre and post-conference) </td>
								<td>{{$data['host_budget']}}</td>
							</tr>
                                                        
                                               
						</tbody>
					</table>
                                
                                 
                                 
                     </div>
                            
                            
			</div>
		</div>
	</div>
@endsection
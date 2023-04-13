
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
								<td style="width:35%;">Event</td>
								<td>{{$data['title_en']}}</td>
							</tr>
                                                        
                                                         <tr>
								<td style="width:35%;">Category</td>
								<td>{{$data['title']}}</td>
							</tr>
                                                        
                                                        
							<tr>
								<td style="width:35%;">The undersigned (FORENAME, SURNAME) </td>
								<td>{{$data['app_undersigned_name']}}</td>
							</tr>
                                                        
                                                        <tr>
								<td style="width:35%;">Date of birth </td>
								<td>{{$data['app_date_birth_day']}}</td>
							</tr>
						
							<tr>
								<td style="width:35%;">City</td>
								<td>{{$data['app_city']}}</td>
							</tr>
                                                      
                                                            <tr>
                                                                    <td style="width:35%;">State</td>
                                                                    <td>{{$data['app_state']}}</td>
                                                            </tr>
                                                    
                                                        
                                                        <tr>
								<td style="width:35%;">State of residence</td>
								<td>{{$data['app_state_of_residence']}}</td>
							</tr>
                                                     
                                                        <tr>
								<td style="width:35%;">Residential hall overview and on/off campus accommodations capacity </td>
								<td>{{$data['app_permanent_address']}}</td>
							</tr>
                                 
                                                               <tr>
								<td style="width:35%;">Permanent address</td>
								<td>{{$data['app_permanent_address']}}</td>
							</tr>
                                                        
                                                               <tr>
								<td style="width:35%;">E-mail</td>
								<td>{{$data['app_email']}}</td>
							</tr>
                                                       
                                                        
                                                         <tr>
								<td style="width:35%;"> Signature </td>
								<td>{{$data['app_signature']}}</td>
							</tr>
                                                        
                                                         <tr>
								<td style="width:35%;"> Date </td>
								<td>{{$data['created_at']}}</td>
							</tr>
                                                          
                                                        
                                               
						</tbody>
					</table>
                                
                                 
                                 
                     </div>
                            
                            
			</div>
		</div>
	</div>
@endsection
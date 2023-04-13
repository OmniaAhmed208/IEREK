
@extends('admin.layouts.master')
@section('panel-title')Sponsor
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
			<h3 class="panel-title">Sponsor Data</h3>
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
								<td style="width:35%;">Name</td>
								<td>{{$eventSponsor['sponsor_title'].'/ '.$eventSponsor['sponsor_name']}}</td>
							</tr>
                                                        
                                                        <tr>
								<td style="width:35%;">Organization</td>
								<td>{{$eventSponsor['sponsor_organization']}}</td>
							</tr>
                                                        
                                                         <tr>
								<td style="width:35%;">Department</td>
								<td>{{$eventSponsor['sponsor_department']}}</td>
							</tr>
                                                        
                                                         <tr>
								<td style="width:35%;">Website</td>
								<td>{{$eventSponsor['sponsor_website']}}</td>
							</tr>
                                                        
                                                         <tr>
								<td style="width:35%;">Country</td>
								<td>{{$eventSponsor['sponsor_country']}}</td>
							</tr>
                                                        
                                                        <tr>
								<td style="width:35%;">City</td>
								<td>{{$eventSponsor['sponsor_city']}}</td>
							</tr>
                                                        
                                                        <tr>
								<td style="width:35%;">Street</td>
								<td>{{$eventSponsor['sponsor_street']}}</td>
							</tr>
                                                        
                                                        <tr>
								<td style="width:35%;">postal code</td>
								<td>{{$eventSponsor['sponsor_code']}}</td>
							</tr>
                                                       
                                                        <tr>
								<td style="width:35%;">fax</td>
								<td>{{$eventSponsor['sponsor_fax']}}</td>
							</tr>
                                                        
                                                        <tr>
								<td style="width:35%;">phone</td>
								<td>{{$eventSponsor['sponsor_phone']}}</td>
							</tr>
                                                        
                                                        <tr>
								<td style="width:35%;">Mobile</td>
								<td>{{$eventSponsor['sponsor_mobile']}}</td>
							</tr>
                                                        
                                                        <tr>
								<td style="width:35%;">Email</td>
								<td>{{$eventSponsor['sponsor_email']}}</td>
							</tr>
                                                        
                                                         <tr>
								<td style="width:35%;">Package</td>
								<td>{{$eventSponsor['sponsor_package']}}</td>
							</tr>
                                               
                                                         <tr>
								<td style="width:35%;">Signature</td>
								<td>{{$eventSponsor['sponsor_signature']}}</td>
							</tr>
						</tbody>
					</table>
                                
                                 
                                 
                     </div>
                            
                            
			</div>
		</div>
	</div>
@endsection
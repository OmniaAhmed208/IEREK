
@extends('admin.layouts.master')
@section('panel-title')Invoice 
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
			<h3 class="panel-title">Invoice Details</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<div class="col-md-4">
					<center>
					<img src="/uploads/default_avatar_female.jpg" style="max-width:200px;border:1px #a97f18 solid;box-shadow: 0 2px 14px 0 rgba(0,0,0,0.1)">
					</center>
				</div>
				
				<div class="col-md-8">
                                    <table class="table" id="invoiceDetails">
						<tbody>
							<tr>
								<td style="border:none;"></td>
								<td style="border:none;"></td>
							</tr>
							<tr>
								<td style="width:35%;">User Email</td>
								<td>{{$userEmail}}</td>
							</tr>
                                                        
                                                        <tr>
								<td style="width:35%;">User Type</td>
								<td>{{$userType}}</td>
							</tr>
						
							<tr>
								<td style="width:35%;">Event</td>
								<td>{{$eventTitle}}</td>
							</tr>
                                                        @if($payment_id != NULL)
                                                            <tr>
                                                                    <td style="width:35%;">Payment Id</td>
                                                                    <td>{{$payment_id}}</td>
                                                            </tr>
                                                        @endif
                                                        
                                                        <tr>
								<td style="width:35%;">Currency</td>
								<td>{{$currencymov}}</td>
							</tr>
                                                     
                                                        <tr>
								<td style="width:35%;">Inovice perioud</td>
								<td>{{$invoicePerioud}}</td>
							</tr>
                                 
                                 @if($promoCode != NULL)
                                                        <tr>
								<td style="width:35%;">Promo Code</td>
								<td>{{$promoCode}}</td>
							</tr>
                                 @endif                      
						</tbody>
					</table>
                                 @php
                                   $totalAmount = 0;
                                 @endphp
                                 
                                 
                                       <table class="table" id="invoiceDetails">
                                          
                                                <tr style="width:35%;">
                                                    <th colspan="2" class='fees-class'>Attendence</th>
                                                </tr>
                                            @foreach ($fees as $order)
                                              @if($order->fees_category_id == 1)
                                                <tr>
                                                    <td>{{$order->title_en}}</td>
                                                    <td>{{$order->amount}}</td>
                                                        @php
                                                            $totalAmount += $order->amount;
                                                        @endphp
                                                </tr>
                                          
                                           @endif
                                               @endforeach
                                               
                                           
                                                <tr style="width:35%;">
                                                    <th colspan="2" class='fees-class'>Accomadation</th>
                                                </tr>
                                           @foreach ($fees as $order)
                                              @if($order->fees_category_id == 2)
                                                <tr>
                                                    <td>{{$order->title_en}}</td>
                                                    <td>{{$order->amount}}</td>
                                                        @php
                                                            $totalAmount += $order->amount;
                                                        @endphp
                                            
                                                </tr>
                                          
                                           @endif
                                               @endforeach
                                               
                                           
                                                <tr style="width:35%;">
                                                    <th colspan="2" class='fees-class'>Visa</th>
                                                </tr>
                                           @foreach ($fees as $order)
                                              @if($order->fees_category_id == 3)
                                                <tr>
                                                    <td>{{$order->title_en}}</td>
                                                    <td>{{$order->amount}}</td>
                                                        @php
                                                            $totalAmount += $order->amount;
                                                        @endphp
                                            
                                                </tr>
                                          
                                           @endif
                                               @endforeach
                                               
                                          
                                                <tr style="width:35%;">
                                                    <th colspan="2" class='fees-class'>Paper</th>
                                                </tr>
                                           @foreach ($fees as $order)
                                              @if($order->fees_category_id == 5)
                                                <tr>
                                                    <td>{{$order->title_en}}</td>
                                                    <td>{{$order->amount}}</td>
                                                        @php
                                                            $totalAmount += $order->amount;
                                                        @endphp
                                            
                                                </tr>
                                          
                                           @endif
                                               @endforeach
                                               
                                              @foreach ($fees as $order)
                                              @if($order->fees_category_id == 6)
                                                <tr style="width:35%;">
                                                    <th colspan="2" class='fees-class'>Custom</th>
                                                </tr>
                                           
                                                <tr>
                                                    <td>{{$order->title_en}}</td>
                                                    <td>{{$order->amount}}</td>
                                                        @php
                                                            $totalAmount += $order->amount;
                                                        @endphp
                                            
                                                </tr>
                                          
                                           @endif
                                               @endforeach
                                               
                                               <tr style="width:35%;">
                                               <th colspan="2" class='fees-class'>Total Money</th>
                                         </tr>
                                          
                                         <tr>
                                             <td>total</td>
                                             <td>
                                               @if($totalAmount != 0)
                                                 {{$totalAmount}}
                                               @else
                                                 {{$amount}}
                                               @endif
                                             </td>
                                         </tr>
                                         @if($discount != NULL)
                                          <tr>
                                             <td>Discount</td>
                                             <td>{{$discount}}</td>
                                         </tr>
                                         
                                          <tr>
                                             <td>Total After Discount </td>
                                             <td>{{$totalAmount - $discount}}</td>
                                         </tr>
                                         @endif 
                                    </table>
             <div class='barcode-generator'>
                                <img src="data:image/png;base64,{{$barcode}}" />
                            </div>
				</div>
                            
                            
				<div class="col-md-12" style="display:none">
					<div class="col-md-3 pull-right">
						<a class="btn btn-success pull-right" id="edit">Edit Profile</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
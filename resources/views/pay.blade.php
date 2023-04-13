@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="panel">
			<div class="panel-body">
				<form id="myCCForm" action="/pay" method="post">
				  <input type="hidden" name="_token" value="{{ csrf_token() }}">
				  <input name="token" type="hidden" value="" />
				  <div>
				    <label>
				      <span>Card Number</span>
				      <input id="ccNo" type="text" value="" autocomplete="off" required />
				    </label>
				  </div>
				  <div>
				    <label>
				      <span>Expiration Date (MM/YYYY)</span>
				      <input id="expMonth" type="text" size="2" required />
				    </label>
				    <span> / </span>
				    <input id="expYear" type="text" size="4" required />
				  </div>
				  <div>
				    <label>
				      <span>CVC</span>
				      <input id="cvv" type="text" value="" autocomplete="off" required />
				    </label>
				  </div>
				  <input type="submit" value="Submit Payment" />
				</form>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
<script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<script type="text/javascript">

  // Called when token created successfully.
  var successCallback = function(data) {
    var myForm = document.getElementById('myCCForm');

    // Set the token as the value for the token input
    myForm.token.value = data.response.token.token;

    // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
    // myForm.submit();
  	makePayment();
  };

  // Called when token creation fails.
  var errorCallback = function(data) {
    if (data.errorCode === 200) {
      // This error code indicates that the ajax call failed. We recommend that you retry the token request.
    } else {
      informX(data.errorMsg);
    }
  };

  var tokenRequest = function() {
    // Setup token request arguments
    var args = {
      sellerId: "102563668",
      publishableKey: "34AAFD4C-0977-470C-B0CB-61611C1164BE",
      ccNo: $("#ccNo").val(),
      cvv: $("#cvv").val(),
      expMonth: $("#expMonth").val(),
      expYear: $("#expYear").val()
    };

    // Make the token request
    TCO.requestToken(successCallback, errorCallback, args);
  };

  $(function() {
    // Pull in the public encryption key for our environment
    TCO.loadPubKey('production');

    $("#myCCForm").submit(function(e) {
      // Call our token request function
      tokenRequest();

      // Prevent form from submitting
      return false;
    });
  });

  function makePayment()
  {
  	var myForm = document.getElementById('myCCForm');
  	var formData = new FormData(myForm);
  	$.ajax({
        type: 'POST',
        url: '/pay',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
            beforeSend: function(xhr) {

            },
            success: function (response) {
                //check if response with success : true/false
                console.log(response);
            },
            error: function (response) {
               console.log(response);
            }
        });
  }
</script>
@endpush
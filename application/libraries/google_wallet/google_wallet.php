<?php
include_once "lib/JWT.php";
include_once "payload.php";

class google_wallet
{
	function payNow($data_arr="")
	{
		$this->_ci =& get_instance();
		$this->_ci->load->config('google_wallet');
		
		$sellerIdentifier = $this->_ci->config->item('issuerId');
		$sellerSecretKey = $this->_ci->config->item('secretKey');
		$currencyCode = $this->_ci->config->item('currencyCode');
	
		$payload = new Payload();
		$payload->SetIssuedAt(time());
		$payload->SetExpiration(time()+3600);
		
		if(count($data_arr))
		{
			foreach($data_arr as $data_key=>$data_val)
			{
				$payload->AddProperty($data_key, $data_val);
			}
		}
		
		$payload->AddProperty("currencyCode", $currencyCode);
		
		// Creating payload of the product.
		$Token = $payload->CreatePayload($sellerIdentifier);
		
		// Encoding payload into JWT format.
		$jwtToken = JWT::encode($Token, $sellerSecretKey);
		
		?>
		<script src="https://sandbox.google.com/checkout/inapp/lib/buy.js"></script>
        <script type='text/javascript'>
		function DemoButton(jwt_value)
		{
			runDemoButton = document.getElementById('runDemoButton');
			google.payments.inapp.buy({
				jwt: jwt_value,
				success: function(result)
				{
					alert('Success');
				},
				
				failure: function(result)
				{
					//console.log(result.response.errorType);
					alert('Failure');
				}
			});
			return false;
		}
        </script>
        <?php
		$btn = '<button id="runDemoButton" value="buy" class="buy-button" onclick="DemoButton(\''.$jwtToken.'\')"><b>Pay Now</b></button><span id="res_status"></span>';
		return $btn;
	}
}
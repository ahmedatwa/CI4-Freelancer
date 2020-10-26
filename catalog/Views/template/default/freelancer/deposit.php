<?php echo $header; ?> 
<div class="jumbotron">
	<div class="container-fluid">
		<h2 class="display-5"><?php echo $heading_title; ?></h2>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-12">

		</div>
	</div>
	<!-- Content
================================================== -->
<!-- Container -->
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-8">
			
		
			<!-- Hedline -->
			<h3 class="">Payment Method</h3>

			<!-- Payment Methods Accordion -->
			<div class="payment margin-top-30">

				<div class="payment-tab payment-tab-active">
					<div class="payment-tab-trigger">
						<input checked id="paypal" name="cardType" type="radio" value="paypal">
						<label for="paypal">PayPal</label>
						<img class="payment-logo paypal" src="https://i.imgur.com/ApBxkXU.png" alt="">
					</div>

					<div class="payment-tab-content">
						<p>  <div id="paypal-button-container"></div></p>
					</div>
				</div>


<!-- 				<div class="payment-tab">
					<div class="payment-tab-trigger">
						<input type="radio" name="cardType" id="creditCart" value="creditCard">
						<label for="creditCart">Credit / Debit Card</label>
						<img class="payment-logo" src="https://i.imgur.com/IHEKLgm.png" alt="">
					</div>

					<div class="payment-tab-content">
						<div class="row payment-form-row">

							<div class="col-md-6">
								<div class="card-label">
									<input id="nameOnCard" name="nameOnCard" required type="text" placeholder="Cardholder Name">
								</div>
							</div>

							<div class="col-md-6">
								<div class="card-label">
									<input id="cardNumber" name="cardNumber" placeholder="Credit Card Number" required type="text">
								</div>
							</div>

							<div class="col-md-4">
								<div class="card-label">
									<input id="expiryDate" placeholder="Expiry Month" required type="text">
								</div>
							</div>

							<div class="col-md-4">
								<div class="card-label">
									<label for="expiryDate">Expiry Year</label>
									<input id="expirynDate" placeholder="Expiry Year" required type="text">
								</div>
							</div>

							<div class="col-md-4">
								<div class="card-label">
									<input id="cvv" required type="text" placeholder="CVV">
								</div>
							</div>

						</div>
					</div>
				</div> -->

			</div>
			<!-- Payment Methods Accordion / End -->
		
<!-- 			<a href="pages-order-confirmation.html" class="button big ripple-effect margin-top-40 margin-bottom-65">Proceed Payment</a>
 -->		</div>
		<!-- Summary -->
		<div class="col margin-top-60">
			<!-- Summary -->
			<div class="boxed-widget summary margin-top-0">
				<div class="boxed-widget-headline" id="payment-summery">
					<h3>Summary</h3>
					<input type="hidden" id="csrf" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<input type="hidden" name="amount">
					<input type="hidden" name="status">
				</div>
				<div class="boxed-widget-inner">
					<ul>
						<li>
							<div class="form-group row">
								<label for="amount" class="col-sm-6 col-form-label"><?php echo $entry_amount; ?></label>
								<div class="col-sm-6">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1"><?php echo $currency; ?></span>
										</div>
										<input type="number" value="20" class="form-control" id="input-amount">
									</div>
								</div>
							</div>
						</li>
						<li><?php echo $text_fee; ?><span id="processing_fee"><?php echo $processing_fee; ?></span></li>
						<li class="total-costs"><?php echo $text_total; ?> <span id="total">22.3</span></li>
					</ul>
				</div>
			</div>
			<!-- Summary / End -->

		</div>

	</div>
</div>
<!-- Container / End -->


</div>
<div class="margin-bottom-30"></div>
<script type="text/javascript">
$('#input-amount').on('input', function(){
	var amount = $(this).val();
	var fee = $('#processing_fee').text();
   $('#total').text(parseInt(amount) + parseFloat(fee));
});
</script>

<script src="https://www.paypal.com/sdk/js?client-id=AQsYMy9yvvuJQgYo5ZWjdHbtCoA-9fBjezG3Kuwi3RQy0WutI14gCAnS9Y74MneOOIBeqbfvav9uVOcn&currency=EUR" data-namespace="paypal_sdk"></script>
 <script>
  paypal_sdk.Buttons({
    createOrder: function(data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: $('#total').text()
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {
      	var csrf_name = 'CSRFCAT';
      	var csrf_token = $('#csrf').val();
        // This function shows a transaction success message to your buyer.
        $.ajax({
        	url: 'freelancer/deposit/addFunds?customer_id=<?php echo $customer_id; ?>',
        	method: 'post',
        	dataType: 'json',
        	data: {amount: details.purchase_units[0].amount.value, currency: details.purchase_units[0].amount.currency_code, status:details.status, 'CSRFCAT': csrf_token},
        	success: function(json) {
        		if (json['success']) {
        			$.notify({
        				icon: 'fas fa-check-circle',
						title: 'Success:',
						message: json['success'],
						type: 'success'
					});

        		}
        	}

        });
        //alert('Transaction completed by ' + details.payer.name.given_name);
      });
    }
  }).render('#paypal-button-container');
  //This function displays Smart Payment Buttons on your web page.
</script>


<?php echo $footer; ?>

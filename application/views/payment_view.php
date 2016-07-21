<!DOCTYPE html>
<html>

<head>
<title>Stripe</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSS -->
<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>" />

<!-- Javascript Jquery Boostrap loader-->
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>

<!-- API stripe loader -->
<script src="https://checkout.stripe.com/checkout.js"></script>
</head>

<body>
<!-- Contact Section -->
<section id="contact">
  <div class="container title-box text-center">
      <i><h1>PAYMENT GATEWAY</h1></i>
    <div class="row">
      <div class="col-xs-12 text-center">
        <h2 class="section-heading">Alpacode's payment gateway</h2>
        <b><p>Help us keep track of our product and its status</p>
        <p>Use this space to let us know anything</p></b>
        <br />
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <form name="sentMessage" id="contactForm" novalidate="" method="post" action="/index.php/contact">
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">Your Invoice Number(#):</div>
                  <input type="text" class="form-control"
                         name="invoice"
                         placeholder=""
                         id="invoice" required=""
                         data-validation-required-message="The field Invoice must be filled">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">Your Name:</div>
                  <input type="text" class="form-control"
                         name="name"
                         placeholder=""
                         id="name" required=""
                         data-validation-required-message="The field Name must be filled">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">Your Email:</div>
                  <input type="text" class="form-control"
                         name="email"
                         placeholder=""
                         id="email" required=""
                         data-validation-required-message="The field Email must be filled">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">Your Phone Number:</div>
                  <input type="text" class="form-control"
                         name="phone"
                         placeholder=""
                         id="phone" required=""
                         data-validation-required-message="The field Phone number must be filled">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
            </div>
              <div class="form-group">
                <textarea class="form-control"
                          placeholder="Your Message Goes Here"
                         name="message"
                          id="message" required=""
                          data-validation-required-message="The field Phone number must be filled"></textarea>
                <p class="help-block text-danger"></p>
              </div>
            <div class="clearfix"></div>
            <div class="col-xs-12">
              <div id="success"></div>
              <button type="submit" class="btn btn-xl btn-success"> Send </button>               
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<div class="clear"></div>

<!-- This laods the composer autoload -->
<?php require('vendor/autoload.php'); ?>

<!--This form uses a variable ammount to pay --> 
<section id="stripe">
  <div class="container">
    <div class="row">
      <div class="title-box text-center col-xs-12">
          <p>Use this space to pay your bill, choose your own value </p></b>
        <div class="col-xs-12 text-center"> 
        	<form id="stripeForm" action="/index.php/payment/pay" method="POST" class="form-inline">
            <div class="form-group">
              <label class="sr-only">Amount</label>
              <div class="input-group">
                <div class="input-group-addon">$ CAD</div>
                <input class="form-control" type="text" id="amount" name="amount" placeholder="Enter Amount Here">
                <div class="input-group-addon">.00</div>
                <input type="hidden" id="stripeToken" name="stripeToken"/>
                <input type="hidden" id="stripeEmail" name="stripeEmail"/>
              </div>
            </div>   
            <input class="btn btn-success btn-xl" type="button" id="customButton" value="Make Payment" />
        	</form>
        </div> 
      </div> 
    </div>  
  </div>  
  <br />
</section>

<div class="clear"></div>

<!-- This is the handler Js code to the form using Stripe -->
<script>
  $('#stripeForm').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
  });

	var handler = StripeCheckout.configure({
    key: 'pk_test_',
    token: function(token) {
        $("#stripeToken").val(token.id);
        $("#stripeEmail").val(token.email);
        $("#stripeForm").submit();
    }
  });

  $('#customButton').on('click', function(e) {
    $('#error_explanation').html('');  

    // this is going to pass a float instaed of a string to the controller(is thius really working???)
    var amount = $("input#amount").val();
    amount = amount.replace(/$/g, '').replace(/,/g, '')
    amount = parseFloat(amount);

    if (isNaN(amount)) {
      $('#error_explanation').html('<p>Plaease enter a valid ammount</p>');
    }
    else {
      amount = amount * 100;
      // Open Checkout modal with further options
      handler.open({
        image: 'https://pbs.twimg.com/profile_images/269279233/llama270977_smiling_llama_400x400.jpg', 
        name: 'Alpacode Payments',
        description: 'Transfer for services provided',
        amount: Math.round(amount)
      })
    }  
    e.preventDefault();
  });

	  // Close Checkout on page navigation
  $(window).on('popstate', function() {
    handler.close();
  });

</script>
</body>
</html>


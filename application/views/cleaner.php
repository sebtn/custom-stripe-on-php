<!DOCTYPE html>
<html>

<head>
<title>Stripe</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSS -->
<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>" >

<!-- Javascript loader-->
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>

<!-- API stripe loader -->
<script src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">Stripe.setPublishableKey('pk_test_');</script>
</head>

<body>

<?php if(validation_errors()): ?>
  <?php echo validation_errors('<div class="alert alert-danger"><a class="close" data-dismiss="alert">x</a><strong>', '</strong></div>'); ?>
<?php endif; ?> 

<!-- Contact form -->
  <div class="contact-form"> 
   <h1>Payment Form</h1>
   <p>Please fill all spaces</p>
    <form name="sentMessage" id="contactForm" novalidate="" method="post" action="/index.php/contact" data-toggle="validator">
      <div class="col-xs-12">
        <div class="form-group">
          <label class="control-label" for="invoice">Invoice#:</label> 
          <div class="input-group">
            <input type="text" class="form-control required input"
                   name="invoice" size="55"
                   placeholder="Invoice number"
                   id="invoice" 
                   required
                   data-validation-required-message="The field Invoice must be filled">
            <p class="help-block text-danger" id="invoice-message"></p>
          </div>
        </div>
        <div class="form-group">
        <label class="control-label" for="name">Name:</label> 
          <div class="input-group">
            <input type="text" class="form-control required input"
                   name="name" size="55"
                   placeholder="Your Name"
                   id="name" 
                   required
                   data-validation-required-message="The field Name must be filled">
            <p class="help-block text-danger" id="name-message"></p>
          </div>
        </div>
        <div class="form-group">
        <label class="control-label" for="email">Email:</label> 
          <div class="input-group">
            <input type="text" class="form-control required input"
                   name="email" size="55"
                   placeholder="Your Email"
                   id="email" 
                   required
                   data-validation-required-message="The field Email must be filled">
            <p class="help-block text-danger" id="email-message"></p>
          </div>
        </div>
        <div class="form-group">
        <label class="control-label" for="phone">Tel.#:</label> 
          <div class="input-group">
            <input type="text" class="form-control required input"
                   name="phone" size="55"
                   placeholder="Your cell Number"
                   id="phone" 
                   required
                   data-validation-matches-match="phone"
                   data-validation-required-message="The field Phone number must be filled">
            <p class="help-block text-danger" id="phone-message"></p>
          </div>
        </div>
      </div>
      <br />
        <div class="form-group">
        <label class="control-label" for="message">Message:</label>
          <textarea class="form-control" type="text"
                    placeholder="Your Message Goes Here"
                    name="message" size=""
                    id="message" 
                    data-validation-matches-match="message">
          </textarea>
          <p class="help-block text-danger" id="message-message"></p>
        </div>
      <div class="clearfix"></div>
      <div class="col-xs-12">
        <div id="success"></div>
      </div>
    </form>
  </div>

  <div class="clear"></div>

<!-- Credit card payment box -->
  <div class='card-box two-box'>
    <form accept-charset="UTF-8" action="/index.php/payment/pay" class="require-validation" id="payment-form" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="✓" /><input name="_method" type="hidden" value="PUT" /></div>
      <div class="form-group">
        <label class="control-label"> 
          <span>Amount</span>
        </label>
        <div class="input-group">
          <div class="input-group-addon">$</div>
          <input class="form-control" type="text" id="amount" name="amount" placeholder="Enter Amount Here">
          <div class="input-group-addon">CAD</div>
        </div>
      </div>
      <div class='form-row'>
        <div class='col-xs-12 form-group card required'>
          <label class='control-label'>
          <span>Card Number</span>
          </label>
          <div class="input-group">
            <div class="input-group-addon">#</div>
            <input autocomplete='off' class='form-control card-number' size='20' type='text' data-stripe="number" name='number'>
          </div>
        </div>
      </div>
      <div class='form-row'>
        <div class='col-xs-4 form-group cvc required'>
          <label class='control-label'>CVC </label>
          <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' data-stripe="cvc" name='cvc'>
        </div>
        <div class='col-xs-4 form-group expiration required'>
          <label class='control-label'>Month</label>
          <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' data-stripe="exp_month" name='month'>
        </div>
        <div class='col-xs-4 form-group expiration required'>
          <label class='control-label'>Year</label>
          <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' data-stripe="exp_year" name='year'>
        </div>
      </div>
      <div class='form-row'>
        <div class='col-md-12 form-group'>
          <br />
          <button class='form-control btn btn-primary submit-button' type='submit' value="submit-payment" id="customButton">Make payment</button>
        </div>
      </div>
    </form>
  </div>
  <div class="row" id="footer"><p>© Copyright </p></div>

<script>
  function stripeResponseHandler(status, response) {
    // Grab the form payment:
    var $form = $('#payment-form');

    if (response.error) { // Problem!

      // Show the errors on the form:
      $form.find('.payment-errors').text(response.error.message);
      $form.find('.submit').prop('disabled', false); // Re-enable submission

    } else { // Token was created!

      // Get the token ID:
      var token = response.id;

      // Insert the token ID into the form so it gets submitted to the server:
      $form.append($('<input type="hidden" name="stripeToken">').val(token));

      // Submit the form:
      $form.get(0).submit();
    }
  };

  $(".alert-danger").fadeOut(4500);

  /*
   This executes ajax submission on the contact form as is requested 
   by the click on on the make payment button  
  */ 
  $("#customButton").on('click', function() 
  {
    $('#contactForm')[0].submit(function(event)
    {
      var isFormValid = true;

      $(".required input").each(function(){
        if ($.trim($(this).val()).length == 0){
            $(this).addClass("highlight");
            isFormValid = false;
        }else{
          $(this).removeClass("highlight");
        }
      });

      if {
        (!isFormValid) alert("Please fill in all the required fields (indicated by *)");
      }else{
        {
          var formData = 
          {
            'invoice'   :$('input[name=invoice]').val(),
            'name'      :$('input[name=name]').val(),
            'email'     :$('input[name=email]').val(),
            'phone'     :$('input[name=phone]').val(),
            'message'   :$('input[name=message]').val(),
          };
          //return formData;
          //if (formData != 'null' && formData != '') 
          //if('invoice' || 'name' ||  'email' == '' ) 
          $.ajax(
          {
            type     : 'POST',
            url      : base.url + '/index.php/contact',
            data     : formData,
            dataType : 'json',
            encode   : true
          })
        });
      }
      return isFormValid;
   })  
  });

  $(function() 
  {
    var $form = $('#payment-form');
    $form.submit(function(event) 
    {
      // Disable the submit button to prevent repeated clicks:
      $form.find('.submit').prop('disabled', true);
      // Request a token from Stripe:
      Stripe.card.createToken($form, stripeResponseHandler);
      // Prevent the form from being submitted several times:
      return false;
    });
  })

  $('form.require-validation').bind('submit', function(e) 
  {
    var $form         = $(e.target).closest('form'),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;

    $errorMessage.addClass('hide');
    $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault(); // cancel on first error
      }
    });  
  });
  
</script>
</body>
</html>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function index()
	{
        $this->load->view('custom_stripe');
	}

    public function pay()
    {
        $this->config->load('stripe', true);
        $this->load->library('session');

        //creates a token from the stripe form.
        $token  = $this->input->post('stripeToken');

        // The amount is set to be whatever the client wants.
        $amount = floatval($this->input->post('amount') * 100);

        //composer loads the functionality needed.
        require('vendor/autoload.php');

        //stripe is generating a key.
        // \Stripe\Stripe::setApiKey("");
        \Stripe\Stripe::setApiKey($this->config->$config['key']);

        // The customer object is created as an array
        $customer = \Stripe\Customer::create(array(
            'email' => $this->input->post('stripeEmail'),
            'source'  => $token
        ));

        // The object charge includes this array.
        $charge_array = array(
            'customer' => $customer->id,
            'amount'   => $amount,
            'currency' => 'cad',
            'description' => 'Example charge'
        );

        // Stripe creates the object charge.
        $charge = \Stripe\Charge::create($charge_array);

        
        echo '<h1>Thank you for your payment, please check you email!</h1>';

        // loads the model to send an email to the client.
        $this->load->model("EmailProvider", "emailprovider");

      /* The object charge and its proerties will be sent to the emal provider model
          then will be picked up by a view rendering the email.
          The name tag in the form will become an index while using checkout but when using 
          custom form it's not necessary to assing names to the input in the form.
      */    
        $email_customer = array(
            'email'  => $customer['email'],
        );      

        $email_charge = array(
            'brand'  => $charge['source']['brand'],
            'amount' => ($charge['amount'] / 100),
        );

        // this line uses the emailprovider model to send mails passin email charge and 
        // email customer as parameters, both are arrays extracted from stripe objects.
        $this->emailprovider->send_email($email_customer, $email_charge); 
 
  }

}


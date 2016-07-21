<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EmailProvider extends CI_Model {

  function __construct () 
  {
    $this->load->library('email');
  }

  // A way of creating parse message method to be able to send emails
  // using customer and charge objects.
  public function parse_message ($customer, $charge) 
  {
    $data = array(
      "charge"   => $charge,
      "customer" => $customer
      ); 

    //Special way to return a view, allows outgoing email formmating.  
    return $this->load->view("emails/confirmation", $data, TRUE);
  }
  // Sends mail parsing the content in the stripe object.
  public function send_email ($customer, $charge) 
  {
    $this->email->from('sebscodex@gmail.com', 'sebscodex@gmail.com');
    $this->email->to('sebscodex@gmail.com');
    $this->email->subject('Thank you for yor payment to Alpacode');
    $message = $this->parse_message($customer, $charge);
    $this->email->message($message);

    $result = $this->email->send();
  }

}
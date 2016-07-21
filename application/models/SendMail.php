<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SendMail extends CI_Model {

  function __construct () 
  {
    $this->load->library('email');
  }

  // A way of creating parse message method to be able to send emails
  // using the object postdata, extracted form.
  public function parse_message ( $postdata ) 
  {
      $data = array( 
        "postdata" => $postdata
      ); 

    //Special way to return a view, allows outgoing email formmating.  
    return $this->load->view("emails/confirmation_alpa", $data, TRUE);
  }

  //Send mail using the form data.
  public function sendPaymentForm ( $postdata )
  {
    $body = $this->getBody( $postdata );

    $this->load->library('email');
    $this->email->from("sebscodex@gmail.com", "Contact Form");
    // $this->email->from("noreply@alpacode.com", "Contact Form");
    // $this->email->to("frank@alpacode.com");
    $this->email->to("sebscodex@gmail.com");
    $this->email->subject("Alpacode Payment");
    
    $message = $this->parse_message($postdata);
    $this->email->message($message);

    $this->email->send();
  }

  //Get the body of the form
  public function getBody ($postdata)
  {
    $name     = $postdata['name'];
    $invoice  = $postdata['invoice'];
    $email    = $postdata['email'];
    $phone    = $postdata['phone'];
    $message  = $postdata['message'];

    $body = "Name : "     . $name   . "\r\n\r\n" .
            "Invoice : "  . $invoice  . "\r\n\r\n" .
            "Email : "    . $email  . "\r\n\r\n" .
            "Phone : "    . $phone  . "\r\n\r\n" .
            "Message : "  . $message  . "\r\n\r\n" ;
            
    return $body;
  }
}

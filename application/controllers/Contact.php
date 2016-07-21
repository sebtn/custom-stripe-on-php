 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller
{

  public function __construct ()
  {
    parent::__construct();
    $this->load->library('session');
    $this->load->helper(array('form', 'url'));
  }

  /**
   * Ajax called to send email.
   * @return bool
   */
  public function index ()
  { 
    //Defined postdata as an array.
    $postdata = array(
      'name'    => $this->input->post('name'),
      'invoice' => $this->input->post('invoice'),
      'email'   => $this->input->post('email'),
      'phone'   => $this->input->post('phone'),
      'message' => $this->input->post('message')
    );
    //Validates the form feilds.
    $this->load->library('form_validation');
    
    $this->form_validation->set_rules('invoice', 'Field invoice', 'callback_field_check');
    $this->form_validation->set_rules('name', 'Field name', 'callback_field_check');
    $this->form_validation->set_rules('email', 'Field email', 'callback_field_check|valid_email');
    $this->form_validation->set_rules('phone', 'Field phone', 'callback_field_check');
  
    if($this->form_validation->run() == TRUE)
    {
      $this->load->model('SendMail', 'sendmail');
      $this->sendmail->sendPaymentForm( $postdata );
      $this->load->view('custom_stripe');    
    } else {
      $this->load->view('custom_stripe');    
    }

   }
  
  //callback used in the vallidation.
  public function field_check($str)
  {
    if ($str == '' || $str == null)
    {
      $this->form_validation->set_message('field_check', 'The %s cannot be empty');
      return FALSE;
    } else {
      return TRUE;
    }
  }

}
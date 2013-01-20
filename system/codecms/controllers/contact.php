<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function __construct(){

		parent::__construct();

        // START DYNAMICALLY ADD STYLESHEETS
        $css = array(
            'assets/css/bootstrap.css',
            'assets/templates/default/css/default.css',
            'assets/css/bootstrap-responsive.css'
        );

        $this->template->stylesheet->add($css);
        // END DYNAMICALLY ADD STYLESHEETS               

        // START DYNAMICALLY ADD JAVASCRIPTS
        $js = array(
            'assets/js/jquery.js',
            'assets/js/bootstrap.min.js'
        );

        $this->template->javascript->add($js);
        // END DYNAMICALLY ADD STYLESHEETS

        $this->load->model('posts_model');

        $config['protocol'] 	= 	'sendmail';
		$config['mailpath'] 	= 	'/usr/sbin/sendmail';
		$config['charset'] 		= 	'iso-8859-1';
		$config['wordwrap'] 	= 	TRUE;
		$config['mailtype']		=	'html';
        
        $this->load->library('email', $config);
        $this->load->library('form_validation');

        $this->template->set_template('public/templates/default/contact_tpl');

	}

	public function index(){

		$this->home();
	}

	public function home($post_type = 'page'){

        $this->template->title      = 'Contact Page';
        
        //ALL THE PAGES FOR THE MENU PAGE LISTING
        $data['pages']             = $this->posts_model->get_all_posts($post_type, $order_by = 'post_id', $arrange_by = 'asc', $limit = 10);        

        $this->template->content->view('public/templates/default/contact', $data);
        
        // publish the template
        $this->template->publish(); 
	}

	public function form_submit_validation(){

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean|alpha');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('reason', '"How may I help you"', 'trim|required|xss_clean');

		if ( $this->form_validation->run() ) :

			$this->email->from($this->input->post('email'), $this->input->post('first_name'));
			$this->email->to('someone@example.com'); 			//CHANGE TO YOUR EMAIL ADDRESS
			//$this->email->cc('another@another-example.com'); 	//UNCOMMENT IF YOU WANT TO USE THE CC FUNCTION
			//$this->email->bcc('them@their-example.com'); 		//UNCOMMENT IF YOU WANT TO USE THE BCC FUNCTION

			$this->email->subject($this->input->post('reason'));

	        $message = ' 
	        First Name: 	'. $this->input->post('first_name') .'
	        Last Name: 		'. $this->input->post('last_name') 	.'
	        Email: 			'. $this->input->post('email') 		.'
	        Website: 		'. $this->input->post('website') 	.'
	        Message: 		'. $this->input->post('message');

			$this->email->message($message);

			if ($this->email->send()) :

				$data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully sent an email.');
				redirect('contact', $data);

			else:

				$data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, we there is a problem in sending your message. Please try again.');
				redirect('contact', $data);

			endif;			

		else:

			//IF THE USER FAILED THE FORM VALIDATION, GO BACK TO CONTACT PAGE WITH THE ERRORS
			$this->home();

		endif;

	}

}
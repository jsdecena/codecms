<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){

        parent::__construct();

        $this->template->set_template('admin/admin_template');

        // START DYNAMICALLY ADD STYLESHEETS
        $css = array(
        	'assets/css/bootstrap.css',
        	'assets/css/bootstrap-responsive.css'        	
        );

        $this->template->stylesheet->add($css);
        // END DYNAMICALLY ADD STYLESHEETS

        // START DYNAMICALLY ADD JAVASCRIPTS
        $js = array(
        	'assets/js/jquery.js',        	
        	'assets/js/application.js',
        	'assets/js/bootstrap-affix.js',
        	'assets/js/bootstrap-alert.js',
        	'assets/js/bootstrap-button.js',
        	'assets/js/bootstrap-carousel.js',
        	'assets/js/bootstrap-collapse.js',        	
        	'assets/js/bootstrap-dropdown.js',
        	'assets/js/bootstrap-modal.js',
//        	'assets/js/bootstrap-popover.js',
        	'assets/js/bootstrap-scrollspy.js',
        	'assets/js/bootstrap-tab.js',
        	'assets/js/bootstrap-tooltip.js',
        	'assets/js/bootstrap-transition.js',
        	'assets/js/bootstrap-typeahead.js',
        	'assets/js/bootstrap.min.js'
        );

        $this->template->javascript->add($js);
        // END DYNAMICALLY ADD STYLESHEETS

        //$this->load->model('users_model');
        //$this->load->library('form_validation');
        //$this->load->library('email', array('mailtype' => 'html'));
    }	

	public function index(){

		$this->login_now();

	}


	public function login_now(){

        $this->template->title = 'Login';
        
        $data = array(); // load from model (but using a dummy array here)
        $this->template->content->view('admin/login', $data);
        
        // publish the template
        $this->template->publish();

	}

}
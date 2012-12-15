<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {


    public function __construct(){ 

    	 parent::__construct();

        // START DYNAMICALLY ADD STYLESHEETS
        $css = array(
        	'assets/css/bootstrap.css',
        	'assets/css/bootstrap-responsive.css',
            'assets/css/docs.css',
            'assets/css/admin.css'
        );

        $this->template->stylesheet->add($css);
        // END DYNAMICALLY ADD STYLESHEETS

        // START DYNAMICALLY ADD JAVASCRIPTS
        $js = array(
        	'http://code.jquery.com/jquery-latest.min.js',
        	'assets/js/application.js',
        	'assets/js/bootstrap-affix.js',
        	'assets/js/bootstrap-alert.js',
        	'assets/js/bootstrap-button.js',
        	'assets/js/bootstrap-carousel.js',
        	'assets/js/bootstrap-collapse.js',
        	'assets/js/bootstrap-dropdown.js',
        	'assets/js/bootstrap-modal.js',
        	'assets/js/bootstrap-scrollspy.js',
        	'assets/js/bootstrap-tab.js',
        	'assets/js/bootstrap-tooltip.js',
        	'assets/js/bootstrap-transition.js',
        	'assets/js/bootstrap-typeahead.js',
        	'assets/js/bootstrap.min.js'
        );

        $this->template->javascript->add($js);
        // END DYNAMICALLY ADD STYLESHEETS    	 

        $this->load->model('users_model');
        $this->template->set_template('admin/template_dashboard');
    }	

	public function index(){

		if ( $this->users_model->check_if_logged_in() ) :

			$this->page_home();

		else:

			//UNAUTHORIZE ACCESS THROW THEM OUTSIDE
			redirect('admin/main/login');

		endif;			

	}

	public function page_home() {
            
            $this->template->title = 'Pages';

            $data['logged_info']    = $this->users_model->logged_in();
            
            $this->template->content->view('admin/pages', $data);
            
            // publish the template
            $this->template->publish();

            $this->users_model->insert_identity();

	}

}
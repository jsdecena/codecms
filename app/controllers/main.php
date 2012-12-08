<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$this->homepage();
	}

	public function homepage(){

        $this->template->title = 'Homepage';
        
        // START DYNAMICALLY ADD STYLESHEETS
        $css = array(
        	'assets/css/bootstrap-responsive.css',
        	'assets/css/bootstrap.css'
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
        
        $data = array(); // load from model (but using a dummy array here)
        $this->template->content->view('main', $data);        
        
        // publish the template
        $this->template->publish();		
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
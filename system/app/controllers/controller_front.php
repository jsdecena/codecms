<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_front extends CI_Controller {

        public function __construct(){

                parent::__construct();

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

        }        

        public function index() {
                
                $this->home();                        
        }

        public function home(){

                 $this->template->set_template('template_home');

                $this->template->title = 'Home';

                $data = array(); // load from model (but using a dummy array here)
                $this->template->content->view('home', $data);  

                // publish the template
                $this->template->publish();		
        }

        public function pages() {

                $this->load->model('pages_model');
                
                $this->template->title = 'Pages';

                $data['page_data'] = $this->pages_model->get_static_page();

                $this->template->content->view('pages', $data);

                // publish the template
                $this->template->publish();     
        }


}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_front extends CI_Controller {

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
                    'http://code.jquery.com/jquery-latest.min.js',
                    
                    //USER THE OTHER JS IF YOU NEED IT              
                    /*'assets/js/application.js',
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
                    'assets/js/bootstrap-typeahead.js',*/
                    'assets/js/bootstrap.min.js'
                );

                $this->template->javascript->add($js);
                // END DYNAMICALLY ADD STYLESHEETS

                $this->load->model('public_model');
                $this->load->model('users_model');           

        }        

        public function index() {
                
                $this->home();                        
        }

        public function home(){          

                $this->template->set_template('public/templates/default/home_tpl'); 

                $this->template->title = 'Home';

                $data['page_data'] = $this->public_model->get_all_pages();
                $this->template->content->view('public/templates/default/home', $data);

                // publish the template
                $this->template->publish();		
        }

        public function pages() {

                $this->template->set_template('public/templates/default/pages_tpl');                

                $data['page_data']  = $this->public_model->get_all_pages();
                $data['page']       = $this->public_model->get_page();

                $page_title         = $this->public_model->get_page();

                $this->template->title = $page_title->title;                                              

                $this->template->content->view('public/templates/default/pages', $data);

                // publish the template
                $this->template->publish();     
        }

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
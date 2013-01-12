<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

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
                $this->load->model('posts_model');
                $this->load->model('users_model');
                $this->load->helper('text');       

        }	

        public function posts_list(){

            $this->template->set_template('public/templates/default/posts_tpl');

            $this->template->title      = 'Post Listing';

            $data['logged_info']        = $this->users_model->logged_in();
            $data['page_data']          = $this->public_model->get_all_pages();
            $data['post_items']         = $this->posts_model->get_all_posts('post_id', 'desc', '0,3');
            
            $this->template->content->view('public/templates/default/posts', $data);
            
            // publish the template
            $this->template->publish();            
        }        

        //SINGLE POST
        public function post() {

                $this->template->set_template('public/templates/default/posts_tpl');                

                $data['page_data']          = $this->public_model->get_all_pages();
                $data['post']               = $this->public_model->view_post();
                $post_title                 = $this->public_model->view_post(); //PAGE TITLE OF THE SPECIFIC POST

                if( isset($post_title) ) :
                
                    $this->template->title      = $post_title->title;

                else:

                    $this->template->title  = 'Page Not Found';

                endif;            

                $this->template->content->view('public/templates/default/posts', $data);

                // publish the template
                $this->template->publish();
        }	
}
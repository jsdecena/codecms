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
                $this->load->model('posts_model');
                $this->load->helper('text');       

        }        

        public function index() {
                
                $this->home();                        
        }

        public function home(){          

                $this->template->set_template('public/templates/default/home_tpl'); 

                $this->template->title  = 'Home';

                //ALL THE PAGES FOR THE MENU PAGE LISTING
                $data['page_data']      = $this->public_model->get_all_pages();
                
                //GET ALL THE POSTS
                $data['all_posts']      = $this->public_model->get_all_posts('post_id', 'desc', '0,3');

                $this->template->content->view('public/templates/default/home', $data);

                // publish the template
                $this->template->publish();		
        }

        public function pages() {

                $this->template->set_template('public/templates/default/pages_tpl');

                $this->load->library('pagination');

                $config['base_url']         = base_url('blog/posts_list');
                $config['total_rows']       = $this->posts_model->count_all_posts();
                $config['per_page']         = 2;            
                $config['full_tag_open']    = '<div class="pagination"><ul>';
                $config['full_tag_close']   = '</ul></div>';
                $config['num_tag_open']     = '<li>';
                $config['num_tag_close']    = '</li>';   
                $config['cur_tag_open']     = '<li><a href="#" class="current">';
                $config['cur_tag_close']    = '</a></li>';
                $config['prev_tag_open']    = '<li id="prev_item">';
                $config['prev_tag_close']   = '</li>';
                $config['next_tag_open']    = '<li id="next_item">';
                $config['next_tag_close']   = '</li>';
                $config['next_link']        = 'Next';
                $config['prev_link']        = 'Prev';

                $this->pagination->initialize($config);

                $data['links']              = $this->pagination->create_links();                                           

                //ALL THE PAGES FOR THE MENU PAGE LISTING
                $data['page_data']      = $this->public_model->get_all_pages();
                
                $data['page']           = $this->public_model->get_page(); // THE SPECIFIC PAGE
                $page_title             = $this->public_model->get_page(); //PAGE TITLE OF THE SPECIFIC PAGE

                
                // CHECK FOR THE PAGE TO DISPLAY ALL THE POSTS              
                $data['post_page']      = $this->public_model->check_post_page();                

                // GET ALL THE POSTS
                $data['all_posts']      = $this->public_model->get_all_posts();                

                if( isset($page_title) ) :
                    
                    $this->template->title  = $page_title->title;

                else:

                    $this->template->title  = 'Page Not Found';

                endif;

                $this->template->content->view('public/templates/default/pages', $data);

                // publish the template
                $this->template->publish();     
        }

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
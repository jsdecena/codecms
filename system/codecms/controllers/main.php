<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeCMS an alternative responsive open source cms made from Philippines.
 *
 * @package     CodeCMS
 * @author      @jsd
 * @copyright   Copyright (c) 2013
 * @license     http://creativecommons.org/licenses/by-sa/3.0/deed.en_US
 * @link        https://bitbucket.org/jsdecena/codecms
 * @since       Version 0.1
 * 
 */

class Main extends CI_Controller {

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
                $this->load->helper('text');       

        }        

        public function index() {
                
                $this->home();                        
        }

        public function home(){          

                $this->template->set_template('public/templates/default/home_tpl'); 

                $this->template->title      = 'Home';

                //ALL THE PAGES FOR THE MENU PAGE LISTING
                $data['pages']              = $this->posts_model->get_all_posts($post_type = 'page', $order_by = 'post_id', $arrange_by ='desc', $limit = 3);
                
                //GET ALL THE POSTS
                $data['posts']              = $this->posts_model->get_all_posts($post_type = 'post', $order_by = 'post_id', $arrange_by ='desc', $limit = 3 );

                $this->template->content->view('public/templates/default/home', $data);

                // publish the template
                $this->template->publish();		
        }

        public function pages() {

                $this->template->set_template('public/templates/default/pages_tpl');

                $this->load->library('pagination');

                $config['base_url']         = base_url('blog/posts_list');
                $config['total_rows']       = $this->posts_model->count_all_posts();
                $config['per_page']         = 3;       
                $config['full_tag_open']    = '<div class="pagination"><ul>';
                $config['full_tag_close']   = '</ul></div>';
                $config['num_tag_open']     = '<li>';
                $config['num_tag_close']    = '</li>';   
                $config['cur_tag_open']     = '<li class="active"><a href="#">';
                $config['cur_tag_close']    = '</a></li>';
                $config['prev_tag_open']    = '<li id="prev_item">';
                $config['prev_tag_close']   = '</li>';
                $config['next_tag_open']    = '<li id="next_item">';
                $config['next_tag_close']   = '</li>';
                $config['first_tag_open']   = '<li id="first">';
                $config['first_tag_close']  = '</li>';            
                $config['last_tag_open']    = '<li id="last">';
                $config['last_tag_close']   = '</li>';
                $config['next_link']        = 'Next';
                $config['prev_link']        = 'Prev';

                $this->pagination->initialize($config);

                $data['links']              = $this->pagination->create_links();                                           

                //ALL THE PAGES FOR THE MENU PAGE LISTING
                $data['pages']              = $this->posts_model->get_all_posts($post_type = 'page', $order_by = 'post_id', $arrange_by = 'asc', '', $offset = 0);
                
                $data['page']               = $this->posts_model->get_page(); // THE SPECIFIC PAGE
                $page_title                 = $this->posts_model->get_page(); //PAGE TITLE OF THE SPECIFIC PAGE

                
                // CHECK FOR THE PAGE TO DISPLAY ALL THE POSTS              
                $data['post_page']          = $this->posts_model->check_post_page();

                $offset                     = $this->uri->segment(3);
                
                // GET ALL THE POSTS
                //CHANGE THE LIMIT VALUE TO LIMIT THE NUMBER OF POST ITEMS TO SHOW IN THE HOMEPAGE
                $data['posts']              = $this->posts_model->get_all_posts($post_type = 'post', $order_by = 'post_id', $arrange_by = 'desc', $limit = 3, $offset);              

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

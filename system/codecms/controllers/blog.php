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
                    'assets/js/bootstrap.min.js'
                );

                $this->template->javascript->add($js);
                // END DYNAMICALLY ADD STYLESHEETS

                $this->load->model('posts_model');
                $this->load->model('users_model');
                $this->load->helper('text');       

        }	

        public function posts_list(){

            $this->template->set_template('public/templates/default/posts_tpl');

            $this->load->library('pagination');

            $config['base_url']         = base_url('blog/posts_list');
            $config['total_rows']       = $this->posts_model->count_all_posts();
            $config['per_page']         = 3;
            $config['uri_segment']      = 3;
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
            $data['pages']          = $this->posts_model->get_all_pages($order_by = 'post_id', $arrange_by = 'desc', $limit = $config['per_page'], $offset);
            
            $data['page']               = $this->posts_model->get_page(); // THE SPECIFIC PAGE
            $page_title                 = $this->posts_model->get_page(); //PAGE TITLE OF THE SPECIFIC PAGE

            
            // CHECK FOR THE PAGE TO DISPLAY ALL THE POSTS              
            $data['post_page']          = $this->posts_model->check_post_page();                

            $offset                     = $this->uri->segment(3);
            
            // GET ALL THE POSTS
            $data['posts']              = $this->posts_model->get_all_posts($order_by = 'post_id', $arrange_by = 'desc', $limit = $config['per_page'], $offset);

            $this->template->title      = 'Post Listing';

                //$data['logged_info']        = $this->users_model->logged_in();
                //$data['page_data']          = $this->posts_model->get_all_pages();
                //$data['post_items']         = $this->posts_model->get_all_posts();
            
            $this->template->content->view('public/templates/default/posts', $data);
            
            // publish the template
            $this->template->publish();            
        }        

        //SINGLE POST
        public function post() {

                $this->template->set_template('public/templates/default/posts_tpl');                

                $data['pages']             = $this->posts_model->get_all_pages($order_by = 'post_id', $arrange_by = 'asc', $limit = 10);
                $data['post']              = $this->posts_model->view_post();
                $post_title                = $this->posts_model->view_post(); //PAGE TITLE OF THE SPECIFIC POST

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
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_pages extends CI_Controller {

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
            'assets/js/jquery.js',
            'assets/js/bootstrap-dropdown.js',
            'assets/js/bootstrap-tab.js',
            'assets/js/bootstrap.min.js',
            'assets/js/ckeditor/ckeditor.js',
            'assets/js/default.js'
        );

        $this->template->javascript->add($js);
        // END DYNAMICALLY ADD STYLESHEETS    	 

        $this->load->model('users_model');
        $this->load->model('posts_model');
        $this->template->set_template('admin/dashboard_tpl');
        $this->load->library('form_validation');
    }	

	public function index(){

		if ( $this->users_model->logged_in_check() ) :

			$this->page_home();

		else:

			//UNAUTHORIZE ACCESS THROW THEM OUTSIDE
			redirect('admin/admin_main/login');

		endif;			

	}

	public function page_home() {
            
        $this->template->title      = 'Pages';

        $data['logged_info']    	= $this->users_model->logged_in();
        $data['page_items']    		= $this->posts_model->get_all_posts();
        
        $this->template->content->view('admin/pages_list', $data);
        
        // publish the template
        $this->template->publish();
	}

    public function pages_list($post_type = 'page', $order_by = 'post_id', $arrange_by = 'asc'){

        if ( $this->users_model->logged_in_check() ) :

            $this->load->library('pagination');

            $config['base_url']         = base_url('admin/pages/pages_list');
            $config['total_rows']       = $this->posts_model->count_all_pages();
            $config['per_page']         = 5;
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
        
            $this->template->title      = 'Pages Listing';

            $data['logged_info']        = $this->users_model->logged_in();

            $offset                     = $this->uri->segment(4);
            $data['posts']              = $this->posts_model->get_all_posts($post_type, $order_by, $arrange_by, $config['per_page'], $offset);
            
            $this->template->content->view('admin/pages_list', $data);
            
            // publish the template
            $this->template->publish();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/admin_main/login');

        endif;

    }

    public function page_create($post_type = 'page'){

        if ( $this->users_model->logged_in_check() ) :        

            $this->template->title      = 'Create a Page';

            $data['logged_info']        = $this->users_model->logged_in();
            $data['pages']              = $this->posts_model->get_all_posts($post_type = 'page');        
            
            $this->template->content->view('admin/pages_create', $data);
            
            // publish the template
            $this->template->publish();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/admin_main/login');

        endif;            

    }

    public function page_create_check(){

        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

        if ( $this->form_validation->run() ) :

            if ( $this->input->post('page_create') && $this->posts_model->insert_post() === TRUE ) :

                $data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully created a page.');              

                redirect('admin/admin_pages/page_edit' .'/'. $this->posts_model->get_post_id(), $data);    

            endif;                   

        else:

            $this->page_create();

        endif;
    } 

    public function page_view() {

            $this->template->set_template('public/templates/default/pages_tpl');                

            $data['page_data']  = $this->public_model->get_all_posts();
            $data['page']       = $this->public_model->get_page();

            $page_title         = $this->public_model->get_page();

            $this->template->title = $page_title->title;                                              

            $this->template->content->view('public/templates/default/pages', $data);

            // publish the template
            $this->template->publish();     
    }   

    public function page_edit(){        
        
            $this->template->title      = 'Pages';

        if ( $this->users_model->logged_in_check() ) :

            $post_id                    = $this->uri->segment(4);            

            $data['logged_info']        = $this->users_model->logged_in();
            $data['page_items']         = $this->posts_model->get_post($post_id); //THIS IS ACTUALLY RETURNING THE POST WITH A PAGE 'POST TYPE'
            $data['pages']              = $this->posts_model->get_all_posts();
            
            $this->template->content->view('admin/pages_edit', $data);
            
            // publish the template
            $this->template->publish();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/admin_main/login');

        endif;            
    }    

    public function page_edit_check(){

        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

        if ( $this->form_validation->run() ) :

            //VALIDATION SUCCCESS
            $this->posts_model->update_post();

            $data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully edited this page.');
            redirect('admin/admin_pages/page_edit' .'/'. $this->input->post('post_id'), $data);

        else:

            //VALIDATION FAILURE
            $data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, Title is required.');
            redirect('admin/admin_pages/page_edit' .'/'. $this->input->post('post_id'), $data);

        endif;            
    }

    public function quick_update(){
        
        if ( $this->users_model->logged_in_check() ) :

            if ( $this->posts_model->quick_update() ) :

                if ( $this->input->post('status') == 'published') :
                    $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully PUBLISHED a page.');
                else:
                    $data['message_error']    = $this->session->set_flashdata('message_error', 'You have successfully UNPUBLISHED a page.');
                endif;

                redirect('admin/admin_pages/pages_list', $data);

            endif;            

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/admin_main/login');

        endif;        

    }    

    /* ------- DELETE PAGES ----------- */

    public function page_delete(){

        if( $this->posts_model->delete_post() === TRUE) :

            $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully deleted a page.');
            $data['message_error']      = $this->session->set_flashdata('message_error', 'Sorry, we have a problem deleting a page. Please try again.');

           redirect('admin/admin_pages/pages_list', $data);

        endif;
    }

    public function post_delete_selection(){
            
        $selectedIds = $_POST['selected'];
        $this->posts_model->delete_post_selection($selectedIds);         

    }        

}
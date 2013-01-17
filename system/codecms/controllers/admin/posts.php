<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {    

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

			$this->post_home();

		else:

			//UNAUTHORIZE ACCESS THROW THEM OUTSIDE
			redirect('admin/main/login');

		endif;			

	}

	public function post_home() {
            
        $this->template->title      = 'Posts';

        $data['logged_info']    	= $this->users_model->logged_in();
        $data['post_items']    		= $this->posts_model->get_all_posts();
        
        $this->template->content->view('admin/posts_list', $data);
        
        // publish the template
        $this->template->publish();
	}

    public function posts_list(){

        if ( $this->users_model->logged_in_check() ) :

            $query = $this->posts_model->view_post_settings();  //GETS THE POST PER PAGE SETTINGS  

            $per_page       = $query[1]['settings_value'];      //SETTINGS PER PAGE VALUE  
            $order_by       = $query[2]['settings_value'];      //SETTINGS POST BY "post_id" or "date"
            $arrange_by     = $query[3]['settings_value'];      //ARRANGE BY DESC OR ASC

            $this->load->library('pagination');

            $config['base_url']         = site_url('admin/posts/posts_list');
            $config['total_rows']       = $this->posts_model->count_all_posts();
            $config['per_page']         = $per_page;
            $config['num_links']        = 3;
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
        
            $this->template->title      = 'Post Listing';

            $offset                     = $this->uri->segment(4);

            $data['logged_info']        = $this->users_model->logged_in();
            $data['post_items']         = $this->posts_model->get_all_posts($order_by, $arrange_by, $config['per_page'], $offset);
            
            $this->template->content->view('admin/posts_list', $data);
            
            // publish the template
            $this->template->publish();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;

    }

    public function post_create(){

        if ( $this->users_model->logged_in_check() ) :        

            $this->template->title      = 'posts';

            $data['logged_info']        = $this->users_model->logged_in();            
            
            $this->template->content->view('admin/posts_create', $data);
            
            // publish the template
            $this->template->publish();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;            

    }

    public function post_create_check(){

        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

        if ( $this->form_validation->run() ) :

            //SET THE MESAGE ONLY WHEN THE BUTTON "POST CREATE" IS CLICKED
            if ( $this->input->post('post_create') ) :
                
                $data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully created a post.');
            
            endif;

            $this->_post_insert_db();
            redirect('admin/posts/post_edit' .'/'. $this->posts_model->get_post_id(), $data);            

        else:

            $this->post_create();

        endif;
    }

    private function _post_insert_db(){

        if ( $this->users_model->logged_in_check() ) :

            //LET US VALIDATE FIRST THE INPUTTED DATA
            $this->posts_model->insert_post();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;          

    }

    public function post_edit($post_id){

        if ( $this->users_model->logged_in_check() ) : 

            $this->template->title      = 'posts';

            $data['logged_info']        = $this->users_model->logged_in();
            $data['post_items']         = $this->posts_model->get_post($post_id);
            
            $this->template->content->view('admin/posts_edit', $data);
            
            // publish the template
            $this->template->publish();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;            
    }    

    public function post_edit_check(){

        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

        if ( $this->form_validation->run() ) :

            //VALIDATION SUCCCESS
            $this->_post_edit_insert();

            $data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully edited this post.');
            redirect('admin/posts/post_edit' .'/'. $this->input->post('post_id'), $data);

        else:

            //VALIDATION FAILURE
            $data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, Title is required.');
            redirect('admin/posts/post_edit' .'/'. $this->input->post('post_id'), $data);

        endif;            
    }

    private function _post_edit_insert(){

        if ( $this->users_model->logged_in_check() ) :        

            if ( $this->posts_model->update_post() ) :

                    //SUCCESFULL INSERTION OF THE EDITED post IN THE DB
                    return true;
            else :
                    //FAILURE OF INSERTION OF THE EDITED post IN THE DB
                    return false;
            endif;

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;  
    }

    /* ------- DELETE POSTS ----------- */

    public function post_delete(){

        //SINGLE DELETE
        if ( $this->input->post('delete_post')) :
            
            if( $this->posts_model->delete_post() === TRUE) :

                $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully deleted a post.');
                $data['message_error']      = $this->session->set_flashdata('message_error', 'Sorry, we have a problem deleting a post. Please try again.');

               redirect('admin/posts/posts_list', $data);

            endif;

        else:            

            $id = $this->input->post('delete_selection');                  
            
            for( $i=0; $i<sizeof($id); $i++) :
            
                $this->posts_model->delete_post_selection($id[$i]);
            
            endfor;
            
            $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully deleted your selected posts.');
            redirect('admin/posts/posts_list', $data);

        endif;
    }


}
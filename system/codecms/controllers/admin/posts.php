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
            'http://code.jquery.com/jquery-latest.min.js',
            'assets/js/bootstrap-dropdown.js',
            'assets/js/bootstrap-tab.js',
            'assets/js/bootstrap.min.js',
            'assets/js/ckeditor/ckeditor.js',

            //USER THE OTHER JS IF YOU NEED IT
/*          'assets/js/application.js',
            'assets/js/bootstrap-affix.js',
            'assets/js/bootstrap-alert.js',
            'assets/js/bootstrap-button.js',
            'assets/js/bootstrap-carousel.js',
            'assets/js/bootstrap-collapse.js',
            'assets/js/bootstrap-modal.js',
            'assets/js/bootstrap-scrollspy.js',
            'assets/js/bootstrap-tooltip.js',
            'assets/js/bootstrap-transition.js',
            'assets/js/bootstrap-typeahead.js',*/
            'assets/templates/default/js/default.js' //CC JS
        );

        $this->template->javascript->add($js);
        // END DYNAMICALLY ADD STYLESHEETS    	 

        $this->load->model('users_model');
        $this->load->model('posts_model');
        $this->template->set_template('admin/dashboard_tpl');
        $this->load->library('form_validation');
    }

	public function index(){

		if ( $this->users_model->check_if_logged_in() ) :

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

    public function posts_list($limit=0){

        if ( $this->users_model->check_if_logged_in() ) :

            $this->load->library('pagination');

            $config['base_url']         = base_url('admin/post/posts_list');
            $config['total_rows']       = $this->posts_model->count_all_posts();;
            $config['per_page']         = 5;
            $config['num_links']        = 20;
            $config['uri_segment']      = 5;
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
        
            $this->template->title      = 'Post Listing';

            $data['logged_info']        = $this->users_model->logged_in();
            $data['post_items']         = $this->posts_model->get_all_posts();
            
            $this->template->content->view('admin/posts_list', $data);
            
            // publish the template
            $this->template->publish();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;

    }

    public function post_create(){

        if ( $this->users_model->check_if_logged_in() ) :        

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

            if ( $this->input->post('post_create') ) :
                $data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully created a post.');
            endif;            

            $this->post_insert_db();            
            redirect('admin/posts/post_create', $data);

        else:

            $this->post_create();

        endif;
    }

    public function post_insert_db(){

        if ( $this->users_model->check_if_logged_in() ) :

            //LET US VALIDATE FIRST THE INPUTTED DATA
            $this->posts_model->insert_created_post();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;          

    }

    public function post_edit(){

        if ( $this->users_model->check_if_logged_in() ) :        

            $this->template->title      = 'posts';

            $data['logged_info']        = $this->users_model->logged_in();
            $data['post_items']         = $this->posts_model->get_post();
            
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
            $this->post_edit_insert();

            $data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully edited this post.');
            redirect('admin/posts/post_edit' .'/'. $this->input->post('id'), $data);

        else:

            //VALIDATION FAILURE
            $data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, Title is required.');
            redirect('admin/posts/post_edit' .'/'. $this->input->post('id'), $data);

        endif;            
    }

    public function post_edit_insert(){

        if ( $this->users_model->check_if_logged_in() ) :        

            if ( $this->posts_model->update_edited_post() ) :

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

    /* ------- DELETE THE SPECIFIC post ----------- */

    public function post_delete(){

        $query = $this->db->get('posts');

        if ( $query->num_rows() > 0 ) :

           if( $this->db->delete('posts', array('post_id' => $this->input->post('id'))) === TRUE) :

                $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully deleted a user.');
                $data['message_error']      = $this->session->set_flashdata('message_error', 'Sorry, we have a problem deleting a user.');

               redirect('admin/posts/posts_list' .'/'. $this->input->post('id'), $data);

            endif;

        endif;
    }

}
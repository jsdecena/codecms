<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {


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
        	'assets/js/application.js',
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
        	'assets/js/bootstrap-typeahead.js',
        	'assets/js/bootstrap.min.js',
            'assets/js/ckeditor/ckeditor.js',
            'assets/templates/default/js/default.js' //CC JS
        );

        $this->template->javascript->add($js);
        // END DYNAMICALLY ADD STYLESHEETS    	 

        $this->load->model('users_model');
        $this->load->model('pages_model');
        $this->template->set_template('admin/dashboard_tpl');
        $this->load->library('form_validation');
    }	

	public function index(){

		if ( $this->users_model->check_if_logged_in() ) :

			$this->page_home();

		else:

			//UNAUTHORIZE ACCESS THROW THEM OUTSIDE
			redirect('admin/main/login');

		endif;			

	}

	public function page_home() {
            
        $this->template->title      = 'Pages';

        $data['logged_info']    	= $this->users_model->logged_in();
        $data['page_items']    		= $this->pages_model->get_all_pages();
        
        $this->template->content->view('admin/pages_list', $data);
        
        // publish the template
        $this->template->publish();
	}

    public function pages_list($limit=0){

        if ( $this->users_model->check_if_logged_in() ) :

            $this->load->library('pagination');

            $config['base_url']         = base_url('admin/pages/pages_list');
            $config['total_rows']       = $this->pages_model->count_all_pages();;
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
        
            $this->template->title      = 'Pages Listing';

            $data['logged_info']        = $this->users_model->logged_in();
            $data['page_items']         = $this->pages_model->get_all_pages();
            
            $this->template->content->view('admin/pages_list', $data);
            
            // publish the template
            $this->template->publish();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;

    }

    public function page_create(){

        if ( $this->users_model->check_if_logged_in() ) :        

            $this->template->title      = 'Pages';

            $data['logged_info']        = $this->users_model->logged_in();
            $data['page_items']         = $this->pages_model->get_all_pages();

            if ( $this->input->post('page_create') ) :
                $data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully created a page.');
            endif;            
            
            $this->template->content->view('admin/pages_create', $data);
            
            // publish the template
            $this->template->publish();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;            

    }

    public function page_create_check(){

        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

        if ( $this->form_validation->run() ) :

            $this->page_create_insert();            
            $this->page_create();

        else:

            $this->page_create();

        endif;
    }

    public function page_create_insert(){

        if ( $this->users_model->check_if_logged_in() ) :

            //LET US VALIDATE FIRST THE INPUTTED DATA
            $this->pages_model->insert_created_page();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;          

    }

    public function page_edit(){

        if ( $this->users_model->check_if_logged_in() ) :        

            $this->template->title      = 'Pages';

            $data['logged_info']        = $this->users_model->logged_in();
            $data['page_items']         = $this->pages_model->get_specific_page();
            
            $this->template->content->view('admin/pages_edit', $data);
            
            // publish the template
            $this->template->publish();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;            
    }    

    public function page_edit_check(){

        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

        if ( $this->form_validation->run() ) :

            //VALIDATION SUCCCESS
            $this->page_edit_insert();

            $data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully edited this page.');
            redirect('admin/pages/page_edit' .'/'. $this->input->post('id'), $data);

        else:

            //VALIDATION FAILURE
            $data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, Title is required.');
            redirect('admin/pages/page_edit' .'/'. $this->input->post('id'), $data);

        endif;            
    }

    public function page_edit_insert(){

        if ( $this->users_model->check_if_logged_in() ) :        

            if ( $this->pages_model->insert_edited_page() ) :

                    //SUCCESFULL INSERTION OF THE EDITED PAGE IN THE DB
                    return true;
            else :
                    //FAILURE OF INSERTION OF THE EDITED PAGE IN THE DB
                    return false;
            endif;

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;  
    }

    /* ------- DELETE THE SPECIFIC PAGE ----------- */

    public function page_delete(){

        $query = $this->db->get('pages');

        if ( $query->num_rows() > 1 ) :

           if( $this->db->delete('pages', array('page_id' => $this->input->post('id'))) === TRUE) :

                $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully deleted a user.');
                $data['message_error']      = $this->session->set_flashdata('message_error', 'Sorry, we have a problem deleting a user.');

               redirect('admin/pages/pages_list' .'/'. $this->input->post('id'), $data);

            endif;

        else:
            
            $data['message_error'] = $this->session->set_flashdata('message_error', 'Ooops, No more pages!');
            
            redirect('admin/pages/pages_list' .'/'. $this->input->post('id'), $data);

        endif;
    }    

}
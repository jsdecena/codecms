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
            'assets/js/jquery.js',
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
            $config['per_page']         = 2;
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

            $data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully created a page.'); 
            redirect('admin/pages/page_edit' .'/'. $this->pages_model->get_page_id(), $data, 'refresh');

        else:

            $this->page_create();

        endif;
    }

    public function page_create_insert(){

        if ( $this->users_model->check_if_logged_in() ) :

            //LET US VALIDATE FIRST THE INPUTTED DATA
            $this->pages_model->insert_page();

        else:

            //UNAUTHORIZE ACCESS THROW THEM OUTSIDE
            redirect('admin/main/login');

        endif;          

    }

    public function view_page() {

            $this->template->set_template('public/templates/default/pages_tpl');                

            $data['page_data']  = $this->public_model->get_all_pages();
            $data['page']       = $this->public_model->get_page();

            $page_title         = $this->public_model->get_page();

            $this->template->title = $page_title->title;                                              

            $this->template->content->view('public/templates/default/pages', $data);

            // publish the template
            $this->template->publish();     
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

    /* ------- DELETE PAGES ----------- */

    public function page_delete(){

        //SINGLE DELETE
        if ( $this->input->post('page_id')) :
            
            if( $this->pages_model->delete_page() === TRUE) :

                $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully deleted a page.');
                $data['message_error']      = $this->session->set_flashdata('message_error', 'Sorry, we have a problem deleting a page. Please try again.');

               redirect('admin/pages/pages_list' .'/'. $this->input->post('page_id'), $data);

            endif;

        else:            

            $id = $this->input->post('delete_selection');                  
            
            for( $i=0; $i<sizeof($id); $i++) :
            
                $this->pages_model->delete_page_selection($id[$i]);
            
            endfor;
            
            $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully deleted your selected pages.');
            redirect('admin/pages/pages_list', $data);

        endif;
    }    

}
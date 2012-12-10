<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct(){

        parent::__construct();

        // START DYNAMICALLY ADD STYLESHEETS
        $css = array(
        	'assets/css/bootstrap.css',
        	'assets/css/bootstrap-responsive.css'	
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
        	'assets/js/bootstrap.min.js'
        );

        $this->template->javascript->add($js);
        // END DYNAMICALLY ADD STYLESHEETS

        $this->template->set_template('admin/template_dashboard');
        $this->load->model('users_model');        
        $this->load->library('form_validation');
        //$this->load->library('email', array('mailtype' => 'html'));
    }	

	public function index(){

        if ( $this->session->userdata('is_logged_in')) :
            $this->dashboard();
        else:
            $this->login_now();
        endif;

	}


    /*
    *
    *   LOGIN PAGE
    *
    */
	public function login_now(){

    		$this->template->set_template('admin/template_login');

            $this->template->title = 'Login';
            
            $this->template->content->view('admin/login');
            
            // publish the template
            $this->template->publish();
	}

    /*
    *
    *   USER SIDE VALIDATION
    *
    */    
    public function login_check(){

        //CREATES VALIDATION OF THE USER INPUT ON THE LOGIN FORM
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_check_details');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|md5');

        if ( $this->form_validation->run() ) :

            $users['user_details'] = $this->users_model->get_user_details();

            foreach ($users as $user_detail):
              $username = $user_detail->username;
              $first_name = $user_detail->first_name;
              $last_name = $user_detail->last_name;
            endforeach;

            //FLASH USERDATA TO BE USED DURING LOGIN
            $data = array(
                'username' => $username,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $this->input->post('email'),
                'role' => 2, //ADMIN ROLE
                'is_logged_in' => 1
            );

            $this->session->set_userdata($data);

            //THROW THEM TO THE ADMIN DASHBOARD FOR SUCCESSFULLY PASSED THE INITIAL VALIDATION
            redirect('admin/dashboard');

        else:

            //THROW THEM TO THE SAME LOGIN PAGE WITH THE ERRORS
            $this->login_now();

        endif;

    }

    /*
    *
    *   CHECKS FOR CORRECT DETAILS IN THE DATABASE BEFORE ALLOWING TO LOGIN
    *
    */
    public function check_details(){

        $this->load->model('users_model');
        
        if ( $this->users_model->login_allowed() ) :

            return true;

        else:

            $this->form_validation->set_message('check_details', 'Incorrect email or password. Please try again.');

            return false;
        
        endif;

    }

    /*
    *
    *  DASHBOARD PAGE
    *
    */    
	public function dashboard(){

        //CHECK FIRST IF THE USER IS ALREADY LOGGED IN
        if ( $this->session->userdata('is_logged_in')) :        

            $this->template->title = 'Dashboard';
            
            $data = array(); // load from model (but using a dummy array here)
            $this->template->content->view('admin/dashboard', $data);
            
            // publish the template
            $this->template->publish();

        else:

            redirect('admin/restricted');

        endif;        
	}

    /*
    *
    *   RESTRICTED PAGE
    *
    */
    public function restricted(){

        $this->template->set_template('admin/template_login');        

        $this->template->title = 'Restricted Page';
        
        $this->template->content->view('restricted');
        
        // publish the template
        $this->template->publish();        

    }

    public function logged_in(){

       return ($this->session->userdata("username")) ? true : false;
    }

    /*
    *
    *   LOG OUT THE USER
    *
    */
    public function logout(){

        $this->session->sess_destroy();

        $this->login_now();

    }

    /*  ------- CREATE -----------
    *
    *   CREATE A USER
    *
    */    
    public function users_create(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->title = 'User creation page';
            
            $this->template->content->view('template_user_create');
            
            // publish the template
            $this->template->publish();

        else:

            redirect('admin/restricted');

        endif;         

    }

    /*
    *
    *   CREATE A USER CHECKING
    *
    */
    public function users_create_check(){

        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|is_unique[cc_users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|md5');
        $this->form_validation->set_rules('role','Role','required|callback_check_default');

        //CUSTOM MESSAGE FOR THE EMAIL THAT ALREADY EXIST IN THE DATABASE
        $this->form_validation->set_message('is_unique', 'The email you are creating already exists. Please use a different email.');
        $this->form_validation->set_message('check_default', 'Please select role for the user.');

        if ( $this->form_validation->run()) :

            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'role' => $this->input->post('role'),
                'password' => $this->input->post('password')
            );

            //IF SUCCESSFULL INSERT TO DATABASE
            if( $this->db->insert('cc_users', $data) === TRUE && $this->input->post('create')) :

                $data['create_success']    = $this->session->set_flashdata('create_success', 'You have successfully created a user.');
                $data['create_error']      = $this->session->set_flashdata('create_error', 'Sorry, we have a problem creating a user.');

                redirect('admin/users_create');

            endif;

        else:

            // IF VALIDATION FAILS, GO BACK TO THE USERS CREATE PAGE
            // WITH THE ERRORS
            $this->users_create();

        endif;
    }

    //ADDITIONAL CHECKING FOR THE ROLE CALLBACK
    public function check_default($post_string){

      return $post_string == '0' ? FALSE : TRUE;
    }  

    /*
    *
    *   ------- READ -----------
    *
    *   LIST USERS
    *
    */    
    public function users_list(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->title = 'User creation page';               

            $records['user_data'] = $this->users_model->users_query_list();

            $this->template->content->view('template_users_list', $records);

            $this->template->publish();                       

        else:

            redirect('admin/restricted');

        endif;         

    }

    /*
    *
    *   ------- UPDATE USER LIST PAGE -----------
    *
    *  
    *
    */  
    public function users_update(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->title = 'User update page';

            $records_user['data'] = $this->users_model->users_query_specific();

            $this->template->content->view('template_users_update.php', $records_user);

            $this->template->publish();

        else:

            redirect('admin/restricted');

        endif;         
    }

    /*
    *
    *   ------- UPDATE THE SPECIFIC USER -----------
    *
    *   
    *
    */  
    public function users_update_specific(){

        if ( $this->input->post('save')):
            
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'role' => $this->input->post('role'),
                'password' => md5($this->input->post('password'))
            );  

                //IF SUCCESSFULL UPDATE TO DATABASE
               if( $this->db->update('cc_users', $data, 'id = '. $this->input->post('id').'') === TRUE) :

                    $data['update_success']    = $this->session->set_flashdata('update_success', 'You have successfully updated a user.');
                    $data['update_error']      = $this->session->set_flashdata('update_error', 'Sorry, we have a problem updating a user.');

                    redirect('admin/users_update/'. $this->input->post('id').'');

                endif; // SUCCESS UPDATE DATABASE
        endif; //IF POST SAVE
    } 

    /*
    *
    *   ------- DELETE THE SPECIFIC USER -----------
    *
    *   
    *
    */

    public function users_delete(){

        $query = $this->db->get('cc_users');

        if ($query->num_rows() > 1) :

           if( $this->db->delete('cc_users', array('id' => $this->uri->segment(3,0))) === TRUE) :

                $data['delete_success']    = $this->session->set_flashdata('delete_success', 'You have successfully deleted a user.');
                $data['delete_error']      = $this->session->set_flashdata('delete_error', 'Sorry, we have a problem deleting a user.');

                return $this->users_list();

            endif;

        else:
            
            $data['last_user'] = $this->session->set_flashdata('last_user', 'Ooops, this is the last user. You cannot delete this user.');
            
            return $this->users_list();

        endif;
    } 

}
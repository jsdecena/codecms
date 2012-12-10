<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        	'assets/js/bootstrap.min.js'
        );

        $this->template->javascript->add($js);
        // END DYNAMICALLY ADD STYLESHEETS

        $this->template->set_template('admin/template_dashboard');
        $this->load->model('users_model');        
        $this->load->library('form_validation');
    }	


    /* ---------- START PAGE ------------------ */

	public function index(){

        if ( $this->session->userdata('is_logged_in')) :
            $this->dashboard();
        else:
            $this->login_now();
        endif;

	}


    /* -------- LOGIN PAGE -------------------- */

	public function login_now(){

    		$this->template->set_template('admin/template_login');

            $this->template->title = 'Login';
            
            $this->template->content->view('admin/login');
            
            // publish the template
            $this->template->publish();
	}

    /* ---------- USER SIDE VALIDATION -----------*/

    public function login_check(){

        //CREATES VALIDATION OF THE USER INPUT ON THE LOGIN FORM
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_check_details');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|sha1');

        if ( $this->form_validation->run() ) :

            //FLASH USERDATA TO BE USED DURING LOGIN
            $data = array(
                'email' => $this->input->post('email'),
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

    /* --------- CHECKS FOR CORRECT DETAILS IN THE DATABASE BEFORE ALLOWING TO LOGIN --------- */
    
    public function check_details(){
        
        if ( $this->users_model->login_allowed() ) :
            return true;
        else:
            $this->form_validation->set_message('check_details', 'Incorrect email or password. Please try again.');
            return false;
        endif;

    }

    /* ---------- DASHBOARD PAGE ------------ */

	public function dashboard(){

        //CHECK FIRST IF THE USER IS ALREADY LOGGED IN
        if ( $this->session->userdata('is_logged_in')) :

            $this->template->title = 'Dashboard';

            $data['logged_info'] = $this->users_model->logged_in();
            $data['role'] = $this->users_model->check_role();
            
            $this->template->content->view('admin/dashboard', $data);
            
            // publish the template
            $this->template->publish();

        else:

            redirect('admin/restricted');

        endif;        
	}

    /* ---------- RESTRICTED PAGE ------------- */

    public function restricted(){

        $this->template->set_template('admin/template_login');        

        $this->template->title = 'Restricted Page';
        
        $this->template->content->view('restricted');
        
        // publish the template
        $this->template->publish();        

    }

    /* ------- LOG OUT THE USER --------*/

    public function logout(){

        $this->session->sess_destroy();

        $this->login_now();

    }

    /*  ------- CREATE A USER ----------- */

    public function users_create(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->title  = 'User creation page';

            $data['logged_info']    = $this->users_model->logged_in();
            $data['role']           = $this->users_model->check_role();

            $this->template->content->view('users_create', $data);
            
            // publish the template
            $this->template->publish();

        else:

            redirect('admin/restricted');

        endif;         

    }

    /* --------- CREATE A USER CHECKING --------*/

    public function users_create_check(){

        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|is_unique[cc_users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|sha1');
        $this->form_validation->set_rules('role','Role','required|callback_check_default');

        //CUSTOM MESSAGE FOR THE EMAIL THAT ALREADY EXIST IN THE DATABASE
        $this->form_validation->set_message('is_unique', 'The email you are creating already exists. Please use a different email.');
        $this->form_validation->set_message('check_default', 'You must select role for the user.');

        if ( $this->form_validation->run()) :

            $data = array(
                'username' => $this->input->post('username'),
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

    /* ------- READ LIST USERS ----------- */    
    public function users_list(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->title  = 'User creation page';               

            $data['user_data']      = $this->users_model->users_query_list();
            $data['logged_info']    = $this->users_model->logged_in();
            $data['role']           = $this->users_model->check_role();

            $this->template->content->view('users_list', $data);

            $this->template->publish();                       

        else:

            redirect('admin/restricted');

        endif;         

    }

    /* ------- UPDATE USER LIST PAGE ----------- */  

    public function users_update(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->title = 'User update page';

            $data['data'] = $this->users_model->users_query_specific();

            $data['logged_info'] = $this->users_model->logged_in();
            $data['role'] = $this->users_model->check_role();

            $this->template->content->view('users_update.php', $data);

            $this->template->publish();

        else:

            redirect('admin/restricted');

        endif;         
    }

    /* ------- UPDATE THE SPECIFIC USER ----------- */

    public function users_update_specific(){

        if ( $this->input->post('save')):
            
            $data = array(
                'username' => $this->input->post('username'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'role' => $this->input->post('role'),
                'about' => $this->input->post('about')
            );  


                $this->form_validation->set_rules('about','About','trim|xss_clean');
                $this->form_validation->set_rules('role','Role','required|callback_check_default');
                $this->form_validation->set_message('check_default', 'You must select role for the user.');          

                if ( $this->form_validation->run()) :                

                    //IF SUCCESSFULL UPDATE TO DATABASE
                   if( $this->db->update('cc_users', $data, 'id = '. $this->input->post('id').'') === TRUE) :

                        $data['update_success']    = $this->session->set_flashdata('update_success', 'Upate success.');
                        $data['update_error']      = $this->session->set_flashdata('update_error', 'Sorry, we have a problem updating a user.');

                        redirect('admin/users_update/'. $this->input->post('id').'');

                    endif; // SUCCESS UPDATE DATABASE
                else:

                    $data['needs_user_role']      = $this->session->set_flashdata('needs_user_role', 'Sorry, you need to set the user role.');
                    
                    // IF VALIDATION FAILS, GO BACK TO THE USERS UPDATE PAGE
                    // WITH THE ERRORS                    
                    redirect('admin/users_update/'. $this->input->post('id').'');
                endif; // PASSED THE VALIDATION
        endif; //IF POST SAVE
    }

    /* ------- SPECIFIC USER PW PAGE ----------- */  

    public function users_update_pw(){        

        if ( $this->session->userdata('is_logged_in')) :             

            $this->template->title = 'User update page';

            //CHECK FOR USER ROLES
            $role = $this->users_model->check_role();

            $data['data']           = $this->users_model->users_query_specific();
            $data['logged_info']    = $this->users_model->logged_in();
            $data['role']           = $this->users_model->check_role();

            if ( $role != 'admin' ) :
                $this->template->content->view('users_update_pw.php', $data);
            else:
                $this->template->set_template('admin/profile_update');
                $this->template->content->view('admin/admin_update_pw.php', $data);                
            endif;

            $this->template->publish();

        else:

            redirect('admin/restricted');

        endif;         
    }    

    /* ------- UPDATE THE SPECIFIC USER'S PW ----------- */

    public function users_update_specific_pw(){

        if ( $this->input->post('save')):
            
                $data = array(
                'password' => sha1($this->input->post('password'))
                );  

                $this->form_validation->set_rules('password', 'passthru(command)word', 'trim|required|min_length[5]|sha1');

                if ( $this->form_validation->run()) :                

                    //IF SUCCESSFULL UPDATE TO DATABASE
                   if( $this->db->update('cc_users', $data, 'id = '. $this->input->post('id').'') === TRUE) :

                        $data['update_success']    = $this->session->set_flashdata('update_success', 'You have successfully changed password.');                        

                        redirect('admin/users_update_pw/'. $this->input->post('id').'');

                    endif; // SUCCESS UPDATE DATABASE

                else:                    
                    
                    // IF VALIDATION FAILS, GO BACK TO THE USERS UPDATE PAGE
                    // WITH THE ERRORS                    
                    redirect('admin/users_update_pw/'. $this->input->post('id').'');
                endif; // PASSED THE VALIDATION

        endif; //IF POST SAVE
    }    

    
    /* ------- DELETE THE SPECIFIC USER ----------- */

    public function users_delete(){

        $query = $this->db->get('cc_users');

        if ( $query->num_rows() > 1 ) :

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

    public function user_profile(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->set_template('admin/profile_update');        

            $this->template->title = 'Profile page';

            $data['logged_info'] = $this->users_model->logged_in();
            $data['role'] = $this->users_model->check_role();

            $this->template->content->view('admin/admin_profile', $data);

            $this->template->publish();

        else:

            redirect('admin/restricted');

        endif;         


    }

}
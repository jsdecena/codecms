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
            redirect('admin/login');
        endif;

	}


    /* -------- LOGIN PAGE -------------------- */

	public function login(){

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
            $this->login();

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

            $data['logged_info']    = $this->users_model->logged_in();
            
            $this->template->content->view('admin/dashboard', $data);
            
            // publish the template
            $this->template->publish();

            $this->users_model->insert_identity();            

        else:

            redirect('admin/login');

        endif;        
    }

    /* ------- LOG OUT THE USER --------*/

    public function logout(){

        $this->users_model->logout_now();

        redirect('admin/login');

    }    

    /* -------- FOREGET PASSWORD PAGE -------------------- */

    public function forget_password(){

        $this->login();
    }

    /* INITIAL CHECKING OF THE FORGET PASSWORD FIELDS */
    public function forget_password_check() {

            //CREATES VALIDATION OF THE USER INPUT ON THE LOGIN FORM
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

            if ( $this->form_validation->run() ) :

                //IF SUCCESSFULL CHECKING THE EMAIL IN THE DATABASE IS EXISTING AND EMAIL IS SENT
                if ( $this->users_model->retrieve_password_check() ) :


                    $this->pw_key_check();

                    //echo "email existng in the db"; die();
                    $data['message_success']    = $this->session->set_flashdata('message_success', 'Password recovery link sent!. Please check your email.');
                    redirect('admin/forget_password');

                else :

                    //echo "email does not exist in the db"; die();

                    $data['message_error'] = $this->session->set_flashdata('message_error', 'This email is not existing in our records.');
                    redirect('admin/forget_password');

                endif;

            else :

                //echo "wrong email format"; die();
                $this->login();

            endif;
    }

    /* SENDING THE PASSWORD KEY TO THE EMAIL WHICH WILL BE USED TO VALIDATE USERS IDENTITY */
    public function pw_key_check(){

            $key = sha1(uniqid());

            $this->load->library('email', array('mailtype' => 'html'));
            
            $this->email->from('mobius19@live.com', 'Jeff Simons Decena');
            $this->email->to($this->input->post('email'));
            
            $this->email->subject('Password Recovery');
            
            $message = "You have requested for password recovery. <a href='". base_url("admin/get_pw/$key") ."'>Click here</a> to create a new password.";
            
            //$message = "hello";
            $this->email->message($message);
        
                if ( $this->email->send()) :

                    //INSERT THE VALUES TO THE DATABASE
                    //THIS COULD HAVE BEEN IN THE MODEL BUT ... LET IT STAY HERE FOR A WHILE
                    $this->db->set('pw_recovery', $key);
                    $this->db->update('cc_users');

                else :

                    //EMAIL IS NOT SENT
                    //echo "Not Sent!"; die();
                    $data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, we have problem sending your request.');
                    redirect('admin/forget_password');

                    return false;

                endif; //END CHECK FOR EMAIL IS SENT        
    }

    /* CHECK FOR THE CORRECT KEY MATCH OF THE KEY SENT TO THE USERS EMAIL WITH OUR RECORDS KEY */
    public function get_pw($key = FALSE){
        
        if ( isset($key)) :

            if ( $this->users_model->check_valid_keys($key) ):

                $this->create_new_pw($key);

            else :

                $data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, the key generated does not match to our record.');
                redirect('admin/forget_password');

            endif;

        else:

            redirect('admin/login');

        endif;            
    }    

    /* CREATE NEW PASSWORD PAGE */
    public function create_new_pw($key){

            $data['key'] = $key;

            $this->template->set_template('admin/template_login');

            $this->template->title = 'Create New Password';
            
            $this->template->content->view('admin/create_new_pw', $data);
            
            // publish the template
            $this->template->publish();

    }

    /* AFTER CREATING A NEW PASSWORD, INSERT IT TO THE DB */
    public function insert_new_pw(){

        $this->form_validation->set_rules('password', 'Password', 'trim|required|sha1');

        if ( $this->form_validation->run() ) :

            if ( $this->users_model->update_new_pw_in_db() ) :

                    //IF SUCCESSFULL INSERTION OF NEW PASSWORD
                    $data['message_success'] = $this->session->set_flashdata('message_success', 'You have successfully changed your password. Please login now.');
                    redirect('admin/login');           

            else :

                    //IF NOT SUCCESSFULL INSERTION OF NEW PASSWORD
                    $data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, we have problem changing your password. Please try again.');
                    redirect('admin/login');

            endif;

        else :

            //IF THE PASSWORD DOES NOT MATCH, THROW THE USER TO THE PASSWORD CREATION PAGE WITH THE ERROR
            $this->create_new_pw();

        endif;

    }    

    /*  ------- CREATE A USER ----------- */

    public function users_create(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->title  = 'User creation page';

            $data['logged_info']    = $this->users_model->logged_in();

            $this->template->content->view('users_create', $data);
            
            // publish the template
            $this->template->publish();

        else:

            redirect('admin/login');

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

            $this->template->content->view('users_list', $data);

            $this->template->publish();                       

        else:

            redirect('admin/login');

        endif;         

    }

    /* ------- UPDATE USER LIST PAGE ----------- */  

    public function users_update(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->title = 'User update page';

            $data['data'] = $this->users_model->users_query_specific();

            $data['logged_info'] = $this->users_model->logged_in();

            $this->template->content->view('users_update.php', $data);

            $this->template->publish();

        else:

           redirect('admin/login');

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

        //IF YOU GO DIRECTLY TO THIS PAGE, THROW THEM TO LOGIN PAGE
        redirect('admin/login');
    }

    /* ------- SPECIFIC USER PW PAGE ----------- */  

    public function users_update_pw(){        

        if ( $this->session->userdata('is_logged_in')) :             

            $this->template->title = 'User update page';

            $data['data']           = $this->users_model->users_query_specific();
            $data['logged_info']    = $this->users_model->logged_in();

            $this->template->content->view('users_update_pw.php', $data);


            $this->template->publish();

        else:

            //IF YOU GO DIRECTLY TO THIS PAGE, THROW THEM TO LOGIN PAGE
            redirect('admin/login');

        endif;         
    }    

    /* ------- UPDATE THE SPECIFIC USER'S PW ----------- */

    public function users_update_specific_pw(){

        if ( $this->input->post('save')):
            
                $data = array(
                    'password' => sha1($this->input->post('password'))
                );  

                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|sha1');

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

        //IF YOU GO DIRECTLY TO THIS PAGE, THROW THEM TO LOGIN PAGE
        redirect('admin/login');        
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


    /* ------- USER PROFILE ----------- */

    public function user_profile(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->set_template('admin/profile_update');        

            $this->template->title  = 'Profile page';

            $data['logged_info']    = $this->users_model->logged_in();

            $this->template->content->view('admin/admin_profile', $data);

            $this->template->publish();

        else:

            redirect('admin/login');

        endif;         


    }

}
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

class Admin_main extends CI_Controller {

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

        $this->template->set_template('admin/dashboard_tpl');
        $this->load->model('users_model');
        $this->load->model('posts_model');
        $this->load->library('form_validation');
    }

    /* ---------- START PAGE ------------------ */

	public function index(){

        if ( $this->session->userdata('is_logged_in')) :
            $this->dashboard();
        else:           
           redirect('admin/admin_main/login');
        endif;

	}


    /* -------- LOGIN PAGE -------------------- */

	public function login(){

		$this->template->set_template('admin/login_tpl');

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

            $user_details = $this->users_model->logged_in();

            //CHECK IF THE LOGGING IN USER IS AN ADMIN
            if ( $user_details['email'] == $this->input->post('email') && $user_details['role'] == 'admin' ) :                

                //FLASH USERDATA TO BE USED DURING LOGIN
                $data = array(
                    'email'         => $this->input->post('email'),
                    'is_logged_in'  => 1,
                    'role'          => 'admin'
                );                

            else:

                //FLASH USERDATA TO BE USED DURING LOGIN
                $data = array(
                    'email'         => $this->input->post('email'),
                    'is_logged_in'  => 1,
                    'role'          => 'subscriber'
                );                                

            endif;


            $this->session->set_userdata($data);
            
            redirect('admin/admin_main/dashboard');

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

            $this->template->title      = 'Dashboard';

            $data['logged_info']        = $this->users_model->logged_in();
            
            $this->template->content->view('admin/dashboard', $data);
            
            // publish the template
            $this->template->publish();

            $this->users_model->insert_identity();            

        else:
          redirect('admin/admin_main/login');

        endif;        
    }

    /* ------- LOG OUT THE USER --------*/

    public function logout( $data = ''){

        $this->users_model->logout_now();
      redirect('admin/admin_main/login');

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
                  redirect('admin/admin_main/forget_password');

                else :

                    //echo "email does not exist in the db"; die();
                    
                  redirect('admin/admin_main/forget_password');

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
            
            $message = "You have requested for password recovery. <a href='". base_url("admin/main/get_pw/$key") ."'>Click here</a> to create a new password.";
            
            //$message = "hello";
            $this->email->message($message);
        
                if ( $this->email->send()) :

                    //INSERT THE VALUES TO THE DATABASE
                    //THIS COULD HAVE BEEN IN THE MODEL BUT ... LET IT STAY HERE FOR A WHILE
                    $this->db->set('pw_recovery', $key);
                    $this->db->update('users');

                else :

                    //EMAIL IS NOT SENT
                    //echo "Not Sent!"; die();
                    $data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, we have problem sending your request.');
                    redirect('admin/admin_main/forget_password');

                    return false;

                endif; //END CHECK FOR EMAIL IS SENT        
    }

    /* CHECK FOR THE CORRECT KEY MATCH OF THE KEY SENT TO THE USERS EMAIL WITH OUR RECORDS KEY */
    public function get_pw($key = FALSE){
        
        if ( isset($key)) :

            if ( $this->users_model->check_valid_keys($key) ):

                $this->create_new_pw($key);

            else :
                
              redirect('admin/admin_main/forget_password');

            endif;

        else:
          redirect('admin/admin_main/login');

        endif;            
    }    

    /* CREATE NEW PASSWORD PAGE */
    public function create_new_pw($key){

            $data['key'] = $key;

            $this->template->set_template('admin/login_tpl');

            $this->template->title = 'Create New Password';
            
            $this->template->content->view('admin/users_create_new_pw', $data);
            
            // publish the template
            $this->template->publish();

    }

    /* AFTER CREATING A NEW PASSWORD, INSERT IT TO THE DB */
    public function insert_new_pw(){

        $this->form_validation->set_rules('password', 'Password', 'trim|required|sha1');

        if ( $this->form_validation->run() ) :

            if ( $this->users_model->update_new_pw_in_db() ) :

                    //IF SUCCESSFULL INSERTION OF NEW PASSWORD                    
                  redirect('admin/admin_main/login');           

            else :

                    //IF NOT SUCCESSFULL INSERTION OF NEW PASSWORD                    
                  redirect('admin/admin_main/login');

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

            $this->template->content->view('admin/users_create', $data);
            
            // publish the template
            $this->template->publish();

        else:
          redirect('admin/admin_main/login');

        endif;         

    }

    /* --------- CREATE A USER CHECKING -------- */

    public function users_create_check(){

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|sha1');
        $this->form_validation->set_rules('role','Role','required|callback_check_default');

        //CUSTOM MESSAGE FOR THE EMAIL THAT ALREADY EXIST IN THE DATABASE
        $this->form_validation->set_message('is_unique', 'The email you are creating already exists. Please use a different email.');

        //CUSTOM MESSAGE FOR THE ROLE TO BE CHOSEN FIRST.
        $this->form_validation->set_message('check_default', 'You must select role for the user.');

        if ( $this->form_validation->run()) :

            $data = array(
                'username'      => $this->input->post('username'),
                'first_name'    => $this->input->post('first_name'),
                'last_name'     => $this->input->post('last_name'),
                'email'         => $this->input->post('email'),
                'role'          => $this->input->post('role'),
                'is_logged_in'  => 0,
                'identity'      => 0,
                'password'      => $this->input->post('password')
            );

            //IF SUCCESSFULL INSERT TO DATABASE
            if( $this->db->insert('users', $data) === TRUE && $this->input->post('create')) :

                $data['create_success']    = $this->session->set_flashdata('create_success', 'You have successfully created a user.');
                $data['create_error']      = $this->session->set_flashdata('create_error', 'Sorry, we have a problem creating a user.');
              redirect('admin/admin_main/users_create');

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

            $this->template->content->view('admin/users_list', $data);

            $this->template->publish();                       

        else:
          redirect('admin/admin_main/login');

        endif;         

    }

    /* ------- UPDATE USER LIST PAGE ----------- */  

    public function users_update(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->title = 'User update page';

            $data['data'] = $this->users_model->users_query_specific();

            $data['logged_info'] = $this->users_model->logged_in();

            $this->template->content->view('admin/users_update', $data);

            $this->template->publish();                       

        else:
         redirect('admin/admin_main/login');

        endif;         
    }

    /* ------- UPDATE USER LIST PAGE ----------- */  

    public function users_update_by_admin(){

        if ( $this->session->userdata('is_logged_in')) :     

            $this->template->title = 'Admin User update page';

            $data['data'] = $this->users_model->users_query_specific();

            $data['logged_info'] = $this->users_model->logged_in();

            $this->template->content->view('admin/users_update_by_admin', $data);

            $this->template->publish();

        else:
         redirect('admin/admin_main/login');

        endif;         
    }    

    /* ------- UPDATE THE SPECIFIC USER ----------- */

    public function users_update_specific_check(){

        if ( $this->input->post('save')) :

                if ( $this->session->userdata('role') == 'admin') :
                    $this->form_validation->set_rules('role','Role','required|callback_check_default');
                    $this->form_validation->set_message('check_default', 'You must select a role.');
                endif;


                $this->form_validation->set_rules('about','About','trim|xss_clean');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');           

                if ( $this->form_validation->run() ) :                    

                    //IF PASSED THE VALIDATION AND SUCCESSFULL UPDATE TO DATABASE
                   if( $this->users_model->update_user() === TRUE) :

                        $data['message_success']    = $this->session->set_flashdata('message_success', 'Update successful.');
                        $data['message_error']      = $this->session->set_flashdata('message_error', 'Sorry, we have a problem updating a user.');

                        redirect('admin/admin_main/users_update' . '/' . $this->input->post('users_id') .' ', $data );

                    endif; // SUCCESS UPDATE DATABASE

                else:

                    $data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, you need to set the user role.');
                    
                    // IF VALIDATION FAILS, GO BACK TO THE USERS UPDATE PAGE                
                    redirect('admin/admin_main/users_update/'. $this->input->post('users_id').'');

                endif; // PASSED THE VALIDATION

        endif; //IF POST SAVE
        
      redirect('admin/admin_main/login');
    }

    /* ------- UPDATE THE SPECIFIC USER BY THE ADMIN ----------- */

    public function users_update_specific_by_admin(){        

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
                $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
                $this->form_validation->set_rules('role','Role','required|callback_check_default');
                $this->form_validation->set_message('check_default', 'You must select role for the user.');          

                if ( $this->form_validation->run()) :                

                    //IF SUCCESSFULL UPDATE TO DATABASE
                   if( $this->db->update('users', $data, 'users_id = '. $this->input->post('users_id').'') === TRUE) :

                        $data['message_success']    = $this->session->set_flashdata('message_success', 'Update successful.');
                        $data['message_error']      = $this->session->set_flashdata('message_error', 'Sorry, we have a problem updating a user.');
                      redirect('admin/admin_main/users_update_by_admin/'. $this->input->post('users_id').'');

                    endif; // SUCCESS UPDATE DATABASE
                else:

                    $data['message_error'] = $this->session->set_flashdata('message_error', 'Sorry, you need to set the user role.');
                    
                    // IF VALIDATION FAILS, GO BACK TO THE USERS UPDATE PAGE                    
                  redirect('admin/admin_main/users_update_by_admin/'. $this->input->post('users_id').'');
                endif; // PASSED THE VALIDATION
        endif; //IF POST SAVE
        
      redirect('admin/admin_main/login');
    }    

    /* ------- SPECIFIC USER PW PAGE ----------- */  

    public function users_update_pw(){        

        if ( $this->session->userdata('is_logged_in')) :             

            $this->template->title = 'User update page';

            $data['data']           = $this->users_model->users_query_specific();
            $data['logged_info']    = $this->users_model->logged_in();

            $this->template->content->view('admin/users_update_pw', $data);


            $this->template->publish();

        else:
            
          redirect('admin/admin_main/login');

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
                   if( $this->db->update('users', $data, 'users_id = '. $this->input->post('users_id').'') === TRUE) :

                        $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully changed password.');
                      redirect('admin/admin_main/users_update_pw/'. $this->input->post('users_id').'');

                    endif; // SUCCESS UPDATE DATABASE

                else:
                    
                    // IF VALIDATION FAILS, GO BACK TO THE USERS UPDATE PAGE
                    // WITH THE ERRORS

                    $data['message_error']    = $this->session->set_flashdata('message_error', 'You need to put a password.');
                  redirect('admin/admin_main/users_update_pw/'. $this->input->post('users_id').'');

                endif; // PASSED THE VALIDATION

        endif; //IF POST SAVE
        
      redirect('admin/admin_main/login');        
    }    

    
    /* ------- DELETE THE SPECIFIC USER ----------- */
    public function users_delete(){

        //CHECK IF YOU ARE DELETING A USER OTHER THAN YOU
        $current_user = $this->users_model->logged_in();

        foreach ( $current_user as $user_id ) :

            $cur_user_id = $user_id['users_id'];

            //CHECK IF YOU ARE DELETING YOUR OWN RECORD
            if ( $cur_user_id !== $this->uri->segment(4) ):        

                //IF NOT, CONTINUE DELETE IT.
                $this->users_model->delete_user();

                $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully deleted a user.');
                $data['message_error']      = $this->session->set_flashdata('message_error', 'Sorry, we have a problem deleting a user.');
                redirect('admin/admin_main/users_list', $data);

            else: //IF YES, THROW AN ERROR

                $data['message_error']      = $this->session->set_flashdata('message_error', 'Hey, do not delete your account from here.');
                redirect('admin/admin_main/users_list', $data);

            endif;            
            
        endforeach;

    }

    public function delete_account(){

        $this->users_model->delete_my_account();

        redirect('admin/admin_main/login');
    }


    /* ------- USER PROFILE ----------- */

    public function user_profile(){

        if ( $this->session->userdata('is_logged_in')) :

            $this->template->set_template('admin/profile_tpl');      

            $this->template->title  = 'Profile page';

            $data['logged_info']    = $this->users_model->logged_in();

            $this->template->content->view('admin/profile', $data);

            $this->template->publish();

        else:

          redirect('admin/admin_main/login');

        endif;
    }

    /* ------- END USER PROFILE ----------- */

    

    /* ------- SETTINGS PAGE ----------- */

    public function settings(){

        if ( $this->session->userdata('is_logged_in')) :                                

            $this->template->title      = 'Settings page';

            $data['logged_info']        = $this->users_model->logged_in();
            $data['pages']              = $this->posts_model->get_all_posts($post_type = 'page');
            $data['post_settings']      = $this->posts_model->view_post_settings();

            $this->template->content->view('admin/settings', $data);

            $this->template->publish();

        else:
          redirect('admin/admin_main/login');

        endif;
    }

    public function post_settings_check(){

            $this->form_validation->set_rules('post_page_chosen','Chosen Page for the posts','trim|xss_clean');
            $this->form_validation->set_rules('post_per_page','Show per page','trim|xss_clean|is_natural');
            $this->form_validation->set_rules('arrange_post_by','Arrange posts by','trim|xss_clean');
            $this->form_validation->set_rules('order_post_by','Order posts by','trim|xss_clean');

            if ( $this->form_validation->run()) :

                $this->posts_model->update_post_settings();              

                $data['message_success']    = $this->session->set_flashdata('message_success', 'You have successfully cofigured your post settings.');
              redirect('admin/admin_main/settings', $data);

            else:
                
              redirect('admin/admin_main/settings', $data);

            endif;        
    }

}
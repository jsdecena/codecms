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

class Users_model extends CI_Model {

    public $database            = 'codecms';
    public $posts_table         = 'posts';
    public $settings_table      = 'settings';
    public $users_table         = 'users';    

    function __construct() {
        
        // Call the Model constructor
        parent::__construct();
    }

    /* INSERT IDENTITY ON LOGIN */    
    function insert_identity(){

        $data = $this->session->all_userdata();

        foreach ($data as $udata) {
            
            $user_identity = array( 'identity' => sha1($udata), 'is_logged_in' => 1, 'last_login' => time($this->session->userdata('last_activity')) );
        }

        $this->db->get_where('users', array('email' => $this->session->userdata('email')));
        $this->db->update('users', $user_identity);

    }    

    /* CHECK IF THE PASSWORD AND EMAIL MATCHED THE RECORD IN THE DB */
	function login_allowed(){

        //CHECK IN THE DATABASE THE USERNAME AND PASSWORD COMBINATION
        $query = $this->db->get_where('users', array( 'email' => $this->input->post('email'), 'password' => sha1($this->input->post('password')) ));

		if ( $query->num_rows() == 1 ) :
			return TRUE;
		else:
			return FALSE;
		endif;

	} // END LOGIN ALLOWED


	/* READING THE USERS LIST */
	function users_query_list(){
        
        $query = $this->db->get('users');

        if ( $query->num_rows() > 0 ) :
            
            return $users_list = $query->result_array();

        endif;
	}

    /* UPDATE THE SPECIFIC USER */
    function users_query_specific() {

        $query = $this->db->get_where('users', array('users_id' => $this->uri->segment(4,0)));

        if ( $query->num_rows() > 0 ) :

            $data = $query->result();

            return $data;

        endif;
    }

    /* RETRIEVES THE CURRENT USER INFORMATION */
    function logged_in() {

        $query = $this->db->get_where('users', array('email' => $this->session->userdata('email')));

        if($query->num_rows() > 0):
            
            foreach ($query->result_array() as $row) :
            
                $data = $row;

            endforeach;

            return $data;

        endif;
    }

    /*CHECKING FOR THE CURRENT USER IF LOGGED IN OR NOT*/
    function logged_in_check(){
        
        //CHECK IF THE USER IS LOGGED IN
        $query = $this->db->get_where('users', array('email' => $this->session->userdata('email'), 'is_logged_in' => 1));

        if($query->num_rows() == 1):

            return TRUE;

        else:

            return FALSE;

        endif;

    }

    /*UPDATE THE USER*/
    function update_user(){

        //CHECK IF WE ARE UPDATING AN ADMIN OR A SUBSCRIBER
        if ( $this->session->userdata('role') == 'admin' ) :
        
            $data = array(
                'username'          => $this->input->post('username'),
                'first_name'        => $this->input->post('first_name'),
                'last_name'         => $this->input->post('last_name'),
                'email'             => $this->input->post('email'),
                'role'              => $this->input->post('role'),
                'about'             => $this->input->post('about')
            );

        else:

            $data = array(
                'username'          => $this->input->post('username'),
                'first_name'        => $this->input->post('first_name'),
                'last_name'         => $this->input->post('last_name'),
                'email'             => $this->input->post('email'),
                'role'              => 'subscriber',
                'about'             => $this->input->post('about')
                );
        endif;

        $this->db->where('users_id', $this->input->post('users_id'));
        $this->db->update($this->users_table, $data);

        return TRUE;          
    }

    /* LOGS OUT A USER */
    function logout_now() {

        $this->db->set('identity', 0 );
        $this->db->set('is_logged_in', 0 );
        $this->db->update('users');

        $this->session->sess_destroy();
    }

    /* FORGOT PASSWORD CHECKING FOR THE EXISTING EMAIL OF THE USER. */
    function retrieve_password_check(){

        $query = $this->db->get_where('users', array('email' => $this->input->post('email')));

        if($query->num_rows() > 0) :

             //EMAIL EXISTING
            return TRUE;

        else :

             //EMAIL NOT EXISTING
            return FALSE;

        endif;

    }

    /* CHECK FOR THE VALID KEY THAT WAS RETURNED FROM THE EMAIL */
    function check_valid_keys($key){

       $query = $this->db->get_where('users', array('pw_recovery' => $key));

        if($query->num_rows() > 0) :

            //HOUSTON, WE FOUND A MATCH!
            return TRUE;

        else :

            //HOUSTON, WE HAVE A PROBLEM WITH THE GENERATED KEY!
            return FALSE;

        endif;

    }

    /* UPDATE THE USERS PASSWORD CONSIDERING THAT THE KEY FROM THE EMAIL IS VALID. */
    function update_new_pw_in_db(){

        $query = $this->db->get_where('users', array('pw_recovery' => $this->input->post('key')));

        if($query->num_rows() == 1) :

            //HOUSTON, WE FOUND A MATCH! LET'S UPDATE THIS USERS NEW PASSWORD
            $this->db->set('password', $this->input->post('password') ); 
            $this->db->update('users');
            return TRUE;

        else :

            //HOUSTON, WE HAVE A PROBLEM IN UPDATING THE USER'S PASSWORD
            return FALSE;

        endif;
    }

    function delete_user(){

        $this->db->where('users_id', $this->uri->segment(4));
        $this->db->delete($this->users_table);

        return TRUE;

    }

    function delete_my_account(){

        $this->db->where('users_id', $this->input->post('delete_account'));
        $this->db->delete($this->users_table);

        return TRUE;        

    }
} //END USERS_MODEL
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model { 


    /* INSERT IDENTITY ON LOGIN */    
    public function insert_identity(){

        $data = $this->session->all_userdata();

        foreach ($data as $udata) {
            
            $user_identity = array( 'identity' => sha1($udata), 'is_logged_in' => 1 );
        }

        $this->db->get_where('cc_users', array('email' => $this->session->userdata('email')));
        $this->db->update('cc_users', $user_identity);

    }    

    /* CHECK IF THE PASSWORD AND EMAIL MATCHED THE RECORD IN THE DB */
	public function login_allowed(){

        //CHECK IN THE DATABASE THE USERNAME AND PASSWORD COMBINATION
        $query = $this->db->get_where('cc_users', array( 'email' => $this->input->post('email'), 'password' => sha1($this->input->post('password')) ));

		if ( $query->num_rows() == 1 ) :
			return true;
		else:
			return false;
		endif;

	} // END LOGIN ALLOWED


	/* READING THE USERS LIST */
	public function users_query_list(){
        
        $query = $this->db->get('cc_users');

        if($query->num_rows() > 0):
            foreach ($query->result_array() as $row):
                $data[] = $row;
            endforeach;

            return $data;
        else:
            return false;
        endif;
	}

    /* UPDATE THE SPECIFIC USER */
    public function users_query_specific(){

        $query = $this->db->get_where('cc_users', array('id' => $this->uri->segment(3,0)));

        foreach ($query->result() as $row){   
            $data[] = $row;
        }
        return $data;
    }

    /* RETRIEVES THE CURRENT USER INFORMATION */
    public function logged_in(){

        $query = $this->db->get_where('cc_users', array('email' => $this->session->userdata('email')));

        if($query->num_rows() > 0):
            foreach ($query->result_array() as $row) :
                $data = $row;
            endforeach;

            return $data;

        endif;
    }

    /* LOGS OUT A USER */
    public function logout_now(){

        $query = $this->db->get_where('cc_users', array('email' => $this->session->userdata('email')));

         if($query->num_rows() > 0) :

            $data = array('identity' => 0, 'is_logged_in' => 0 );

         endif;

         $this->db->update('cc_users', $data);

         $this->session->sess_destroy();
    }

    /* FORGOT PASSWORD CHECKING FOR THE EXISTING EMAIL OF THE USER. */
    public function retrieve_password_check(){

        $query = $this->db->get_where('cc_users', array('email' => $this->input->post('email')));

        if($query->num_rows() > 0) :

             //EMAIL EXISTING
            // echo "found!"; die();
            return true;

        else :

             //EMAIL NOT EXISTING
            //echo "not exiting"; die();
            return false;

        endif;

    }

    /* CHECK FOR THE VALID KEY THAT WAS RETURNED FROM THE EMAIL */
    public function check_valid_keys($key){

       $query = $this->db->get_where('cc_users', array('pw_recovery' => $key));

        if($query->num_rows() > 0) :

            //HOUSTON, WE FOUND A MATCH!
            return true;

        else :

            //HOUSTON, WE HAVE A PROBLEM WITH THE GENERATED KEY!
            return false;

        endif;

    }

    /* UPDATE THE USERS PASSWORD CONSIDERING THAT THE KEY FROM THE EMAIL IS VALID. */
    public function update_new_pw_in_db(){

        $query = $this->db->get_where('cc_users', array('pw_recovery' => $this->input->post('key')));

        if($query->num_rows() == 1) :

            //HOUSTON, WE FOUND A MATCH! LET'S UPDATE THIS USERS NEW PASSWORD
            $this->db->set('password', sha1($this->input->post('password')) ); 
            $this->db->update('cc_users');
            return true;

        else :

            //HOUSTON, WE HAVE A PROBLEM IN UPDATING THE USER'S PASSWORD
            return false;

        endif;
    }

} //END USERS_MODEL
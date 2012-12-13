<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model { 

    public function insert_identity(){

        $data = $this->session->all_userdata();

        foreach ($data as $udata) {
            
            $user_identity = array( 'identity' => sha1($udata), 'is_logged_in' => 1 );
        }

        $this->db->get_where('cc_users', array('email' => $this->session->userdata('email')));
        $this->db->update('cc_users', $user_identity);

    }    

	public function login_allowed(){

        $query = $this->db->get_where('cc_users', array( 'email' => $this->input->post('email'), 'password' => sha1($this->input->post('password')) ));

		if ( $query->num_rows() == 1 ) :
			return true;
		else:
			return false;
		endif;

	} // END LOGIN ALLOWED


	//READING THE USERS LIST
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

    /*

    UPDATE THE SPECIFIC USER

    */

    public function users_query_specific(){

        $query = $this->db->get_where('cc_users', array('id' => $this->uri->segment(3,0)));

        foreach ($query->result() as $row){   
            $data[] = $row;
        }
        return $data;
    }

    /*

    RETRIEVES THE CURRENT USER

    */
    public function logged_in(){

        $query = $this->db->get_where('cc_users', array('email' => $this->session->userdata('email')));

        if($query->num_rows() > 0):
            foreach ($query->result() as $row) :
                $data = $row;
            endforeach;

            return $data;

        endif;
    }

    public function logout_now(){

        $query = $this->db->get_where('cc_users', array('email' => $this->session->userdata('email')));

         if($query->num_rows() > 0):

            $data = array('identity' => 0, 'is_logged_in' => 0 );

         endif;

         $this->db->update('cc_users', $data);

         $this->session->sess_destroy();

    }

    public function check_role(){

        $query = $this->db->get_where('cc_users', array('email' => $this->session->userdata('email')));

        foreach ($query->result() as $row) :
            $role = $row->role;
        endforeach;

        return $role;             

    }

} //END USERS_MODEL
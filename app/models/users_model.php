<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model { 

	public function login_allowed(){

		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('cc_users');

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
            return $row;
        endif;
    }

} //END USERS_MODEL
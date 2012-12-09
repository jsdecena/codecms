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

    public function users_query_specific(){

        $query = $this->db->query('SELECT * FROM cc_users WHERE id = ' . $this->uri->segment(3,0) .''); 

        foreach ($query->result() as $row){   
            $data[] = $row;
        }
        return $data;
    }

/*	public function users_query_update($data){
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('cc_users', $data);
	}*/

} //END USERS_MODEL
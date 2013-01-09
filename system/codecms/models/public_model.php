<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Public_model extends CI_Model {	

	//START PAGES ------------------------------------------------------------------------------------------------------------------------------------------------------
	public function get_all_pages(){

		$query = $this->db->get('pages');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		else :

			return false;

		endif;


	}	

	public function get_page(){

		//GET THE SPECIFIC PAGE
		$query = $this->db->get_where('pages', array( 'slug' => $this->uri->segment(1) ));
		
		if($query->num_rows() > 0):

			//IF A PAGE IS FOUND DISPLAY THE DATA WITH IT
			foreach ($query->result() as $row) :
			    
			    $page = $row;

			endforeach;
			
			return $page;

		endif;

	}

	public function count_all_pages(){

		$query = $this->db->count_all_results('pages');

		return $query;

	}

	//CHECK FOR THE PAGE THAT WILL SHOW ALL THE POSTS. THIS IS SET IN THE DATABASE BY THE SETTINGS.
	public function check_post_page(){

		$query = $this->db->get('cc_settings');

		if ( $query->num_rows() > 0 ) :

			foreach ($query->result_array() as $value) :
				
				return $value;

			endforeach;

		endif;	

	}



	//START POSTS ------------------------------------------------------------------------------------------------------------------------------------------------------
	public function get_all_posts($order ='post_id', $asc_desc ='DESC', $limit = '0,18446744073709551615'){

		$db = $this->db->dbprefix('posts');

		$query = $this->db->query(' SELECT * FROM '. $db .' ORDER BY '. $order .' '. $asc_desc .' LIMIT '. $limit .'');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;

	}	

    public function view_post(){

        $query = $this->db->get_where('posts', array('slug' => $this->uri->segment(3,0)), 1);
		
		if($query->num_rows() == 1):

 			return $query->row();

		endif;
    } 	

	public function count_all_posts(){

		$query = $this->db->count_all_results('posts');

		return $query;

	}

}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Public_model extends CI_Model {

    function __construct() {
        
        // Call the Model constructor
        parent::__construct();
    }		

	//START PAGES ------------------------------------------------------------------------------------------------------------------------------------------------------
	function get_all_pages(){

		$query = $this->db->get('pages');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		else :

			return false;

		endif;


	}	

	function get_page(){

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

	function count_all_pages(){

		$query = $this->db->count_all_results('pages');

		return $query;

	}

	//CHECK FOR THE PAGE THAT WILL SHOW ALL THE POSTS. THIS IS SET IN THE DATABASE BY THE SETTINGS.
	function check_post_page(){

		$query = $this->db->get('cc_settings');

		if ( $query->num_rows() > 0 ) :

			foreach ($query->result_array() as $value) :
				
				return $value;

			endforeach;

		endif;	

	}



	//START POSTS ------------------------------------------------------------------------------------------------------------------------------------------------------
	function get_all_posts($order_by ='post_id', $arrange_by ='desc', $limit = 10, $offset = 0){

		$query = $this->db->get('posts', $limit, $offset);

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;

	}	

    function view_post(){

        $query = $this->db->get_where('posts', array('slug' => $this->uri->segment(3,0)), 1);
		
		if($query->num_rows() == 1):

 			return $query->row();

		endif;
    } 	

	function count_all_posts(){

		$query = $this->db->count_all_results('posts');

		return $query;

	}

}
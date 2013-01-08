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



	//START POSTS ------------------------------------------------------------------------------------------------------------------------------------------------------
	public function get_all_posts(){

		$query = $this->db->get('posts');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		else :

			return false;

		endif;


	}	

    public function view_post($slug){

        $query = $this->db->get_where('posts', array('slug' => $this->uri->segment(2)), 1);
		
		if($query->num_rows() == 1):

			var_dump($query->row()); die();

 			return $query->row();

		endif;
    } 	

	public function count_all_posts(){

		$query = $this->db->count_all_results('posts');

		return $query;

	}	

}
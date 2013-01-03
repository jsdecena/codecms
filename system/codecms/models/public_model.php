<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Public_model extends CI_Model {

	//START PAGES ------------------------------------------------------------------------------------------------------------------------------------------------------
	public function get_all_pages(){

		$query = $this->db->get('pages');

		if($query->num_rows() > 0):

			foreach ($query->result_array() as $row) :
			   $page_list[] = $row;
			endforeach;

			return $page_list;

		else:

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

		if($query->num_rows() > 0):

			foreach ($query->result_array() as $row) :
			   $post_list[] = $row;
			endforeach;

			return $post_list;

		else:

			return false;
		
		endif;


	}	

	public function show_post( $post_id ){

		$query = $this->db->get_where('posts', array( 'post_id' => $post_id ));
		
		if($query->num_rows() > 0):

			//IF A post IS FOUND DISPLAY THE DATA WITH IT
			foreach ($query->result() as $row) :
			    
			    $post = $row;

			endforeach;
			
			return $post;

		endif;		
	}

	public function count_all_posts(){

		$query = $this->db->count_all_results('posts');

		return $query;

	}	

}
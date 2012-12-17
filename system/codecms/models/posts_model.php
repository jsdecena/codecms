<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {

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

	public function get_specific_post(){

		$query = $this->db->get_where('posts', array( 'post_id' => $this->uri->segment(4) ));
		
		if($query->num_rows() == 1):

			//IF A post IS FOUND DISPLAY THE DATA WITH IT
			foreach ($query->result() as $row) :
			    $post = $row;		
			endforeach;
			
			return $post;

		endif;		
	}

	public function insert_created_post(){

			$data = array(
			   'title' 		=> $this->input->post('title'),
			   'content' 	=> $this->input->post('content'),
			   'slug' 		=> $this->input->post('slug')
			);

			$this->db->insert('posts', $data);	
	}

	public function insert_edited_post(){

		$data = array(
			'title' 	=> $this->input->post('title'),
			'content' 	=> $this->input->post('content'),
			'slug' 		=> $this->input->post('slug')
		);

		$this->db->where('post_id', $this->input->post('id'));
		$this->db->update('posts', $data); 
	}

	public function count_all_posts(){

		$query = $this->db->count_all_results('posts');

		return $query;

	}	
}
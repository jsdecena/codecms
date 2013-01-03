<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {

	public $post_id;
	public $title;
	public $content;
	public $created;

	public function get_all_posts(){

		$query = $this->db->get('posts');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		else :

			return false;

		endif;

	}

	public function get_post(){

		$query = $this->db->get_where('posts', array( 'post_id' => $this->uri->segment(4) ));
		
		if($query->num_rows() == 1):

 			return $query->row();

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

	public function update_edited_post(){

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
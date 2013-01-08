<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {

	public function get_all_posts(){

		$query = $this->db->get('posts');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		else :

			return false;

		endif;

	}

	public function get_post($post_id){

		//$query = $this->db->get_where('posts', array( 'post_id' => $this->uri->segment(4) ));

		$post_id = $this->uri->segment(4);

		$query = $this->db->get_where('posts', array( 'post_id' => $post_id ));
		
		if($query->num_rows() == 1):

 			return $query->row();

		endif;		
	}	

	public function insert_post(){

			$data = array(
			   'title' 		=> $this->input->post('title'),
			   'content' 	=> $this->input->post('content'),
			   'slug' 		=> url_title($this->input->post('title'))
			);
			//var_dump($data); die();

			$this->db->insert('posts', $data);
	}

	public function update_post(){

		$data = array(
			'title' 	=> $this->input->post('title'),
			'content' 	=> $this->input->post('content'),
			'slug' 		=> url_title($this->input->post('title'))
		);

		$this->db->where('post_id', $this->input->post('id'));
		$this->db->update('posts', $data); 
	}

	public function count_all_posts(){

		$query = $this->db->count_all_results('posts');

		return $query;

	}	
}
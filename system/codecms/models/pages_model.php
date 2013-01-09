<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends CI_Model {

	public function get_all_pages(){

		$query = $this->db->get('pages');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;

	}

	public function get_specific_page(){

		$query = $this->db->get_where('pages', array( 'page_id' => $this->uri->segment(4) ));
		
		if($query->num_rows() == 1):

			//IF A PAGE IS FOUND DISPLAY THE DATA WITH IT
			foreach ($query->result() as $row) :
			    $page = $row;		
			endforeach;
			
			return $page;

		endif;		
	}

	public function insert_created_page(){

			$data = array(
			   'title' 			=> $this->input->post('title'),
			   'content' 		=> $this->input->post('content'),
			   'slug' 			=> $this->input->post('slug'),
			   'date_add'		=> date("Y-m-d H:i:s")
			);

			$this->db->insert('pages', $data);	
	}

	public function insert_edited_page(){

		$data = array(
			'title' 	=> $this->input->post('title'),
			'content' 	=> $this->input->post('content'),
			'slug' 		=> $this->input->post('slug')
		);

		$this->db->where('page_id', $this->input->post('id'));
		$this->db->update('pages', $data); 
	}

	public function count_all_pages(){

		$query = $this->db->count_all_results('pages');

		return $query;

	}

}
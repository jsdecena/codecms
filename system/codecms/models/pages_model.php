<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends CI_Model {

    function __construct() {
        
        // Call the Model constructor
        parent::__construct();
    }		

	function get_all_pages(){

		$query = $this->db->get('pages');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;

	}

	function get_specific_page(){

		$query = $this->db->get_where('pages', array( 'page_id' => $this->uri->segment(4) ));
		
		if($query->num_rows() == 1):

			//IF A PAGE IS FOUND DISPLAY THE DATA WITH IT
			foreach ($query->result() as $row) :
			    $page = $row;		
			endforeach;
			
			return $page;

		endif;		
	}

	function insert_page(){

			$data = array(
			   'title' 			=> $this->input->post('title'),
			   'content' 		=> $this->input->post('content'),
			   'slug' 			=> $this->input->post('slug'),
			   'status' 		=> $this->input->post('status'),
			   'date_add'		=> date("Y-m-d H:i:s")
			);

			$this->db->insert('pages', $data);	
	}

	function get_page_id() {

		$query = $this->db->get_where('pages', array( 'title' => $this->input->post('title') ));

		$create_page_id = $query->row('page_id');

		return $create_page_id;

	}	

	function insert_edited_page(){

		$data = array(
			'title' 	=> $this->input->post('title'),
			'content' 	=> $this->input->post('content'),
			'slug' 		=> $this->input->post('slug'),
			'status' 	=> $this->input->post('status')
		);

		$this->db->where('page_id', $this->input->post('id'));
		$this->db->update('pages', $data); 
	}

	function count_all_pages(){

		$query = $this->db->count_all_results('pages');

		return $query;
	}

	//SINGLE DELETE
	function delete_page() {

		$this->db->delete('pages', array('page_id' => $this->input->post('page_id')));

		return true;
	}

	//MULTIPLE DELETE
	function delete_page_selection($id) {

	    $this->db->where_in('page_id', $id)->delete('pages');

		return true;
	}	

}
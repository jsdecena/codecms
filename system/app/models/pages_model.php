<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends CI_Model {

	public function get_static_page(){

		$query = $this->db->get_where('pages', array( 'slug' => $this->uri->segment(1) ));
		
		if($query->num_rows() > 0):

			$pages = array();
			//IF A PAGE IS FOUND DISPLAY THE DATA WITH IT
			foreach ($query->result() as $row) :
			    $pages = $row;			
			endforeach;
			
			return $pages;

		endif;		
	}

}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Controller {

	function update_settings() {

		echo "WTF!"; die();

		/*$data = array(
		           'post_page_chosen' 	=> $this->input->post('post_page_chosen'),
		           'post_per_page' 		=> $this->input->post('post_per_page'),
		           'arrange_post_by' 	=> $this->input->post('arrange_post_by'),
		           'order_post_by' 		=> $this->input->post('order_post_by')
		            );
		
		$this->db->update('settings', $data, array('id' => $id));	            		*/
		//$this->db->update('settings', $data);		

	}

	function check_settings(){

		$query = $this->db->get('cc_settings');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		else :

			return false;

		endif;	
	}
}
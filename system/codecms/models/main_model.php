<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Controller {

	function insert_settings() {

		//HOW TO INSERT A KEY VALUE COMBO IN THE DB??????
		$data = array(
		               'post_page_chosen' 	=> $this->input->post('post_page_chosen'),
		               'post_per_page' 		=> $this->input->post('post_per_page'),
		               'arrange_post_by' 	=> $this->input->post('arrange_post_by'),
		               'order_post_by' 		=> $this->input->post('order_post_by')
		            );

		$this->db->update('cc_config', $data);

	}

	function check_settings(){

		$query = $this->db->get('cc_config');

		if($query->num_rows() > 0):

			foreach ($query->result_array() as $row) :				
			   $settings[] = $row;
			endforeach;

			//echo "<pre>";
			//var_dump($settings); die();

			return $settings;

		else:

			return false;
		
		endif;		
	}
}
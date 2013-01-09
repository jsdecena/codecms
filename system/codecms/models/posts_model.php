<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {

	public function get_all_posts($order ='post_id', $asc_desc ='DESC', $limit = '0,18446744073709551615'){

		$db = $this->db->dbprefix('posts');

		$query = $this->db->query(' SELECT * FROM '. $db .' ORDER BY '. $order .' '. $asc_desc .' LIMIT '. $limit .'');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;

	}

	public function get_post($post_id){

		$post_id = $this->uri->segment(4);

		$query = $this->db->get_where('posts', array( 'post_id' => $post_id ));
		
		if($query->num_rows() == 1):

 			return $query->row();

		endif;		
	}	

	public function insert_post(){

			$query = $this->db->get_where('users', array( 'email' => $this->session->userdata('email') ));

			$author = $query->row();		

			$data = array(
				'users_id' 		=> $author->users_id,
			   	'title' 		=> $this->input->post('title'),
			   	'content' 		=> $this->input->post('content'),
			   	'slug' 			=> strtolower(url_title($this->input->post('title'))),
			   	'author' 		=> $author->first_name ." ". $author->last_name,
			   	'date_add'		=> date("Y-m-d H:i:s")
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

	public function update_post_settings() {

		$data = array(
		    array(
		        'settings_id' 		=> 1,
		        'settings_name' 	=> 'post_page_chosen',
		        'settings_value' 	=> $this->input->post('post_page_chosen')
		    ),
		    array(
		        'settings_id' 		=> 2,
		        'settings_name'		=> 'post_per_page',
		        'settings_value' 	=> $this->input->post('post_per_page')
		    ),
		    array(
		        'settings_id' 		=> 3,
		        'settings_name' 	=> 'arrange_post_by',
		        'settings_value' 	=> $this->input->post('arrange_post_by')
		   	),
		   	array(
		        'settings_id' 		=> 4,
		        'settings_name' 	=> 'order_post_by',
		        'settings_value' 	=> $this->input->post('order_post_by')
		   	)		    
		);

		$this->db->update_batch('settings', $data, 'settings_id');

	}

	public function view_post_settings() {

		$query = $this->db->get('settings');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;	
	}	
}
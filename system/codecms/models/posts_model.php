<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {

    function __construct() {
        
        // Call the Model constructor
        parent::__construct();
    }	

	function get_all_posts($order_by ='post_id', $arrange_by ='desc', $limit = 10, $offset = 0){

		$this->db->select('*')->from('posts')->order_by($order_by , $arrange_by)->limit($limit, $offset);
		
		$query = $this->db->get();

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;

	}

	function get_post($post_id){

		$post_id = $this->uri->segment(4);

		$query = $this->db->get_where('posts', array( 'post_id' => $post_id ));
		
		if($query->num_rows() == 1):

 			return $query->row();

		endif;		
	}	

	function insert_post(){

			$query = $this->db->get_where('users', array( 'email' => $this->session->userdata('email') ));

			$author = $query->row();		

			$data = array(
				'users_id' 		=> $author->users_id,
			   	'title' 		=> $this->input->post('title'),
			   	'content' 		=> $this->input->post('content'),
			   	'slug' 			=> strtolower(url_title($this->input->post('title'))),
			   	'author' 		=> $author->first_name ." ". $author->last_name,
			   	'status'		=> $this->input->post('status'),
			   	'date_add'		=> date("Y-m-d H:i:s")
			);

			$this->db->insert('posts', $data);
	}


	function get_post_id() {

		$query = $this->db->get_where('posts', array( 'title' => $this->input->post('title') ));

		$create_post_id = $query->row('post_id');

		return $create_post_id;

	}
	function update_post(){

		$data = array(
			'title' 	=> $this->input->post('title'),
			'status' 	=> $this->input->post('status'),
			'content' 	=> $this->input->post('content'),
			'slug' 		=> url_title($this->input->post('title'))
		);

		$this->db->where('post_id', $this->input->post('post_id'));
		$this->db->update('posts', $data); 
	}

	//SINGLE DELETE
	function delete_post() {

		$this->db->delete('posts', array('post_id' => $this->input->post('post_id')));

		return true;
	}

	//MULTIPLE DELETE
	function delete_post_selection($id) {

	    $this->db->where_in('post_id', $id)->delete('posts');

		return true;
	}

	function count_all_posts(){

		$query = $this->db->count_all_results('posts');
		
		return $query;

	}		

	function update_post_settings() {

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

	function view_post_settings() {

		$query = $this->db->get('settings');

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;	
	}	
}
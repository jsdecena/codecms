<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeCMS an alternative responsive open source cms made from Philippines.
 *
 * @package     CodeCMS
 * @author      @jsd
 * @copyright   Copyright (c) 2013
 * @license     http://creativecommons.org/licenses/by-sa/3.0/deed.en_US
 * @link        https://bitbucket.org/jsdecena/codecms
 * @since       Version 0.1
 * 
 */

class Posts_model extends CI_Model {	

	public $database 			= 'codecms';
	public $posts_table 		= 'posts';
	public $settings_table 		= 'settings';
	public $users_table 		= 'users';

    function __construct() {
        
        // Call the Model constructor
        parent::__construct();        
    }	

	/* ===============================================================	BACK END =============================================================== */

    //LIST ALL THE POSTS
	function get_all_posts($post_type = 'post', $order_by ='post_id', $arrange_by ='desc', $limit = 10, $offset = 0){		

		$this->db->select('*')->from('posts')->where('post_type', $post_type)->order_by($order_by , $arrange_by)->limit($limit, $offset);
		
		$query = $this->db->get();

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;

	}

	//WHEN POST ID AS ALREADY CREATED AND CAN BE RETRIEVE IN THE URI SEGMENT
	function get_post($post_id){

		$query = $this->db->get_where($this->posts_table, array( 'post_id' => $post_id ));
		
		if($query->num_rows() == 1):

 			return $query->row();

		endif;		
	}

	function get_page(){

		$post_title = $this->uri->segment(3);	

		$query = $this->db->get_where($this->posts_table, array( 'slug' => $post_title ));
		
		if($query->num_rows() == 1):

 			return $query->row();

		endif;		
	}	

	//WHEN THE ID IS NOT YET AVAILABLE FOR QUERY. GET THE MATCH ON THE TITLE IN THE DB TO GET ITS ID
	function get_post_id() {

		$query = $this->db->get_where($this->posts_table, array( 'title' => $this->input->post('title') ));

		return $query->row('post_id');

	}	

	function insert_post(){

		$query = $this->db->get_where('users', array( 'email' => $this->session->userdata('email') ));

		$author = $query->row();		

		$data = array(
			'post_type'		=> $this->input->post('post_type'),
			'users_id' 		=> $author->users_id,
		   	'title' 		=> $this->input->post('title'),
		   	'content' 		=> $this->input->post('content'),
		   	'slug' 			=> strtolower(url_title($this->input->post('title'))),
		   	'author' 		=> $author->first_name ." ". $author->last_name,
		   	'status'		=> $this->input->post('status'),
		   	'date_add'		=> date("Y-m-d H:i:s")
		);		

		$this->db->insert($this->posts_table, $data);

		return TRUE;		
	}

	function update_post(){

		$data = array(
			'title' 	=> $this->input->post('title'),
			'status' 	=> $this->input->post('status'),
			'content' 	=> $this->input->post('content'),
			'slug' 		=> strtolower(url_title($this->input->post('title'))),
		);

		$this->db->where('post_id', $this->input->post('post_id'));
		$this->db->update($this->posts_table, $data);
	}


	//QUICK UPDATE A POST TYPE ( PAGE OR POST )
	function quick_update(){
		
		$data = array(
			'status' => $this->input->post('status'),
			'post_type' => $this->input->post('post_type')
		);

		$this->db->where('post_id', $this->input->post('post_id'));
		$this->db->update($this->posts_table, $data);
		
		return true;
	}

	//SINGLE POST DELETE
	function delete_post() {

		if ( $this->input->post('delete_post') ) :
			
			//DELETE A POST
			$this->db->delete('posts', array('post_id' => $this->input->post('delete_post')));

		else:
		
			//DELETE A PAGE
			$this->db->delete('posts', array('post_id' => $this->input->post('delete_page')));

		endif;
		

		return true;
	}

	//MULTIPLE DELETE
	function delete_post_selection($selectedIds) {

	    $this->db->where_in('post_id', $selectedIds)->delete('posts');

		return true;
	}

	//COUNT ALL POSTS
	function count_all_posts(){

		$this->db->count_all_results('posts');
		$this->db->from('posts');
		$this->db->where('post_type', 'post');
		
		$query = $this->db->get();
		
		if ( $query->num_rows() > 0) :			
			return $query->num_rows();
		endif;

	}
	
	//COUNT ALL PAGES
	function count_all_pages(){

		$this->db->count_all_results('posts');
		$this->db->from('posts');
		$this->db->where('post_type', 'page');
		
		$query = $this->db->get();		
		
		if ( $query->num_rows() > 0) :
			return $query->num_rows();
		endif;

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

	//CHECK FOR THE PAGE THAT WILL SHOW ALL THE POSTS. THIS IS SET IN THE DATABASE BY THE SETTINGS.
	function check_post_page(){

		$query = $this->db->get('cc_settings');

		if ( $query->num_rows() > 0 ) :

			foreach ($query->result_array() as $value) :
				
				return $value;

			endforeach;

		endif;	

	}

	/* ===============================================================	FRONT END =============================================================== */
	
    function view_post(){

        $query = $this->db->get_where('posts', array('slug' => $this->uri->segment(3,0)), 1);
		
		if($query->num_rows() == 1):

 			return $query->row();

		endif;
    }	
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {	

	protected $database 			= 'codecms';
	protected $posts_table 			= 'posts';
	protected $settings_table 		= 'settings';
	protected $users_table 			= 'users';

    function __construct() {
        
        // Call the Model constructor
        parent::__construct();        
    }	

	/* ===============================================================	BACK END =============================================================== */

    //LIST ALL THE POSTS
	function get_all_posts($order_by ='post_id', $arrange_by ='desc', $limit = 10, $offset = 0){

		//echo $this->$posts_table; die();

		$this->db->select('*')->from('posts')->where('post_type', 'post')->order_by($order_by , $arrange_by)->limit($limit, $offset);
		
		$query = $this->db->get();

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;

	}

	//LIST ALL THE PAGES
	function get_all_pages($order_by ='post_id', $arrange_by ='desc', $limit = 10, $offset = 0){

		$this->db->select('*')->from('posts')->where('post_type', 'page')->order_by($order_by , $arrange_by)->limit($limit, $offset);
		
		$query = $this->db->get();

		if ( $query->num_rows() > 0 ) :

			return $query->result_array();

		endif;

	}

	function get_post($post_id){

		$query = $this->db->get_where($this->posts_table, array( 'post_id' => $post_id ));
		
		if($query->num_rows() == 1):

 			return $query->row();

		endif;		
	}

	function get_page(){		

		$post_title = $this->uri->segment(1);		

		$query = $this->db->get_where($this->posts_table, array( 'slug' => $post_title ));
		
		if($query->num_rows() == 1):

 			return $query->row();

		endif;		
	}	

	function get_post_id() {

		$query = $this->db->get_where($this->posts_table, array( 'slug' => $this->input->post('slug') ));

		$create_post_id = $query->row('post_id');

		return $create_post_id;

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
	function delete_post_selection($id) {

	    $this->db->where_in('post_id', $id)->delete('posts');

		return true;
	}

	//COUNT ALL POSTS
	function count_all_posts(){

		$this->db->count_all_results('posts');
		$this->db->from('posts');
		$this->db->where('post_type', 'post');

		if ( $this->uri->segment(1) == 'blog') :
			$this->db->where('status', 'published');
		endif;
		
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
		$this->db->where('status', 'published');
		
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
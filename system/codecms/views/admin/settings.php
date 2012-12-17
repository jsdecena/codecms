
<?php 	//TESTING AREA
		//if ( isset($_POST)) : echo "<pre>"; var_dump($_POST); endif; 
		// foreach ($page_items as $pages) : echo "<pre>"; var_dump($pages); die(); endforeach; 
		// /var_dump($settings); die();
?>

	<ul id="cc_tabs" class="nav nav-tabs">
	  <li><a href="#users" data-toggle="tab">Users</a></li>
	  <li><a href="#pages" data-toggle="tab">Pages</a></li>
	  <li><a href="#posts" data-toggle="tab">Posts</a></li>
	  <li><a href="#others" data-toggle="tab">Others</a></li>
	</ul>
	 
	<div class="tab-content">
		<div class="tab-pane" id="users">Users settings</div>
		<div class="tab-pane" id="pages">Pages settings</div>
		<div class="tab-pane active" id="posts">
		
		<?php echo form_open('admin/main/post_settings_check'); ?>
		
			<?php if ( validation_errors() ) :  ?>
			  <div class="text-error alert-block alert-error fade in">
			  	<a class="close" data-dismiss="alert">&times;</a>
			    <?php echo validation_errors(); ?> 
			  </div>
			<?php endif;  ?>

			<?php if ( $this->session->flashdata('message_success') ) : ?>

			<div class="text-success alert-block alert-success fade in">
			  <a class="close" data-dismiss="alert">&times;</a>
			  <?php echo $this->session->flashdata('message_success'); ?> 
			</div>

			<?php elseif ( $this->session->flashdata('message_error') ): ?>

			<div class="text-error alert-block alert-error fade in"> 
			  <a class="close" data-dismiss="alert">&times;</a>
			  <?php echo $this->session->flashdata('message_error'); ?> 
			</div>      

			<?php endif; ?>			
											
			<div class="controlgroup">
				<div class="controls">
					<label for="choose_page" class="input-block-level">Choose a page to display your post.</label>	
					<select name="post_page_chosen" id="post_page_chosen" class="clear">
						<option value="0">Choose Page</option>
						<?php if ( is_array($page_items)) : foreach ($page_items as $pages) : ?>
		  				<option value="<?php echo $pages['page_id']; ?>" <?php if ( $this->input->post('post_page_chosen') == $pages['page_id'] ) : ?>selected="selected"<?php endif; ?>><?php echo $pages['title']; ?></option>
						<?php endforeach; endif; ?>	
					</select>
				</div>
				
				<div class="controls">
					<label for="post_per_page" class="input-block-level">Number of post to show in the page.</label>
					<input type="text" name="post_per_page" placeholder="Posts per page" value="<?php echo $this->input->post('post_per_page') ?>">
				</div>

				<div class="controls">
					<label for="arrange_post_by" class="input-block-level">Default arrange post by.</label>
					<select name="arrange_post_by" id="arrange_post_by">
						<option value="1" <?php if ( $this->input->post('arrange_post_by') == '1' ) : ?>selected="selected"<?php endif; ?>>By ID</option>
						<option value="2" <?php if ( $this->input->post('arrange_post_by') == '2' ) : ?>selected="selected"<?php endif; ?>>By Date</option>
					</select>
				</div>

				<div class="controls">
					<label for="order_post_by" class="input-block-level">Default order post by.</label>
					<select name="order_post_by" id="order_post_by">
						<option value="asc" <?php if ( $this->input->post('order_post_by') == 'asc' ) : ?>selected="selected"<?php endif; ?>>Ascending</option>
						<option value="desc" <?php if ( $this->input->post('order_post_by') == 'desc' ) : ?>selected="selected"<?php endif; ?>>Descending</option>
					</select>
				</div>
				<div class="controls">
					<button name="save_post_settings" class="btn btn-primary btn-small"><i class="icon-ok icon-white"> &nbsp; </i> Save Post Settings</button>  			
				</div>
			</div>
		
		<?php echo form_close(); ?>			

		</div>
		<div class="tab-pane" id="others">Other Settings</div>
	</div>
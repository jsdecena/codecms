<?php // echo "<pre>"; var_dump($page_items); die(); ?>

<div class="row clearfix:after pages_list">
	
	<div class="span3 bs-docs-sidebar">

		<!-- LOAD THE PAGE SIDEBAR -->
		<?php $this->load->view('admin/pages_post_tpl_sidebar'); ?>
		
	</div>

	<div class="span9">
		<section id="pages">
			<div class="controlgroup">

				<?php

				//PAGE CREATION FORM

				$attr = array('id' => 'post_create');
				echo form_open('admin/admin_posts/post_create_check', $attr); ?>

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

				<div class="controls clearfix">
					<input type="hidden" id="post" name="post_type" value="post" />
					<label for="post_title">Post Title <sup class="text-error">*</sup></label>
					<input type="text" class="input-block-level" id="post_title" name="title" value="<?php echo $this->input->post('title'); ?>">
					<input type="hidden" class="input-block-level" id="post_slug" name="slug" value="">				
				</div>

				<div class="controls clearfix">
					<textarea name="content" id="content" class="input-block-level ckeditor" cols="30" rows="10"><?php echo $this->input->post('content'); ?></textarea>
				</div>

				<div class="controls">
					<label>Publishing options:</label>
					<div class="controlgroup clearfix">
						<select name="status">
							<option value="unpublished" selected="selected">Unpublished</option>
							<option value="published">Published</option>
						</select>
					</div>					
				</div>

				<div class="controls">
					<a href="<?php echo base_url('admin/admin_posts/posts_list'); ?>" class="btn btn-info">Go Back</a>
					<input type="submit" name="post_create" class="btn btn-primary" value="Create a post" />

				</div>

				<?php echo form_close(); ?>				
				

			</div>
			
		</section>

	</div>	

</div>
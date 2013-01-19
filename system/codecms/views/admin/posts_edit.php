<?php  ?>

<div class="row clearfix:after pages_list">
	
	<div class="span3 bs-docs-sidebar">

		<!-- LOAD THE PAGE SIDEBAR -->
		<?php $this->load->view('admin/pages_post_tpl_sidebar'); ?>
		
	</div>

	<div class="span9">
		<section id="posts">
			<div class="controlgroup">

				<?php 

				//POST EDIT FORM

				$attr = array('class' => 'clear', 'id' => 'post_edit');
				echo form_open('admin/posts/post_edit_check', $attr); ?>

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
					<input type="hidden" class="input-block-level" name="slug" value="<?php echo $posts->slug; ?>">
					<input type="hidden" class="input-block-level" name="post_id" value="<?php echo $posts->post_id; ?>">
					<label for="post_title">Post Title <sup class="text-error">*</sup></label>
					<input type="text" class="input-block-level" name="title" value="<?php echo $posts->title; ?>">
				</div>

				<div class="controls clearfix">
					<textarea name="content" id="content" class="input-block-level ckeditor" cols="30" rows="10"><?php echo $posts->content; ?></textarea>
				</div>

				<div class="controls">
					<label>Publishing options:</label>
					<div class="controlgroup clearfix">
						<select name="status">
							<option value="unpublished" <?php if ( $posts->status == 'unpublished') : ?>selected="selected"<?php endif; ?>>Unpublished</option>
							<option value="published" <?php if ( $posts->status == 'published') : ?>selected="selected"<?php endif; ?>>Published</option>
						</select>
					</div>					
				</div>


				<div class="controls">
					<a href="<?php echo base_url('admin/posts/posts_list'); ?>" class="btn btn-info">Back</a>
					<input type="submit" id="post_edit" name="post_edit" class="btn btn-primary" value="Save" />

				</div>

				<?php echo form_close(); ?>				
				

			</div>
			
		</section>

	</div>	

</div>
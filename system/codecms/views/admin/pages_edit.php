<?php // echo "<pre>"; var_dump($page_items); die(); ?>

<div class="row clearfix:after pages_list">
	
	<div class="span3 bs-docs-sidebar">

		<!-- LOAD THE PAGE SIDEBAR -->
		<?php $this->load->view('admin/pages_post_tpl_sidebar'); ?>
		
	</div>

	<div class="span9">
		<section id="pages">
			<div class="control-group">

				<!-- LOAD THE PAGE CONTENT -->
				<?php 

				//PAGE EDIT FORM

				$attr = array('class' => 'clear', 'id' => 'page_edit');
				echo form_open('admin/admin_pages/page_edit_check', $attr); ?>

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
					<input type="hidden" id="page_slug" class="input-block-level" name="slug" value="<?php echo $page_items->slug; ?>">
					<input type="hidden" class="input-block-level" name="post_id" value="<?php echo $page_items->post_id; ?>">
					<label for="page_title">Page Title <sup class="text-error">*</sup></label>
					<input type="text" id="page_title" class="input-block-level" name="title" value="<?php echo $page_items->title; ?>">
				</div>

				<div class="controls clearfix">
					<textarea name="content" id="content" class="input-block-level ckeditor" cols="30" rows="10"><?php echo $page_items->content; ?></textarea>
				</div>


				<div id="page_attributes" class="controls">
					<h5>Page Attributes</h5>
					<div class="control-group">
						<label class="page_status control-label">Status:</label>
						<div class="controls">							
							<select name="status">
								<option value="unpublished" <?php if ( $page_items->status == 'unpublished') : ?>selected="selected"<?php endif; ?>>Unpublished</option>
								<option value="published" <?php if ( $page_items->status == 'published') : ?>selected="selected"<?php endif; ?>>Published</option>
							</select>					
						</div>												
					</div>

					<div class="control-group">
						<label class="page_parent control-label">Page Parent:</label>
						<div class="controls">							
							<select name="page_parent">
								<option value="0"> -- Select a page -- </option>
								<?php foreach ($pages as $page) : if ( $page['post_id'] != $this->uri->segment(4) && $page['status'] != 'unpublished' ) : //DO NOT INCLUDE THE CURRENT PAGE & UNPUBLISHED PAGE/s ON THE CHOICES ?>									
									<option value="<?php echo $page['post_id']; ?>"<?php if ( $this->input->post('page_parent') == $page['post_id'] ): ?> selected="selected"<?php endif; ?>><?php echo $page['title']; ?></option>
								<?php endif; endforeach;?>
							</select>					
						</div>												
					</div>									
				</div>				

				<div class="controls">
					<a href="<?php echo base_url('admin/admin_pages/pages_list'); ?>" class="btn btn-info">Back</a>
					<input type="submit" name="page_edit" class="btn btn-primary" value="Save" />

				</div>

				<?php echo form_close(); ?>				
				

			</div>
			
		</section>

	</div>	

</div>
<?php // echo "<pre>"; var_dump($page_items); die(); ?>

<div class="row clearfix:after pages_list">
	
	<div class="span3 bs-docs-sidebar">

		<!-- LOAD THE PAGE SIDEBAR -->
		<?php $this->load->view('admin/pages_tpl_sidebar'); ?>
		
	</div>

	<div class="span9">
		<section id="pages">
			<div class="controlgroup">

				<!-- LOAD THE PAGE CONTENT -->
				<?php // $this->load->view('admin/pages_tpl_create'); ?>

				<?php

				//PAGE CREATION FORM

				$attr = array('id' => 'page_create');
				echo form_open('admin/pages/page_create_check', $attr); ?>

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
					<label for="page_title">Page Title <sup class="text-error">*</sup></label>
					<input type="text" class="input-block-level" id="page_title" name="title" value="<?php echo $this->input->post('title'); ?>">
					<input type="hidden" class="input-block-level" id="page_slug" name="slug" value="">
				</div>

				<div class="controls clearfix">
					<textarea name="content" id="content" class="input-block-level ckeditor" cols="30" rows="10"><?php echo $this->input->post('content'); ?></textarea>
				</div>

				<div class="controls">
					<a href="<?php echo base_url('admin/pages/pages_list'); ?>" class="btn btn-info">Go Back</a>
					<input type="submit" name="page_create" class="btn btn-primary" value="Create a page" />

				</div>

				<?php echo form_close(); ?>				
				

			</div>
			
		</section>

	</div>	

</div>

<?php 

//var_dump($page_items); die();
$attr = array('class' => 'clear', 'id' => 'page_edit');
echo form_open('admin/pages/page_edit_check', $attr); ?>

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
	<input type="hidden" class="input-block-level" name="slug" value="<?php echo $page_items->slug; ?>">
	<input type="hidden" class="input-block-level" name="id" value="<?php echo $page_items->page_id; ?>">
	<label for="page_title">Page Title <sup class="text-error">*</sup></label>
	<input type="text" class="input-block-level" name="title" value="<?php echo $page_items->title; ?>">
</div>

<div class="controls clearfix">
	<label for="page_title">Page Content</label>
	<textarea name="content" id="content" class="input-block-level" cols="30" rows="10"><?php echo $page_items->content; ?></textarea>
</div>

<div class="controls">
	<a href="<?php echo base_url('admin/pages/pages_list'); ?>" class="btn btn-info">Go Back</a>
	<input type="submit" name="page_edit" class="btn btn-primary" value="Save Your Edit" />

</div>

<?php echo form_close(); ?>
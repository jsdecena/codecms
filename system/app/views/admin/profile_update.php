<?php $this->load->view('admin/dashboard_tpl_header'); ?>

<div class="row clearfix:after">
	
	<div class="span3 bs-docs-sidebar">
	
	<?php  $this->load->view('admin/profile_update_sidebar');?>
		
	</div>

	<div class="span9">
		
		<?php echo $this->template->content; ?>

	</div>	

</div>

<?php $this->load->view('admin/dashboard_tpl_footer'); ?>
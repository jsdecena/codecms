<?php $this->load->view('templates/default/tpl_top'); ?>
      
<div class="row-fluid page_tpl">

	<div class="span9">

		<?php echo $this->template->content; ?>

	</div><!--/span-->

	<div class="span3">
	  <div class="well sidebar-nav">
	  	sidebar
	  </div><!--/.well -->
	</div><!--/span-->	

</div><!--/row-->

<?php $this->load->view('templates/default/tpl_btm'); ?>
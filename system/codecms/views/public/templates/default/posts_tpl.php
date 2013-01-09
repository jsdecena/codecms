<?php $this->load->view('public/templates/default/tpl_top'); ?>
      
<div class="row-fluid posts_tpl">

	<div class="span9">

			<div id="post_page_wrap" class="span9">
			
				<?php echo $this->template->content; ?>

			</div><!--	END POST PAGE-->

	</div><!--/span-->

	<div class="span3">
	  <div class="well sidebar-nav">
	  	sidebar
	  </div><!--/.well -->
	</div><!--/span-->	

</div><!--/row-->

<?php $this->load->view('public/templates/default/tpl_btm'); ?>
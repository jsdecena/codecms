<?php $this->load->view('templates/default/tpl_top'); ?>
      
<div class="row-fluid page_tpl">

	<div class="span9">

		<?php //CHECK IF THIS IS THE POST PAGE SET IN THE SETTINGS, DISPLAY POSTS ?>



		<?php 
				//IF NOT DISPLAY AS PER NORMAL
				echo $this->template->content; 
		?>

	</div><!--/span-->

	<div class="span3">
	  <div class="well sidebar-nav">
	  	sidebar
	  </div><!--/.well -->
	</div><!--/span-->	

</div><!--/row-->

<?php $this->load->view('templates/default/tpl_btm'); ?>
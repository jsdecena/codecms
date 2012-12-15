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
				<?php $this->load->view('admin/pages_tpl_read'); ?>
				

			</div>
			
		</section>

	</div>	

</div>
<?php $this->load->view('public/templates/default/tpl_top'); ?>

<div class="row-fluid page_tpl">	

	<div id="post_page_wrap" class="span9">

		<?php if ( isset($page) && $page->status == 'published' ) : //CHECK IF THE PAGE IS SET OR EXISTING ?>
			
			<h2> <?php echo $page->title; ?> </h2>

			<?php echo $page->content; ?>					

		<?php else: ?>

			<p class="text-error">Sorry, the page you are looking for is not existing or deleted. </p>

		<?php endif; ?>

	</div>						

	<div class="span3">

	  <div class="well sidebar-nav">sidebar</div>

	</div>

</div><!--/row-->

<?php $this->load->view('public/templates/default/tpl_btm'); ?>
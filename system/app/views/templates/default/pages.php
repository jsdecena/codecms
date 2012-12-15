<!-- THIS IS THE CONTENT-->

<section id="main_content hidden">

	<?php if ( isset($page) || is_array($page) ) : ?>
		
		<h1><?php echo $page->title; ?></h1>

		<p><?php echo $page->content; ?></p>

		<?php else: ?>

			<p>No page found</p>

	<?php endif; ?>
	
</section>
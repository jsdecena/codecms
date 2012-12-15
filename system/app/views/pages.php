<?php //var_dump($page_data); die(); ?>

<section id="main_content">

	<?php if ( isset($page_data) ) : ?>
		
		<h1><?php echo $page_data->title; ?></h1>

		<p><?php echo $page_data->content; ?></p>

		<?php else: ?>

			<p>No page found</p>

	<?php endif; ?>
	
</section>
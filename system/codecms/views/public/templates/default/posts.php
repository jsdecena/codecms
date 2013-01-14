<!-- THIS IS THE ACTUAL PAGE CONTENT-->

<section id="main_content hidden">

	<?php if ( isset($post) ) : //var_dump($post); die(); ?>
		
		<h1><?php echo $post->title; ?></h1>

		<p><?php echo $post->content; ?></p>

		<?php else: ?>

			<p>No post found</p>

	<?php endif; ?>
	
</section>
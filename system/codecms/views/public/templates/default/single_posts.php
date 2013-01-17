<!-- THIS IS THE ACTUAL POST -->

<section id="main_content" class="post_page">

	<?php if ( isset($post) ) : ?>

		<h2>
			<?php echo $post->title; ?>
			<span><?php echo '<span class="author">' . $post->author . "</span> on "; $newDate = date("M jS Y", strtotime($post->date_add)); echo $newDate; ?></span>
		</h2>

		<?php echo $post->content; ?>

	<?php endif; ?>
	
</section>
<section id="main_content" class="post_page">
	
	<?php if ( isset($page) ) : ?>

		<h2>
			<?php echo $page->title; ?>
			<span><?php echo '<span class="author">' . $page->author . "</span> on "; $newDate = date("M jS Y", strtotime($page->date_add)); echo $newDate; ?></span>
		</h2>

		<?php echo $page->content; ?>

	<?php else: ?>

		<p class="text-error">Sorry, there are no page to show. </p>

	<?php endif; ?>

</section>
<!-- THIS IS THE POST LISTS-->

<section id="main_content" class="post_page">

<?php if ( $this->uri->segment(2) == 'post' ) : //CHECK IF THIS IS THE PAGE TO DISPLAY THE POST! ?>

	<?php if ( isset($post) ) : ?>

		<h2>
			<?php echo $post->title; ?>
			<span><?php echo '<span class="author">' . $post->author . "</span> on "; $newDate = date("M jS Y", strtotime($post->date_add)); echo $newDate; ?></span>
		</h2>

		<?php echo $post->content; ?>

	<?php endif; ?>

<?php elseif ( $this->uri->segment(2) == 'posts_list' ): //CHECK IF THIS THE PAGE TO LIST ALL THE POSTS! ?>

	<?php if ( is_array($posts) ) : foreach ($posts as $post) : $slug = $post['slug']; ?>

		<?php if ( isset($post) && $post['status'] !== 'unpublished' ) : ?>

			<h2>
				<a href="<?php echo base_url("blog/post/$slug"); ?>"><?php echo $post['title']; ?></a>
				
				<span> 			
					<?php echo '<span class="author">' . $post['author'] . "</span> on "; $newDate = date("M jS Y", strtotime($post['date_add'])); echo $newDate; ?>			
				</span>
			</h2>

			<?php echo word_limiter($post['content'], 30, '<p><a href="'. base_url("blog/post/$slug") .'">Continue Reading</a></p>'); ?>

		<?php endif; ?>

	<?php endforeach; ?>

	<?php echo $links; ?>

	<?php else: //IF THERE IS REALLY NO POST CREATED ?>

		<p class="text-error">Sorry, there are no posts to show. </p>

	<?php endif; ?>

<?php endif; ?>
	
</section>
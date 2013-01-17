<!-- THIS IS THE POST LISTS-->

<section id="main_content" class="post_page">

<?php if ( $this->uri->segment(2) == 'post' ) : ?>

	<?php if ( isset($post) ) : ?>

		<h2>
			<?php echo $post->title; ?>
			<span><?php echo '<span class="author">' . $post->author . "</span> on "; $newDate = date("M jS Y", strtotime($post->date_add)); echo $newDate; ?></span>
		</h2>

		<?php echo $post->content; ?>

	<?php endif; ?>

<?php elseif ( $this->uri->segment(2) == 'posts_list' ): ?>

	<?php foreach ($posts as $post) : $slug = $post['slug']; ?>

		<?php if ( $post['status'] == 'published' ) : ?>

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

<?php endif; ?>
	
</section>
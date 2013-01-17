<!-- THIS IS THE POST LISTS-->

<section id="main_content">

	<?php foreach ($posts as $post) : $slug = $post['slug']; ?>
		<div class="post_page">
			<h2>
				<a href="<?php echo base_url("blog/post/$slug"); ?>"><?php echo $post['title']; ?></a>
				
				<span> 			
					<?php echo '<span class="author">' . $post['author'] . "</span> on "; $newDate = date("M jS Y", strtotime($post['date_add'])); echo $newDate; ?>			
				</span>
			</h2>

			<?php echo word_limiter($post['content'], 30, '<p><a href="'. base_url("blog/post/$slug") .'">Continue Reading</a></p>'); ?>			
		</div>
	<?php endforeach; ?>
	
</section>

<?php echo $links; ?>
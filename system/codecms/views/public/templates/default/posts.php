<!-- THIS IS THE ACTUAL PAGE CONTENT-->

<section id="main_content hidden">

	<?php if ( isset($post) ) : $slug = $post->slug; //var_dump($post); die(); ?>
		<div class="post_page">
			<h2>
			<a href="<?php echo base_url("blog/post/$slug"); ?>"><?php echo $post->title; ?></a>
				<span> 
				
				<?php							

					echo '<span class="author">' . $post->author . "</span> on ";

					$newDate = date("M jS Y", strtotime($post->date_add));
					echo $newDate;

				?>
				
				</span>
			</h2>		

			<?php echo $post->content; ?>
					
		</div>

		<?php else: ?>

			<p>No post found</p>

	<?php endif; ?>
	
</section>
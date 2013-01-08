<?php $this->load->view('public/templates/default/tpl_top'); ?>
      
<div class="row-fluid page_tpl">

		<?php

			//CHECK IF THIS IS THE POST PAGE SET IN THE SETTINGS, DISPLAY THE POSTS
			if ( isset($post_page->settings_value) && $post_page->settings_value == 'blog' && $this->uri->segment(1) == 'blog' ) :

		?>
		
			<div id="post_page_wrap" class="span9">
			
				<?php foreach ($all_posts as $row) : ?>

				<div class="post_page">
					<h2>
						<?php echo $row['title']; ?> 
						<span> 
						
						<?php							

							echo '<span class="author">' . $row['author'] . "</span> on ";

							$newDate = date("M jS Y", strtotime($row['date_add']));
							echo $newDate;

							//echo $row['date_add'] ?>
						
						</span>
					</h2>
					<?php echo word_limiter($row['content'], 50); ?>
				</div>				

				<?php endforeach; //END ALL POSTS ROW ?>

			</div><!--	END POST PAGE-->
		
		<?php else: ?>

			<div class="span9 regular_page">
			
				<?php

					//IF NOT DISPLAY AS PER NORMAL
					echo $this->template->content;

				?>

			</div> <!-- END REGULAR PAGE -->

		<?php endif; ?>


	<div class="span3">
	  <div class="well sidebar-nav">
	  	sidebar
	  </div><!--/.well -->
	</div><!--/span-->	

</div><!--/row-->

<?php $this->load->view('public/templates/default/tpl_btm'); ?>
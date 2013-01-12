<?php if ( $page->status == 'published') : ?>

<?php $this->load->view('public/templates/default/tpl_top'); ?>
      
<div class="row-fluid page_tpl">

		<?php

			//CHECK IF THIS IS THE POST PAGE SET IN THE SETTINGS, DISPLAY THE POSTS			
			if ( isset($post_page['settings_value']) && $post_page['settings_value'] == $this->uri->segment(1) ) :

		?>
		
			<div id="post_page_wrap" class="span9">
			
		  <?php 

		        //CHECK IF THERE IS A POST/S
		        if ( is_array($all_posts) ) : 

		        //IF THERE IS/ARE, SHOW THEM 
		        foreach ($all_posts as $row) : 

		        //GET ONLY THE PUBLISHED POST/S
		        if ( $row['status'] == 'published') : $slug = $row['slug']; ?>

				<div class="post_page">
					<h2>
					<a href="<?php echo base_url("blog/post/$slug"); ?>"><?php echo $row['title']; ?></a>
						<span> 
						
						<?php							

							echo '<span class="author">' . $row['author'] . "</span> on ";

							$newDate = date("M jS Y", strtotime($row['date_add']));
							echo $newDate;

						?>
						
						</span>
					</h2>
					<?php echo word_limiter($row['content'], 30); ?>
					<p><a href="<?php echo base_url("blog/post/$slug"); ?>">Continue Reading</a></p>
				</div>				

				<?php endif; endforeach; ?>

				<p><?php echo $links; ?></p>
				
				<?php else: //SHOW NO POST ?>

				<h4>Sorry, there are no posts to show. </h4>

				<?php endif; ?>				

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

<?php endif; ?>
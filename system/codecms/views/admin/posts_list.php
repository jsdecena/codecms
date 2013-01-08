<?php // echo "<pre>"; var_dump($post_items); die(); ?>

<div class="row clearfix:after posts_list">
	
	<div class="span3 bs-docs-sidebar">

		<!-- LOAD THE post SIDEBAR -->
		<?php $this->load->view('admin/pages_post_tpl_sidebar'); ?>
		
	</div>

	<div class="span9">
		<section id="pages">
			<div class="controlgroup">

				<!-- LOAD THE PAGE CONTENT -->
				<?php // $this->load->view('admin/pages_tpl_list'); ?>

				<?php 

				//PAGE LIST FORM

				if ( is_array($post_items)) : echo form_open('admin/posts/post_delete'); ?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Content</th>
							<th>Author</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($post_items as $posts) : ?>			
							<tr>
								<td><?php echo $posts['post_id']; ?></td>
								<td><?php echo $posts['title']; ?></td>
								<td><?php echo $posts['content']; ?></td>
								<td><?php echo $posts['author']; ?></td>
								<td>								
								<?php echo anchor("admin/posts/post_edit" . '/' . $posts["post_id"], '<i class="icon-pencil icon-white">&nbsp;</i> Edit', 'class="btn btn-primary"'); ?>
								<?php if ( $logged_info['role'] == 'admin') : ?>
								<button name="id" class="btn btn-danger btn-small" value="<?php echo $posts["post_id"]; ?>" onClick="return confirm('Are you sure you want to delete?')">
									<i class="icon-trash icon-white"> &nbsp; </i> Delete</button>
								<?php endif; ?>
								</td>
							</tr>			
						<?php endforeach; ?>	
					</tbody>
				</table>

				<?php // echo $this->pagination->create_links(); ?>
					
				<?php echo form_close(); else: ?>

				  <div class="text-error alert-block alert-error fade in">
				    <p>Ooops, No more posts!</p>
				  </div>

				<?php endif; ?>				
				

			</div>
			
		</section>

	</div>	

</div>
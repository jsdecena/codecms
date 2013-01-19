<div class="row clearfix:after posts_list">
	
	<div class="span3 bs-docs-sidebar">

		<!-- LOAD THE post SIDEBAR -->
		<?php $this->load->view('admin/pages_post_tpl_sidebar'); ?>
		
	</div>

	<div class="span9">
		<section id="pages">
			<div class="controlgroup">

				<?php if ( $this->session->flashdata('message_success') ) : ?>

				<div class="text-success alert-block alert-success fade in">
				  <a class="close" data-dismiss="alert">&times;</a>
				  <?php echo $this->session->flashdata('message_success'); ?> 
				</div>

				<?php elseif ( $this->session->flashdata('message_error') ): ?>

				<div class="text-error alert-block alert-error fade in"> 
				  <a class="close" data-dismiss="alert">&times;</a>
				  <?php echo $this->session->flashdata('message_error'); ?> 
				</div>      

				<?php endif; ?>

				<?php 

				//POST LIST FORM

				if ( is_array($posts)) : ?>
				
				<table class="table table-striped">
					<thead>
						<tr>
							<th><input type="checkbox" id="select_all" /></th>
							<th class="tbl_title">Title</th>
							<th class="tbl_content">Content</th>
							<th class="tbl_author">Author</th>
							<th class="tbl_actions">Actions</th>
							<th class="tbl_status">Status</th>							
						</tr>
					</thead>
					<tbody>
						<?php foreach ($posts as $post) : $post_url = $post["slug"] ?>			
							<tr>
								<td><input class="delete_selection" type="checkbox" name="delete_selection[]" value="<?php echo $post['post_id']; ?>" /> </td>
								<td class="tbl_title"><?php echo $post['title']; ?></td>
								<td class="tbl_content"><?php echo word_limiter($post['content'], 10); ?></td>
								<td class="tbl_author"><?php echo $post['author']; ?></td>
								<td class="tbl_actions">
								
								<!-- ACTION TO VIEW THE PAGE-->
								<?php echo anchor( base_url("blog/post/$post_url"), '<i class="icon-search icon-white">&nbsp;</i> View', 'target="_blank" class="btn btn-info"'); ?>
								
								<!-- ACTION TO EDIT THE PAGE-->
								<?php echo anchor("admin/posts/post_edit" . '/' . $post["post_id"], '<i class="icon-pencil icon-white">&nbsp;</i> Edit', 'class="btn btn-primary"'); ?>
								
								<!-- ACTION TO DELETE THE PAGE-->
								<?php if ( $logged_info['role'] == 'admin' ) : echo form_open('admin/posts/post_delete'); ?>
								<button name="delete_post" class="btn btn-danger btn-small" value="<?php echo $post["post_id"]; ?>" onClick="return confirm('Are you sure you want to delete?')">
									<i class="icon-trash icon-white"> &nbsp; </i> Delete</button>
								<?php echo form_close(); endif; ?>
								</td>

								<td class="tbl_status">

									<?php echo form_open('admin/posts/quick_update'); if ( $post['status'] == 'unpublished') : ?>
										
										<!-- ACTION TO QUICK PUBLISH THE PAGE-->
										<input type="hidden" name="post_id" value="<?php echo $post["post_id"]; ?>" />
										<input type="hidden" name="post_type" value="<?php echo $post["post_type"]; ?>" />
										<button name="status" class="btn btn-danger btn-small" value="published" onClick="return confirm('Publish this page?')">
										<i class="icon-remove icon-white icon_status">&nbsp;</i>

									<?php else: ?>

										<!-- ACTION TO QUICK UNPUBLISH THE PAGE-->
										<input type="hidden" name="post_id" value="<?php echo $post["post_id"]; ?>" />
										<input type="hidden" name="post_type" value="<?php echo $post["post_type"]; ?>" />
										<button name="status" class="btn btn-success btn-small" value="unpublished" onClick="return confirm('Unpublish this page?')">
										<i class="icon-ok icon-white icon_status">&nbsp;</i>
																				
									<?php endif; echo form_close(); ?>
								</td>								
							</tr>			
						<?php endforeach; ?>
					</tbody>
				</table>				
				
				<div class="pull-left action_left" id="post_selected">
					<?php echo form_open('admin/posts/post_delete', 'id="delete_selection_form"'); ?>
						<button id="delete_selection" name="delete_selection" class="btn btn-danger btn-small" value="" onClick="return confirm('Delete selected posts?')"><i class="icon-trash icon-white"> &nbsp; </i> Delete Selected</button>
					<?php echo form_close(); ?>
				</div>

				<div class="pull-right action_right">
					<?php echo $links; //PAGINATION ?>
				</div>
				
				<?php else: ?>

				  <div class="text-error alert-block alert-error fade in">
				    <p>Ooops, No more posts!</p>
				  </div>

				<?php endif; ?>				
				

			</div>
			
		</section>

	</div>	

</div>
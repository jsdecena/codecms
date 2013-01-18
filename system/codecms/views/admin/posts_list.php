<?php // echo "<pre>"; var_dump($post_items); die(); ?>

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

				if ( is_array($post_items)) : echo form_open('admin/posts/post_delete'); ?>
				
				<table class="table table-striped">
					<thead>
						<tr>
							<th><input type="checkbox" id="select_all" /></th>
							<th class="tbl_status">Status</th>
							<th class="tbl_title">Title</th>
							<th class="tbl_content">Content</th>
							<th class="tbl_author">Author</th>
							<th class="tbl_actions">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($post_items as $posts) : $post_url = $posts["slug"] ?>			
							<tr>
								<td><input class="delete_selection" type="checkbox" name="delete_selection[]" value="<?php echo $posts['post_id']; ?>" /> </td>
								<td class="tbl_status">
									<?php if ( $posts['status'] == 'unpublished') : ?>
										<i class="icon-remove icon-black icon_status">&nbsp;</i>
									<?php else: ?>
										<i class="icon-ok icon-black icon_status">&nbsp;</i>									
									<?php endif; ?>									
								</td>
								<td class="tbl_title"><?php echo $posts['title']; ?></td>
								<td class="tbl_content"><?php echo word_limiter($posts['content'], 10); ?></td>
								<td class="tbl_author"><?php echo $posts['author']; ?></td>
								<td class="tbl_actions">
								<?php echo anchor( base_url("blog/post/$post_url"), '<i class="icon-search icon-white">&nbsp;</i> View', 'target="_blank" class="btn btn-info"'); ?>
								<?php echo anchor("admin/posts/post_edit" . '/' . $posts["post_id"], '<i class="icon-pencil icon-white">&nbsp;</i> Edit', 'class="btn btn-primary"'); ?>
								<?php if ( $logged_info['role'] == 'admin' ) : ?>
								<button name="delete_post" class="btn btn-danger btn-small" value="<?php echo $posts["post_id"]; ?>" onClick="return confirm('Are you sure you want to delete?')">
									<i class="icon-trash icon-white"> &nbsp; </i> Delete</button>
								<?php endif; ?>
								</td>
							</tr>			
						<?php endforeach; ?>
					</tbody>
				</table>				
				
				<div class="pull-left action_left">
					<button name="delete_selected" class="btn btn-danger btn-small" value="" onClick="return confirm('Delete selected posts?')"><i class="icon-trash icon-white"> &nbsp; </i> Delete Selected</button>
				</div>

				<div class="pull-right action_right">
					<?php echo $links; //PAGINATION ?>
				</div>
				
				<?php echo form_close(); else: ?>

				  <div class="text-error alert-block alert-error fade in">
				    <p>Ooops, No more posts!</p>
				  </div>

				<?php endif; ?>				
				

			</div>
			
		</section>

	</div>	

</div>
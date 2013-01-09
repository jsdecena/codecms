<?php // echo "<pre>"; var_dump($post_items); die(); ?>

<div class="row clearfix:after posts_list">
	
	<div class="span3 bs-docs-sidebar">

		<!-- LOAD THE post SIDEBAR -->
		<?php $this->load->view('admin/pages_post_tpl_sidebar'); ?>
		
	</div>

	<div class="span9">
		<section id="pages">
			<div class="controlgroup">

				<?php 

				//POST LIST FORM

				if ( is_array($post_items)) : ?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th class="tbl_id">ID</th>
							<th class="tbl_title">Title</th>
							<th class="tbl_content">Content</th>
							<th class="tbl_author">Author</th>
							<th class="tbl_actions">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php echo form_open('admin/posts/post_delete'); foreach ($post_items as $posts) :  ?>			
							<tr>
								<td><input type="checkbox" name="<?php echo $posts['post_id']; ?>" /> </td>
								<td class="tbl_id"><?php echo $posts['post_id']; ?></td>
								<td class="tbl_title"><?php echo $posts['title']; ?></td>
								<td class="tbl_content"><?php echo $posts['content']; ?></td>
								<td class="tbl_author"><?php echo $posts['author']; ?></td>
								<td class="tbl_actions">								
								<?php echo anchor("admin/posts/post_edit" . '/' . $posts["post_id"], '<i class="icon-pencil icon-white">&nbsp;</i> Edit', 'class="btn btn-primary"'); ?>
								<?php if ( $logged_info['role'] == 'admin') : ?>
								<button name="id" class="btn btn-danger btn-small" value="<?php echo $posts["post_id"]; ?>" onClick="return confirm('Are you sure you want to delete?')">
									<i class="icon-trash icon-white"> &nbsp; </i> Delete</button>
								<?php endif; ?>
								</td>
							</tr>			
						<?php endforeach;  echo form_close(); ?>
					</tbody>
				</table>				
				
				<div class="pull-left action_left">

					<?php echo form_open('admin/posts/post_delete_selected'); ?>
						<button name="id" class="btn btn-danger btn-small" value="" onClick="return confirm('Delete selected posts?')"><i class="icon-trash icon-white"> &nbsp; </i> Delete Selected</button>
					<?php  echo form_close(); ?>

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
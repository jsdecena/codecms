<?php // echo "<pre>"; var_dump($page_items); die(); ?>

<div class="row clearfix:after pages_list">
	
	<div class="span3 bs-docs-sidebar">

		<!-- LOAD THE PAGE SIDEBAR -->
		<?php $this->load->view('admin/pages_post_tpl_sidebar'); ?>
		
	</div>

	<div class="span9">
		<section id="pages">
			<div class="controlgroup">

				<!-- LOAD THE PAGE CONTENT -->
				<?php // $this->load->view('admin/pages_tpl_list'); ?>

				<?php 

				//PAGE LIST FORM
				if ( is_array($page_items)) : echo form_open('admin/pages/page_delete'); ?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="tbl_id">ID</th>
							<th class="tbl_title">Title</th>
							<th class="tbl_content">Content</th>
							<th class="tbl_actions">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($page_items as $pages) : ?>			
							<tr>
								<td class="tbl_id"><?php echo $pages['page_id']; ?></td>
								<td class="tbl_title"><?php echo $pages['title']; ?></td>
								<td class="tbl_content"><?php echo $pages['content']; ?></td>
								<td class="tbl_actions">
								<?php echo anchor( $pages["slug"], '<i class="icon-search icon-white">&nbsp;</i> View', 'target="_blank" class="btn btn-info"'); ?>
								<?php echo anchor("admin/pages/page_edit" . '/' . $pages["page_id"], '<i class="icon-pencil icon-white">&nbsp;</i> Edit', 'class="btn btn-primary"'); ?>
								<?php if ( $logged_info['role'] == 'admin') : ?>
								<button name="id" class="btn btn-danger btn-small" value="<?php echo $pages["page_id"]; ?>" onClick="return confirm('Are you sure you want to delete?')">
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
				    <p>Ooops, No more pages!</p>
				  </div>

				<?php endif; ?>				
				

			</div>
			
		</section>

	</div>	

</div>
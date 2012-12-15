<?php echo form_open('admin/pages/page_delete'); ?>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>ID</th>
				<th>Title</th>
				<th>Content</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if ( is_array($page_items)) : foreach ($page_items as $pages) : ?>			
				<tr>
					<td><?php echo $pages['page_id']; ?></td>
					<td><?php echo $pages['title']; ?></td>
					<td><?php echo $pages['content']; ?></td>
					<td>
					<?php echo anchor("admin/pages/page_edit" . '/' . $pages["page_id"], '<i class="icon-pencil icon-white">&nbsp;</i> Edit', 'class="btn btn-primary"'); ?>
					<?php if ( $logged_info['role'] == 'admin') : ?>
					<button name="id" class="btn btn-danger btn-small" value="<?php echo $pages["page_id"]; ?>" onClick="return confirm('Are you sure you want to delete?')">
						<i class="icon-trash icon-white"> &nbsp; </i> Delete</button>
					<?php endif; ?>
					</td>
				</tr>			
			<?php endforeach; endif; ?>	
		</tbody>
	</table>

	<?php // echo $this->pagination->create_links(); ?>
	
<?php echo form_close(); ?>
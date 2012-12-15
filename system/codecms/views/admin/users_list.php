<?php if ( isset($user_data) && is_array($user_data) && count($user_data) ) : //echo "<pre>"; var_dump($user_data); die(); ?> 
<div class="row">

	<div class="span3 sidebar">
		
		<?php echo $this->load->view('admin/users_list_sidebar'); ?>

	</div>

	<div class="span9">

		<div class="page-header"> Users List </div>		
		
		<table class="table table-condensed table-bordered">
			<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>First Name</th> 
				<th>Last Name</th>
				<th>Email</th>
				<th>Role</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>

			<?php foreach($user_data as $data): $id = $data['id']; ?>
				<tr>
					<td><?php echo $data['id']; ?></td>
					<td><?php echo $data['username']; ?></td>
					<td><?php echo $data['first_name']; ?></td>
					<td><?php echo $data['last_name']; ?></td>
					<td><?php echo $data['email']; ?></td>
					<td><?php echo $data['role']; ?></td>
					<td><?php echo anchor("admin/main/users_update_by_admin/$id", '<i class="icon-pencil icon-white">&nbsp;</i> Edit', 'class="btn btn-primary btn-small"'); ?> 
						<a href="<?php echo base_url("admin/main/users_delete/$id"); ?>" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-small"> 
						<i class="icon-trash icon-white"> &nbsp; </i> Delete</a>

					</td>
				</tr>
			<?php endforeach; ?>  	
			</tbody>
		</table>
	</div>	

</div> <!-- END ROW -->

<?php endif; ?>
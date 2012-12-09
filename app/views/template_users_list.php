<?php if ( isset($user_data) && is_array($user_data) && count($user_data) ) : //echo "<pre>"; var_dump($user_data); die(); ?> 


<table class="table table-condensed table-bordered">
	<caption style="text-align: left"><h3>Users List</h3></caption>	
	<thead>
	<tr>
		<th>ID</th>
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
			<td><?php echo $data['first_name']; ?></td>
			<td><?php echo $data['last_name']; ?></td>
			<td><?php echo $data['email']; ?></td>
			<td><?php echo $data['role']; ?></td>
			<td><?php echo anchor("admin/users_update/$id", 'Edit'); ?> | <?php echo anchor("admin/users_delete/$id", 'Delete', array('onClick' => "return confirm('Are you sure you want to delete?')")); ?> </td>
		</tr>
	<?php endforeach; ?>  	
	</tbody>
</table>

<?php endif; ?>
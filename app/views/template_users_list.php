<?php if ( isset($user_data) && is_array($user_data) && count($user_data) ) : //echo "<pre>"; var_dump($user_data); die(); ?> 

<table class="table table-condensed table-bordered">
	<caption style="text-align: left"><h3>Users List</h3></caption>	
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
			<td>
				<?php 

					//ROLE 1 : SUBS
					//ROLE 2 : ADMIN
					if ( $data['role'] == 1 ):
						echo "Subscriber";
					elseif ( $data['role'] == 2 ):
						echo "Admin";
					else:
						echo "Unknown";
					endif;

				?>
			</td>
			<td><?php echo anchor("admin/users_update/$id", 'Edit', 'class="btn btn-primary btn-small"'); ?> 
				<a href="<?php echo base_url("admin/users_delete/$id"); ?>" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-small"> Delete</a>

			</td>
		</tr>
	<?php endforeach; ?>  	
	</tbody>
</table>

<?php endif; ?>
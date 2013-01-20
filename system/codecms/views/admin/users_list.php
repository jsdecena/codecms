<?php if ( isset($user_data) && is_array($user_data) && count($user_data) ) : //echo "<pre>"; var_dump($user_data); die(); ?> 
<div class="row">

	<div class="span3 sidebar">
		
		<?php echo $this->load->view('admin/users_list_sidebar'); ?>

	</div>

	<div class="span9">

		<div class="page-header"> Users List </div>

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
		
		<table class="table table-striped">
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

			<?php foreach($user_data as $data): $id = $data['users_id']; ?>
				<tr>
					<td><?php echo $data['users_id']; ?></td>
					<td><?php echo $data['username']; ?></td>
					<td><?php echo $data['first_name']; ?></td>
					<td><?php echo $data['last_name']; ?></td>
					<td><?php echo $data['email']; ?></td>
					<td><?php echo $data['role']; ?></td>
					<td>
						<?php echo anchor("admin/admin_main/users_update_by_admin/$id", '<i class="icon-pencil icon-white">&nbsp;</i> Edit', 'class="btn btn-primary btn-small"'); ?>

						<?php echo anchor("admin/admin_main/users_delete/$id", '<i class="icon-pencil icon-white">&nbsp;</i> Delete', 'class="btn btn-danger btn-small" onClick="return confirm(\'Delete this user?\')"'); ?>

					</td>
				</tr>
			<?php endforeach; ?>  	
			</tbody>
		</table>
	</div>	

</div> <!-- END ROW -->

<?php endif; ?>
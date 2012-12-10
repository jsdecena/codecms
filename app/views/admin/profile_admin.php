<div class="row clearfix:after">
	
	<div class="span3 sidebar">

		<ul class="nav nav-list bs-docs-sidenav affix-top">
			<li><a href="<?php echo base_url('admin/user_profile'); ?>">Profile</a></li>
			<li><a href="<?php echo base_url("admin/users_update_pw/$logged_info->id"); ?>">Password</a></li>
			<li><a href="#">Notifications</a></li>
			<li><a href="#">Social</a></li>
		</ul>
		
	</div>

	<div class="span9">
		
		<section id="personal_info">
			
			<div class="controlgroup">
				<div class="page-header">
					Personal Information
				</div>

				<div class="controls">
					<label for="username" class="muted"> <i class="icon-fire">&nbsp;</i> Username: </label>
					<p class="details text-info"><?php echo $logged_info->username; ?></p>									
				</div>

				<div class="controls">
					<label for="first_name" class="muted"><i class="icon-user">&nbsp;</i> First Name:</label>
					<p class="details text-info"><?php echo $logged_info->first_name; ?></p>										
				</div>

				<div class="controls">
					<label for="last_name" class="muted"><i class="icon-user">&nbsp;</i> Last Name:</label>
					<p class="details text-info"><?php echo $logged_info->last_name; ?></p>						
				</div>

				<div class="controls">
					<label for="email" class="muted"><i class="icon-envelope">&nbsp;</i> Email:</label>
					<p class="details text-info"><?php echo $logged_info->email; ?></p>						
				</div>

				<div class="controls">
					<label for="role" class="muted"><i class="icon-star">&nbsp;</i> Role:</label>
					<p class="details text-info"><?php echo $logged_info->role; ?></p>						
				</div>

				<div class="controls">
					<label for="role" class="muted"><i class="icon-lock">&nbsp;</i> About You:</label>
					<p class="details text-info"><?php echo $logged_info->about; ?></p>						
				</div>				
			</div>
		</section>

	</div>	

</div>
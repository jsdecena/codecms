<ul class="nav nav-list bs-docs-sidenav affix-top">
	<li <?php if ( $this->uri->segment(3) == 'user_profile'): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/admin_main/user_profile'); ?>">Personal Information</a></li>
	<li <?php if ( $this->uri->segment(3) == 'users_update'): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/admin_main/users_update') . '/' . $logged_info['users_id']; ?>">Update your profile</a></li>	
	<li <?php if ( $this->uri->segment(3) == 'users_update_pw'): echo "class='active'"; endif; ?>><a href="<?php echo base_url("admin/admin_main/users_update_pw") . '/' . $logged_info['users_id']; ?>">Password</a></li>	
	<li><a href="#">Social</a></li>
</ul>
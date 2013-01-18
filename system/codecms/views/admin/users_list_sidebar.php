
<ul class="nav nav-list bs-docs-sidenav affix-top">
	<li <?php if ( $this->uri->segment(3) == 'users_list' || $this->uri->segment(3) == 'admin_users_update'): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/main/users_list'); ?>">Users List</a></li>
	<li <?php if ( $this->uri->segment(3) == 'users_create' || $this->uri->segment(3) == 'users_create_check'): echo "class='active'"; endif; ?>><a href="<?php echo base_url("admin/main/users_create"); ?>">Create a User</a></li>
	<li><a href="#">Notifications</a></li>
	<li><a href="#">Social</a></li>
</ul>
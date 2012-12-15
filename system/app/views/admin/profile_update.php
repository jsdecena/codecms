<?php $this->load->view('admin/template_dashboard_header'); ?>

<div class="row clearfix:after">
	
	<div class="span3 sidebar">

		<ul class="nav nav-list bs-docs-sidenav affix-top">
			<li <?php if ( $this->uri->segment(2) == 'user_profile'): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/user_profile'); ?>">Profile</a></li>
			<li <?php if ( $this->uri->segment(2) == 'users_update_pw'): echo "class='active'"; endif; ?>><a href="<?php echo base_url("admin/users_update_pw") . '/' . $logged_info['id']; ?>">Password</a></li>
			<li><a href="#">Notifications</a></li>
			<li><a href="#">Social</a></li>
		</ul>
		
	</div>

	<div class="span9">
		
		<?php echo $this->template->content; ?>

	</div>	

</div>

<?php $this->load->view('admin/template_dashboard_footer'); ?>
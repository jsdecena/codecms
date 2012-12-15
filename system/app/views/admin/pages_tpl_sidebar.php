<ul class="nav nav-list bs-docs-sidenav affix-top">
	<li <?php if ( $this->uri->segment(3) == 'pages_list'): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/pages/pages_list'); ?>">Pages</a></li>
	<li <?php if ( $this->uri->segment(3) == 'page_create' || $this->uri->segment(3) == 'page_create_check') : echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/pages/page_create'); ?>">Create a page</a></li>
</ul>
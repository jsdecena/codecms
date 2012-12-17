<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
        Manage Pages
      </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse in">
      <div class="accordion-inner">
		<ul class="nav nav-list">
			<li <?php if ( $this->uri->segment(3) == 'pages_list'): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/pages/pages_list'); ?>">List Pages</a></li>
			<li <?php if ( $this->uri->segment(3) == 'page_create' || $this->uri->segment(3) == 'page_create_check') : echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/pages/page_create'); ?>">Create a page</a></li>
		</ul>
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
       Manage Posts
      </a>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
      <div class="accordion-inner">
		<ul class="nav nav-list">
			<li <?php if ( $this->uri->segment(3) == 'posts_list'): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/dashboard'); ?>">List Posts</a></li>
			<li><a href="<?php echo base_url('admin/dashboard'); ?>">Create a Post</a></li>
		</ul>
      </div>
    </div>
  </div>
</div>
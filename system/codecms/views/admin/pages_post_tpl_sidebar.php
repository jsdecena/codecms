<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
        Manage Pages
      </a>
    </div>

    <div id="collapseOne" class="accordion-body collapse <?php if ( $this->uri->segment(3) == 'pages_list' || $this->uri->segment(3) == 'page_create' || $this->uri->segment(3) == 'page_create_check' || $this->uri->segment(3) == 'page_edit'): echo "in"; endif; ?>">
      <div class="accordion-inner">
    		<ul class="nav nav-list">
    			<li <?php if ( $this->uri->segment(3) == 'pages_list' || $this->uri->segment(3) == 'page_edit' ) : echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/admin_pages/pages_list'); ?>">List Pages</a></li>
    			<?php if ( $logged_info['role'] == 'admin') : ?><li <?php if ( $this->uri->segment(3) == 'page_create' || $this->uri->segment(3) == 'page_create_check') : echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/admin_pages/page_create'); ?>">Create a page</a></li><?php endif; ?>
    		</ul>
        <ul class="nav nav-list">
          <li> <a href="#">Navigation Menu</a> </li>
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
    <div id="collapseTwo" class="accordion-body collapse <?php if ( $this->uri->segment(3) == 'posts_list' || $this->uri->segment(3) == 'post_create' || $this->uri->segment(3) == 'post_create_check' || $this->uri->segment(3) == 'post_edit'): echo "in"; endif; ?>">
      <div class="accordion-inner">
		<ul class="nav nav-list">
			<li <?php if ( $this->uri->segment(3) == 'posts_list' || $this->uri->segment(3) == 'post_edit' ): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/admin_posts/posts_list'); ?>">List Posts</a></li>
			<?php if ( $logged_info['role'] == 'admin') : ?><li <?php if ( $this->uri->segment(3) == 'post_create'): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/admin_posts/post_create'); ?>">Create a Post</a></li><?php endif; ?>
		</ul>
      </div>
    </div>
  </div>
</div>
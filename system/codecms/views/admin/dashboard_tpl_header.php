<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
	<title><?php echo $this->template->title->default("Default title"); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $this->template->description; ?>">
	<meta name="author" content="">
	<?php echo $this->template->meta; ?>
	<?php echo $this->template->stylesheet; ?>

    <style>
      body { padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */ }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/ico/favicon.ico'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('assets/ico/apple-touch-icon-144-precomposed.png'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('assets/ico/apple-touch-icon-114-precomposed.png'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('assets/ico/apple-touch-icon-72-precomposed.png'); ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('assets/ico/apple-touch-icon-57-precomposed.png'); ?>">
  </head>

  <body class="dashboard admin">

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo base_url(); ?>">Code CMS</a>
          <div class="nav-collapse collapse">
            <ul class="nav">            
              <li <?php if ( $this->uri->segment(3) == 'dashboard'): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/admin_main/dashboard'); ?>">Dashboard</a></li>

              <?php if ( $logged_info['role'] == 'admin') : ?>
              
              <!-- USER MANAGEMENT-->
              <li class="dropdown <?php if ( $this->uri->segment(3) == 'users_list' || $this->uri->segment(3) == 'users_create'): echo "active"; endif; ?>">
                <a href="<?php echo base_url('admin/admin_main/users_list'); ?>">Manage Users</a>
              </li>            

              <?php endif; ?>

              <!-- PAGE MANAGEMENT-->
              <li class="dropdown <?php if ( $this->uri->segment(3) == 'pages_list' || $this->uri->segment(3) == 'page_create'): echo "active"; endif; ?>">
                <a href="<?php echo base_url('admin/admin_pages/pages_list'); ?>">Manage Pages</a>
              </li>

              <!-- POST MANAGEMENT-->
              <li class="dropdown <?php if ( $this->uri->segment(3) == 'posts_list' || $this->uri->segment(3) == 'post_create'): echo "active"; endif; ?>">
                <a href="<?php echo base_url('admin/admin_posts/posts_list'); ?>">Manage Post</a>
              </li>
            
            <?php if ( $logged_info['role'] == 'admin') : ?>
            
              <!-- SETTINGS -->
              <li <?php if ( $this->uri->segment(3) == 'settings'): echo "class='active'"; endif; ?>><a href="<?php echo base_url('admin/admin_main/settings'); ?>">Settings</a> </li>

            <?php endif; ?>              

            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

    <div id="user_detail" class="input-block-level">      
      <div class="btn-group pull-right">
        <a class="btn btn-primary" href="<?php echo base_url('admin/admin_main/user_profile'); ?>"><i class="icon-user icon-white"></i> <?php echo $logged_info['first_name'] .' '. $logged_info['last_name']  ?></a>
        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo base_url('admin/admin_main/user_profile'); ?>"><i class="icon-star"></i> View Profile</a></li>
          <li><a href="<?php echo base_url('admin/admin_main/users_update') . '/' . $logged_info['users_id']; ?>"><i class="icon-pencil"></i> Edit Profile</a></li>
          <li><a href="<?php echo base_url("admin/admin_main/logout"); ?>"><i class="icon-off"></i> Log Out</a></li>
          <li class="divider"></li>
          <li><?php echo form_open('admin/admin_main/delete_account', 'id="delete_my_account"'); ?>
            <button class="btn btn-danger bt-small input-block-level" name="delete_account" id="delete_account" value="<?php echo $logged_info['users_id']; ?>" onClick="return confirm('Are you sure you want to delete your acccount?')"> <i class="icon-remove icon-white">&nbsp;</i> Delete Account</button>
              <?php echo form_close(); ?>            
        </ul>
      </div>      
    </div>

  <!-- THIS IS NEEDED FOR THE OTHER PAGES AS THEY ARE REFERENCING TO THIS HEADER -->    
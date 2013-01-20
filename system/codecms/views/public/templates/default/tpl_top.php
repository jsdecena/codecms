<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!doctype html>
<html>
<head>
	<title><?php echo $this->template->title->default("Default title"); ?></title>
	<meta charset="utf-8">
	<meta name="description" content="<?php echo $this->template->description; ?>">
	<meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo $this->template->meta; ?>
	<?php echo $this->template->stylesheet; ?>
    <!-- Fav and touch icons -->
    
    <link rel="shortcut icon" href="<?php echo base_url('assets/ico/favicon.ico'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('assets/ico/apple-touch-icon-144-precomposed.png'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('assets/ico/apple-touch-icon-114-precomposed.png'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('assets/ico/apple-touch-icon-72-precomposed.png'); ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('assets/ico/apple-touch-icon-57-precomposed.png'); ?>">

</head>
<body>

<div class="container tpl_default">

  <div class="masthead">
        <h3 class="muted"> <a class="logo" href="<?php echo base_url(); ?>"> Code CMS</a></h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <li> <a href="<?php echo base_url(); ?>">Home</a></li>
                <?php
                  if ( is_array($pages) && isset($pages) ):
                  foreach ($pages as $page) : if( $page['status'] == 'published') : ?>
                    <li><a href="<?php echo base_url('page/view') .'/'. $page['slug']; ?>"><?php echo $page['title']; ?></a></li>
                <?php endif; endforeach; endif; ?>
                <li> <a href="<?php echo base_url('blog/posts_list'); ?>">Blog</a></li>
                <li> <a href="<?php echo base_url('contact'); ?>">Contact</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
  </div>    

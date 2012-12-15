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

<div class="container">

  <?php echo $this->template->content; ?>

    <footer>
    <p><?php // echo $this->template->copyright->default("There is no copyright"); ?></p>
    </footer>

</div> <!-- END CONTAINER CLASS -->

<script src="//code.jquery.com/jquery-latest.min.js"></script>
<?php echo $this->template->javascript; ?>

</body>
</html>
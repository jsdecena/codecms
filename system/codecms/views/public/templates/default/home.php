<!-- THIS IS THE CONTENT-->


<!-- Jumbotron -->
<div class="jumbotron">
  <h1>Code CMS!</h1>
  <p class="lead">CodeCMS is a pet project of <a href="http://jsdecena.me">Jeff Simons Decena.</a> It aims to be an alternative open source CMS software made from the Manila, Philippines. Currently, this is ver 0.1 stable release. <br /> You can contribute on this project by forking <a href="https://bitbucket.org/jsdecena/codecms">this.</a></p>
  <a class="btn btn-large btn-success" href="https://bitbucket.org/jsdecena/codecms/get/3e0d3a1ad9b4.zip">Download Now!</a>
</div>

<hr>

<!-- Example row of columns -->
<div class="row-fluid">

  <?php if ( is_array($all_posts) ) : foreach ($all_posts as $row) : $slug = $row['slug']; ?>

  <div class="span4">
    <h2><a href="<?php echo base_url("blog/post/$slug"); ?>"><?php echo character_limiter($row['title'], 15); ?></a></h2>
    <?php echo word_limiter($row['content'], 50); ?>
    <p><a class="btn" href="<?php echo base_url("blog/post/$slug"); ?>">View details &raquo;</a></p>
  </div>

  <?php endforeach; endif; //END ALL POSTS ROW ?>

</div>
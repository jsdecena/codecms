<!-- THIS IS THE CONTENT-->


<!-- Jumbotron -->
<div class="jumbotron">
  <h1>Code CMS!</h1>
  <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
  <a class="btn btn-large btn-success" href="https://bitbucket.org/jsdecena/codecms">Download Now!</a>
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
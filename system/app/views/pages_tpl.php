<?php $this->load->view('pages_tpl_top'); ?>

<div class="span9 content_area">
  
  <?php echo $this->template->content; ?>
  
</div>

<div class="span3 sidebar">
  
  <p>Sidebar</p>

  <?php 

    //WIDGET SIDEBAR
    // echo $this->template->content; 

  ?>

</div>
<?php $this->load->view('pages_tpl_btm'); ?>
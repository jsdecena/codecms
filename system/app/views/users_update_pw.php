<?php // var_dump($data); die(); ?>

<div class="row clearfix:after">
  
  <div class="span3 sidebar">
  
  <?php  $this->load->view('admin/profile_update_sidebar');?>
    
  </div>

<div class="span9">

  <section class="update_pw_page">

    <div class="controlgroup">
      
      <div class="page-header"> Update your password </div>
      
      <?php
          $attr = array('class' => 'form-signin', 'id' => 'create_user_form');
          echo form_open('admin/main/users_update_specific_pw', $attr);
      ?>

      <div class="text-success"> 
        <?php if ( $this->session->flashdata('update_success') ) : echo $this->session->flashdata('update_success'); endif; ?> 
      </div>

      <div class="text-error"> 
          <?php 
                if ( $this->session->flashdata('invalid_pw') ) : echo $this->session->flashdata('invalid_pw');
                  elseif ( $this->session->flashdata('update_error') ) : echo $this->session->flashdata('update_error');
                endif; ?> 
      </div>
      
      <?php foreach ($data as $user_data) : ?>
          <input type="hidden" value="<?php echo $user_data->id; ?>" name="id">
          <label for="password">Password</label>
          <input type="password" class="input-block-level" name="password" placeholder="Password" value="">
      <?php endforeach; ?>

      <?php echo anchor('admin/main/user_profile', 'Go back', 'class="btn btn-info"'); ?>
      <input type="submit" name="save" class="btn btn-primary" value="Change Password" />
    
      <?php echo form_close(); ?>       

    </div>   

  </section>

</div> <!-- /row -->
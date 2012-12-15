<div class="row">

  <div class="span3 sidebar">
    
    <?php echo $this->load->view('admin/users_list_sidebar'); ?>

  </div>

  <div class="span9">

    <div class="page-header"> Create a User </div>    
    
    <?php

    $attr = array('class' => 'form-signin', 'id' => 'create_user_form');
      echo form_open('admin/main/users_create_check', $attr); 

    ?>
    
    <div class="text-success"> <?php if( $this->session->flashdata('create_success')) : echo $this->session->flashdata('create_success'); else: echo $this->session->flashdata('create_error'); endif; ?> </div>
    <?php if ( validation_errors() ) : ?>
      <div class="text-error alert-block alert-error fade in"> 
        <a class="close" data-dismiss="alert">&times;</a>
        <?php echo validation_errors(); ?>
      </div>
    <?php endif;  ?>

  <input type="text" class="input-block-level" name="username" placeholder="Username" value="<?php echo $this->input->post('username'); ?>">
  <input type="text" class="input-block-level" name="first_name" placeholder="First Name" value="<?php echo $this->input->post('first_name'); ?>">
  <input type="text" class="input-block-level" name="last_name" placeholder="Last Name" value="<?php echo $this->input->post('last_name'); ?>">
    <input type="text" class="input-block-level" name="email" placeholder="Email address" value="<?php echo $this->input->post('email'); ?>">
    <select name="role" id="role">
      <option value="0" selected="selected">Select Role</option>
      <option value="admin">Admin</option>
      <option value="subscriber">Subscriber</option>
    </select>
    <input type="password" class="input-block-level" name="password" placeholder="Password" value="<?php echo $this->input->post('email'); ?>">
   
   <input type="submit" name="create" class="btn btn-primary" value="Create a user" />
  
  <?php echo form_close(); ?>
  </div>  

</div> <!-- END ROW -->

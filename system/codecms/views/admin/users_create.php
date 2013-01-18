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
    
  <p class="text-success"> <?php if( $this->session->flashdata('create_success')) : echo $this->session->flashdata('create_success'); else: echo $this->session->flashdata('create_error'); endif; ?> </p>
  
  <div class="control-group">
    <div class="controls">      
        <div class="control-group">                
          <div class="controls">
            <label for="username" class="control-label">Username</label>
            <input type="text" class="input-large" name="username" placeholder="Username" value="<?php echo $this->input->post('username'); ?>">
            <?php echo form_error('username', '<span class="text-error">', '</span>'); ?>
          </div>        
        </div>
        <div class="control-group">
          <div class="controls">
            <label for="firstname">First Name</label>
            <input type="text" class="input-large" name="first_name" placeholder="First Name" value="<?php echo $this->input->post('first_name'); ?>">
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <label for="lastname">Last Name</label>
            <input type="text" class="input-large" name="last_name" placeholder="Last Name" value="<?php echo $this->input->post('last_name'); ?>">
          </div>
        </div>
        <div class="control-group">                
          <div class="controls">
            <label for="email">Email Address</label>
            <input type="text" class="input-large" name="email" placeholder="Email address" value="<?php echo $this->input->post('email'); ?>">
            <?php echo form_error('email', '<span class="text-error">', '</span>'); ?>
          </div>
        </div>

        <div class="control-group">          
          <div class="controls">    
            <label for="role">Your Role</label>
            <select name="role" id="role">
              <option value="0" <?php if ( $this->input->post('role') == '0') : ?>selected="selected"<?php endif; ?>>Select Role</option>
              <option value="admin" <?php if ( $this->input->post('role') == 'admin') : ?>selected="selected"<?php endif; ?>>Admin</option>
              <option value="subscriber" <?php if ( $this->input->post('role') == 'subscriber') : ?>selected="selected"<?php endif; ?>>Subscriber</option>
            </select>

            <?php echo form_error('role', '<span class="text-error">', '</span>'); ?>   
          </div>
        </div>
        <div class="control-group">          
          <div class="controls">      
            <label for="password">Password</label>
            <input type="password" class="input-large" name="password" placeholder="Password" value="<?php echo $this->input->post('email'); ?>">
            <?php echo form_error('password', '<span class="text-error">', '</span>'); ?>
          </div>
        </div>
      
      <input type="submit" name="create" class="btn btn-primary" value="Create a user" />        

    </div> 
  </div>   
  
  <?php echo form_close(); ?>
  </div>  

</div> <!-- END ROW -->

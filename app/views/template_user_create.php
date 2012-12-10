<div class="container">

  	<?php

		$attr = array('class' => 'form-signin', 'id' => 'create_user_form');
  		echo form_open('admin/users_create_check', $attr); 

  	?>

    <h2 class="form-signin-heading">Create a user</h2>
    
    <div class="text-success"> <?php if( $this->session->flashdata('create_success')) : echo $this->session->flashdata('create_success'); else: echo $this->session->flashdata('create_error'); endif; ?> </div>
    <div class="text-error"> <?php if ( validation_errors() ) : echo validation_errors(); endif; ?> </div>

	<input type="text" class="input-block-level" name="username" placeholder="Username" value="<?php echo $this->input->post('username'); ?>">
  <input type="text" class="input-block-level" name="first_name" placeholder="First Name" value="<?php echo $this->input->post('first_name'); ?>">
	<input type="text" class="input-block-level" name="last_name" placeholder="Last Name" value="<?php echo $this->input->post('last_name'); ?>">
    <input type="text" class="input-block-level" name="email" placeholder="Email address" value="<?php echo $this->input->post('email'); ?>">
    <select name="role" id="role">
    	<option value="0" selected="selected">Select Role</option>
    	<option value="2">Admin</option>
    	<option value="1">Subscriber</option>
    </select>
    <input type="password" class="input-block-level" name="password" placeholder="Password" value="<?php echo $this->input->post('email'); ?>">
   
   <input type="submit" name="create" class="btn btn-primary" value="Create a user" />
	
	<?php echo form_close(); ?>

</div> <!-- /container -->

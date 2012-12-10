<div class="container">

  	<?php
  		  $attr = array('class' => 'form-signin', 'id' => 'create_user_form');
    		echo form_open('admin/users_update_specific', $attr);
  	?>

    <h2 class="form-signin-heading">Update user details</h2>
    
    <div class="text-success"> 
      <?php 
          
          if ( $this->session->flashdata('update_success') ) : echo $this->session->flashdata('update_success');

            elseif ( $this->session->flashdata('last_user') ) : echo $this->session->flashdata('last_user');
            
            else: echo $this->session->flashdata('update_error');
          
          endif;
      ?> 
    </div>
    <div class="text-error"> <?php if ( validation_errors() ) : echo validation_errors(); endif; ?> </div>
    
    <?php foreach ($data as $user_data): ?>
    
      <input type="hidden" value="<?php echo $user_data->id; ?>" name="id">
      <label for="username">Username</label>
      <input type="text" class="input-block-level" name="username" value="<?php echo $user_data->username; ?>" disabled>

      <label for="first_name">First Name</label>
      <input type="text" class="input-block-level" name="first_name" value="<?php echo $user_data->first_name; ?>">
      
      <label for="last_name">Last Name</label>
      <input type="text" class="input-block-level" name="last_name" value="<?php echo $user_data->last_name; ?>">
      
      <label for="email">Email</label>
      <input type="text" class="input-block-level" name="email" value="<?php echo $user_data->email; ?>">
      
      <label for="role">User Role</label>
      <select name="role" id="role">
        <option value="0">Select Role</option>
      	<option value="2" <?php if ( $user_data->role == '2' ): echo "selected=\"selected\""; endif; ?>>Admin</option>
      	<option value="1" <?php if ( $user_data->role == '1' ): echo "selected=\"selected\""; endif; ?>>Subscriber</option>
      </select>

      <label for="password">Password</label>
      <input type="password" class="input-block-level" name="password" placeholder="Password" value="<?php echo $user_data->password; ?>">

    <?php endforeach; ?>

    <input type="submit" name="save" class="btn btn-primary" value="Update user details" />
	
	<?php echo form_close(); ?>

</div> <!-- /container -->
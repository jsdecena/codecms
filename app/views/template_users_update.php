<div class="container">

    <div class="page-header"> <h4>Update your details</h4> </div>
  	
    <?php
  		  $attr = array('class' => 'form-signin', 'id' => 'create_user_form');
    		echo form_open('admin/users_update_specific', $attr);
  	?>
    
    <div class="text-success"> 
      <?php if ( $this->session->flashdata('update_success') ) : echo $this->session->flashdata('update_success'); else: echo $this->session->flashdata('update_error'); endif; ?> 
    </div>
    <div class="text-error"> 

      <?php 
          
          if ( validation_errors() ) : echo validation_errors(); endif; 
          if ( $this->session->flashdata('needs_user_role') ) : echo $this->session->flashdata('needs_user_role'); elseif ( $this->session->flashdata('last_user') ) : echo $this->session->flashdata('last_user'); endif;
      ?> 
    </div>
    
    <?php foreach ($data as $user_data): ?>
    
      <input type="hidden" value="<?php echo $user_data->id; ?>" name="id">
      <label for="username" class="muted">Username</label>
      <input type="text" class="input-block-level" name="username" value="<?php echo $user_data->username; ?>">

      <label for="first_name" class="muted">First Name</label>
      <input type="text" class="input-block-level" name="first_name" value="<?php echo $user_data->first_name; ?>">
      
      <label for="last_name" class="muted">Last Name</label>
      <input type="text" class="input-block-level" name="last_name" value="<?php echo $user_data->last_name; ?>">
      
      <label for="email" class="muted">Email</label>
      <input type="text" class="input-block-level" name="email" value="<?php echo $user_data->email; ?>">
      
      <label for="role" class="muted">User Role</label>
      <select name="role" id="role">
        <option value="0">Select Role</option>
      	<option value="admin" <?php if ( $user_data->role == 'admin' ): echo "selected=\"selected\""; endif; ?>>Admin</option>
      	<option value="subscriber" <?php if ( $user_data->role == 'subscriber' ): echo "selected=\"selected\""; endif; ?>>Subscriber</option>
      </select>

      <label for="about" class="muted">About You</label>
      <textarea rows="5" column="10" name="about" class="about input-block-level"><?php echo $user_data->about; ?></textarea>

    <?php endforeach; ?>

    <input type="submit" name="save" class="btn btn-primary" value="Update your details" />
	
	<?php echo form_close(); ?>

</div> <!-- /container -->
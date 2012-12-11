<div class="container users_update">

    <div class="page-header"> <h4>Update your details</h4> </div>
  	
    <div class="controlgroup">

      <?php if ( $this->session->flashdata('update_success') ) : ?>
      
        <div class="controls text-success"> 
          <?php echo $this->session->flashdata('update_success'); else: echo $this->session->flashdata('update_error'); ?> 
        </div>

      <?php endif; ?>

      <?php if ( validation_errors() ) :  ?>
      <div class="controls text-error"> 
        <?php echo validation_errors(); ?> 
      </div>
      <?php endif;  ?>

      <?php if ( $this->session->flashdata('needs_user_role') ) : ?>      
      <div class="controls text-error"> 
        <?php echo $this->session->flashdata('needs_user_role'); elseif ( $this->session->flashdata('last_user') ) : echo $this->session->flashdata('last_user'); ?>
      </div>
      <?php endif; ?>

    </div>
    
    <?php
  		  $attr = array('class' => 'form-signin', 'id' => 'create_user_form');
    		echo form_open('admin/users_update_specific', $attr);
  	?>
    
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
      <?php if ( $role == 'admin') : ?>
      
      <label for="role" class="muted">User Role</label>
      <select name="role" id="role">
        <option value="0">Select Role</option>
      	<option value="admin" <?php if ( $user_data->role == 'admin' ): echo "selected=\"selected\""; endif; ?>>Admin</option>
      	<option value="subscriber" <?php if ( $user_data->role == 'subscriber' ): echo "selected=\"selected\""; endif; ?>>Subscriber</option>
      </select>
      <?php endif; ?>

      <label for="about" class="muted">About You</label>
      <textarea rows="5" column="10" name="about" class="about input-block-level"><?php echo $user_data->about; ?></textarea>

    <?php endforeach; ?>

    <input type="submit" name="save" class="btn btn-primary" value="Update your details" />
	
	<?php echo form_close(); ?>

</div> <!-- /container -->
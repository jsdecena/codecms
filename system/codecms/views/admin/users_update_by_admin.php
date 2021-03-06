<div class="row users_update">

  <div class="span3 sidebar">
  
    <?php  $this->load->view('admin/users_list_sidebar');?>
    
  </div>  

  <div class="span9">
  
    <section class="update_details">    
      
      <div class="controlgroup">

        <div class="page-header"> Edit this user details </div>

        <?php if ( $this->session->flashdata('message_success') ) : ?>

        <div class="text-success alert-block alert-success fade in">
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('message_success'); ?> 
        </div>

        <?php elseif ( $this->session->flashdata('message_error') ): ?>

        <div class="text-error alert-block alert-error fade in"> 
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('message_error'); ?> 
        </div>      

        <?php endif; ?>            

      <?php
          $attr = array('class' => 'form-signin', 'id' => 'create_user_form');
          echo form_open('admin/admin_main/users_update_specific_by_admin', $attr);
      ?>
      
      <?php foreach ($data as $user_data): ?>
      
        <input type="hidden" value="<?php echo $user_data->users_id; ?>" name="users_id">
        <label for="username" class="muted">Username</label>
        <input type="text" class="input-block-level" name="username" value="<?php echo $user_data->username; ?>">

        <label for="first_name" class="muted">First Name</label>
        <input type="text" class="input-block-level" name="first_name" value="<?php echo $user_data->first_name; ?>">
        
        <label for="last_name" class="muted">Last Name</label>
        <input type="text" class="input-block-level" name="last_name" value="<?php echo $user_data->last_name; ?>">
        
        <label for="email" class="muted">Email <sup class="text-error">*</sup></label>
        <input type="text" class="input-block-level" name="email" value="<?php echo $user_data->email; ?>">
        
        <?php if ( $logged_info['role'] == 'admin') : ?>
        
          <label for="role" class="muted">User Role <sup class="text-error">*</sup></label>
          <select name="role" id="role">
            <option value="0">Select Role</option>
            <option value="admin" <?php if ( $user_data->role == 'admin' ): echo "selected=\"selected\""; endif; ?>>Admin</option>
            <option value="subscriber" <?php if ( $user_data->role == 'subscriber' ): echo "selected=\"selected\""; endif; ?>>Subscriber</option>
          </select>
        
        <?php endif; ?>

        <label for="about" class="muted">About You</label>
        <textarea rows="5" column="10" name="about" class="about input-block-level ckeditor"><?php echo $user_data->about; ?></textarea>

      <?php endforeach; ?>

      <br class="clear" />
      <a href="<?php echo base_url('admin/admin_main/users_list'); ?>" class="btn btn-info">Go Back</a>
      <input type="submit" name="save" class="btn btn-primary" value="Update details" />
    
      <?php echo form_close(); ?>      

    </div>

  </section>


</div>

</div> <!-- /row -->
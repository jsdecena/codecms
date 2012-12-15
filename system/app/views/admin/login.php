<?php if ( $this->uri->segment(2) == 'login' || $this->uri->segment(2) == 'login_check' ) : ?>

	<?php 
		$attr = array('class' => 'form-signin', 'id' => 'myform');
		echo form_open('admin/login_check', $attr); 
	?>
	<h2 class="form-signin-heading">Log In Now</h2>
	
	<?php if ( validation_errors() ) : ?>
		<div class="text-error"> <?php echo validation_errors(); ?> </div>
	<?php endif; ?>
	
	<?php if( $this->session->flashdata('message_error')) :  ?>
		<div class="text-error"> <?php echo $this->session->flashdata('message_error') ?> </div>
	<?php else: ?>
		<div class="text-success"> <?php echo $this->session->flashdata('message_success') ?> </div>			
	<?php endif; ?>		

	<input type="text" class="input-block-level" name="email" placeholder="Email address" value="<?php echo $this->input->post('email'); ?>">
	<input type="password" class="input-block-level" name="password" placeholder="Password" value="<?php echo $this->input->post('email'); ?>">
	<label for="forgot_password">
	 <a href="<?php echo base_url('admin/forget_password'); ?>">Forgot Password?</a>
	</label>
	<button class="btn btn-sml btn-primary" type="submit">Log in</button>
	</form>

<?php elseif ( $this->uri->segment(2) == 'forget_password' || $this->uri->segment(2) == 'forget_password_check' ) : //SHOW THE FORGET PASSWORD FIELDS ?>

	<?php 

	$attr = array('class' => 'form-signin', 'id' => 'myform');
	  echo form_open('admin/forget_password_check', $attr);
	?>
	<h2 class="form-signin-heading">Enter your email</h2>
	
	<?php if ( validation_errors() ) :  ?>
		<div class="text-error"> <?php echo validation_errors(); ?> </div>
	<?php endif; ?>

	<?php if( $this->session->flashdata('message_error')) :  ?>
		<div class="text-error"> <?php echo $this->session->flashdata('message_error') ?> </div>
	<?php else: ?>
		<div class="text-success"> <?php echo $this->session->flashdata('message_success') ?> </div>	
	<?php endif; ?>	

	<input type="email" class="input-block-level" name="email" placeholder="Email" value="<?php echo $this->input->post('email'); ?>">

	<button class="btn btn-sml btn-primary" type="submit" name="get_password">Retrieve Password</button>
	</form>

<?php endif; ?>
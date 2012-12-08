<div class="container">

  	<?php 

		$attr = array('class' => 'form-signin', 'id' => 'myform');
	  	echo form_open('admin/login_check', $attr); 
  	?>
    <h2 class="form-signin-heading">Please sign in</h2>
    
    <div class="text-error"> <?php if ( validation_errors() ) : echo validation_errors(); endif; ?> </div>

    <input type="text" class="input-block-level" name="email" placeholder="Email address" value="<?php echo $this->input->post('email'); ?>">
    <input type="password" class="input-block-level" name="password" placeholder="Password" value="<?php echo $this->input->post('email'); ?>">
    <label class="checkbox">
      <input type="checkbox" value="remember-me"> Remember me
    </label>
    <button class="btn btn-large btn-primary" type="submit">Sign in</button>
  </form>

</div> <!-- /container -->
	<?php 

	$attr = array('class' => 'form-signin', 'id' => 'myform');
	  echo form_open('admin/main/insert_new_pw', $attr);
	?>
	<h2 class="form-signin-heading">New Password</h2>
	
	<?php if ( validation_errors() ) :  ?>
		<div class="text-error"> <?php echo validation_errors(); ?> </div>
	<?php endif; ?>

	<input type="hidden" class="input-block-level" name="key" value="<?php echo $key; ?>">
	
	<div class="control-group">
		<label for="password">Password</label>
		<div class="control">
			<input type="password" class="input-block-level" name="password" placeholder="Password" value="">
		</div>
	</div>

	<button class="btn btn-sml btn-primary" type="submit" name="create_new_password">Create New Password</button>
	</form>
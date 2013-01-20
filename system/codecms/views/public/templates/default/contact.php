<!-- THIS IS THE ACTUAL PAGE CONTENT-->

<section id="main_content" class="contact">

<h2>Contact page</h2>


	<?php echo form_open_multipart('contact/form_submit_validation', 'id="form_submit" class="form-horizontal'); ?>

	<?php if ( validation_errors() ) :  ?>
	  <div class="text-error alert-block alert-error fade in">
	  	<a class="close" data-dismiss="alert">&times;</a>
	    <?php echo validation_errors(); ?> 
	  </div>
	<?php endif;  ?>

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

	<div class="control-group">
		<label for="first_name" class="control-label">First Name: <span class="text-error">*</span></label> 
		<div class="controls">
			<input type="text" name="first_name" id="first_name" class="input-xlarge" placeholder="First Name" value="<?php echo $this->input->post('first_name'); ?>" />			
		</div>
	</div>

	  <div class="control-group">
	    <label class="control-label" for="last_name">Last Name:</label>
	    <div class="controls">
	      <input type="text" name="last_name" id="last_name" class="input-xlarge" placeholder="Last Name" value="<?php echo $this->input->post('last_name'); ?>" />
	    </div>
	  </div>

	<div class="control-group">
	    <label class="control-label" for="email">Email: <span class="text-error">*</span></label>
	    <div class="controls">
	      <input type="text" name="email" id="email" class="input-xlarge" placeholder="Email" value="<?php echo $this->input->post('email'); ?>" />	      
	    </div>
	</div>

	<div class="control-group">
	    <label class="control-label" for="website">Website:</label>
	    <div class="controls">
	      <input type="text" name="website" id="website" class="input-xlarge" placeholder="Website" value="<?php echo $this->input->post('website'); ?>" />
	    </div>
	</div>

	<div class="control-group">
		<label for="reason" class="control-label">How may I help you?: <span class="text-error">*</span></label>
		<div class="controls">
			<input type="text" name="reason" id="reason" class="input-xlarge" placeholder="How may I help you?" value="<?php echo $this->input->post('reason'); ?>" />			
		</div>
	</div>	

	<div class="control-group">
		<label class="control-label" for="message">Message:</label>
		<div class="controls">
		  <textarea name="message" id="message" class="input-xlarge" cols="30" rows="10" placeholder="Your Message" value="<?php echo $this->input->post('message'); ?>"></textarea>
		</div>
	</div>

	<div class="controls">
	  <button type="submit" name="send_message" class="btn btn-primary">Send Message</button>	  
	</div>

	<?php echo form_close(); ?>
	
</section>
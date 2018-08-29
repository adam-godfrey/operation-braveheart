<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php if(isset($this->success)) : ?>
			<?php if($this->success) : ?>
			<div id="form-submit" class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				Success! Well done its submitted.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<p>We welcome your enquiries, so please get in touch. We'd like to help you as quickly as possible, so please contact us via email or use our enquiry form below.  We endeavour to respond to your enquiry within 72 hours.</p>
			<div class="row">
				<div class="col-md-6">
					<h2>Write to Us</h2>
					<address>
						David Godfrey<br>
						<strong>Operation Braveheart</strong><br>
						82 New Street<br>
						Cullompton<br>
						Devon<br>
						EX15 1HD
					</address>
				</div>
				<div class="col-md-6">
					<h2>Email</h2>
					<p><a href="#"><span id="my-email">please enable javascript to view</span></a></p>
				</div>
			</div>
			<div id="webform">
				<h2>Submit Enquiry</h2>
				<?php echo Form::open(array('id' => 'contactForm', 'class' => 'form form-horizontal', 'action' => URL . 'contact', 'method' => 'post', 'role' => 'form'));?>
					<div>
						<?php echo Form::input(array('type' => 'hidden', 'name' => 'token', 'value' => $this->token));?>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="fullname">Name</label>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'fullname', 'id' => 'fullname', 'placeholder' => 'Name'));?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="email">Email</label>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'email', 'id' => 'email', 'placeholder' => 'Email'));?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="web">Website (optional)</label>	
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'web', 'id' => 'web', 'placeholder' => 'Website'));?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="email">Subject</label>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'subject', 'id' => 'subject', 'placeholder' => 'Subject'));?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="comment">Message</label>
							<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'comment', 'id' => 'comment'), '');?>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<div class="captchatext">
								<img id="captcha" src="<?=URL;?>util/visual-captcha.php" width="200" height="60" alt="Visual CAPTCHA" />
							</div>
							<p id="refresh">Not readable? Change text.</p>
						</div>
					</div>
					<div class="form-group">
						<div class=" col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="captcha">Anti-SPAM</label>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'captcha', 'id' => 'captcha', 'placeholder' => 'Anti-SPAM'));?>
							<span class="help-block">Please enter the anti-spam text to show you are a real person</span>
						</div>
					</div>
					<?php echo Form::input(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'send'), 'Send Message');?>

				<?php echo Form::close();?>
			</div>
		</div>
	</div>
</div>
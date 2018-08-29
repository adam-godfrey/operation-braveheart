<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div id="webform">
				<?php echo Form::open(array('id' => 'registerForm', 'class' => 'form form-horizontal', 'action' => URL . 'register/create', 'method' => 'post', 'role' => 'form'));?>
				<fieldset>
					<legend><h2>Step 1: Enter User Information</h2></legend>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="first_name">Forename</label>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'first_name', 'id' => 'first_name', 'title' => 'Please enter your first name', 'placeholder' => 'Forename'));?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="last_name">Surname</label>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'last_name', 'id' => 'last_name', 'title' => 'Please enter your last name', 'placeholder' => 'Surname'));?>
						</div>
					</div>
					<div class="form-group has-feedback">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="email">Email</label>
							<?php echo Form::input(array('type' => 'email', 'class' => 'form-control text-input', 'name' => 'email', 'id' => 'email', 'title' => 'Please enter your email address', 'placeholder' => 'Email'));?>
							<span class="glyphicon form-control-feedback"></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="confemail">Confirm Email</label>
							<?php echo Form::input(array('type' => 'email', 'class' => 'form-control text-input', 'name' => 'confemail', 'id' => 'confemail', 'title' => 'Please confirm your email address', 'placeholder' => 'Email'));?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="email">Interests <span class="smalltxt">(optional)</span></label>
							<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'interests', 'id' => 'interests', 'title' => 'Please enter any interests/hobbies you have', 'placeholder' => 'Interests'));?>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend><h2>Step 2: Enter Account Information</h2></legend>
					<div class="form-group has-feedback">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="username">Username</label>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'username', 'id' => 'username', 'title' => 'Please enter a username', 'placeholder' => 'Username'));?>
							<span class="glyphicon form-control-feedback"></span>
							<p class="help-block">Please enter a username for your user account. Note that username should be between 4 and 30 characters.</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="passwordInput">Password</label>
							<?php echo Form::input(array('type' => 'password', 'class' => 'form-control text-input', 'name' => 'passwordInput', 'id' => 'passwordInput', 'title' => 'Please enter a password', 'placeholder' => 'Password'));?>
							<p class="help-block">Please enter a password for your user account. Note that passwords are case-sensitive.</p>

							<div class="" id="passwordStrength"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="confirmPasswordInput">Verify Password</label>
							<?php echo Form::input(array('type' => 'password', 'class' => 'form-control text-input', 'name' => 'confirmPasswordInput', 'id' => 'confirmPasswordInput', 'title' => 'Please re-enter your password', 'placeholder' => 'Password'));?>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend><h2>Step 3: Sign Up for our Newsletter?</h2></legend>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="newsletter">Newsletter</label>
							<p><?php echo Form::input(array('type' => 'checkbox', 'class' => 'radiobutton', 'name' => 'newsletter', 'id' => 'newsletter', 'value' => 'yes'));?> Sign me Up</p>
							<p class="help-block">Sign up for operation-braveheart.org.uk newsletter. This newsletter includes what fundraising events are happening soon, our latest news and any other points of interest. You can Opt-out at any time....so sign up and give it a try!! <a href="<?= URL; ?>privacy"><span class="hint">Privacy Policy</span></a></p>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend><h2>Step 4: Agree our Terms &amp; Conditions</h2></legend>
					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<p><?php echo Form::input(array('type' => 'checkbox', 'class' => 'radiobutton', 'name' => 'termscheck', 'id' => 'termscheck', 'value' => 'yes'));?> I have read and accepted the <a href="<?= URL; ?>terms"><span class="hint">Terms &amp; Conditions</span></a></p>
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
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label class="control-label" for="captchaimg">Anti-Spam Verification</label>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'captchaimg', 'id' => 'captchaimg', 'title' => 'Please enter captcha text', 'placeholder' => ''));?>
						</div>
					</div>
				</fieldset>
				<div class="form-group">
					<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
						<?php echo Form::input(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'send', 'value' => 'Register'));?>
					</div>
				</div>
				<?php echo Form::close();?>
			</div>
		</div>
	</div>
</div>
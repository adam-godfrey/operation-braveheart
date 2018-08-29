<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php if(isset($this->success)) : ?>
			<?php if($this->success) : ?>
			<div id="form-submit" class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Success!</strong> <?=$this->message;?>
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> <?=$this->message;?>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<p>If you have forgotten your password, please enter your email address into the box provided and we'll send you a new one.  Don't forget to change your new password once you receive it.</p>
			<div id="webform">
				<h2>Request New Password</h2>
				<?php echo Form::open(array('id' => 'newpassword', 'class' => 'form form-horizontal', 'action' => 'forgot-password/request', 'method' => 'post', 'role' => 'form'));?>
				<div class="form-group">
					<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
						<label class="control-label" for="email">E-mail</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'email', 'id' => 'email', 'placeholder' => 'Email'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
						<?php echo Form::input(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'send', 'value' => 'Request New Password'));?>
					</div>
				</div>	
				<?php echo Form::close();?>
			</div>
		</div>
	</div>
</div>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php if(isset($this->success)) : ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> <?=$this->view->success;?>
			</div>
			<?php endif; ?>
			<div class="row">
				<div class="col-md-6 border-right login">
					<h3>NEW HERE?</h3>
					<span class="help-block"><i>Registration is free and easy.</i></span>
					<a class="btn btn-default btn-block" href="<?=URL;?>register">CREATE AN ACCOUNT</a>
				</div>
				<div class="col-md-6 border-left login">
					<h3>ALREADY REGISTERED?</h3>
					<span class="help-block"><i>If you have an account with us, please log in.</i></span>
					<?php echo Form::open(array('id' => 'loginForm', 'class' => 'form form-horizontal', 'action' => URL . 'login', 'method' => 'post', 'role' => 'form'));?>
					<div class="form-group">
						<div class="col-sm-12 col-md-12">
							<label class="control-label" for="username">Username or Email</label>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'username', 'id' => 'username'));?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12 col-md-12">
							<label class="control-label" for="password">Password</label>
							<?php echo Form::input(array('type' => 'password', 'class' => 'form-control text-input', 'name' => 'password', 'id' => 'password'));?>
						</div>
					</div>
					<p><a href="<?=URL;?>forgot-password">Forget Your Password?</a></p>
					<?php echo Form::input(array('type' => 'submit', 'class' => 'btn btn-default btn-block', 'name' => 'send'), 'LOGIN');?>
					<?php echo Form::close();?>
				</div>
			</div>
		</div>
	</div>
</div>
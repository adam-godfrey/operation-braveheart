<div id="content">
	<div class="content_item">
		<div class="content_item_main">
			<?php echo Form::open(array('name' => 'updateForm', 'id' => 'updateForm', 'action' => 'save', 'method' => 'post'));?>
			<?php echo Form::input(array('type' => 'button', 'class' => 'back', 'name' => 'backbutton', 'id' => 'back-button', 'title' => 'Go Back'));?>
			<?php echo Form::input(array('type' => 'button', 'class' => 'save', 'name' => 'savebutton', 'id' => 'save-button', 'title' => 'Save'));?>
			<fieldset>
				<legend>Current Password</legend>
				<div class="formgroup">
					<p class="hint">Please enter your current password to continue.</p>
					<label class="formlabel" for="currentpass">Email</label><br />
					<?php echo Form::input(array('type' => 'password', 'class' => 'text-input', 'name' => 'currentpass', 'id' => 'currentpass'));?>
				</div>
			</fieldset>
			<fieldset>
				<legend>Edit Password (optional)</legend>
				<div class="formgroup">
					<label class="formlabel" for="pass1">Email</label><br />
					<?php echo Form::input(array('type' => 'password', 'class' => 'text-input', 'name' => 'pass1', 'id' => 'pass1'));?>
				</div>
				<div class="formgroup">
					<label class="formlabel" for="pass2">Email</label><br />
					<?php echo Form::input(array('type' => 'password', 'class' => 'text-input', 'name' => 'pass2', 'id' => 'pass2'));?>
				</div>
			</fieldset>
			<fieldset>
				<legend>Edit Email (optional)</legend>
				<div class="formgroup">
					<label class="formlabel" for="email1">Email</label><br />
					<?php echo Form::input(array('type' => 'text', 'class' => 'text-input', 'name' => 'email1', 'id' => 'email1', 'value' => $this->email));?>
				</div>
				<div class="formgroup">
					<label class="formlabel" for="email2">Email</label><br />
					<?php echo Form::input(array('type' => 'text', 'class' => 'text-input', 'name' => 'email2', 'id' => 'email2', 'value' => $this->email));?>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
		<div class="content_item_bottom"></div>
	</div>
</div>

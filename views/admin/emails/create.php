<?php
	function Button($name) {
		global $buttons; // access the global $buttons array
		if(isset($buttons[$name])) {
			foreach($buttons[$name] as $attr_name => $attr_value)
				$attrs[] = sprintf('%s="%s"', $attr_name, $attr_value);
			return '<input type="button" '.implode(' ', $attrs).' />';
		}
		return;
	}
?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/emails', 'method' => 'post', 'role' => 'form'));?>
			<div id="admin-buttons">
				<?php foreach ($this->buttons as $button): ?>
				<?php echo Button($button); ?>
				<?php endforeach; ?>
			</div>
			<?php if(isset($this->success)) : ?>
			<?php if($this->success) : ?>
			<div id="form-submit" class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Success!</strong> Email sent.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Email not sent.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<fieldset>
				<legend><h2>Original Message Details</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="email_sender">SENDER</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'email_sender', 'id' => 'email_sender', 'value' => $this->email[0]['sender'], 'readonly' => 'readonly'));?>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="email_subject">SUBJECT</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'email_subject', 'id' => 'email_subject', 'value' => $this->email[0]['subject'], 'readonly' => 'readonly'));?>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="date_received">DATE RECEIVED</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'date_received', 'id' => 'date_received', 'value' => $this->email[0]['date_received'], 'readonly' => 'readonly'));?>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="email_content">MESSAGE</label>
						<?php echo Form::textarea(array('rows' => '20', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'email_content', 'id' => 'email_content', 'value' => nl2br($this->email[0]['email']), 'readonly' => 'readonly'));?>
					</div>
				</div>
			</fieldset>
			<fieldset>	
				<legend><h2>Your Reply</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<span class="help-block">Please enter the content for your reply.</p>
						<label class="control-label" for="your_reply">MESSAGE</label>
						<?php echo Form::textarea(array('rows' => '20', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'your_reply', 'id' => 'your_reply', 'placeholder' => 'Your reply'));?>
					</div>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
	</div>
</div>
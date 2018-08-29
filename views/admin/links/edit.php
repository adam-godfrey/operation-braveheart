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
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/links/edit', 'method' => 'post', 'role' => 'form'));?>
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
				<strong>Success!</strong> Link updated.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Link not updated.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<fieldset>
				<legend><h2>Website Link Information</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="website_name">NAME</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'website_name', 'id' => 'website_name', 'value' => $this->links['title']));?>
						<span class="help-block">Please enter the name of the website.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="website_url">URL</label>
						<?php echo Form::input(array('type' => 'url', 'class' => 'form-control text-input', 'name' => 'website_url', 'id' => 'website_url', 'value' => $this->links['url']));?>
						<span class="help-block">Please enter the url of the website.</span>
					</div>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'linkid', 'id' => 'linkid', 'value' => $this->links['id']));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
	</div>
</div>
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
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/sponsors/edit', 'method' => 'post', 'role' => 'form'));?>
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
				<strong>Success!</strong> Sponsor added.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Sponsor not added.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<fieldset>
				<legend><h2>Sponsor's Information</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<p class="hint">Please enter the name of the sponsor.</p>
						<label class="formlabel" for="sponsor_name">NAME</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'sponsor_name', 'id' => 'sponsor_name', 'value' => $this->sponsors['name']));?>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<p class="hint">Please enter the town/city of the sponsor.</p>
						<label class="formlabel" for="sponsor_location">LOCATION</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'sponsor_location', 'id' => 'sponsor_location', 'value' => $this->sponsors['location']));?>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<p class="hint">Please enter the url of the sponsors website.</p>
						<label class="formlabel" for="sponsor_url">URL <span class="smalltxt">(optional)</span></label>
						<?php echo Form::input(array('type' => 'url', 'class' => 'form-control text-input', 'name' => 'sponsor_url', 'id' => 'sponsor_url', 'value' => $this->sponsors['url']));?>
					</div>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'sponsorid', 'id' => 'sponsorid', 'value' => $this->sponsors['id']));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
	</div>
</div>
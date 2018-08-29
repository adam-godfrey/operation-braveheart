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
			<?php echo Form::open(array( 'id' => 'adminForm','class' => 'form form-hoirzontal', 'name' => 'adminForm', 'action' => URL . 'admin/poems/edit', 'method' => 'post', 'role' => 'form'));?>
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
				<strong>Success!</strong> Blog updated.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Blog not updated.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			
			<fieldset>
				<legend><h2>Poem Content</h2></legend>
				<fieldset>
				<legend><h2>Poem Content</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="poem_title">TITLE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'poem_title', 'id' => 'field_title', 'value' => $this->poem['title']));?>
						<span class="help-block">Please enter a title for the poem.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="poem_author">AUTHOR</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'poem_author', 'id' => 'poem_author', 'value' => $this->poem['author']));?>
						<span class="help-block">Please enter the author of the poem.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="poem_content">POEM</label>
						<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'poem_content', 'id' => 'field_content', 'value' => $this->poem['content']));?>
						<span class="help-block">Please enter the poem.</span>
					</div>
				</div>
			</fieldset>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'poemid', 'id' => 'poemid', 'value' => $this->poem['id']));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			<?php echo Form::open(array('enctype' => 'multipart/form-data', 'name' => 'uploadform', 'class' => 'form-horizontal', 'id' => 'uploadform', 'action' => URL . 'util/processupload.php', 'method' => 'post', 'role' => 'form'));?>
			<fieldset>
				<legend><h2>Poem Image</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label">IMAGE TO UPLOAD</label>
						<div class="input-group">
							<span class="input-group-btn">
								<span class="btn btn-default btn-file">
									Browse&hellip; <?php echo Form::input(array('type' => 'file', 'class' => '', 'name' => 'filepic', 'id' => 'filepic'));?>
								</span>
							</span>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'image-file', 'id' => 'image-file', 'readonly' => ''));?>
							<?php echo Form::input(array('type' => 'hidden', 'name' => 'destination', 'id' => 'destination', 'value' => 'content'));?>
						</div>
					</div>
					<span class="help-block">Please select an image for the poem (optional).</span>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<?php echo Form::input(array('type' => 'submit', 'id' => 'SubmitButton', 'name' => 'SubmitButton', 'value' => ' '));?>
					</div>
				</div>
			</fieldset>
			<?php echo Form::close();?>
			<div class="col-md-8 col-md-offset-2">
				<div class="progress progress-striped">
					<div id="progressbar" class="progress-bar progress-bar-warning" style="width: 0%">
						<span id="statustxt" class="sr-only">0% Complete</span>
					</div>
				</div>
			</div>
			<div id="output"></div>
		</div>
	</div>
</div>
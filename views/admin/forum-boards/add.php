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
			<?php echo Form::open(array('enctype' => 'multipart/form-data', 'id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/boards/add', 'method' => 'post', 'role' => 'form' ));?>
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
				<strong>Success!</strong> Forum board added.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Forum board not added.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<fieldset>
				<legend><h2>Board Content</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="board_title">TITLE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'board_title', 'id' => 'board_title', 'placeholder' => 'Board title'));?>
						<span class="help-block">Please enter a title for the board.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="board_desc">TITLE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'board_desc', 'id' => 'board_desc', 'placeholder' => 'Board description'));?>
						<span class="help-block">Please enter a description for the board.</span>
					</div>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
	</div>
</div>
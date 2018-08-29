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
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/comments', 'method' => 'post', 'role' => 'form'));?>
			<div id="admin-buttons">
				<?php foreach ($this->buttons as $button): ?>
				<?php echo Button($button); ?>
				<?php endforeach; ?>
			</div>
			<fieldset>
				<legend><h2>Comment Content</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="comment_author">AUTHOR</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'comment_author', 'id' => 'comment_author', 'value' => $this->comments[0]['author']));?>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="comment_content">COMMENT</label>
						<?php echo Form::textarea(array('rows' => '20', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'comment_content', 'id' => 'comment_content', 'value' => nl2br($this->comments[0]['comment'])));?>
					</div>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
	</div>
</div>
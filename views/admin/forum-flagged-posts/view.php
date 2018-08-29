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
			<?php if(isset($this->success)) : ?>
			<?php switch($this->action) :
			case 'allow': ?>
				<?php if($this->success) : ?>
				<div id="form-submit" class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
						&times;
					</button>
					<strong>Success!</strong> Flagged post authorised.
				</div>
				<?php else: ?>
				<div id="form-submit" class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
						&times;
					</button>
					<strong>Error!</strong> Flagged post not authorised.
				</div>
				<?php endif; ?>
			<?php break; ?>
			<?php case 'remove': ?>
				<?php if($this->success) : ?>
				<div id="form-submit" class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
						&times;
					</button>
					<strong>Success!</strong> Flagged post removed.
				</div>
				<?php else: ?>
				<div id="form-submit" class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
						&times;
					</button>
					<strong>Error!</strong> Flagged post not removed.
				</div>
				<?php endif; ?>
			<?php break; ?>
			<?php endswitch; ?>
			<?php endif; ?>
			<fieldset>
				<legend><h2>Comment Content</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label for="comment_author">AUTHOR</label><br />
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'comment_author', 'id' => 'comment_author', 'value' => $this->comment[0]['user']));?>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label for="comment_content">COMMENT</label><br />
						<?php echo Form::textarea(array('rows' => '20', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'comment_content', 'id' => 'comment_content', 'value' => nl2br($this->comment[0]['comment'])));?>
					</div>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'commentid', 'id' => 'commentid', 'value' => $this->comment[0]['id']));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
	</div>
</div>
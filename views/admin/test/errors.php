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
			<?php echo Form::open(array('enctype' => 'multipart/form-data', 'id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/news/edit', 'method' => 'post', 'role' => 'form'));?>
			<div id="admin-buttons">
				<?php foreach ($this->buttons as $button): ?>
				<?php echo Button($button); ?>
				<?php endforeach; ?>
			</div>
			<div id="form-submit" class="alert alert-warning alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Warning!</strong> There has been an error.
			</div>
			<?php if(isset($this->errors) && count($this->errors) > 0 ): ?>
			<p><strong>You forgot to enter the following field(s)</strong></p>
			<ul id="validation">
				<?php foreach ($this->errors as $error): ?>
					<li><?=$error;?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
			<fieldset>
				<legend><h2>News Content</h2></legend>
				<div class="col-md-10 col-md-offset-1">
					<div class="form-group">
						<p class="hint">Please enter a title for the news.</p>
						<label for="news_title">TITLE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'news_title', 'id' => 'field_title', 'value' => $this->news[0]['title']));?>
					</div>
				</div>
				<div class="col-md-10 col-md-offset-1">
					<div class="form-group">
						<p class="hint">Please enter the content for the news.</p>
						<label for="news_content">CONTENT</label>
						<?php echo Form::textarea(array('rows' => '20', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'news_content', 'id' => 'field_content', 'value' => nl2br($this->news[0]['content'])));?>
					</div>
				</div>
				<div class="col-md-10 col-md-offset-1">
					<div class="form-group">
						<p class="hint">Please enter some keywords/search phrases for the news (optional).</p>
						<p class="hint">Keywords/search phrases must be separated by commas.</p>
						<label for="news_keywords">KEYWORDS</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'news_keywords', 'id' => 'news_keywords', 'value' => $this->news[0]['keywords']));?>
					</div>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'newsid', 'id' => 'newsid', 'value' => $this->news[0]['id']));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'imgname', 'id' => 'imgname', 'value' =>  $this->news[0]['imgname']));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			
			<?php echo Form::open(array('enctype' => 'multipart/form-data', 'name' => 'uploadform', 'class' => 'form-horizontal', 'id' => 'uploadform', 'action' => URL . 'util/processupload.php', 'method' => 'post', 'role' => 'form'));?>
			<fieldset>
				<legend><h2>Blog Image</h2></legend>
				<div class="col-md-10 col-md-offset-1">
					<div class="form-group">
						<p class="hint">Please select an image for the news (optional).</p>
						<label>IMAGE TO UPLOAD</label>
						<div class="input-group">
							<span class="input-group-btn">
								<span class="btn btn-default btn-file">
									Browse&hellip; <?php echo Form::input(array('type' => 'file', 'class' => '', 'name' => 'filepc', 'id' => 'filepc'));?>
								</span>
							</span>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'image-file', 'id' => 'image-file', 'readonly' => ''));?>
						</div>
					</div>
				</div>
				<div class="col-md-10 col-md-offset-1">
					<div class="form-group">
						<?php echo Form::input(array('type' => 'submit', 'id' => 'SubmitButton', 'name' => 'SubmitButton', 'value' => ' '));?>
					</div>
				</div>
			</fieldset>
			<?php echo Form::close();?>
			<div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div ></div>
			<div id="output"></div>
		</div>
	</div>
</div>
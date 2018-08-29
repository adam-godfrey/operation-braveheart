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
			<?php if(isset($this->errors) && count($this->errors) > 0 ): ?>
			<h3 class="errorhead">There has been an error:</h3>
			<p><span class="bold">You forgot to enter the following field(s)</span></p>
			<ul id="validation">
				<?php foreach ($this->errors as $error): ?>
				<li><?=$error;?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
			<?php if(isset($this->success)) : ?>
			<?php if($this->success) : ?>
			<div id="form-submit" class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Success!</strong> News updated.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> News not updated.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<fieldset>
				<legend><h2>News Content</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="news_title">TITLE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'news_title', 'id' => 'field_title', 'value' => $this->news['title']));?>
						<p class="help-block">Please enter a title for the news.</p>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="news_content">CONTENT</label>
						<?php echo Form::textarea(array('rows' => '20', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'news_content', 'id' => 'field_content', 'value' => $this->news['content']));?>
						<p class="help-block">Please enter the content for the news.</p>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="news_keywords">KEYWORDS</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'news_keywords', 'id' => 'news_keywords', 'value' => $this->news['keywords']));?>
						<p class="help-block">Please enter some keywords/search phrases for the news (optional).</p>
						<p class="help-block">Keywords/search phrases must be separated by commas.</p>
					</div>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'newsid', 'id' => 'newsid', 'value' => $this->news['id']));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'imgname', 'id' => 'imgname', 'value' =>  $this->news['image']));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			
			<?php echo Form::open(array('enctype' => 'multipart/form-data', 'name' => 'uploadform', 'class' => 'form-horizontal', 'id' => 'uploadform', 'action' => URL . 'util/processupload.php', 'method' => 'post', 'role' => 'form'));?>
			<fieldset>
				<legend><h2>News Image</h2></legend>
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
						<p class="help-block">Please select an image for the news (optional).</p>
					</div>
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
			<div id="output">
				<img id="preview-img" class="img-responsive" src="<?=URL;?>public/images/content/<?=$this->news['image'];?>" alt="<?=$this->news['alternate'];?>" title="<?=$this->news['alternate'];?>">
			</div>
		</div>
	</div>
</div>
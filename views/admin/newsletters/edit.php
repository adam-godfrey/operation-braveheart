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
			<?php echo Form::open(array('enctype' => 'multipart/form-data', 'id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/newsletters/edit', 'method' => 'post', 'role' => 'form'));?>
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
				<strong>Success!</strong> Newsletter updated.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Newsletter not updated.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<fieldset>
				<legend><h2>Newsletter Content</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="newsletter_title">NEWSLETTER TITLE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'title', 'id' => 'title', 'value' => $this->newsletter['title']));?>
					</div>
				</div>
				<div id='cssmenu'>
					<ul>
						<li><a href='#'><span>Intro Message</span></a>
							<ul>
								<li>
									<div class="article">
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
											<label class="control-label" for="welcome">INTRO MESSAGE</label>
												<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'intro', 'id' => 'intro', 'value' => $this->newsletter['intro']));?>
												<span class="help-block">Please enter a intro message for the newsletter.</span>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<li><a href='#'><span>Article 1</span></a>
							<ul>
								<li>
									<div class="article">
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
												<label class="control-label" for="article_title_1">ARTICLE TITLE 3</label>
												<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'article_title_1', 'id' => 'article_title_1', 'value' => isset($this->newsletter['article_title_1']) ? $this->newsletter['article_title_1'] : ''));?>
											</div>
										</div>
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
												<label class="control-label" for="article_content_1">ARTICLE CONTENT 3</label>
												<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'article_content_1', 'id' => 'article_content_1', 'value' => isset($this->newsletter['article_content_1']) ? $this->newsletter['article_content_1'] : ''));?>
												<p class="hint">Please enter the content for article 3.</p>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<li><a href='#'><span>Article 2</span></a>
							<ul>
								<li>
									<div class="article">
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
												<label class="control-label" for="article_title_2">ARTICLE TITLE 3</label>
												<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'article_title_2', 'id' => 'article_title_2', 'value' => isset($this->newsletter['article_title_2']) ? $this->newsletter['article_title_2'] : ''));?>
											</div>
										</div>
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
												<label class="control-label" for="article_content_2">ARTICLE CONTENT 3</label>
												<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'article_content_2', 'id' => 'article_content_2', 'value' => isset($this->newsletter['article_content_2']) ? $this->newsletter['article_content_2'] : ''));?>
												<p class="hint">Please enter the content for article 3.</p>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<li><a href='#'><span>Article 3</span></a>
							<ul>
								<li>
									<div class="article">
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
												<label class="control-label" for="article_title_3">ARTICLE TITLE 3</label>
												<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'article_title_3', 'id' => 'article_title_3', 'value' => isset($this->newsletter['article_title_3']) ? $this->newsletter['article_title_3'] : ''));?>
											</div>
										</div>
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
												<label class="control-label" for="article_content_3">ARTICLE CONTENT 3</label>
												<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'article_content_3', 'id' => 'article_content_3', 'value' => isset($this->newsletter['article_content_3']) ? $this->newsletter['article_content_3'] : ''));?>
												<p class="hint">Please enter the content for article 3.</p>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<li><a href='#'><span>Article 4</span></a>
							<ul>
								<li>
									<div class="article">
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
												<label class="control-label" for="article_title_4">ARTICLE TITLE 3</label>
												<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'article_title_4', 'id' => 'article_title_4', 'value' => isset($this->newsletter['article_title_4']) ? $this->newsletter['article_title_4'] : ''));?>
											</div>
										</div>
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
												<label class="control-label" for="article_content_4">ARTICLE CONTENT 3</label>
												<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'article_content_4', 'id' => 'article_content_4', 'value' => isset($this->newsletter['article_content_4']) ? $this->newsletter['article_content_4'] : ''));?>
												<p class="hint">Please enter the content for article 3.</p>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'imgname', 'id' => 'imgname', 'value' => ''));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
	</div>
</div>
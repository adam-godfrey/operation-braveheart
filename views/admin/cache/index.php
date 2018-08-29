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
			<?php echo Form::open(array('id' => 'adminForm','name' => 'adminForm', 'class' => 'form form-horizontal',  'action' => URL . 'admin/managecache', 'method' => 'post', 'role' => 'form'));?>
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
				<strong>Success!</strong> Website cache cleared.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Website cache not cleared.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<fieldset>
				<h2>
					<span id="website-cache" title="What is Website Cache?"
						data-container="body" 
						data-toggle="popover" data-placement="bottom"
						data-content="A web cache is a mechanism for the temporary storage (caching) of web documents, such as HTML pages and images, to reduce bandwidth usage, server load, and perceived lag. A web cache stores copies of documents passing through it; subsequent requests may be satisfied from the cache if certain conditions are met.">Clear website cache</span>
				</h2>
				<div class="clearfix">
					<div class="form-inline">
						<div class="controls-row">
							<div class="col-md-3">
								<label class="radio inline">
									<?php echo Form::input(array('type' => 'radio', 'name' => 'clear_cache', 'id' => 'clear_all', 'value' => 'all'));?> Clear all cache
								</label>
							</div>
							<div class="col-md-4">
								<label class="radio inline">
									<?php echo Form::input(array('type' => 'radio', 'name' => 'clear_cache', 'id' => 'clear_choice', 'value' => 'choices'));?> Select the cache to clear
								</label>
							</div>
						</div>
					</div>
				</div>
				<div id="all" class="desc"></div>
				<div id="choices" class="desc">
					<div class="well">
						<div class="clearfix">
							<h3>Clear individual website cache</h3>
							<?php foreach($this->categories as $category): ?>
							<div class="control-group">
								<div class="col-sm-3 col-md-3">
									<div class="checkbox-inline">
										<label><?php echo Form::input(array('type' => 'checkbox', 'name' => 'cache[]', 'id' => $category . '_cache', 'value' => strtolower($category)));?> <?php echo $category; ?></label>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>		
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
	</div>
</div>
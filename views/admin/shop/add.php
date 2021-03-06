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
			<?php echo Form::open(array('enctype' => 'multipart/form-data', 'id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/shop/add', 'method' => 'post', 'role' => 'form'));?>
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
				<strong>Success!</strong> Shop item added.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Shop item not added.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<fieldset>
				<legend><h2>Product Name &amp; Description</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="item_name">ITEM NAME</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'item_name', 'id' => 'item_name', 'placeholder' => 'Item name'));?>
						<span class="help-block">Please enter a name for the item.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="item_shortdesc">ITEM SHORT DESCRIPTION</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'item_shortdesc', 'id' => 'item_shortdesc', 'placeholder' => 'Item short description'));?>
						<span class="help-block">Please enter a short description for the item.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="item_fulldesc">ITEM FULL DESCRIPTION</label>
						<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'item_fulldesc', 'id' => 'item_fulldesc', 'placeholder' => 'Item full description'));?>
						<span class="help-block">Please enter the full description for the item.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label">CLOTHING?</label>
						<div class="clearfix">
							<div class="form-inline">
								<div class="controls-row">
									<div class="col-md-3">
										<label class="radio inline">
											<?php echo Form::input(array('type' => 'radio', 'name' => 'is_clothing', 'id' => 'clear_all', 'value' => '0'));?> No
										</label>
									</div>
									<div class="col-md-4">
										<label class="radio inline">
											<?php echo Form::input(array('type' => 'radio', 'name' => 'is_clothing', 'id' => 'clear_choice', 'value' => '1'));?> Yes
										</label>
									</div>
								</div>
							</div>
						</div>
						<span class="help-block">Is this item clothing?</span>
						<div id="all" class="desc"></div>
						<div id="choices" class="desc">
							<div class="well">
								<div class="clearfix">
									<label class="control-label" for="item_size">ITEM SIZE</label>
									<select class="form-control" name="item_size">
										<option value=" " selected="selected"> </option>
										<option value="Small">Small</option>
										<option value="Medium">Medium</option>
										<option value="Large">Large</option>
										<option value="X-Large">X-Large</option>
									</select>
								</div>
							</div>
							<span class="help-block">Please enter a size for the item.</span>
						</div>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="item_keywords">KEYWORDS</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'item_keywords', 'id' => 'item_keywords'));?>
						<span class="help-block">Please enter some keywords/search phrases for the item (optional).</span>
						<span class="help-block">Keywords/search phrases must be separated by commas.</span>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend><h2>Product Item Code, Price &amp; Stock Level</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="item_code">ITEM CODE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'item_code', 'id' => 'item_code', 'placeholder' => 'Item code'));?>
						<span class="help-block">Please enter an item code.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="item_price">ITEM PRICE</label>
						<div class="input-group">
							<span class="input-group-addon">&pound;</span>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'item_price', 'id' => 'item_price', 'placeholder' => 'Item price'));?>
						</div>
						<span class="help-block">Please enter a price for the item.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="item_shortdesc">ITEM STOCK LEVEL</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'item_stock', 'id' => 'item_stock', 'placeholder' => 'Item stock level'));?>
						<span class="help-block">Please enter the stock level amount for the item.</span>
					</div>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'imgname', 'id' => 'imgname', 'value' => ''));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			
			<?php echo Form::open(array('enctype' => 'multipart/form-data', 'name' => 'uploadform', 'class' => 'form-horizontal', 'id' => 'uploadform', 'action' => URL . 'util/processupload.php', 'method' => 'post', 'role' => 'form'));?>
			<fieldset>
				<legend><h2>Product Item Image</h2></legend>
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
							<?php echo Form::input(array('type' => 'hidden', 'name' => 'destination', 'id' => 'destination', 'value' => 'shop'));?>
							<?php echo Form::input(array('type' => 'hidden', 'name' => 'thumb', 'id' => 'thumb', 'value' => true));?>
						</div>
					</div>
					<span class="help-block">Please select an image for the item.</span>
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
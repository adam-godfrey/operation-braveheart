<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php echo Form::open(array('name' => 'adminForm', 'class' => 'form-horizontal', 'id' => 'adminForm', 'action' => URL . 'admin/currentfund', 'method' => 'post', 'role' => 'form'));?>
			<div id="admin-buttons">
				<?php echo Form::input(array('type' => 'button', 'class' => 'back', 'name' => 'backbutton', 'id' => 'back-button', 'title' => 'Go Back'));?>
				<?php echo Form::input(array('type' => 'button', 'class' => 'save', 'name' => 'savebutton', 'id' => 'save-button', 'title' => 'Save'));?>
			</div>
			<?php if(isset($this->success)) : ?>
			<?php if($this->success) : ?>
			<div id="form-submit" class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Success!</strong> Current fund updated.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Current fund not updated.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<fieldset>
				<legend><h2>CURRENT FUND</h2></legend>
				<div class="form-group">
					<label class="control-label" for="current_fund">CURRENT FUND AMOUNT</label>
					<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'current_fund', 'id' => 'current_fund', 'value' => $this->fund));?>
				</div>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
	</div>
</div>
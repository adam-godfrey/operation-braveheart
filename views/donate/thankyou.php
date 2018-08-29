<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>Add Yourself to our Donor Section</h2>
			<div class="lightSection">					
				<?php echo Form::open(array('id' => 'donateform', 'class' =>'form-horizontal', 'action' => 'save', 'method' => 'post', 'role' => 'form'));?>
				<div>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'submitform', 'value' => '1'));?>
				</div>
				<div>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'txn_id', 'value' => $_POST['txn_id']));?>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label class="formlabel" for="nameField">Name</label><br />
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'nameField', 'id' => 'nameField', 'placeholder' => 'Name'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label class="formlabel" for="websiteField">Web</label><br />
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'websiteField', 'id' => 'websiteField', 'placeholder' => 'Website'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label class="formlabel" for="messageField">Message</label><br />
						<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'messageField', 'id' => 'messageField', 'placeholder' => 'Message'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<?php echo Form::input(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'send', 'value' => 'Send Message'));?>
					</div>
				</div>	
				<?php echo Form::close();?>
			</div>
		</div>
	</div>
</div>


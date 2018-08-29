<div id="content">
	<div class="content_item">
		<div class="content_item_main">
			<div id="usercp">
				<h4><a href="/control-panel">Your Control Panel</a></h4>
				<?php //if(is_authed_admin()): ?> 
				<h5>Admin Area</h5>
				<ul class="cplist">
					<li><a href="/admin/">Access Admin Area</a></li>
				</ul>
				<?php //endif; ?>
				<h5>Your Profile</h5>
				<ul class="cplist">
					<li><a href="<?=URL;?>profile/">Edit Your Details</a></li>
					<li><a href="/control-panel/editemailpassword">Edit Email &amp; Password</a></li>
				</ul>
				<h5>Settings &amp; Options</h5>
				<ul class="cplist">
					<li><a href="<?=URL;?>profile/avatar">Edit Avatar</a></li>
					<li><a href="<?=URL;?>profile/signature">Edit Signature </a></li>
					<li><a href="<?=URL;?>profile/options">Edit Options</a></li>
				</ul>
				<h5>Shopping</h5>
				<ul class="cplist">
					<li><a href="<?=URL;?>profile/orders">Order History</a></li>
					<li><a href="<?=URL;?>profile/shipping">Shipping Preferences</a></li>
				</ul>
				<h5>Messages</h5>
				<ul class="cplist">
					<li><a href="<?=URL;?>profile/messages">Messages</a></li>
					<li><a href="<?=URL;?>profile/sendmessage">Send New Message </a></li>
				</ul>
				<h5>Subscribed Threads</h5>
				<ul class="cplist">
					<li><a href="<?=URL;?>profile/subscriptions">List Subscriptions</a></li>
				</ul>
			</div>
			<div class="cpcontent">
			<?php echo Form::open(array('name' => 'adminform', 'id' => 'adminform', 'action' => 'save', 'method' => 'post'));?>
			<?php echo Form::input(array('type' => 'button', 'class' => 'back', 'name' => 'backbutton', 'id' => 'back-button', 'title' => 'Go Back'));?>
			<?php echo Form::input(array('type' => 'button', 'class' => 'save', 'name' => 'savebutton', 'id' => 'save-button', 'title' => 'Save'));?>
			<fieldset>
				<legend>Your Current Signature</legend>
				<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'text-input', 'name' => 'signature', 'id' => 'signature', 'title' => 'Your forum signature', 'value' => $this->signature));?>
			</fieldset>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
		</div>
		<div class="content_item_bottom"></div>
	</div>
</div>
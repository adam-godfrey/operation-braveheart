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
				<?php echo Form::open(array('name' => 'updateForm', 'id' => 'updateForm', 'action' => 'save', 'method' => 'post'));?>
				<?php echo Form::input(array('type' => 'button', 'class' => 'back', 'name' => 'backbutton', 'id' => 'back-button', 'title' => 'Go Back'));?>
				<?php echo Form::input(array('type' => 'button', 'class' => 'save', 'name' => 'savebutton', 'id' => 'save-button', 'title' => 'Save'));?>
				<fieldset>
					<legend>Receive Email</legend>
					<p>From time to time, the administrators may want to send you email notices.</p>
					<br />
					<p>If you do not want to receive these notices, disable this option.</p>
					<p><?php echo Form::input(array('type' => 'checkbox', 'class' => 'radiobutton', (($this->email_admin == 'y') ? 'checked' => 'checked' : false), 'name' => 'email_admin', 'id' => 'email_admin', 'value' => 'yes'));?>Receive Email from Administrators</p>
					<br />
					<p>You can allow other members to send you email messages.</p>
					<p><?php echo Form::input(array('type' => 'checkbox', 'class' => 'radiobutton', (($this->$email_other == 'y') ? 'checked' => 'checked' : false), 'name' => 'email_other', 'id' => 'email_other', 'value' => 'yes'));?>Receive Email from Other Members</p>
				</fieldset>
				<fieldset>
					<legend>Default Thread Subscrtiption Mode</legend>
					<p>When you post a new thread, or reply to a topic, you can choose to automatically add that thread to your list of <a href="<?=URL;?>profile/subscriptions">subscribed threads</a>, with the option to receive email notification of new replies to that thread.</p>
					<p>Default Thread Subscription Mode:
					<select name="autosubscribe" id="threads">
						<option value="1" >Do not subscribe</option>
						<option value="2" >No email notification</option>
						<option value="3" selected="selected">Instant email notification</option>
					</select>
					</p>
				</fieldset>
				<fieldset>
					<legend>Private Messaging</legend>
					<p>This control panel features a <a href="<?=URL;?>profile/messages/">private messaging system</a>, which allows members to send messages to one another privately.</p>
					<br />
					<p>If you do not want to send or receive private messages, you may disable the private messaging system.</p>
					<p><?php echo Form::input(array('type' => 'checkbox', 'class' => 'radiobutton', (($this->$pm_disabled == 'y') ? 'checked' => 'checked' : false), 'name' => 'pm_dis', 'id' => 'pm_dis', 'value' => 'yes'));?>Enable Private Messaging</p>
					<br />
					<p>You may limit the receipt of private messages to just administrators/moderators and your contacts. Other members who attempt to send messages to you will be told that you have disabled private messaging.</p>
					<p><?php echo Form::input(array('type' => 'checkbox', 'class' => 'radiobutton', (($this->$pm_admin == 'y') ? 'checked' => 'checked' : false), 'name' => 'pm_admin', 'id' => 'pm_admin', 'value' => 'yes'));?>Receive Private Messages only from Contacts and Moderators</p>
					<br />
					<p>The forum can send a message to your email address to inform you when someone sends you a private message.</p>
					<p><?php echo Form::input(array('type' => 'checkbox', 'class' => 'radiobutton', (($this->$new_prvt_msg == 'y') ? 'checked' => 'checked' : false), 'name' => 'new_prvt_msg', 'id' => 'new_prvt_msg', 'value' => 'yes'));?>Receive Email Notification of New Private Messages</p>
					<br />
					<p>When sending private messages the control panel can make a copy of the message in your Sent Items folder.</p>
					<p><input type="checkbox" class="options" name="save_sent" <?php if($save_sent == 'y') echo 'checked="checked"'; ?> value="y" /></p>
					<p><?php echo Form::input(array('type' => 'checkbox', 'class' => 'radiobutton', (($this->$save_sent_msgs == 'y') ? 'checked' => 'checked' : false), 'name' => 'save_sent', 'id' => 'save_sent', 'value' => 'yes'));?>Save a copy of sent messages in my Sent Items folder by default</p>
				</fieldset>
				<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
				<?php echo Form::close();?>
			</div>
		</div>
		<div class="content_item_bottom"></div>
	</div>
</div>

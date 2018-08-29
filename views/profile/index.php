<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="col-md-1">
				<h4><a href="/control-panel">Your Control Panel</a></h4>
				<?php if(Session::get('admin') == 1): ?> 
				<h5>Admin Area</h5>
				<ul class="cplist">
					<li><a href="<?=URL;?>/admin">Access Admin Area</a></li>
				</ul>
				<?php endif; ?>
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
			<div class="col-md-11">
				<div class="row">
					<div class="col-md-3">
						<h3><?=Session::get('username');?></h3>
						<img class="img-responsive" src="<?=URL;?>public/images/avatars/<?=$this->avatar;?>" alt="<?=$this->avatar;?>">
					</div>
					<div class="col-md-9">
						Name:
						Email:
						
						Member for:
						
						Forum posts:
					</div>
				</div>
				<div class="row">
				
				</div>
			</div>
		</div>
	</div>
</div>

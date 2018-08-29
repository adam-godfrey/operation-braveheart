				</div>
				<!-- End Main Content section -->
				<!-- Sidebar Content section -->
				<div class="col-xs-12 col-sm-6 col-md-4 sidebar">
					<div class="box sidebar_item">
						<div class="sidebar_item_head"><h3>Events Planner</h3></div>
						<div class="sidebar_item_main">
							<div id="datepicker"></div>
						</div>
					</div>
					<div class="box sidebar_item">
						<div class="sidebar_item_head"><h3>Newsletter</h3></div>
						<div class="sidebar_item_main">
							<div class="well well-news">
								<p>Get updates for our latest news, events and blogs.</p>
								<?php echo Form::open(array('id' => 'newsletterForm', 'class' => 'form form-horizontal', 'action' => 'save', 'method' => 'post', 'role' => 'form'));?>
								<div class="form-group">
									<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'signupname', 'id' => 'signupname', 'value' => 'Name'));?>
								</div>
								<div class="form-group">
									<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'signupemail', 'id' => 'signupemail', 'value' => 'Email'));?>
								</div>
								<div class="form-group">
									<?php echo Form::button(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'send'), 'Signup!!');?>
									<p id="signupsuccess" style="text-align: left"></p>
								</div>
								<?php echo Form::close();?>
							</div>
						</div>
					</div>
					<div class="box sidebar_item">
						<div class="sidebar_item_head"><h3>Followers</h3></div>
						<div class="sidebar_item_main">
							<div class="fb-like-box" data-href="https://www.facebook.com/FacebookDevelopers" data-width="292" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
						</div>
					</div>
					<div class="box sidebar_item">
						<div class="sidebar_item_head"><h3>100 Club Lottery</h3></div>
						<div class="sidebar_item_main">
							<a href="<?php echo URL; ?>lottery"><img src="<?php echo URL; ?>public/images/layout/lottery.jpg" alt="Join the Operation Braveheart 100 Club Lottery" title="Join the Operation Braveheart 100 Club Lottery" /></a>
						</div>
					</div>
					<div class="box sidebar_item">
						<div class="sidebar_item_head"><h3>Donate</h3></div>
						<div class="sidebar_item_main">
							<a href="<?=URL;?>donate"><img src="<?php echo URL; ?>public/images/layout/paypal.png" alt="Donate with PayPal" title="Donate with PayPal" /></a>
						</div>
					</div>
					
					<div class="box sidebar_item">
						<div class="sidebar_item_head"><h3>Follow Us</h3></div>
						<div class="sidebar_item_main">
							<img src="<?php echo URL; ?>public/images/layout/FacebookLogo.png" alt="Follow us on Facebook" title="Follow us on Facebook" width="270" />
							<img src="<?php echo URL; ?>public/images/layout/follow-us-on-twitter.jpg" alt="Follow us on Twitter" title="Follow us on Twitter" width="270"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Site footer -->
		<div class="bottom">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-4">
						<img src="<?=URL; ?>public/images/layout/sniper_scope.jpg" class="img-responsive">
					</div>
					<div class="col-md-9">
						<div class="row">
							<div class="col-md-2 col-sm-4 col-xs-6">
								<h5>Main Navigation</h5>
								<ul class="footerlist">
									<li><a href="<?php echo URL; ?>">Home</a></li>
									<li><a href="<?php echo URL; ?>news">News</a></li>
									<li><a href="<?php echo URL; ?>events">Events</a></li>
									<li><a href="<?php echo URL; ?>gallery">Gallery</a></li>
								</ul>	
							</div>
							<div class="col-md-3 col-sm-4 col-xs-6">
								<h5>About</h5>
								<ul class="footerlist">
									<li><a href="<?php echo URL; ?>contact-us">Contact Us</a></li>
									<li><a href="<?php echo URL; ?>about">About </a></li>
									<li><a href="<?php echo URL; ?>donate">Donate</a></li>
									<li><a href="<?php echo URL; ?>blogs">Blogs</a></li>
								</ul>	
							</div>
							<div class="col-md-3 col-sm-4">
								<h5>Forum</h5>
								<ul class="footerlist">
									<li><a href="<?php echo URL; ?>forum/across-the-services">Across The Services</a></li>
									<li><a href="<?php echo URL; ?>forum/friends-and-family">Friends And Family</a></li>
									<li><a href="<?php echo URL; ?>forum/fund-raising-ideas">Fund Raising Ideas</a></li>
									<li><a href="<?php echo URL; ?>forum/messages-of-support">Messages Of Support</a></li>
									<li><a href="<?php echo URL; ?>forum/operation-braveheart-cafe">Operation Braveheart Cafe</a></li>
								</ul>
							</div>
							<div class="col-md-3 col-sm-4">
								<h5>Site Info &amp; Help</h5>
								<ul class="footerlist">
									<li><a href="<?php echo URL; ?>privacy">Privacy Policy</a></li>
									<li><a href="<?php echo URL; ?>terms">Terms of Use</a></li>
									<li><a href="<?php echo URL; ?>sitemap">Sitemap</a></li>
									<li><a href="<?php echo URL; ?>register">Register</a></li>
									<li><a href="<?php echo URL; ?>forgotpassword">Forgotten password</a></li>
								</ul>
							</div>
						</div>
						<div class="copy">
							<p>Copyright 2008 - <?php echo date('Y') ?> Operation Braveheart.  All rights reserved.  Website design &amp; development by Adam Godfrey</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if(isset($this->admin_modal)): ?>
	<?php if($this->admin_modal): ?>
	<div class="modal fade" id="myModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					 <h4 class="modal-title"><?=$this->modal['title'];?></h4>
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row">
							<?=$this->modal['content'];?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<?php endif; ?>
	<?php endif; ?>
	<!-- Include jQuery and bootstrap JS plugins -->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
	<script src="<?=URL;?>public/js/bootbox.min.js"></script>
	<script src="<?php echo URL; ?>public/js/jquery.validate.js"></script>
	<script src="<?php echo URL; ?>public/js/jquery.default.js"></script>
	<?php if (!empty($this->scripts)):?>
	<?php foreach($this->scripts as $script) : ?>
	<?php if(substr($script, 0, 4) == 'http'): ?>
	<script type="text/javascript" src="<?php echo $script; ?>"></script>
	<?php else: ?>
	<?php if(file_exists('/www/app/public/js/' . $script . '.js')): ?>
	<script type="text/javascript" src="<?=URL;?>public/js/<?php echo $script; ?>.js"></script>
	<?php else: ?>
	<?php echo URL . 'public/js/' . $script . '.js'; ?>
	<?php endif; ?>
	<?php endif; ?>
	<?php endforeach; ?>	
	<?php endif; ?>
	<?php if(!empty($this->embed)):?>
	<?php //foreach($this->embed as $poo) : ?>
	<?php echo $this->embed; ?>
	<?php //endforeach; ?>
	<?php endif;?>
</body>
</html>
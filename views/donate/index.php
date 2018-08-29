<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
				<h2>Show Your Support for our Cause</h2>
				<div class="lightSection">
					<div class="center-block" style="width: 500px">
						<img class="img-responsive" src="<?=URL;?>public/images/layout/paypal_large.gif" alt="Donate with PayPal">
					</div>
					<h3>Hello, dear visitor!</h3>
					<p>This is Tutorialzine's Donation Center. It utilizes PayPal's APIs to bring you a fully fledged donation solution. It is currently in <strong>Demo Mode</strong>, which means that PayPal is bypassed and you can donate as much as you want to test the functionality. You can, however, just change a variable in the config.php file to enable real donations.</p>    
					<!-- The PayPal Donation Button -->
				</div>
				<?php echo Form::open(array('id' => 'payPalForm', 'role' => 'form', 'action' => payPalURL, 'method' => 'post'));?>
				<div class="form-group">
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'cmd', 'value' => '_donations'));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'item_name', 'value' => 'Donation'));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'business', 'value' => MYPAYPALEMAIL));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'notify_url', 'value' => URL . 'util/donate_ipn.php'));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'return', 'value' => URL . 'donate/thankyou'));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'no_note', 'rm' => '1'));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'cbt', 'value' => 'Go Back To The Site'));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'no_shipping', 'value' => '1'));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'lc', 'value' => 'UK'));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'currency_code', 'value' => 'GBP'));?>
					<div class="row">
						<div class="col-md-8">
							<label for="amount">Donation amount</label>
							<select class="form-control input-md" name="amount">
								<option value="50">&pound;50</option>
								<option value="20">&pound;20</option>
								<option value="10" selected="selected">&pound;10</option>
								<option value="5">&pound;5</option>
								<option value="2">&pound;2</option>
								<option value="1">&pound;1</option>
							</select>
						</div>
						<div class="col-md-4">
							<?php echo Form::input(array('type' => 'hidden', 'name' => 'bn', 'value' => 'PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest'));?>
							<?php echo Form::input(array('type' => 'image', 'src' => URL.'public/images/layout/paypal-donate-button.jpg', 'name' => 'submit'));?>
							<img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
						</div>
					</div>
				</div>	
				<?php echo Form::close();?>
				<div class="row">
					<div class="col-md-3 valign">
						<span class="mahoosif">Our Goal</span>
					</div>
					<div class="col-md-6">
						<div id="loader" class="loading"></div>
						<!-- Setting the Google Chart API address as the background image of the div: -->
						<div id="piechart_3d"></div>
					</div>
					<div class="col-md-3 valign">
						<div class="donations">
							<span class="mahoosif"><?php echo $this->percent?>% done</span>
						</div>
					</div>
				</div>
				<div class="donors">
					<h3>The Donor List</h3>
					<div class="comments">
					<?php if(empty($this->comments)): ?>
						<p>No donations made so far</p>
					<?php else:?>
					<?php foreach($this->comments as $comment): ?>
						<div class="entry">
							<p class="comment">
								<?php 
									echo nl2br($comment['message']); // Converting the newlines of the comment to <br /> tags
								?>
								<span class="tip"></span>
							</p>
							<div class="name">
								<?php echo $comment['name']?> <a class="url" href="<?php echo $comment['url']?>"><?php echo $comment['url']?></a>
							</div>
						</div>
					<?php endforeach; ?>
					<?php endif; ?>
					</div> <!-- Closing the comments div -->
				</div> <!-- Closing the donors div -->
			</div>
		</div>
	</div>
<div id="content">
	<div class="content_item">
		<div class="content_item_main">
			<div class="mainitem">
				<p>We welcome your enquiries, so please get in touch. We'd like to help you as quickly as possible, so please contact us via email or use our enquiry form below.  We endeavour to respond to your enquiry within 72 hours.</p>
				<div id="add">
					<h2>Write to Us</h2>
					<p>David Godfrey</p>
					<p class="bold">Operation Braveheart</p>
					<p>82 New Street</p>
					<p>Cullompton</p>
					<p>Devon</p>
					<p>EX15 1HD</p>
				</div>
				<div id="tel">
					<h2>Email</h2>
					<p><a href="#"><span id="my-email">please enable javascript to view</span></a></p>
				</div>
				<div class="clear"></div>
				<div id="webform">
					<h2>Submit Enquiry</h2>
					<?php echo Form::open(array('id' => 'contactForm', 'action' => URL . 'contact', 'method' => 'post'));?>
					<div>
						<?php echo Form::input(array('type' => 'hidden', 'name' => 'token', 'value' => $this->token));?>
					</div>
					<div id="form_result"></div>
					<div id="sending"></div>
					<div class="group">
						<label class="formlabel" for="fullname">Name</label><br />
						<?php echo Form::input(array('type' => 'text', 'class' => 'text-input', 'name' => 'fullname', 'id' => 'fullname'));?>
					</div>
					<div class="group">
						<label class="formlabel" for="email">E-mail</label><br />
						<?php echo Form::input(array('type' => 'text', 'class' => 'text-input', 'name' => 'email', 'id' => 'email'));?>
					</div>
					<div class="group">
						<label class="formlabel" for="web">Website <span class="smalltxt">(optional)</span></label><br />
						<?php echo Form::input(array('type' => 'text', 'class' => 'text-input', 'name' => 'web', 'id' => 'web'));?>
					</div>
					<div class="group">
						<label class="formlabel" for="comment">Message</label><br />
						<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'text-input', 'name' => 'comment', 'id' => 'comment'));?>
					</div>
					<div class="group">
						<?php echo Form::input(array('type' => 'submit', 'class' => 'submitButton', 'name' => 'send', 'value' => 'Send Message'));?>
					</div>	
					<?php echo Form::close();?>
				</div>
			</div>
		</div>
		<div class="content_item_bottom"></div>
	</div>
</div>
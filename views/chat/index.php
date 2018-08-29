<div class="content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="cpcontent">
				<div id="chatContainer">
					<div id="chatTopBar" class="rounded"></div>
					<div id="chatLineHolder"></div>
					<div id="chatUsers" class="rounded"></div>
					<div id="chatBottomBar" class="rounded">
						<div class="tip"></div>
						<?php echo Form::open(array('id' => 'chatLoginForm', 'action' => '', 'method' => 'post'));?>
						<div>
							<?php echo Form::input(array('type' => 'hidden', 'name' => 'name', 'value' => Session::get('username')));?>
						</div>
						<div class="group">
							<?php echo Form::input(array('type' => 'submit', 'class' => 'submitButton', 'name' => 'send', 'value' => 'Start Chat'));?>
						</div>	
						<?php echo Form::close();?>
						
						<?php echo Form::open(array('id' => 'chatSubmitForm', 'action' => '', 'method' => 'post'));?>
						<div>
							<?php echo Form::input(array('type' => 'test', 'id' => 'chatText', 'name' => 'chatText', 'maxlength' => 255));?>
						</div>
						<div class="group">
							<?php echo Form::input(array('type' => 'submit', 'class' => 'submitButton', 'name' => 'chatSubmit', 'value' => 'Submit'));?>
						</div>	
						<?php echo Form::close();?>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
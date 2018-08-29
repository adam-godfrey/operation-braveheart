<div id="content">
	<div class="content_item">
		<div class="content_item_main">
			<div class="newsitem">
				<?php echo Form::open(array('id' => 'forumForm', 'action' => URL . 'forum/postnewtopic', 'method' => 'post'));?>
				<div>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'boardname', 'value' => $this->board));?>
				</div>
				<div class="group">
					<label class="formlabel" for="topictitle">Topic Title</label><br />
					<?php echo Form::input(array('type' => 'text', 'class' => 'text-input', 'name' => 'topictitle', 'id' => 'topictitle', 'value' => $this->data['topictitle']));?>
				</div>
				<div class="group">
					<label class="formlabel" for="topicmessage">Message</label><br />
					<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'text-input', 'name' => 'topicmessage', 'id' => 'topicmessage', 'value' => $this->data['message']));?>
				</div>
				<div class="group">
					<?php echo Form::input(array('type' => 'submit', 'class' => 'submitButton', 'name' => 'newtopic', 'value' => 'Post New Topic'));?>
				</div>	
				<?php echo Form::close();?>
			</div>
		</div>
		<div class="content_item_bottom"></div>
	</div>
</div>
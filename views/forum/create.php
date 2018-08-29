<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="row">
				<?php echo Form::open(array('id' => 'forumForm', 'class=' => 'form form-horizontal', 'action' => URL . 'board/postnewtopic', 'method' => 'post', 'role' => 'form'));?>
				<?php echo Form::input(array('type' => 'hidden', 'name' => 'boardname', 'value' => $this->board));?>
				<div class="form-group">
					<div class="col-md-12">
						<label for="topictitle">Topic Title</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'topictitle', 'id' => 'topictitle', 'placeholder' => 'Topic title...'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<label for="topicmessage">Message</label>
						<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'topicmessage', 'id' => 'topicmessage', 'placeholder' => 'Topic message...'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<?php echo Form::input(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'newtopic', 'value' => 'Post New Topic'));?>
					</div>
				</div>	
				<?php echo Form::close();?>
			</div>
		</div>
	</div>
</div>

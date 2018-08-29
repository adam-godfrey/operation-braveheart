<?php if (empty($this->events)):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>Oops! There are no events in the database.</h2>
		</div>
	</div>
</div>
<?php else:?>
<?php foreach($this->events as $event):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="commentcount">
				<div class="comm-count">
					<p><?php echo $event['commcount']; ?></p>
				</div>
			</div>
			<p>Posted on <?=$event['postdate'];?></p>
			<hr />
			<h2><?php echo $event['title']; ?></h2>
			<h4><?=$event['eventdate'];?></h4>
			<p><?php echo nl2br($event['content']);?></p>
			<div id="map-canvas"></div>
			<div class="infobox-wrapper">
				<div id="infobox">
					<?=$event['title'];?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endforeach?>
<?php if (!empty($this->events)):?>
	<div class=""><?php echo $this->paging; ?></div>
<?php endif?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div id="webform">
				<h2>Leave a Reply</h2>
				<?php echo Form::open(array('id' => 'replyForm', 'action' => URL . 'events/reply', 'class' => 'form form-horizontal', 'method' => 'post', 'role' => 'form'));?>
				
				<div class="form-group">
					<div class="col-md-5">
						<label for="fullname">Name</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'fullname', 'id' => 'fullname', 'placeholder' => 'Name'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label for="email">Email</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'email', 'id' => 'email', 'placeholder' => 'Email'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label for="web">Website (optional)</label>	
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'web', 'id' => 'web', 'placeholder' => 'Website'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label for="comment">Message</label>
						<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'comment', 'id' => 'comment'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<p class="hint">Please enter the anti-spam image text.</p>
						<img src="<?=URL;?>libs/captcha.php" id="captcha" alt="Please enter captcha text" title="Please enter captcha text" /></p>
						<p id="refresh">Not readable? Change text.</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label class="formlabel" for="captchaimg">Anti-Spam Verification</label><br />
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'captchaimg', 'id' => 'captchaimg', 'title' => 'Please enter captcha text'));?>
					</div>
				</div>
				<?php echo Form::input(array('type' => 'hidden', 'name' => 'eventid', 'id' => 'eventid', 'value' => $this->events[0]['id']));?>
				<?php echo Form::input(array('type' => 'hidden', 'name' => 'pageid', 'id' => 'pageid', 'value' => $this->pageid));?>
				<div class="form-group">
					<div class="col-md-5">
						<?php echo Form::input(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'send', 'value' => 'Send Message'));?>
					</div>
				</div>	
				<?php echo Form::close();?>
			</div>
				
			<h2 class="comment"><?=$this->comm_count;?> Responses To <?=$this->event_title;?></h2>
			<?php if (empty($this->comments)):?>
			<p>Oops! There are no comments.  Be the first to comment.</p>
			<?php else:?>
			<ul id="comments-list">
			<?php $last_comment = sizeof($this->comments); ?>
			<?php foreach($this->comments as $comment):?>
			<?php if ($last_comment == 1): ?>
			<a name="lastcomment"></a>
			<?php endif; ?>
			<?php $last_comment--; ?>
			<li>
				<div class="comment-container">
					<div class="comment-img">
						<img src="<?=URL;?>public/images/avatars/<?=(!empty($comment['avatar'])) ? $comment['avatar'] : 'no-avatar.gif';?>" width="75px" height="75px" alt="<?=$comment['avatar'];?>" title="<?=$comment['avatar'];?>" />
					</div>
					<div class="comment-comment">
						<p><span  class="comment-author"><?=$comment['user'];?></span> said <span class="comment-date"><?=$comment['postdate'];?></span> ago...</p>
						<p>"<?php echo ($comment['status'] == 1) ? nl2br($comment['comment']) : 'Comment awaiting moderation!'; ?>"</p>
					</div>					
				</div>
				<div class="clear"></div>
			</li>
			<?php endforeach;?>
			</ul>
			<?php endif;?>
		</div>
	</div>
</div>
<?php endif?>
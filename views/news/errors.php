<?php if(isset($this->errors) && count($this->errors) > 0 ): ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('html,body').animate({scrollTop: $("#replyForm").offset().top},1);
	});
</script>
<?php endif; ?>
<?php if (empty($this->news)):?>
<div class="content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>Oops! There is no news in the database.</h2>
		</div>
	</div>
	<div class="content_item_bottom"></div>
</div>
<?php else:?>
<?php foreach($this->news as $newsitem):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="commentcount">
				<div class="comm-count">
					<p><?php echo $newsitem['count']; ?></p>
				</div>
			</div>
			<p><?php echo $newsitem['postdate'];?></p>
			<hr />
			<h2><?php echo $newsitem['title']; ?></h2>
			<p><?php echo nl2br($newsitem['content']);?></p>
		</div>
	</div>
</div>
<?php endforeach?>
<?php if (!empty($this->news)):?>
<div class=""><?php echo $this->paging; ?></div>
<?php endif?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php if(isset($this->errors) && count($this->errors) > 0 ): ?>
			<h3 class="errorhead">There has been an error:</h3>
			<p><span class="bold">You forgot to enter the following field(s)</span></p>
			<ul id="validation">
				<?php foreach ($this->errors as $error): ?>
					<li><?=$error;?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
			<div id="webform">
				<h2>Leave a Reply</h2>
				<?php echo Form::open(array('id' => 'replyForm', 'class' => 'form-horizontal', 'action' => URL . 'news/reply', 'method' => 'post', 'role' => 'form'));?>
				<div>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'token', 'value' => $this->token));?>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label class="formlabel" for="fullname">Name</label><br />
						<?php echo Form::input(array('type' => 'text', 'class' => 'text-input', 'name' => 'fullname', 'id' => 'fullname', 'value' => $this->data['fullname']));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label class="formlabel" for="email">E-mail <span class="smalltxt">(never published)</span></label><br />
						<?php echo Form::input(array('type' => 'text', 'class' => 'text-input', 'name' => 'email', 'id' => 'email', 'value' => $this->data['email']));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label class="formlabel" for="web">Website <span class="smalltxt">(optional)</span></label><br />
						<?php echo Form::input(array('type' => 'text', 'class' => 'text-input', 'name' => 'web', 'id' => 'web', 'value' => $this->data['web']));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-5">
						<label class="formlabel" for="message">Message</label><br />
						<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'text-input', 'name' => 'message', 'id' => 'message', 'value' => $this->data['message']));?>
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
						<?php echo Form::input(array('type' => 'text', 'class' => 'text-input', 'name' => 'captchaimg', 'id' => 'captchaimg', 'title' => 'Please enter captcha text'));?>
					</div>
				</div>
				<?php echo Form::input(array('type' => 'hidden', 'name' => 'newsid', 'id' => 'newsid', 'value' => $this->news[0]['id']));?>
				<?php echo Form::input(array('type' => 'hidden', 'name' => 'pageid', 'id' => 'pageid', 'value' => $this->pageid));?>
				<div class="group">
					<div class="col-md-5">
						<?php echo Form::input(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'send', 'value' => 'Send Message'));?>
					</div>
				</div>	
				<?php echo Form::close();?>
			</div>
			<h2 class="comment"><?=$this->comm_count;?> Responses To <?=$this->news_title;?></h2>
			<?php if (empty($this->comments)):?>
			<p>Oops! There are no comments.  Be the first to comment.</p>
			<?php else:?>
			<ul id="comments-list">
			<?php foreach($this->comments as $comment):?>
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
</div>
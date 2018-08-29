<?php if (empty($this->news)):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>Oops! There is no news in the database.</h2>
		</div>
	</div>
</div>
<?php else:?>
<?php foreach($this->news as $newsitem):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php if(isset($this->success)) : ?>
			<?php if($this->success) : ?>
			<div id="form-submit" class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Success!</strong> Comment added.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Comment not added.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<div class="commentcount">
				<div class="comm-count">
					<p><?php echo $newsitem['count']; ?></p>
				</div>
			</div>
			<p><?php echo $newsitem['postdate'];?></p>
			<hr />
			<h2><?php echo $newsitem['title']; ?></h2>
			<img class="img-responsive pull-right" src="<?=URL;?>public/images/content/<?php echo $newsitem['photo'];?>">
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
			<div id="webform">
				<h2>Leave a Reply</h2>
				<?php echo Form::open(array('id' => 'replyForm', 'action' => URL . 'news/reply/' . $this->pageid, 'class' => 'form form-horizontal', 'method' => 'post', 'role' => 'form'));?>
				<div>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'token', 'value' => $this->token));?>
				</div>
				<div class="form-group">
					<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
						<label for="fullname">Name</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'fullname', 'id' => 'fullname', 'placeholder' => 'Name'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
						<label for="email">Email</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'email', 'id' => 'email', 'placeholder' => 'Email'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
						<label for="web">Website (optional)</label>	
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'website', 'id' => 'website', 'placeholder' => 'Website'));?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
						<label for="comment">Message</label>
						<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'comment', 'id' => 'comment'));?>
					</div>
				</div>
				<div class="form-group">
						<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<div class="captchatext">
								<img src="<?=URL;?>util/visual-captcha.php" width="200" height="60" alt="Visual CAPTCHA" />
							</div>
							<p id="refresh">Not readable? Change text.</p>
						</div>
					</div>
					<div class="form-group">
						<div class=" col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
							<label for="captcha">Anti-SPAM</label>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'captcha', 'id' => 'captcha', 'placeholder' => 'Anti-SPAM'));?>
						</div>
					</div>
				<?php echo Form::input(array('type' => 'hidden', 'name' => 'newsid', 'id' => 'newsid', 'value' => $this->news[0]['id']));?>
				<?php echo Form::input(array('type' => 'hidden', 'name' => 'pageid', 'id' => 'pageid', 'value' => $this->pageid));?>
				<div class="form-group">
					<div class="col-sm-8 col-md-8 col-sm-offset-1 col-md-offset-2">
						<?php echo Form::input(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'send', 'value' => 'Send Message'));?>
					</div>
				</div>		
				<?php echo Form::close();?>
			</div>
		</div>
	</div>
</div>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2 class="comment"><?=$this->comm_count;?> Responses To <?=$this->news_title;?></h2>
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
							<p><span  class="comment-author"><?=$comment['author'];?></span> said <span class="comment-date"><?=$comment['postdate'];?></span> ago...</p>
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
<div id="content">
	<div class="content_item">
		<div class="content_item_main">
			<div class="newsitem">
				<?php echo Form::open(array('id' => 'forumForm', 'action' => URL . 'forum', 'method' => 'post'));?>
				<div>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'board', 'value' => $this->board));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'topic', 'value' => $this->topic));?>
				</div>
				<div class="group">
					<label class="formlabel" for="comment">Message</label><br />
					<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'text-input', 'name' => 'topicmessage', 'id' => 'topicmessage', 'value' => $this->data['message']));?>
				</div>
				<div class="group">
					<?php echo Form::input(array('type' => 'submit', 'class' => 'submitButton', 'name' => 'send', 'value' => 'Send Message'));?>
				</div>	
				<?php echo Form::close();?>
				
				<div id="forumHeading">
					<div class="aurthorHeading"><p>Author</p></div>
					<div class="topicHeading"><p>Topic</p></div>
				</div>
				<?php foreach($this->forum as $key => $forumitem):?>
				<div class="message">
					<div class="tdLeft">
						<h3><?=$this->forum[$key]['mauthor'];?></h3>
						<p><?=$this->forum[$key]['user_level'];?></p>
						<p><img src="<?php echo $URL; ?>images/avatars/<?=$this->forum[$key]['avatar'];?>" alt="<?=$this->forum[$key]['avatar'];?>" title="<?=$this->forum[$key]['avatar'];?>" width="50%" height="50%"/></p>
						<p>Join Date: <?=$this->forum[$key]['joindate'];?></p>
						<p>Posts: <?=$this->forum[$key]['posts']?></p>
						<?php if($this->forum[$key]['online']=="Online"): ?>
						<div class="online">
						<?php else: ?>
						<div class="offline">
						<?php endif; ?>
						<?=$this->forum[$key]['online'];?>
						</div>
					</div>
					<div class="tdRight">
						<h3><?=$this->forum[$key]['topic'];?></h3>
						<p><?=$this->forum[$key]['newpostdate'];?></p>
						<hr class="hr" />
						<?=$this->forum[$key]['message'];?>
						<hr class="hr" />
						<p class="psmall"><?=$this->forum[$key]['signature'];?></p>
					</div>
				</div>
				<?php endforeach?>
				<div class="clear"></div>
				<?php if (!empty($this->forum)):?>
				<div class="welcome">
					<div class="forumPagingRight">
						<?php echo $this->paging; ?>
					</div>
					<div class="topicsCount">
						<p>Topics <?=$this->offset;?> to <?=$this->pagemax;?> of <?=$this->getresult;?></p>
					</div>
				</div>
				<?php endif?>
			</div>
		</div>
		<div class="content_item_bottom"></div>
	</div>
</div>
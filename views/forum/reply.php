<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php echo Form::open(array('id' => 'forumForm', 'class' => 'form-horizontal', 'action' => URL . 'forum/postreply', 'method' => 'post', 'role' => 'form'));?>
			<div>
				<?php echo Form::input(array('type' => 'hidden', 'name' => 'board', 'value' => $this->board));?>
				<?php echo Form::input(array('type' => 'hidden', 'name' => 'topic', 'value' => $this->topic));?>
			</div>
			<div class="form-group">
				<div class="col-md-10 col-md-offset-1">
					<label for="topicmessage">Message</label>
					<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'topicmessage', 'id' => 'topicmessage', 'value' => $this->message));?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-10 col-md-offset-1">
					<?php echo Form::input(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'send', 'value' => 'Post Reply'));?>
				</div>
			</div>	
			<?php echo Form::close();?>
			
			<div class="row">
				<div class="col-md-3">
					<h4>Author</h4>
				</div>
				<div class="col-md-9">
					<h4>Topic</h4>
				</div>
			</div>
			<?php foreach($this->forum as $key => $forumitem):?>
			<div class="row">
				<div class="col-md-3">
					<h3><?=$this->forum[$key]['mauthor'];?></h3>
					<p><?=$this->forum[$key]['user_level'];?></p>
					<img src="<?=URL;?>public/images/avatars/<?=$this->forum[$key]['avatar'];?>" alt="<?=$this->forum[$key]['avatar'];?>" title="<?=$this->forum[$key]['avatar'];?>" class="img-responsive" width="50%" height="50%"/>
					<p>Join Date: <?=$this->forum[$key]['joindate'];?></p>
					<p>Posts: <?=$this->forum[$key]['posts']?></p>
					<?php if($this->forum[$key]['online']== "Online"): ?>
					<div class="online">
					<?php else: ?>
					<div class="offline">
					<?php endif; ?>
						<?=$this->forum[$key]['online'];?>
					</div>
				</div>
				<div class="col-md-9">
					<h3><?=$this->forum[$key]['topic'];?></h3>
					<p><?=$this->forum[$key]['newpostdate'];?></p>
					<hr>
					<?=$this->forum[$key]['message'];?>
					<hr>
					<p class="psmall"><?=$this->forum[$key]['signature'];?></p>
				</div>
			</div>
			<?php endforeach?>
			<?php if (!empty($this->forum)):?>
			<div class="">
				<?php echo $this->paging; ?>
			</div>
			<?php endif?>
		</div>
	</div>
</div>
<?php if (empty($this->forum)):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>There are currently no topics.</h2>
		</div>
	</div>
</div>
<?php else:?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="welcomeContainer">
				<?php if(Session::get('loggedIn')): ?>
				<a id="replytopic" href="<?=URL;?>topic/reply/<?=$this->board;?>/<?=$this->topic;?>">Reply</a>
				<?php else: ?>
				<div class="welcome"><p>Welcome Guest</p><p>Please login or <a href="<?php echo URL; ?>register">register</a></p></div>
				<?php endif; ?>
				<?php if (!empty($this->forum)):?>
				<div class="forumPagingLeft">
					<?php echo $this->paging; ?>
				</div>
				<?php endif?>
			</div><!-- end welcome div-->
			<div class="row">
				<div class="col-md-3">
					<p>Author</p>
				</div>
				<div class="col-md-9">
					<p>Topic</p>
				</div>
			</div>
			<?php foreach($this->forum as $key => $forumitem):?>
			<div class="row">
				<div class="col-md-3" style="text-align:center">
					<h3><?=$this->forum[$key]['mauthor'];?></h3>
					<p><?=$this->forum[$key]['user_level'];?></p>
					<img src="<?=URL; ?>public/images/avatars/<?=$this->forum[$key]['avatar'];?>" class="img-responsive" alt="<?=$this->forum[$key]['avatar'];?>" title="<?=$this->forum[$key]['avatar'];?>" />
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
				<div class="col-md-9">
					<h3><?=$this->forum[$key]['topic'];?></h3>
					<p><?=$this->forum[$key]['newpostdate'];?></p>
					<hr>
					<?=nl2br($this->forum[$key]['message']);?>
					<hr>
					<p class="psmall"><?=$this->forum[$key]['signature'];?></p>
					<p class="reportbuttons">
						<div>
							<a class="quote" href="<?=URL?>topic/reply/<?=$this->board;?>/<?=$this->topic;?>/<?=$this->forum[$key]['messageid']; ?>">Quote</a>
						</div>
						<div>
							<p id="reported_<?=$this->forum[$key]['messageid']; ?>"></p>
							<a href="#" class="report" id="report_<?=$this->forum[$key]['messageid']; ?>">Report to moderator</a>
						</div>
					</p>
				</div>
			</div>
			<?php endforeach?>
			<div class="clear"></div>
			<?php if (!empty($this->forum)):?>
			<div class="welcome">
				<div class="">
					<?php echo $this->paging; ?>
				</div>
			</div>
			<?php endif?>
		</div>
	</div>
</div>
<?php endif?>
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
				<?php if(Session::get('loggedIn') != false): ?>
				<a id="newtopic" href="<?=URL;?>forum/newtopic/<?=$this->board;?>">New Topic</a>
				<?php else: ?>
				<div class="welcome"><p>Welcome Guest</p><p>Please login or <a href="<?=URL; ?>register">register</a></p></div>
				<?php endif; ?>
				<?php if (!empty($this->forum)):?>
				<div class="forumPagingLeft">
					<?php echo $this->paging; ?>
					<div class="topicsCount">
						<p>Topics <?=$this->offset;?> to <?=$this->pagemax;?> of <?=$this->getresult;?></p>
					</div>
				</div>
				<?php endif?>
			</div><!-- end welcome div-->
			
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th colspan="2">Topic</th>
							<th>Replies/Views</th>
							<th>Last Post</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($this->forum as $key => $forumitem):?>
						<tr>
							<?php if($this->forum[$key]['locked']=="y"): ?>
							<td class="topicLock"></td>
							<?php else: ?>
							<td class="topicUnlock"></td>
							<?php endif; ?>
							<td class="topicMain">
							<p><a href="<?=URL;?>topic/pages/<?=$this->board;?>/<?=$this->forum[$key]['topicid'];?>-<?=$this->forum[$key]['topic'];?>"><?=$this->forum[$key]['topicname']; ?></a></p>
							<p>started by: <?=$this->forum[$key]['author']; ?></p>
							</td>
							<td class="repliesMain">
								<p>Replies: <?=$this->forum[$key]['msg_count']; ?></p>
								<p>Views: <?=$this->forum[$key]['counter']; ?></p>
							</td>
							<td class="lastPostMain">
								<p><?=$this->forum[$key]['last_msg_author']; ?></p>
								<p><?=$this->forum[$key]['last_msg_date']; ?></p>	
							</td>
						</tr>
						<?php endforeach?>
					</tbody>
				</table>
			</div>
			
			
			<?php if (!empty($this->forum)):?>
			<div class="welcome">
				<div class="">
					<?php echo $this->paging; ?>
				</div>
				<div class="topicsCount">
					<p>Topics <?=$this->offset;?> to <?=$this->pagemax;?> of <?=$this->getresult;?></p>
				</div>
			</div>
			<?php endif?>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php endif?>
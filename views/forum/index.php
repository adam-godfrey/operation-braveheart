<?php if (empty($this->forum)):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>There are currently no discussion boards.</h2>
		</div>
	</div>
</div>
<?php else:?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php foreach($this->forum as $key => $forumitem):?>
			<div class="row">
				<div class="col-md-5">
					<h5><a href="<?=URL;?>board/pages/<?=$this->forum[$key]['boardid'];?>-<?=$this->forum[$key]['board'];?>"><?=$this->forum[$key]['boardname']; ?></a></h5><p><?=$this->forum[$key]['boarddesc']; ?></p>
				</div>
				<div class="col-md-2">
					<p><?=$this->forum[$key]['messagecount']; ?> Posts</p><p><?=$this->forum[$key]['topiccount']; ?> Topics</p>
				</div>
				<div class="col-md-5">
					<?php if (!empty($this->forum[$key]['topicname'])):?>
					<p><strong>Last post</strong> by <?=$this->forum[$key]['author']; ?></p><p>in <?=$this->forum[$key]['topicname']; ?></p><p>on <?=$this->forum[$key]['postdate']; ?></p>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach?>
		</div>
	</div>
</div>
<?php if (!empty($this->forum)):?>
<div class=""><?php echo $this->paging; ?></div>
<?php endif?>
<?php endif?>

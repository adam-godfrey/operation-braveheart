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
					<p><?=$event['count']; ?></p>
				</div>
			</div>
			<p>Posted on <?=$event['postdate'];?></p>
			<hr />
			<h2><?=$event['title']; ?></h2>
			<h4><?=$event['eventdate'];?></h4>
			<p><?=nl2br($event['content']);?></p>
			<p class="readmore"><a href="<?=URL; ?>events/view/<?=$this->counter; ?>">Read more...</a></p>
		</div>
	</div>
</div>
<?php $this->counter++; ?>
<?php endforeach?>
<?php if (!empty($this->events)):?>
<div class=""><?php echo $this->paging; ?></div>
<?php endif?>
<?php endif?>
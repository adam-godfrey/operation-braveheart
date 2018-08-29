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
			<div class="commentcount">
				<div class="comm-count">
					<p><?php echo $newsitem['count']; ?></p>
				</div>
			</div>
			<p><?php echo $newsitem['postdate'];?></p>
			<hr />
			<h2><?php echo $newsitem['title']; ?></h2>
			<p><?php echo nl2br($newsitem['content']);?></p>
			<p class="readmore"><a href="<?php echo URL; ?>news/view/<?php echo $this->counter; ?>">Read more...</a></p>
		</div>
	</div>
</div>
<?php $this->counter++; ?>
<?php endforeach?>
<?php if (!empty($this->news)):?>
<div class=""><?php echo $this->paging; ?></div>
<?php endif?>
<?php endif?>


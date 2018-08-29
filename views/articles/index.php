<?php if (empty($this->articles)):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>Oops! There is no articles in the database.</h2>
		</div>
	</div>
</div>
<?php else:?>
<?php foreach($this->articles as $article):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="commentcount">
				<div class="comm-count">
					<p><?php echo $article['count']; ?></p>
				</div>
			</div>
			<p><?php echo $article['postdate'];?></p>
			<hr />
			<h2><?php echo $article['title']; ?></h2>
			<p><?php echo nl2br($article['content']);?></p>
			<p class="readmore"><a href="<?php echo URL; ?>articles/view/<?php echo $this->counter; ?>">Read more...</a></p>
		</div>
	</div>
</div>
<?php $this->counter++; ?>
<?php endforeach?>
<?php if (!empty($this->articles)):?>
	<div class=""><?php echo $this->paging; ?></div>
<?php endif?>
<?php endif?>


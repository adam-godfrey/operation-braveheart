<?php if (empty($this->blog)):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>Oops! There are no blogs in the database.</h2>
		</div>
	</div>
</div>
<?php else:?>
<?php foreach($this->blog as $blogsitem):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="commentcount">
				<div class="comm-count">
					<p><?php echo  $blogsitem['count']; ?></p>
				</div>
			</div>
			<p><?php echo $blogsitem['postdate'];?></p>
			<hr />
			<h2><?php echo $blogsitem['title']; ?></h2>
			<p><?php echo nl2br($blogsitem['content']);?></p>
			<p class="readmore"><a href="<?php echo URL; ?>blogs/view/<?php echo $this->counter; ?>">Read more...</a></p>
		</div>
	</div>
	<div class="content_item_bottom"></div>
</div>
<?php $this->counter++; ?>
<?php endforeach?>
<?php if (!empty($this->blog)):?>
<div class=""><?php echo $this->paging; ?></div>
<?php endif?>
<?php endif?>


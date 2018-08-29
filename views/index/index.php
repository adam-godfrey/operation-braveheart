<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<p><?php echo nl2br($this->indexContent['content']); ?></p>
			<p class="committee">David Godfrey</p>
		</div>
	</div>
</div>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="small-banner">
				<img class="img-responsive" src="<?=URL;?>public/images/layout/news.jpg" alt="Operation Braveheart News" title="Operation Braveheart News" width="100%">
			</div>
			<div class="commentcounthome">
				<div class="comm-count"><p><?php echo $this->news[0]['count']; ?></p></div>
			</div>
			<p><?php echo $this->news[0]['postdate']; ?></p>
			<hr />
			<h2><?php echo $this->news[0]['title']; ?></h2>
			<p><?php echo nl2br($this->news[0]['content']); ?></p>
			<p class="readmore"><a href="<?php echo URL; ?>news/view/1">Read more...</a></p>
		</div>
	</div>
</div>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="small-banner">
				<img class="img-responsive" src="<?=URL;?>public/images/layout/blog.jpg" alt="Operation Braveheart Blogs" title="Operation Braveheart Blogs" width="100%">
			</div>
			<div class="commentcounthome">
				<div class="comm-count"><p><?php echo $this->blog[0]['count']; ?></p></div>
			</div>
			<p><?php echo $this->blog[0]['postdate']; ?></p>
			<hr />
			<h2><?php echo $this->blog[0]['title']; ?></h2>
			<p><?php echo nl2br($this->blog[0]['content']); ?></p>
			<p class="readmore"><a href="<?php echo URL; ?>blogs/view/1">Read more...</a></p>
		</div>
	</div>
</div>
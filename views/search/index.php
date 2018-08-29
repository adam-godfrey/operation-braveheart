<?php if (empty($this->searchresults)):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>Oops! There are no matches for "<?=$this->searchterm ;?>".</h2>
		</div>
	</div>
	<div class="content_item_bottom"></div>
</div>
<?php else:?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>Search Results for "<?=$this->searchterm;?>"</h2>
			<p id="searchresults">Results 
			<?php $var = 1;?>
			<?php if($var < $this->entries): ?>
			<strong><?=$var;?></strong> - <strong><?=$this->rowcount;?></strong> of <strong><?=$this->totalcount;?></strong>
			<?php else: ?>
			<strong><?=$var;?></strong> - <strong><?=$var;?></strong> of <strong><?=$this->totalcount;?></strong>
			<?php endif; ?> for <strong><?=$this->searchterm;?></strong> (<strong><?=$this->querytime;?></strong> seconds)</p>
			<?php foreach($this->searchresults as $searchitem):?>
			<?php switch($searchitem['mytable']):
			case 'messages': ?>
			<div class="searchlink"><a href="<?=URL;?>forum"><?=$searchitem['title']; ?></a></div>
			<div class="searchurl"><?=URL;?>forum</div>
			<div class="searchinfo"><?=$searchitem['content']; ?></div>
			<?php break;?>
			<?php case 'news': ?>
			<div class="searchlink"><a href="<?=URL;?>news/view/<?=$searchitem['position']; ?>"><?=$searchitem['title']; ?></a></div>
			<div class="searchurl"><?=URL;?>news/view/<?=$searchitem['position']; ?></div>
			<div class="searchinfo"><?=$searchitem['content']; ?></div>
			<?php break;?>
			<?php case 'events': ?>
			<div class="searchlink"><a href="<?=URL;?>events/view/<?=$searchitem['position']; ?>"><?=$searchitem['title']; ?></a></div>
			<div class="searchurl"><?=URL;?>events/view/<?=$searchitem['position']; ?></div>
			<div class="searchinfo"><?=$searchitem['content']; ?></div>
			<?php break;?>
			<?php case 'blogs': ?>
			<div class="searchlink"><a href="<?=URL;?>blogs/view/<?=$searchitem['position']; ?>"><?=$searchitem['title']; ?></a></div>
			<div class="searchurl"><?=URL;?>blogs/view/<?=$searchitem['position']; ?></div>
			<div class="searchinfo"><?=$searchitem['content']; ?></div>
			<?php break;?>
			<?php case 'articles': ?>
			<div class="searchlink"><a href="<?=URL;?>articles/view/<?=$searchitem['position']; ?>"><?=$searchitem['title']; ?></a></div>
			<div class="searchurl"><?=URL;?>articles/view/<?=$searchitem['position']; ?></div>
			<div class="searchinfo"><?=$searchitem['content']; ?></div>
			<?php break;?>
			<?php endswitch;?>
			<?php $var++; ?>
			<?php endforeach?>
		</div>
	</div>
</div>
<?php if (!empty($this->searchresults)):?>
<div class=""><?php echo $this->paging; ?></div>
<?php endif?>
<?php endif?>
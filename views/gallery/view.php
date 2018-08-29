<div id="content">
	<div class="content_item">
		<div class="content_item_main">
			<div class="newsitem">
				<?php if (empty($this->gallery)):?>
				<h2>Oops! There are no images in the gallery.</h2>
				<?php else:?>
				<?php define ("NUMCOLS",4); $count = 0; ?>
				<h4 class="category"><?=$this->category;?></h4>
				<table class="gallery-7-img">
					<?php foreach($this->gallery as $key => $row): ?>
					<?php if ($count % NUMCOLS == 0) echo "<tr>";  # new row ?>
					<td>
						<a href="<?=URL;?>public/images/gallery/full/<?=$this->gallery[$key]['cat'];?>/<?=$this->gallery[$key]['thumb'];?>" rel="daniel-gallery">
							<img src="<?=URL;?>public/images/gallery/thumbs/<?=$this->gallery[$key]['cat'];?>/<?=$this->gallery[$key]['thumb'];?>" class="img-7-small" alt="" title="" />
						</a>
					</td>
					<?php $count++; ?>
					<?php if ($count % NUMCOLS == 0) echo "</tr>\n";  # end row ?>
					<?php endforeach; ?>
					<?php if ($count % NUMCOLS != 0): ?>
					<?php while ($count++ % NUMCOLS): ?>
					<td>&nbsp;</td>
					<?php endwhile; ?>
					</tr>
					<?php endif; ?>
				</table>
				<?php if (!empty($this->gallery)):?>
				<div class=""><?=$this->paging; ?></div>
				<?php endif?>
				<?php endif?>
			</div>
		</div>
		<div class="content_item_bottom"></div>
	</div>
</div>
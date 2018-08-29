<?php if (empty($this->products)):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>Oops! There is no products in the database.</h2>
		</div>
	</div>
</div>
<?php else:?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="row">
				<?php foreach($this->products as $subitem):?>
				<div class="col-md-4">
					<ul>
						<li><a href="<?=URL;?>shop/view/<?=$subitem['itemid'];?>"><img src="<?=URL;?>public/images/shop/thumbs/<?=$subitem['image'];?>" alt="<?=$subitem['item'];?>" title="<?=$subitem['item'];?>" /></a></li>
						<li><strong><a href="<?=URL;?>shop/view/<?=$subitem['itemid'];?>"><?=$subitem['item'];?></a></strong></li>
						<li><?=$subitem['shortdesc'];?></li>
					
						<?php if(count($subitem['sizes']) > 1): ?>
						<?php $myprice = explode(".",number_format($subitem['price'],2)); ?>
						<li><p>From</p><span class="ucprice">&#163;<?php echo $myprice[0]; ?></span><span class="lcprice">.<?php echo $myprice[1]; ?></span> Free Delivery</li>
						<?php else: ?>
						<?php $myprice = explode(".",number_format($subitem['price'],2)); ?>
						<li><span class="ucprice">&#163;<?php echo $myprice[0]; ?></span><span class="lcprice">.<?php echo $myprice[1]; ?></span> Free Delivery</li>
					
						<?php endif; ?>	
					</ul>
				</div>
				<?php endforeach?>
			</div>
		</div>
	</div>
</div>
<?php if (!empty($this->products)):?>
<div class=""><?php echo $this->paging; ?></div>
<?php endif?>
<?php endif?>
<?php if (empty($this->products)):?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<h2>Oops! This product does not exist.</h2>
		</div>
	</div>
</div>
<?php else:?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div class="row">
				<?php foreach($this->products as $subitem):?>
				<div class="col-md-6">
					<img src="<?=URL;?>public/images/shop/large/<?=$subitem['image'];?>" alt="<?=$subitem['shortdesc'];?>" title="<?=$subitem['shortdesc'];?>">
				</div>
				<div class="col-md-6">
					<?php echo Form::open(array('id' => '', 'class' => 'form form-horizontal', 'action' => URL . 'shop', 'method' => 'post', 'role' => 'form'));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'jcartToken', 'value' => $this->jcart_session));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'my-item-id', 'value' => $subitem['prodid']));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'my-item-price', 'value' => $subitem['price']));?>
					<?php echo Form::input(array('type' => 'hidden', 'name' => 'my-item-url', 'value' => ''));?>
					
					<ul>
						<li><h4><a href=""><?=$subitem['item'];?></a></h4></li>
						<li><?=$subitem['description'];?></li>
						<?php if(count($subitem['sizes']) > 1): ?>
						<li>Sizes available:
							<ul>
								<?php foreach($subitem['sizes'] as $size => $price): ?>
								<li><?=$size;?>: &#163;<?=$price;?></li>
								<?php endforeach; ?>
							</ul>
						</li>
						<li>
							<select class="form-control" name="my-item-name" id="item_<?=$subitem['prodid'];?>">
								<?php foreach($subitem['sizes'] as $size => $price): ?>
								<option value="<?=$size;?>"><?=$size;?> (&#163;<?=$price;?>)</option>
								<?php endforeach; ?>
							</select>
						</li>
						<?php else: ?>
						<?php echo Form::input(array('type' => 'hidden', 'name' => 'my-item-name', 'value' => key($subitem['sizes']) ));?>
						<?php endif; ?>
						
						<?php $myprice = explode(".",number_format($subitem['price'],2)); ?>
						<li><span id="myprice_<?=$subitem['prodid'];?>" class="ucprice">&#163;<?=$myprice[0];?></span>.<span id="myprice2_<?=$subitem['prodid'];?>" class="lcprice">.<?=$myprice[1];?></span></li>
					</ul>
					<?php echo Form::button(array('type' => 'submit', 'class' => 'btn btn-default', 'name' => 'my-add-button'),'Add to cart');?>

					<?php echo Form::close();?>
				</div>
				<?php endforeach?>
			</div>
		</div>
	</div>
</div>
<?php endif?>
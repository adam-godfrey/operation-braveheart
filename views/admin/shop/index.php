<?php
	function Button($name) {
		global $buttons; // access the global $buttons array
		if(isset($buttons[$name])) {
			foreach($buttons[$name] as $attr_name => $attr_value)
				$attrs[] = sprintf('%s="%s"', $attr_name, $attr_value);
			return '<input type="button" '.implode(' ', $attrs).' />';
		}
		return;
	}
?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/shop', 'method' => 'post', 'role' => 'form'));?>
			<div id="admin-buttons">
				<?php foreach ($this->buttons as $button): ?>
				<?php echo Button($button); ?>
				<?php endforeach; ?>
			</div>
			<?php if(isset($this->success)) : ?>
			<?php if($this->success['result']) : ?>
			<div id="form-submit" class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Success!</strong> Shop item <?=$this->success['action'];?>.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Shop item not <?=$this->success['action'];?>.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php if ( empty($this->active_items) && empty($this->disabled_items) ):?>
			<h2>Oops! There is no shop in the database.</h2>
			<?php else:?>
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#sectionA"><strong>Current</strong></a></li>
				<li><a data-toggle="tab" href="#sectionB"><strong>Disabled</strong></a></li>
			</ul>
			<div class="tab-content">
				<div id="sectionA" class="tab-pane fade in active">
					<div class="table-responsive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="col-md-1"><?php echo Form::input(array('type' => 'checkbox', 'name' => 'checkAll', 'id' => 'checkAll'));?></th>
									<th class="col-md-2">Code</th>
									<th class="col-md-5">Item</th>
									<th class="col-md-1">Size</th>
									<th class="col-md-2">Price</th>
									<th class="col-md-1">Stock</th>
								</tr>
							</thead>
							<tbody>
								<?php if(empty($this->active_items)): ?>
								<tr>
									<td colspan="3">No active shop to display</td>
								</tr>
								<?php else: ?>
								<?php foreach($this->active_items as $item):?>
								<tr>
									<td><?php echo Form::input(array('type' => 'checkbox', 'name' => 'id[]', 'value' => $item['prodid']));?></td>
									<td><a href="<?=URL;?>admin/shop/edit/<?=$item['itemid'];?>"><?=$item['itemid'];?></a></td>
									<td><a href="<?=URL;?>admin/shop/edit/<?=$item['itemid'];?>"><?=$item['item'];?></a></td>
									<td><a href="<?=URL;?>admin/shop/edit/<?=$item['itemid'];?>"><?=$item['size'];?></a></td>
									<td><a href="<?=URL;?>admin/shop/edit/<?=$item['itemid'];?>"><?=$item['price'];?></a></td>
									<td><a href="<?=URL;?>admin/shop/edit/<?=$item['itemid'];?>"><?=$item['stock'];?></a></td>
								</tr>
								<?php endforeach?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="sectionB" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="col-md-1"><?php echo Form::input(array('type' => 'checkbox', 'name' => 'checkAll', 'id' => 'checkAll'));?></th>
									<th class="col-md-2">Code</th>
									<th class="col-md-5">Item</th>
									<th class="col-md-1">Size</th>
									<th class="col-md-2">Price</th>
									<th class="col-md-1">Stock</th>
								</tr>
							</thead>
							<tbody>
								<?php if(empty($this->disabled_items)): ?>
								<tr>
									<td colspan="3">No disabled shop to display</td>
								</tr>
								<?php else: ?>
								<?php foreach($this->disabled_items as $item):?>
								<tr>
									<td><?php echo Form::input(array('type' => 'checkbox', 'name' => 'id[]', 'value' => $item['prodid']));?></td>
									<td><a href="<?=URL;?>admin/shop/edit/<?=$item['itemid'];?>"><?=$item['itemid'];?></a></td>
									<td><a href="<?=URL;?>admin/shop/edit/<?=$item['itemid'];?>"><?=$item['item'];?></a></td>
									<td><a href="<?=URL;?>admin/shop/edit/<?=$item['itemid'];?>"><?=$item['size'];?></a></td>
									<td><a href="<?=URL;?>admin/shop/edit/<?=$item['itemid'];?>"><?=$item['price'];?></a></td>
									<td><a href="<?=URL;?>admin/shop/edit/<?=$item['itemid'];?>"><?=$item['stock'];?></a></td>
								</tr>
								<?php endforeach?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			<?php if( (!empty($this->active_items)) || (!empty($this->disabled_items)) ):?>
			<div class=""><?php echo $this->paging; ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>

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
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/poems', 'method' => 'post', 'role' => 'form'));?>
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
				<strong>Success!</strong> Poem <?=$this->success['action'];?>.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Poem not <?=$this->success['action'];?>.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php if (empty($this->poems)):?>
			<h2>Oops! There are no poems in the database.</h2>
			<?php else:?>
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'checkAll', 'id' => 'checkAll'));?></th>
							<th>Title</th>
							<th>Author</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($this->poems as $poem):?>
						<tr>
							<td><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'id[]', 'value' => $poem['id']));?></td>
							<td><a href="<?=URL;?>admin/poems/edit/<?=$poem['id'];?>"><?=$poem['title'];?></a></td>
							<td><?=$poem['author'];?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			<?php if (!empty($this->poems)):?>
			<div><?php echo $this->paging; ?></div>
			<?php endif?>
			<?php endif?>	
		</div>
	</div>
</div>
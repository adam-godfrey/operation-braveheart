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
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/flaggedposts', 'method' => 'post', 'role' => 'form'));?>
			<div id="admin-buttons">
				<?php foreach ($this->buttons as $button): ?>
				<?php echo Button($button); ?>
				<?php endforeach; ?>
			</div>
			<?php if (empty($this->flaggedposts)):?>
			<h2>Oops! There are no flagged posts in the database.</h2>
			<?php else:?>
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'checkAll', 'id' => 'checkAll'));?></th>
							<th class="">Author</th>
							<th class="">Comment</th>
							<th class="date">Post Date</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($this->flaggedposts as $flagged):?>
						<tr>
							<td class="checkbox"><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'id[]', 'value' => $flagged['messageid']));?></td>
							<td><a href="<?=URL;?>admin/flaggedposts/edit/<?=$flagged['id'];?>"><?=$flagged['author'];?></a></td>
							<td><a href="<?=URL;?>admin/flaggedposts/edit/<?=$flagged['id'];?>"><?=$flagged['message'];?></a></td>
							<td><a href="<?=URL;?>admin/flaggedposts/edit/<?=$flagged['id'];?>"><?=$flagged['postdate'];?></a></td>
						</tr>
						<?php endforeach?>
					</tbody>
				</table>
			</div>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			<?php if (!empty($this->flaggedposts)):?>
			<div class=""><?php echo $this->paging; ?></div>
			<?php endif?>
			<?php endif?>	
		</div>
	</div>
</div>
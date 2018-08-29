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
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/boards', 'method' => 'post', 'role' => 'form'));?>
			<div id="admin-buttons">
				<?php foreach ($this->buttons as $button): ?>
				<?php echo Button($button); ?>
				<?php endforeach; ?>
			</div>
			<?php if(isset($this->success)) : ?>
			<div id="form-submit" class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Success!</strong> Forum Board deleted.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Forum Board not deleted.
			</div>
			<?php endif; ?>
			<?php if (empty($this->boards)):?>
			<h2>Oops! There are no forum boards in the database.</h2>
			<?php else:?>
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'checkAll', 'id' => 'checkAll'));?></th>
							<th class="">Board Name</th>
							<th class="">Topics</th>
							<th class="">Posts</th>
							<th class="">Last Post in...</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($this->boards as $board):?>
						<tr>
							<td class="checkbox"><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'id[]', 'value' => $board['id']));?></td>
							<td><?=$board['boardname'];?></td>
							<td><?=$board['topiccount'];?></td>
							<td><?=$board['messagecount'];?></td>
							<td><?=$board['topicname'];?></td>
						</tr>
						<?php endforeach?>
					</tbody>
				</table>
			</div>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			<?php if (!empty($this->boards)):?>
			<div class=""><?php echo $this->paging; ?></div>
			<?php endif?>
			<?php endif?>
		</div>
	</div>
</div>

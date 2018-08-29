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
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/newsletters', 'method' => 'post', 'role' => 'form'));?>
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
				<strong>Success!</strong> Newsletter <?=$this->success['action'];?>.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Newsletter not <?=$this->success['action'];?>.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php if ( empty($this->unsent_newsletters) && empty($this->sent_newsletters)):?>
			<h2>Oops! There are no newsletters in the database.</h2>
			<?php else:?>
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#sectionA"><strong>Unsent</strong></a></li>
				<li><a data-toggle="tab" href="#sectionB"><strong>Sent</strong></a></li>
			</ul>
			<div class="tab-content">
				<div id="sectionA" class="tab-pane fade in active">
					<div class="table-responsive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'checkAll', 'id' => 'checkAll'));?></th>
									<th>Title</th>
									<th>Date Created</th>
								</tr>
							</thead>
							<tbody>
								<?php if(empty($this->unsent_newsletters)): ?>
								<tr>
									<td colspan="3">No unsent newsletters display</td>
								</tr>
								<?php else: ?>
								<?php foreach($this->unsent_newsletters as $newsletter):?>
								<tr>
									<td><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'id[]', 'value' => $newsletter['id']));?></td>
									<td><a href="<?=URL;?>admin/newsletters/edit/<?=$newsletter['id'];?>"><?=$newsletter['title'];?></a></td>
									<td><?=$newsletter['created'];?></td>
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
									<th><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'checkAll', 'id' => 'checkAll'));?></th>
									<th>Title</th>
									<th>Date Created</th>
									<th>Date Sent</th>
								</tr>
							</thead>
							<tbody>
								<?php if(empty($this->sent_newsletters)): ?>
								<tr>
									<td colspan="4">No sent newsletters to display</td>
								</tr>
								<?php else: ?>
								<?php foreach($this->sent_newsletters as $newsletter):?>
								<tr>
									<td><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'id[]', 'value' => $newsletter['id']));?></td>
									<td><a href="<?=URL;?>admin/newsletters/edit/<?=$newsletter['id'];?>"><?=$newsletter['title'];?></a></td>
									<td><?=$newsletter['date_created'];?></td>
									<td><?=$newsletter['date_sent'];?></td>
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
			<?php if ( !empty($this->unsent_newsletters) || !empty($this->sent_newsletters)):?>
			<div class=""><?php echo $this->paging; ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>

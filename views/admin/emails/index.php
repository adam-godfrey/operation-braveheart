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
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/emails', 'method' => 'post', 'role' => 'form'));?>
			<div id="admin-buttons">
				<?php foreach ($this->buttons as $button): ?>
				<?php echo Button($button); ?>
				<?php endforeach; ?>
			</div>
			<?php if (empty($this->comments)):?>
			<h2>Oops! There are no emails in the database.</h2>
			<?php else:?>
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#sectionA"><strong>New</strong></a></li>
				<li><a data-toggle="tab" href="#sectionB"><strong>Awaiting response</strong></a></li>
				<li><a data-toggle="tab" href="#sectionC"><strong>Responded to</strong></a></li>
			</ul>
			<div class="tab-content">
				<div id="sectionA" class="tab-pane fade in active">
					<div class="table-responsive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'checkAll', 'id' => 'checkAll'));?></th>
									<th>Sender</th>
									<th>Subject</th>
									<th>Date Received</th>
								</tr>
							</thead>
							<tbody>
								<?php $not_opened = 0; ?>
								<?php foreach($this->emails as $email):?>
								<?php if($email['opened'] == 'N'): ?>
								<tr>
									<?php $not_opened++; ?>
									<td><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'id[]', 'value' => $email['id']));?></td>
									<td><?=$email['name'];?></td>
									<td><a href="<?=URL;?>admin/emails/view/<?=$email['id'];?>"><?=$email['subject'];?></a></td>
									<td><?=$email['date_rec'];?></td>
								</tr>
								<?php endif; ?>
								<?php endforeach?>
								<?php if($not_opened == 0): ?>
								<tr>
									<td>No new emails in database</td>
								</tr>
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
									<th>Sender</th>
									<th>Subject</th>
									<th>Date Received</th>
								</tr>
							</thead>
							<tbody>
								<?php $not_responded = 0; ?>
								<?php foreach($this->emails as $email):?>
								<?php if($email['opened'] == 'Y' && $email['replied'] == 'N'): ?>
								<tr>
									<?php $not_responded++; ?>
									<td><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'id[]', 'value' => $email['id']));?></td>
									<td><?=$email['name'];?></td>
									<td><a href="<?=URL;?>admin/emails/view/<?=$email['id'];?>"><?=$email['subject'];?></a></td>
									<td><?=$email['date_rec'];?></td>
								</tr>
								<?php endif; ?>
								<?php endforeach?>
								<?php if($not_responded == 0): ?>
								<tr>
									<td>No emails awaiting response in database</td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="sectionC" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'checkAll', 'id' => 'checkAll'));?></th>
									<th>Sender</th>
									<th>Subject</th>
									<th>Date Received</th>
									<th>Date Replied</th>
								</tr>
							</thead>
							<tbody>
								<?php $responded = 0; ?>
								<?php foreach($this->emails as $email):?>
								<?php if($email['opened'] == 'Y' && $email['responded'] == 'Y'): ?>
								<tr>
									<?php $responded++; ?>
									<td><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'id[]', 'value' => $email['id']));?></td>
									<td><?=$email['sender'];?></td>
									<td><a href="<?=URL;?>admin/emails/view/<?=$email['id'];?>"><?=$email['subject'];?></a></td>
									<td><?=$email['date_received'];?></td>
									<td><?=$email['date_replied'];?></td>
								</tr>
								<?php endif; ?>
								<?php endforeach?>
								<?php if($responded == 0): ?>
								<tr>
									<td>No emails responded to in database</td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			</table>
			<?php if (!empty($this->emails)):?>
			<div class=""><?php echo $this->paging; ?></div>
			<?php endif?>
			<?php endif?>
		</div>
	</div>
</div>

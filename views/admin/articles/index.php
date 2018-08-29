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
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/articles', 'method' => 'post', 'role' => 'form'));?>
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
				<strong>Success!</strong> Article <?=$this->success['action'];?>.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Article not <?=$this->success['action'];?>.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php if ( empty($this->active_articles) && empty($this->archived_articles) ):?>
			<h2>Oops! There is no articles in the database.</h2>
			<?php else:?>
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#sectionA"><strong>Current</strong></a></li>
				<li><a data-toggle="tab" href="#sectionB"><strong>Archived</strong></a></li>
			</ul>
			<div class="tab-content">
				<div id="sectionA" class="tab-pane fade in active">
					<div class="table-responsive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'checkAll', 'id' => 'checkAll'));?></th>
									<th>Title</th>
									<th>Date Published</th>
								</tr>
							</thead>
							<tbody>
								<?php if(empty($this->active_articles)): ?>
								<tr>
									<td colspan="3">No active articles to display</td>
								</tr>
								<?php else: ?>
								<?php foreach($this->active_articles as $article):?>
								<tr>
									<td><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'id[]', 'value' => $article['id']));?></td>
									<td><a href="<?=URL;?>admin/articles/edit/<?=$article['id'];?>"><?=$article['title'];?></a></td>
									<td><?=$article['postdate'];?></td>
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
									<th>Date Published</th>
								</tr>
							</thead>
							<tbody>
								<?php if(empty($this->archived_articles)): ?>
								<tr>
									<td colspan="3">No archived articles to display</td>
								</tr>
								<?php else: ?>
								<?php foreach($this->archived_articles as $article):?>
								<tr>
									<td><?php echo Form::input(array('type' => 'checkbox', 'class' => '', 'name' => 'id[]', 'value' => $article['id']));?></td>
									<td><a href="<?=URL;?>admin/articles/edit/<?=$article['id'];?>"><?=$article['title'];?></a></td>
									<td><?=$article['postdate'];?></td>
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
			<?php if( (!empty($this->active_articles)) || (!empty($this->archived_articles)) ):?>
			<div class=""><?php echo $this->paging; ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>

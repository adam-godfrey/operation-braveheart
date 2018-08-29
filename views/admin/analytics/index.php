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
			<?php echo Form::open(array('id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/', 'method' => 'post', 'role' => 'form'));?>
			<div id="admin-buttons">
				<?php foreach ($this->buttons as $button): ?>
				<?php echo Button($button); ?>
				<?php endforeach; ?>
			</div>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			<div id="analytics">
				<div id="count_users">
					<div id="visitor_count">
						<div id="gumf">
							<div id="now">Right now</div>
							<div id="online"></div>
							<div id="active">active visistors on site</div>
						</div>
						<div id="legend">
							<div class="visitors_legend"></div>
							<div class="legend_text">VISITORS</div>
							<div class="users_legend"></div>
							<div class="legend_text">MEMBERS</div>
						</div>
						<div id="percentbar">
							<div class="bar" id="leftbar"></div>
							<div class="bar" id="rightbar"></div>
						</div>
					</div>
					<div id="online_users">
					<p><span>Current Active Members:</span></p>
					<div id="usernames"></div>
					</div>
				</div>
				<div id="active_pages">
					<p>Top Active Pages:</p>
					<ul id="myTab" class="nav nav-tabs">
						<li class="active">
							<a href="#today" data-toggle="tab">Today</a>
						</li>
						<li>
							<a href="#week" data-toggle="tab">This Week</a>
						</li>
						<li>
							<a href="#month" data-toggle="tab">This Month</a>
						</li>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane fade in active" id="today">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<tr>
										<th colspan="2">Active Page</th>
										<th></th>
										<th>Active Visits</th>
									</tr>
									<?php for($i=1; $i < 11; $i++): ?>
									<tr>
										<td><?php echo $i; ?>.</td>
										<td><?=isset($this->dailyhits[$i-1]['pagename']) ? '<a href="'.URL.str_replace('url=', '', $this->dailyhits[$i-1]['pagename']).'">'.str_replace('url=', '/', $this->dailyhits[$i-1]['pagename']).'</a>' : ''; ?></td>
										<td></td>
										<td>
											<div class="linebar" style="width:<?=isset($this->dailyhits[$i-1]['maxwidth']) ? $this->dailyhits[$i-1]['maxwidth'].'px' : '0px'; ?>"></div>
											<div class="percent" ><?=isset($this->dailyhits[$i-1]['hits']) ? $this->dailyhits[$i-1]['hits'].'%' : ''; ?></div>
										</td>
									</tr>
									<?php endfor; ?>
								</table>
							</div>
						</div>
						<div class="tab-pane fade" id="week">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<tr>
										<th colspan="2">Active Page</th>
										<th></th>
										<th>Active Visits</th>
									</tr>
									<?php for($i=1; $i < 11; $i++): ?>
									<tr>
										<td><?php echo $i; ?>.</td>
										<td><?=isset($this->weeklyhits[$i-1]['pagename']) ? '<a href="'.URL.str_replace('url=', '', $this->weeklyhits[$i-1]['pagename']).'">'.str_replace('url=', '/', $this->weeklyhits[$i-1]['pagename']).'</a>' : ''; ?></td>
										<td></td>
										<td>
											<div class="linebar" style="width:<?=isset($this->weeklyhits[$i-1]['maxwidth']) ? $this->weeklyhits[$i-1]['maxwidth'].'px' : '0px'; ?>"></div>
											<div class="percent" ><?=isset($this->weeklyhits[$i-1]['hits']) ? $this->weeklyhits[$i-1]['hits'].'%' : ''; ?></div>
										</td>
									</tr>
									<?php endfor; ?>
								</table>
							</div>
						</div>
						<div class="tab-pane fade" id="month">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<tr>
										<th colspan="2">Active Page</th>
										<th></th>
										<th>Active Visits</th>
									</tr>
									<?php for($i=1; $i < 11; $i++): ?>
									<tr>
										<td><?php echo $i; ?>.</td>
										<td><?=isset($this->monthlyhits[$i-1]['pagename']) ? '<a href="'.URL.str_replace('url=', '', $this->monthlyhits[$i-1]['pagename']).'">'.str_replace('url=', '/', $this->monthlyhits[$i-1]['pagename']).'</a>' : ''; ?></td>
										<td></td>
										<td>
											<div class="linebar" style="width:<?=isset($this->monthlyhits[$i-1]['maxwidth']) ? $this->monthlyhits[$i-1]['maxwidth'].'px' : '0px'; ?>"></div>
											<div class="percent" ><?=isset($this->monthlyhits[$i-1]['hits']) ? $this->monthlyhits[$i-1]['hits'].'%' : ''; ?></div>
										</td>
									</tr>
									<?php endfor; ?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
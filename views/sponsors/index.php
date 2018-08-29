<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php if (empty($this->sponsors)):?>
			<h2>Oops! There are no sponsors in the database.</h2>
			<?php else:?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Company Name</th>
							<th>Location</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($this->sponsors as $sponsor):?>
						<tr>
							<td>
								<?php if(!empty($sponsor['url'])): ?>
								<a href="<?=$sponsor['url'];?>"><?=$sponsor['name']; ?></a>
								<?php else: ?>
								<?=$sponsor['name']; ?>
								<?php endif; ?>
							</td>
							<td><?=$sponsor['location']; ?></td>
						</tr>
						<?php endforeach?>
					</tbody>
					<tfoot>
						<tr>
							<th>Company Name</th>
							<th>Location</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<?php if (!empty($this->sponsors)):?>
			<div class=""><?=$this->paging; ?></div>
			<?php endif?>
			<?php endif?>
		</div>
	</div>
</div>
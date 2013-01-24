<div class="tours index">
	<h2><?php echo __('Tours'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('start_time'); ?></th>
			<th><?php echo $this->Paginator->sort('end_time'); ?></th>
			<th><?php echo $this->Paginator->sort('image'); ?></th>
			<th><?php echo $this->Paginator->sort('like_count'); ?></th>
			<th><?php echo $this->Paginator->sort('category'); ?></th>
			<th><?php echo $this->Paginator->sort('tags'); ?></th>
			<th><?php echo $this->Paginator->sort('topic'); ?></th>
			<th><?php echo $this->Paginator->sort('lat_min'); ?></th>
			<th><?php echo $this->Paginator->sort('lat_max'); ?></th>
			<th><?php echo $this->Paginator->sort('lng_min'); ?></th>
			<th><?php echo $this->Paginator->sort('lng_max'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($tours as $tour): ?>
	<tr>
		<td><?php echo h($tour['Tour']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($tour['User']['name'], array('controller' => 'users', 'action' => 'view', $tour['User']['id'])); ?>
		</td>
		<td><?php echo h($tour['Tour']['name']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['description']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['start_time']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['end_time']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['image']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['like_count']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['category']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['tags']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['topic']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['lat_min']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['lat_max']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['lng_min']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['lng_max']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['created']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['modified']); ?>&nbsp;</td>
		<td><?php echo h($tour['Tour']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tour['Tour']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tour['Tour']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tour['Tour']['id']), null, __('Are you sure you want to delete # %s?', $tour['Tour']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Tour'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Routes'), array('controller' => 'routes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route'), array('controller' => 'routes', 'action' => 'add')); ?> </li>
	</ul>
</div>

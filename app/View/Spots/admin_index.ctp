<div class="spots index">
	<h2><?php echo __('Spots'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('image'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('stay_time'); ?></th>
			<th><?php echo $this->Paginator->sort('lat'); ?></th>
			<th><?php echo $this->Paginator->sort('lng'); ?></th>
			<th><?php echo $this->Paginator->sort('prefecture'); ?></th>
			<th><?php echo $this->Paginator->sort('zoom'); ?></th>
			<th><?php echo $this->Paginator->sort('like_count'); ?></th>
			<th><?php echo $this->Paginator->sort('category'); ?></th>
			<th><?php echo $this->Paginator->sort('tags'); ?></th>
			<th><?php echo $this->Paginator->sort('keyword'); ?></th>
			<th><?php echo $this->Paginator->sort('addition'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($spots as $spot): ?>
	<tr>
		<td><?php echo h($spot['Spot']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($spot['User']['name'], array('controller' => 'users', 'action' => 'view', $spot['User']['id'])); ?>
		</td>
		<td><?php echo h($spot['Spot']['name']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['image']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['description']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['stay_time']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['lat']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['lng']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['prefecture']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['zoom']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['like_count']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['category']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['tags']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['keyword']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['addition']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['created']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['modified']); ?>&nbsp;</td>
		<td><?php echo h($spot['Spot']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $spot['Spot']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $spot['Spot']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $spot['Spot']['id']), null, __('Are you sure you want to delete # %s?', $spot['Spot']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Spot'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Routes'), array('controller' => 'routes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route'), array('controller' => 'routes', 'action' => 'add')); ?> </li>
	</ul>
</div>

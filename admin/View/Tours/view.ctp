<div class="tours view">
<h2><?php  echo __('Tour'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tour['User']['name'], array('controller' => 'users', 'action' => 'view', $tour['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Time'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['start_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End Time'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['end_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['image']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Like Count'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['like_count']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['category']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tags'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['tags']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Topic'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['topic']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat Min'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['lat_min']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat Max'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['lat_max']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lng Min'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['lng_min']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lng Max'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['lng_max']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($tour['Tour']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tour'), array('action' => 'edit', $tour['Tour']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tour'), array('action' => 'delete', $tour['Tour']['id']), null, __('Are you sure you want to delete # %s?', $tour['Tour']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tours'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tour'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Routes'), array('controller' => 'routes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route'), array('controller' => 'routes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Routes'); ?></h3>
	<?php if (!empty($tour['Route'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Tour Id'); ?></th>
		<th><?php echo __('Spot Id'); ?></th>
		<th><?php echo __('Stay Time'); ?></th>
		<th><?php echo __('Sort'); ?></th>
		<th><?php echo __('Info'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($tour['Route'] as $route): ?>
		<tr>
			<td><?php echo $route['id']; ?></td>
			<td><?php echo $route['tour_id']; ?></td>
			<td><?php echo $route['spot_id']; ?></td>
			<td><?php echo $route['stay_time']; ?></td>
			<td><?php echo $route['sort']; ?></td>
			<td><?php echo $route['info']; ?></td>
			<td><?php echo $route['created']; ?></td>
			<td><?php echo $route['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'routes', 'action' => 'view', $route['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'routes', 'action' => 'edit', $route['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'routes', 'action' => 'delete', $route['id']), null, __('Are you sure you want to delete # %s?', $route['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Route'), array('controller' => 'routes', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

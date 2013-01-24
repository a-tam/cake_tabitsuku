<div class="spots view">
<h2><?php  echo __('Spot'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($spot['User']['name'], array('controller' => 'users', 'action' => 'view', $spot['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['image']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Stay Time'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['stay_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lng'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['lng']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prefecture'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['prefecture']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zoom'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['zoom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Like Count'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['like_count']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['category']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tags'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['tags']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keyword'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['keyword']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Addition'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['addition']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($spot['Spot']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Spot'), array('action' => 'edit', $spot['Spot']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Spot'), array('action' => 'delete', $spot['Spot']['id']), null, __('Are you sure you want to delete # %s?', $spot['Spot']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Spots'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Spot'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Routes'), array('controller' => 'routes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route'), array('controller' => 'routes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Routes'); ?></h3>
	<?php if (!empty($spot['Route'])): ?>
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
		foreach ($spot['Route'] as $route): ?>
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

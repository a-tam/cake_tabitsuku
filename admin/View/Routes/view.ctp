<div class="routes view">
<h2><?php  echo __('Route'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($route['Route']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tour'); ?></dt>
		<dd>
			<?php echo $this->Html->link($route['Tour']['name'], array('controller' => 'tours', 'action' => 'view', $route['Tour']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Spot'); ?></dt>
		<dd>
			<?php echo $this->Html->link($route['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $route['Spot']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Stay Time'); ?></dt>
		<dd>
			<?php echo h($route['Route']['stay_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sort'); ?></dt>
		<dd>
			<?php echo h($route['Route']['sort']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Info'); ?></dt>
		<dd>
			<?php echo h($route['Route']['info']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($route['Route']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($route['Route']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Route'), array('action' => 'edit', $route['Route']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Route'), array('action' => 'delete', $route['Route']['id']), null, __('Are you sure you want to delete # %s?', $route['Route']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Routes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tours'), array('controller' => 'tours', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tour'), array('controller' => 'tours', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Spots'), array('controller' => 'spots', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Spot'), array('controller' => 'spots', 'action' => 'add')); ?> </li>
	</ul>
</div>

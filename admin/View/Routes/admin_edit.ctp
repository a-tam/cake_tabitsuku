<div class="routes form">
<?php echo $this->Form->create('Route'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Route'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('tour_id');
		echo $this->Form->input('spot_id');
		echo $this->Form->input('stay_time');
		echo $this->Form->input('sort');
		echo $this->Form->input('info');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Route.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Route.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Routes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Tours'), array('controller' => 'tours', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tour'), array('controller' => 'tours', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Spots'), array('controller' => 'spots', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Spot'), array('controller' => 'spots', 'action' => 'add')); ?> </li>
	</ul>
</div>

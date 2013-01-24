<div class="tours form">
<?php echo $this->Form->create('Tour'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Tour'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('start_time');
		echo $this->Form->input('end_time');
		echo $this->Form->input('image');
		echo $this->Form->input('like_count');
		echo $this->Form->input('category');
		echo $this->Form->input('tags');
		echo $this->Form->input('topic');
		echo $this->Form->input('lat_min');
		echo $this->Form->input('lat_max');
		echo $this->Form->input('lng_min');
		echo $this->Form->input('lng_max');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tours'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Routes'), array('controller' => 'routes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route'), array('controller' => 'routes', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="reviews form">
<?php echo $this->Form->create('Review'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Review'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_by');
		echo $this->Form->input('user_to');
		echo $this->Form->input('reservation_id');
		echo $this->Form->input('property_id');
		echo $this->Form->input('title');
		echo $this->Form->input('review');
		echo $this->Form->input('token');
		echo $this->Form->input('cleanliness');
		echo $this->Form->input('communication');
		echo $this->Form->input('house_rules');
		echo $this->Form->input('accurancy');
		echo $this->Form->input('checkin');
		echo $this->Form->input('location');
		echo $this->Form->input('value');
		echo $this->Form->input('publish_date');
		echo $this->Form->input('is_dummy');
		echo $this->Form->input('dummy_user');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Review.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Review.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Reviews'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Reservations'), array('controller' => 'reservations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Reservation'), array('controller' => 'reservations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Properties'), array('controller' => 'properties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property'), array('controller' => 'properties', 'action' => 'add')); ?> </li>
	</ul>
</div>

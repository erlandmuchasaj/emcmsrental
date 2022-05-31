<div class="reviews form">
<?php echo $this->Form->create('Review'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Review'); ?></legend>
	<?php
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
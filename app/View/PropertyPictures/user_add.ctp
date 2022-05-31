<div class="propertyPictures form">
<?php echo $this->Form->create('PropertyPicture', array('type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Add Property Picture'); ?></legend>
	<?php
		echo $this->Form->input('property_id');
		echo $this->Form->input('image_path.', array('type'=>'file','multiple'=>true));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>


<div class="propertyPictures view">
<h2><?php echo __('Property Picture'); ?></h2>
	<dl>

		<dt><?php echo __('Property'); ?></dt>
		<dd>
			<?php echo $this->Html->link($propertyPicture['Property']['address'], array('controller' => 'properties', 'action' => 'view', $propertyPicture['Property']['id'])); ?>

		</dd>
		<dt><?php echo __('Image Path'); ?></dt>
		<dd>
			<?php echo h($propertyPicture['PropertyPicture']['image_path']); ?>

		</dd>

		<dt><?php echo __('Is Featured'); ?></dt>
		<dd>
			<?php echo h($propertyPicture['PropertyPicture']['is_featured']); ?>

		</dd>
		<dt><?php echo __('Publish Status'); ?></dt>
		<dd>
			<?php echo h($propertyPicture['PropertyPicture']['publish_status']); ?>

		</dd>
	</dl>
</div>

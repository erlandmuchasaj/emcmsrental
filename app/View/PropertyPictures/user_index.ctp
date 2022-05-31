	<h2><?php echo __('Property Pictures'); ?></h2>
	<table cellpadding="0" cellspacing="0">
		<thead>
			<tr>

				<th><?php echo $this->Paginator->sort('property_id'); ?></th>
				<th><?php echo $this->Paginator->sort('image_path'); ?></th>
				<th><?php echo $this->Paginator->sort('is_featured'); ?></th>
				<th><?php echo $this->Paginator->sort('publish_status'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($propertyPictures as $propertyPicture): ?>
			<tr>

				<td>
					<?php echo $this->Html->link($propertyPicture['Property']['address'], array('controller' => 'properties', 'action' => 'view', $propertyPicture['Property']['id'])); ?>
				</td>
				<td><?php echo h($propertyPicture['PropertyPicture']['image_path']); ?>&nbsp;</td>

				<td><?php echo h($propertyPicture['PropertyPicture']['is_featured']); ?>&nbsp;</td>
				<td><?php echo h($propertyPicture['PropertyPicture']['publish_status']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $propertyPicture['PropertyPicture']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $propertyPicture['PropertyPicture']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $propertyPicture['PropertyPicture']['id']), array(), __('Are you sure you want to delete # %s?', $propertyPicture['PropertyPicture']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>


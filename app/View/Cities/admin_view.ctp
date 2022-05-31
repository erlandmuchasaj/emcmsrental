<div class="cities view">
<h2><?php echo __('City'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($city['City']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($city['City']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($city['City']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Around'); ?></dt>
		<dd>
			<?php echo h($city['City']['around']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Known'); ?></dt>
		<dd>
			<?php echo h($city['City']['known']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image Path'); ?></dt>
		<dd>
			<?php echo h($city['City']['image_path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Home'); ?></dt>
		<dd>
			<?php echo h($city['City']['is_home']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($city['City']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($city['City']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit City'), array('action' => 'edit', $city['City']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete City'), array('action' => 'delete', $city['City']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $city['City']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Cities'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New City'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List City Places'), array('controller' => 'city_places', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New City Place'), array('controller' => 'city_places', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related City Places'); ?></h3>
	<?php if (!empty($city['CityPlace'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('City Id'); ?></th>
		<th><?php echo __('City Name'); ?></th>
		<th><?php echo __('Place Name'); ?></th>
		<th><?php echo __('Quote'); ?></th>
		<th><?php echo __('Short Description'); ?></th>
		<th><?php echo __('Long Description'); ?></th>
		<th><?php echo __('Image Path'); ?></th>
		<th><?php echo __('Lat'); ?></th>
		<th><?php echo __('Lng'); ?></th>
		<th><?php echo __('Is Featured'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($city['CityPlace'] as $cityPlace): ?>
		<tr>
			<td><?php echo $cityPlace['id']; ?></td>
			<td><?php echo $cityPlace['city_id']; ?></td>
			<td><?php echo $cityPlace['city_name']; ?></td>
			<td><?php echo $cityPlace['place_name']; ?></td>
			<td><?php echo $cityPlace['quote']; ?></td>
			<td><?php echo $cityPlace['short_description']; ?></td>
			<td><?php echo $cityPlace['long_description']; ?></td>
			<td><?php echo $cityPlace['image_path']; ?></td>
			<td><?php echo $cityPlace['lat']; ?></td>
			<td><?php echo $cityPlace['lng']; ?></td>
			<td><?php echo $cityPlace['is_featured']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'city_places', 'action' => 'view', $cityPlace['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'city_places', 'action' => 'edit', $cityPlace['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'city_places', 'action' => 'delete', $cityPlace['id']), array('confirm' => __('Are you sure you want to delete # %s?', $cityPlace['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New City Place'), array('controller' => 'city_places', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

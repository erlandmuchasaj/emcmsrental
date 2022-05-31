<div class="cityPlaces view">
<h2><?php echo __('City Place'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cityPlace['CityPlace']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo $this->Html->link($cityPlace['City']['name'], array('controller' => 'cities', 'action' => 'view', $cityPlace['City']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City Name'); ?></dt>
		<dd>
			<?php echo h($cityPlace['CityPlace']['city_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Place Name'); ?></dt>
		<dd>
			<?php echo h($cityPlace['CityPlace']['place_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quote'); ?></dt>
		<dd>
			<?php echo h($cityPlace['CityPlace']['quote']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Description'); ?></dt>
		<dd>
			<?php echo h($cityPlace['CityPlace']['short_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Long Description'); ?></dt>
		<dd>
			<?php echo h($cityPlace['CityPlace']['long_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image Path'); ?></dt>
		<dd>
			<?php echo h($cityPlace['CityPlace']['image_path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<dd>
			<?php echo h($cityPlace['CityPlace']['lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lng'); ?></dt>
		<dd>
			<?php echo h($cityPlace['CityPlace']['lng']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Featured'); ?></dt>
		<dd>
			<?php echo h($cityPlace['CityPlace']['is_featured']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit City Place'), array('action' => 'edit', $cityPlace['CityPlace']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete City Place'), array('action' => 'delete', $cityPlace['CityPlace']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $cityPlace['CityPlace']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List City Places'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New City Place'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cities'), array('controller' => 'cities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New City'), array('controller' => 'cities', 'action' => 'add')); ?> </li>
	</ul>
</div>

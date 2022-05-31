<div class="reviews view">
<h2><?php echo __('Review'); ?></h2>
	<dl>
	<dt><?php echo __('Id'); ?></dt>
	<dd>
		<?php echo h($review['Review']['id']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('User By'); ?></dt>
	<dd>
		<?php echo $this->Html->link($review['UserBy']['name'], array('controller' => 'users', 'action' => 'view', $review['UserBy']['id'])); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('User To'); ?></dt>
	<dd>
		<?php echo $this->Html->link($review['UserTo']['name'], array('controller' => 'users', 'action' => 'view', $review['UserTo']['id'])); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Reservation'); ?></dt>
	<dd>
		<?php echo $this->Html->link($review['Reservation']['property_id'], array('controller' => 'reservations', 'action' => 'view', $review['Reservation']['id'])); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Property'); ?></dt>
	<dd>
		<?php echo $this->Html->link($review['Property']['address'], array('controller' => 'properties', 'action' => 'view', $review['Property']['id'])); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Title'); ?></dt>
	<dd>
		<?php echo h($review['Review']['title']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Review'); ?></dt>
	<dd>
		<?php echo h($review['Review']['review']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Cleanliness'); ?></dt>
	<dd>
		<?php echo h($review['Review']['cleanliness']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Communication'); ?></dt>
	<dd>
		<?php echo h($review['Review']['communication']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('House Rules'); ?></dt>
	<dd>
		<?php echo h($review['Review']['house_rules']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Accurancy'); ?></dt>
	<dd>
		<?php echo h($review['Review']['accurancy']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Checkin'); ?></dt>
	<dd>
		<?php echo h($review['Review']['checkin']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Location'); ?></dt>
	<dd>
		<?php echo h($review['Review']['location']); ?>
		&nbsp;
	</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($review['Review']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Publish Date'); ?></dt>
		<dd>
			<?php echo h($review['Review']['publish_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Dummy'); ?></dt>
		<dd>
			<?php echo h($review['Review']['is_dummy']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dummy User'); ?></dt>
		<dd>
			<?php echo h($review['Review']['dummy_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($review['Review']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($review['Review']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($review['Review']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>


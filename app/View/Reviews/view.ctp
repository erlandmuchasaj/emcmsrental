<?php
	/*This css is applied only to this page*/		 
	echo $this->Html->css('users', null, array('block'=>'cssMiddle'));

?>
<div class="em-container make-top-spacing">
	<div class="row" id="elementToMask">
		<div class="col-lg-3 col-md-4 user-sidebar">
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8">
			<div class="panel panel-warning">
				<header class="panel-heading"><h3><?php echo __('Review details');?></h3></header>
				<div class="panel-body">
					<div class="table-responsive event-table">
					<dl>
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
						<dt><?php echo __('Reservation Code'); ?></dt>
						<dd>
							<?php echo $this->Html->link($review['Reservation']['confirmation_code'], array('controller' => 'reservations', 'action' => 'view', $review['Reservation']['id'])); ?>
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
					</dl>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

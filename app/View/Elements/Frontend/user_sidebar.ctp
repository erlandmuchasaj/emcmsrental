<?php if (AuthComponent::user()): ?>
<div class="user-box">
	<div class="_pm_container">
		<?php
			echo $this->Html->link($this->Html->displayUserAvatar(AuthComponent::user('image_path')),array('controller' => 'users', 'action' => 'view', AuthComponent::user('id')), array('escape' => false, 'class'=>'user-box-avatar')); 

			echo $this->Html->link($this->Html->tag('i', '',array('class' => 'fa fa-pencil-square-o', 'aria-hidden'=>'true')).'&nbsp;'.__('Edit'),array('controller' => 'users', 'action' => 'edit', AuthComponent::user('id')),array('escape' => false, 'class'=>'user-box-edit'));     
		?>
	</div>
	<?php echo $this->Html->tag('h2', h(AuthComponent::user('name').' '.AuthComponent::user('surname')),array('class' => 'user-box-name')) ?>
</div>
<?php endif ?>

<div class="quick-links">
	<h3 class="quick-links-header"><?php echo __('Quick Links'); ?></h3>
	<ul class="quick-links-list">
		<li>
			<a href="<?php echo $this->Html->url(['controller' => 'properties', 'action' => 'listings'], true ); ?>">
				<?php echo __('View/Manage Listing'); ?>
			</a>
		</li>
		<li>
			<a href="<?php echo $this->Html->url(['controller' => 'reservations', 'action' => 'my_reservations'], true ); ?>">
				<?php echo __('My Reservations'); ?>
			</a>
		</li>

		<li>
			<a href="<?php echo $this->Html->url(['controller' => 'reservations', 'action' => 'my_trips'], true ); ?>">
				<?php echo __('My Trips'); ?>
			</a>
		</li>

		<li>
			<a href="<?php echo $this->Html->url(['controller' => 'wishlists', 'action' => 'index'], true ); ?>">
				<?php echo __('My Wishlist'); ?>
			</a>
		</li>

		<li>
			<a href="<?php echo $this->Html->url(['controller' => 'reviews', 'action' => 'index'], true ); ?>">
				<?php echo __('Reviews'); ?>
			</a>
		</li>
	</ul>
</div>
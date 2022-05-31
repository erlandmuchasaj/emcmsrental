<?php
	echo $this->Html->css('common/jasny-bootstrap', null, array('block'=>'cssMiddle'));
	$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS.'small'.DS;
?>        

<?php //debug($user);?>

<article class="panel panel-info">
	<header class="panel-heading tab-bg-dark-navy-blue">
		<h4><?php echo __('User Information'); ?></h4>
	</header>
	<div class="panel-body profile-information">
		<div class="col-md-3">
			<div class="profile-pic text-center">
				<?php 
					if (file_exists($directory.$user['User']['image_path']) && is_file($directory.$user['User']['image_path'])) { 
						echo $this->Html->image('uploads/User/small/'.$user['User']['image_path'], array('alt' => 'avatar','class'=>'img-responsive')); 
					} else {
						echo $this->Html->image('placeholder.png', array('alt' => 'image_path', 'class'=>'')); 
					}
				?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="profile-desk">
				<h2><?php echo h($user['User']['name']) .' &nbsp;'. h($user['User']['surname']); ?></h2>
				<h4><?php echo h($user['User']['email'])?></h4>
				<?php  $is_client = $user['User']['role'] === 'admin' ? __('Administrator') : __('Customer'); ?>
				<span class="text-muted"><?php echo $is_client; ?></span>
				<p><?php echo h($user['UserProfile']['about']); ?></p>
			</div>
		</div>
		<div class="col-md-3">
			<div class="profile-statistics">
				<h3><?php echo __('Joined since'); ?></h3>
				<p><?php echo $this->Time->niceShort(h($user['User']['created']));?></p>
			</div>
		</div>
	</div>
</article>

<article class="panel panel-info">
	<header class="panel-heading tab-bg-dark-navy-blue">
		<h4><?php echo __('Profile Information'); ?></h4>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<div class="row prf-contacts">
					<div class="col-md-3 col-sm-6" >
						<h3><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;<?php echo __('Location.'); ?></h3>
						<div class="location-info">
							<p><?php echo __('Address');?>:&nbsp;<?php echo h($user['UserProfile']['address']); ?></p>
							<p><?php echo __('Country');?>:&nbsp;<?php echo h($user['UserProfile']['country']); ?></p>
							<p><?php echo __('City');?>:&nbsp;<?php echo h($user['UserProfile']['city']); ?></p>
							<p><?php echo __('Zip');?>:&nbsp;<?php echo h($user['UserProfile']['zip']); ?></p>
						</div>
					</div>
					<div class="col-md-3 col-sm-6" >
						<h3><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;<?php echo __('Contacts'); ?></h3>
						<div class="location-info">
							<p><?php echo __('Phone Number');?>:&nbsp;<?php echo h($user['UserProfile']['phone']); ?></p>
							<p><?php echo __('Email');?>:&nbsp;<?php echo h($user['User']['email']); ?></p>
							<p><?php echo __('Url');?>:&nbsp;<?php echo h($user['UserProfile']['url']); ?></p>
						</div>
					</div>
					<div class="col-md-3 col-sm-6" >
						<h3><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?php echo __('Credit Cart Data.'); ?></h3>
						<div class="location-info">
							<p><?php echo __('Credit Card Type');?>:&nbsp;<?php echo h($user['UserProfile']['credit_card_type']); ?></p>
							<p><?php echo __('Credit Card Number');?>:&nbsp;<?php echo h($user['UserProfile']['credit_card_number']); ?></p>
							<p><?php echo __('Card Holder'); ?>:&nbsp;<?php echo h($user['UserProfile']['card_holder']); ?></p>
							<p><?php echo __('Credit Card Security Code');?>:&nbsp;<?php echo h($user['UserProfile']['credit_card_security_code']); ?></p>
							<p><?php echo __('Credit Card Expire');?>:&nbsp;<?php echo h($user['UserProfile']['credit_card_expire']); ?></p>
						</div>
					</div>
					<div class="col-md-3 col-sm-6" >
						<h3><i class="fa fa-facebook" aria-hidden="true"></i>&nbsp;<?php echo __('Socials Information.'); ?></h3>
						<div class="location-info">
							<p><?php echo __('linkedin');?>:&nbsp;<?php echo h($user['UserProfile']['linkedin']);?></p>
							<p><?php echo __('twitter');?>:&nbsp;<?php echo h($user['UserProfile']['twitter']);?></p>
							<p><?php echo __('facebook');?>:&nbsp;<?php echo h($user['UserProfile']['facebook']);?></p>
							<p><?php echo __('googleplus');?>:&nbsp;<?php echo h($user['UserProfile']['googleplus']);?></p>
							<p><?php echo __('pinterest');?>:&nbsp;<?php echo h($user['UserProfile']['pinterest']);?></p>
							<p><?php echo __('instagram');?>:&nbsp;<?php echo h($user['UserProfile']['instagram']);?></p>
							<p><?php echo __('vimeo');?>:&nbsp;<?php echo h($user['UserProfile']['vimeo']);?></p>
							<p><?php echo __('youtube');?>:&nbsp;<?php echo h($user['UserProfile']['youtube']);?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<?php echo $this->Html->link(__('Go Back'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
		</div>
	</div>
</div>

<?php
	// echo $this->Html->script('', array('block'=>'scriptBottomMiddle')); 
	// echo $this->Html->scriptBlock("", array('block' => 'scriptBottom'));  
?> 


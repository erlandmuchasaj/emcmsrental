	<div class="main-content" style="position: absolute; width: 50%; top: 30%; left: 25%;" >
		<div class="page-error-404" style="color: #fff;">
			<div class="error-symbol">
				<i class="fa fa-thumbs-up" aria-hidden="true" style="color: #fff;"></i>
			</div>
			<div class="error-text">
				<h2 style="color: #fcfcfc; font-weight: bold;"><?php echo __('Thank You!'); ?></h2><?php echo __('You have been registered.'); ?>
				<p style="color: #fff;">
					<?php 
						if (isset($general['Setting']) && (int)$general['Setting']['require_email_activation'] == 1){
							echo __('We have been sent an e-mail to the address you specified before.');
							echo '<br />';
							echo __(' Please check your e-mails to activate your account.');
							
						} 
						echo $this->Html->link(__('Sign in'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'login'), array('style'=>'color: #6078FF; font-weight: bold;')); 
					?>
				</p>
			</div>
		</div>
	</div>
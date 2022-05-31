<div class="login-box">
	<div class="login-logo">
		<?php 
			$span = $this->Html->tag('span', __('BackTo <b>%s</b>', h(Configure::read('Website.name'))));
			echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-arrow-circle-left')).'&nbsp;'.$span, array('admin'=>false,'controller' => 'properties', 'action' => 'index'), array('escape' => false));
		?>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg"><?php echo __('Sign in to start your session.'); ?></p>
		<?php echo $this->Form->create('User', array('url' => array('controller' => 'users','action' => 'login'))); ?> 
			<div class="form-group has-feedback">
				<?php
					// username3 login
					//echo $this->Form->input('username',array('placeholder'=>'Username', 'class'=>'form-control','label'=>false,'div'=>false));
					// If we want user to be logged in viea E-mail
					echo $this->Form->input('email', array('type'=>'email','class'=>'form-control', 'label'=>false, 'div'=>false, 'placeholder'=>__('Email')));
				?>
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>

			<div class="form-group has-feedback">
				<?php 
				echo $this->Form->input('password', array('type'=>'password','placeholder'=>__('Password'), 'class'=>'form-control','label'=>false,'div'=>false)); 
				?>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>

			<div class="row has-feedback">
				<div class="col-xs-8">
					<?php echo $this->Form->input('remember_me', array('type'=>'checkbox','div' => false, 'label' => __('Remember Me'))); ?>
				</div>
				<div class="col-xs-4">
					<?php 
						echo $this->Form->input(__('Sign In'), array('type'=>'submit','class'=>'btn btn-primary btn-block btn-flat','label'=>false,'div'=>false));
					?>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>
		
		<?php if (Configure::read('Hybridauth.enabled')): ?>
		<div class="social-auth-links text-center">
		<p>-<?php echo __('OR'); ?>-</p>
		<?php 
			foreach (Configure::read('Hybridauth.providers') as $provider => $value) {
				if ($value['enabled'] == true) {
					echo $this->Html->link(
						$this->Html->tag('i', '', array('class' => "fa fa-".EMCMS_strtolower($provider))) . __('Sign in using %s', $provider),
						array(
							'admin' => false,
							'user' => false,
							'controller' => 'users',
							'action' => 'social_login', $provider
						),
						array(
							'escape' => false,
							'class' => "btn btn-block btn-social btn-".EMCMS_strtolower($provider)." btn-flat"
						)
					); 
				}
			}

			// if (Configure::read('Hybridauth.providers.Google.enabled')) {
			// 	echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-google-plus')).__('Sign in using Google+'),array('admin'=>false, 'user'=>false, 'controller' => 'users', 'action' => 'social_login', 'Google'),array('escape' => false, 'class'=>'btn btn-block btn-social btn-google btn-flat')); 
			// }

			// if (Configure::read('Hybridauth.providers.Twitter.enabled')) {
			// 	echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-twitter')).__('Sign In with Twitter'),array('admin'=>false, 'user'=>false, 'controller' => 'users', 'action' => 'social_login', 'Twitter'),array('escape' => false, 'class'=>'btn btn-block btn-social btn-twitter btn-flat'));
			// }

			// if (Configure::read('Hybridauth.providers.Facebook.enabled')) {
			// 	echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-facebook')).__('Sign in using Facebook'),array('admin'=>false, 'user'=>false, 'controller' => 'users', 'action' => 'social_login', 'Facebook'),array('escape' => false, 'class'=>'btn btn-block btn-social btn-facebook btn-flat'));
			// } 
		?>
		</div>
		<?php endif ?>

		<!-- /.social-auth-links -->
		<p>
		<?php echo __('Don\'t have an account?'); ?>
		<?php echo $this->Html->link(__(' Sign Up '), array('admin'=>false,'controller' => 'users', 'action' => 'signup'),array('escape'=>true,'class'=>'text-green')); ?>
		</p>
		<p>
			<?php  echo __('Forgot Password?'); ?>
			<a data-toggle="modal" class="text-green" href="#forgotPasswordModal"><?php  echo __('Reset Password.'); ?></a>
			<br>
			<?php echo __('You are not activated?'); ?>
			<a data-toggle="modal" href="#requestActivationLinkModal"><?php echo __('Get a Link'); ?></a>
		</p>		
	</div>
	<!-- /.login-box-body -->
</div>

<!-- Modal Reset Password-->
	<div class="modal fade" aria-hidden="true" aria-labelledby="forgotPasswordModal" role="dialog" tabindex="-1" id="forgotPasswordModal" >
		<div class="modal-dialog">
			<div class="modal-content">
			<?php echo $this->Form->create('User', array('url'  => array('controller' => 'users','action' => 'requestResetPassword'))); ?> 
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?php echo __('Forgot Password ?'); ?></h4>
				</div>
				<div class="modal-body">
					<?php echo $this->Html->tag('p',  __('Enter your e-mail address below to reset your password.'));?>
					<?php echo $this->Form->input('email',array('id'=>false,'placeholder'=>__('Email'),'label'=>false,'autocomplete'=>'off','class'=>'form-control placeholder-no-fix'));?>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button"><?php echo __('Cancel'); ?></button>
					<?php echo $this->Form->input(__('Submit'),array('id'=>false,'type'=>'button','label'=>false,'div'=>false,'class'=>'btn btn-succes')); ?> 
				</div>
			<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
<!-- modal -->

<!-- Modal Recive Activation Link-->
	<div aria-hidden="true" aria-labelledby="requestActivationLinkModal" role="dialog" tabindex="-1" id="requestActivationLinkModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
			<?php echo $this->Form->create('User', array('url'  => array('controller' => 'users','action' => 'requestActivationLink'))); ?> 
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?php echo __(' Request Activation Link?'); ?></h4>
				</div>
				<div class="modal-body">
					<?php echo $this->Html->tag('p',  __('Enter your e-mail address below to recive an activation link.'));?>
					<?php echo $this->Form->input('email',array('id'=>false,'placeholder'=>__('Email'),'label'=>false,'autocomplete'=>'off','class'=>'form-control placeholder-no-fix'));?>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button"><?php echo __('Cancel'); ?></button>
					<?php echo $this->Form->input(__('Submit'),array('id'=>false,'type'=>'button','label'=>false,'div'=>false,'class'=>'btn btn-succes')); ?>
				</div>
			<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
<!-- modal -->
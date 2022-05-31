<div class="register-box">
	<div class="register-logo">
		<?php
			$span = $this->Html->tag('span', __('BackTo <b>%s</b>', h(Configure::read('Website.name'))));
			echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-arrow-circle-left')).'&nbsp;'.$span, array('admin'=>false,'controller' => 'properties', 'action' => 'index'), array('escape' => false));  
		?>
	</div>
	<!-- /.login-logo -->
	<div class="register-box-body">
		<p class="login-box-msg"><?php echo __('Register a new membership'); ?></p>
		<div class="row">
			<div class="col-md-12">
				<?php if (!empty($errors)){ ?>
					<div class="alert alert-error">
						<?php foreach($errors as $error){  ?>
							<div>
								<strong><?php echo __('Error!'); ?></strong>
								<?php echo h(implode('<br />', $error)); ?>
							</div>
						<?php } ?>
					</div>   
				<?php } ?>
			</div>
		</div>
		<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'signup'))); ?> 

			<div class="form-group has-feedback">
				<?php
					echo $this->Form->input('name',array('class'=>'form-control', 'label'=>false, 'div'=>false, 'placeholder'=>__('Name')));
				?>
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>

			<div class="form-group has-feedback">
				<?php
					echo $this->Form->input('surname',array('class'=>'form-control', 'label'=>false, 'div'=>false, 'placeholder'=>__('Surname')));
				?>
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>

			<div class="form-group has-feedback">
				<?php
					echo $this->Form->input('username',array('class'=>'form-control', 'label'=>false, 'div'=>false, 'placeholder'=>__('Username')));
				?>
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>

			<div class="form-group has-feedback">
				<?php
					echo $this->Form->input('email',array('type'=>'email','class'=>'form-control', 'label'=>false, 'div'=>false, 'placeholder'=>__('Email')));
				?>
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>

			<div class="form-group has-feedback">
				<?php 
				echo $this->Form->input('password',array('type'=>'password','placeholder'=>__('Password'), 'class'=>'form-control','label'=>false,'div'=>false)); 
				?>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>

			<div class="form-group has-feedback">
				<?php 
				echo $this->Form->input('confirm_password',array('type'=>'password','placeholder'=>__('Confirm password'), 'class'=>'form-control','label'=>false,'div'=>false)); 
				?>
				<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
			</div>

			<div class="form-group">
				<div class="col-xs-8">
					<?php echo $this->Form->input('terms_of_service',array('type'=>'checkbox','div' => false,'required'=>'required' ,'label' => '&nbsp;' . __('I agree to the terms'))); ?>
				</div>
				<div class="col-xs-4">
					<?php 
						echo $this->Form->input(__('Register'),array('type'=>'submit','class'=>'btn btn-primary btn-block btn-flat','label'=>false,'div'=>false));
					?>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>
		<?php if (false): ?>
		<div class="social-auth-links text-center">
			<?php 
				echo $this->Html->tag('p', __('- OR -'));

				echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-twitter')).__('Sign up using Twitter'),array('admin'=>false, 'user'=>false, 'controller' => 'users', 'action' => 'social_login', 'Twitter'),array('escape' => false, 'class'=>'btn btn-block btn-social btn-twitter btn-flat')); 

				echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-facebook')).__('Sign up using Facebook'),array('admin'=>false, 'user'=>false, 'controller' => 'users', 'action' => 'social_login', 'Facebook'),array('escape' => false, 'class'=>'btn btn-block btn-social btn-facebook btn-flat')); 

				echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-google-plus')).__('Sign up using Google+'),array('admin'=>false, 'user'=>false, 'controller' => 'users', 'action' => 'social_login', 'Google'),array('escape' => false, 'class'=>'btn btn-block btn-social btn-google btn-flat')); 
			?>
		</div>
		<?php endif; ?>
		<!-- /.social-auth-links -->
		<?php echo $this->Html->link(__('I already have a membership'), array('admin'=>false,'controller' => 'users', 'action' => 'login'),array('escape'=>true,'class'=>'text-green')); ?>
	</div>
</div>
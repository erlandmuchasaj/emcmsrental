<?php echo $this->Html->css('users', null, array('block'=>'cssMiddle'));?>
<div class="em-container make-top-spacing">
	<div class="row">
		<div class="col-md-12"> 
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo __('Reset Password!'); ?></div>
				<div class="panel-body">
					<?php echo $this->Form->create('User', array('url'  => array('controller' => 'users','action' => 'requestResetPassword'))); ?>

					<?php echo $this->Form->input('email',array('placeholder'=>__('Email'), 'label'=>__('Enter Your E-mail Address'), 'class' => 'form-control'));?>
					
					<?php echo $this->Form->end(__('Reset')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
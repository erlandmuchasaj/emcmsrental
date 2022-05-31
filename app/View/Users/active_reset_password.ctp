<div class="em-container make-top-spacing">
	<div class="row">
		<div class="col-md-12"> 
			<?php if (count($errors) > 0) { ?>
				<div class="alert alert-danger alert-dismissible fade in" role="alert" style="z-index: 9999;">
					<button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
					<?php foreach($errors as $error){?>
						<?php foreach($error as $er){ ?>
							<?php echo __('<strong>Error!</strong>'); ?>
							<?php echo h($er); ?>
							<br />
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
			<div class="panel panel-em no-border">
				<div class="panel-heading"><?php echo __('Recover password'); ?></div>
				<div class="panel-body">
					<?php echo $this->Form->create('User', array('url'  => array('controller' => 'users','action' => 'activeResetPassword', h($code)), 'class'=> '')); ?>
						<?php echo $this->Form->input('reset_password',array('type'=>'hidden', 'value'=> h($code))); ?>
						
						<div class="form-group">
							<?php echo $this->Form->input('password',array('type'=>'password', 'placeholder'=>__('Choose password'), 'class' => 'form-control')); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('confirm_password',array('type'=>'password','placeholder'=>__('Confirm password'), 'class' => 'form-control')); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input(__('Submit'), array('type'=>'submit', 'class'=>'btn', 'label'=> false)); ?>
						</div>

					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
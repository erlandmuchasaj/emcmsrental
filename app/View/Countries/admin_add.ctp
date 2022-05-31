<div class="panel panel-em">
	<header class="panel-heading">
	   <?php  echo __('Add Country'); ?>
	</header>
	<div class="panel-body">
		<?php echo $this->Form->create('Country',array('class'=>'form-horizontal')); ?>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Country Name');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('name', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('iso code'); ?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('iso_code', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('phonecode'); ?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('phonecode', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('numcode'); ?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('numcode', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10">
				<?php echo $this->Form->submit(__('Save Country'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>

				<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
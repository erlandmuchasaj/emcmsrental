<div class="panel  panel-em">
	<header class="panel-heading"><?php echo __('Edit Host Cancellation Policy');?></header>
	<div class="panel-body">
		<?php echo $this->Form->create('HostCancellationPolicy',array('class'=>'form-horizontal'));?>
		<?php echo $this->Form->input('id'); ?>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Months Prior');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('months', array('type'=>'select','label'=>false, 'div'=>false,'class'=>'form-control', 'options'=>$months)); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Free Cancellation Limit');?><span style="color: red;">*</span></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('free_cancellation_limit', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Days');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('days', array('type'=>'select','label'=>false, 'div'=>false,'class'=>'form-control', 'options'=>$days)); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Before Days Amount');?><span style="color: red;">*</span></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('before_amount', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Within Days Amount');?><span style="color: red;">*</span></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('after_amount', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Currency');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('currency', array('type'=>'select','label'=>false, 'div'=>false,'class'=>'form-control', 'options'=>$currencies)); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10">
				<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>

				<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>

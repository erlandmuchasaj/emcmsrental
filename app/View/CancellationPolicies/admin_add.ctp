<div class="panel panel-em">
	<header class="panel-heading"><?php echo __('Add Cancellation Policy');?></header>
	<div class="panel-body">
		<?php echo $this->Form->create('CancellationPolicy',array('class'=>'form-horizontal'));?>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Cancellation Policy Name'); ?><span style="color: red;">*</span></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('name', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'160')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Cancellation Policy Title'); ?><span style="color: red;">*</span></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('cancellation_title', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'160')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Cancellation Policy Content'); ?><span style="color: red;">*</span></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('cancellation_content', array('type'=>'textarea','label'=>false, 'div'=>false,'class'=>'form-control froala')); ?>
				<span class="help-block"><?php echo __('Write a short description to explain the policy');?></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Cleaning Fee');?></label>
			<div class="col-sm-6 ">
				<span class="help-block"><?php echo __('After Checkin Is Refundable');?></span>
				<?php echo $this->Form->input('security_status', array('type'=>'checkbox','label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>

			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Security Fee');?></label>
			<div class="col-sm-6 ">
				<span class="help-block"><?php echo __('After Checkin Is Refundable');?></span>
				<?php echo $this->Form->input('cleaning_status', array('type'=>'checkbox','label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>

			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Additional Guest Fee');?></label>
			<div class="col-sm-6 ">
				<span class="help-block"><?php echo __('After Checkin Is Refundable');?></span>
				<?php echo $this->Form->input('additional_status', array('type'=>'checkbox','label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-push-6 control-label"><?php echo __('Property Fee');?></label>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Days Prior');?></label>
			<div class="col-sm-6 ">
				<span class="help-block"><?php echo __('Is Refundable');?></span>
				<?php echo $this->Form->input('property_days_prior_status', array('type'=>'checkbox','label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch', 'data-class' => "list_before_days_prior")); ?>

			</div>
		</div>

		<div class="form-group list_before_days_prior" style="display: none;">
			<label class="col-sm-3 control-label"><?php echo __('Days');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('property_days_prior_days', array('type'=>'select','label'=>false, 'div'=>false,'class'=>'form-control', 'options'=>$days)); ?>
			</div>
		</div>

		<div class="form-group list_before_days_prior" style="display: none;">
			<label class="col-sm-3 control-label"><?php echo __('Percentage');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('property_days_prior_percentage', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Before Checkin');?></label>
			<div class="col-sm-6 ">
				<span class="help-block"><?php echo __('Is Refundable');?></span>
				<?php echo $this->Form->input('property_before_status', array('type'=>'checkbox','label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch', 'data-class' => "property_before_checkin_days")); ?>

			</div>
		</div>

		<div class="form-group property_before_checkin_days" style="display: none;">
			<label class="col-sm-3 control-label"><?php echo __('Days');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('property_before_days', array('type'=>'select','label'=>false, 'div'=>false,'class'=>'form-control', 'options'=>$days)); ?>
			</div>
		</div>

		<div class="form-group property_before_checkin_days" style="display: none;">
			<label class="col-sm-3 control-label"><?php echo __('Percentage');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('property_before_percentage', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('After Checkin');?></label>
			<div class="col-sm-6 ">
				<span class="help-block"><?php echo __('Is Refundable');?></span>
				<?php echo $this->Form->input('property_after_status', array('type'=>'checkbox','label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch', 'data-class' => "property_after_checkin_days")); ?>

			</div>
		</div>

		<div class="form-group property_after_checkin_days" style="display: none;">
			<label class="col-sm-3 control-label"><?php echo __('Days');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('property_after_days', array('type'=>'select','label'=>false, 'div'=>false,'class'=>'form-control', 'options'=>$days)); ?>
			</div>
		</div>

		<div class="form-group property_after_checkin_days" style="display: none;">
			<label class="col-sm-3 control-label"><?php echo __('Percentage');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('property_after_percentage', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Is displaying as standard?');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('is_standard', array('type'=>'checkbox','label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10">
				<?php echo $this->Form->submit(__('Save Policy'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>

				<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<?php
$this->Froala->editor('.froala', array('block'=>'scriptBottom'));
$this->Html->scriptBlock("
	(function($){
		$(document).ready(function() {
			$('.bootstrap-switch').on('switchChange.bootstrapSwitch', function(event, state) {
				// console.log(this.getAttribute('data-class')); // DOM element
				// console.log(event); // jQuery event
				// console.log(state); // true | false

				var element = this.getAttribute('data-class');
				if (state){
					$('.'+element).slideDown();
				} else {
					$('.'+element).slideUp();
				}
			});
		});
	})(jQuery);
", array('block' => 'scriptBottom'));
?>
<?php 
	$options = [
		'travel' => __('Travel'),
		'business' => __('Business'),
		'premote' => __('Premote'),
		'advert' => __('Advert'),
		'birthday_card' => __('Birthday Card')
	];
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-em">
            <header class="panel-heading">
               <?php  echo __('Add Coupon'); ?>
            </header>
            <div class="panel-body">
			<?php echo $this->Form->create('Coupon',array('class'=>'form-horizontal')); ?>				
			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo __('Coupon name');?></label>
				<div class="col-md-6">
					<?php echo $this->Form->input('name', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-minlength'=>'0', 'data-maxlength'=>'50', 'autocomplete'=>"off")); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo __('Coupon code');?></label>
				<div class="col-md-6">
					<div class="input-group">
						<?php 
							echo $this->Form->input('code', array('id'=>'em_code_generator', 'class'=>'form-control', 'div'=>false,'label'=>false, 'autocomplete'=>"off"));  
						?>
						<span class="input-group-addon">
							<a href="javascript:;" class="generate-coupon"><?php echo __('Generate');?></a>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label">
					<?php echo __('Price Type'); ?>
				</label>
				<div class="col-lg-6 col-md-6">
					<?php 
						echo $this->Form->input('price_type',array('class'=>'form-control', 'options'=> array('1'=>__('Percentage'),'2'=>__('Fixed')), 'empty'=>__('Select price type'), 'div'=>false, 'label'=>false)); 
					?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo __('Price value');?></label>
				<div class="col-md-6">
					<?php echo $this->Form->input('price_value', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label">
					<?php echo __('Coupon Type'); ?>
				</label>
				<div class="col-lg-6 col-md-6">
					<?php 
						echo $this->Form->input('coupon_type', array('class'=>'form-control', 'options'=>$options, 'empty'=>__('Select coupon type'), 'div'=>false, 'label'=>false)); 
					?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo __('Quantity');?></label>
				<div class="col-md-6">
					<?php echo $this->Form->input('quantity', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo __('From');?></label>
				<div class="col-md-6">
					<?php echo $this->Form->input('date_from', array('label'=>false, 'empty'=>__('Select'), 'div'=>false,'class'=>'form-control')); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo __('To');?></label>
				<div class="col-md-6">
					<?php echo $this->Form->input('date_to', array('label'=>false, 'empty'=>__('Select'), 'div'=>false,'class'=>'form-control')); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label">
					<?php echo __('Currency'); ?>
				</label>
				<div class="col-lg-6 col-md-6">
					<?php 
						echo $this->Form->input('currency',array('class'=>'form-control', 'options' => $currencies, 'empty'=>__('Select Currency'), 'div'=>false, 'label'=>false)); 
					?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo __('Status');?></label>
				<div class="col-md-6 ">
					<?php echo $this->Form->input('status', array('label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>
					<span class="help-block"><?php echo __('Coupon status.');?></span>
				</div>
			</div>

			<div class="form-group">
			    <div class="col-md-offset-2 col-md-6">
			        <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
			        <?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
			    </div>
			</div>   
			<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
	$this->Html->scriptBlock("
		(function($){
			$(document).ready(function() {
				'use strict';
				$('.generate-coupon').off('click').on('click', function(event){
					event.preventDefault();
					event.stopPropagation();
					gencode(12);
					return false;
				});
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>

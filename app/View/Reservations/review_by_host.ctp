<?php
/*This css is applied only to this page*/		 
echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
	$rates = array(
		1=>__('%d Star',1), 
		2=>__('%d Stars',2), 
		3=>__('%d Stars',3), 
		4=>__('%d Stars',4), 
		5=>__('%d Stars',5)
	);
?>
<!-- page start-->
<div class="em-container make-top-spacing">
	<div class="row" id="elementToMask">
		<div class="col-lg-3 col-md-4 user-sidebar">
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8">
			<section class="panel panel-warning">
				<header class="panel-heading">
					<?php echo __('Add Review'); ?>
				</header>
				<div class="panel-body">
					<?php echo $this->Form->create('Review',array('url' => array('controller' => 'reservations', 'action' => 'review_by_host', $reservation_id), 'class'=>'form-horizontal')); ?>

					<div class="form-group">
						<label class="col-lg-12"><?php echo __('Title');?></label>
						<div class="col-lg-12">
							<?php echo $this->Form->input('title', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-minlength'=>'0', 'data-maxlength'=>'160')); ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-12"><?php echo __('Review');?></label>
						<div class="col-lg-12">
							<?php echo $this->Form->input('review', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-minlength'=>'0', 'data-maxlength'=>'2500')); ?>
						</div>
					</div> 
					
					<div class="form-group">
						<label class="col-lg-12"><?php echo __('Cleanliness');?></label>
						<div class="col-lg-12">
							<?php echo $this->Form->input('cleanliness',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','options' =>$rates/*, 'empty'=>__('Select Your Rating')*/)); ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-12"><?php echo __('Communication');?></label>
						<div class="col-lg-12">
							<?php echo $this->Form->input('communication',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','options' =>$rates)); ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-12"><?php echo __('House rules');?></label>
						<div class="col-lg-12">
							<?php echo $this->Form->input('house_rules',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','options' =>$rates)); ?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-12">
							<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
						</div>
					</div>   
					<?php echo $this->Form->end(); ?>
				</div>
			</section>
		</div>
	</div>
</div>
<!-- page end-->
<?php
$this->Html->scriptBlock("
(function ($) {
	'use strict';
	$(document).ready(function () {
		$(function () {
			
		});
	});
})(jQuery);
", array('block' => 'scriptBottom'));
?>
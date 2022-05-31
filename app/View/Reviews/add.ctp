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
					<?php 
						echo $this->Form->create('Review',array('class'=>'form-horizontal')); 
						echo $this->Form->input('review_status', array('type'=>'hidden', 'value'=>'waiting_traveler_review'));
						echo $this->Form->input('is_dummy', array('type'=>'hidden', 'value'=>0));
					?>

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

					<!-- 
					<div class="form-group">
						<label class="col-lg-12"><?php //echo __('Hospitality');?></label>
						<div class="col-lg-12">
							<?php //echo $this->Form->input('house_rules',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','options' =>$rates)); ?>
						</div>
					</div>
					 -->

					<div class="form-group">
						<label class="col-lg-12"><?php echo __('Quality Overnight');?></label>
						<div class="col-lg-12">
							<?php echo $this->Form->input('accurancy',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','options' =>$rates)); ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-12"><?php echo __('Recommendation');?></label>
						<div class="col-lg-12">
							<?php echo $this->Form->input('checkin',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','options' =>$rates)); ?>
						</div>
					</div>
					
					<?php if(false){ ?>
					<div class="form-group">
						<label class="col-lg-12"><?php echo __('Location');?></label>
						<div class="col-lg-12">
							<?php echo $this->Form->input('location',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','options' =>$rates)); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-12"><?php echo __('Value');?></label>
						<div class="col-lg-12">
							<?php echo $this->Form->input('value',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','options' =>$rates)); ?>
						</div>
					</div>
					<?php } ?>

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

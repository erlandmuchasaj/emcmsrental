<!-- page start-->
<article class="panel panel-em">
	<header class="panel-heading">
		<?php  echo __('Add Contact'); ?>
	</header>
	<div class="panel-body">
		<?php echo $this->Form->create('Contact',array('class'=>'form-horizontal')); ?>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Email');?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('email',array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'100')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Subject');?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('subject', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'70')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Message');?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('message', array('type'=>'textarea', 'label'=>false, 'div'=>false, 'class'=>'form-control count-char', 'data-maxlength'=>'500')); ?>   
				<span class="help-block"><?php echo __('Here you can write a long message regarding the contact');?></span>
			</div>
		</div>     

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Status');?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('is_read', array('label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>
				<span class="help-block"><?php echo __('Set yes if you want the mark this contact as read.');?></span>
			</div>
		</div>                    	                     	                    					            
		<div class="form-group">
			<div class="col-md-offset-3 col-md-6">
				<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
				<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
			</div>
		</div> 
		<?php echo $this->Form->end(); ?>
	</div>
</article>

<?php // echo $this->Html->css('bootstrap-switch', null, array('block'=>'cssMiddle')); ?>
<!-- page start-->
<div class="panel panel-em">
	<header class="panel-heading">
	   <?php  echo __('Edit Category'); ?>
	</header>
	<div class="panel-body">
		<?php
			echo $this->Form->create('Category',array('class'=>'form-horizontal'));
			echo $this->Form->input('id');
			echo $this->Form->input('model', ['type' => 'hidden']);
		?>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Category Name'); ?><span style="color: red;">*</span></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('name', array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Category Name'), 'data-maxlength'=>'160')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Status');?></label>
			<div class="col-sm-6 ">
				<?php echo $this->Form->input('status', array('type'=>'checkbox','label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>
				<span class="help-block"><?php echo __('Check if you want the category to be accesable');?></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Category Description'); ?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('description', array('type'=>'textarea','label'=>false, 'div'=>false,'class'=>'form-control froala')); ?>
				<span class="help-block"><?php echo __('Write a short description to explain the category');?></span>
			</div>
		</div>

		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10">
				<?php echo $this->Form->submit(__('Save Category'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
				<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<!-- page end-->
<?php $this->Froala->editor('.froala', array('block'=>'scriptBottom')); ?>

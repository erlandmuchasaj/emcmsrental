<div class="panel panel-em">
	<header class="panel-heading">
		<?php echo __('Add Catyegory'); ?>
	</header>
	<div class="panel-body">
		<?php echo $this->Form->create('Category',array('class'=>'form-horizontal')); ?>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Category Name'); ?><span style="color: red;">*</span></label>
				<div class="col-sm-6">
					<?php echo $this->Form->input('name', array('id'=>'category_name','label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Category Name'), 'data-maxlength'=>'160')); ?>
				</div>
			</div>

			<?php if (!isset($type) || empty($type)): ?>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo __('Category type'); ?><span style="color: red;">*</span></label>
					<div class="col-sm-6">
						<?php echo $this->Form->input('model', array(
							'id'=>'category_model',
							'label'=>false,
							'div'=>false,
							'class'=>'form-control',
							'empty'=>__('Select model'),
							'type' => 'select', 
							'options' => [
								'Article' => 'Article', 
								'Experience' => 'Experience',
								'Service' => 'Service',
							]
						)); ?>
					</div>
				</div>
			<?php else: ?>
				<?php echo $this->Form->input('model', ['type' => 'hidden', 'value' => $type]); ?>
			<?php endif ?>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Status');?></label>
				<div class="col-sm-6 ">
					<?php echo $this->Form->input('status', array('type'=>'checkbox', 'label'=>false, 'div'=>false, 'class'=>'bootstrap-switch')); ?>
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
					<?php echo $this->Html->link(__('Cancel'), array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
				</div>
			</div>

		<?php echo $this->Form->end(); ?>
	</div>
</div>
<?php $this->Froala->editor('.froala', array('block'=>'scriptBottom')); ?>
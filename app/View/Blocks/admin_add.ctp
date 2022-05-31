<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo __('Add a Content Block');?></h1>
	</div>
</div>
<div class="panel panel-em">
	<div class="panel-heading">
		<?php echo $this->Html->tag('h4', __('Block Details'), array('class'=>'')); ?>
	</div>
	<div class="panel-body">
		<?php echo $this->Form->create('Block',array('class'=>'form-horizontal'));?>
			<fieldset>
				<div class="form-group">
					<div class="col-sm-12">
						<?php echo $this->Form->input('name',array('label' => __('Name *'),'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<?php
							echo $this->Form->input('slug',
										array('label' => __('Slug / Key'),
										'class' => 'form-control',
										'after' => __('Used to call the content block in your front end code')));
						?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<?php
							echo $this->Form->input('content',array('type'=>'textarea', 'div' => false,'label'=>false,'class'=>'form-control froala'));
						?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<?php echo $this->Form->submit(__('Add Content Block'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
						<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
					</div>
				</div>
			</fieldset>
		<?php echo $this->Form->end();?>
	</div>
	<div class="panel-footer">
		<?php echo $this->Html->link(__('Back to content blocks'),array('action' => 'index'),array('class' => 'btn btn-default'));?>
	</div>
</div>

<?php
	$this->Froala->editor('.froala', array('block'=>'scriptBottom'));
	$this->Html->scriptBlock("
		(function($){
			$(document).ready(function() {
				'use strict';
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>
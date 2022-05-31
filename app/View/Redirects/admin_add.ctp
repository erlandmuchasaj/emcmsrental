<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo __('Add a Redirect'); ?></h1>
	</div>
</div>
<div class="panel panel-em">
	<div class="panel-heading">
		<?php echo __('Add Redirect');?>
	</div>
	<div class="panel-body">
		<?php echo $this->Form->create('Redirect', array('class'=>'form')); ?>
			<fieldset>
				<div class="form-group">
					<div class="col-lg-6">
						<?php
							echo $this->Form->input('urls', array('type' => 'textarea', 'div' => false, 'class' => 'form-control', 'label' => __('URLs'), 'after' => __('Enter in multiple URLs on seperate lines if wanting to add several redirects to the same URL')));
							if (!empty($this->Form->error('url'))) {
								echo $this->Form->error('url');
							}
						?>
					</div>
					<div class="col-lg-6">
						<?php
							echo $this->Form->input('redirect', array('div' => false, 'class' => 'form-control', 'label' => __('Redirect To')));
						?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-12">
						<?php echo $this->Form->submit(__('Add Redirect'), array('class' => 'btn btn-primary'));?>
					</div>
				</div>
			</fieldset>
		<?php echo $this->Form->end();?>
	</div>

	<div class="panel-footer">
		<?php echo $this->Html->link(__('Back to redirects'), array('action' => 'index'), array('class' => 'btn btn-default'));?>
	</div>
</div>
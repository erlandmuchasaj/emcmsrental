<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo __('Edit a Redirect'); ?></h1>
	</div>
</div>
<div class="panel panel-em">
	<div class="panel-heading">
		<?php echo __('Update Redirect');?>
	</div>
	<div class="panel-body">
		<?php
			echo $this->Form->create('Redirect', array('class'=>'form'));
			echo $this->Form->input('id');
		?>
			<fieldset>
				<div class="form-group">
					<div class="col-md-6">
						<?php
							echo $this->Form->input('url', array('div' => false, 'class' => 'form-control', 'label' => __('URL')));
						?>
					</div>
					<div class="col-md-6">
						<?php
							echo $this->Form->input('redirect', array('div' => false, 'class' => 'form-control', 'label' => __('Redirect To')));
						?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
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
<article class="panel panel-em">
	<header class="panel-heading">
		<h4><?php echo __('Edit Accommodation Type - %s', h($language['Language']['name'])); ?></h4>
	</header>
	<div class="panel-body">
		<?php 
			echo $this->Form->create('AccommodationType', array('class'=>'form-inline', 'role'=>'form'));
			echo $this->Form->input('id');
			echo $this->Form->input('language_id', ['type' => 'hidden']);
			echo $this->Form->input('accommodation_type_id', ['type' => 'hidden']);
		?>
			<div class="form-group">
				<label class="sr-only" for="accommodation_type_name"><?php echo __('Accommodation Name');?></label>
				<?php 
					echo $this->Form->input('accommodation_type_name', [
						'class' => 'form-control count-char', 
						'id' => 'accommodation_type_name',
						'label' => false,
						'div' => false,
						'placeholder' => __('Accommodation type name'),
						'data-minlength' => '0',
						'data-maxlength' => '90'
					]); 
				?>
			</div>

			<?php echo $this->Form->submit(__('Update'), array('class'=>'btn btn-success','label'=>false,'div'=>false)); ?>
			<?php echo $this->Html->link(__('Cancel'),array('action' => 'view', $this->Form->value('id')),array('escape' => false, 'class'=>'btn btn-danger')); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</article>

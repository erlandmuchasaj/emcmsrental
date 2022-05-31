<!-- page start-->
<article class="panel panel-em">
	<header class="panel-heading">
		<?php  echo __('View Contact'); ?>
	</header>
	<div class="panel-body">
		<div class="row">
			<label class="col-sm-3 control-label"><?php echo __('Email');?></label>
			<div class="col-sm-6"><?php echo h($contact['Contact']['email']); ?></div>
		</div>

		<div class="row">
			<label class="col-sm-3 control-label"><?php echo __('Subject');?></label>
			<div class="col-sm-6"><?php echo h($contact['Contact']['subject']); ?></div>
		</div>

		<div class="row">
			<label class="col-sm-3 control-label"><?php echo __('Message');?></label>
			<div class="col-sm-6"><?php echo h($contact['Contact']['message']); ?></div>
		</div>

		<div class="row">
			<label class="col-sm-3 control-label"><?php echo __('Created');?></label>
			<div class="col-sm-6"><?php echo h($contact['Contact']['created']); ?></div>
		</div>

		<div class="row">
			<label class="col-sm-3 control-label"><?php echo __('Modified');?></label>
			<div class="col-sm-6"><?php echo h($contact['Contact']['modified']); ?></div>
		</div>
	</div>
	<div class="panel-footer clearfix">
	<?php 

		echo $this->Html->link(
			__('Go Back'), 
			array('action' => 'index'),
			array('escape' => false, 'class'=>'btn btn-default btn-sm')
		) . '&nbsp;';

		echo $this->Html->link(
			__('Edit'), 
			array('action' => 'edit', $contact['Contact']['id']),
			array('escape' => false, 'class'=>'btn btn-success btn-sm')
		);

		echo "&nbsp;";

		echo $this->Form->postLink(
			__('Delete'), 
			[
				'action' => 'delete', 
				$contact['Contact']['id']
			], 
			[
				'confirm' => __('Are you sure you want to delete # %s?', $contact['Contact']['id']),
				'class'=>'btn btn-danger btn-sm',
			]
		);

		echo "&nbsp;";

		echo $this->Html->link(
			__('Add Contact'),
			array('action' => 'add'),
			array('escape' => false, 'class'=>'btn btn-info btn-sm')
		); 
	?>
	</div>
</article>


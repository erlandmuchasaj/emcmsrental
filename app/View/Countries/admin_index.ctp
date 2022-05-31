<div class="row">
	<div class="col-md-12">
		<div class="panel panel-em">
			<header class="panel-heading">
				<?php echo $this->Html->tag('h4',__('Countries'),array('class' => 'display-inline-block')) ?>
				<span class="tools pull-right">
					<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square fa-lg')). '&nbsp;' .__('New Country'),array('admin'=>true, 'controller' => 'countries', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm'));
					?>
				</span>
			</header>
			<div class="panel-body table-responsive">
				<table  class="table general-table">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('iso_code'); ?></th>
							<th><?php echo $this->Paginator->sort('numcode'); ?></th>
							<th><?php echo $this->Paginator->sort('phonecode'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($countries as $country): ?>
							<tr>
								<td><?php echo h($country['Country']['name']); ?>&nbsp;</td>
								<td><?php echo h($country['Country']['iso_code']); ?>&nbsp;</td>
								<td><?php echo h($country['Country']['numcode']); ?>&nbsp;</td>
								<td><?php echo h($country['Country']['phonecode']); ?>&nbsp;</td>
								<td class="actions">
									<?php // echo $this->Html->link(__('View'), array('action' => 'view', $country['Country']['id']),array('class'=>'btn btn-info btn-sm','escape'=>false)); ?>
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $country['Country']['id']), array('class'=>'btn btn-info btn-sm','escape'=>false)); ?>
									<?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $country['Country']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $country['Country']['id']))); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- pagination START -->
<div class="row">
	<div class="col-xs-12">
		<?php echo $this->element('Pagination/counter'); ?>
		<?php echo $this->element('Pagination/navigation'); ?>
	</div>
</div>

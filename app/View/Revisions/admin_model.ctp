<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo __('Revisions'); ?></h1>
	</div>
</div>
<?php 
 // debug($revisions);
?>
<div class="panel panel-em">
	<div class="panel-heading">
		<?php echo __('Revisions for %s', $model); ?>
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<?php if (isset($revisions) && !empty($revisions)) : ?>
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('created', __('Date')); ?></th>
							<th><?php echo $this->Paginator->sort('User.name', __('Modified By')); ?></th>
							<th><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($revisions as $revision): ?>
							<tr>
								<td><?php echo $this->Time->niceShort($revision['Revision']['created']); ?></td>
								<td><?php echo (!empty($revision['Revision']['user_id'])) ? $revision['User']['name'] : __('n/a'); ?></td>
								<td class="actions">
								<?php
									echo $this->Html->link(
										'<i class="fa fa-edit"></i>',
										array(
											'controller' => Inflector::pluralize(Inflector::underscore($revision['Revision']['model'])),
											'action' => 'edit',
											$revision['Revision']['model_id'],
											$revision['Revision']['revision']
										),
										array(
											'class' => 'btn btn-warning',
											'escape' => false,
											'alt' => __('Use Revision'),
											'title' => __('Use Revision')
										)
									);
									echo '&nbsp;';
									echo $this->Form->postLink(
										'<i class="fa fa-trash-o"></i>',
										 array(
										 	'action' => 'delete',
											$revision['Revision']['revision']
										),
										array(
											'class' => 'btn btn-danger',
											'escape' => false,
											'alt' => __('Delete'),
											'title' => __('Delete')
										),
										__('Are you sure you want to delete this revision?')
									);
								?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php echo $this->element('Pagination/counter'); ?>
				<?php echo $this->element('Pagination/navigation'); ?>
			</div>
		<?php else : ?>
			<?php echo __('There are no revisions at the moment!'); ?>
		<?php endif; ?>
	</div>
</div>
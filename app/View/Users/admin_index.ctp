<?php
	$current_model = Inflector::classify($this->params['controller']);
	$current_controller = $this->params['controller'];
	$current_action 	= $this->params['action'];
	$directorySm = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS.'small'.DS;
?>
<div class="box">
	<div class="box-header with-border">
		<?php echo $this->Html->tag('h3', __('Users'), array('class'=>'box-title'))?>
		<div class="box-tools pull-right">
			<?php
				//echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')).'&nbsp;'.__('New User'),array('admin'=>true, 'controller' => 'users', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm'));
			?>
		</div>
	</div>

	<div class="well">
		<?php $base_url = array('admin'=>true,'controller' => 'users', 'action' => 'index');?>
		<?php echo $this->Form->create('User', array('url'  => $base_url,'class' => 'form'));?>
			<fieldset class="form-group">
				<div class="input-group custom-search-form">
					<?php if (!empty($search)) : ?>
						<?php echo $this->Form->input('search', array('class' => 'form-control', 'label' => false, 'placeholder' => __('Search...'), 'div' => false, 'value' => $search));?>
					<?php else :
						echo $this->Form->input('search',
								array('type' => 'text',
									'class' => 'form-control',
									'placeholder' =>  __('Search...'),
									'label' => false,
									'div' => false
								)
							);
					endif; ?>
					<span class="input-group-btn">
						<?php
							echo $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>',
								array('class' => 'btn btn-default',
									'escape' => false,
									'type' => 'submit',
									'div' => false)
								);
						?>
					</span>
				</div>
			</fieldset>
			<?php if (!empty($search)) :
					echo $this->Html->link(__('Reset'), $base_url, array('class' => 'btn btn-sm btn-warnign','escape' => false));
				endif;
			echo $this->Form->end();
		?>
		<div class="btn-group">
			<?php
				echo $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Add a new user'),array('admin'=>true,'controller'=>'users','action'=>'add'), array('class'=>'btn bg-success btn-flat margin','escape' => false));

				echo $this->Html->link('Export CSV',array('admin'=>true,'controller'=>'users','action'=>'csv'), array('target'=>'_blank', 'class'=>'btn bg-olive btn-flat margin'));

				echo $this->Html->link('Export XLS',array('admin'=>true,'controller'=>'users','action'=>'xls'), array('target'=>'_blank','class'=>'btn bg-navy btn-flat margin'));
			?>
		</div>
	</div>

	<?php if (isset($users) && !empty($users)) : ?>
		<div class="box-body event-table" id="downdiv">
			<table class="table table-general">
				<thead id="editor">
					<tr>
						<th><?php echo $this->Paginator->sort('id', 'Avatar'); ?></th>
						<th><?php echo $this->Paginator->sort('name'); ?></th>
						<th><?php echo $this->Paginator->sort('email'); ?></th>
						<th class="hidden-xs hidden-sm"><?php echo $this->Paginator->sort('role'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $user): ?>
						<tr class="parent-element <?php echo ($user['User']['is_banned']) ? 'disabled' : ''; ?>" >
							<td data-th="<?php echo __('Avatar');?>" class="image">
								<div class="user-avatar">
									<?php
										if (file_exists($directorySm.$user['User']['image_path']) && is_file($directorySm .$user['User']['image_path'])) {
											echo $this->Html->image('uploads/User/small/'.$user['User']['image_path'], array('alt' => 'avatar', 'fullBase' => true));
										} else {
											echo $this->Html->image('avatars/avatar.jpg', array('alt' => 'avatar','fullBase' => true));
										}

										if ($user['User']['is_banned']==1) {
											echo '<span class="badge ban-badge label-danger">'.__('Banned').'&nbsp;<i class="fa fa-ban" aria-hidden="true"></i></span>';
										}
									?>
								</div>
							</td>
							<td data-th="<?php echo __('Name');?>"><?php echo h($user['User']['name']); ?>&nbsp;</td>
							<td data-th="<?php echo __('Email');?>"><?php echo h($user['User']['email']); ?>&nbsp;</td>
							<td class="hidden-xs hidden-sm"><?php echo h($user['User']['role']); ?>&nbsp;</td>
							<td class="actions">
								<?php
									//echo $this->Html->link(__('Edit').'&nbsp;'.$this->Html->tag('i', '', array('class' => 'fa fa-edit')), array('action' => 'edit', $user['User']['id']),array('escape' => false, 'class'=>'btn btn-success btn-sm'));
									//echo "&nbsp;";
									//echo $this->Html->link(__('View').'&nbsp;'.$this->Html->tag('i', '', array('class' => 'fa fa-info')),array('controller'=>'users','action' => 'view', $user['User']['id']),array('escape' => false, 'class'=>'btn btn-info btn-sm'));
									//echo "&nbsp;";
									//$var = $var = h(addslashes($user['User']['name']));
									//$elementId = (int)h($user['User']['id']);
									//echo $this->Html->link(__('Delete').'&nbsp;'.$this->Html->tag('i', '', array('class' => 'fa fa-times')), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}', this); return false;", 'class'=>'btn btn-danger btn-sm', 'id'=>'element_'.$elementId));
								?>			
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo __('Actions');?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<li>
											<?php echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-edit')).'&nbsp;'.__('Edit'), array('action' => 'edit', $user['User']['id']),array('escape' => false)); ?>
										</li>
										<li>
											<?php
												echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-info-circle')).'&nbsp;'.__('View'),array('controller'=>'users','action' => 'view', $user['User']['id']),array('escape' => false));
											?>
										</li>
										<li>
											<?php
												echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-envelope')).'&nbsp;'.__('Send Mail'),array('controller'=>'users','action' => 'sendEmail', $user['User']['id']),array('escape' => false));
											?>
										</li>
										
										<?php if (AuthComponent::user('role') === 'admin' && AuthComponent::user('id') !== $user['User']['id']): ?>
										<li class="divider"></li>
										<li>
											<?php
												$var = h(addslashes($user['User']['name']));
												$elementId = (int)h($user['User']['id']);
												if ($user['User']['is_banned'] == 1) {
													echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-ban')).'&nbsp;'.__('Unban User'),array('admin' => true, 'controller' => 'users', 'action' => 'unban', $elementId) , array('escape' => false), __('Are you sure you want to unban user: %s ?', $var));
												} else {

													echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-ban')).'&nbsp;'.__('Ban User'),array('admin'=>true, 'controller'=>'users', 'action' => 'ban', $elementId) , array('escape' => false), __("Are you sure you want to ban user: %s ?", $var));
												}
											?>
										</li>
										<li>
											<?php
												$var = $var = h(addslashes($user['User']['name']));
												$elementId = (int)h($user['User']['id']);
												echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-times')).'&nbsp;'.__('Delete'), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}', this); return false;",'id'=>'element_'.$elementId));
											?>
										</li>
										<?php endif ?>
									</ul>
								</div>
								
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="box-footer clearfix">
			<?php echo $this->element('Pagination/counter'); ?>
			<?php echo $this->element('Pagination/navigation'); ?>
		</div>
	<?php elseif (!empty($search)) : ?>
		<?php echo __('Your search returned no results, please try again!'); ?>
	<?php else : ?>
		<?php echo __('There are no content blocks at the moment!'); ?>
	<?php endif; ?>
</div>
<script>
/**
 * [ShowConfirmDelete Opem Confirmation box for when delating a row, Ajax]
 * @param {INT} id   [primary key of record]
 * @param {string} name [description]
 */
	function ShowConfirmDelete(id, name) {
		var $confirmModal = $('#modalConfirmYesNo'),
		 	$elementToMask = $('#elementToMask'),
			$rowToRemove = $('#element_'+id).closest('.parent-element');

		$confirmModal.modal('show');
		$('#lblMsgConfirmYesNo').html('<?php echo __('Are you sure you want to delete'); ?>: <b>' + name + '</b>?');
		$('#btnYesConfirmYesNo').off('click').on('click',function () {
			$confirmModal.modal('hide');
			$.ajax({
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'users','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				dataType: 'json',
				data:{data:{User:{id:id,nane:name}}},
				beforeSend: function() {
					// called before response
					$elementToMask.mask('Waiting...');
				},
				success: function(data, textStatus, xhr) {
					//called when successful
					if (textStatus =='success') {
						var response = $.parseJSON(JSON.stringify(data));
						if (!response.error) {
							$rowToRemove.fadeOut(350,function() { this.remove() });
							toastr.success(response.message,'<?php echo __('Success!'); ?>');
						} else {
							toastr.error(response.message,'<?php echo __('Error!'); ?>');
						}
					} else {
						toastr.warning(textStatus,'<?php echo __('Warning!'); ?>');
					}
				},
				complete: function(xhr, textStatus) {
					//called when complete
					$confirmModal.modal('hide');
					$elementToMask.unmask();
				},
				error: function(xhr, textStatus, errorThrown) {
					//called when there is an error
					$elementToMask.unmask();
					toastr.error(errorThrown, 'Error!');
				}
			});
			return true;
		});

		$('#btnNoConfirmYesNo').off('click').on('click', function () {
			$confirmModal.modal('hide');
			return true;
		});
		return true;
	}
</script>
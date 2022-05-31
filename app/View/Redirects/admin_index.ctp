<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo __('Redirects'); ?></h1>
	</div>
</div>

<div class="well">
	<?php echo $this->Form->create('Redirect', array('url'  => array('admin'=>true,'controller' => 'redirects','action' => 'index')));?>
		<fieldset class="form-group">
			<div class="input-group custom-search-form">
				<?php if (!empty($search)) : ?>
					<?php echo $this->Form->input('search', array('class' => 'form-control', 'label' => false, 'div' => false, 'value' => $search));?>
				<?php else :
					echo $this->Form->input('search',
							array('type' => 'text',
								'class' => 'form-control',
								'placeholder' => 'Search...',
								'label' => false,
								'div' => false
							)
						);
				endif; ?>
				<span class="input-group-btn">
					<?php 
						echo $this->Form->button('<i class="fa fa-search"></i>',
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
				echo $this->Html->link(__('Reset'), array('action' => 'index'), array('class' => 'btn btn-sm btn-warnign','escape' => false)); 
			endif; 
		echo $this->Form->end();
	?>
	<?php echo $this->Html->link(
				'<i class="fa fa-plus"></i>&nbsp;'.__('Add a Redirect'),
				array('action' => 'add'),
				array('class' => 'btn btn-primary','escape' => false));
	?>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-em">
			<div class="panel-heading">
				<?php echo __('Current Redirects'); ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<?php if (isset($redirects) && !empty($redirects)) : ?>
					<div class="table-responsive event-table">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th><?php echo $this->Paginator->sort('url', __('URL'));?></th>
									<th><?php echo $this->Paginator->sort('redirect', __('Redirect To'));?></th>
									<th><?php echo $this->Paginator->sort('status'); ?></th>
									<th><?php echo __('Actions');?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($redirects as $redirect) : ?>
									<tr class="parent-element">
										<td data-th="<?php echo __('URL');?>">
											<?php echo $this->Html->link(h($redirect['Redirect']['url']), '/'.$redirect['Redirect']['url'], array('target' => '_blank')); ?>
										</td>
										<td data-th="<?php echo __('Redirect');?>">
											<?php 
												echo (isset($redirect['Redirect']['redirect']) && !empty($redirect['Redirect']['redirect'])) ? h($redirect['Redirect']['redirect']) : '/'; 
											?>
										</td>
										<td data-th="<?php echo __('Status');?>">
											<a  data-toggle="tooltip" title="<?php echo  __('Unpublish this Redirect');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($redirect['Redirect']['id']); ?>',0); return false;" id="status_allowed_<?php echo h($redirect['Redirect']['id']); ?>" <?php if ($redirect['Redirect']['status'] == 0){ ?> style="display: none;" <?php } ?>>
												<span class="label label-success"><?php echo __('Published'); ?></span>
											</a>
											<a  data-toggle="tooltip" title="<?php echo  __('Publish this Redirect');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($redirect['Redirect']['id']); ?>',1); return false;" id="status_denied_<?php echo h($redirect['Redirect']['id']); ?>" <?php if ($redirect['Redirect']['status'] == 1){ ?> style="display: none;" <?php } ?>>
												<span class="label label-danger"><?php echo __('Unpublished'); ?></span>
											</a>
										</td>
										<td>
											<?php
												echo $this->Html->link(
													$this->Html->tag('i','',array('class' => 'fa fa-edit')).'&nbsp;'. __('Edit'), 
													array('action' => 'edit', $redirect['Redirect']['id']),
													array(
														'class'=>'btn btn-default btn-sm',
														'escape'=>false, 
														'alt' => __('Edit'),
														'title' => __('Edit')
													)
												);
												echo '&nbsp';
												$var = h(addslashes($redirect['Redirect']['url']));
												$elementId = (int)$redirect['Redirect']['id'];
												echo $this->Html->link(
													$this->Html->tag('i', '', array('class' => 'fa fa-close')).'&nbsp;'. __('Delete'), 
													'javascript:void(0);',
													array(
														'class'=>'btn btn-danger btn-sm',
														'escape'=>false, 
														'onclick' =>"ShowConfirmDelete({$elementId},'{$var}'); return false;", 
														'id'=>'element_'.$elementId,
														'alt' => __('Delete'),
														'title' => __('Delete')
													)
												);

											?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php 
								echo $this->element('Pagination/counter');
								echo $this->element('Pagination/navigation')
							?>
						</div>
					</div>
				<?php elseif (!empty($search)) : ?>
					<?php echo __('Your search returned no results, please try again!'); ?>
				<?php else : ?>
					<?php echo __('There are no redirects at the moment!'); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
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
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'redirects','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Redirect:{id:id,name:name}}},
				beforeSend: function() {
					// called before response
					$elementToMask.mask('Waiting...');
				},
				success: function(data, textStatus, xhr) {
					//called when successful
					if (textStatus =='success') {
						var response = $.parseJSON(JSON.stringify(data));
						if (!response.error) {
							$rowToRemove.fadeOut(350,function() { this.remove(); });
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

/**
 * [changeStatus Change publish/unpublish status]
 * @param  {$this} obj       [description]
 * @param  {INT} data_id     [description]
 * @param  {INT} data_status [1/0]
 * @return {string}          [description]
 */
	function changeStatus(obj,data_id,data_status){
		var $elementToMask = $('#elementToMask');
		if (data_status == undefined){
			data_status = 0;
		}
		$.ajax({
			url:'<?php echo Router::url(array('controller' => 'redirects','action' => 'changeStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{Redirect:{id:data_id,status:data_status}}},
			beforeSend: function() {
				// called before response
				$elementToMask.mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='success') {
					var response = $.parseJSON(JSON.stringify(data));

					if (!response.error) {
						if (data_status == 0){
							$('#status_allowed_'+data_id).hide();
							$('#status_denied_'+data_id).fadeIn('slow');
						}else{
							$('#status_allowed_'+data_id).fadeIn('slow');
							$('#status_denied_'+data_id).hide();
						}
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
				$elementToMask.unmask();
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				var message = '';
				if(xhr.responseJSON.hasOwnProperty('message')){
					//do struff		
					message = xhr.responseJSON.message;
				}
				$elementToMask.unmask();
				toastr.error(errorThrown+":&nbsp;"+message, textStatus);
			}
		});
	}
</script>
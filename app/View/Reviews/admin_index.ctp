<div class="row" id="elementToMask">
    <div class="col-sm-12">
        <div class="panel panel-em">
			<header class="panel-heading">
				<?php echo $this->Html->tag('h4',__('Reviews'),array('class' => 'display-inline-block')) ?>
			</header>
			<div class="panel-body">
				<div class="event-table">
				<table class="table">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('user_by', __('User from')); ?></th>
							<th><?php echo $this->Paginator->sort('user_to', __('User to')); ?></th>
							<th><?php echo $this->Paginator->sort('property_id'); ?></th>
							<th><?php echo $this->Paginator->sort('title'); ?></th>
							<th><?php echo $this->Paginator->sort('review'); ?></th>
							<th><?php echo $this->Paginator->sort('review_by'); ?></th>
							<th><?php echo $this->Paginator->sort('status'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($reviews as $review): ?>
						<?php $elementId = (int) $review['Review']['id']; ?>
						<tr>
							<td>
								<?php echo $this->Html->link(h($review['UserBy']['name']), array('controller' => 'users', 'action' => 'view', $review['UserBy']['id'])); ?>
							</td>
							<td>
								<?php echo $this->Html->link(h($review['UserTo']['name']), array('controller' => 'users', 'action' => 'view', $review['UserTo']['id'])); ?>
							</td>
							<td>
								<?php echo $this->Html->link($review['Property']['address'], array('controller' => 'properties', 'action' => 'view', $review['Property']['id'])); ?>
							</td>
							<td><?php echo h($review['Review']['title']); ?>&nbsp;</td>
							<td><?php echo h($review['Review']['review']); ?>&nbsp;</td>
							<td><?php echo h($review['Review']['review_by']); ?>&nbsp;</td>
							<td data-th="<?php echo __('Status');?>">
								<a data-toggle="tooltip" title="<?php echo  __('Click to unpublish this review');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo $review['Review']['id']; ?>',0); return false;" id="status_allowed_<?php echo $review['Review']['id']; ?>" <?php if ($review['Review']['status'] == 0){ ?> style="display: none;" <?php } ?>>
									<span class="label label-success"><?php echo __('Published');?></span>
								</a>
								<a data-toggle="tooltip" title="<?php echo  __('Click to publish this review');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo$review['Review']['id']; ?>',1); return false;" id="status_denied_<?php echo$review['Review']['id']; ?>" <?php if ($review['Review']['status'] == 1){ ?> style="display: none;" <?php } ?>>
									<span class="label label-danger"><?php echo __('Unpublished');?></span>
								</a>
							</td>
							<td class="actions">
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo __('Actions');?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<li>
											<?php
												echo $this->Html->link(
													$this->Html->tag('i', '', array('class' => 'fa fa-edit')).'&nbsp;'.__('Edit'), 
													array('action' => 'edit', $elementId),
													array('escape' => false)
												);
											?>
										</li>
										<li>
											<?php
												echo $this->Html->link(
													$this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View'),
													array('action' => 'view', $review['Review']['id']),
													array('escape' => false)
												);
											?>
										</li>
										<li class="divider"></li>
										<li>
											<?php
												$var = h(addslashes($review['Review']['title']));
												echo $this->Html->link(
													$this->Html->tag('i', '', array('class' => 'fa fa-times')).'&nbsp;'.__('Delete'), 
													'javascript:void(0);',
													array('escape'=>false, 'onclick' =>"ShowConfirmDelete(this, {$elementId},'{$var}', this); return false;")
												);
											?>
										</li>
									</ul>
								</div>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				</div>
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
<script>
/**
 * [ShowConfirmDelete Opem Confirmation box for when delating a row, Ajax]
 * @param {INT} id   [primary key of record]
 * @param {string} name [description]
 */
	function ShowConfirmDelete(obj, id, name) {
		var $confirmModal = $('#modalConfirmYesNo'),
		 	$elementToMask = $('#elementToMask'),
			$rowToRemove = $(obj).closest('.parent-element');

		$confirmModal.modal('show');
		$('#lblMsgConfirmYesNo').html('<?php echo __('Are you sure you want to delete'); ?>: <b>' + name + '</b>?');
		$('#btnYesConfirmYesNo').off('click').on('click',function () {
			$confirmModal.modal('hide');
			$.ajax({
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'reviews','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Review:{id:id,name:name}}},
				beforeSend: function() {
					// called before response
					$elementToMask.mask('Waiting...');
				},
				success: function(data, textStatus, xhr) {
					//called when successful
					if (textStatus =='success') {
						var response = $.parseJSON(JSON.stringify(data));
						if (!response.error) {
							$rowToRemove.fadeOut(350,function() { obj.remove() });
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
					var message = '';
					if(xhr.responseJSON.hasOwnProperty('message')){
						//do struff		
						message = xhr.responseJSON.message;
					}
					$elementToMask.unmask();
					toastr.error(errorThrown+":&nbsp;"+message, textStatus);
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
			url:'<?php echo Router::url(array('admin'=>true, 'controller' => 'reviews', 'action' => 'changeStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{Review:{id:data_id,status:data_status}}},
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
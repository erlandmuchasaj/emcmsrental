<div class="row" id="elementToMask">
	<div class="col-sm-12">
		<div class="panel panel-em">
			<header class="panel-heading">
				<?php echo $this->Html->tag('h4',__('Cancellation Policies'),array('class' => 'display-inline-block')) ?>
				<span class="tools pull-right panel-heading-actions">
					<?php
						echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')).'&nbsp;'.__('New Policy'),array('admin'=>true, 'controller' => 'cancellation_policies', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
					?>
				</span>
			</header>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('name'); ?></th>
								<th><?php echo $this->Paginator->sort('is_standard'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($cancellationPolicies as $cancellationPolicy): ?>
								<tr>
									<td><?php echo h($cancellationPolicy['CancellationPolicy']['name']); ?>&nbsp;</td>
									<td>
										<a data-toggle="tooltip" title="<?php echo __('Unpublush');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($cancellationPolicy['CancellationPolicy']['id']); ?>',0); return false;" id="status_allowed_<?php echo h($cancellationPolicy['CancellationPolicy']['id']); ?>" <?php if ($cancellationPolicy['CancellationPolicy']['is_standard'] == 0){ ?> style="display: none;" <?php } ?>>
											<span class="label label-success"><?php echo __('Published'); ?></span>
										</a>
										<a data-toggle="tooltip" title="<?php echo __('Publish');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($cancellationPolicy['CancellationPolicy']['id']); ?>',1); return false;" id="status_denied_<?php echo h($cancellationPolicy['CancellationPolicy']['id']); ?>" <?php if ($cancellationPolicy['CancellationPolicy']['is_standard'] == 1){ ?> style="display: none;" <?php } ?>>
											<span class="label label-danger"><?php echo __('Unpublished'); ?></span>
										</a>
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
	<?php echo $this->element('Pagination/counter'); ?>
	<?php echo $this->element('Pagination/navigation'); ?>
</div>
<script>
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
			url:'<?php echo Router::url(array('controller' => 'cancellation_policies', 'action' => 'changeStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{CancellationPolicy:{id:data_id,is_standard:data_status}}},
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
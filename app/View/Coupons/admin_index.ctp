<div class="row" id="elementToMask">
    <div class="col-sm-12">
        <div class="panel panel-em">
			<header class="panel-heading">
				<?php echo $this->Html->tag('h4',__('Coupons'),array('class' => 'display-inline-block')) ?>
			    <span class="tools pull-right">
			        <?php  echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')). ' ' .__('New Coupon'),array('admin'=>true, 'controller' => 'coupons', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-flat')); 
			        ?>
			     </span>
			</header>
			<div class="panel-body table-responsive event-table">
				<table class="table general-table">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('code'); ?></th>
							<th><?php echo $this->Paginator->sort('price_value', __('Value')); ?></th>
							<th><?php echo $this->Paginator->sort('coupon_type'); ?></th>
							<th><?php echo $this->Paginator->sort('quantity'); ?></th>
							<th><?php echo $this->Paginator->sort('date_from', __('Valid F/T')); ?></th>
							<th><?php echo $this->Paginator->sort('purchase_count'); ?></th>
							<th><?php echo $this->Paginator->sort('status'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($coupons as $coupon): ?>
							<tr class="parent-element">
								<td data-th="<?php echo __('Name');?>"><?php echo h($coupon['Coupon']['name']); ?>&nbsp;</td>
								<td data-th="<?php echo __('Code');?>"><?php echo h($coupon['Coupon']['code']); ?>&nbsp;</td>
								<td data-th="<?php echo __('Value');?>">
								<?php 
									if ($coupon['Coupon']['price_type']==1) {
									 	# we have a percentage coupon
									 	echo round($coupon['Coupon']['price_value'], 0)."% ({$coupon['Coupon']['currency']})";
									} elseif ($coupon['Coupon']['price_type']==2) {
										# we have a fixed value coupon
										echo $this->Number->currency($coupon['Coupon']['price_value'], $coupon['Coupon']['currency'], ['thousands' => ',', 'decimals' => '.']);
									} 									  
								?>
								</td>
								<td data-th="<?php echo __('Type');?>"><?php echo Inflector::humanize($coupon['Coupon']['coupon_type']);?></td>
								<td data-th="<?php echo __('Quantity');?>"><?php echo h($coupon['Coupon']['quantity']); ?>&nbsp;</td>
								<td data-th="<?php echo __('Validity');?>">
								<?php echo __('From').':&nbsp;'.h($coupon['Coupon']['date_from']);?>
								<br>
								<?php echo __('To').':&nbsp;'.h($coupon['Coupon']['date_to']); ?>
								</td>
								<td data-th="<?php echo __('Purchase count');?>"><?php echo h($coupon['Coupon']['purchase_count']); ?>&nbsp;</td>
								<td data-th="<?php echo __('Status');?>">
									<a data-toggle="tooltip" title="<?php echo  __('Click to unpublish this coupon');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo $coupon['Coupon']['id']; ?>',0); return false;" id="status_allowed_<?php echo $coupon['Coupon']['id']; ?>" <?php if ($coupon['Coupon']['status'] == 0){ ?> style="display: none;" <?php } ?>>
										<span class="label label-success"><?php echo __('Published');?></span>
									</a>
									<a data-toggle="tooltip" title="<?php echo  __('Click to publish this coupon');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo $coupon['Coupon']['id']; ?>',1); return false;" id="status_denied_<?php echo $coupon['Coupon']['id']; ?>" <?php if ($coupon['Coupon']['status'] == 1){ ?> style="display: none;" <?php } ?>>
										<span class="label label-danger"><?php echo __('Unpublished');?></span>
									</a>
								</td>
								<td class="actions">
									<?php
										echo $this->Html->link(__('Edit').'&nbsp;'.$this->Html->tag('i', '', array('class' => 'fa fa-edit')), array('action' => 'edit', $coupon['Coupon']['id']),array('escape' => false, 'class'=>'btn btn-success btn-sm')); 
									?>
									&nbsp;
									<?php
										echo $this->Html->link(__('View').'&nbsp;'.$this->Html->tag('i', '', array('class' => 'fa fa-info')),array('action' => 'view', $coupon['Coupon']['id']),array('escape' => false, 'class'=>'btn btn-info btn-sm')); 
									?>
									&nbsp;
									<div data-toggle="tooltip" title="<?php echo __('Delete coupon');?>">
										<?php
											$var = $var = h(addslashes($coupon['Coupon']['name']));
											$elementId = (int)h($coupon['Coupon']['id']);
											echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-times')), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete(this, {$elementId},'{$var}', this); return false;", 'class'=>'btn btn-danger btn-sm', 'id'=>'element_'.$elementId));
										?>
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
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'coupons','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Coupon:{id:id,name:name}}},
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
					// console.log(xhr.responseJSON.message);
					// var response = $.parseJSON(xhr.responseText);
					// console.log(response.message);

					//called when there is an error
					$elementToMask.unmask();
					toastr.error(errorThrown+': '+xhr.responseJSON.message, textStatus);
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
			url:'<?php echo Router::url(array('admin'=>true, 'controller' => 'coupons', 'action' => 'changeStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{Coupon:{id:data_id,status:data_status}}},
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
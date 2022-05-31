<div class="box box-danger"  id="elementToMask">
	<div class="box-header with-border">
		<?php echo $this->Html->tag('h3', __('Room Types'), array('class'=>'box-title'))?>
		<div class="box-tools pull-right">
			<?php
				echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')).'&nbsp;'.__('New Type'),array('admin'=>true, 'controller' => 'room_types', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
			?>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">
		<table class="table">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('room_type_id', 'ID'); ?></th>
					<th><?php echo $this->Paginator->sort('language_id', __('Language')); ?></th>
					<th><?php echo $this->Paginator->sort('room_type_name', __('Name')); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($roomTypes as $roomType): ?>
				<tr class="parent-element">
					<td><?php echo $roomType['RoomType']['room_type_id']; ?></td>
					<td>
						<?php echo $this->Html->link($roomType['Language']['name'], array('controller' => 'languages', 'action' => 'view', $roomType['Language']['id'])); ?>&nbsp;
					</td>
					<td><?php echo htmlspecialchars_decode(stripslashes($roomType['RoomType']['room_type_name'])); ?>&nbsp;</td>
					<td class="actions">
						<?php 
							echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View'),array('admin'=>true,'controller'=>'room_types','action' => 'view', $roomType['RoomType']['id']),array('escape' => false, 'class'=>'btn btn-success btn-sm'));
							echo "&nbsp;";
							echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa  fa-edit')).'&nbsp;'.__('Edit'),array('admin'=>true,'controller'=>'room_types','action' => 'edit', $roomType['RoomType']['id']),array('escape' => false, 'class'=>'btn btn-info btn-sm'));
							echo "&nbsp;";
							$var = h(addslashes($roomType['RoomType']['room_type_name']));
							$elementId = (int)h($roomType['RoomType']['id']);
							echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-times')).'&nbsp;'.__('Delete'), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}', this); return false;", 'class'=>'btn btn-danger btn-sm', 'id'=>'element_'.$elementId));
						?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
	<div class="box-footer text-center">
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
	function ShowConfirmDelete(id, name, obj) {
		var __this =$(obj),
			$confirmModal = $('#modalConfirmYesNo'),
		 	$elementToMask = $('#elementToMask'),
			$rowToRemove = $('#element_'+id).closest('.parent-element');

		$confirmModal.modal('show');
		$('#lblMsgConfirmYesNo').html('<?php echo __('Are you sure you want to delete'); ?>: <b>' + name + '</b>?');
		$('#btnYesConfirmYesNo').off('click').on('click',function () {
			$confirmModal.modal('hide');
			$.ajax({
				// url: baseURL + '/admin/' + controller + '/delete/' + id,
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'room_types','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				async: false,
				dataType: 'json',
				data:{data:{RoomType:{id:id,room_type_name:name}}},
				beforeSend: function() {
					// called before response
					$elementToMask.mask('Waiting...');
				},
				success: function(data, textStatus, xhr) {
					// console.log(data);
					// console.log(textStatus);
					// console.log(xhr.status);
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
					var response = $.parseJSON(xhr.responseText);
					//called when there is an error
					$elementToMask.unmask();
					toastr.error(errorThrown+': '+response.message, textStatus);
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
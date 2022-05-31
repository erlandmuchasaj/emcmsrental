<?php
	$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Characteristic'. DS;
	// echo $this->Html->css('icon-picker', null, array('block'=>'cssMiddle'));
?>
<div class="box box-danger"  id="elementToMask">
	<div class="box-header with-border">
		<?php echo $this->Html->tag('h3', __('Characteristics'), array('class'=>'box-title'))?>
		<div class="box-tools pull-right">
			<?php
				echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')).'&nbsp;'.__('New Characteristic'),array('admin'=>true, 'controller' => 'characteristics', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
			?>
		</div>
	</div>
	<div class="box-body event-table">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo $this->Paginator->sort('icon'); ?></th>
						<th><?php echo $this->Paginator->sort('icon_class', __('Icon font')); ?></th>
						<th><?php echo $this->Paginator->sort('CharacteristicTranslation.characteristic_name', __('Name')); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($characteristics as $characteristic): ?>
						<tr class="parent-element">
							<td data-th="<?php echo __('ID');?>" ><?php echo h($characteristic['Characteristic']['id']);?></td>
							<td data-th="<?php echo __('Thumbnail');?>"  class="avatar-img">
							<?php 
								if (file_exists($directory.$characteristic['Characteristic']['icon']) && is_file($directory .$characteristic['Characteristic']['icon'])) {
									echo $this->Html->image('uploads/Characteristic/'. h($characteristic['Characteristic']['icon']), array('alt' => 'icon', 'class'=>'img-responsive', 'width'=>35, 'height'=>35)); 
								} else {
									echo $this->Html->image('no-img-available.png', array('alt' => 'img', 'width'=>35, 'height'=>35));
								}
							?>
							</td>
							<td data-th="<?php echo __('Icon');?>"  class="icon-preview"><i class="<?php echo h($characteristic['Characteristic']['icon_class']);?>"></i></td>
							<td data-th="<?php echo __('Name');?>" ><?php echo h($characteristic['CharacteristicTranslation']['characteristic_name']);?></td>
							<td class="actions">
							<?php 
								echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View'),array('admin'=>true,'controller'=>'characteristics','action' => 'view', $characteristic['Characteristic']['id']),array('escape' => false, 'class'=>'btn btn-success btn-sm'));

								echo "&nbsp;";
								echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')).'&nbsp;'.__('Edit'),array('admin'=>true,'controller'=>'characteristics','action' => 'edit', $characteristic['Characteristic']['id']),array('escape' => false, 'class'=>'btn btn-info btn-sm'));

								echo "&nbsp;";
								$var = h(addslashes($characteristic['CharacteristicTranslation']['characteristic_name']));
								$elementId = (int)h($characteristic['Characteristic']['id']);
								echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-times')).'&nbsp;'.__('Delete'), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}', this); return false;", 'class'=>'btn btn-danger btn-sm', 'id'=>'element_'.$elementId));
							?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
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
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'characteristics','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				async: false,
				dataType: 'json',
				data:{data:{Characteristic:{id:id,characteristic_name:name}}},
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

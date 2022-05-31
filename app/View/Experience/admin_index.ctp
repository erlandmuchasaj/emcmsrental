<div id="elementToMask">
	<div class="row">
		<div class="col-sm-3 pull-left">
			<?php
				$default_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
				if($this->Session->check('per_page_count')) { 
					$default_count = $this->Session->read('per_page_count');
				}
			?>
			<select id="per_page_count" class="form-control selectboxit">
				<option value="5"  <?php echo ($default_count == '5') ? 'selected' : '' ; ?>>5</option>
				<option value="10" <?php echo ($default_count == '10') ? 'selected' : '' ; ?>>10</option>
				<option value="15" <?php echo ($default_count == '15') ? 'selected' : '' ; ?>>15</option>
				<option value="20" <?php echo ($default_count == '20') ? 'selected' : '' ; ?>>20</option>
				<option value="25" <?php echo ($default_count == '25') ? 'selected' : '' ; ?>>25</option>
				<option value="30" <?php echo ($default_count == '30') ? 'selected' : '' ; ?>>30</option>
				<option value="50" <?php echo ($default_count == '50') ? 'selected' : '' ; ?>>50</option>
				<option value="100" <?php echo ($default_count == '100') ? 'selected' : '' ; ?>>100</option>
			</select>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-em">
				<header class="panel-heading">
					<?php echo $this->Html->tag('h4', __('Experiences'), array('class' => 'display-inline-block')) ?>
					<span class="tools pull-right">
						<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square fa-lg')). '&nbsp;' .__('New experience'),array('admin'=>true, 'controller' => 'experience', 'action' => 'add'), array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
						?>
					</span> 
				</header>
				<div class="panel-body">
					<table class="table general-table">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('id', '#'); ?></th>
								<th><?php echo $this->Paginator->sort('title'); ?></th>
								<th><?php echo $this->Paginator->sort('user_id', __('Host')); ?></th>
								<th><?php echo $this->Paginator->sort('city_id', __('City')); ?></th>
								<th><?php echo $this->Paginator->sort('category_id', __('Category')); ?></th>
								<th><?php echo $this->Paginator->sort('is_approved', __('Admin status')); ?></th>
								<th><?php echo $this->Paginator->sort('is_featured', __('Featured')); ?></th>
								<th><?php echo $this->Paginator->sort('status'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody id="sortable">
							<?php foreach ($experiences as $experience): ?>
								<tr id="arrayorder_<?php echo $experience['Experience']['id']; ?>" class="OrderingField parent-element">
									<td class="sort-handle">
										<?php echo $experience['Experience']['id']; ?>
									</td>
									<td>
										<?php echo h($experience['Experience']['title']); ?>
									</td>
									<td>
										<?php echo $this->Html->link($experience['User']['name'], array('controller' => 'users', 'action' => 'view', $experience['User']['id'])); ?>
									</td>
									<td>
										<?php echo $this->Html->link($experience['City']['name'], array('controller' => 'cities', 'action' => 'view', $experience['City']['id'])); ?>
									</td>
									<td>
										<?php echo $this->Html->link($experience['Category']['name'], array('controller' => 'categories', 'action' => 'view', $experience['Category']['id'])); ?>
									</td>

									<td>
									<?php 
										echo $this->Form->create('Experience', array('type' => 'post', 'url' => array('admin' => true, 'controller' => 'experience', 'action' => 'status', $experience['Experience']['id']), 'name' => 'admin_status_'. $experience['Experience']['id']));
										echo $this->Form->input('id', ['type' => 'hidden', 'value' => $experience['Experience']['id']]);
										echo $this->Form->input('is_approved', [
												'div' => false,
												'label' => false,
												'type' => 'select',
												'options' => [
													'pending' => 'Pending',
													'approved' => 'Approved',
													'rejected' => 'Rejected',
												],
												'value' => $experience['Experience']['is_approved'],
												'onchange' => "this.form.submit(); return false;",
											]);
										echo $this->Form->end(); 
									?>
									</td>
									<td>
										<a href="javascript:void(0);" onclick="changeFeatured(this,'<?php echo $experience['Experience']['id']; ?>', 0); return false;" id="featured_allowed_<?php echo $experience['Experience']['id']; ?>" <?php if ($experience['Experience']['is_featured'] == 0){ ?> style="display: none;" <?php } ?>>
											<span class="label label-success"><?php echo __('Yes'); ?></span>
										</a>

										<a href="javascript:void(0);" onclick="changeFeatured(this,'<?php echo $experience['Experience']['id']; ?>', 1); return false;" id="featured_denied_<?php echo $experience['Experience']['id']; ?>" <?php if ($experience['Experience']['is_featured'] == 1){ ?> style="display: none;" <?php } ?>>
											<span class="label label-danger"><?php echo __('No'); ?></span>
										</a>
									</td>

									<td>
										<a href="javascript:void(0);" onclick="changeStatus(this,'<?php echo $experience['Experience']['id']; ?>', 0); return false;" id="status_allowed_<?php echo $experience['Experience']['id']; ?>" <?php if ($experience['Experience']['status'] == 0){ ?> style="display: none;" <?php } ?>>
											<span class="label label-success"><?php echo __('Published'); ?></span>
										</a>
										<a href="javascript:void(0);" onclick="changeStatus(this,'<?php echo $experience['Experience']['id']; ?>', 1); return false;" id="status_denied_<?php echo $experience['Experience']['id']; ?>" <?php if ($experience['Experience']['status'] == 1){ ?> style="display: none;" <?php } ?>>
											<span class="label label-danger"><?php echo __('Unpublished'); ?></span>
										</a>
									</td>

									<td class="actions">
										<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-info')).'&nbsp;'.__('View'), array('admin' => true, 'controller' => 'experience', 'action' => 'view', $experience['Experience']['id']),array('class'=>'btn btn-info btn-sm','escape'=>false)); ?>

										<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-edit')).'&nbsp;'.__('Edit'), array('admin' => true, 'controller' => 'experience', 'action' => 'edit', $experience['Experience']['id']),array('class'=>'btn btn-default btn-sm','escape'=>false)); ?>

										<?php 
											$var = h(addslashes($experience['Experience']['title']));
											$experience_id = (int)$experience['Experience']['id'];
											echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-close')).'&nbsp;'.__('Delete'), 'javascript:;',array('class'=>'btn btn-danger btn-sm','escape'=>false, 'onclick' =>"ShowConfirmDelete({$experience_id},'{$var}'); return false;", 'id'=>'element_'.$experience_id));
										?>
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
</div>

<?php
	$this->Html->scriptBlock("
		(function($){
			$(document).ready(function() {
				'use strict';
				$('#sortable').sortable({
					opacity: 0.8, 
					cursor: 'move',
					revert: true,
					handle : '.sort-handle',
					zIndex: 999,
					axis: 'y',
					distance: 10,
					items: '.OrderingField',
					start: function(e,ui){
						ui.placeholder.height(ui.item.height());
					},
					helper: function(e, tr){
						var originals = tr.children();
						var helper = tr.clone();
						helper.children().each(function(index)	{
							$(this).width(originals.eq(index).width());
						});
						helper.css('background-color', 'rgba(223, 240, 249,0.6)');
						return helper;
					},
					update: function() {
						var order = $(this).sortable('serialize')+'&action=sort'; 
						$.post(fullBaseUrl+'/admin/experience/sort', order, function(data, textStatus, xhr) {
							if (textStatus =='success') {
								/*
								* // this verison is used when we specify the returned data type
								* var response = $.parseJSON(JSON.stringify(data));
								*/
								var response = $.parseJSON(data);
								if (!response.error) {
									toastr.success(response.message);
								}
							} else {
								toastr.info(textStatus);
							}
						});
					}                                 
				});

				// when modal close clear his content
				$('#modalConfirmYesNo').on('hidden.bs.modal', function () {
					// do something…
					$('#lblMsgConfirmYesNo').html('');
				})
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>
<script>
/**
 * [ShowConfirmDelete Opem Confirmation box for when delating a row, Ajax]
 * @param {INT} id   [primary key of record]
 * @param {string} name 
 */
	function ShowConfirmDelete(id, name) {
		var $confirmModal = $('#modalConfirmYesNo'),
		 	$elementToMask = $('#elementToMask'),
			$rowToRemove = $('#element_'+id).closest('.parent-element');
		$confirmModal.modal('show');
		$('#lblMsgConfirmYesNo').html('Are you sure you want to delete <b>' + name + '</b>.');
		$('#btnYesConfirmYesNo').off('click').on('click', function () {
			$confirmModal.modal('hide');
			$.ajax({
				url: fullBaseUrl+'/admin/experience/delete/' + id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Experience:{id:id,name:name}}},
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
							toastr.success(response.message,'Success!');
						} else {
							toastr.error(response.message,'Error!');
						}
					} else {
						toastr.warning(textStatus,'Warning!');
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
 * changeStatus 
 * Change publish/unpublish status
 * 
 * @param  {$this} obj       
 * @param  {INT} data_id     
 * @param  {INT} data_status [1/0]
 * @return {string}          
 */
	function changeStatus(obj, data_id, data_status) {
		var $elementToMask = $('#elementToMask');
		if (data_status == undefined){
			data_status = 0;
		}
		$.ajax({
			url: fullBaseUrl+'/admin/experience/changeStatus',
			type: 'POST',
			dataType: 'json',
			data:{data:{Experience:{id:data_id,status:data_status}}},
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
						toastr.success(response.message, 'Success!');
					} else {
						toastr.error(response.message,'Error!');
					}
				} else {
					toastr.warning(textStatus,'Warning!');
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

/**
 * changeFeatured 
 * Change publish/unpublish status
 * 
 * @param  {$this} obj       
 * @param  {INT} data_id     
 * @param  {INT} data_status [1/0]
 * @return {string}          
 */
	function changeFeatured(obj, data_id, data_status) {
		var $elementToMask = $('#elementToMask');
		if (data_status == undefined){
			data_status = 0;
		}
		$.ajax({
			url: fullBaseUrl+'/admin/experience/featured',
			type: 'POST',
			dataType: 'json',
			data:{data:{Experience:{id:data_id,is_featured:data_status}}},
			beforeSend: function() {
				// called before response
				$elementToMask.mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='success') {
					var response = $.parseJSON(JSON.stringify(data));

					if (!response.error) {
						if (data_status == 0 ){
							$('#featured_allowed_'+data_id).hide();
							$('#featured_denied_'+data_id).fadeIn('slow');
						}else{
							$('#featured_allowed_'+data_id).fadeIn('slow');
							$('#featured_denied_'+data_id).hide();
						}
						toastr.success(response.message, 'Success!');
					} else {
						toastr.error(response.message, 'Error!');
					}
				} else {
					toastr.warning(textStatus, 'Warning!');
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

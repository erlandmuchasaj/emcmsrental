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
					<?php echo $this->Html->tag('h4',__('Categories'),array('class' => 'display-inline-block')) ?>
					<span class="tools pull-right">
						<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square fa-lg')). '&nbsp;' .__('New category'),array('admin'=>true, 'controller' => 'categories', 'action' => 'add'), array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
						?>
					</span> 
				</header>
				<div class="panel-body">
					<table class="table general-table">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('id', '#'); ?></th>
								<th><?php echo $this->Paginator->sort('name'); ?></th>
								<th><?php echo $this->Paginator->sort('model'); ?></th>
								<th class="hidden-sm hidden-xs"><?php echo $this->Paginator->sort('description'); ?></th>
								<th><?php echo $this->Paginator->sort('status'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody id="sortable">
							<?php foreach ($categories as $category): ?>
								<tr id="arrayorder_<?php echo $category['Category']['id']; ?>" class="OrderingField parent-element">
									<td class="sort-handle" width="80px;"><?php echo h($category['Category']['id']); ?>&nbsp;<i class="fa fa-sort"></i></td>
									<td><?php echo h($category['Category']['name']); ?>&nbsp;</td>
									<td><?php echo h($category['Category']['model']); ?>&nbsp;</td>
									<td class="hidden-sm hidden-xs" width="25%">
									<?php echo getDescriptionHtml($category['Category']['description']);?>
									</td>
									<td>
										<a href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($category['Category']['id']); ?>',0); return false;" id="status_allowed_<?php echo h($category['Category']['id']); ?>" <?php if ($category['Category']['status'] == 0){ ?> style="display: none;" <?php } ?>>
											<span class="label label-success"><?php echo __('Published'); ?></span>
										</a>
										<a href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($category['Category']['id']); ?>',1); return false;" id="status_denied_<?php echo h($category['Category']['id']); ?>" <?php if ($category['Category']['status'] == 1){ ?> style="display: none;" <?php } ?>>
											<span class="label label-danger"><?php echo __('Unpublished'); ?></span>
										</a>
									</td>
									<td class="actions">
										<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-info')).'&nbsp;'.__('View'), array('admin' => true, 'controller' => 'categories', 'action' => 'view', $category['Category']['id']),array('class'=>'btn btn-info btn-sm','escape'=>false)); ?>

										<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-edit')).'&nbsp;'.__('Edit'), array('admin' => true, 'controller' => 'categories', 'action' => 'edit', $category['Category']['id']),array('class'=>'btn btn-default btn-sm','escape'=>false)); ?>

										<?php 
											$var = h(addslashes($category['Category']['name']));
											$category_id = (int)$category['Category']['id'];
											echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-close')).'&nbsp;'.__('Delete'), 'javascript:;',array('class'=>'btn btn-danger btn-sm','escape'=>false, "onclick" =>"ShowConfirmDelete({$category_id},'{$var}'); return false;", 'id'=>'element_'.$category_id));
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
						var \$originals = tr.children();
						var \$helper = tr.clone();
						\$helper.children().each(function(index)	{
							$(this).width(\$originals.eq(index).width());
						});
						\$helper.css('background-color', 'rgba(223, 240, 249,0.6)');
						return \$helper;
					},
					update: function() {
						var order = $(this).sortable('serialize')+'&action=sort'; 
						$.post('".Router::Url(array('admin' => true, 'controller' => 'categories','action' => 'sort'), true)."', order, function(data, textStatus, xhr) {
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
 * @param {string} name [description]
 */
	function ShowConfirmDelete(id, name) {
		var $confirmModal = $('#modalConfirmYesNo'),
		 	$elementToMask = $('#elementToMask'),
			$rowToRemove = $('#element_'+id).closest('.parent-element');
		$confirmModal.modal('show');
		$('#lblMsgConfirmYesNo').html('<?php echo __('Are you sure you want to delete'); ?>: <b>' + name + '</b>.');
		$('#btnYesConfirmYesNo').off('click').on('click',function () {
			$confirmModal.modal('hide');
			$.ajax({
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'categories','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Category:{id:id,name:name}}},
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
			url:'<?php echo Router::url(array('controller' => 'categories','action' => 'changeStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{Category:{id:data_id,status:data_status}}},
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
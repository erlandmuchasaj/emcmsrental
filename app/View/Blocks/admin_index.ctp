<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			<?php echo __('Content Blocks');?>
		</h1>
	</div>
</div>
<div class="well">
	<?php echo $this->Form->create('Block', array('url'  => array('admin'=>true,'controller' => 'blocks','action' => 'index')));?>
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

		// debug($blocks);

		echo $this->Html->link(
				'<i class="fa fa-plus"></i> ' . __('Add a new content block'),
				array('action' => 'add'),
				array('class' => 'btn btn-primary','escape' => false)
			); 
	?>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-em">
			<div class="panel-heading">
				<h4 style="display:inline-block;"><?php echo __('Current Content Blocks'); ?></h4>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body ">
				<?php if (isset($blocks) && !empty($blocks)) : ?>
					<div class="table-responsive event-table">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th><?php echo $this->Paginator->sort('name'); ?></th>
									<th><?php echo $this->Paginator->sort('slug', __('Slug / Key')); ?></th>
									<th class="hidden-xs hidden-sm"><?php echo $this->Paginator->sort('modified', __('Last Modified')); ?></th>
									<th><?php echo $this->Paginator->sort('status'); ?></th>
									<th><?php echo __('Actions'); ?></th>
								</tr>
							</thead>
							<tbody id="sortable">
								<?php foreach ($blocks as $block): ?>
									<tr id="arrayorder_<?php echo $block['Block']['id']; ?>" class="parent-element">
										<td class="sort-handle" data-th="<?php echo __('Name');?>"><?php echo "<i class='fa fa-sort'></i>&nbsp;".h($block['Block']['name']); ?></td>
										<td data-th="<?php echo __('Slug');?>"><?php echo h($block['Block']['slug']); ?></td>
										<td class="hidden-xs hidden-sm"><?php echo $this->Time->niceShort($block['Block']['modified']); ?></td>
										<td data-th="<?php echo __('Status');?>">
											<a  data-toggle="tooltip" title="<?php echo  __('Unpublish this Block');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($block['Block']['id']); ?>',0); return false;" id="status_allowed_<?php echo h($block['Block']['id']); ?>" <?php if ($block['Block']['status'] == 0){ ?> style="display: none;" <?php } ?>>
												<span class="label label-success"><?php echo __('Published'); ?></span>
											</a>
											<a  data-toggle="tooltip" title="<?php echo  __('Publish this Block');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($block['Block']['id']); ?>',1); return false;" id="status_denied_<?php echo h($block['Block']['id']); ?>" <?php if ($block['Block']['status'] == 1){ ?> style="display: none;" <?php } ?>>
												<span class="label label-danger"><?php echo __('Unpublished'); ?></span>
											</a>
										</td>
										<td class="actions">
										<?php
											echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-edit')).'&nbsp;'. __('Edit'), array('action' => 'edit', $block['Block']['id']),array('class'=>'btn btn-default btn-sm','escape'=>false));

											if (isset($block['Block']['revisions']) && !empty($block['Block']['revisions']))	{
												echo '&nbsp;';
												echo $this->Html->link(
														$this->Html->tag('i','',array('class' => 'fa fa-clipboard'))
														.'&nbsp;'. __('Revisions'),
														array('controller' => 'revisions',
															'action' => 'model',
															'Block',
															$block['Block']['id']),
														array(
															'class' => 'btn btn-info btn-sm',
															'escape' => false,
															'alt' => __('Revisions'),
															'title' => __('Revisions')
														)
													);
											}

											echo '&nbsp';
											$var = h(addslashes($block['Block']['name']));
											$elementId = (int)$block['Block']['id'];
											echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-close')).'&nbsp;'. __('Delete'), 'javascript:void(0);',array('class'=>'btn btn-danger btn-sm','escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}'); return false;", 'id'=>'element_'.$elementId));
											?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php 
						echo $this->element('Pagination/counter');
						echo $this->element('Pagination/navigation')
						?>
					</div>
				<?php elseif (!empty($search)) : ?>
					<?php echo __('Your search returned no results, please try again!'); ?>
				<?php else : ?>
					<?php echo __('There are no content blocks at the moment!'); ?>
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
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'blocks','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Article:{id:id,name:name}}},
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
			url:'<?php echo Router::url(array('controller' => 'blocks','action' => 'changeStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{Block:{id:data_id,status:data_status}}},
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
				axis: 'y',
				coneHelperSize: true,
				forcePlaceholderSize: true,
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
					$.post('".Router::Url(array('admin' => true, 'controller' => 'blocks','action' => 'sort'), true)."', order, function(data, textStatus, xhr) {
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
		});
	})(jQuery);
", array('block' => 'scriptBottom'));
?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
	(function($){
		$(document).ready(function() {
			'use strict';
		});
	})(jQuery);
<?php $this->Html->scriptEnd(); ?>

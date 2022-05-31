<?php
	$current_model = Inflector::classify($this->params['controller']);
	$current_controller = $this->params['controller'];
	$current_action 	= $this->params['action'];
	$directorySm = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'HomeSlider'. DS.'small'.DS;
?>
	<div class="row" id="elementToMask">
		<div class="col-sm-12">
			<div class="panel panel-em">
				<header class="panel-heading">
					<?php echo $this->Html->tag('h4',__('Home Sliders'),array('class' => 'display-inline-block')) ?>
					<span class="tools pull-right panel-heading-actions">
						<?php
							echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')).'&nbsp;'.__('New Slider'),array('admin'=>true, 'controller' => 'home_sliders', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
						?>
					</span>
				</header>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table  table-hover general-table">
							<thead>
								<tr>
									<th><?php echo __('#'); ?></th>
									<th><?php echo $this->Paginator->sort('image_path',__('Image')); ?></th>
									<th class="hidden-md hidden-sm hidden-xs"><?php echo $this->Paginator->sort('slogan',__('Slogan')); ?></th>
									<th><?php echo $this->Paginator->sort('status', __('Status')); ?></th>
									<th><?php echo __('Actions'); ?></th>                                        
								</tr>
							</thead>
							<tbody id="sortable">
								<?php foreach ($homeSliders as $homeSlider): ?>
									<tr id="arrayorder_<?php echo $homeSlider['HomeSlider']['id']; ?>" class="parent-element">
										<td style="vertical-align: middle;"><i class="fa fa-list sort-handle"></i></td>
										<td class="image">
											<?php 
												if (file_exists($directorySm.$homeSlider['HomeSlider']['image_path']) && is_file($directorySm .$homeSlider['HomeSlider']['image_path'])) { 	
													echo $this->Html->image('uploads/HomeSlider/small/'. $homeSlider['HomeSlider']['image_path'], array('alt' => 'image','fullBase' => true));   
												} else {
													echo $this->Html->image('no-img-available.png', array('alt' => 'no image available','fullBase' => true));
												}
											?>	
										</td>
										<td class="hidden-md hidden-sm hidden-xs"><?php echo h($homeSlider['HomeSlider']['slogan']); ?>&nbsp;</td>

										<td>
											<a  data-toggle="tooltip" title="<?php echo  __('Unpublush this image');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($homeSlider['HomeSlider']['id']); ?>',0); return false;" id="status_allowed_<?php echo h($homeSlider['HomeSlider']['id']); ?>" <?php if ($homeSlider['HomeSlider']['status'] == 0){ ?> style="display: none;" <?php } ?>>
												<span class="label label-success"><?php echo __('Published'); ?></span>
											</a>
											<a  data-toggle="tooltip" title="<?php echo  __('Publish this image');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($homeSlider['HomeSlider']['id']); ?>',1); return false;"  id="status_denied_<?php echo h($homeSlider['HomeSlider']['id']); ?>" <?php if ($homeSlider['HomeSlider']['status'] == 1){ ?> style="display: none;" <?php } ?>>
												<span class="label label-danger"><?php echo __('Unpublished'); ?></span>
											</a>
										</td>

										<td class="actions">
											<div data-toggle="tooltip" title="<?php echo __('Edit image');?>">
												<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')),array('admin'=>true,'controller'=>'home_sliders','action' => 'edit', $homeSlider['HomeSlider']['id']),array('escape' => false, 'class'=>'btn btn-info btn-sm')); 
												?>
											</div>

											<div data-toggle="tooltip" title="<?php echo __('Delete image');?>">
												<?php
													$var = '';
													$elementId = (int)h($homeSlider['HomeSlider']['id']);
													echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-times')), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}', this); return false;", 'class'=>'btn btn-danger btn-sm', 'id'=>'element_'.$elementId, 'data-model'=>$current_model, 'data-controller'=>$current_controller));
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
	</div>
	<?php echo $this->element('Pagination/counter'); ?>
	<?php echo $this->element('Pagination/navigation'); ?>
<?php
$this->Html->scriptBlock("
	$(document).ready(function() {
		$(function() {
			$('#sortable').sortable({
				opacity: 0.8, 
				cursor: 'move',
				revert: true,
				handle: '.sort-handle',
				axis: 'y',
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
					$.post('".Router::Url(array('admin' => true, 'controller' => 'home_sliders','action' => 'sort'), true)."', order, function(data, textStatus, xhr) {
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
	});
", array('block' => 'scriptBottom'));
?>

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
			var model = __this.attr('data-model'),
				controller = __this.attr('data-controller');
			$.ajax({
				// url: baseURL + '/admin/' + controller + '/delete/' + id,
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'home_sliders','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				dataType: 'json',
				data:{data:{HomeSlider:{id:id,image_path:name}}},
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
			url:'<?php echo Router::url(array('controller' => 'home_sliders','action' => 'changeStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{HomeSlider:{id:data_id,status:data_status}}},
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
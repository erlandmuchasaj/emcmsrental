<?php
	$current_model = Inflector::classify($this->params['controller']);
	$current_controller = $this->params['controller'];
	$current_action 	= $this->params['action'];
	$directorySm = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Banner'. DS;
?>
	<div class="row" id="elementToMask">
		<div class="col-sm-12">
			
			<div class="row">
				<div class="col-sm-3 pull-left">
					<?php
						$default_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
						if ($this->Session->check('per_page_count')) { 
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

			<div class="panel panel-em">
				<header class="panel-heading">
					<?php echo $this->Html->tag('h4',__('Banners'),array('class' => 'display-inline-block')) ?>
					<span class="tools pull-right panel-heading-actions">
						<?php
							echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')).'&nbsp;'.__('New Banner'),array('admin'=>true, 'controller' => 'site_settings', 'action' => 'addBanner'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
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
									<th class="hidden-md hidden-sm hidden-xs"><?php echo $this->Paginator->sort('title',__('Title')); ?></th>
									<th><?php echo $this->Paginator->sort('status', __('Status')); ?></th>
									<th><?php echo __('Actions'); ?></th>                                        
								</tr>
							</thead>
							<tbody id="sortable">
								<?php foreach ($banners as $banner): ?>
									<tr id="arrayorder_<?php echo $banner['Banner']['id']; ?>" class="parent-element">
										<td style="vertical-align: middle;"><i class="fa fa-list sort-handle"></i></td>
										<td class="image">
											<?php 
												if (file_exists($directorySm.$banner['Banner']['image_path']) && is_file($directorySm .$banner['Banner']['image_path'])) { 	
													echo $this->Html->image('uploads/Banner/'. $banner['Banner']['image_path'], array('alt' => 'image','fullBase' => true));   
												} else {
													echo $this->Html->image('no-img-available.png', array('alt' => 'no image available','fullBase' => true));
												}
											?>	
										</td>
										<td class="hidden-md hidden-sm hidden-xs"><?php echo h($banner['Banner']['title']); ?>&nbsp;</td>

										<td>
											<a  data-toggle="tooltip" title="<?php echo  __('Unpublush this image');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($banner['Banner']['id']); ?>',0); return false;" id="status_allowed_<?php echo h($banner['Banner']['id']); ?>" <?php if ($banner['Banner']['status'] == 0){ ?> style="display: none;" <?php } ?>>
												<span class="label label-success"><?php echo __('Published'); ?></span>
											</a>
											<a  data-toggle="tooltip" title="<?php echo  __('Publish this image');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($banner['Banner']['id']); ?>',1); return false;"  id="status_denied_<?php echo h($banner['Banner']['id']); ?>" <?php if ($banner['Banner']['status'] == 1){ ?> style="display: none;" <?php } ?>>
												<span class="label label-danger"><?php echo __('Unpublished'); ?></span>
											</a>
										</td>

										<td class="actions">
											<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')),array('admin'=>true,'controller'=>'site_settings','action' => 'editBanner', $banner['Banner']['id']),array('escape' => false, 'class'=>'btn btn-info btn-sm')); ?>

											<?php 
												echo $this->Form->postLink('<i class="fa fa-trash-o"></i>',
													array('action' => 'deleteBanner', $banner['Banner']['id']),
													array(
														'class' => 'btn btn-danger',
														'escape' => false,
														'alt' => __('Delete'),
														'title' => __('Delete'),
														'confirm' => __('Are you sure you want to delete the banner %s?', $banner['Banner']['title'])
													)
												);
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
					$.post('".Router::Url(array('admin' => true, 'controller' => 'site_settings','action' => 'sortBanner'), true)."', order, function(data, textStatus, xhr) {
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
			url:'<?php echo Router::url(array('controller' => 'site_settings','action' => 'changeBannerStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{Banner:{id:data_id,status:data_status}}},
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
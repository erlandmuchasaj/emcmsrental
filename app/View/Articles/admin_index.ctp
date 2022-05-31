<?php
	$directorySmURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Article'. DS.'small'.DS;
	$directorySmPATH = 'uploads/Article/small/';
?>
<div class="well">
	<?php echo $this->Form->create('Article', array('url'  => array('admin'=>true,'controller' => 'articles','action' => 'index'), ));?>
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
				echo $this->Html->link(__('Reset'), array('action' => 'index')); 
			endif; 
		echo $this->Form->end();
	?>
</div>
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
			<div  class="panel panel-em">
				<header class="panel-heading">
					<?php echo $this->Html->tag('h4',__('Articles'),array('class' => 'display-inline-block')) ?>
					<span class="tools pull-right">
						<?php
							echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus')).'&nbsp;'.__('New Article'),array('admin'=>true, 'controller' => 'articles', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
						?>
					</span>
				</header>
				<div class="panel-body event-table">
					<table class="table general-table">
						<thead>
							<tr>
								<th class="image">
								<?php echo $this->Paginator->sort('featured_image','<i class="fa fa-sort"></i>&nbsp;Image', array('escape' => false)); ?>
								</th>
								<th><?php echo $this->Paginator->sort('is_featured','Featured'); ?></th>
								<th><?php echo $this->Paginator->sort('title'); ?></th>
								<th><?php echo $this->Paginator->sort('category_id'); ?></th>
								<th class="hidden-sm hidden-xs"><?php echo $this->Paginator->sort('summary'); ?></th>
								<th><?php echo $this->Paginator->sort('status'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody  id="sortable">
							<?php foreach ($articles as $article): ?>
							<tr id="arrayorder_<?php echo $article['Article']['id']; ?>" class="parent-element">
								<td data-th="<?php echo __('Image');?>" class="sort-handle image">
									<?php 
										if (file_exists($directorySmURL.$article['Article']['featured_image']) && is_file($directorySmURL .$article['Article']['featured_image'])) {
											$base64 = $directorySmPATH.$article['Article']['featured_image'];
											echo $this->Html->image($base64, array('alt' => 'featured_image')); 
										} else {
											$base64 = 'placeholder.png';
											echo $this->Html->image($base64, array('alt' => 'featured_image'));
										}
									?>							
								</td>

								<td data-th="<?php echo __('Feature');?>">
									<a  data-toggle="tooltip" title="<?php echo  __('Unfeature this Article');?>" href="javascript:void(0);" onclick="changeStatusFeature(this,'<?php echo h($article['Article']['id']); ?>',0); return false;" id="status_feature_<?php echo h($article['Article']['id']); ?>" <?php if ($article['Article']['is_featured'] == 0){ ?> style="display: none;" <?php } ?>>
										<i class="fa fa-check fa-2x" style="color: #95b75d;"></i>
									</a>
									<a  data-toggle="tooltip" title="<?php echo  __('Feature this Article');?>" href="javascript:void(0);" onclick="changeStatusFeature(this,'<?php echo h($article['Article']['id']); ?>',1); return false;" id="status_unfeature_<?php echo h($article['Article']['id']); ?>" <?php if ($article['Article']['is_featured'] == 1){ ?> style="display: none;" <?php } ?>>
										<i class="fa fa-ban fa-2x" style="color: #ed1e6f;"></i>
									</a>
								</td>

								<td data-th="<?php echo __('Title');?>">
									<?php 
										echo getDescriptionHtml(h($article['Article']['title']));
									?>
								</td>

								<td data-th="<?php echo __('Category');?>">
									<?php 
										echo $this->Html->link($article['Category']['name'], array('controller' => 'categories', 'action' => 'view', $article['Category']['id'])); 
									?>
								</td>

								<td class="hidden-sm hidden-xs" style="width: 25%;">
									<?php echo getDescriptionHtml(h($article['Article']['summary'])); ?>
								</td>
							
								<td>
									<a  data-toggle="tooltip" title="<?php echo  __('Unpublish this Article');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($article['Article']['id']); ?>',0); return false;" id="status_allowed_<?php echo h($article['Article']['id']); ?>" <?php if ($article['Article']['status'] == 0){ ?> style="display: none;" <?php } ?>>
										<span class="label label-success"><?php echo __('Published'); ?></span>
									</a>
									<a  data-toggle="tooltip" title="<?php echo  __('Publish this Article');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($article['Article']['id']); ?>',1); return false;" id="status_denied_<?php echo h($article['Article']['id']); ?>" <?php if ($article['Article']['status'] == 1){ ?> style="display: none;" <?php } ?>>
										<span class="label label-danger"><?php echo __('Unpublished'); ?></span>
									</a>
								</td>

								<td class="actions">
									<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-info')).'&nbsp;'.__('View'), array('action' => 'view', $article['Article']['id']),array('class'=>'btn btn-info btn-sm','escape'=>false)); ?>

									<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-edit')).'&nbsp;'. __('Edit'), array('action' => 'edit', $article['Article']['id']),array('class'=>'btn btn-default btn-sm','escape'=>false)); ?>

									<?php 
										$var = h(addslashes($article['Article']['title']));
										$elementId = (int)$article['Article']['id'];
										echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-close')).'&nbsp;'. __('Delete'), 'javascript:void(0);',array('class'=>'btn btn-danger btn-sm','escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}'); return false;", 'id'=>'element_'.$elementId));
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
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'articles','action' => 'delete')); ?>/'+ id,
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
			url:'<?php echo Router::url(array('controller' => 'articles','action' => 'changeStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{Article:{id:data_id,status:data_status}}},
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

/**
 * [changeStatusFeature description]
 * @param  {[$this]} obj         [description]
 * @param  {[INT]} data_id     [description]
 * @param  {[INT]} data_status [description]
 * @return {[OBJ]}             [description]
 */
	function changeStatusFeature(obj,data_id,data_status){
		var $elementToMask = $('#elementToMask');
		if (data_status == undefined){
			data_status = 0;
		}
		$.ajax({
			url:'<?php echo Router::url(array('controller' => 'articles','action' => 'changeFeatureStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{Article:{id:data_id,is_featured:data_status}}},
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
							$('#status_feature_'+data_id).hide();
							$('#status_unfeature_'+data_id).fadeIn('slow');
						}else{
							$('#status_feature_'+data_id).fadeIn('slow');
							$('#status_unfeature_'+data_id).hide();
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
					$.post('".Router::Url(array('admin' => true, 'controller' => 'articles','action' => 'sort'), true)."', order, function(data, textStatus, xhr) {
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

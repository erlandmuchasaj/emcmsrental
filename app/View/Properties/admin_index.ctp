<?php
	/*This css is applied only to this page*/
	echo $this->Html->css('common/owl-carousel/owl.carousel.min', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('common/calendar/jquery.dop.FrontendBookingCalendarPRO', null, array('block'=>'cssMiddle'));
?>
<div class="well">
	<?php echo $this->Form->create('Property', array('url'  => array('admin'=>true,'controller' => 'properties','action' => 'index'), ));?>
		<fieldset class="form-group">
			<div class="input-group custom-search-form">
				<?php if (!empty($search)) : ?>
					<?php echo $this->Form->input('search', array('class' => 'form-control', 'label' => false, 'div' => false, 'value' => $search));?>
				<?php else :
					echo $this->Form->input('search',
							array('type' => 'text',
								'class' => 'form-control',
								'placeholder' => __('Search...'),
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
		<?php
			if (!empty($search)) :
				echo $this->Html->link(__('Reset'), array('action' => 'index'));
			endif;
		echo $this->Form->end();
	?>
</div>

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

<div class="row" id="elementToMask">
	<div class="col-sm-12">
		<div class="panel panel-em">
			<header class="panel-heading">
				<?php echo $this->Html->tag('h4',__('Properties'),array('class' => 'display-inline-block')) ?>
				<span class="tools pull-right">
				<?php
					echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus')).'&nbsp;'.__('New Property'),array('admin'=>false, 'controller' => 'properties', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm'));
				?>
				</span>
			</header>
			<div class="panel-body">
				<div class="event-table">
					<table class="table">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('thumbnail'); ?></th>
								<th class="hidden-md hidden-sm hidden-xs"><?php echo __('Owner'); ?></th>
								<th class="hidden-md hidden-sm hidden-xs"><?php echo $this->Paginator->sort('title'); ?></th>
								<th><?php echo $this->Paginator->sort('address'); ?></th>
								<th><?php echo $this->Paginator->sort('status', 'status'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody id="sortable">
							<?php foreach ($properties as $property):
								$elementId = (int)$property['Property']['id'];
								$directorySmURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Property'.DS.$elementId.DS.'PropertyPicture'.DS.'small'.DS;
								$directorySmPATH = 'uploads/Property/'.$elementId.'/PropertyPicture/small/';
								?>
								<tr id="arrayorder_<?php echo $elementId; ?>" class="OrderingField parent-element">
									<td data-th="<?php echo __('Thumbnail');?>" class="sort-handle image">
										<?php
											$base64 = 'placeholder.png';
											if (file_exists($directorySmURL.$property['Property']['thumbnail']) && is_file($directorySmURL .$property['Property']['thumbnail'])) {
												$base64 = $directorySmPATH . $property['Property']['thumbnail'];
											}
											$img = $this->Html->image($base64, array('alt' => 'thumbnail', 'class'=>'img-responsive'));

											$type = EMCMS_ucfirst($property['Property']['contract_type']);
											$label = ($property['Property']['contract_type'] === 'rent') ? 'label-success' : 'label-primary';
											$is_featured = $property['Property']['is_featured'] ? "checked='checked'" : '';
											// property type

											$tag ='<input class="change-feature" type="checkbox" name="data[\'Property\'][\'is_featured\']" data-property-id="'.$elementId.'" '.$is_featured.' >';

											// $tag = $this->Form->input('Property.is_featured', ['type'=>'checkbox','label'=>false, 'div'=>false, 'class'=>'change-feature', 'data-property-id'=>$elementId, $is_featured], ['escape'=>false]);

											echo $this->Html->tag('div', $img . $tag . $this->Html->tag('span', h($type), array('class' => "label payed-badge {$label}"))
												, array('style' => 'position: relative; display: inline-block;'));
										?>
									</td>
									<?php
										$title = "";
										if (isset($property['PropertyTranslation']['title'])) {
											$title = $property['PropertyTranslation']['title'];
										}
									?>
									<td class="hidden-md hidden-sm hidden-xs"><?php echo h($property['User']['name']. ' ' . $property['User']['surname']); ?></td>
									<td class="hidden-md hidden-sm hidden-xs"><?php echo getDescriptionHtml($title); ?></td>
									<td data-th="<?php echo __('Address');?>"><?php echo h($property['Property']['address']); ?></td>
									<td data-th="<?php echo __('Status');?>">
										<a data-toggle="tooltip" title="<?php echo  __('Click to unpublish this property');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo $elementId; ?>',0); return false;" id="status_allowed_<?php echo $elementId; ?>" <?php if ($property['Property']['status'] == 0){ ?> style="display: none;" <?php } ?>>
											<span class="label label-success"><?php echo __('Published');?></span>
										</a>
										<a data-toggle="tooltip" title="<?php echo  __('Click to publish this property');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo $elementId; ?>',1); return false;" id="status_denied_<?php echo $elementId; ?>" <?php if ($property['Property']['status'] == 1){ ?> style="display: none;" <?php } ?>>
											<span class="label label-danger"><?php echo __('Unpublished');?></span>
										</a>
									</td>
									<td class="actions">
										<div class="btn-group">
											<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo __('Actions');?>
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu dropdown-menu-right" role="menu">
												<li>
													<?php
														echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa  fa-edit')).'&nbsp;'.__('Edit'), array('admin'=>true,'controller'=>'properties','action' => 'edit', $elementId),array('escape' => false));
													?>
												</li>
												<li>
													<?php
														echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View'),'#view_property_modal',array('escape' => false, 'data-property-id'=>$elementId, 'class'=>'view-modal'));
													?>
												</li>
												<li class="divider"></li>
												<li data-toggle="tooltip" title="Preview on front-end">
													<?php
														echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa  fa-globe')).'&nbsp;'.__('Preview'), array('admin'=>false,'controller'=>'properties','action' => 'view', $elementId ,'?'=> array('preview' => 1, 'property_owner'=>$property['Property']['user_id'])), array('target'=>'_blank','escape' => false));
													?>
												</li>
												<!-- 
												<li>
													<?php
														// echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-file-text')).'&nbsp;'.__('Leave Review'), array('admin'=>true,'controller'=>'reviews','action' => 'add', $elementId, '?'=> array('property_id' =>  $elementId)), array('escape' => false));
													?>
												</li> 
												-->
												<li class="divider"></li>
												<li>
													<?php
														$var = h(addslashes($property['Property']['address']));
														echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-times')).'&nbsp;'.__('Delete'), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}', this); return false;",'id'=>'element_'.$elementId));
													?>
												</li>
											</ul>
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

<!-- pagination START -->
<div class="row">
	<div class="col-xs-12">
		<?php echo $this->element('Pagination/counter'); ?>
		<?php echo $this->element('Pagination/navigation'); ?>
	</div>
</div>

<div id="view_property_modal" class="modal fade" tabindex="-1" role="dialog"  aria-labelledby="viewPropertyModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="viewPropertyModalLabel"><i class="fa fa-info"></i>&nbsp;<?php echo __('Property'); ?></h4>
			</div>
			<div class="modal-body">
				<div id="modal_content"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
			</div>
		</div>
	</div>
</div>

<?php
echo $this->Html->script('//maps.googleapis.com/maps/api/js?key='.Configure::read('Google.key'), array('block'=>'scriptBottomMiddle'));
echo $this->Html->script("common/owl-carousel/dist/owl.carousel.min", array('block' => 'scriptBottomMiddle'));
echo $this->Html->script("common/calendar/jquery.dop.FrontendBookingCalendarPRO", array('block' => 'scriptBottomMiddle'));
$this->Html->scriptBlock("
(function($){
	$(document).ready(function() {
		'use strict';
		// BEGIN AJAX SORTING
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
				$.post(fullBaseUrl+'/admin/properties/sort', order, function(data, textStatus, xhr) {
					if (textStatus == 'success') {
						/*
						* // this verison is used when we specify the returned data type
						* var response = $.parseJSON(JSON.stringify(data));
						*/
						var response = $.parseJSON(data);
						if (!response.error) {
							toastr.success(response.message,'Success.');
						}
					} else {
						toastr.warning(textStatus, 'Warning');
					}
				});
			}
		});

		// BEGIN CHECKBOX AJAX FEATURE FUNCTION
		$('.change-feature').on('change', function(e) {
			var ischecked = $(this).is(':checked'),
				property_id = $(this).attr('data-property-id');
			$.ajax({
				url: fullBaseUrl+'/admin/properties/featured/'+property_id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Property:{id:property_id,is_featured:ischecked}}},
				success:function(data, textStatus, xhr){
					//called when successful
					if (textStatus =='success') {
						var response = $.parseJSON(JSON.stringify(data));
						if (!response.error) {
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
				},
				error: function(xhr, textStatus, errorThrown) {
					//called when there is an error
					var message = '';
					if(xhr.responseJSON.hasOwnProperty('message')){
						//do struff
						message = xhr.responseJSON.message;
					}
					toastr.error(errorThrown+':&nbsp;'+message, textStatus);
				}
			});
			e.preventDefault();
			return true;
		});

		var modalContent = $('#modal_content');
		$('#sortable').on('click', '.view-modal', function(e){
			e.preventDefault();
			var _this = $(this);
			var property_id = _this.attr('data-property-id');
			$.ajax({
				url: fullBaseUrl+'/admin/properties/view/'+property_id,
				type: 'get',
				data: 'action=get_view',
				beforeSend: function() {
					modalContent.mask('Waiting...');
				},
				success:function(response, status, xhr ){
					if (status=='error') {
						toastr.error(response,'Error!');
					} else {
						$('#view_property_modal').modal('show');
						modalContent.html(response);
					}
				},
				complete: function(xhr, textStatus) {
					//called when complete
					modalContent.unmask();
				},
				error: function(xhr, textStatus, errorThrown) {
					//called when there is an error
					modalContent.unmask();
					toastr.error(errorThrown, 'Error!');
				}
			});
			return false;
		});

		$('#view_property_modal').on('hidden.bs.modal', function (e) {
			modalContent.html('');
		});
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
		$('#lblMsgConfirmYesNo').html('Are you sure you want to delete: <b>' + name + '</b>?');
		$('#btnYesConfirmYesNo').off('click').on('click', function() {
			$.ajax({
				url: fullBaseUrl + '/admin/properties/delete/'+ id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Property:{id:id,address:name}}},
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
					$confirmModal.modal('hide');
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
			url: fullBaseUrl + '/admin/properties/changeStatus',
			type: 'POST',
			dataType: 'json',
			data:{data:{Property:{id:data_id,status:data_status}}},
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

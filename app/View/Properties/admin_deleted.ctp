<?php
	/*This css is applied only to this page*/
	echo $this->Html->css('common/owl-carousel/owl.carousel.min', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('common/calendar/jquery.dop.FrontendBookingCalendarPRO', null, array('block'=>'cssMiddle'));
?>
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
				<?php echo $this->Html->tag('h4',__('Deleted Properties'),array('class' => 'display-inline-block')) ?>
			</header>
			<div class="panel-body">
				<div class="event-table">
					<table class="table">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('thumbnail'); ?></th>
								<th><?php echo __('Owner'); ?></th>
								<th><?php echo $this->Paginator->sort('address'); ?></th>
								<th><?php echo $this->Paginator->sort('deleted'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody id="sortable">
							<?php foreach ($properties as $property):
								$elementId = (int)$property['Property']['id'];
								$directorySmURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Property'.DS.$elementId.DS.'PropertyPicture'.DS.'small'.DS;
								$directorySmPATH = 'uploads/Property/'.$elementId.'/PropertyPicture/small/';
								?>
								<tr id="arrayorder_<?php echo $elementId; ?>" class="parent-element">
									<td data-th="<?php echo __('Thumbnail');?>" class="sort-handle image">
										<?php
											$base64 = 'placeholder.png';
											if (file_exists($directorySmURL.$property['Property']['thumbnail']) && is_file($directorySmURL .$property['Property']['thumbnail'])) {
												$base64 = $directorySmPATH . $property['Property']['thumbnail'];
											}

											$img = $this->Html->image($base64, array('alt' => 'thumbnail', 'class'=>'img-responsive'));
											$type = EMCMS_ucfirst($property['Property']['contract_type']);
											echo $this->Html->tag('div', $img . $this->Html->tag('span', h($type), array('class' => 'badge label-success payed-badge'))
												, array('style' => 'position: relative; display: inline-block;'));
										?>
									</td>
									<td data-th="<?php echo __('Owner');?>"><?php echo h($property['User']['name'].' '.$property['User']['surname']); ?></td>
									<td data-th="<?php echo __('Address');?>"><?php echo h($property['Property']['address']); ?></td>
									<td data-th="<?php echo __('Deleted');?>"><?php echo $this->Time->nice($property['Property']['deleted']); ?></td>
									<td class="actions">
										<?php
											echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View'),'#view_property_modal',array('escape' => false, 'data-property-id'=>$elementId, 'class'=>'view-modal label label-info'));
										?>
										&nbsp;
										<?php
											$var = h(addslashes($property['Property']['address']));
											echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-times')).'&nbsp;'.__('Delete'), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}', this); return false;",'id'=>'element_'.$elementId, 'class'=>'label label-danger'));
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
				<h4 class="modal-title" id="viewPropertyModalLabel"><i class="ico-info"></i>&nbsp;<?php echo __('Property'); ?></h4>
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
// echo $this->Html->script("calendar/jquery.dop.FrontendBookingCalendarPRO", array('block' => 'scriptBottomMiddle'));
$this->Html->scriptBlock("
(function($){
	$(document).ready(function() {
		'use strict';
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
		$('#lblMsgConfirmYesNo').html('<?php echo __('Are you sure you want to permanently delete'); ?>: <b>' + name + '</b>?');
		$('#btnYesConfirmYesNo').off('click').on('click', function() {
			$.ajax({
				url:'<?php echo Router::url(array('admin' => true, 'controller' => 'properties', 'action' => 'deletPermanent')); ?>/'+ id,
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
</script>

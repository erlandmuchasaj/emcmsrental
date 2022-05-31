<?php
	/*This css is applied only to this page*/
	// echo $this->Html->css('common/animate', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('common/owl-carousel/owl.carousel.min', null, array('block'=>'cssMiddle'));
?>
<div class="em-container make-top-spacing">
	<div class="row" id="elementToMask">
		<div class="col-lg-3 col-md-4 user-sidebar">
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8">
			<div class="well">
				<?php echo $this->Form->create('Reservation', array('url'  => array('controller' => 'reservations', 'action' => 'index')));?>
				<fieldset class="form-group">
					<div class="input-group">
						<?php if (!empty($search)) : ?>
							<?php echo $this->Form->input('search', array('class' => 'form-control', 'label' => false, 'div' => false, 'value' => $search));?>
						<?php else:
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
			<div class="panel panel-em no-border">
				<header class="panel-heading clearfix">
					<?php echo $this->Html->tag('h4', __('Reservations'), ['class'=>'display-inline-block'])?>
					<div class="pull-right">
						<?php
							$default_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
							if($this->Session->check('per_page_count')) {
								$default_count = $this->Session->read('per_page_count');
							}
						?>
						<select id="per_page_count" class="form-control ">
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
				</header>
				<div class="event-table">
					<table class="table general-table">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('reservation_status'); ?></th>
								<th><?php echo __('Date, Times and location'); ?></th>
								<th><?php echo $this->Paginator->sort('user_to', __('Host')); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($reservations as $reservation):
								$elementId = (int)$reservation['Reservation']['id'];
							?>
							<tr class="parent-element">
								<td data-th="<?php echo __('Status');?>"><?php echo Inflector::humanize($reservation['Reservation']['reservation_status']);?></td>
								<td data-th="<?php echo __('Details');?>"><?php echo h($reservation['Property']['address']);?></td>
								<td data-th="<?php echo __('Host');?>" class="image">
								<?php echo h('');?>
								<?php
									echo $this->Html->link($this->Html->displayUserAvatar($reservation['Host']['image_path']),array('controller' => 'users', 'action' => 'view', $reservation['Host']['id']), array('escape' => false, 'class'=>'user-avatar'));
								?>
								</td>
								<td class="actions">
									<div class="btn-group">
										<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo __('Actions');?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right" role="menu">
											<li>
												<?php
													echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa  fa-edit')).'&nbsp;'.__('Edit'), array('controller'=>'properties','action' => 'edit', $elementId),array('escape' => false));
												?>
											</li>
											<li>
												<?php
													echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View'),'#view_property_modal',array('escape' => false, 'data-property-id'=>$elementId, 'class'=>'view-modal'));
												?>
											</li>
											<li class="divider"></li>
											<li>
												<?php
													$var = '';
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
			<!-- pagination START -->
			<?php echo $this->element('Pagination/counter'); ?>
			<?php echo $this->element('Pagination/navigation'); ?>
		</div>
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
echo $this->Html->script("common/owl-carousel/dist/owl.carousel.min", array('block' => 'scriptBottomMiddle'));
$this->Html->scriptBlock("
	(function($){
		$(document).ready(function() {
			'use strict';
			var modalContent = $('#modal_content');
			$('#elementToMask').on('click', '.view-modal', function(e){
				e.preventDefault();
				var _this = $(this);
				var property_id = _this.attr('data-property-id');
				$.ajax({
					url: fullBaseUrl+'/properties/ajax_preview/'+property_id,
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
		$('#lblMsgConfirmYesNo').html('Are you sure you want to delete <b>' + name + '</b>?');
		$('#btnYesConfirmYesNo').off('click').on('click', function() {
			$.ajax({
				url: fullBaseUrl+'/properties/delete/'+id,
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
			url: fullBaseUrl+'/properties/changeStatus',
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
				if (xhr.responseJSON.hasOwnProperty('message')){
					//do struff
					message = xhr.responseJSON.message;
				}
				$elementToMask.unmask();
				toastr.error(errorThrown+":&nbsp;"+message, textStatus);
			}
		});
	}
</script>

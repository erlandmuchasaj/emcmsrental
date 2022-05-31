	<div class="row" id="elementToMask">
		<div class="col-sm-12">
			<div class="panel panel-em">
				<header class="panel-heading">
					<?php echo $this->Html->tag('h4',__('Faqs'),array('class' => 'display-inline-block')) ?>
					<span class="tools pull-right">
						<?php
							echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')).'&nbsp;'.__('New FAQ-s'),array('admin'=>true, 'controller' => 'faqs', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
						?>
					 </span>
				</header>
				<div class="panel-body">
					<!--collapse start-->
					<div class="panel-group" id="sortable">
						<?php foreach ($faqs as $faq): ?>
							<div id="arrayorder_<?php echo $faq['Faq']['id']; ?>" class="panel panel-info parent-element clearfix">
								<div class="panel-heading">
									<h4 class="faq-title">&nbsp;<i class="fa fa-align-justify sort-handle"></i>&nbsp;
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#sortable" href="#collapse_faq_<?php echo h($faq['Faq']['id']); ?>">
										  <?php echo h($faq['Faq']['question']); ?>&nbsp;<i class="fa fa-question"></i>&nbsp;
										</a>
									</h4>
									<div class="pull-right faq-actions">
										<span data-toggle="tooltip" title="<?php echo __('Edit question');?>">
											<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')),array('admin'=>true,'controller'=>'faqs','action' => 'edit', $faq['Faq']['id']),array('escape' => false, 'class'=>'btn btn-info btn-sm')); 
											?>
										</span>

										<span data-toggle="tooltip" title="<?php echo __('Delete question');?>">
											<?php
												$var = h(addslashes($faq['Faq']['question']));
												$elementId = (int)h($faq['Faq']['id']);
												echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-times')), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}'); return false;", 'class'=>'btn btn-danger btn-sm', 'id'=>'element_'.$elementId));
											?>
										</span>



										<a  data-toggle="tooltip" title="<?php echo  __('Unpublush this Question');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($faq['Faq']['id']); ?>',0); return false;" class='btn btn-warning btn-sm'  id="status_allowed_<?php echo h($faq['Faq']['id']); ?>" <?php if ($faq['Faq']['status'] == 0){ ?> style="display: none;" <?php } ?>>
											<i class="fa fa-check-square-o"></i>
										</a>
										<a  data-toggle="tooltip" title="<?php echo  __('Publish this Question');?>" href="javascript:void(0);" onclick="changeStatus(this,'<?php echo h($faq['Faq']['id']); ?>',1); return false;" class='btn btn-warning btn-sm'  id="status_denied_<?php echo h($faq['Faq']['id']); ?>" <?php if ($faq['Faq']['status'] == 1){ ?> style="display: none;" <?php } ?>>
											<i class="fa fa-minus-square-o"></i>
										</a>

									</div>	
								</div>
								<div id="collapse_faq_<?php echo h($faq['Faq']['id']); ?>" class="panel-collapse collapse">
									<div class="panel-body">
										<h6><i class="fa fa-comment"></i>&nbsp; <?php echo __('Answer'); ?></h6>
										<div class="contact-message">
											<?php echo htmlspecialchars_decode(stripslashes($faq['Faq']['answer']));?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<!--collapse end-->
				</div>
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
					axis: 'y',  //Optional
					/* scroll: false,*/
					/* cursorAt: { left: 5 },*/ 
					/* distance: 1,*/
					/* delay: 150,*/
					/* placeholder: 'sortable-placeholder',*/
					/* connectWith: '.panel',*/
					/* items: '.panel',*/
					/* coneHelperSize: true,*/
					/* forcePlaceholderSize: true,*/
					/* tolerance: 'pointer'*/
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
						$.post('".Router::Url(array('admin' => true, 'controller' => 'faqs','action' => 'sort'), true)."', order, function(data, textStatus, xhr) {
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
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'faqs','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Faq:{id:id,question:name}}},
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
			url:'<?php echo Router::url(array('controller' => 'faqs','action' => 'changeStatus')); ?>',
			type: 'POST',
			dataType: 'json',
			data:{data:{Faq:{id:data_id,status:data_status}}},
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
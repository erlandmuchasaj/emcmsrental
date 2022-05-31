<!--
/*
* $message['Message']['message_type']
* 1- 'Reservation Request', 'trips/request'			=> reservation_request
* 2- 'Conversation', 'trips/conversation'			=> conversation
* 3- 'Message', 'trips/conversation'				=> message
* 4- 'Review Request', 'trips/review_by_host'		=> review_by_host
* 5- 'Review Request', 'trips/review_by_traveller'  => review_by_traveller
* 6- 'Inquiry', 'trips/conversation' 				=> inquiry
* 7- 'Contacts Request', 'contacts/request'			=> contact_request
* 8- 'Contacts Response', 'contacts/response'		=> contact_response
* 9- 'Referrals', 'trips/conversation'				=> referrals
* 10- 'List Creation', 'trips/conversation'			=> list_creation
* 11- 'List Edited', 'trips/conversation'			=> list_edited
* 12- 'Request Sent', 'trips/request_sent'			=> request_sent
*/
-->
<?php
	/*This css is applied only to this page*/
	echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
	// debug($messages);
?>
<div class="em-container make-top-spacing">
	<div class="row" id="elementToMask">
		<div class="col-lg-3 col-md-4 hidden-sm hidden-xs user-sidebar">
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8">
			<div class="panel panel-em no-border panel-table">
				<header class="panel-heading clearfix">
					<?php echo $this->Html->tag('h4', __('Messages'), ['class' => 'display-inline-block']); ?>
					<div class="pull-right">
						<?php
							$default_count = isset($this->request->pass[0]) ? $this->request->pass[0] : 'all';
						?>
						<select id="message_filter" class="form-control">
							<option value="all" <?php echo ($default_count === 'all') ? 'selected' : '' ; ?>><?php echo __('All Messages'); ?></option>
							<option value="starred" <?php echo ($default_count === 'starred') ? 'selected' : '' ; ?>><?php echo __('Starred'); ?></option>
							<option value="unread" <?php echo ($default_count === 'unread') ? 'selected' : '' ; ?>><?php echo __('Unread'); ?></option>
							<option value="never_responded" <?php echo ($default_count === 'never_responded') ? 'selected' : '' ; ?>><?php echo __('Never Responded'); ?></option>
							<option value="reservations" <?php echo ($default_count === 'reservations') ? 'selected' : '' ; ?>><?php echo __('Reservations'); ?></option>
							<option value="archived" <?php echo ($default_count === 'archived') ? 'selected' : '' ; ?>><?php echo __('Archived'); ?></option>
						</select>
					</div>
				</header>
				<?php if (isset($messages) && !empty($messages)){ ?>
				<?php // debug($messages); ?>
					<div class="event-table">
						<table class="table general-table">
							<thead>
								<tr>
									<th data-label="<?php echo __('thumbnail');?>">
										<?php echo __('thumbnail'); ?>
									</th>
									<th data-label="<?php echo __('Created');?>">
										<?php echo $this->Paginator->sort('created',__('Created')); ?>
									</th>
									<th data-label="<?php echo __('Subject');?>">
										<?php echo $this->Paginator->sort('subject',__('Subject')); ?>
									</th>
									<th class="actions">
										<?php echo __('Actions'); ?>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($messages as $message): ?>
									<?php
										if ($message['Message']['contact_id'] != 0) {
											$topay = '';
										} elseif ($message['Message']['reservation_id'] != 0 && !empty($message['Reservation'])) {
											$checkin  	= $message['Reservation']['checkin'];
											$checkout 	= $message['Reservation']['checkout'];
											$topay 	    = $message['Reservation']['to_pay'];
											$paid 		= $message['Reservation']['is_payed'];
											$hostpaid 	= $message['Reservation']['is_payed_host'];
											$guestpaid 	= $message['Reservation']['is_payed_guest'];
											$currency 	= $message['Reservation']['currency'];
										} else {
											$topay = '';
										}

										if ($message['Message']['conversation_id'] != 0) {
											$message_id = $message['Message']['conversation_id'];
											$reservation_id = $message['Message']['reservation_id'];
										} else {
											$message_id = $message['Message']['id'];
											$reservation_id = $message['Message']['reservation_id'];
										}

										if ($message_id == 0) {
											$message_id = $message['Message']['contact_id'];
										}

										$backfround_color = ($message['Message']['is_read']) ? '' : 'style="background:#FFFFD0;color:#00B0FF;"';
									?>
									<tr class="parent-element" <?php echo $backfround_color;?> >
										<td data-th="<?php echo __('Thumbnail');?>">
											<?php
												echo $this->Html->link(
													$this->Html->displayUserAvatar($message['UserBy']['image_path'], [
														'width' => 50,
														'height' => 50,
														'class' => 'media-round media-photo',
														'alt' => h($message['UserBy']['name']),
														'title' => h($message['UserBy']['name'])
													]),
													array('controller' => 'users', 'action' => 'view', $message['UserBy']['id']),
													array('escape' => false, 'class'=>'user-box-avatar')
												);
											?>
										</td>
										<td data-th="<?php echo __('Created');?>">

											<?php echo $this->Html->tag('div', h($message['UserBy']['name']), array('style' => 'position: relative; display: block;')); ?>
											<?php echo $this->Time->niceShort($message['Message']['created']); ?>
										</td>
										<td data-th="<?php echo __('Subject');?>">
										<?php
											$property_title = '';
											if (isset($message['Property']['PropertyTranslation']['title'])) {
												$property_title = h(substr($message['Property']['PropertyTranslation']['title'], 0, 32));
											}

											if ('inquiry' === $message['Message']['message_type']) {
												$subject = __('Inquiry about <b>%s</b>', $property_title);
												if ($message['Message']['is_read'] == 0) {
													echo '<strong>';
												}

												echo $this->Html->link($subject, array('controller'=>'messages', 'action' => 'conversation', $message_id), array('escape' => false, 'class'=>'view-details', "onmousedown"=>"javascript:is_read(".$message['Message']['id'].")"));

												if ($message['Message']['is_read'] == 0) {
													echo '</strong>';
												}

											} elseif ('conversation' === $message['Message']['message_type']) {
												$subject = __('Discuss about <b>%s</b>', $property_title);
												if ($message['Message']['is_read'] == 0) {
													echo '<strong>';
												}

												echo $this->Html->link($subject, array('controller'=>'messages','action' => 'conversation', $message_id),array('escape' => false, 'class'=>'view-details', "onmousedown"=>"javascript:is_read(".$message['Message']['id'].")"));

												if ($message['Message']['is_read'] == 0) {
													echo '</strong>';
												}

											} elseif ('referrals' === $message['Message']['message_type']) {
												if ($message['Message']['is_read'] == 0) {
													echo '<strong>';
												}

												echo $this->Html->link(h($message['Message']['subject']), array('controller'=>'messages', 'action' => 'conversation', $message_id),array('escape' => false, 'class'=>'view-details', "onmousedown"=>"javascript:is_read(".$message['Message']['id'].")"));

												if ($message['Message']['is_read'] == 0) {
													echo '</strong>';
												}

											} elseif (
												'reservation_request' === $message['Message']['message_type'] ||
												'request_sent' === $message['Message']['message_type']
											) {
												if ($message['Message']['is_read'] == 0) {
													echo '<strong>';
												}

												// $controller = 'reservations';
												$action = trim($message['Message']['message_type']);

												echo $this->Html->link(h($message['Message']['subject']), array('controller'=>'reservations', 'action' => $action, $reservation_id), array('escape' => false, 'class'=>'view-details', "onmousedown"=>"javascript:is_read(".$message['Message']['id'].")"));

												if ($message['Message']['is_read'] == 0) {
													echo '</strong>';
												}

												echo $this->Html->tag('div', $property_title);
												echo $this->Html->tag('p', '('.$message['Reservation']['checkin'] .' -- '.  $message['Reservation']['checkin'].')');

											} elseif (
												'review_by_host' === $message['Message']['message_type'] ||
												'review_by_traveller' === $message['Message']['message_type']
											) {
												if ($message['Message']['is_read'] == 0) {
													echo '<strong>';
												}

												$controller = 'reservations';
												$action = trim($message['Message']['message_type']);


												echo $this->Html->link(h($message['Message']['subject']), array('controller'=>'messages', 'action' => $action, $reservation_id), array('escape' => false, 'class'=>'view-details', "onmousedown"=>"javascript:is_read(".$message['Message']['id'].")"));

												if ($message['Message']['is_read'] == 0) {
													echo '</strong>';
												}


												echo $this->Html->tag('div', $property_title);
												echo $this->Html->tag('p', '('.$message['Reservation']['checkin'] .' -- '.  $message['Reservation']['checkin'].')');

											} elseif ('list_creation' === $message['Message']['message_type']) {
												if ($message['Message']['is_read'] == 0) {
													echo '<strong>';
												}

												echo $this->Html->link(h($message['Message']['subject']), array('controller'=>'messages', 'action' => 'conversation', $message['Message']['property_id']),array('escape' => false, 'class'=>'view-details', "onmousedown"=>"javascript:is_read(".$message['Message']['id'].")"));

												if ($message['Message']['is_read'] == 0) {
													echo '</strong>';
												}

												echo $this->Html->tag('h3', $property_title);

											} elseif ('list_edited' === $message['Message']['message_type']) {
												if ($message['Message']['is_read'] == 0) {
													echo '<strong>';
												}

												echo $this->Html->link(h($message['Message']['subject']), array('controller'=>'messages','action' => 'conversation', $message['Message']['property_id']),array('escape' => false, 'class'=>'view-details', "onmousedown"=>"javascript:is_read(".$message['Message']['id'].")"));

												if ($message['Message']['is_read'] == 0) {
													echo '</strong>';
												}

												echo $this->Html->tag('h3', $property_title);

											} elseif ('message' === $message['Message']['message_type']) {
												if ($message['Message']['is_read'] == 0) {
													echo '<strong>';
												}
												echo $this->Html->link(h($message['Message']['subject']), array('controller'=>'messages', 'action' => 'conversation', $message_id), array('escape' => false, 'class'=>'view-details', "onmousedown"=>"javascript:is_read(".$message['Message']['id'].")"));

												if ($message['Message']['is_read'] == 0) {
													echo '</strong>';
												}
											} else {

												if ($message['Message']['contact_id'] != 0 &&
													(
														'contact_request' === $message['Message']['message_type'] ||
														'contact_response' === $message['Message']['message_type']
													)
												) {
													$message_id = $message['Message']['contact_id'];
												}

												if ($message['Message']['is_read'] == 0) {
													echo '<strong>';
												}

												if ('contact_request' === $message['Message']['message_type']) {
													$action = 'contact_request';
												} else {
													$action = 'contact_response';
												}

												echo $this->Html->link(
													h($message['Message']['subject']),
													['controller'=>'contacts', 'action' => $action, $message_id],
													['escape' => false, 'class'=>'view-details', "onmousedown"=>"javascript:is_read(".$message['Message']['id'].")"]
												);

												if ($message['Message']['is_read'] == 0) {
													echo '</strong>';
												}
											}

											if (
												'referrals' !== $message['Message']['message_type'] ||
												'list_creation' !== $message['Message']['message_type']
											) {
												echo "<p>";
												if (!isset($message['Property']['id'])){
													echo __('List Deletion');
												} else {
													if (
														'reservation_request' == $message['Message']['message_type'] ||
														'contact_response' == $message['Message']['message_type'] ||
														'contact_request' == $message['Message']['message_type'] ||
														'request_sent' == $message['Message']['message_type']
													) {
														if ('reservation_request' !== $message['Message']['message_type']) {
															echo __('Contact Message');
														} else {
															echo Inflector::humanize($message['Message']['message_type']);
														}
													} else {
														echo Inflector::humanize($message['Message']['message_type']);
													}
												}
												echo "<p>";

												if (isset($topay) && trim($topay) !== '' && $paid != 1) {
													if ($hostpaid != 1 && $guestpaid != 1) {
														echo '<span class="badge">';
														echo $this->Number->currency($topay, $currency, ['thousands' => ',', 'decimals' => '.']);
														echo '</span>';
													}
												}
												echo "&nbsp;";
												echo $this->Html->tag('span', Inflector::humanize($message['Reservation']['reservation_status']), ['class' => $this->Html->getReservationLabel($message['Reservation']['reservation_status'])]);
											}
										?>
										</td>
										<td class="actions">

											<a href="javascript:void(0);" class="starred-icon" onclick="changeStatus(this,'<?php echo h($message['Message']['id']); ?>',0); return false;" id="status_allowed_<?php echo h($message['Message']['id']); ?>" <?php if ($message['Message']['is_starred'] == 0){ ?> style="display: none;" <?php } ?>>
												<i class="fa fa-star" aria-hidden="true"></i>
											</a>

											<a href="javascript:void(0);" class="starred-icon" onclick="changeStatus(this,'<?php echo h($message['Message']['id']); ?>',1); return false;" id="status_denied_<?php echo h($message['Message']['id']); ?>" <?php if ($message['Message']['is_starred'] == 1){ ?> style="display: none;" <?php } ?>>
												<i class="fa fa-star-o" aria-hidden="true"></i>
											</a>

											<?php if ($message['Message']['is_archived'] == 0) { ?>
												<a href="javascript:void(0);" class="btn btn-info btn-sm" onclick="changeArchiveStatus(this,'<?php echo h($message['Message']['id']); ?>',1); return false;">
													<i class="fa fa-archive" aria-hidden="true"></i>&nbsp;<?php echo __('Archive');?>
												</a>
											<?php } else { ?>
												<a href="javascript:void(0);" class="btn btn-info btn-sm" onclick="changeArchiveStatus(this,'<?php echo h($message['Message']['id']); ?>',0); return false;">
													<i class="fa fa-archive" aria-hidden="true"></i>&nbsp;<?php echo __('Unarchive');?>
												</a>
											<?php } ?>

											<?php // delete, archive/unarchive, starred,
												$var = h(addslashes($message['Message']['subject']));
												$element_id = (int)$message['Message']['id'];
												echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-close')).'&nbsp;'.__('Delete'), 'javascript:;',array('class'=>'btn btn-danger btn-sm','escape'=>false, "onclick" =>"ShowConfirmDelete({$element_id},'{$var}'); return false;", 'id'=>'element_'.$element_id));

											?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php } else { ?>
					<h3><?php echo __("Nothing to show you."); ?></h3>
				<?php } ?>
			</div>
			<!-- pagination START -->
			<?php echo $this->element('Pagination/counter'); ?>
			<?php echo $this->element('Pagination/navigation'); ?>
		</div>
	</div>
</div>
<!-- Confirmation Modal For Ajax Delete of Records -->
<?php echo $this->element('Common/confirm_modal'); ?>
<?php
$this->Html->scriptBlock("
(function ($) {
	'use strict';
	$(document).ready(function () {
		$(function () {
			$('#message_filter').on('change', function(){
				window.location.href = fullBaseUrl+'/messages/index/'+$(this).val();
			});
		});
	});
})(jQuery);
", array('block' => 'scriptBottom'));
?>

<script>
/**
 * is_read this function changes the status of an email sent to user
 * @param  {INT} id Primary key of the email read.
 * @return void
 */
	function is_read(id){
		$.ajax({
			type: 'POST',
			url: fullBaseUrl + '/messages/isRead/' + id,
			data:{data:{Message:{id:id, is_read:1}}},
		});
	}

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
		$('#lblMsgConfirmYesNo').html('Are you sure you want to delete: <b>' + name + '</b>.');
		$('#btnYesConfirmYesNo').off('click').on('click',function () {
			$confirmModal.modal('hide');
			$.ajax({
				url: fullBaseUrl + '/messages/delete/' + id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Message:{id:id,subject:name}}},
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
					// console.log(xhr.responseJSON.message);
					// var response = $.parseJSON(xhr.responseText);
					// console.log(response.message);

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
			url: fullBaseUrl + '/messages/changeStatus',
			type: 'POST',
			dataType: 'json',
			data:{data:{Message:{id:data_id,is_starred:data_status}}},
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

/**
 * [changeStatus Change publish/unpublish status]
 * @param  {$this} obj       [description]
 * @param  {INT} data_id     [description]
 * @param  {INT} data_status [1/0]
 * @return {string}          [description]
 */
	function changeArchiveStatus(obj,data_id,data_status){
		var $elementToMask = $('#elementToMask'),
			$rowToRemove = $(obj).closest('.parent-element');
		if (data_status == undefined){
			data_status = 0;
		}
		$.ajax({
			url: fullBaseUrl + '/messages/changeArchiveStatus',
			type: 'POST',
			dataType: 'json',
			data:{data:{Message:{id:data_id,is_archived:data_status}}},
			beforeSend: function() {
				// called before response
				$elementToMask.mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='success') {
					var response = $.parseJSON(JSON.stringify(data));
					if (!response.error) {
						$rowToRemove.fadeOut(350,function() { obj.remove(); });
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
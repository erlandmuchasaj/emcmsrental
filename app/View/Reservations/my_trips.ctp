<?php
	echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
?>
<div class="em-container make-top-spacing">
	<div class="row" id="elementToMask">
		<div class="col-lg-3 col-md-4 hidden-sm hidden-xs user-sidebar">
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8">
			<div class="well">
				<?php echo $this->Form->create('Reservation', array('url'  => array('controller' => 'reservations','action' => 'my_trips')));?>
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
						echo $this->Html->link(__('Reset'), array('action' => 'my_trips'));
					endif;
				echo $this->Form->end();
				?>
			</div>
			<div class="panel panel-em no-border">
				<header class="panel-heading clearfix">
					<?php echo $this->Html->tag('h4', __('My Trips'), ['class'=>'pull-left'])?>
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
								<th class="text-center"><?php echo $this->Paginator->sort('user_to', __('Host')); ?></th>
								<th class="actions text-center"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$today = get_gmt_time(strtotime(date("Y-m-d")));
							foreach ($reservations as $reservation):
								$elementId = (int)$reservation['Reservation']['id'];
								$checkin  = get_gmt_time(strtotime($reservation['Reservation']['checkin']));
								$checkout = get_gmt_time(strtotime($reservation['Reservation']['checkout']));
							?>
							<tr class="parent-element">
								<td data-th="<?php echo __('Status');?>">
									<?php
										echo $this->Html->tag('span', Inflector::humanize($reservation['Reservation']['reservation_status']), ['class' => $this->Html->getReservationLabel($reservation['Reservation']['reservation_status'])]);
									?>
								</td>
								<td data-th="<?php echo __('Details');?>">
								<p>
									(<?php echo $reservation['Reservation']['checkin'];?>
									&nbsp;--&nbsp;
									<?php echo $reservation['Reservation']['checkout'] ?>)
								</p>
								<?php
									echo $this->Html->link(
										h($reservation['Property']['PropertyTranslation']['title']),
										array('controller' => 'properties', 'action' => 'view', $reservation['Reservation']['property_id']),
										array('escape' => false)
									);
									echo $this->Html->tag('p', h($reservation['Property']['address']));
								?>
								</td>
								<td data-th="<?php echo __('Host');?>" class="text-center">
								<?php
									echo $this->Html->link(
										$this->Html->displayUserAvatar($reservation['Host']['image_path'], [
											'width' => 50,
											'height' => 50,
											'class' => 'media-round media-photo',
											'alt' => h($reservation['Host']['name']),
											'title' => h($reservation['Host']['name'])
										]),
										array('controller' => 'users', 'action' => 'view', $reservation['Host']['id']),
										array('escape' => false)
									);
									echo $this->Html->tag('h5', h($reservation['Host']['name']).' '.h($reservation['Host']['surname']));

									echo $this->Html->tag('p', h($reservation['Host']['email']));
								?>
								</td>
								<td class="actions text-center">

									<?php echo $this->Html->tag('p', $this->Number->currency($reservation['Reservation']['total_price'], $reservation['Reservation']['currency'], ['thousands' => ',', 'decimals' => '.']), ['class' => 'label label-primary', 'style' => 'font-size: 12px;']); ?>
									<br><br>
									<div class="btn-group">
										<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo __('Actions');?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right" role="menu">
											<li>
												<?php
													echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa  fa-envelope')).'&nbsp;'.__('Message History'), array('controller'=>'reservations', 'action' => 'request_sent', $elementId), array('escape' => false));
												?>
											</li>

											<?php if ('pending_approval' !== $reservation['Reservation']['reservation_status']): ?>
											<li>
												<?php
													echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View Receipt'),'#view_property_modal',array('escape' => false, 'data-property-id'=>$elementId, 'class'=>'view-modal'));
												?>
											</li>
											<?php endif ?>

											<!-- 
											<li class="divider"></li>
											<li>
												<?php
													//echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa  fa-edit')).'&nbsp;'.__('Edit'), array('controller'=>'reservations','action' => 'edit', $elementId),array('escape' => false));
												?>
											</li> 
											-->
											<!-- leave traveler review -->
											<?php if ('awaiting_traveler_review' === $reservation['Reservation']['reservation_status']): ?>
												<li>
													<?php
													echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit', 'aria-hidden'=>'true')).'&nbsp;'.__('Leave review'),array('controller'=>'reservations','action' => 'review_by_traveler', $elementId) , array('escape' => false));
													?>
												</li>
											<?php endif ?>
											<!-- pay host -->
											<?php if ('payment_pending' === $reservation['Reservation']['reservation_status']): ?>
												<li>
													<?php

													echo $this->Html->link(
														$this->Html->tag('i', '', array('class' => 'fa fa-money', 'aria-hidden'=>'true')).'&nbsp;'.__('Proceed with Payment'),
														array('controller' => 'reservations', 'action' => 'book', $reservation['Reservation']['id']),
														array('escape' => false)
													);

													// echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-money', 'aria-hidden'=>'true')).'&nbsp;'.__('Proceed with Payment'),array('controller'=>'reservations','action' => 'pay_host', $elementId) , array('escape' => false), __("Are you sure you want to proceed with payment for this reservation?"));
													?>
												</li>
											<?php endif ?>
											<!-- checkin -->
											<?php
											if (
												('payment_completed' === $reservation['Reservation']['reservation_status'] ||
												'awaiting_checkin' === $reservation['Reservation']['reservation_status']) &&
												($checkin <= $today)
											) {  ?>
												<li>
													<?php
													echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-sign-in', 'aria-hidden'=>'true')).'&nbsp;'.__('Checkin'),array('controller'=>'reservations','action' => 'checkin', $elementId) , array('escape' => false), __("Are you sure you want to checkin?"));
													?>
												</li>
											<?php } ?>
											<!-- checkout -->
											<?php
											if (('checkin' === $reservation['Reservation']['reservation_status']) && ($checkout <= $today)): ?>
												<li>
													<?php
													echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-sign-out', 'aria-hidden'=>'true')).'&nbsp;'.__('Checkout'),array('controller'=>'reservations','action' => 'checkout', $elementId) , array('escape' => false), __("Are you sure you want to checkout?"));
													?>
												</li>
											<?php endif ?>

											<!-- cancel by traveler -->
											<?php 
											if (
												'pending_approval' === $reservation['Reservation']['reservation_status'] ||
												'payment_completed' === $reservation['Reservation']['reservation_status']
											) { ?>
												<li>
													<?php
													echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-ban', 'aria-hidden'=>'true')).'&nbsp;'.__('Cancel Request'),array('controller'=>'reservations','action' => 'cancel_by_traveler', $elementId) , array('escape' => false), __("Are you sure you want to cancel your reservation?"));
													?>
												</li>
											<?php } ?>
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
$this->Html->scriptBlock("
	(function($){
		$(document).ready(function() {
			'use strict';
			var modalContent = $('#modal_content'),
				modalOpen;

			$('#elementToMask').on('click', '.view-modal', function(e){
				e.preventDefault();
				var _this = $(this);
				var id = _this.attr('data-property-id');
				modalOpen = $.ajax({
					url: fullBaseUrl+'/reservations/view/'+id,
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
				if(modalOpen && modalOpen.readyState != 4){
				    modalOpen.abort();
				}
			});
		});
	})(jQuery);
", array('block' => 'scriptBottom'));
?>
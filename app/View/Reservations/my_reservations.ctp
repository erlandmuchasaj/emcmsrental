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
				<?php echo $this->Form->create('Reservation', array('url'  => array('controller' => 'reservations','action' => 'my_reservations')));?>
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
						echo $this->Html->link(__('Reset'), array('action' => 'my_reservations'));
					endif;
				echo $this->Form->end();
				?>
			</div>
			<div class="panel panel-em no-border">
				<header class="panel-heading clearfix">
					<?php echo $this->Html->tag('h4', __('Reservations'), ['class'=>'pull-left']); ?>
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
								<th class="text-center"><?php echo $this->Paginator->sort('user_by', __('Guest')); ?></th>
								<th><?php echo __('Date, Times and location'); ?></th>
								<th><?php echo $this->Paginator->sort('reservation_status', __('Status')); ?></th>
								<th><?php echo __('Details'); ?></th>
								<th class="actions text-center"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($reservations as $reservation):
								$elementId = (int)$reservation['Reservation']['id'];
							?>
							<tr class="parent-element">
								<td data-th="<?php echo __('Guest');?>" class="text-center">
								<?php
									echo $this->Html->link(
										$this->Html->displayUserAvatar($reservation['Traveler']['image_path'], [
											'width' => 50,
											'height' => 50,
											'class' => 'media-round media-photo',
											'alt' => h($reservation['Traveler']['name']),
											'title' => h($reservation['Traveler']['name'])
										]),
										array('controller' => 'users', 'action' => 'view', $reservation['Traveler']['id']),
										array('escape' => false)
									);

									echo $this->Html->tag('h5', h($reservation['Traveler']['name']).' '. h($reservation['Traveler']['surname']));
									echo $this->Html->tag('p', h($reservation['Traveler']['email']));
								?>
								</td>

								<td data-th="<?php echo __('Details');?>">
								<p>
									(<?php echo $this->Time->nice($reservation['Reservation']['checkin'], null, '%a, %b %eS %Y') ?>
									&nbsp;-&nbsp;
									<?php echo $this->Time->nice($reservation['Reservation']['checkout'], null, '%a, %b %eS %Y') ?>)
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
								<td data-th="<?php echo __('Status');?>">
									<?php
										echo $this->Html->tag('span',
											Inflector::humanize($reservation['Reservation']['reservation_status']),
											['class' => $this->Html->getReservationLabel($reservation['Reservation']['reservation_status'])]
										);
									?>
								</td>
								<td data-th="<?php echo __('Details');?>">
								<?php
									echo $this->Number->currency($reservation['Reservation']['total_price'], $reservation['Reservation']['currency'], ['thousands' => ',', 'decimals' => '.']);
								?>
								</td>

								<td class="actions text-center">
									<div class="btn-group">
										<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo __('Actions');?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right" role="menu">
											<li>
												<?php
													echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa  fa-envelope')).'&nbsp;'.__('Message History'), array('controller'=>'reservations', 'action' => 'reservation_request', $elementId), array('escape' => false));
												?>
											</li>
											<li>
												<?php
													echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View Receipt'),'#view_property_modal',array('escape' => false, 'data-property-id'=>$elementId, 'class'=>'view-modal'));
												?>
											</li>
											<!-- <li class="divider"></li> -->
											<!-- leave traveler review -->
											<?php if ('awaiting_host_review' === $reservation['Reservation']['reservation_status']): ?>
												<li>
													<?php
													echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit', 'aria-hidden'=>'true')).'&nbsp;'.__('Leave review'),array('controller'=>'reservations','action' => 'review_by_host', $elementId) , array('escape' => false));
													?>
												</li>
											<?php endif ?>

											<?php if ('pending_approval' === $reservation['Reservation']['reservation_status']): ?>
												<li>
													<?php
													echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-check-square-o', 'aria-hidden'=>'true')).'&nbsp;'.__('Accept'),array('controller'=>'reservations','action' => 'accept', $elementId) , array('escape' => false), __("Are you sure you want to accept this reservation?"));
													?>
												</li>
												<li>
													<?php
													echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-ban', 'aria-hidden'=>'true')).'&nbsp;'.__('Decline'),array('controller'=>'reservations','action' => 'decline', $elementId) , array('escape' => false), __("Are you sure you want to decline this reservation?"));
													?>
												</li>
											<?php endif ?>

											<?php 
											if (
												'payment_completed' === $reservation['Reservation']['reservation_status']
											) { ?>
												<li>
													<?php
													echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-ban', 'aria-hidden'=>'true')).'&nbsp;'.__('Cancel Reservation'),array('controller'=>'reservations','action' => 'cancel_by_host', $elementId) , array('escape' => false), __("Are you sure you want to cancel your reservation?"));
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
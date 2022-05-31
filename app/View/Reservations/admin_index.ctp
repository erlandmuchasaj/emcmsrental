<?php 
	$reservation_statuses = [
		'payment_pending' 			=> 'label-warning',
		'pending_approval' 			=> 'label-warning',	
		'declined' 					=> 'label-danger',			
		'accepted'  				=> 'label-success',			 
		'expired' 					=> 'label-danger',				
		'payment_completed'			=> 'label-info', 
		'canceled_by_host' 			=> 'label-danger', 
		'canceled_by_traveler' 		=> 'label-danger',
		'awaiting_checkin' 			=> 'label-default',
		'checkin'  					=> 'label-info',				
		'awaiting_traveler_review'  => 'label-warning',
		'awaiting_host_review' 		=> 'label-warning',
		'completed' 				=> 'label-success'
	];
?>
<div class="box box-info">
	<div class="box-header with-border">
		<?php echo $this->Html->tag('h3',__('Reservations'),array('class' => 'box-title')) ?>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<div class="dataTables_wrapper form-inline dt-bootstrap clearfix">
			<div class="pull-left">
				<?php
					$default_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
					if($this->Session->check('per_page_count')) {
						$default_count = $this->Session->read('per_page_count');
					}
				?>
				<label>
					<?php echo  __('Show'); ?>
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
					<?php echo  __('Entries'); ?>
				</label>
			</div>

			<div class="dataTables_filter pull-right">
			<?php 
				echo $this->Form->create('Reservation', array('url' => array('controller' => 'reservations', 'action' => 'admin_index')));

				if (!empty($search)) :
					echo $this->Form->input('search', array('class' => 'form-control', 'label' => false, 'div' => false, 'value' => $search));
				else:
					echo $this->Form->input('search',
						array('type' => 'text',
							'class' => 'form-control',
							'placeholder' => __('Search...'),
							'label' => false,
							'div' => false
						)
					);
				endif; 

				if (!empty($search)) :
					echo $this->Html->link(__('Reset'), array('action' => 'admin_index'));
				endif;
				echo $this->Form->end();
			?>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table no-margin">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('confirmation_code', __('Booking Nr.')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('user_by', __('Guest')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('user_to', __('Host')); ?></th>
						<th><?php echo $this->Paginator->sort('checkin', __('Details')); ?></th>	
						<th><?php echo $this->Paginator->sort('total_price'); ?></th>						
						<th><?php echo $this->Paginator->sort('reservation_status'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($reservations as $reservation): ?>
						<?php $status = EMCMS_strtolower($reservation['Reservation']['reservation_status']); ?>
						<tr>
							<td><?php echo h($reservation['Reservation']['confirmation_code']); ?>&nbsp;</td>
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

								echo $this->Html->tag('h5', h($reservation['Traveler']['name']).' '. h($reservation['Traveler']['surname']), ['class' => 'remove-margin']);
								echo $this->Html->tag('p', h($reservation['Traveler']['email']));
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

								echo $this->Html->tag('h5', h($reservation['Host']['name']).' '. h($reservation['Host']['surname']), ['class' => 'remove-margin']);
								echo $this->Html->tag('p', h($reservation['Host']['email']));
							?>
							</td>
							<td>
							<?php 
								echo $this->Time->format('F jS, Y', $reservation['Reservation']['checkin']);
								echo " - ";
								echo $this->Time->format('F jS, Y', $reservation['Reservation']['checkout']);
								echo "<br>";

								$title = 'Property';
								if (!empty($reservation['Property']['PropertyTranslation'])) {
									$title = h($reservation['Property']['PropertyTranslation']['title']);
								}

								echo $this->Html->link(
									$title,
									array('admin' => false, 'controller' => 'properties', 'action' => 'view', $reservation['Reservation']['property_id']),
									array('escape' => false,'target'=>'_blank')
								);
								echo $this->Html->tag('p', h($reservation['Property']['address']));
							?>
							</td>

							<td>
							<?php 
								echo $this->Number->currency($reservation['Reservation']['total_price'], $reservation['Reservation']['currency'], ['thousands' => ',', 'decimals' => '.']);
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

							<td class="actions">
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo __('Actions');?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<li>
											<?php 
												echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View'), array('action' => 'view', $reservation['Reservation']['id']), array('escape' => false)); 
											?>
										</li>
										
										<?php if (in_array($reservation['Reservation']['reservation_status'], [
													'canceled_by_host',
													'canceled_by_traveler',
													'declined',
													'expired',
													'completed',
													'payment_error'
												], true) || true): ?>
											<li class="divider"></li>
											<li>
											<?php
												echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-times')).'&nbsp;'.__('Delete'), array('action' => 'delete', $reservation['Reservation']['id']), array('class'=>'', 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $reservation['Reservation']['id'])));
											?>
											</li> 
										<?php endif ?>
									</ul>
								</div> 
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="box-footer clearfix">
		<?php echo $this->element('Pagination/counter'); ?>
		<?php echo $this->element('Pagination/navigation'); ?>
	</div>
	<!-- /.box-footer -->
</div>



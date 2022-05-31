<?php
	/*This css is applied only to this page*/		 
	echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
?>
<div class="em-container make-top-spacing">
	<div class="row" id="elementToMask">
		<div class="col-lg-3 col-md-4 user-sidebar">
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8">
			<div class="panel panel-em no-border">
				<header class="panel-heading clearfix">
					<?php echo $this->Html->tag('h4', __('Reviews'), ['class'=>'pull-left'])?>
				</header>
				<div class="panel-body">
					<div class="table-responsive event-table">
						<table class="table general-table">
							<thead>
								<tr>
									<th><?php echo __('Status'); ?></th>
									<th class="hidden-md hidden-sm hidden-xs"><?php echo __('Traveler'); ?></th>
									<th><?php echo __('Property'); ?></th>
									<th class="hidden-md hidden-sm hidden-xs"><?php echo __('Dates'); ?></th>
									<th><?php echo __('Status'); ?></th>
									<th class="actions"><?php echo __('Actions'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($reviews as $review): ?>
									<tr>
										<td data-th="<?php echo __('Status');?>">
											<?php 
												if ($review['Reservation']['reservation_status'] === 'waiting_host_review'){
													echo '<b style="color: #303030;" >' . __('Waiting Host Review'). '</b>&nbsp;';
												} else if ($review['Reservation']['reservation_status'] === 'completed'){
													echo '<b style="color: #FBC210;" >' . __('Completed'). '</b>&nbsp;';
												} else {
													echo '<b  style="color: #F70404;">'.__('Not Defined').'</b>&nbsp;';
												}
											?>										
										</td>
										<td class="hidden-md hidden-sm hidden-xs"><?php echo h($review['UserBy']['name']).' '.h($review['UserBy']['surname']); ?>&nbsp;</td>
										<td data-th="<?php echo __('Property');?>"><?php echo h($review['Property']['address']); ?>&nbsp;</td>
										<td class="hidden-md hidden-sm hidden-xs">
											<?php echo '<b>' . __('Checkin: '). '</b>&nbsp;'. date("j F, Y", strtotime($review['Reservation']['checkin'])); ?>
											&nbsp;<br />
											<?php echo '<b>' . __('Checkout: '). '</b>&nbsp;'. date("j F, Y", strtotime($review['Reservation']['checkout'])); ?>
										</td>
										<td  data-th="<?php echo __('Published');?>">
											<?php $class = $review['Review']['status'] ? 'label-success' : 'label-danger'; ?>	
											<span class="label <?php echo $class; ?>">
												<?php echo ($review['Review']['status']) ?  __('Published') : __('Unpublished');?>
											</span>
										</td>
										<td class="actions">
											<span class="label label-success" data-toggle="tooltip" data-placement="top" title="<?php echo __('View this review');?>" >
												<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')),array('controller'=>'reviews', 'action' => 'view', $review['Review']['id']),array('escape' => false));  ?>
											</span>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- pagination START -->
			<?php echo $this->element('Pagination/counter'); ?>
			<?php echo $this->element('Pagination/navigation'); ?>
		</div>
	</div>
</div>

<div class="em-container make-top-spacing">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<header class="panel-heading clearfix">
				<?php echo $this->Html->tag('h3', __('Reviews'), ['class'=>'pull-left'])?>
			</header>			
			<?php if (isset($reviews) && !empty($reviews)) { ?>
				<div class="comments">
					<?php foreach ($reviews as $review){
						$user_review = '';
						if ($review['Review']['is_dummy']) {
							$user_review = $review['Review']['dummy_user'];
							if (isset($review['Review']['publish_date']) && !empty($review['Review']['publish_date']) && trim($review['Review']['publish_date'])!='') {
								$time = $review['Review']['publish_date'];
							} else {
								$time = $review['Review']['modified'];
							}
						} else {
							$user_review = $review['UserBy']['name'].'&nbsp;'.$review['UserBy']['surname'];
							$time = $review['Review']['modified'];
						}
					?>
					<div class="comment">
						<div class="commentAvatar">
							<?php echo $this->Html->link(
								$this->Html->displayUserAvatar($review['UserBy']['image_path'], array('alt' => 'avatar', 'border' => '0','fullBase' => true, 'class'=>'avatar')),
									array('controller'=>'users', 'action'=>'view', $review['UserBy']['id']),
									array('target' => '_blank', 'escape' => false)
								);
							?>
							<div class="commentArrow"><span class="fa fa-caret-left"></span></div>
						</div>
						<div class="commentContent">
							<div class="commentName"><?php echo $user_review; ?></div>
							<div class="commentTitle"><?php echo h($review['Review']['title']); ?></div>
							<div class="commentBody">
								<?php echo h($review['Review']['review']); ?>
							</div>
							<div class="commentActions">
								<div class="commentTime">
									<span class="fa fa-clock-o"></span>&nbsp;
									<?php echo $this->Time->timeAgoInWords($time); ?>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<?php } ?>
				</div>
			<?php } ?>
			<!-- pagination START -->
			<?php echo $this->element('Pagination/counter'); ?>
			<?php echo $this->element('Pagination/navigation'); ?>
		</div>
	</div>
</div>

<?php 
	$mostVisited = $this->requestAction(
	    array('controller' => 'properties', 'action' => 'featured'),
	    array('named' => array('limit' => 10))
	);
?>

<?php if (!empty($mostVisited)): ?>
	<div class="row">
		<div class="col-md-12 section-header">
			<?php echo $this->Html->tag('h3', __('Top rated places'), array('class'=>'title')); ?>
			<?php //echo $this->Html->tag('p', __('Some places you would enjoy visiting.'), array('class'=>'description')); ?>
			<!-- <hr class="hr-line"> -->
		</div>
		<div class="col-md-12">
			<div class="owl-carousel owl-theme no-dots owl-expereience" id="js_featured_prop">
				<?php foreach ($mostVisited as $mostVisit): ?>
				<?php 
					$thumbnail = $this->webroot.'img/uploads/Property/'.$mostVisit['Property']['id'].'/PropertyPicture/medium/'.$mostVisit['Property']['thumbnail'];
					$label = ($mostVisit['Property']['contract_type'] === 'rent') ? 'label-success' : 'label-primary';	
				?>
				<div class="item">
					<div class="experience__image_wrapper">
						<!--
						<div class="wishlist_ex">
							<svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="1em" width="1em" viewBox="0 0 40 40" class="wishlist__icon js-add-to-wishlist" data-model-id="<?php // echo h($mostVisit['Property']['id']); ?>" data-model-name="Property">
								<g>
									<path d="m37.1 13.3q0-1.8-0.4-3.2t-1.3-2.2-1.8-1.3-2.1-0.7-2.2-0.2-2.5 0.6-2.4 1.4-2 1.6-1.3 1.4q-0.4 0.5-1.1 0.5t-1.1-0.5q-0.5-0.6-1.3-1.4t-2-1.6-2.4-1.4-2.5-0.6-2.2 0.2-2.1 0.7-1.8 1.3-1.3 2.2-0.4 3.2q0 3.8 4.1 7.9l13 12.5 12.9-12.4q4.2-4.2 4.2-8z m2.9 0q0 4.9-5.1 10l-13.9 13.4q-0.4 0.4-1 0.4t-1-0.4l-13.9-13.4q-0.2-0.2-0.6-0.6t-1.3-1.4-1.5-2.2-1.2-2.7-0.5-3.1q0-4.9 2.8-7.7t7.9-2.7q1.4 0 2.8 0.4t2.7 1.3 2.1 1.6 1.7 1.5q0.8-0.8 1.7-1.5t2.1-1.6 2.7-1.3 2.8-0.4q5 0 7.9 2.7t2.8 7.7z">
									</path>
								</g>
							</svg>
						</div>
						-->
						<?php 
							echo $this->Html->link(
								$this->Html->tag('span', $mostVisit['Property']['type_formated'], ['class' => "experience__contract-type label {$label}"]) . 
								$this->Html->image('general/noimg/empty.png', array('alt' => 'img','class'=>'img-responsive experience__image owl-lazy', 'data-src' => $thumbnail)), 
								['controller' => 'properties', 'action' => 'view', $mostVisit['Property']['id']], 
								array('escape' => false , 'class' => 'experience', 'target' => '_blank', 'rel' => 'noopener noreferrer')
							);
						?>
					</div>
					<div class="panel-body panel-card-section">
						<div class="media">
				    		<div class="experience__category experience__category--home clearfix">
				    			<span class="pull-left category__element"><?php echo h($mostVisit['RoomType']['room_type_name']); ?></span>
				    			<span class="pull-left category__dot">·</span>
				    			<span class="pull-left category__element"><?php echo h($mostVisit['AccommodationType']['accommodation_type_name']); ?></span>
				    		</div>
				    		<?php 
				    			echo $this->Html->link($this->Html->tag('span', getDescriptionHtml($mostVisit['PropertyTranslation']['title']), ['class' => 'truncate']), ['controller' => 'properties','action' => 'view', $mostVisit['Property']['id']], array('escape' => false, 'class' => 'experience__title', 'target' => '_blank', 'rel' => 'noopener noreferrer'));
				    		?>
				    		<div class="experience__price_wrapper">
				    			<span class="experience__price">
				    				<?php echo $mostVisit['Property']['price_converted']; ?>
				    			</span>
				    			<?php if ($mostVisit['Property']['contract_type'] === 'rent'): ?>
				    			<?php echo __(' / per night'); ?>&nbsp;<?php echo $retVal = ($mostVisit['Property']['allow_instant_booking'] ==1) ? '<i class="fa fa-bolt icon-instant-book" aria-hidden="true"></i>' : ''; ?>
				    			<?php endif ?>
				    		</div>
						</div>
					</div>
				</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
<?php endif ?>

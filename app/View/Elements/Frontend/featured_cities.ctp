<?php 
	$cities = $this->requestAction(
	    array('controller' => 'cities', 'action' => 'featured'),
	    array('named' => array('limit' => 10))
	);
?>

<?php if (!empty($cities)): ?>
	<div class="row">
		<div class="col-md-12 text-center section-header">
			<?php echo $this->Html->tag('h3', __('Explore the world'), array('class'=>'title')); ?>
			<?php echo $this->Html->tag('p', __('See where people are traveling, all around the world.'), array('class'=>'description')); ?>
			<hr class="hr-line" />
		</div>
	</div>
	<div class="row">
		<?php 
			$neigh_count = 1;
			$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'City'. DS;
			$longSection = [1, 7, 11, 17, 21, 27, 31];
		?>
		<?php foreach ($cities as $key => $city): ?>
		<?php 
			if (in_array($neigh_count, $longSection)) {
				$class_neigh = "col-md-8 col-sm-12 col-xs-12"; 
			} else {
				$class_neigh = "col-md-4 col-sm-12 col-xs-12";
			}
			$image_Url = $this->webroot.'img/uploads/City/'.$city['City']['image_path'];
		?>
		<div class="<?php echo $class_neigh;?>">
			<figure class="city-element text-center">
				<?php $thumbnail = $this->webroot.'img/uploads/City/'.$city['City']['image_path']; ?>
				<!-- style="background-image:url(<?php // echo $thumbnail; ?>);" -->
				<div class="lazy background_preview" data-src="<?php echo $thumbnail; ?>">
					<?php 
						echo $this->Html->image('general/noimg/empty.png', array('alt' => 'image', 'class'=>'invisible city-img', 'style'=>'visibility:hidden'));
					?>
				</div>
				<figcaption>
				<?php 
					echo $this->Html->tag('h3', h($city['City']['name']), array('class'=>'center-element-vertical'));
					echo $this->Html->link(__('View more'), ['controller'=>'properties', 'action'=>'search', '?' => ['location'=>h($city['City']['name'])]], array('escape' => false, 'class'=>'', 'target' => '_blank', 'rel' => 'noopener noreferrer'));
				?>
				</figcaption>
			</figure>
		</div>
		<?php $neigh_count++; ?>
		<?php endforeach ?>
	</div>
	<?php
		$this->Html->script('frontend/jquery.lazy/jquery.lazy.min.js', array('block'=>'scriptBottomMiddle'));
		$this->Html->scriptBlock("
				(function($){
					$(document).ready(function() {
						'use strict';
						$('.lazy').lazy({
							effect: 'fadeIn',
							effectTime: 450,
							threshold: 0,
							visibleOnly: true
						});
					});
				})(jQuery);
		", array('block' => 'scriptBottom'));
	?>
<?php endif ?>
<?php 
	$experiences = $this->requestAction(
	    array('controller' => 'experience', 'action' => 'featured'),
	    array('named' => array('limit' => 10))
	);
?>

<?php if (!empty($experiences)): ?>
	<div class="row">
		<div class="col-md-12 section-header">
			<?php echo $this->Html->tag('h3', __('Experiences'), array('class'=>'title')); ?>
		</div>
		<div class="col-md-12">
		    <div class="owl-carousel owl-theme owl-expereience" id="js_experience">
		    	<?php foreach ($experiences as $key => $experience): ?>
	    		<div class="item">
	    			<div class="experience__image_wrapper">
					<?php 
						if (!empty($experience['Image'])) {
							$image = $experience['Image'][0];
							$thumbnail = $this->webroot. "img/uploads/{$image['model']}/{$image['model_id']}/medium/{$image['src']}";
							$caption = $image['caption'];
						} else {
							$caption = 'image';
							$thumbnail = 'no-img-available.png';
						}

						echo $this->Html->link($this->Html->image('general/noimg/empty.png', array('alt' => h($caption),'class'=>'img-responsive experience__image owl-lazy', 'data-src' => $thumbnail)), ['controller' => 'experience', 'action' => 'view', $experience['Experience']['id']], array('escape' => false , 'class' => 'experience', 'target' => '_blank', 'rel' => 'noopener noreferrer'));
					?>
					</div>
		    		<div class="panel-body panel-card-section">
			    		<div class="media">
				    		<div class="experience__category clearfix">
				    			<span class="pull-left category__element"><?php echo h($experience['Category']['name']); ?></span>
				    			<?php if (!empty($experience['Subcategory']['name'])): ?>
				    			<span class="pull-left category__dot">·</span>
				    			<span class="pull-left category__element"><?php echo h($experience['Subcategory']['name']); ?></span>
				    			<?php endif ?>
				    		</div>
				    		<?php 
				    			echo $this->Html->link($this->Html->tag('span', h($experience['Experience']['title']), ['class' => 'truncate']), ['controller' => 'experience','action' => 'view', $experience['Experience']['id']], array('escape' => false, 'class' => 'experience__title', 'target' => '_blank', 'rel' => 'noopener noreferrer'));
				    		?>
				    		<div class="experience__price_wrapper">
				    			<span class="experience__price"><?php echo $experience['Experience']['price_converted'] ?></span>&nbsp; per guest 
				    		</div>
			    		</div>
		    		</div>
	    		</div>

				<!-- 
				<a href="<?php // echo Router::Url(array('controller' => 'experience','action' => 'view', $experience['Experience']['id']), true) ?>" target="_blank" rel="noopener" class="experience cateimg1">
					<?php 
						// if (!empty($experience['Image'])) {
						// 	$image = $experience['Image'][0];
						// 	$thumbnail = "uploads/{$image['model']}/{$image['model_id']}/medium/{$image['src']}";
						// 	$caption = $image['caption'];
						// } else {
						// 	$caption = 'image';
						// 	$thumbnail = 'no-img-available.png';
						// }
						// echo $this->Html->image($thumbnail, array('alt' => h($caption), 'class'=>'img-responsive experience__image'));
					?>
				    <div class="experience__title">
				    	<span class="experience__price"><?php // echo $experience['Experience']['price_converted'] ?></span>&nbsp;<?php // echo h($experience['Experience']['title']) ?>
				    </div>
		   		</a>
		   		-->
		    	<?php endforeach ?>
		    </div>
		</div>
	</div>
<?php endif ?>
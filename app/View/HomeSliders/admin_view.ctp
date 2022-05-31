<?php 
	$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'HomeSlider'. DS;
	$status = $homeSlider['HomeSlider']['status'] ? __('Published') : __('Unpublished'); 
?>
<div class="row">
	<div class="col-sm-12">
		<section class="panel panel-em">
			<header class="panel-heading">
				<?php echo __('Home Slider'); ?>
			</header>
			<div class="panel-body">
				<div><?php echo __('Status') . ' : ' .  $status; ?></div>
				<div class="media-gal">
					<div class="view-image item">
						<?php 
							if (file_exists($directory.$homeSlider['HomeSlider']['image_path']) && is_file($directory .$homeSlider['HomeSlider']['image_path'])) { 	
								echo $this->Html->image('uploads/HomeSlider/'.$homeSlider['HomeSlider']['image_path'], array('alt' => 'image'));
							} else {	
								echo __('No Image Available'); 
							} 
						?>
						<p><?php echo __('Slogan') . ' : ' . h($homeSlider['HomeSlider']['slogan']); ?></p>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
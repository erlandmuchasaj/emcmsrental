<?php 
	$banners = $this->requestAction(
	    array('controller' => 'site_settings', 'action' => 'featured'),
	    array('named' => array('limit' => 4))
	);
?>

<?php if (!empty($banners)): ?>
	<div class="row">
		<div class="col-md-12">
			<div class="banner-carousel carousel slide row-space-top-6 row-space-6" id="banner_carousel_generic" data-ride="carousel">
				<!-- Indicators -->
				<!--
				<ol class="carousel-indicators">
					<li data-target="#banner_carousel_generic" data-slide-to="0" class="active"></li>
					<li data-target="#banner_carousel_generic" data-slide-to="1"></li>
					<li data-target="#banner_carousel_generic" data-slide-to="2"></li>
				</ol>
				-->
			    <!-- Wrapper for slides -->
			    <div class="carousel-inner" role="listbox">
			    	<?php foreach ($banners as $key => $banner): ?>
			    	<?php $thumbnail = $this->webroot.'img/uploads/Banner/'.$banner['Banner']['image_path']; ?>
			    	<div class="item <?php echo ($key == 0) ? "active" : '';?>">
			    		<div class="banner-slide_one background_preview" style="background-image:url(<?php echo $thumbnail; ?>);"></div>
			        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 remove-padding-left remove-padding-right">
			        	    <div class="carousel-caption banner-carousel-caption">
			        	   		<h2 class="banner-title"><?php echo h($banner['Banner']['title']); ?></h2>
			        	   		<p class="banner-description"><?php echo h($banner['Banner']['description']); ?></p>
			        	   		<a class="banner-slider-btn btn btn-primary" rel="noopener noreferrer" target="_blank" href="<?php echo $banner['Banner']['url']; ?>">
			        	   			<?php echo h($banner['Banner']['button_text']); ?>
			        	   		</a> 
			        	    </div> 
			        	</div>
			        </div>
			    	<?php endforeach ?>
			    </div>
			</div>
		</div>
	</div>
<?php endif ?>
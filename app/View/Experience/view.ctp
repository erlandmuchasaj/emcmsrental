<?php

if (!empty($experience['Experience']['title'])) {
	$this->set('title_for_layout', getDescriptionHtml($experience['Experience']['title']));
	$this->assign('meta_title', getDescriptionHtml($experience['Experience']['title']));
}

if (!empty($experience['Experience']['tagline'])) {
	$this->assign('meta_description', getDescriptionHtml($experience['Experience']['tagline']));
}

$this->assign('meta_url', Router::Url(null, true));

?>

<div class="em-container experiences view make-top-spacing">
	<style scoped="">
		.wish_list_action {
		    margin: 15px 0;
		}

		.pad_tb_20 {
		    padding: 15px 0 5px;
		}
		.wish_list_action .wishList_can, 
		.wish_list_action .wishList_can:hover
		{
			background: #ffffff none repeat scroll 0 0 !important;
			border: 2px solid #008489;
			border-radius: 4px;
			color: #008489;
			font-size: 16px;
		}

		.mar_btm_five {
			margin-bottom: 5px;
		}

		.affix {
		  /*position: fixed !important;*/
		  /*top: 85px;*/
		  z-index: 10;
		  width: auto;
		}

		@media (min-width: 768px) {
		    .affix {
		        position: fixed !important;
		        width: 46.777777%;
		    }

		}

		.affix-bottom {
			position: absolute;
		}

		@media screen and (min-width: 992px) {
		  .affix {
		    width: 38.66666%;
		  }
		}

		@media screen and (min-width: 1170px) {
		  .affix {
		    width: 457px;
		  }
		}
		

		.right_top {
			padding: 15px;
			background-color: #fff;
		    /*margin-bottom: 50px;*/
			position: relative;
		    overflow: hidden;
		}

		@media (max-width: 767px) {
			.hostexp_right {
				padding: 0;
			}
			.right_top {
			    margin-bottom: 0;
			}
		}

		.experience_sec {
			background-color: #fff;
		}

		.exp_img {
			width: 100%;
		    height: 400px !important;
		    object-fit: cover;
		}
		.overall {
		    display: inline-block;
		    width: 100%;
		    padding: 30px 0;
		}

		.mobover{
		    display: inline-block;
		    width: 100%;
		    padding: 30px 0;
		}

		.videorate {
		    display: inline-block;
		    width: 57%;
		    overflow: hidden;
		    text-overflow: ellipsis;
		    white-space: nowrap;
		    font-size: 16px;
		}

		.forrate {
		    display: block;
		    width: 100%;
		    font-weight: 600;
		    color: #484848;
		    font-size: 15px;
		}

		.videorate .forrate span {
		    font-size: 15px;
		    /* font-family: 'Roboto', sans-serif; */
		    font-weight: 300;
		    padding-left: 5px;
		}

		.star1 {
		    display: inline-block;
		    width: 100%;
		}

		.num {
			font-size: 11px;
		    padding-right: 5px;
		}

		.fonticon {
		    width: 50%;
		    float: left;
		}
		.fonticon a {
		    color: #484848;
		    padding-right: 15px;
		    font-size: 15px;
		}

		.social-icon-size {
		    font-size: 18px;
		}

		.share-btn {
		    min-width: 16px;
		    margin-right: 8px;
		    display: inline-block;
		    vertical-align: middle;
		}


		.price {
		    color: #484848;
		    text-align: center;
		    padding-top: 10px;
		    display: inline-block;
		    width: 100%;
		}

		.icon1{
		    border-bottom: 1px solid #ccc;
		    display: inline-block;
		    width: 100%;
		    border-top: 1px solid #ccc;
		    padding: 24px 0;
		}
		.wishlist_save {
		    float: right;
		    cursor: pointer;
		}

		.rich-toggle-unchecked {
	    	display: inline-block;
	    	vertical-align: middle
		}

		.exp__title {
		    font-size: 36px;
		    font-family: azo_sansbold;
		    color: #484848;
		    margin: 0;
		    padding: 6px 0;
		}

		.exp_tagline {
			font-size: 19px;
			font-family: azo_sanslight;
			line-height: normal;
			color: #484848;
			overflow-wrap: break-word;		
			margin: 0;	
		}

		.experie {
		    font-size: 17px;
		    margin-top: 10px;
		    margin-bottom: 10px;
		    font-weight: normal;
		    display: inline-block;
		    width: 100%;
		}
		.exp__category{
		    font-family: azo_sanslight;
		    font-size: 17px;
		    margin: 0;
		    padding: 5px 0;
		}
		.exp__host--link{
		    color: #008489;
		}

		.pro {
		    /*width: 60px;*/
		    float: right;
		}

		.pro img {
			display: inline-block;
			width: 60px;
			height: 60px;
			object-fit: cover;
		    border-radius: 50px;
		}

		.exper {
		    /* margin-top: 24px; */
		    padding: 24px 0;
		    border-top: 1px solid #ccc;
		    border-bottom: 1px solid #ccc;
		    display: inline-block;
		    width: 100%;
		}

		.time1 {
		    font-size: 17px;
		    padding-bottom: 10px;
		}


		.time1 .fa {
		    padding-right: 10px;
		}


		.about p {
		    margin: 0;
		}
		.forpro {
		    display: inline-block;
		    width: 100%;
		    float: left;
		    font-size: 17px;
		    padding-top: 15px;
		}
		.morecontent span {
		    display: none;
		}
		.morelink {
		    display: inline-block;
		    color: #008489;
		    font-size: 17px;
		    font-weight: 400;
		}
		p.morelink {
		    font-size: 15px;
		}
		p.morelink:hover {
		    text-decoration: underline;
		    font-size: 15px;
		}

		.abthole {
		    display: inline-block;
		    width: 100%;
		    border-bottom: 1px solid #ccc;
		    padding: 24px 0;
		    font-family: azo_sanslight;
		}

		.aboutdet {
		    display: inline-block;
		    width: 100%;
		    float: left;
		    padding-right: 0;
		    font-size: 17px;
		    font-family: azo_sansbold;
		    margin: 0;
		}

		.mobile_location_area {
		    position: relative;   
		    padding-top: 10px;
		    display: block;
		    width: 100%;
		    height: 350px;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
		    overflow: hidden;
		    cursor: pointer !important;
		}

		 /*style the box*/  
		 .gm-style .gm-style-iw {
		    top: 0 !important;
		    left: 0 !important;
		    width: 100% !important;
		    height: 100% !important;
		    min-height: 100px !important;
		    padding-top: 10px;
		    display: block !important;
		 }    
				
		.exp_head {
			font-family: azo_sansbold;
			font-size: 24px;
		}

		.exp_loc {
			font-family: azo_sanslight;
			font-size: 17px;
		}

		.monthup{
		    font-family: azo_sanslight;
		    font-size: 17px;
		}
		.timing{
		    /*font-weight: 300;*/
		    font-size: 15px;
		    /*font-family: 'Roboto', sans-serif;*/
		    letter-spacing: 0.2px;
		}
		.update {
		    line-height: 27px;
		    float: left;
		    width: 80%;
		}
		.choosebut {
		    float: right;
		    width: 20%;
		}
		.choosebut a {
		    padding: 7px 10px;
		    border-radius: 5px;
		    border: 1px solid #008489;
		    background: transparent;
		    color: #008489;
		    float: right;
		    text-align: center;
		    font-weight: 500;
		    font-size: 15px;
		}
		.upcome {
		    padding-top: 24px;
		    display: inline-block;
		    width: 100%;
		}
		.upcome h4 {
		    color: #484848;
		    margin: 0;
		    font-family: azo_sansbold;
		    font-size: 17px;
		}
		.month {
		    display: inline-block;
		    width: 100%;
		    border-bottom: 1px solid #ccc;
		    padding: 24px 0;
		}
		.timing span {
		    padding-left: 5px;
		}

		.forsee {
		    display: inline-block;
		    width: 100%;
		    padding: 24px 0;
		    border-bottom: 1px solid #ccc;
		    font-size: 17px;
		}
		.forsee a {
		    font-size: 19px;
		    color: #0B94B3;
		}

		.review {
		    font-family: azo_sansbold;
		    font-size: 17px;
		    color: #484848;
		    margin: 18px 0 0 !important;
		    display: inline-block;
		    width: 100%;
		}
	</style>
	<?php // debug($experience); ?>
	<div class="row">
		<div class="col-md-5 col-md-push-7 col-sm-6  col-sm-push-6 col-xs-12 hostexp_right">
			<div class="right_top" id="sticky">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				    <!-- Wrapper for slides -->
				    <div class="carousel-inner" role="listbox">
				    	<?php foreach ($experience['Image'] as $key => $image): ?>
				    	<?php 
				    		if ($key == 0) {
				    			$og_image = Router::url("/img/uploads/{$image['model']}/{$image['model_id']}/medium/{$image['src']}", true);
				    			$this->assign('meta_image', $og_image);
				    		}
			    		?>
				    	<?php $thumbnail = "uploads/{$image['model']}/{$image['model_id']}/medium/{$image['src']}"; ?>
				    	<figure class="item <?php echo ($key == 0) ? "active" : '';?>">
				    		<?php 
				    			echo $this->Html->image($thumbnail, array('alt' => h($image['caption']), 'class'=>'img-responsive exp_img', 'data-src' => $thumbnail));
				    		?>
				    		<figcaption class="carousel-caption"><?php h($image['caption']); ?></figcaption>
				        </figure>
				    	<?php endforeach ?>
				    </div>
				    <!-- Controls -->
				    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				    	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				    	<span class="sr-only"><?php echo __("Previous"); ?></span>
				    </a>
				    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				    	<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				    	<span class="sr-only"><?php echo __("Next"); ?></span>
				    </a>
				</div>

				<div class="mobover overall">
					<div class="videorate">
						<div class="forrate"><?php echo $experience['Experience']['price_converted'] ?><span><?php echo __("per person"); ?></span></div>
						<div class="star1 all_reviews_popup_btn" id="">
							<a href="javascript:;" class="num exp_review_pop"><?php echo __("No Reviews Yet"); ?></a>
						</div>
					</div>
					<a href="#available_dates_popup" data-toggle="modal" data-target="#available_dates_popup" class="btn btn-primary pull-right"><?php echo __("See dates"); ?></a>
				</div>

				<div class="icon1" ng-init="link_copied=0">
					<span class="fonticon">
						<a class="share-btn" rel="nofollow" title="Facebook" href="#0" target="_blank">
							<span class="sr-only">Facebook</span>
							<i class="fa fa-facebook social-icon-size"></i>
						</a>
						<a class="share-btn" rel="nofollow" title="Twitter" href="#0" target="_blank">
							<span class="sr-only">Twitter</span>
							<i class="fa fa-twitter social-icon-size"></i>
						</a>
						 
						<a href="#share-popup">
							<span class="sr-only"><?php echo __('More'); ?></span>
							<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
						</a>
					</span>

					<span class="wishlist_save save">
						<span class="rich-toggle-unchecked">
						<?php echo __("Save to Wish List"); ?><i class="fa fa-heart-o icon-light-gray"></i>
						</span>
					</span>
				</div>

				<div class="price"><?php echo __("Prices may vary depending on the date you select."); ?></div>
			</div>
		</div>
		<div class="col-md-7 col-md-pull-5 col-sm-6 col-sm-pull-6 col-xs-12 experience_sec">
			<h2 class="exp__title"><?php echo h($experience['Experience']['title']); ?></h2>
			<h4 class="exp_tagline"><?php echo h($experience['Experience']['tagline']); ?></h4>
			<div class="row experie">
				<div class="col-md-10 col-sm-10 col-xs-10">
					<h3 class="exp__category">
						<?php echo h($experience['Category']['name']); ?>
					</h3>
					<div class="exp__host"><?php echo __('Hosted by'); ?>
						<?php echo $this->Html->link(h($experience['User']['name']), array('controller' => 'users', 'action' => 'view', $experience['User']['id']), array('escape' => false, 'class'=>'exp__host--link', 'target'=> '_blank', 'rel'=>'noopener noreferrer')); 
						?>
					</div>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2">
					<?php 
						echo $this->Html->link(
							$this->Html->displayUserAvatar($experience['User']['image_path'], array('alt'=>'logo', 'class'=>'img-responsive')),
							['controller' => 'users', 'action' => 'view', $experience['User']['id']],array('escape' => false, 'class'=>'pro', 'target'=>'_blank', 'rel'=>'noopener noreferrer')); 
					?>
				</div>
			</div>

			<div class="exper">
				<div class="time1">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<?php 
						echo $this->Html->link(h($experience['Address']['Country']['name']), '#experience_map', array('escape' => false, 'class'=>'js-scroll-to', 'data-offset-top' => '85')); 
					?>
				</div>
				<div class="time1">
					<i class="fa fa-clock-o" aria-hidden="true"></i>
					<?php 
						$time = new DateTime($experience['Experience']['start_time']);
						$timenow = new DateTime($experience['Experience']['end_time']);
						$interval = $timenow->diff($time);

						if ($interval->h > 0) {
							$total = $interval->h.".".$interval->i;
							echo __('%s Hours total.', $total);
						} else {
							echo __('%s Minutes total.', $interval->i);
						}
					?>
				</div>
				<!-- 
					## Here are displayed only the category of need provides
				<div class="time1">
					<i class="fa fa-file-text" aria-hidden="true"></i>
					Meal, Drinks, Accommodations and Transportation
				</div>
				-->
				<div class="time1">
					<i class="fa fa-comments" aria-hidden="true"></i>
					<?php echo __('Offered in %s', h($experience['Language']['name'])); ?>
				</div>
			</div>

			<div class="abthole">
				<h4 class="aboutdet"><?php echo __('About your host, %s', h($experience['User']['name'])); ?></h4> 
				<div class="forpro">
					<?php 
						echo $this->Html->tag('p', h($experience['Experience']['about_you']), array('class' => 'more_tag'));
					?>
				</div>
			</div>

			<div class="abthole">
				<h4 class="aboutdet"><?php echo __("What we'll do"); ?></h4>
				<div class="forpro">
					<?php 
						echo $this->Html->tag('p', h($experience['Experience']['what_will_do']), array('class' => 'more_tag'));
					?>
				</div>
			</div>
			
			<?php if ((int)$experience['Experience']['need_provides'] == 1 && false): ?>
			<div class="abthole">
				<h4 class="aboutdet"><?php echo __("What I'll provide"); ?></h4>
				<div class="forpro">
				</div>
			</div>
			<?php endif ?>

			
			<?php if ((int)$experience['Experience']['need_packing_lists'] == 1): ?>
			<div class="abthole">
				<h4 class="aboutdet"><?php echo __("Packing List"); ?></h4>
				<div class="forpro">
					<?php if (!empty($experience['Experience']['packing_list']) && is_array($experience['Experience']['packing_list'])): ?>
					<ul>
						<?php foreach ($experience['Experience']['packing_list'] as $key => $packing): ?>
							<li><?php echo h($packing); ?></li>
						<?php endforeach ?>
					</ul>
					<?php endif ?>
				</div>
			</div>
			<?php endif ?>

			<div class="abthole">
				<h4 class="aboutdet"><?php echo __('Who can come'); ?></h4>
				<div class="forpro">
					<p><?php echo __('Guests ages %s and up can attend.', h($experience['Experience']['minimum_age'])); ?></p>
				</div>
			</div>

			<div class="abthole">
				<h4 class="aboutdet"><?php echo __('Notes'); ?></h4>
				<div class="forpro">
					<?php 
						echo $this->Html->tag('p', h($experience['Experience']['notes']), array('class' => 'more_tag'));
					?>
				</div>
			</div>

			<div class="abthole">
				<h4 class="aboutdet"><?php echo __("Where we'll be"); ?></h4>
				<div class="forpro2">
				<?php 
					echo $this->Html->tag('p', h($experience['Experience']['where_will_be']), array('class' => 'more_tag'));
				?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div id="experience_map" class="mobile_location_area"></div>
				</div>
			</div>

			<div class="upcome height-limited">
				<h4><?php echo __('Upcoming availability'); ?></h4> 
			</div>

			<?php 
				$now = date('Y-m-d');
				$end = date('Y-m-d', strtotime('+4 days'));
				$period = new DatePeriod(
				    new DateTime($now),
				    new DateInterval('P1D'),
				    new DateTime($end)
				);
			?>
			<?php foreach ($period as $key => $value): ?>
			<div class="month">
				<!-- 
				<div class="row">
					<div class="col-md-12">
						<span class="label label-info" style="color: #fff">3 SPOT LEFT</span>
					</div>
				</div>
				-->
				<div class="update">
					<div class="monthup"><?php echo $value->format('Y-m-d'); ?></div>
					<div class="timing">
						<?php echo $experience['Experience']['start_time'] ?> - <?php echo $experience['Experience']['end_time'] ?>.&nbsp;<?php echo $experience['Experience']['price_converted'] ?><span><?php echo __("per person"); ?></span>
					</div>
				</div>
				<div class="choosebut">
					<a href="javascript:;" class="js-choose-booking-date" data-date="<?php echo $value->format('Y-m-d'); ?>" data-id="<?php echo $experience['Experience']['id'] ?>">
						<?php echo __('Choose date'); ?>
					</a>
				</div>
			</div>
			<?php endforeach ?>

			<div class="forsee available_dates_popup_btn" id="newshare">
				<a href="#available_dates_popup" data-toggle="modal" data-target="#available_dates_popup" data-effect="mfp-zoom-in" class="contlink"><?php echo __("See all available dates"); ?></a>
			</div>

			<h3 class="review"><?php echo __("Reviews"); ?></h3>
			<div class="forsee" id="all_reviews_popup_btn"><?php echo __("No Reviews Yet"); ?></div>

			<div class="abthole">
				<h4 class="aboutdet"><?php echo __("Group size"); ?></h4>
				<div class="forpro">
					<p><?php echo __("There are %d spots available on this experience.", 6); ?></p>
					<p class="help-text"><?php echo __("You don’t have to fill all of them. Experiences are meant to be social, so other travelers could join too."); ?></p>
				</div>
			</div>

			<div class="abthole abthole1">
				<h4 class="aboutdet"><?php echo __("Special certifications"); ?></h4>
				<div class="forpro">
					<?php 
						echo $this->Html->tag('p', h($experience['Experience']['special_certifications']), array('class' => 'more_tag'));
					?>
				</div>
			</div>

			<div class="abthole abthole1">
				<h4 class="aboutdet"><?php echo __("Additional requirements"); ?></h4>
				<div class="forpro">
					<?php 
						echo $this->Html->tag('p', h($experience['Experience']['additional_requirements']), array('class' => 'more_tag'));
					?>
				</div>
			</div>

			<div class="abthole abthole2 cancellation_policy">
				<h4 class="aboutdet"><?php echo __("Flexible cancellation policy"); ?></h4>
				<div class="forpro">
					<p>
						<?php  echo __('Any trip or experience can be canceled and fully refunded within 24 hours of purchase.') . '&nbsp;' , $this->Html->link(__('See cancellation policy'), '#0', array('escape' => false, 'class'=>'', 'target'=> '_blank', 'rel'=>'noopener noreferrer')); ?>
					</p>
				</div>
			</div>

			<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $experience['Experience']['id'], 'id' => 'expId'));?>

			<?php echo $this->Form->input('latitude', array('type'=>'hidden', 'value' => $experience['Address']['latitude'], 'id' => 'elat'));?>

			<?php echo $this->Form->input('longitude', array('type'=>'hidden', 'value' => $experience['Address']['longitude'], 'id' => 'elng'));?>

			<?php echo $this->Form->input('country', array('type'=>'hidden', 'value' => $experience['Address']['Country']['name'], 'id' => 'ecountry'));?>

			<?php echo $this->Form->input('address', array('type'=>'hidden', 'value' => $experience['Address']['address1'], 'id' => 'eaddress'));?>
		</div>
	</div>
</div>

<div class="modal fade" id="exp_review_pop" role="dialog" aria-labelledby="exp_review_popLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
				<button type="button" class="close detail_close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->tag('h3', __('Reviews!')) ?>
			</div>
            <div class="modal-body pad-30 wishlist_popup flleft experience_sec">
                <div id="exp_reviews"></div>
            </div>
            <div class="modal-footer">
            	<button type="button" data-dismiss="modal" class="btn btn-default"><?php echo __('Close');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="available_dates_popup" role="dialog" aria-labelledby="exp_review_popLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
				<button type="button" class="close detail_close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->tag('h3', __('When do you want to go?')) ?>
			</div>
            <div class="modal-body experience_sec">
            	<p>
            		<?php  echo __(' If you can’t find the dates you want, try') . '&nbsp;' , $this->Html->link(__('contacting the host'), '#0', array('escape' => false, 'class'=>'', 'target'=> '_blank', 'rel'=>'noopener noreferrer')); ?>
            	</p>
            	<?php 
            		$now = date('Y-m-d');
            		$end = date('Y-m-d', strtotime('+2 months'));
            		$period = new DatePeriod(
            		    new DateTime($now),
            		    new DateInterval('P1D'),
            		    new DateTime($end)
            		);
            	?>
            	<?php foreach ($period as $key => $value): ?>
            		<?php // debug([$key => $value]); ?>
            		<div class="row pad_tb_20">
	            		<!--
	            		<div class="col-md-12">
	            			<span class="label label-info" style="color: #fff">3 SPOT LEFT</span>
	            		</div>
	            		-->
            		    <div class="col-md-7 col-sm-7 col-xs-12">
            		        <p class="mar_btm_five"><?php echo $value->format('Y-m-d'); ?></p>
            		        <p class="mar_btm_five"> −  · <?php echo $experience['Experience']['start_time'] ?> - <?php echo $experience['Experience']['end_time'] ?>.&nbsp;<?php echo $experience['Experience']['price_converted'] ?><span><?php echo __("per person"); ?></span></p>
            		    </div>
            		    <div class="col-md-5 col-sm-5 col-xs-12 wish_list_action text-right">
            		        <button type="button" class="btn wishList_can js-choose-booking-date" data-id="<?php echo $experience['Experience']['id'] ?>" data-date="<?php echo $value->format('Y-m-d'); ?>"><?php echo __('Choose date'); ?></button>
            		    </div>
            		</div>
            	<?php endforeach ?>
            </div>
            <div class="modal-footer">
            	<button type="button" data-dismiss="modal" class="btn btn-default"><?php echo __('Close');?></button>
            </div>
        </div>
    </div>
</div>
<?php // debug($experience); ?>
<?php
$this->Html->script('//maps.googleapis.com/maps/api/js?libraries=places&amp;key='.Configure::read('Google.key').'&callback=initializeMap', array('block'=>'scriptBottomMiddle', 'async', 'defer'));
$this->Html->scriptBlock("
	var urisegment = location.pathname.split('/');
	var sgmnt      = urisegment[urisegment.length - 1];
	(function($){
		$(document).ready(function() {
			'use strict';

			// show more links
			showLessmore();

			// sidebar scroll
			$('#sticky').affix({
				offset: {
					top: $('#main_menu').outerHeight(true),
					bottom: $('#footer').outerHeight(true) + 60,
				}
			})

			/* Show more less option */
			$(document).on('click', '.morelink',function(e) {
			    e.preventDefault();
			    var _that = $(this);
			    if(_that.hasClass('less')) {
			        _that.removeClass('less');
			        _that.html('+ More');
			    } else {
			        _that.addClass('less');
			        _that.html('');
			    }
			    _that.parent().prev().toggle();
			    _that.prev().toggle();
			    return false;
			});

			/* Exp reviews */
			$(document).on('click', '.exp_review_pop', function(e){
			    var expId = $('#expId').val();
			    $.ajax({
			        type: 'POST',
			        url : fullBaseUrl+'/experience/getReviews/' + expId,
			        data: {
			            exp_id  : expId,
			        },
			        dataType : 'json',
			        success: function(res) {
			            $('#exp_reviews').html(res.result);
			            showLessmore();
			            $('#exp_review_pop').modal('show');
			        }
			    });
			    return false;
			});
			
			/* Book an exp */
			$(document).on('click', '.js-choose-booking-date', function() {
			    var exp_id = $(this).data('id');
			    var date = $(this).data('date');
			    var permission = $('#permission').val();

		        $.ajax({
		            type: 'POST',
		            url : fullBaseUrl+'/experience/check',
		            data: {
		            	exp_id:exp_id,
		            	date:date
		            },
		            dataType : 'json',
		            success: function(data, textStatus, xhr) {
		            	if (textStatus == 'success') {
		            		var response = $.parseJSON(JSON.stringify(data));
		            		if (response.error) {
		            			toastr.error(response.message, 'Error!');
		            		} else {

		            		}
		            	} else {
		            		toastr.warning(textStatus, 'Warning!');
		            	}

		            	// if (res.msg == 'success') {
		                //     window.location.replace(base_url+'experiences/'+sgmnt+'/book/guest-requirements?scheduled_id='+res.id);   
		                // } else if(res.msg == 'unauthorised') {
		                //     $('#exp_dates_pop').modal('hide');
		                //     $('#Login_pop').modal('show');
		                // }
		            },
		        });
				return false;
			});

		});
	})(jQuery);
", array('block' => 'scriptBottom'));
?>

<script>
	function showLessmore() {
	    var showChar = 125;
	    var ellipsestext = "...";
	    var moretext = "+ More";
	    var lesstext = "- Less";

	    $('.more_tag').each(function() {
	        var content = $(this).html();
	        if(content.length > showChar) {
	            var c = content.substr(0, showChar);
	            var h = content.substr(showChar, content.length - showChar);
	            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript:void(0);" style="color: #008489;" class="morelink">' + moretext + '</a></span>';
	            $(this).html(html);
	        }
	    });
	}
	/**
	 * initializeMap
	 * initialize google map to show the circle of proprty
	 * once the script has fully loaded
	 *
	 * @return void
	 */
	function initializeMap() {
		if (typeof(google) == 'undefined') {
			// Insecure Connection!
			// Your system date is wrong, please change it.
			// window.location.href = fullBaseUrl+'/in_secure';
			console.log('Insecure Connection! Your system date is wrong, please change it.');
			return false;
		}

		/* Google map */
		var latitude   = $('#elat').val();
		var longitude  = $('#elng').val();
		var ecountry   = $('#ecountry').val();
		var eaddress   = $('#eaddress').val();
		var roomlatlng = {lat:parseFloat(latitude), lng: parseFloat(longitude)};


		// Create the map.
		var map = new google.maps.Map(document.getElementById('experience_map'), {
		    zoom            : 13,
		    center          : roomlatlng,
		    scaleControl    : false,
		    scrollwheel     : false,
		    disableDefaultUI: true,
		    mapTypeControl  : false,
		});
		// info window
		infoWindow = new google.maps.InfoWindow();
		var windowLatLng = new google.maps.LatLng(parseFloat(latitude),parseFloat(longitude));
		infoWindow.setOptions({
		    content: '<div class="exp_head">Where we’ll meet</div><div class="exp_loc"> '+eaddress +' · '+ecountry+'</div>',
		    position: windowLatLng,
		});
		infoWindow.open(map);
		// Add the circle for this city to the map.
		var cityCircle = new google.maps.Circle({
		    strokeColor     : '#008489',
		    strokeOpacity   : 0.8,
		    strokeWeight    : 2,
		    fillColor       : '#008489',
		    fillOpacity     : 0.35,
		    map             : map,
		    center          : roomlatlng,
		    radius          : 500
		});
	}
</script>


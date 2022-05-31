<style>
	.flright {
	    float: right;
	}

	.right_top {
		padding-left: 30px;
	    margin-bottom: 50px;
		position: relative;
	    overflow: hidden;
	}

	.exp_img {
		width: 100%;
	    height: 460px;
	    object-fit: cover;
	}

	@media (min-width: 767px) {
		.right_top.fixed_div_ex{
		    margin-top: 20px;
		}
		.fixed_div_ex {
			position: fixed;
			top: 0;
			z-index: 10;
			max-width: 342px;
		}		
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
	    width: 60px;
	    float: right;
	}

	.pro img {
	    max-width: 100%;
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
	    overflow: hidden;
	    cursor: pointer !important;
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
	    width: 100px;
	    padding: 7px 10px;
	    border-radius: 5px;
	    border: 1px solid #008489;
	    background: transparent;
	    color: #008489;
	    float: right;
	    text-align: center;
	    font-weight: 500;
	     /*font-family: 'Roboto', sans-serif;*/
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
<div class="row experiences view">
	<div class="col-md-5 col-sm-6 col-xs-12 flright">
		<div class="right_top" id="sticky">
			<img src="https://abservetechdemo.com/products/airstar/airbnb/public/uploads/experiences/208/1549105672-491.png" class="exp_img img-responsive">

			<div class="mobover overall">
				<div class="videorate">
					<div class="forrate"><?php echo $experience['Experience']['price_converted'] ?><span>per person </span> </div>
					<div class="star1 all_reviews_popup_btn" id="">
						<span class="num"> No Reviews Yet </span>
					</div>
				</div>
				<a href="#available_dates_popup" class="btn btn-primary pull-right">See dates</a>
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
						<span class="sr-only">More</span>
						<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
					</a>
				</span>

				<span class="wishlist_save save">
					<span class="rich-toggle-unchecked">
					Save to Wish List <i class="fa fa-heart-o icon-light-gray"></i>
					</span>
				</span>
			</div>

			<div class="price">Prices may vary depending on the date you select.</div>
		</div>
	</div>
	<div class="col-md-7 col-sm-6 col-xs-12 experience_sec">

		<h2 class="exp__title"><?php echo h($experience['Experience']['title']); ?></h2>
		<h4 class="exp_tagline"><?php echo h($experience['Experience']['tagline']); ?></h4>
		<div class="row experie">
			<div class="col-md-10 col-sm-10 col-xs-10">
				<h3 class="exp__category">
					<?php echo h($experience['Category']['name']); ?>
				</h3>
				<div class="exp__host"><?php echo __('Hosted by'); ?>
					<?php echo $this->Html->link(h($experience['User']['name']), array('controller' => 'users', 'action' => 'view', $experience['User']['id']), array('escape' => false, 'class'=>'exp__host--link', 'target'=> '_blank')); 
					?>
				</div>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-2">
			<?php 
				echo $this->Html->link(
					$this->Html->displayUserAvatar($experience['User']['image_path'], array('alt'=>'logo', 'class'=>'img-responsive')),
					['controller' => 'users', 'action' => 'view', $experience['User']['id']],array('escape' => false, 'class'=>'pro', 'target'=>'_blank')); 
			?>
			</div>
		</div>

		<div class="exper">
			<div class="time1">
				<i class="fa fa-clock-o" aria-hidden="true"></i>
				4 hours total 
			</div>
			<div class="time1">
				<i class="fa fa-file-text" aria-hidden="true"></i>
				Meal, Drinks, Accommodations and Transportation
			</div>
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

		<div class="abthole">
			<h4 class="aboutdet"><?php echo __("What I'll provide"); ?></h4>
			<div class="forpro">
				<p>8 dishes
					<img src="http://makent.trioangle.com/images/host_experiences/provide_items/icon_meal.png" class="provide_icon">
				</p>
				<p>Spicy or non-spicy food are all accommodated. People with allergy and vegetarians are all accommodated
				</p>
				<p>Drinks
				<img src="http://makent.trioangle.com/images/host_experiences/provide_items/icon_drinks.png" class="provide_icon">
				</p>
				<p>Non alcoholic and alcoholic drinks are all included
				</p>
				<p>A helmet + a poncho
				<img src="http://makent.trioangle.com/images/host_experiences/provide_items/icon_accommodations.png" class="provide_icon">
				</p>
				<p>(Poncho if it rains)
				</p>
				<p>Motorbike ride
				<img src="http://makent.trioangle.com/images/host_experiences/provide_items/icon_transportation.png" class="provide_icon">
				</p>
				<p>A motorbike with an English speaking local
				</p>
			</div>
		</div>

		<div class="abthole">
			<h4 class="aboutdet"><?php echo __("Who can come"); ?></h4>
			<div class="forpro">
				<p><?php echo __('Guests ages %s and up can attend.', h($experience['Experience']['minimum_age'])); ?></p>
			</div>
		</div>

		<div class="abthole">
			<h4 class="aboutdet"><?php echo __("Notes"); ?></h4>
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
			<h4> Upcoming availability </h4> 
		</div>

		<div class="month">
			<div class="update">
				<div class="monthup">17/04/2019</div>
				<div class="timing">10:00 - 14:00. <?php echo $experience['Experience']['price_converted'] ?><span>per person </span> </div>
			</div>
			<div class="choosebut">
				<a href="javascript:void(0);" id="js_choose_btn_0" class="js-choose-booking-date" data-date="2019-04-17">Choose
				</a>
			</div>
		</div>

		<div class="month">
			<div class="update">
				<div class="monthup">18/04/2019</div>
				<div class="timing">10:00 - 14:00. <?php echo $experience['Experience']['price_converted'] ?><span>per person </span> </div>
			</div>
			<div class="choosebut">
				<a href="javascript:void(0);" id="js_choose_btn_0" class="js-choose-booking-date" data-date="2019-04-17">Choose
				</a>
			</div>
		</div>

		<div class="month">
			<div class="update">
				<div class="monthup">19/04/2019</div>
				<div class="timing">10:00 - 14:00. <?php echo $experience['Experience']['price_converted'] ?><span>per person </span> </div>
			</div>
			<div class="choosebut">
				<a href="javascript:void(0);" id="js_choose_btn_0" class="js-choose-booking-date" data-date="2019-04-17">Choose
				</a>
			</div>
		</div>

		<div class="month">
			<div class="update">
				<div class="monthup">20/04/2019</div>
				<div class="timing">10:00 - 14:00. <?php echo $experience['Experience']['price_converted'] ?><span>per person </span> </div>
			</div>
			<div class="choosebut">
				<a href="javascript:void(0);" id="js_choose_btn_0" class="js-choose-booking-date" data-date="2019-04-17">Choose
				</a>
			</div>
		</div>

		<div class="forsee available_dates_popup_btn" id="newshare">
			<a href="#available_dates_popup" data-effect="mfp-zoom-in" class="contlink">See all available dates </a>
		</div>


		<h3 class="review">Reviews</h3>
		<div class="forsee" id="all_reviews_popup_btn">No Reviews Yet</div>

		<div class="abthole">
			<h4 class="aboutdet"><?php echo __("Group size"); ?></h4>
			<div class="forpro">
				<p>There are 6 spots available on this experience.</p>
				<p class="help-text">You don’t have to fill all of them. Experiences are meant to be social, so other travelers could join too. </p>
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
				<p>Any trip or experience can be canceled and fully refunded within 24 hours of purchase.<a target="_blank" href="#0" class="newa">See cancellation policy</a>
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

<?php // debug($experience); ?>

<?php
$this->Html->script('//maps.googleapis.com/maps/api/js?libraries=places&amp;key='.Configure::read('Google.key').'&callback=initializeMap', array('block'=>'scriptBottomMiddle', 'async', 'defer'));
$this->Html->scriptBlock("
	(function($){
		$(document).ready(function() {
			'use strict';
			showLessmore();

			/* Show more less option */
			$(document).on('click','.morelink',function(e) {
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

			var stickyElement = $('#sticky');
			var f = stickyElement.offset().top;
			$(window).scroll(function(){
			    var scroll = $(window).scrollTop();
			    var s = ($('header').outerHeight() + $('.experience_sec').height()) - stickyElement.height();
			    var test = $('.experience_sec').height()- stickyElement.height();
			    if(scroll > s) {
			        stickyElement.removeClass('fixed_div_ex').addClass('relative_div').css({'top': test});
			    } else {
			        if (scroll > f) {
			            stickyElement.addClass('fixed_div_ex').removeClass('relative_div').css({'top': '0px'});
			        } else {
			        	stickyElement.removeClass('fixed_div_ex');
			        }
			    }
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
		}

		/* Google map */
		var latitude    = $('#elat').val();
		var longitude   = $('#elng').val();
		var ecountry    = $('#ecountry').val();
		var eaddress    = $('#eaddress').val();
		var roomlatlng  = {lat:parseFloat(latitude), lng: parseFloat(longitude)};


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


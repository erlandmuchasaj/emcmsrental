<style scoped>
	
.relative_holder {
    position: relative;
}

.search_home {
    text-shadow: 1px 1px 40px rgba(22, 23, 31, 0.4);
    margin-top: 0;
    margin-bottom: 40px;
    font-size: 48px;
    width: 80%;
    text-align: left;
    font-family: azo_sansbold;
    color: #fff;
}

.search-tabs {
    width: 100%;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
}

.hotel_search_form {
	border: 1px solid #fff;
	float: left;
	width: 100%;
}

.hotel_search_form .form-control {
    border: 0px none;
    height: auto;
    padding: 5px 0px;
    font-size: 18px;
    background-color: #fff;
    color: #484848;
    box-shadow: none;
    font-family: azo_sanslight;
}


.hotel_search_form .btn-primary {
    max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    float: right;
    text-transform: capitalize;
    font-size: 17px;
    position: absolute;
    right: 10px;
    top: 12px;
    font-family: azo_sanslight;
}


.hotel_search_form .form-group {
    margin-bottom: 0px;
}

/*New design*/
.search_rooms {
    padding: 15px 115px 15px 60px;
    background: #fff;
}

.search_img {
    position: absolute;
    left: 15px;
    top: 18px;
}

.back_slider {
    height: 450px;
    width: 100%;
    overflow: hidden;
}

.front_slider {
    margin: 0 auto;
    position: relative;
    width: 100%;
    background-color: rgb(25, 30, 23);
    height: 100%;
}

.front_slider > div {
    position: absolute;
    top: 0;
    width: 100%;
}

.activeimg1 {
    animation: fade 2s linear;
    transform: translateY(-10%);
    -moz-transform: translateY(-10%);
    -webkit-transform: translateY(-10%);
}

#bigImage {
	width: 100%;
	height: 500px;
	object-fit: cover;
	max-width: 100%;
	vertical-align: middle;
}
@media only screen and (min-width: 1200px) {
    .back_slider {
        height: 750px;
    }
    #bigImage{
    	height:800px;
    }
}
</style>

<div class="relative_holder">
    <div class="back_slider">
        <div class="front_slider">
            <div class="activeimg">
                <?php echo $this->Html->image('general/Header/1.jpg', array('alt' => 'image_path', 'class'=>'', 'id' => 'bigImage'));  ?>
            </div>
        </div>
    </div>    
    <div class="search-tabs">
        <div class="container">
            <h2 class="search_home"><?php echo $caption; ?></h2>
			<?php  echo $this->Form->create("Property",array('type' => 'get', 'url' => array('controller'=>'properties', 'action'=>'search'), 'class' => 'hotel_search_form', 'id'=>'search', 'onkeypress'=>'return event.keyCode != 13;'));  ?>

				<div class="col-md-12 col-sm-12 col-xs-12 search_rooms">
				    <div class="search_img">
				        <svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="height: 24px; width: 24px; display: block; fill: rgb(118, 118, 118);"><path d="m10.4 18.2c-4.2-.6-7.2-4.5-6.6-8.8.6-4.2 4.5-7.2 8.8-6.6 4.2.6 7.2 4.5 6.6 8.8-.6 4.2-4.6 7.2-8.8 6.6m12.6 3.8-5-5c1.4-1.4 2.3-3.1 2.6-5.2.7-5.1-2.8-9.7-7.8-10.5-5-.7-9.7 2.8-10.5 7.9-.7 5.1 2.8 9.7 7.8 10.5 2.5.4 4.9-.3 6.7-1.7v.1l5 5c .3.3.8.3 1.1 0s .4-.8.1-1.1" fill-rule="evenodd"></path></svg>
				    </div>
				    <div class="form-group form-group-lg">
				        <?php echo $this->Form->input('location', array('type'=>'text', 'div'=>false, 'label'=>false, 'class'=>'form-control city_tab',  'id'=>'property_address', 'placeholder'=>__('Where you wanna go'), 'value' => '', 'autocomplete' => 'off', 'required' => 'required')); ?>
				        <div id="city_err" style=" display: none; text-align: left;">Anywhere</div>
				    </div>
				    <button class="btn btn-primary" type="submit">
				    	<?php echo __('Search'); ?>
				    </button>
				</div>
			<?php echo $this->Form->input('lat', ['type' => 'hidden', 'id' => 'search_field_lat']);?>
			<?php echo $this->Form->input('lng', ['type' => 'hidden', 'id' => 'search_field_lng']);?>
			<?php echo $this->Form->input('page',array('type'=>'hidden', 'value'=>1));?>
			<?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<?php
	$this->Html->scriptBlock("
		(function($){
			$(document).ready(function() {
				'use strict';
				var imgTimer = setInterval(changeImageByTimer, 7000);
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>

<script type="text/javascript">
        var imageArray = [
            fullBaseUrl+"/img/general/Header/1.jpg",
            fullBaseUrl+"/img/general/Header/2.jpg"
        ];
        var n=1;
        var loopLength = imageArray.length;
        function changeImageByTimer() {
            if(n>=loopLength){
                n=0;
            }
            var $bigImage = $('#bigImage');
            $bigImage.fadeOut(1500, function () {
                $bigImage.parent().removeClass('activeimg').addClass('activeimg1');
            });
            var x=n;
            if(n<loopLength){
	            $bigImage.fadeOut(1500, function () {
	                $bigImage.attr('src', imageArray[x]).fadeIn(800);
	                $bigImage.parent().removeClass('activeimg1').addClass('activeimg');
	            });
        	}
	        $bigImage.animate({opacity: 1});
	        n++;
    	}
</script>
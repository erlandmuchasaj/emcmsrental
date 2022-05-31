<?php echo $this->Html->css('frontend/fotorama/fotorama', null, array('block'=>'cssMiddle')); ?>
<div class="fotorama-wrap-frontpage fotorama-frontpage">
	<div id="fotorama_homeslider" class="fotorama">
		<a href="<?php echo $this->webroot.'img/placeholder.png';?>"></a>
	</div>

	<?php  echo $this->Form->create("Property",array('type' => 'get', 'url' => array('controller'=>'properties', 'action'=>'search'), 'class' => 'form-inline search-filters', 'id'=>'search', 'onkeypress'=>'return event.keyCode != 13;'));  ?>

	<div class="form-group book-style">
		<div class="input-group search-property">
			<?php echo $this->Form->input('location', array('type'=>'text', 'div'=>false, 'label'=>false, 'class'=>'form-control search-style',  'id'=>'property_address', 'placeholder'=>__('Where you wanna go'), 'value' => '', 'autocomplete' => 'off', 'required' => 'required')); ?>
			<div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
		</div>
	</div>

	<div class="form-group book-style">
		<div class="input-group search-property readonly">
			<?php echo $this->Form->input('checkin',array('type'=>'text', 'div'=>false, 'label'=>false, 'class'=>'form-control search-style calendar-text-search', 'placeholder'=>__('Checkin'), 'id'=>'checkin', 'autocomplete'=>'off', 'readonly'=>'readonly')); ?>
			<div class="input-group-addon check_in_trigger"><i class="fa fa-calendar"></i></div>
		</div>
	</div>

	<div class="form-group book-style">
		<div class="input-group search-property readonly">
			<?php echo $this->Form->input('checkout',array('type'=>'text', 'div'=>false, 'label'=>false, 'class'=>'form-control search-style calendar-text-search', 'placeholder'=>__('Checkout'), 'id'=>'checkout', 'autocomplete'=>'off', 'readonly'=>'readonly')); ?>
			<div class="input-group-addon check_out_trigger"><i class="fa fa-calendar"></i></div>
		</div>
	</div>

	<div class="form-group book-style">
		<?php echo $this->Form->input('capacity',array( 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('capacity')));  ?>
	</div>

	<div class="form-group book-style">
		<button type="submit" class="btn btn-green search-btn"><?php echo __('Search'); ?></button>
	</div>
	<?php echo $this->Form->input('lat', ['type' => 'hidden', 'id' => 'search_field_lat']);?>
	<?php echo $this->Form->input('lng', ['type' => 'hidden', 'id' => 'search_field_lng']);?>
	<?php echo $this->Form->input('page',array('type'=>'hidden', 'value'=>1));?>
	<?php echo $this->Form->end(); ?>
</div>

<?php
	$this->Html->script('frontend/fotorama/fotorama', array('block'=>'scriptBottomMiddle'));
	$this->Html->scriptBlock("
		(function($){
			$(document).ready(function() {
				'use strict';
				// calendar trigger show
				$('.check_out_trigger').off('click');
				$('.check_out_trigger').on('click', function(){
					$('#checkout').datepicker('show');
				});

				$('.check_in_trigger').off('click');
				$('.check_in_trigger').on('click', function(){
					$('#checkin').datepicker('show');
				});

				$('#checkin').datepicker({
				    minDate: 0,
				    dateFormat: 'yy-mm-dd',
				    beforeShow: function(input, inst) {
				        setTimeout(function() {
				            inst.dpDiv.find('a.ui-state-highlight').removeClass('ui-state-highlight');
				            $('.ui-state-disabled').removeAttr('title');
				            $('.highlight').not('.ui-state-disabled').tooltip({container:'body'});
				        }, 100);
				    },
				    onSelect: function (date) {
				        var checkout = $('#checkin').datepicker('getDate');
				        checkout.setDate(checkout.getDate() + 1);
				        $('#checkout').datepicker('setDate', checkout);
				        $('#checkout').datepicker('option', 'minDate', checkout);
				        setTimeout(function(){
				            $('#checkout').datepicker('show');
				        }, 20);
				    },
					onChangeMonthYear: function() {
						setTimeout(function(){
							$('.highlight').not('.ui-state-disabled').tooltip({container:'body'});
						},100);  
					}
				});

				$('#checkout').datepicker({
				    dateFormat: 'yy-mm-dd',
				    minDate: 1,
				    onClose: function ()  {
				        var checkin = $('#checkin').datepicker('getDate');
				        var checkout = $('#checkout').datepicker('getDate');
				        if (checkout <= checkin) {
				            var minDate = $('#checkout').datepicker('option', 'minDate');
				            $('#checkout').datepicker('setDate', minDate);
				        }
				        if($('#checkin').val()=='')  {
					        var checkin = $('#checkout').datepicker('getDate');
					        checkin.setDate(checkin.getDate() -1 );
					        $('#checkin').datepicker('setDate',  new Date());
					        $('#checkout').datepicker('option', 'minDate', checkout);
					        setTimeout(function(){
					            $('#checkin').datepicker('show');
					        }, 20);
				        }
				    }
				});

				// inicialise fotorama
				if ($.isFunction($.fn.fotorama) && $('#fotorama_homeslider').length) {
					// 1. Initialize fotorama manually.
					var fotoramaDiv = $('#fotorama_homeslider').fotorama({
						fit     : 'cover',
						loop    : true ,
						autoplay: 6500,
						arrows  : false,
						nav     : false,
						click   : false,
						swipe   : true,
						trackpad: true,
						width   : '100%',
						height  : '100%',
						transition : 'dissolve', /*crossfade*/
						stopautoplayontouch: false
					});

					// 2. Get the API object.
					var fotorama = fotoramaDiv.data('fotorama');
					
					// Load slider content with Ajax
					$.ajax({
						url: fullBaseUrl+'/home_sliders/load',
						type: 'POST',
						dataType: 'json',
						data:'',
						beforeSend: function() {
							// called before response
						},
						success: function(data, textStatus, xhr) {
							//called when successful
							if (textStatus == 'success') {
								var response = $.parseJSON(JSON.stringify(data));
								if (!response.error) {
									fotorama.load(response.data);
								}
							}
						},
						complete: function(xhr, textStatus) {
							//called when complete
						},
						error: function(xhr, textStatus, errorThrown) {
						}
					});
				};
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>
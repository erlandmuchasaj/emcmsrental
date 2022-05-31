<?php echo $this->Html->css('frontend/daterangepicker/daterangepicker', null, array('block'=>'cssMiddle')); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="textHeaderContainerMarginTop">
			<div class="textHeader">
				<?php echo $this->Html->tag('h1', Configure::read('Website.name'), ['class' => 'textHeaderTitle']); ?>
		    	<?php echo $this->Html->tag('p', Configure::read('Website.tagline')); ?>
		   </div>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	    <?php  echo $this->Form->create('Property', array('type' => 'get', 'url' => array('admin' => false, 'controller' => 'properties', 'action' => 'search'), 'class' => 'form-inline', 'id'=>'search', 'onkeypress'=>'return event.keyCode != 13;')); ?>
		<div class="search-filter-container">
			<div class="_2Bk9-">
				<div class="OSsbS">
					<div class="filter-container location-filter">
				    	<label class="search-filter-label" for="property_address"><?php echo __('Where'); ?></label>
				    	<?php echo $this->Form->input('location', array('type'=>'text', 'div'=>false, 'label'=>false, 'class'=>'search-style input-filter',  'id'=>'property_address', 'placeholder'=>__('Anywhere'), 'value' => '', 'autocomplete' => 'off', 'required' => 'required')); ?>
					</div>
					<div class="filter-container date-filter">
						<label class="search-filter-label" for="check_in_out"><?php echo __('When'); ?></label>

						<div class="input-group search-wrapper">
							<?php echo $this->Form->input('check_in_out',array('type'=>'text', 'div'=>false, 'label'=>false, 'class'=>'search-style input-filter', 'id'=>'check_in_out', 'placeholder'=>__('Anytime'), 'autocomplete' => 'off', 'readonly' => 'readonly')); ?>
							<div class="input-group-addon reset-calendar"><i class="fa fa-refresh refresh-btn" aria-hidden="true"></i></div>
						</div>
						<?php echo $this->Form->input('checkin',array('type'=>'hidden', 'id'=>'checkin')); ?>
						<?php echo $this->Form->input('checkout',array('type'=>'hidden', 'id'=>'checkout')); ?>
					</div>
					<div class="filter-container guest-filter">
						<label class="search-filter-label" for="guest_capacity"><?php echo __('Guest'); ?></label>
						<?php echo $this->Form->input('capacity',array('label'=>false, 'div'=>false, 'id'=>'guest_capacity', 'class'=>'input-filter gst gst_icon','type'=>'select','options' => $this->Html->getData('capacity')));  ?>
					</div>
					<div class="filter-container button-filter">
						<button type="submit" class="searchButton"><?php echo __('Search'); ?></button>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->input('lat', ['type' => 'hidden', 'id' => 'search_field_lat']);?>
		<?php echo $this->Form->input('lng', ['type' => 'hidden', 'id' => 'search_field_lng']);?>
	    <?php echo $this->Form->input('page', ['type' => 'hidden', 'value' => 1]);?>
	    <?php echo $this->Form->end(); ?>
	</div>
</div>
<?php
	$this->Html->script('frontend/daterangepicker/moment.min', array('block'=>'scriptBottomMiddle'));
	$this->Html->script('frontend/daterangepicker/daterangepicker.min', array('block'=>'scriptBottomMiddle'));
	$this->Html->scriptBlock("
		(function($){
			$(document).ready(function() {
				'use strict';
				// inicialise daterangepicker
				if ($.isFunction($.fn.daterangepicker) && $('#check_in_out').length) {
					var start = moment();
					$('#check_in_out').daterangepicker({
						parentEl: 'body',
						startDate: start,
					    minDate: start,
					    dateLimitMin:{
					       'days': 1
					    },
					    locale: {
					      format: 'YYYY-MM-DD',
					      separator: ' / ',
					      cancelLabel: 'Clear'
					    },
					    autoApply: true,
					    autoUpdateInput: false,
					}, 
					function(start, end) {
						$('#check_in_out').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
						$('#checkin').val(start.format('YYYY-MM-DD'));
						$('#checkout').val(end.format('YYYY-MM-DD'));
					});
					
					// fill checkin and ceckout dates
					$('#check_in_out').on('apply.daterangepicker', function(ev, picker) {
						var startDateInput = $('#checkin'),
							endDateInput = $('#checkout');

						var startDate = picker.startDate,
							endDate = picker.endDate;

						startDateInput.val(startDate.format('YYYY-MM-DD'));
						endDateInput.val(endDate.format('YYYY-MM-DD'));
					});

					$(document).on('click', '.refresh-btn', function(ev, picker) {
						var startDateInput = $('#checkin'),
							endDateInput = $('#checkout'),
							rangeInput = $('#check_in_out');

						startDateInput.val('');
						endDateInput.val('');
						rangeInput.val('');
						rangeInput.data('daterangepicker').setStartDate(start);
						rangeInput.data('daterangepicker').setEndDate(start);
					});

					// $(window).scroll(function(){
					// 	$('#check_in_out').data('daterangepicker').hide();
					// });
				};
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>
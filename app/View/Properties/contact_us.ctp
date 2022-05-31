<?php
	/*This css is applied only to this page*/        
	// echo $this->Html->css('', null, array('block'=>'cssMiddle'));

	$localeCurrency = $this->Html->getLocalCurrency();

	$number_of_adults = array(
		1 => 1, 
		2 => 2, 
		3 => 3, 
		4 => 4, 
		5 => 5, 
		6 => 6, 
		7 => 7, 
		8 => 8, 
		9 => 9, 
		10 => 10, 
		11 => 11, 
		12 => 12, 
		13 => 13, 
		14 => 14, 
		15 => 15, 
		16 => 16, 
		17 => 17, 
		18 => 18, 
		19 => 19, 
		20 => 20, 
		'21+' => 21,
	);   

	$number_of_children = array(
		0 => 0, 
		1 => 1,
		2 => 2,
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 10,
		11 => 11,
	);   

	$options = array(
		1   => '0-10000', 
		2 => '10001-20000', 
		3 => '20001-30000', 
		4 => '30001-50000', 
		5 => '50001-75000', 
		6 => '75001-100000', 
		7 => '100000+' 
	);
?>
<!-- Content -->
<div class="home-wrapper view-property">
	<div class="home-content">
		<!-- ****************** -->
		<!-- page content START -->
		<!-- ****************** -->
		<div class="row remove-margin">
			<div class="col-sm-6 single-property">
				<div class="row">
					<div class="col-sm-12 single-property remove-padding">
						<h2 class="page-title">
							<?php echo __('Contact us'); ?>
						</h2>
						<h5>
							<?php 
								echo __('Please fill out the following form and we will gladly prepare an individually-tailored holiday booking quote for you.');
							?>
						</h5>
					</div>
				</div>

				<?php echo $this->Form->create('Contact',array('url'=>array('admin'=>false,'user'=>false, 'controller' => 'properties', 'action' => 'contactUs') ,'class'=>'form-horizontal', 'id'=>'contact-form')); ?>
					
					<!-- Title -->
					<div class="form-group book-style">
						<label style="font-weight: lighter;"><?php echo __('Title'); ?>*</label>
						<?php
						echo $this->Form->input('title',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','empty'=>__('Please Select'), 'options' =>array('ms'=>'MS','mr'=>'MR'),'required'=>'required')); 
						?>
					</div> 
					
					<!-- firstname -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('Firstname'); ?>*</label>
						<div class="input-group search-property">
							<?php
								echo $this->Form->input('name',array('type'=>'text', 'label'=>false, 'div'=>false,'class'=>'form-control search-style count-char','autocomplete'=>'off','placeholder'=>__('Firstname'), 'data-minlength'=>'0', 'data-maxlength'=>'100','required'=>'required')) 
							?>
							<div class="input-group-addon">
								<i class="fa fa-info"></i>
							</div>
						</div>
					</div>
					
					<!-- Lastname -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('Lastname'); ?>*</label>
						<div class="input-group search-property">
							<?php
								echo $this->Form->input('surname',array('type'=>'text', 'label'=>false, 'div'=>false,'class'=>'form-control search-style count-char','autocomplete'=>'off','placeholder'=>__('Lastname'), 'data-minlength'=>'0', 'data-maxlength'=>'100','required'=>'required')) 
							?>
							<div class="input-group-addon">
								<i class="fa fa-info"></i>
							</div>
						</div>
					</div>
					
					<!-- e-mail -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('Email'); ?>*</label>
						<div class="input-group search-property">
							<?php
								echo $this->Form->input('email',array('type'=>'email', 'label'=>false, 'div'=>false,'class'=>'form-control search-style','autocomplete'=>'off','placeholder'=>__('Email'),'required'=>'required')) 
							?>
							<div class="input-group-addon">
								<i class="fa fa-at"></i>
							</div>
						</div>
					</div>	

					<!-- phone  number -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('Phone'); ?></label>
						<div class="input-group search-property">
							<?php
								echo $this->Form->input('phone_number',array('type'=>'number', 'label'=>false, 'div'=>false,'class'=>'form-control search-style allow-only-numbers pozitive_number','autocomplete'=>'off','placeholder'=>__('Phone'))) 
							?>
							<div class="input-group-addon">
								<i class="fa fa-phone"></i>
							</div>
						</div>
					</div>	
					
					<!-- message -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('Message'); ?>*</label>
						<div class="search-property">
							<?php
								echo $this->Form->input('text',array('type'=>'textarea', 'label'=>false, 'div'=>false,'class'=>'form-control search-style count-char','autocomplete'=>'off','placeholder'=>__('Message goes here'), 'data-minlength'=>'0', 'data-maxlength'=>'2048','required'=>'required')) 
							?>
						</div>
					</div>	

					<!-- check in -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('Checkin'); ?></label>
						<div class="input-group search-property readonly">
							<?php echo $this->Form->input('checkin',array('label'=>false, 'div'=>false,'class'=>'form-control calendar-text-search search-style','type'=>'text', 'id'=>'check_in', 'placeholder'=>__('Checkin'), 'autocomplete'=>'off', 'readonly'=>'readonly' )); ?>
							<div class="input-group-addon check_in_trigger"><i class="fa fa-calendar"></i></div>
						</div>
					</div>

					<!-- check out -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('Checkout'); ?></label>
						<div class="input-group search-property readonly">
							<?php echo $this->Form->input('checkout',array('label'=>false, 'div'=>false,'class'=>'form-control calendar-text-search search-style','type'=>'text', 'id'=>'check_out', 'placeholder'=>__('Checkout'), 'autocomplete'=>'off', 'readonly'=>'readonly' )); ?>
							<div class="input-group-addon check_out_trigger"><i class="fa fa-calendar"></i></div>
						</div>
					</div>
					
					<!-- number of adults -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('No. of adults'); ?></label>
						<?php
						echo $this->Form->input('number_of_adults',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','empty'=>__('Please Select'), 'options' => $number_of_adults)); 
						?>
					</div> 
					
					<!-- number of children -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('No. of children'); ?></label>
						<?php
						echo $this->Form->input('number_of_children',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','empty'=>__('Please Select'), 'options' => $number_of_children)); 
						?>
					</div> 
					
					<!-- budget -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('Budget'); ?>*</label>
						<?php
						echo $this->Form->input('budget',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','empty'=>__('Please Select'), 'options' =>$options,'required'=>'required')); 
						?>
					</div> 
					
					<!-- destination & Region -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('Destination / Region'); ?></label>
						<div class="input-group search-property">
							<?php
								echo $this->Form->input('destination',array('type'=>'text', 'label'=>false, 'div'=>false,'class'=>'form-control search-style','autocomplete'=>'off','placeholder'=>'Destination')) 
							?>
							<div class="input-group-addon">
								<i class="fa fa-globe"></i>
							</div>
						</div>
					</div>
					
					<!-- about us -->
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php echo __('How did you hear about us?'); ?></label>
						<?php
						echo $this->Form->input('how_you_know_us',array('label'=>false, 'div'=>false,'class'=>'form-control dropdown-select','type'=>'select','empty'=>__('Please Select'), 'options' =>array('search_engine'=>__('Search Engine (Google, Yahoo,...)'),'friend'=>__('Friend'),'magazine'=>__('Magazine'),'other'=>__('Other')))); 
						?>
					</div> 

					<!-- 
					<div class="form-group book-style">
						<label style="font-weight: lighter; "><?php // echo __('CODE'); ?></label>
						<div class="input-group search-property">
							<?php
								// echo $this->Form->input('code',array('type'=>'number', 'label'=>false, 'div'=>false,'class'=>'form-control search-style','autocomplete'=>'off','placeholder'=>'Code')) 
							?>
							<div class="input-group-addon">
								<i class="fa fa-barcode"></i>
							</div>
						</div>
					</div> 
					-->	
					
					<!-- Submit button -->
					<div class="form-group book-style">
						<div class="search-property col-md-4 col-sm-6 remove-padding">
							<?php echo $this->Form->submit(__('Send'), array('id'=>'book-now-btn','class'=>'btn btn-lg full-width','label'=>false,'div'=>false, 'style'=>'border-radius: 0;')); ?>
						</div>
					</div>

					<div class="form-group">
						<span class="help-block" style="display: block;"><?php echo __('<b>*</b> Required Fields');?></span>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>

			<div class="col-sm-6">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 contact_us_info">
						<h1 class="info_title">
							<?php echo __('Why book with us?'); ?>
						</h1>
						<hr />
						<ul class="info_list">
							<li><?php echo __('Get the <strong>lower rates</strong> than can be found anywhere else'); ?></li>
							<li><?php echo __('All properties come with <b>customized services</b> and can be tailor made to suit individual needs.'); ?></li>
							<li><?php echo __('Our collection includes <b>rare and unusual properties</b> otherwise not easily accessible.'); ?></li>
							<li><?php echo __('<b>Multilingual</b> team to answer pre-booking enquiries & manage the booking process.'); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- **************** -->
		<!-- page content END -->
		<!-- **************** -->
	</div>
</div>

<?php
echo $this->Html->script('datepicker/plugins', array('block'=>'scriptBottomMiddle'));
echo $this->Html->script('custom/wChar', array('block' => 'scriptBottomMiddle')); 
$this->Html->scriptBlock("
	(function($) {
		'use strict';
		setTimeout(function() {
			$('body').removeClass('notransition');
		}, 300);
	})(jQuery);

	function customRange(input) {
		var newMin = new Date();
		newMin = new Date(newMin.setDate(newMin.getDate() + 1));
		return {
			minDate: newMin 
		};
	}

	$(document).ready(function() {

		$('input.count-char, textarea.count-char').wChar({message: 'left'});

		// ALLOW ONLY NUMBERS TO BE TYPED
		$('.allow-only-numbers').off('change keyup keydown');
		$('.allow-only-numbers').on('change keyup keydown', function(e){
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && e.ctrlKey === true) || (e.keyCode >= 35 && e.keyCode <= 40)) {
				return;
			}

			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
			return;
		});



		// ALLOW ONLY POZITIVE NUMBERS > 1
		$('.pozitive_number').on('blur', function(event){
			if ($(this).val() < 1 ) {
				$(this).val('1');
			}
		});


		$('.check_out_trigger').off('click');
		$('.check_out_trigger').on('click', function(){
			$('#check_out').datepicker('show');
		});

		$('.check_in_trigger').off('click');
		$('.check_in_trigger').on('click', function(){
			$('#check_in').datepicker('show');
		});


		var date = new Date();
		$('#check_in').bind('change keyup input').datepicker({
			dateFormat: 'yy-mm-dd',
			minDate: date,
			maxDate: '+1Y', 
			nextText: '',
			prevText: '',           
			onSelect: function(dateText, inst) {
				if ($.trim($('#check_out').val()) == '') {
					setTimeout(function() {
						var nextDate = $('#check_in').datepicker('getDate');
						var newMin = new Date(nextDate.setDate(nextDate.getDate() + 1));
						$('#check_out').datepicker().datepicker('setDate', newMin);
						$('#check_out').datepicker('show');

					}, 0);
				} else {
					var cInDate  = $('#check_in').datepicker('getDate');
					var cOutDate = $('#check_out').datepicker('getDate');
					if (cInDate >= cOutDate) {
						setTimeout(function() {
							var nextDate = new Date(cInDate.setDate(cInDate.getDate() + 1));
							$('#check_out').datepicker().datepicker('setDate', nextDate);
							$('#check_out').datepicker('show');
						}, 0);
					};
				}
			},
		});

		$('#check_out').bind('change keyup input').datepicker({
			dateFormat: 'yy-mm-dd',
			minDate: '+1d',
			maxDate: '+1Y',
			nextText: '',
			prevText: '',
			beforeShow: customRange,
			onSelect: function(dateText, inst) {
				if ($.trim($('#check_in').val()) == '') {
					setTimeout(function() {
						var nextDate = $('#check_out').datepicker('getDate');
						var newMin = new Date(nextDate.setDate(nextDate.getDate() - 1));
						$('#check_in').datepicker().datepicker('setDate', newMin);
						$('#check_in').datepicker('show');

					}, 0);
				} else {
					var cInDate  = $('#check_in').datepicker('getDate');
					var cOutDate = $('#check_out').datepicker('getDate');
					// if (cInDate >= cOutDate) {
					if (cOutDate <= cInDate) {
						setTimeout(function() {
							var nextDate = new Date(cOutDate.setDate(cOutDate.getDate() - 1));
							$('#check_in').datepicker().datepicker('setDate', nextDate);
							$('#check_in').datepicker('show');
						}, 0);
					};
				}
			},                             
		});
	});
", array('block' => 'scriptBottom'));
?>

 
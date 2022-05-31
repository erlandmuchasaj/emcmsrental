<?php
	/*This css is applied only to this page*/
	echo $this->Html->css('common/wizard/smart_wizard', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('common/dropzone/dropzone', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('common/calendar/jquery.dop.BackendBookingCalendarPRO', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('jquery-ui/jquery-ui.min.css', null, array('block'=>'cssMiddle'));

	$currency_symbol = $this->Html->getDefaultCurrencyCode();
	if (isset($this->request->data['Currency']['symbol']) && !empty($this->request->data['Currency']['symbol'])) {
		$currency_symbol = trim($this->request->data['Currency']['symbol']);
	}

	$propertyID = null;
	if (isset($this->request->data['Property']['id'])) {
		$propertyID = (int) $this->request->data['Property']['id'];
	}

	$step_num = 0;
	if (isset($this->request->query['step_num'])) {
		$step_num = (int) $this->request->query['step_num'];
		if ($step_num > 2) {
			$step_num = 2;
		}
	}
	
	// debug($this->request->data);
?>
<div id="loader-wrapper" class="loader-dark">
	<div id="loader">&nbsp;</div>
</div>

<div class="em-container make-top-spacing">
	<div class="row">
		<!-- Start SmartWizard -->
		<div class="col-sm-12 clearfix">
			<?php echo $this->Form->create('Property', array('type'=>'file', 'id'=>'property_add_form', 'class'=>'form-horizontal'));
				echo $this->Form->input('Property.id', ['type'=> 'hidden', 'id' => 'property_id']);
				echo $this->Form->input('Property.id', ['type'=> 'hidden', 'id' => 'property_id']);
				$propertyID = (int)$this->Form->value('Property.id');
			?>
			<input type="hidden" value="<?php echo $step_num; ?>" id="step_num">
			<div id="wizard" class="swMain panel">
				<!-- panel-heading -->
				<ul class="panel-heading">
					<li>
						<a href="#step-1">
							<span class="stepNumber">1</span>
							<span class="stepDesc">
								<?php echo __('General'); ?><br />
								<small><?php echo __('General information'); ?></small>
							</span>
						</a>
					</li>
					<li>
						<a href="#step-2">
							<span class="stepNumber">2</span>
							<span class="stepDesc">
								<?php echo __('Details'); ?><br />
								<small><?php echo __('Property details'); ?></small>
							</span>
						</a>
					</li>
					<li>
						<a href="#step-3">
							<span class="stepNumber">3</span>
							<span class="stepDesc">
								<?php echo __('Photos &amp; Calendar'); ?><br />
								<small><?php echo __('&amp; More...'); ?></small>
							</span>
						</a>
					</li>
				</ul>
				<div class="panel-body">
					<div id="step-1" class="">
						<h2 class="StepTitle"><?php echo __('Step 1'); ?>:<span><?php echo __('General information about your listing'); ?></span></h2>
						<div class="form-group">
							<div class="col-md-12">
								<h4><?php echo __('Help Travelers Find the Right Fit');?></h4>
								<span class="help-block">
									<?php echo __('People searching on %s can filter by listing basics to find a space that matches their needs.', Configure::read('Website.name'));?>
								</span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Type of the Rooms'); ?>">
									<?php echo __('Room Type'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('room_type_id', array('class'=>'form-control emcms-required-el', 'div'=>false,'label'=>false,'empty'=>__('Select...'),'escape' => false)); ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Type of accomomdation'); ?>">
									<?php echo __('Accommodation Type'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('accommodation_type_id', array('class'=>'form-control emcms-required-el', 'div'=>false,'label'=>false,'empty'=>__('Select...'),'escape' => false)); ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Maximum number of guests'); ?>">
									<?php echo __('Capacity'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('capacity',array('label'=>false, 'div'=>false,'class'=>'form-control emcms-required-el','type'=>'select','options' => $this->Html->getData('capacity'), 'empty'=>__('Select...'),'escape' => false)); ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>
					</div>

					<div id="step-2" class="">
						<h2 class="StepTitle"><?php echo __('Step 2');?>:&nbsp;<span><?php echo __('Advance details of the property'); ?></span></h2>
						<!-- ******************************************************************************************* -->
						<!-- ******************                 PROPERTY TYPE                   ************************ -->
						<!-- ******************************************************************************************* -->
						<h2 class="text-center wizard-section-separator-text"> <?php echo __('Property Informations'); ?></h2>
						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label" data-toggle="tooltip" title="<?php echo __('Select the type of the property (Sale / Rent).'); ?>">
									<?php echo __('Property Type'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<?php
									echo $this->Form->input('contract_type',array('id'=>'contract_type','class'=>'form-control', 'options'=>$this->Html->getData('property_type'), 'div'=>false, 'label'=>false));
								?>
							</div>
							<div id="property_type_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Number of rooms.'); ?>">
									<?php echo __('Rooms'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('bedroom_number',array('id'=>'bedroom_number', 'label'=>false, 'div'=>false,'class'=>'form-control emcms-required-el','type'=>'select','options' =>$this->Html->getData('bedrooms'))); ?>
							</div>
							<div id="bedroom_number_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Total number of beds.'); ?>">
									<?php echo __('Beds'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('bed_number',array('id'=>'bed_number', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' =>$this->Html->getData('beds'))); ?>
							</div>
							<div id="bed_number_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Total number of bathrooms.'); ?>">
									<?php echo __('Bathrooms'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('bathroom_number',array('id'=>'bathroom_number', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('bathrooms'))); ?>
							</div>
							<div id="bathroom_number_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Number of garages that this property has'); ?>">
									<?php echo __('Garages'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('garages',array('id'=>'garages','label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('garages'), 'empty'=>__('Select...'), 'escape'=>false)); ?>
							</div>
							<div id="property_local_number_sale_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Select the type of the cancellation policy.'); ?>">
									<?php echo __('Cancellation Policy'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('cancellation_policy_id', array('id'=>'cancellation_policy_id','class'=>'form-control', 'div'=>false,'label'=>false, 'empty'=>__('Select...'),'escape' => false, 'type'=>'select','options' => $cancellationPolicies)); ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Property surface area'); ?>">
									<?php echo __('Surface Area'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="input-group">
									<?php
										echo $this->Form->input('surface_area', array('id'=>'property_surface_area_sale', 'class'=>'form-control allow-only-numbers pozitive_number', 'placeholder'=>__('Surface area'), 'div'=>false,'label'=>false, 'min'=>'0'));
									?>
									<div class="input-group-addon">m<sup>2</sup></div>
								</div>
							</div>
							<div id="property_surface_area_sale_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label">
									<?php echo __('Construction year'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="input-group">
									<?php
										echo $this->Form->input('construction_year', array('id'=>'construction_year','class'=>'form-control property-input', 'placeholder'=>__('Construction year'), 'div'=>false,'label'=>false,'readonly'=>'readonly'));
									?>
									<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								</div>
							</div>
							<div id="construction_year_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Select the time when user checkin'); ?>">
									<?php echo __('Checkin Time'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="input-group readonly">
									<?php
										echo $this->Form->input('checkin_time', array('id'=>'checkin_time', 'class'=>'form-control ', 'placeholder'=>__('Checkin Time'), 'div'=>false,'label'=>false, 'autocomplete'=>'off', 'readonly'=>'readonly'));
									?>
									<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
								</div>
							</div>
							<div id="checkin_time_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label" data-toggle="tooltip" title="<?php echo __('Select the time when user checkout'); ?>">
									<?php echo __('Checkout Time'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="input-group readonly">
									<?php
										echo $this->Form->input('checkout_time', array('id'=>'checkout_time', 'class'=>'form-control', 'placeholder'=>__('Checkout Time'), 'div'=>false,'label'=>false, 'autocomplete'=>'off', 'readonly'=>'readonly'));
									?>
									<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
								</div>
							</div>
							<div id="checkout_time_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Minimum days that a user is allowed to book.'); ?>">
									<?php echo __('Minimum stay (Optional)'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="input-group">
									<?php echo $this->Form->input('minimum_days', array('class'=>'form-control allow-only-numbers pozitive_number', 'div'=>false,'label'=>false, 'placeholder'=>__('Minimum number of days'), 'min'=>'1')); ?>
									<div class="input-group-addon"><i class="fa fa-calendar-o"></i></div>
								</div>
								<span class="help-block"><?php echo __('nights');?></span>
							</div>
							<div id="minimum_days_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label" data-toggle="tooltip" title="<?php echo __('Maximum days that a user is allowed to book.'); ?>">
									<?php echo __('Maximum stay (Optional)'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="input-group">
									<?php echo $this->Form->input('maximum_days', array('class'=>'form-control allow-only-numbers', 'div'=>false,'label'=>false, 'placeholder'=>__('maximum number of days'))); ?>
									<div class="input-group-addon"><i class="fa fa-calendar-o"></i></div>
								</div>
								<span class="help-block"><?php echo __('nights');?></span>
							</div>
							<div id="maximum_days_msg" class="col-lg-3 col-md-3 message"></div>
						</div>
						<!-- ******************************************************************************************* -->


						<!-- ******************************************************************************************* -->
						<!-- ******************                 OTHER DETAILS                   ************************ -->
						<!-- ******************************************************************************************* -->
						<hr />
						<h2 class="text-center wizard-section-separator-text"> <?php echo __('Pricing Details'); ?></h2>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Select the currency in wich type this property is gonna be valuated.'); ?>">
									<?php echo __('Currency'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('currency_id', array('id'=>'currency_id','class'=>'form-control', 'div'=>false,'label'=>false, 'empty'=> __('Select Currency'))); ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('You can also edit custom prices for individual days in the calendar'); ?>">
									<?php echo __('Base Price'); ?>
								</label>
								<span class="help-block"><?php echo __('The base nightly price and default currency for your listing.');?></span>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="input-group">
									<?php
										echo $this->Form->input('price', array('id'=>'rent_daily_price', 'class'=>'form-control allow-only-numbers', 'placeholder'=>__('Daily'), 'div'=>false,'label'=>false, 'min'=>'0'));
									?>
									<div class="input-group-addon"><i class="fa fa-money"></i></div>
								</div>
							</div>
							<div id="rent_daily_price_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<h3><?php echo __('Long-Term Prices.');?></h3>
								<span class="help-block"><?php echo __('Offer discounted prices for stays one week or longer.');?></span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('If set, this price applies to any reservation %d nights or longer. ', 7); ?>">
									<?php echo __('Per Week'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="input-group">
									<?php
										echo $this->Form->input('weekly_price', array('class'=>'form-control allow-only-numbers', 'placeholder'=>__('weekly'), 'div'=>false,'label'=>false, 'min'=>'0'));
									?>
									<div class="input-group-addon"><i class="fa fa-money"></i></div>
								</div>
								<span class="help-block"><?php echo __('If set, this price applies to any reservation 7 nights or longer.');?></span>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('If set, this price applies to any reservation %d nights or longer. ', 28); ?>">
									<?php echo __('Per Month'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="input-group">
									<?php
										echo $this->Form->input('monthly_price', array('id'=>'rent_monthly_price','class'=>'form-control allow-only-numbers', 'placeholder'=>__('Monthly'), 'div'=>false,'label'=>false, 'min'=>'0'));
									?>
									<div class="input-group-addon"><i class="fa fa-money"></i></div>
								</div>
								<span class="help-block"><?php echo __('If set, this price applies to any reservation 28 nights or longer.');?></span>
							</div>
							<div  id="rent_monthly_price_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<h3><?php echo __('Additional Charges.');?></h3>
								<span class="help-block"><?php echo __('These charges are added to the reservation total.');?></span>
							</div>
						</div>
						
						<?php 
							echo $this->Form->input('Price.id');
							echo $this->Form->input('Price.model', array('type'=>'hidden'));
							echo $this->Form->input('Price.model_id', array('type'=>'hidden'));
						?>
						<div class="form-group ">
						    <label class="col-sm-3 control-label"><?php echo __('Cleaning Fee');?></label>
						    <div class="col-sm-6">
						        <?php echo $this->Form->input('Price.cleaning',array('label'=>false, 'div'=>false,'class'=>'form-control allow-only-numbers','placeholder'=>__('Cleaning Fee'))); ?>
						    </div>
						</div>

						<div class="form-group ">
						    <label class="col-sm-3 control-label"><?php echo __('Additional Guests price');?></label>
						    <div class="col-sm-6">
						        <?php echo $this->Form->input('Price.addguests',array('label'=>false, 'div'=>false,'class'=>'form-control allow-only-numbers','placeholder'=>__('For each guest after'))); ?>
						        <span class="help-block"><?php echo __('For each guest after.');?></span>
						    </div>

						    <div class="col-sm-6 col-sm-offset-3">
						        <?php echo $this->Form->input('Price.guests',array('label'=>false, 'div'=>false,'class'=>'form-control', 'type' => 'select', 'options' => $this->Html->getData('capacity'), 'escape' => false)); ?>
						        <span class="help-block"><?php echo __('per person per night.');?></span>
						    </div>
						</div>

						<div class="form-group ">
						    <label class="col-sm-3 control-label"><?php echo __('Security Deposit ');?></label>
						    <div class="col-sm-6">
						        <?php echo $this->Form->input('Price.security_deposit',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Security deposit.'), 'data-maxlength'=>'512')); ?>
						    </div>
						</div>
						<!-- ******************************************************************************************* -->


						<!-- ******************************************************************************************* -->
						<!-- ******************                 AMENTIES                        ************************ -->
						<!-- ******************************************************************************************* -->
						<hr />
						<div class="form-group">
							<div class="col-md-12">
								<h3><?php echo __('Amenities');?></h3>
								<span class="help-block"><?php echo __('Every space on %s is unique. Highlight what makes your listing welcoming so that it stands out to guests who want to stay in your area.', Configure::read('Website.name'));?></span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-3 col-lg-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Check only available characteristics on your property.'); ?>">
									<?php echo __('Characteristics'); ?>
								</label>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="row">
									<?php if (!empty($AllCharacteristics)) {  ?>
										<?php foreach ($AllCharacteristics as $characteristic) { ?>
											<?php
												$retVal ='';
												if (is_array($this->Form->value('Characteristic.Characteristic'))) {
													$retVal = (in_array($characteristic['Characteristic']['id'], $this->Form->value('Characteristic.Characteristic'))) ? 'checked="checked"' : '';
												}
											?>
											<div class="col-lg-6 col-md-6 col-sm-6">
												<label>
													<input type="checkbox" value="<?php echo $characteristic['Characteristic']['id']; ?>" name="data[Characteristic][Characteristic][]" <?php echo "{$retVal}"; ?> />
													<!-- <i class="<?php // echo $characteristic['Characteristic']['icon_class']; ?> "></i> -->
													<span class="name"><?php echo $characteristic['CharacteristicTranslation']['characteristic_name']; ?></span>
												</label>
											</div>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
							<div id="characteristic_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<hr class="col-md-8 col-md-offset-2">
						</div>

						<div class="form-group">
							<div class="col-md-3 col-lg-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Check only available safeties on your property.'); ?>">
									<?php echo  __('Safety'); ?>
								</label>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="row">
									<?php if (!empty($AllSafeties)) {  ?>
										<?php foreach ($AllSafeties as $safety) { ?>
										<?php
											$retVal ='';
											if (is_array($this->Form->value('Safety.Safety'))) {
												$retVal = (in_array($safety['Safety']['id'], $this->Form->value('Safety.Safety'))) ? 'checked="checked"' : '' ;
											}
										?>
											<div class="col-lg-6 col-md-6 col-sm-6">
												<label>
													<input type="checkbox" value="<?php echo $safety['Safety']['id']; ?>" name="data[Safety][Safety][]" <?php echo "{$retVal}"; ?> />
													<!-- <i class="<?php // echo $safety['Safety']['icon_class']; ?>"></i> -->
													<span class="name"><?php echo $safety['SafetyTranslation']['safety_name']; ?></span>
												</label>
											</div>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
							<div id="safety_msg" class="col-lg-3 col-md-3 message"></div>
						</div>
						<!-- ******************************************************************************************* -->


						<!-- ******************************************************************************************* -->
						<!-- ******************                 PROPERTY DATA CONTENT             ********************** -->
						<!-- ******************************************************************************************* -->
						<hr />
						<!-- <h2 class="text-center wizard-section-separator-text"><?php echo __('Location and Description'); ?></h2> -->
						<div class="form-group">
							<div class="col-md-12">
								<h3><?php echo __('Tell Travelers About Your Space.');?></h3>
								<span class="help-block"><?php echo __('Every space on %s is unique. Highlight what makes your listing welcoming so that it stands out to guests who want to stay in your area.', Configure::read('Website.name'));?></span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label" data-toggle="tooltip" title="<?php echo __('Title of the property.'); ?>">
									<?php echo __('Listing Name '); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
							<?php if (count($languages) > 1): ?>
								<div class="form-group">
							<?php endif ?>

							<?php foreach ($this->request->data['PropertyTranslation'] as $index => $property): ?>
								<?php $id_lang = $property['Language']['id']; ?>

								<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($property['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
								<?php if (count($languages) > 1): ?>
									<div class="col-md-10">
								<?php endif ?>
								<?php 
									$options = [
										'class' => 'form-control count-char emcms-required-el', 
										'id' => 'title'.$id_lang,
										'label' => false,
										'div' => false,
										'required' => true,
										// 'value' => h($property['title']),
										'placeholder' => __('Be clear and descriptive.'), 
										'data-minlength' => '0', 
										'data-maxlength' => '75',
									];

									echo $this->Form->input('PropertyTranslation.' . $index . '.id', ['type' => 'hidden', /*'value' => $property['id']*/]); 
									echo $this->Form->input('PropertyTranslation.' . $index . '.language_id', ['type' => 'hidden',/* 'value' => $property['language_id']*/]); 
									echo $this->Form->input('PropertyTranslation.' . $index . '.property_id', ['type' => 'hidden',/* 'value' => $property['property_id']*/]); 

									echo $this->Form->input('PropertyTranslation.' . $index . '.title', $options); 
								?>
								<?php if (count($languages) > 1): ?>
									</div>
									<div class="col-md-2 dropdown">
										<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<?php echo h($property['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<?php foreach ($languages as $key => $language): ?>
											<li role="presentation">
												<a role="menuitem" href="javascript:hideOtherLanguage(<?php echo $language['Language']['id']; ?>);" tabindex="-1">
													<?php echo $language['Language']['name']; ?>
												</a>
											</li>
											<?php endforeach ?>
										</ul>
									</div>
								<?php endif ?>
								</div>
							<?php endforeach ?>

							<?php if (count($languages) > 1): ?>
								</div>
							<?php endif ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Property Description.'); ?>">
									<?php echo __('Summary');  ?>
								</label>
								<span class="help-block"><?php echo __('Tell travelers what you love about the space. You can include details about the decor, the amenities it includes, and the neighborhood.');?></span>
							</div>
							<div class="col-lg-6 col-md-6">
							<?php if (count($languages) > 1): ?>
								<div class="form-group">
							<?php endif ?>

							<?php foreach ($this->request->data['PropertyTranslation'] as $index => $property): ?>
								<?php $id_lang = $property['Language']['id']; ?>

								<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($property['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
								<?php if (count($languages) > 1): ?>
									<div class="col-md-10">
								<?php endif ?>
								<?php 
									$options = [
										'class' => 'form-control froala emcms-required-el', 
										'id' => 'description'.$id_lang,
										'label' => false,
										'div' => false,
										'required' => true,
										// 'value' => h($property['description']),
									];

									echo $this->Form->input('PropertyTranslation.' . $index . '.description', $options); 
								?>
								<?php if (count($languages) > 1): ?>
									</div>
									<div class="col-md-2 dropdown">
										<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<?php echo h($property['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<?php foreach ($languages as $key => $language): ?>
											<li role="presentation">
												<a role="menuitem" href="javascript:hideOtherLanguage(<?php echo $language['Language']['id']; ?>);" tabindex="-1">
													<?php echo $language['Language']['name']; ?>
												</a>
											</li>
											<?php endforeach ?>
										</ul>
									</div>
								<?php endif ?>
								</div>
							<?php endforeach ?>

							<?php if (count($languages) > 1): ?>
								</div>
							<?php endif ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label">
									<?php echo __('Location Description'); ?>
								</label>
								<span class="help-block"><?php echo __('Other information you wish to share on your public listing page.');?></span>
							</div>
							<div class="col-lg-6 col-md-6">
							<?php if (count($languages) > 1): ?>
								<div class="form-group">
							<?php endif ?>

							<?php foreach ($this->request->data['PropertyTranslation'] as $index => $property): ?>
								<?php $id_lang = $property['Language']['id']; ?>

								<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($property['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
								<?php if (count($languages) > 1): ?>
									<div class="col-md-10">
								<?php endif ?>
								<?php 
									$options = [
										'class' => 'form-control', 
										'id' => 'location_description'.$id_lang,
										'label' => false,
										'div' => false,
										// 'value' => h($property['location_description']),
										// 'placeholder' => __('Be clear and descriptive.'), 
									];

									echo $this->Form->input('PropertyTranslation.' . $index . '.location_description', $options); 
								?>
								<?php if (count($languages) > 1): ?>
									</div>
									<div class="col-md-2 dropdown">
										<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<?php echo h($property['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<?php foreach ($languages as $key => $language): ?>
											<li role="presentation">
												<a role="menuitem" href="javascript:hideOtherLanguage(<?php echo $language['Language']['id']; ?>);" tabindex="-1">
													<?php echo $language['Language']['name']; ?>
												</a>
											</li>
											<?php endforeach ?>
										</ul>
									</div>
								<?php endif ?>
								</div>
							<?php endforeach ?>

							<?php if (count($languages) > 1): ?>
								</div>
							<?php endif ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"   data-toggle="tooltip" title="<?php echo __('Public title for the product page and for search engines. Leave blank to use the product name. The number of remaining characters is displayed to the left of the field.'); ?>">
									<?php echo __('Meta Title'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
							<?php if (count($languages) > 1): ?>
								<div class="form-group">
							<?php endif ?>

							<?php foreach ($this->request->data['PropertyTranslation'] as $index => $property): ?>
								<?php $id_lang = $property['Language']['id']; ?>

								<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($property['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
								<?php if (count($languages) > 1): ?>
									<div class="col-md-10">
								<?php endif ?>
								<?php 
									$options = [
										'class' => 'form-control count-char', 
										'id' => 'seo_title'.$id_lang,
										'label' => false,
										'div' => false,
										'placeholder' => __('To have a different title from the product name, enter it here.'), 
										'data-minlength' => '0', 
										'data-maxlength' => '70',
									];

									echo $this->Form->input('PropertyTranslation.' . $index . '.seo_title', $options); 
								?>
								<?php if (count($languages) > 1): ?>
									</div>
									<div class="col-md-2 dropdown">
										<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<?php echo h($property['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<?php foreach ($languages as $key => $language): ?>
											<li role="presentation">
												<a role="menuitem" href="javascript:hideOtherLanguage(<?php echo $language['Language']['id']; ?>);" tabindex="-1">
													<?php echo $language['Language']['name']; ?>
												</a>
											</li>
											<?php endforeach ?>
										</ul>
									</div>
								<?php endif ?>
								</div>
							<?php endforeach ?>

							<?php if (count($languages) > 1): ?>
								</div>
							<?php endif ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="col-lg-3 col-md-3">
								<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('This description will appear in search engines. You need a single sentence, shorter than 160 characters (including spaces)'); ?>">
									<?php echo __('Meta description'); ?>
								</label>
							</div>
							<div class="col-lg-6 col-md-6">
							<?php if (count($languages) > 1): ?>
								<div class="form-group">
							<?php endif ?>

							<?php foreach ($this->request->data['PropertyTranslation'] as $index => $property): ?>
								<?php $id_lang = $property['Language']['id']; ?>

								<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($property['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
								<?php if (count($languages) > 1): ?>
									<div class="col-md-10">
								<?php endif ?>
								<?php 
									$options = [
										'class' => 'form-control count-char', 
										'id' => 'seo_description'.$id_lang,
										'label' => false,
										'div' => false,
										'placeholder' => __('To have a different description than your product summary in search results pages, write it here.'), 
										'data-minlength' => '0', 
										'data-maxlength' => '160',
									];

									echo $this->Form->input('PropertyTranslation.' . $index . '.seo_description', $options); 
								?>
								<?php if (count($languages) > 1): ?>
									</div>
									<div class="col-md-2 dropdown">
										<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<?php echo h($property['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<?php foreach ($languages as $key => $language): ?>
											<li role="presentation">
												<a role="menuitem" href="javascript:hideOtherLanguage(<?php echo $language['Language']['id']; ?>);" tabindex="-1">
													<?php echo $language['Language']['name']; ?>
												</a>
											</li>
											<?php endforeach ?>
										</ul>
									</div>
								<?php endif ?>
								</div>
							<?php endforeach ?>

							<?php if (count($languages) > 1): ?>
								</div>
							<?php endif ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>
						<!-- ******************************************************************************************* -->


						<!-- ******************************************************************************************* -->
						<!-- ******************                 LOCATION DETAILS                  ********************** -->
						<!-- ******************************************************************************************* -->
						<div class="form-group">
							<div class="col-md-6">
								<h3><?php echo __('Set Your Listing Location.');?></h3>
								<span class="help-block"><?php echo __("You’re not only sharing your space, you’re sharing your neighborhood. Travelers will use this information to find a place that’s in the right spot.\nWhile guests can see approximately where your listing is located in search results, your exact address is private and will only be shown to guests after they book your listing.");?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 col-md-3 control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Address of the property. You can also Drag &amp; Drop the marker on correct location'); ?>">
								<?php echo __('Address'); ?>
							</label>
							<div class="col-lg-6 col-md-6">
								<div class="input-group">
									<?php echo $this->Form->input('address', array('id'=>'addresspicker_map','class'=>'form-control emcms-required-el', 'div'=>false,'label'=>false, 'placeholder'=>__('Address'))); ?>
									<div class="input-group-addon"> <i class="fa fa-map-marker"></i></div>
								</div>
							</div>
							<div id="addresspicker_map_msg" class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3 col-md-3 wizard-label"><?php echo __('Country'); ?></label>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('country', array('id'=>'country', 'class'=>'form-control', 'placeholder'=>__('Country'), 'div'=>false, 'label'=>false)); ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3 col-md-3 wizard-label"><?php echo __('Locality'); ?></label>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('locality',array('class'=>'form-control','id'=>'locality','label'=>false,'div'=>false, 'placeholder'=>__('locality'))); ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3 col-md-3 wizard-label"><?php echo __('District'); ?></label>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('district',array('class'=>'form-control', 'id'=>'district', 'placeholder'=>__('District'), 'label'=>false, 'div'=>false)); ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3 col-md-3 wizard-label"><?php echo __('State/Province'); ?></label>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('state_province',array('class'=>'form-control', 'placeholder'=>__('state_province'), 'id'=>'state_province', 'label'=>false, 'div'=>false)); ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3 col-md-3 wizard-label"><?php echo __('Zip/Postal code'); ?></label>
							<div class="col-lg-6 col-md-6">
								<?php echo $this->Form->input('zip_code',array('class'=>'form-control', 'placeholder'=>__('ZIP code'), 'id'=>'postal_code', 'label'=>false, 'div'=>false)); ?>
							</div>
							<div class="col-lg-3 col-md-3 message"></div>
						</div>

						<div class="form-group">
							<div class="map-clearfix">
								<div class="map-wrapper">
									<div id="map"></div>
									<div id="legend"><?php echo __('You can drag and drop the marker to the correct location'); ?></div>
								</div>
							</div>
						</div>

						<?php echo $this->Form->input('latitude', array('type'=>'hidden','id'=>'latitude'));?>
						<?php echo $this->Form->input('longitude', array('type'=>'hidden','id'=>'longitude'));?>
						<!-- ******************************************************************************************* -->
					</div>

					<div id="step-3" class="">
						<h2 class="StepTitle"><?php echo __('Step 3');?>:&nbsp;<span><?php echo __('Here you can manage media Gallery, Calendar and much more.');?></span></h2>
						<!-- ******************************************************************************************* -->
						<!-- ******************                 GALLERY IMAGES                    ********************** -->
						<!-- ******************************************************************************************* -->
						<div class="form-group">
							<div class="col-md-12">
								<span class="help-block"><?php echo __('Here you can Drag&Drop images to sort them, you can write image caption, you can delete them. The first image is the default image');?></span>
							</div>
							<div class="col-md-12">
								<ul id="sortable_images" class="photo_img"></ul>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12 text-center">
								<?php echo $this->Html->image('general/inbox.png', array('alt' => 'add photo', 'class'=>'')); ?>
								<h3><?php echo __('Add a photo or two!');?></h3>
								<span class="help-block"><?php echo __('Or three, or more! Guests love photos that highlight the features of your space.');?></span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<div id="my-dropzone" class="dropzone clickable-dropzone">
									<div class="fallback">
										<?php echo __('Update your browser in order to support Drag&Drop features.'); ?>
									</div>
									<div class="dz-message">
										<?php echo __('Drop files here or, <span class="info-upload-txt"> click to upload images.</span>'); ?>
										<br />
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-2 pull-left">
								<button class="btn btn-info clickable-dropzone" type="button">
									<i class="fa fa-upload" aria-hidden="true"></i>&nbsp;<?php echo __('Upload Images'); ?>
								</button>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<div class="info-box">
									<span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
									<div class="info-box-content">
										<?php echo $this->Html->tag('span',__('For a better result for the photos suggest to follow these measures:'),array('class' => 'info-box-text')) ?>
										<span class="info-box-number"><?php echo __('at least %d X %d and max size of: %dMb', 1024, 768, 5);?></span>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<a href="javascript:void(0);" id="backend-refresh" class="btn btn-info">
									<i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;<?php echo addslashes(__('Refresh Calendar')); ?>
								</a>
							</div>
							<hr />
							<div class="col-md-12">
								<div id="backend"></div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-8 col-md-offset-2">
								<h3><?php echo __('Add a Video');?></h3>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-8 col-md-offset-2">
								<label class="control-label" for="video_url"><?php echo __('Property Video');?></label>
								<div class="input-group">
									<?php
										echo $this->Form->input('video_url', array('id'=>'video_url', 'class'=>'form-control', 'placeholder'=>__('Video url'), 'div'=>false,'label'=>false));
									?>
									<div class="input-group-addon"><i class="fa fa-files-o"></i></div>
								</div>
								<span class="help-block"><?php echo __('Upload your video to your youtube.com channel or Vimeo and then just insert the video URL in the field above.');?></span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-8 col-md-offset-2">
								<label class="control-label"><?php echo __('Publish Status');?></label>
								<br />
								<?php echo $this->Form->input('status', array('type'=>'checkbox','label'=>false, 'div'=>false, 'class'=>'bootstrap-switch')); ?>
								<span class="help-block"><?php echo __('Set to YES if you want your property to be published.');?></span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-8 col-md-offset-2">
								<label class="control-label"><?php echo __('Instant Booking?');?></label>
								<br />
								<?php echo $this->Form->input('allow_instant_booking', array('type'=>'checkbox','label'=>false, 'div'=>false, 'class'=>'bootstrap-switch')); ?>
								<span class="help-block"><?php echo __('Set to yes if you want to allow users to instantly book your space.');?></span>
							</div>
						</div>



						<!-- PACKING LIST -->
						<div class="form-group">
							<div class="col-md-8 col-sm-offset-2">
								<h3><?php echo __('Availability');?></h3>
								<p class="help-block"><?php echo __('If you host only for a period of time. Please select the dates.');?></p>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8 col-sm-offset-2">
								<?php echo $this->Form->input('availability_type',array('div'=>false, 'class'=>'form-control js-availability-type','type'=>'select', 'options' => ['always' => 'Always', 'one_time' => 'One time'], 'escape' => false)); ?>
							</div>
						</div>
						
						<div class="js-availability-container" <?php if ($this->request->data['Property']['availability_type'] !== 'one_time') { ?> style="display: none;" <?php } ?>>
							<div class="form-group js-wrapper">
							    <div class="col-md-4 col-sm-offset-2">
							        <?php echo $this->Form->input('available_from',array('id'=>'available_from','div'=>false,'class'=>'form-control js-date-picker','placeholder'=>__('From'), 'autocomplete'=>'off')); ?>
							    </div>
							    <div class="col-md-4">
							        <?php echo $this->Form->input('available_to',array('id'=>'available_to','div'=>false,'class'=>'form-control js-date-picker', 'placeholder'=>__('To'), 'autocomplete'=>'off')); ?>
							    </div>
							    <div class="col-md-2 message"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
		<!-- End SmartWizard -->
	</div>
</div>
<?php echo $this->element('Common/confirm_modal'); ?>
<script>
	function hideOtherLanguage(id)
	{
		$('.translatable-field').hide();
		$('.lang-' + id).show();
	}
</script>
<?php
echo $this->Html->script('//maps.googleapis.com/maps/api/js?key='.Configure::read('Google.key'), array('block'=>'scriptBottomMiddle'));
echo $this->Html->script('common/addresspicker/jquery.ui.addresspicker', array('block'=>'scriptBottomMiddle'));
echo $this->Html->script('common/wizard/jquery.smartWizard', array('block'=>'scriptBottomMiddle'));
echo $this->Html->script('common/dropzone/dropzone', array('block' => 'scriptBottomMiddle'));
echo $this->Html->script('common/calendar/backendBookingCalendar', array('block' => 'scriptBottomMiddle'));
echo $this->Html->script('common/typewatch/jquery.typewatch', array('block' => 'scriptBottomMiddle'));
echo $this->Html->script('common/jquery-ui-timepicker-addon', array('block' => 'scriptBottomMiddle'));
$this->Froala->editor('.froala', array('block'=>'scriptBottom'));
$this->Html->scriptBlock("
	var propertyID = '".$propertyID."',
		currency_symbol = '".$currency_symbol."',
		property_price = '".$this->request->data['Property']['price']."',
		myDropzone = null,
		calendar = null,
		map = null;
	(function($){
		$(document).ready(function() {
			'use strict';

			getPropertyImages(propertyID);

			// Inicialise Wizard
			$('#wizard').smartWizard({
				transitionEffect:'fade',        // Effect on navigation, none/fade/slide/slideleft
				enableFinishButton:false,       // make finish button enabled always
				keyNavigation: true,            // Enable/Disable key navigation(left and right keys are used if enabled)
				enableAllSteps: true,			// Enable All navigation
				cycleSteps: false,              // cycle step navigation
				hideButtonsOnDisabled: true,	// when the previous/next/finish buttons are disabled, hide them instead?
				labelNext:'Next',
				labelPrevious:'Previous',
				// selected: $('#step_num').val(),
				labelFinish:'Finish',
				noForwardJumping: false,
				onShowStep: onShowStepCallback, // triggers when showing a step
				onLeaveStep:leaveAStepCallback, // triggers when leaving a step
				onFinish:onFinishCallback,      // triggers when Finish button is clicked
			});
			
			// GOOGLE MAP INICIALISATION
			var addresspickerMap = $('#addresspicker_map').addresspicker({
				componentsFilter: '',
				key: google_map_key,
				mapOptions: {
					zoom: 4,
					center: new google.maps.LatLng(46, 2),
					scrollwheel: true,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				},
				elements: {
					map:      '#map',
					lat:      '#latitude',
					lng:      '#longitude',
					street_number: '#street_number',
					route: '#route',
					locality: '#locality',
					sublocality: '#sublocality',
					administrative_area_level_3: '#administrative_area_level_3',
					administrative_area_level_2: '#district',
					administrative_area_level_1: '#state_province',
					country:  '#country',
					postal_code: '#postal_code',
					type:    '#type'
				}
			});

			var gmarker = addresspickerMap.addresspicker('marker');
			gmarker.setVisible(true);
			addresspickerMap.addresspicker('updatePosition');

			var image = new google.maps.MarkerImage(fullBaseUrl+'/img/map/marker1.png');
			gmarker.setIcon(image);

			// Update zoom field
			map = $('#addresspicker_map').addresspicker('map');
			google.maps.event.addListener(map, 'idle', function(){
				$('#zoom').val(map.getZoom());
			});

			// Add Marker on click
			google.maps.event.addListener(map, 'click', function(position) {
				gmarker.setPosition(position.latLng);
				google.maps.event.trigger(gmarker, 'dragend');
			});

			// Open map on full container on triger zoom
			google.maps.event.addListener(map, 'zoom_changed', function() {
				var center = map.getCenter();
				google.maps.event.trigger(map, 'resize');
				map.setCenter(center);
			});

			// Property construction year
			var date = new Date();
			$('#construction_year').datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy-mm-dd',
				maxDate: date,
			});

			// CHECKIN TIME
			$('#checkin_time').timepicker({
				showButtonPanel: false,
				timeOnlyTitle: 'Checkin Time',
				timeOnly: true,
				hourMin: 8,
				hourMax: 20,
				timeFormat: 'HH:mm',
				// stepMinute: 5,
			});

			// CHECKOUT TIME
			$('#checkout_time').timepicker({
				showButtonPanel: false,
				timeOnlyTitle: 'Checkout Time',
				timeOnly: true,
				hourMin: 8,
				hourMax: 20,
				timeFormat: 'HH:mm',
				// stepMinute: 5,
			});

			$('.js-availability-type').on('change', function (event) {
				var val = $(this).val();
				var element = $('.js-availability-container');
				if (val === 'one_time') {
					element.fadeIn().find('.js-date-picker').prop('disabled', false).prop('required', true);
				} else if (val === 'always') {
					element.fadeOut().find('.js-date-picker').prop('disabled', true).prop('required', false);
				}
			}).trigger('change');

			$('#available_from').datepicker({
				minDate: 0,
				maxDate: '+1Y',
				dateFormat: 'yy-mm-dd',
				changeYear: true,
				changeMonth: true,
				onSelect: function(dateText, inst) {
					if ($.trim($('#available_to').val()) == '') {
						setTimeout(function() {
							var nextDate = $('#available_from').datepicker('getDate');
							var newMin = new Date(nextDate.setDate(nextDate.getDate() + 1));
							$('#available_to').datepicker('setDate', newMin).trigger('change').datepicker('show');
						}, 150);
					} else {
						var cInDate  = $('#available_from').datepicker('getDate');
						var cOutDate = $('#available_to').datepicker('getDate');
						if (cInDate >= cOutDate) {
							setTimeout(function() {
								var nextDate = new Date(cInDate.setDate(cInDate.getDate() + 1));
								$('#available_to').datepicker('setDate', nextDate).trigger('change').datepicker('show');
							}, 150);
						} else {
							$('#available_to').trigger('change');
						}
					}
				}
			});

			$('#available_to').datepicker({
				minDate: 1,
				maxDate: '+1Y',
				dateFormat: 'yy-mm-dd',
				changeYear: true,
				changeMonth: true,
				onSelect: function(dateText, inst) {
					if ($.trim($('#available_from').val()) == '') {
						setTimeout(function() {
							var nextDate = $('#available_to').datepicker('getDate');
							var newMin = new Date(nextDate.setDate(nextDate.getDate() - 1));
							$('#available_from').datepicker('setDate', newMin).trigger('change').datepicker('show');
						}, 150);
					} else {
						var cInDate  = $('#available_from').datepicker('getDate');
						var cOutDate = $('#available_to').datepicker('getDate');
						if (cOutDate <= cInDate) {
							setTimeout(function() {
								var nextDate = new Date(cOutDate.setDate(cOutDate.getDate() - 1));
								$('#available_from').datepicker('setDate', nextDate).trigger('change').datepicker('show');
							}, 150);
						} else {
							$('#available_from').trigger('change');
						}
					}
				}
			});

			// BACK END CALENDAR INICIALISATION
			$('#backend').DOPBackendBookingCalendarPRO({
				'DataURL': fullBaseUrl+'/properties/loadCalendar/'+propertyID,
				'SaveURL': fullBaseUrl+'/properties/saveCalendar/'+propertyID,
				'ID': propertyID,
				'PropertyID': propertyID,
				'PropertyPrice': property_price,
				'Currency': currency_symbol,
			});

			// REFRESHING BACKEND CALENDAR
			$('#backend-refresh').click(function(){
				$('#backend').DOPBackendBookingCalendarPRO({
					'Reinitialize': true,
					'DataURL': fullBaseUrl+'/properties/loadCalendar/'+propertyID,
					'ID': $('#property_id').val(),
					'PropertyID': $('#property_id').val(),
					'PropertyPrice': $('#rent_daily_price').val(),
					'Currency': currency_symbol,
					'SaveURL': fullBaseUrl+'/properties/saveCalendar/'+propertyID,
				});
			});

			// INICIALISE DROPZONE
			myDropzone = new Dropzone('#my-dropzone', {
				url: fullBaseUrl+'/property_pictures/processImage/'+propertyID,
				params: {
					property_id: propertyID
				},
				addRemoveLinks: false,
				autoProcessQueue: true,
				clickable: '.clickable-dropzone'
			});

			// Maximum file is => x <=
			myDropzone.on('maxfilesexceeded', function(file) {
				var _this = this;
				_this.removeFile(file);
			});

			// AUTOPROCESS QUEUE
			myDropzone.on('processing', function() {
				this.options.autoProcessQueue = true;
			});

			// SHOW NOTIFICATION IF MIXFILES EXEEDED
			myDropzone.on('success', function(file, response) {
				var data = $.parseJSON(JSON.stringify(response));
				if (data.error == 1) {
					toastr.warning(data.message, 'Warning');
					var _this = this;
					_this.removeFile(file);
				}
			});

			// SHOW NOTIFICATION IF ANYTHING GOES WRONG
			myDropzone.on('error', function(file, response) {
				toastr.error(response, 'Error!');
				var _this = this;
				_this.removeFile(file);
			});

			myDropzone.on('addedfile', function() {
				// console.log(this.getQueuedFiles().length);
				// console.log(this.getUploadingFiles().length);
				// console.log(this.getAcceptedFiles());
			});

			// LOAD ALL IMAGES AFTER UPLOAD HAS FINISHED
			myDropzone.on('queuecomplete', function() {
				getPropertyImages(propertyID);
			});

			// SORT IMAGES
			$('#sortable_images').sortable({
				opacity: 0.8,
				cursor: 'move',
				revert: true,
				handle : '.sort-handle',
				zIndex: 999,
				distance: 10,
				items: '.OrderingField',
				start: function(e,ui){
					ui.placeholder.height(ui.item.height());
				},
				helper: function(e, tr){
					var \$originals = tr.children();
					var \$helper = tr.clone();
					\$helper.children().each(function(index)	{
						$(this).width(\$originals.eq(index).width());
					});
					\$helper.css('background-color', 'rgba(223, 240, 249,0.6)');
					return \$helper;
				},
				update: function() {
					var order = $(this).sortable('serialize')+'&action=sort';
					$.post(fullBaseUrl+'/property_pictures/sortImages/'+propertyID, order, function(data, textStatus, xhr) {
						if (textStatus =='success') {
							/*
							* // this verison is used when we specify the returned data type
							* var response = $.parseJSON(JSON.stringify(data));
							*/
							var response = $.parseJSON(data);
							if (!response.error) {
								toastr.success(response.message, 'Success');
							}
						} else {
							toastr.info(textStatus, 'Info');
						}
					});
				}
			});
		});
		$(window).on('load', function() { // makes sure the whole site is loaded 
		    $('#loader').fadeOut(function() { this.remove(); }); // will first fade out the loading animation 
		    $('#loader-wrapper').delay(350).fadeOut('slow', function() { this.remove(); }); // will fade out the white DIV that covers the website. 
		    $('body').delay(350).css({'overflow': 'visible'});
		});
	})(jQuery);


	// GET ALL IMAGES OF A SPECIFIC PROPERTY
	function getPropertyImages(property_id) {
		$.ajax({
			url: fullBaseUrl+'/property_pictures/loadImages/'+property_id,
			type: 'POST',
			dataType: 'html',
			data:'action=get_images',
			beforeSend: function() {
				// called before response
				$('#sortable_images').html('<div class=\'col-md-12 text-center\'><img src=\'".Router::url('/img/spinner.gif', true)."\' /></div>');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='success') {
					$('#sortable_images').html(data);
				} else {
					toastr.warning(textStatus, 'Warning!');
				}
			},
			complete: function(xhr, textStatus) {
				//called when complete
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				$('#sortable_images').html('We couldnt fetch the data please try again!');
				toastr.error(errorThrown, textStatus);
			}
		});
		return false;
	}

	function leaveAStepCallback(obj, context){
		// remove error messages
		$('[data-type=\"emcms-error\"]').remove();
		var step_num = obj.attr('rel');
		return validateSteps(step_num);
		// console.log(validateSteps(step_num));
	}

	function onShowStepCallback(obj, context) {
		console.log(obj);
		console.log(context);

		var step_num = obj.attr('rel'),
		    step_href = obj.attr('href');

		if (step_num==1) {
			$('#wizard_content').html('".addslashes(__('Hello %s, welcome in the property creation area. <br />We have simplified the process of inserting a property only in 3 steps. The first two are used to create the property, the third is used to upload images of the property. <br />Remember to enter as many beautifull Photos as you like! Good work by our team ',(AuthComponent::user()) ? h(AuthComponent::user('name')) : 'User'))."');
		}

		if (step_num==2) {
			if (typeof(map) !== 'undefined') {
				var center = map.getCenter();
				google.maps.event.trigger(map, 'resize');
				map.setCenter(center);
			}
			$('#wizard_content').html('At this stage you can define all the characteristics of your property on our portal <br /> Remember to enable the property on the portal.');
		}

		if (step_num==3) {
			$('#wizard_content').html('Finally now you can upload photos, which will represent your property in portal. Use the most evocative pictures. You can just drag and drop images in the dashed area. Remember, pictures can be up to 3 MB each! If you do not know how to reduce the photos, try picasa.com, it is free.');
		}
	}

	// Call on wizard complete
	function onFinishCallback(obj, context){
		if(validateAllSteps()){
			$('#wizard').smartWizard('showMessage','Finish Clicked, Do Not Refresh the page untill all the data is processed.');
			showPreloader();
			$('#property_add_form').submit();
		}
	}

	// Validate all steps before submit the form
	function validateAllSteps(){
		var isStepValid = true;

		if(validateStep1() == false){
			isStepValid = false;
			$('#wizard').smartWizard('setError',{stepnum:1,iserror:true});
		}else{
			$('#wizard').smartWizard('setError',{stepnum:1,iserror:false});
		}

		if(validateStep2() == false){
			isStepValid = false;
			$('#wizard').smartWizard('setError',{stepnum:2,iserror:true});
		}else{
			$('#wizard').smartWizard('setError',{stepnum:2,iserror:false});
		}

		if(validateStep3() == false){
			isStepValid = false;
			$('#wizard').smartWizard('setError',{stepnum:3,iserror:true});
		}else{
			$('#wizard').smartWizard('setError',{stepnum:3,iserror:false});
		}

		if(!isStepValid){
			$('#wizard').smartWizard('showMessage','Please correct the errors in the steps and continue');
		}
		return isStepValid;
	}

	// Step validator
	function validateSteps(step){
		var isStepValid = true;

		// validate step 1
		if(step == 1){
			if(validateStep1() == false ){
				isStepValid = false;
				$('#wizard').smartWizard('showMessage','Please correct the errors in step ' + step + ' and click next.');
				$('#wizard').smartWizard('setError',{stepnum:step,iserror:true});
			}else{
				$('#wizard').smartWizard('hideMessage');
				$('#wizard').smartWizard('setError',{stepnum:step,iserror:false});
			}
		}

		// validate step2
		if(step == 2){
			if(validateStep2() == false ){
				isStepValid = false;
				$('#wizard').smartWizard('showMessage','Please correct the errors in step ' + step + ' and click next.');
				$('#wizard').smartWizard('setError',{stepnum:step,iserror:true});
			}else{
				$('#wizard').smartWizard('hideMessage');
				$('#wizard').smartWizard('setError',{stepnum:step,iserror:false});
			}
		}

		// validate step3
		if(step == 3){
			if(validateStep3() == false ){
				isStepValid = false;
				$('#wizard').smartWizard('showMessage','Please correct the errors in step ' + step + ' and click next.');
				$('#wizard').smartWizard('setError',{stepnum:step,iserror:true});
			}else{
				$('#wizard').smartWizard('hideMessage');
				$('#wizard').smartWizard('setError',{stepnum:step,iserror:false});
			}
		}

		return isStepValid;
	}

	// Validate wizard steps
	function validateStep1(){
		var isValid = true;
		$('.emcms-required-el', '#step-1').each(function (index, element) {
		    if ($.trim(element.value) == '') {
		    	$(element).closest('.form-group').find('.message').html('<span data-type=\"emcms-error\">Required</span>');
		        isValid = false;
		    }
		});
		return isValid;
	}

	function validateStep2(){
		var isValid = true;
		$('.emcms-required-el', '#step-2').each(function (index, element) {
			if ($.trim(element.value) == '') {
				$(element).closest('.form-group').find('.message').html('<span data-type=\"emcms-error\">Required</span>');
				isValid = false;
			}
		});

		$(':input[required]', '#step-2').each(function (index, element) {
			if ($.trim(element.value) == '') {
				$(element).closest('.js-wrapper').find('.message').html('<span data-type=\"emcms-error\">Required</span>');
				isValid = false;
			}
		});
		return isValid;
	}

	function validateStep3() {
		var isValid = true;

		$(':input[required]', '#step-3').each(function (index, element) {
			if ($.trim(element.value) == '') {
				$(element).closest('.js-wrapper').find('.message').html('<span data-type=\"emcms-error\">Required</span>');
				isValid = false;
			}
		});
		return isValid;
	}
", array('block' => 'scriptBottom'));
?>

<!-- Modal Confirm Box -->
<div id="dialog-confirm" title="<?php echo __('Save Changes'); ?>" style="display:none;">
	<?php echo addslashes(__('Do you want to save all the changes made to This Property?')); ?>
</div>

<!-- Modal Confirm Box -->
<div id="dialog-confirm-delete" title="<?php echo addslashes(__('Confirm Delete Property')); ?>" style="display:none;">
	<?php echo $this->Form->create('Property',array('class'=>'form-horizontal'));  ?>
	<div class="row">
		<div class="col-md-12 text-left">
			<label class="control-label" >
				<?php echo __('Delete Reason'); ?>
			</label>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Form->input('Property.delete_reason',array('id'=>'property_delete_reason', 'label'=>false, 'div'=>false,'class'=>'form-control', 'type'=>'textarea', 'placeholder'=>__('Reason that you are deleting your property?'))); ?>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12 message" id="property_delete_message"></div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>

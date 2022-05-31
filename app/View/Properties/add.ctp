<?php
	/*This css is applied only to this page*/
	echo $this->Html->css('common/wizard/smart_wizard', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('jquery-ui/jquery-ui.min.css', null, array('block'=>'cssMiddle'));
	// echo $this->Html->css('froala_editor.min', null, array('block'=>'cssMiddle'));
?>
<div id="loader-wrapper" class="loader-dark">
	<div id="loader">&nbsp;</div>
</div>

<div  class="em-container make-top-spacing">
	<div class="row wizard-heading-info ">
		<div class="col-md-10 col-md-offset-1">
			<?php
				echo $this->Html->link($this->Html->displayUserAvatar(),array('controller' => 'users', 'action' => 'dashboard'),array('escape' => false));
			?>
			<p id="wizard_content" class="wizard-description"></p>
		</div>
	</div>

	<?php // debug($this->Html->getData('capacity')); ?>

	<div class="row">
		<!-- Start SmartWizard -->
		<div class="col-sm-12 clearfix">
			<?php echo $this->Form->create('Property', array('type'=>'file', 'id'=>'property_add_form' ,'class'=>'form-horizontal')); ?>
			<?php echo $this->Form->input('user_id', array('value'=>AuthComponent::user('id'), 'type'=>'hidden')); ?>
				<div id="wizard" class="swMain panel">
					<!-- panel-heading -->
					<ul class="panel-heading">
						<li>
							<a href="#step-1">
								<span class="stepNumber">1</span>
								<span class="stepDesc">
									<?php echo __('Basic'); ?><br />
									<small><?php echo __('General information'); ?></small>
								</span>
							</a>
						</li>
						<!-- 						
						<li>
							<a href="#step-4">
								<span class="stepNumber">4</span>
								<span class="stepDesc">
									<?php echo __('General'); ?><br />
									<small><?php echo __('General information'); ?></small>
								</span>
							</a>
						</li> -->
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
									<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Type of accommodation'); ?>">
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
									<?php echo $this->Form->input('capacity',array('label'=>false, 'div'=>false,'class'=>'form-control emcms-required-el','type'=>'select','options' =>$this->Html->getData('capacity'), 'empty'=>__('Select...'),'escape' => false)); ?>
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
										echo $this->Form->input('contract_type',array('class'=>'form-control emcms-required-el', 'options'=>$this->Html->getData('property_type'), 'div'=>false, 'label'=>false));
									?>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
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
									<?php echo $this->Form->input('bed_number',array('label'=>false, 'div'=>false,'class'=>'form-control emcms-required-el','type'=>'select','options' =>$this->Html->getData('beds'))); ?>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
							</div>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Total number of bathrooms.'); ?>">
										<?php echo __('Bathrooms'); ?>
									</label>
								</div>
								<div class="col-lg-6 col-md-6">
									<?php echo $this->Form->input('bathroom_number',array('label'=>false, 'div'=>false,'class'=>'form-control emcms-required-el','type'=>'select','options' =>$this->Html->getData('bathrooms'))); ?>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
							</div>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Number of garages that this property has'); ?>">
										<?php echo __('Garages'); ?>
									</label>
								</div>
								<div class="col-lg-6 col-md-6">
									<?php echo $this->Form->input('garages',array('label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('garages'), 'empty'=>__('No Garages.'), 'escape'=>false)); ?>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
							</div>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Select the type of the cancellation policy.'); ?>">
										<?php echo __('Cancellation Policy'); ?>
									</label>
								</div>
								<div class="col-lg-6 col-md-6">
									<?php echo $this->Form->input('cancellation_policy_id', array('class'=>'form-control emcms-required-el', 'div'=>false,'label'=>false, 'empty'=>__('Select...'),'escape' => false, 'type'=>'select','options' =>$cancellationPolicies)); ?>
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
											echo $this->Form->input('surface_area', array('class'=>'form-control allow-only-numbers pozitive_number', 'placeholder'=>__('Surface area'), 'div'=>false,'label'=>false, 'min'=>'0', 'type'=>'number'));
										?>
										<div class="input-group-addon">m<sup>2</sup></div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
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
											echo $this->Form->input('construction_year', array('id'=>'construction_year','class'=>'form-control', 'placeholder'=>__('Construction year'), 'div'=>false,'label'=>false,'readonly'=>'readonly'));
										?>
										<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
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
											echo $this->Form->input('checkin_time', array('id'=>'checkin_time', 'class'=>'form-control ', 'placeholder'=>__('Checkin Time'), 'div'=>false,'label'=>false, 'autocomplete'=>'off', 'readonly'=>'readonly','value'=>'17:00'));
										?>
										<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
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
											echo $this->Form->input('checkout_time', array('id'=>'checkout_time', 'class'=>'form-control', 'placeholder'=>__('Checkout Time'), 'div'=>false,'label'=>false, 'autocomplete'=>'off', 'readonly'=>'readonly','value'=>'10:00'));
										?>
										<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
							</div>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Minimum days that a user is allowed to book.'); ?>">
										<?php echo __('Minimum stay (Optional)'); ?>
									</label>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="input-group">
										<?php echo $this->Form->input('minimum_days', array('type'=>'number', 'class'=>'form-control allow-only-numbers pozitive_number', 'div'=>false,'label'=>false, 'placeholder'=>__('Minimum number of days'), 'min'=>'1')); ?>
										<div class="input-group-addon"><i class="fa fa-calendar-o"></i></div>
									</div>
									<span class="help-block"><?php echo __('nights');?></span>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
							</div>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label wizard-label" data-toggle="tooltip" title="<?php echo __('Maximum days that a user is allowed to book.'); ?>">
										<?php echo __('Maximum stay (Optional)'); ?>
									</label>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="input-group">
										<?php echo $this->Form->input('maximum_days', array('type'=>'number', 'class'=>'form-control allow-only-numbers', 'div'=>false,'label'=>false, 'placeholder'=>__('maximum number of days'))); ?>
										<div class="input-group-addon"><i class="fa fa-calendar-o"></i></div>
									</div>
									<span class="help-block"><?php echo __('nights');?></span>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
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
									<?php echo $this->Form->input('currency_id', array('id'=>'currency_id','class'=>'form-control  emcms-required-el', 'div'=>false,'label'=>false)); ?>
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
											echo $this->Form->input('price', array('class'=>'form-control allow-only-numbers emcms-required-el', 'placeholder'=>__('Daily'), 'div'=>false,'label'=>false, 'min'=>'0'));
										?>
										<div class="input-group-addon"><i class="fa fa-money"></i></div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
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

							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Cleaning Fee');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Price.cleaning',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Cleaning Fee'))); ?>
							    </div>
							</div>

							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Additional Guests price');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Price.addguests',array('label'=>false, 'div'=>false,'class'=>'form-control allow-only-numbers','placeholder'=>__('For each guest after'))); ?>
							        <span class="help-block"><?php echo __('For each guest after.');?></span>
							    </div>

							    <div class="col-sm-6 col-sm-offset-3">
							        <?php echo $this->Form->input('Price.guests',array('label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('capacity'), 'escape' => false)); ?>
							        <span class="help-block"><?php echo __('per person per night.');?></span>
							    </div>
							</div>

							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Security Deposit ');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Price.security_deposit',array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
							        <span class="help-block"><?php echo __('Any guest who confirms a reservation at your listing will be responsible for damages up to this amount. No charges or authorizations will be made unless you make a claim within 14 days after check out.');?></span>
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
												<div class="col-lg-6 col-md-6 col-sm-6">
													<label>
														<input type="checkbox" value="<?php echo $characteristic['Characteristic']['id']; ?>" name="data[Characteristic][Characteristic][]" />
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
												<div class="col-lg-6 col-md-6 col-sm-6">
													<label>
														<input type="checkbox" value="<?php echo $safety['Safety']['id']; ?>" name="data[Safety][Safety][]" />
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

							<div class="form-group js-wrapper">
								<div class="col-lg-3 col-md-3">
									<label class="control-label  wizard-label" data-toggle="tooltip" title="<?php echo __('Title of the property.'); ?>">
										<?php echo __('Listing Name '); ?>
									</label>
								</div>
								<div class="col-lg-6 col-md-6">
								<?php if (count($languages) > 1): ?>
									<div class="form-group">
								<?php endif ?>

								<?php foreach ($languages as $index => $language): ?>
									<?php $id_lang = $language['Language']['id']; ?>

									<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($language['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
									<?php if (count($languages) > 1): ?>
										<div class="col-lg-10">
									<?php endif ?>
									<?php 
										$options = [
											'class' => 'form-control count-char emcms-required-el', 
											'id' => 'title'.$id_lang,
											'label' => false,
											'div' => false,
											'value' => '',
											'placeholder' => __('Be clear and descriptive.'), 
											'data-minlength' => '0', 
											'data-maxlength' => '75',
										];

										if ($language['Language']['is_default'] == 1) {
											$options['required'] = 'required';
										}

										echo $this->Form->input('PropertyTranslation.' . $id_lang . '.language_id', ['type' => 'hidden', 'value' => $id_lang]); 

										echo $this->Form->input('PropertyTranslation.' . $id_lang . '.title', $options); 
									?>
									<?php if (count($languages) > 1): ?>
										</div>
										<div class="col-lg-2 dropdown">
											<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<?php echo h($language['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
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

							<div class="form-group js-wrapper">
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

								<?php foreach ($languages as $index => $language): ?>
									<?php $id_lang = $language['Language']['id']; ?>

									<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($language['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
									<?php if (count($languages) > 1): ?>
										<div class="col-lg-10">
									<?php endif ?>
										<?php 
											$options = [
												'class' => 'form-control froala emcms-required-el', 
												'id' => 'description'.$id_lang,
												'label' => false,
												'div' => false,
												'value' => '',
												'placeholder' => __('Property description'), 
											];

											if ($language['Language']['is_default'] == 1) {
												$options['required'] = 'required';
											}

											echo $this->Form->input('PropertyTranslation.' . $id_lang . '.description', $options); 
										?>
									<?php if (count($languages) > 1): ?>
										</div>
										<div class="col-lg-2 dropdown">
											<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<?php echo h($language['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
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

								<?php foreach ($languages as $index => $language): ?>
									<?php $id_lang = $language['Language']['id']; ?>

									<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($language['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
									<?php if (count($languages) > 1): ?>
										<div class="col-lg-10">
									<?php endif ?>
									<?php 
										$options = [
											'class' => 'form-control', 
											'id' => 'location_description'.$id_lang,
											'label' => false,
											'div' => false,
											'value' => '',
											'placeholder' => __('Location description')
										];

										echo $this->Form->input('PropertyTranslation.' . $id_lang . '.location_description', $options); 
									?>
									<?php if (count($languages) > 1): ?>
										</div>
										<div class="col-lg-2 dropdown">
											<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<?php echo h($language['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
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
								<div id="location_description_msg" class="col-lg-3 col-md-3 message"></div>
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

								<?php foreach ($languages as $index => $language): ?>
									<?php $id_lang = $language['Language']['id']; ?>

									<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($language['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
									<?php if (count($languages) > 1): ?>
										<div class="col-lg-10">
									<?php endif ?>
									<?php 
										$options = [
											'class' => 'form-control count-char', 
											'id' => 'seo_title'.$id_lang,
											'label' => false,
											'div' => false,
											'value' => '',
											'placeholder' => __('To have a different title from the product name, enter it here.'), 
											'data-minlength' => '0', 
											'data-maxlength' => '70',
										];

										echo $this->Form->input('PropertyTranslation.' . $id_lang . '.seo_title', $options); 
									?>
									<?php if (count($languages) > 1): ?>
										</div>
										<div class="col-lg-2 dropdown">
											<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<?php echo h($language['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
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

								<?php foreach ($languages as $index => $language): ?>
									<?php $id_lang = $language['Language']['id']; ?>

									<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($language['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
									<?php if (count($languages) > 1): ?>
										<div class="col-lg-10">
									<?php endif ?>
									<?php 
										$options = [
											'class' => 'form-control count-char', 
											'id' => 'seo_description'.$id_lang,
											'label' => false,
											'div' => false,
											'value' => '',
											'placeholder' => __('To have a different description than your product summary in search results pages, write it here.'), 
											'data-minlength' => '0', 
											'data-maxlength' => '160',
										];

										echo $this->Form->input('PropertyTranslation.' . $id_lang . '.seo_description', $options); 
									?>
									<?php if (count($languages) > 1): ?>
										</div>
										<div class="col-lg-2 dropdown">
											<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<?php echo h($language['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
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
								<div id="seo_description_msg" class="col-lg-3 col-md-3 message"></div>
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
								<label class="control-label control-label col-lg-3 col-md-3 wizard-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Address of the property. You can also Drag &amp; Drop the marker on correct location'); ?>">
									<?php echo __('Address'); ?>
								</label>
								<div class="col-lg-6 col-md-6">
									<div class="input-group">
										<?php echo $this->Form->input('address', array('id'=>'addresspicker_map','class'=>'form-control  emcms-required-el', 'div'=>false,'label'=>false, 'placeholder'=>__('Address'))); ?>
										<div class="input-group-addon"> <i class="fa fa-map-marker"></i></div>
									</div>

								</div>
								<div class="col-lg-3 col-md-3 message"></div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3 col-md-3 wizard-label"><?php echo __('Country'); ?></label>
								<div class="col-lg-6 col-md-6">
									<?php echo $this->Form->input('country', array('id'=>'country', 'class'=>'form-control', 'placeholder'=>__('Country'),'div'=>false,'label'=>false)); ?>
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
									<?php echo $this->Form->input('district',array('class'=>'form-control','id'=>'district', 'placeholder'=>__('District'),'label'=>false,'div'=>false)); ?>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3 col-md-3 wizard-label"><?php echo __('State/Province'); ?></label>
								<div class="col-lg-6 col-md-6">
									<?php echo $this->Form->input('state_province',array('class'=>'form-control', 'placeholder'=>__('state_province'),'id'=>'state_province','label'=>false,'div'=>false)); ?>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3 col-md-3 wizard-label"><?php echo __('Zip/Postal code'); ?></label>
								<div class="col-lg-6 col-md-6">
									<?php echo $this->Form->input('zip_code',array('class'=>'form-control', 'placeholder'=>__('ZIP code'),'id'=>'postal_code','label'=>false,'div'=>false)); ?>
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
							<h2 class="StepTitle"><?php echo __('Step 3'); ?>: <span><?php echo __('Here you can manage media Gallery and Calendar.');?></span></h2>
							<!-- ******************************************************************************************* -->
							<!-- ******************                 GALLERY IMAGES                    ********************** -->
							<!-- ******************************************************************************************* -->
							<div class="form-group">
								<div class="col-lg-6 col-md-6 col-md-offset-3 text-center">
									<?php  echo '<img src="'.Router::url('/img/spinner.gif', true).'" alt="loading images" />'; ?>
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
echo $this->Html->script('common/jquery-ui-timepicker-addon', array('block' => 'scriptBottomMiddle'));
echo $this->Html->script('common/wizard/jquery.smartWizard', array('block'=>'scriptBottomMiddle'));
$this->Froala->editor('.froala', array('block'=>'scriptBottom'));
$this->Html->scriptBlock("
	var myDropzone = null;
	var calendar = null;
	var map = null;
	(function($){
		$(document).ready(function() {
			'use strict';
			// Use this if you dont use helper
			// $('.froala').froalaEditor();

			// Inicialise Wizard
			$('#wizard').smartWizard({
				transitionEffect:'fade',        // Effect on navigation, none/fade/slide/slideleft
				onLeaveStep:leaveAStepCallback, // triggers when leaving a step
				onFinish:onFinishCallback,      // triggers when Finish button is clicked
				onShowStep: onShowStepCallback, // triggers when showing a step
				enableFinishButton:false,       // make finish button enabled always
				/************************/
				keyNavigation: true,            // Enable/Disable key navigation(left and right keys are used if enabled)
				enableAllSteps: false,
				cycleSteps: false,              // cycle step navigation
				hideButtonsOnDisabled: false,   // when the previous/next/finish buttons are disabled, hide them instead?
				labelNext:'Next',
				labelPrevious:'Previous',
				labelFinish:'Finish',
				noForwardJumping: false,
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
				hourMin: 8,
				hourMax: 20,
				timeFormat: 'HH:mm',
				// stepMinute: 5,
			});

			// CHECKOUT TIME
			$('#checkout_time').timepicker({
				showButtonPanel: false,
				timeOnlyTitle: 'Checkout Time',
				hourMin: 8,
				hourMax: 20,
				timeFormat: 'HH:mm',
				// stepMinute: 5,
			});
		});

		$(window).on('load', function() { // makes sure the whole site is loaded 
		    $('#loader').fadeOut(function() { this.remove(); }); // will first fade out the loading animation 
		    $('#loader-wrapper').delay(350).fadeOut('slow', function() { this.remove(); }); // will fade out the white DIV that covers the website. 
		    $('body').delay(350).css({'overflow': 'visible'});
		});
	})(jQuery);

	function leaveAStepCallback(obj, context) {
		// remove error messages
		$('[data-type=\"emcms-error\"]').remove();
		var step_num = obj.attr('rel');
		var step_num = obj.attr('rel'),
		    step_href = obj.attr('href'),
		    fromStep = context.fromStep,
		    toStep = context.toStep;

		// this means user is turning back so do not validate
		if (fromStep > toStep) {
		    return true;
		} else {
		    return validateSteps(step_num);
		}
		// console.log(validateSteps(step_num));
	}

	function onShowStepCallback(obj, context){
		var step_num = obj.attr('rel'),
		    step_href = obj.attr('href');

		if (step_num==1) {
			$('#wizard_content').html('".__('Hello %s, welcome in the property creation area. <br />We have simplified the process of inserting a property only in 3 steps. The first two are used to create the property, the third is used to upload images of the property. <br />Remember to enter as many beautifull photos as you like! Good work by our team ',(AuthComponent::user()) ? h(AuthComponent::user('name')) : 'User')."');
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
			$('#wizard').smartWizard('showMessage','Do Not Refresh the page untill all the data is processed...');
			showPreloader();
			$('#property_add_form').submit();
		}
	}

	// Call on wizard complete
	function onFinishCallback(obj, context){
		if (validateAllSteps()) {
			$('#wizard').smartWizard('showMessage', 'Finish Clicked, Do Not Refresh the page untill all the data is processed.');
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
			$('#wizard').smartWizard('showMessage','Please correct the errors in all the steps and continue');
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
		$('.emcms-required-el[required]', '#step-1').each(function (index, element) {
		    if ($.trim(element.value) == '') {
		    	$(element).closest('.form-group').find('.message').html('<span data-type=\"emcms-error\">Required</span>');
		        isValid = false;
		    }
		});
		return isValid;
	}

	function validateStep2(){
		var isValid = true;
		$('.emcms-required-el[required]', '#step-2').each(function (index, element) {
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

	function validateStep3(){
		var isValid = true;
		return isValid;
	}
", array('block' => 'scriptBottom'));
?>

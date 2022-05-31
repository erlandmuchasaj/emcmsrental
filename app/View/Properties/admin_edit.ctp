<?php
	/*This css is applied only to this page*/
	echo $this->Html->css('common/dropzone/dropzone', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('common/calendar/jquery.dop.BackendBookingCalendarPRO', null, array('block'=>'cssMiddle'));
	
	// debug($this->request->data);

	$currency_symbol = $this->Html->getDefaultCurrencySymbol();
	if (isset($this->request->data['Currency']['symbol']) && !empty($this->request->data['Currency']['symbol'])) {
		$currency_symbol = trim($this->request->data['Currency']['symbol']);
	}

	$propertyID = null;
	if (isset($this->request->data['Property']['id'])) {
		$propertyID = (int) $this->request->data['Property']['id'];
	}
	
?>
<div class="row">
	<?php echo $this->Form->create('Property', array('type'=>'file', 'id'=>'property_edit_form', 'class'=>'form-horizontal'));
		echo $this->Form->input('Property.id');
		$propertyID = (int)$this->Form->value('Property.id');
	?>
	<div class="col-md-3">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo __('Edit Your Listning'); ?></h3>
			</div>
			<div class="box-body no-padding">
				<ul class="nav nav-pills nav-stacked"  role="tablist">
					<li role="presentation" class="active">
						<a href="#tab-1" aria-controls="tab-1" aria-expanded="true" role="tab" data-toggle="tab" class="inside-links">
							<!-- <i class="fa fa-cogs" aria-hidden="true"></i><?php echo __('General Info'); ?> -->
							<i class="fa fa-map-marker" aria-hidden="true"></i><?php echo __('Location'); ?>
						</a>
					</li>
					<li>
						<a href="#tab_calendar" aria-controls="tab_calendar" aria-expanded="false" role="tab" data-toggle="tab" class="inside-links" data-calendar="<?php echo $propertyID; ?>">
							<i class="fa fa-calendar" aria-hidden="true"></i><?php echo __('Calendar'); ?>
						</a>
					</li>
					<li>
						<a href="#tab_pricing" aria-controls="tab_pricing" aria-expanded="false" role="tab" data-toggle="tab" class="inside-links">
							<i class="fa fa-usd" aria-hidden="true"></i><?php echo __('Pricing'); ?>
						</a>
					</li>
					<li class="box-header with-border">
						<h3 class="box-title"><?php echo __('Listing'); ?></h3>
					</li>
					<li>
						<a href="#tab_basic" aria-controls="tab_basic" aria-expanded="false" role="tab" data-toggle="tab" class="inside-links">
							<i class="fa fa-file-text-o" aria-hidden="true"></i><?php echo __('Basic'); ?>
						</a>
					</li>
					<li>
						<a href="#tab_description" aria-controls="tab_description" aria-expanded="false" role="tab" data-toggle="tab" class="inside-links">
							<i class="fa fa-align-left" aria-hidden="true"></i><?php echo __('Description'); ?>
						</a>
					</li>
					<!-- 
					<li>
						<a href="#tab_location" aria-controls="tab_location" aria-expanded="false" role="tab" data-toggle="tab" class="inside-links">
							<i class="fa fa-map-marker" aria-hidden="true"></i><?php // echo __('Location'); ?>
						</a>
					</li>
					-->
					<li>
						<a href="#tab_amenities" aria-controls="tab_amenities" aria-expanded="false" role="tab" data-toggle="tab" class="inside-links">
							<i class="fa fa-bed" aria-hidden="true"></i><?php echo __('Amenities'); ?>
						</a>
					</li>
					<li>
						<a href="#tab_phottos" aria-controls="tab_phottos" aria-expanded="false" role="tab" data-toggle="tab" class="inside-links">
							<i class="fa fa-photo" aria-hidden="true"></i><?php echo __('Photos'); ?>
						</a>
					</li>
					<li>
						<a href="#tab_video" aria-controls="tab_video" aria-expanded="false" role="tab" data-toggle="tab" class="inside-links">
							<i class="fa fa-video-camera" aria-hidden="true"></i><?php echo __('Video'); ?>
						</a>
					</li>

					<li class="box-header with-border">
						<h3 class="box-title"><?php echo __('Guest Resources'); ?></h3>
					</li>
					<li>
						<a href="#tab_terms" aria-controls="tab_terms" aria-expanded="false" role="tab" data-toggle="tab" class="inside-links">
							<i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo __('Terms'); ?>
						</a>
					</li>
					<li>
						<a href="#tab_other" aria-controls="tab_other" aria-expanded="false" role="tab" data-toggle="tab" class="inside-links">
							<i class="fa fa-sliders" aria-hidden="true"></i><?php echo __('Other'); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo __('Edit property'); ?></h3>
				<!--
				<div class="box-tools pull-right">
					<div class="has-feedback">
						<input type="text" class="form-control input-sm" placeholder="Search Mail">
						<span class="glyphicon glyphicon-search form-control-feedback"></span>
					</div>
				</div>
				-->
			</div>
			<!-- /.box-header -->
			<div class="box-body no-padding">
				<div class="mailbox-controls">
					<?php echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-check')).'&nbsp;'.__('Save'), 'javascript:void(0);',array('escape' => false,'class'=>'btn btn-success btn-sm save-property')); ?>
					<div class="btn-group">
						<?php echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-times')).'&nbsp;'.__('Cancel'),array('controller' => 'properties', 'action' => 'index'),array('escape' => false,'class'=>'btn btn-default btn-sm')); ?>

						<?php  echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-plus')).'&nbsp;'.__('New'), array('controller' => 'properties', 'action' => 'add', 'admin'=>false), array('escape' => false,'class'=>'btn btn-default btn-sm')); ?>
					</div>
					<?php echo $this->Html->link($this->Html->tag('i','',array('class' => ' fa fa-trash-o')).'&nbsp;'.__('Delete'), 'javascript:void(0);', array('escape' => false, 'class'=>'btn btn-danger btn-sm remove-property-button', 'onclick' =>"deleteThisProperty({$propertyID}); return false;")); ?>
					<!--
					<div class="pull-right">
						1-50/200
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
							<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
						</div>
					</div>
					-->
				</div>
				<div class="mailbox-messages tab-content">
					<div role="tabpanel" class="tab-pane general fade in active" id="tab-1">
						<div class="col-md-12">
							<h2 class="text-center wizard-section-separator-text"> <?php echo __('Location'); ?></h2>

							<h3 class="wizard-section-separator-text"><?php echo __('Set Your Listing Location'); ?></h3>
							<p><?php echo __('You’re not only sharing your space, you’re sharing your neighborhood. Travelers will use this information to find a place that’s in the right spot.'); ?></p>
							<!-- address -->
							<hr>

							<div class="form-group">
								<div class="col-md-12">
									<h3><?php echo __('Address');?></h3>
									<span class="help-block"><?php echo __('While guests can see approximately where your listing is located in search results, your exact address is private and will only be shown to guests after they book your listing.');?></span>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3 col-md-3" data-toggle="tooltip" title="<?php echo __('Address of the property. You can also Drag &amp; Drop the marker on correct location'); ?>">
									<?php echo __('Address'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.address', array('class'=>'form-control','id'=>'addresspicker_map','label'=>false,'div'=>false)); ?>
								</div>
							</div>

							<div class="form-group hidden">
								<label class="control-label col-lg-3 col-md-3"><?php echo __('Latitude'); ?></label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.latitude',array('class'=>'form-control','id'=>'latitude','label'=>false,'div'=>false,'readonly' => 'readonly')); ?>
								</div>
							</div>

							<div class="form-group hidden">
								<label class="control-label col-lg-3 col-md-3"><?php echo __('Longitude'); ?></label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.longitude',array('class'=>'form-control','id'=>'longitude','label'=>false,'div'=>false,'readonly' => 'readonly')); ?>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3 col-md-3"><?php echo __('Country'); ?></label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.country',array('type'=>'text', 'class'=>'form-control','id'=>'country','label'=>false,'div'=>false)); ?>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3 col-md-3"><?php echo __('Locality'); ?></label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.locality',array('class'=>'form-control','id'=>'locality','label'=>false,'div'=>false)); ?>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3 col-md-3"><?php echo __('District'); ?></label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.district',array('class'=>'form-control','id'=>'district','label'=>false,'div'=>false)); ?>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3 col-md-3"><?php echo __('State/Province'); ?></label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.state_province',array('class'=>'form-control','id'=>'state_province','label'=>false,'div'=>false)); ?>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3 col-md-3"><?php echo __('Zip/Postal code'); ?></label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.zip_code',array('class'=>'form-control', 'placeholder'=>__('ZIP code'),'id'=>'postal_code','label'=>false, 'div'=>false)); ?>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
							</div>

							<div class="form-group ">
								<div class="col-lg-12">
									<div class="map-clearfix">
										<div id="map"></div>
										<div class="help-block"><?php echo __('You can drag and drop the marker to the correct location'); ?></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane calendar fade" id="tab_calendar">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-12">
									<button type="button" class="btn btn-info" id="backend-refresh"><?php echo __('Refresh Calendar'); ?></button>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div id="backend_calendar"></div>
								</div>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane pricing fade" id="tab_pricing">
						<div class="col-md-12">
							<h2 class="text-center wizard-section-separator-text"> <?php echo __('Property Types'); ?></h2>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Minimum days that a user is allowed to book.'); ?>">
									<?php echo __('Min. Days'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.minimum_days',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false, 'min'=>'1')); ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Maximum days that a user is allowed to book.'); ?>">
									<?php echo __('Max. Days'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.maximum_days',array('class'=>'form-control','label'=>false,'div'=>false)); ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Property surface area in (m2)'); ?>">
									<?php echo __('Surface Area'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<?php
									?>
									<div class="input-group">
										<?php
											echo $this->Form->input('Property.surface_area', array('class'=>'form-control allow-only-numbers', 'div'=>false,'label'=>false));
										?>
										<div class="input-group-addon">m<sup>2</sup></div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Select the time when user checkin'); ?>">
									<?php echo __('Checkin Time'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<div class="input-group readonly">
										<?php
											echo $this->Form->input('Property.checkin_time', array('id'=>'checkin_time', 'class'=>'form-control', 'placeholder'=>__('13:30'), 'div'=>false,'label'=>false, 'autocomplete'=>'off', 'readonly'=>'readonly'));
										?>
										<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Select the time when user checkout'); ?>">
									<?php echo __('Checkout Time'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<div class="input-group readonly">
										<?php
											echo $this->Form->input('Property.checkout_time', array('id'=>'checkout_time', 'class'=>'form-control', 'placeholder'=>__('11:30'), 'div'=>false,'label'=>false, 'autocomplete'=>'off', 'readonly'=>'readonly'));
										?>
										<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label">
									<?php echo __('Construction year'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<div class="input-group readonly">
										<?php
											echo $this->Form->input('Property.construction_year', array('id'=>'construction_year', 'class'=>'form-control', 'placeholder'=>__('Construction year'), 'div'=>false,'label'=>false,'readonly'=>'readonly'));
										?>
										<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<h3><?php echo __('Set a Nightly Price for Your Space.');?></h3>
									<span class="help-block"><?php echo __('You can set a price to reflect the space, amenities, and hospitality you’ll be providing.');?></span>
								</div>
							</div>
							

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Daily Rent Price, the daily charge for the customer'); ?>">
									<?php echo __('Rent Price'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<?php
										echo $this->Form->input('Property.price', array('id'=>'property_for_rent', 'class'=>'form-control allow-only-numbers', 'placeholder'=>__('Price for Rent (daily)'), 'div'=>false,'label'=>false));
									?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Weekly Price, weekly charge for the customer. 7 days'); ?>">
									<?php echo __('Weekly Price'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<?php
										echo $this->Form->input('Property.weekly_price', array('class'=>'form-control allow-only-numbers', 'placeholder'=>__('Price for Rent (weekly)'), 'div'=>false,'label'=>false));
									?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Monthly Price, monthly charge for the customer. 28 days'); ?>">
									<?php echo __('Monthly Price'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<?php
										echo $this->Form->input('Property.monthly_price', array('class'=>'form-control allow-only-numbers', 'placeholder'=>__('Price for Rent (monthly)'), 'div'=>false,'label'=>false));
									?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Currency of the price.'); ?>">
									<?php echo __('Currency'); ?>
								</label>
								<div class="col-lg-8 col-md-8 has-custom-dropdown">
									<?php
										echo $this->Form->input('Property.currency_id', array('class'=>'form-control', 'div'=>false,'label'=>false,'required'=>true, 'empty' => __('Select Currency')));
									?>
								</div>
							</div>

							<!-- prices -->
							<?php 
								echo $this->Form->input('Price.id');
								echo $this->Form->input('Price.model', array('type'=>'hidden'));
								echo $this->Form->input('Price.model_id', array('type'=>'hidden'));
							?>

							<?php if (false): ?>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<h3><?php echo __('Set a Nightly Price for Your Space.');?></h3>
									<span class="help-block"><?php echo __('You can set a price to reflect the space, amenities, and hospitality you’ll be providing.');?></span>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Daily Rent Price, the daily charge for the customer'); ?>">
									<?php echo __('Rent Price'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<?php
										echo $this->Form->input('Price.night', array('class'=>'form-control', 'placeholder'=>__('night Price'), 'div'=>false,'label'=>false));
									?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Weekly Price, weekly charge for the customer. 7 days'); ?>">
									<?php echo __('Weekly Price'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<?php
										echo $this->Form->input('Price.week', array('type'=>'text', 'class'=>'form-control', 'placeholder'=>__('Weekly Price'), 'div'=>false,'label'=>false));
									?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Monthly Price, monthly charge for the customer. 28 days'); ?>">
									<?php echo __('Monthly Price'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<!-- <input name="data[Price][month]" class="form-control" placeholder="<?php // echo ('Monthly Price'); ?>" type="number"/> -->
									<?php
										echo $this->Form->input('Price.month', array('type'=>'number', 'class'=>'form-control', 'placeholder'=>__('Monthly Price'), 'div'=>false,'label'=>false, 'min'=>0));
									?>
								</div>
							</div>
							<?php endif ?>

							<!-- additional prices -->
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<h3><?php echo __('Additional Charges.');?></h3>
									<span class="help-block"><?php echo __('These charges are added to the reservation total.');?></span>
								</div>
							</div>
							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Cleaning Fee');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Price.cleaning',array('label'=>false, 'div'=>false,'class'=>'form-control', 'placeholder'=>__('Cleaning Fee'))); ?>
							    </div>
							</div>
							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Additional Guests price');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Price.addguests',array('label'=>false, 'div'=>false,'class'=>'form-control allow-only-numbers','placeholder'=>__('For each guest after'))); ?>
							        <span class="help-block"><?php echo __('For each guest after.');?></span>
							    </div>

							    <div class="col-sm-6 col-sm-offset-3">
							        <?php echo $this->Form->input('Price.guests',array('label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select', 'options' => $this->Html->getData('capacity'), 'empty'=> __('Select Guests'), 'escape' => false)); ?>
							        <span class="help-block"><?php echo __('per person per night.');?></span>
							    </div>
							</div>
							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Security Deposit ');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Price.security_deposit', array('label'=>false, 'div'=>false,'class'=>'form-control allow-only-numbers')); ?>
							    </div>
							</div>

						</div>
					</div>

					<div role="tabpanel" class="tab-pane basic fade" id="tab_basic">
						<div class="col-md-12">
							<h3><?php echo __('Help Travelers Find the Right Fit'); ?></h3>
							<p class="help-block">
								<?php echo __('People searching on %s can filter by listing basics to find a space that matches their needs.', Configure::read('Website.name'));?>
							</p>

							<h4 class="text-center"><?php echo __('Listing Types'); ?></h4>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label"  data-toggle="tooltip" title="<?php echo __('Accommodation Types'); ?>">
										<?php echo __('Accommodation'); ?>
									</label>
								</div>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.accommodation_type_id', array('id'=>'accommodation_type_id','class'=>'form-control', 'div'=>false,'label'=>false)); ?>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label" data-toggle="tooltip" title="<?php echo __('Room types.'); ?>">
										<?php echo __('Room Type'); ?>
									</label>
								</div>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.room_type_id', array('class'=>'form-control', 'id'=>'room_type_id', 'div'=>false,'label'=>false)); ?>
								</div>
							</div>

							<div class="form-group ">
								<div class="col-lg-3 col-md-3">
									<label class="control-label" data-toggle="tooltip" title="<?php echo __('Maximum number of people that can be hosted in this property.'); ?>">
										<?php echo __('Capacity'); ?>
									</label>
								</div>
								<div class="col-lg-8 col-md-8 has-custom-dropdown">
									<?php echo $this->Form->input('Property.capacity',array('id'=>'capacity', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options'=>$this->Html->getData('capacity'), 'empty'=> __('Select capacity'))); ?>
								</div>
							</div>

							<h4 class="text-center"> <?php echo __('Rooms and Beds'); ?></h4>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label" data-toggle="tooltip" title="<?php echo __('Number of rooms.'); ?>">
										<?php echo __('Rooms'); ?>
									</label>
								</div>
								<div class="col-lg-8 col-md-8 has-custom-dropdown">
									<?php echo $this->Form->input('Property.bedroom_number',array('id'=>'bedroom_number', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' =>$this->Html->getData('bedrooms'), 'empty'=> __('Select rooms'))); ?>
								</div>
							</div>

							<div class="form-group ">
								<div class="col-lg-3 col-md-3">
									<label class="control-label" data-toggle="tooltip" title="<?php echo __('Total number of beds.'); ?>">
										<?php echo __('Beds'); ?>
									</label>
								</div>
								<div class="col-lg-8 col-md-8 has-custom-dropdown">
									<?php echo $this->Form->input('Property.bed_number',array('id'=>'bed_number', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('beds'), 'empty'=> __('Select beds'))); ?>
								</div>
							</div>

							<div class="form-group ">
								<div class="col-lg-3 col-md-3">
									<label class="control-label"  data-toggle="tooltip" title="<?php echo __('Total number of bathrooms.'); ?>">
										<?php echo __('Bathrooms'); ?>
									</label>
								</div>
								<div class="col-lg-8 col-md-8 has-custom-dropdown">
									<?php echo $this->Form->input('Property.bathroom_number',array('id'=>'bathroom_number', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('bathrooms'), 'empty'=> __('Select bathrooms'))); ?>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label" data-toggle="tooltip" title="<?php echo __('Number of garages that this property has'); ?>">
										<?php echo __('Garages'); ?>
									</label>
								</div>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('Property.garages',array('id'=>'garages','label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('garages'), 'empty'=>__('Select garages'), 'escape'=>false)); ?>
								</div>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane description fade" id="tab_description">
						<div class="col-md-12">
							<h3><?php echo __('Tell Travelers About Your Space'); ?></h3>
							<p><?php echo __('Every space on %s is unique. Highlight what makes your listing welcoming so that it stands out to guests who want to stay in your area.', Configure::read('Website.name')); ?></p>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label" data-toggle="tooltip" title="<?php echo __('Title of the property.'); ?>">
										<?php echo __('Listing Name '); ?>
									</label>
								</div>
								<div class="col-lg-9 col-md-9">
								<?php if (count($languages) > 1): ?>
									<div class="form-group">
								<?php endif ?>

								<?php foreach ($this->request->data['PropertyTranslation'] as $index => $property): ?>
									<?php $id_lang = $property['Language']['id']; ?>

									<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($property['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >

									<?php if (count($languages) > 1): ?>
										<div class="col-lg-10">
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
										<div class="col-lg-2 dropdown">
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
							</div>							
							
							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label wizard-label"  data-toggle="tooltip" title="<?php echo __('Property Description.'); ?>">
										<?php echo __('Summary');  ?>
									</label>
									<span class="help-block"><?php echo __('Tell travelers what you love about the space. You can include details about the decor, the amenities it includes, and the neighborhood.');?></span>
								</div>
								<div class="col-lg-9 col-md-9">
								<?php if (count($languages) > 1): ?>
									<div class="form-group">
								<?php endif ?>

								<?php foreach ($this->request->data['PropertyTranslation'] as $index => $property): ?>
									<?php $id_lang = $property['Language']['id']; ?>

									<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($property['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >

									<?php if (count($languages) > 1): ?>
										<div class="col-lg-10">
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
										<div class="col-lg-2 dropdown">
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
							</div>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label wizard-label">
										<?php echo __('Location Description'); ?>
									</label>
									<span class="help-block"><?php echo __('Other information you wish to share on your public listing page.');?></span>
								</div>
								<div class="col-lg-9 col-md-9">
								<?php if (count($languages) > 1): ?>
									<div class="form-group">
								<?php endif ?>

								<?php foreach ($this->request->data['PropertyTranslation'] as $index => $property): ?>
									<?php $id_lang = $property['Language']['id']; ?>

									<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($property['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
									<?php if (count($languages) > 1): ?>
										<div class="col-lg-10">
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
										<div class="col-lg-2 dropdown">
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
							</div>

							<div class="form-group">
								<div class="col-lg-3 col-md-3">
									<label class="control-label wizard-label"   data-toggle="tooltip" title="<?php echo __('Public title for the product page and for search engines. Leave blank to use the product name. The number of remaining characters is displayed to the left of the field.'); ?>">
										<?php echo __('Meta Title'); ?>
									</label>
								</div>
								<div class="col-lg-9 col-md-9">
								<?php if (count($languages) > 1): ?>
									<div class="form-group">
								<?php endif ?>

								<?php foreach ($this->request->data['PropertyTranslation'] as $index => $property): ?>
									<?php $id_lang = $property['Language']['id']; ?>

									<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($property['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
									<?php if (count($languages) > 1): ?>
										<div class="col-lg-10">
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
										<div class="col-lg-2 dropdown">
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
								<div class="col-lg-9 col-md-9">
								<?php if (count($languages) > 1): ?>
									<div class="form-group">
								<?php endif ?>

								<?php foreach ($this->request->data['PropertyTranslation'] as $index => $property): ?>
									<?php $id_lang = $property['Language']['id']; ?>

									<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($property['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
									<?php if (count($languages) > 1): ?>
										<div class="col-lg-10">
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
										<div class="col-lg-2 dropdown">
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
							</div>
						</div>
					</div>

					<?php if (false): ?>
					<div role="tabpanel" class="tab-pane location fade" id="tab_location" >
						<div class="col-md-12">
							<h3 class="wizard-section-separator-text"><?php echo __('Set Your Listing Location'); ?></h3>
							<p><?php echo __('You’re not only sharing your space, you’re sharing your neighborhood. Travelers will use this information to find a place that’s in the right spot.'); ?></p>
							<hr>
							<?php echo $this->Form->input('Address.id'); ?>
							<?php echo $this->Form->input('Address.model', array('type'=>'hidden'));?>
							<?php echo $this->Form->input('Address.model_id', array('type'=>'hidden')); ?>

							<div class="form-group">
								<div class="col-md-12">
									<h3><?php echo __('Address');?></h3>
									<span class="help-block"><?php echo __('While guests can see approximately where your listing is located in search results, your exact address is private and will only be shown to guests after they book your listing.');?></span>
								</div>
							</div>
							<div class="form-group ">
							    <label class="col-sm-3 control-label" data-toggle="tooltip" title="<?php echo __('DNI / NIF / NIE');?>"><?php echo __('Identification number');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.dni',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Identification number'), 'data-maxlength'=>'16')); ?>
							    </div>
							</div>
							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Address Alias');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.alias',array('label'=>false, 'div'=>false, 'class'=>'form-control count-char','placeholder'=>__('Alias'), 'data-maxlength'=>'32')); ?>
							    </div>
							</div>

							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Company');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.company',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Company'), 'data-maxlength'=>'128')); ?>
							    </div>
							</div>

							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('VAT Number');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.vat_number',array('id' => 'vat_number', 'label'=>false, 'div'=>false, 'class'=>'form-control count-char','placeholder'=>__('Vat Number'), 'data-maxlength'=>'32')); ?>
							    </div>
							</div>

							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Address');?>*</label>
								    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.address1',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Address line 1'), 'data-maxlength'=>'128', 'required' => 'required'));?>
							    </div>
							</div>

							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Address (2)');?></label>
								    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.address2',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Address line 2')));?>
							    </div>
							</div>

							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('City');?>*</label>
								    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.city',array('label'=>false, 'div'=>false,'class'=>'form-control', 'required' => 'required'));?>
							    </div>
							</div>

							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('ZIP/Postal Code');?></label>
								    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.postal_code',array('label'=>false, 'div'=>false,'class'=>'form-control'));?>
							    </div>
							</div>


							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Country');?>*</label>
								<div class="col-sm-6">
							        <?php echo $this->Form->input('Address.country_id',array('id'=>'id_country', 'label'=>false, 'div'=>false,'class'=>'form-control', 'escape' => false, 'empty' => __('Select Country'))); ?>
							    </div>
							</div>

							<div class="form-group" id="contains_states">
							    <label class="col-sm-3 control-label"><?php echo __('State');?>*</label>
								<div class="col-sm-6">
							        <?php echo $this->Form->input('Address.state_id',array('id'=>'id_state', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select', 'options' =>[], 'escape' => false)); ?>
							    </div>
							</div>

							<div class="form-group ">
							    <label class="col-sm-3 control-label" data-toggle="tooltip" title="<?php echo __('You must register at least one phone number.');?>"><?php echo __('Home phone');?>*</label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.phone',array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
							    </div>
							</div>
							<div class="form-group ">
							    <label class="col-sm-3 control-label" data-toggle="tooltip" title="<?php echo __('You must register at least one phone number.');?>"><?php echo __('Mobile phone');?>*</label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.phone_mobile',array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
							    </div>
							</div>

							<div class="form-group ">
							    <label class="col-sm-3 control-label"><?php echo __('Other');?></label>
							    <div class="col-sm-6">
							        <?php echo $this->Form->input('Address.other',array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
							    </div>
							</div>
						</div>
					</div>
					<?php endif ?>

					<div role="tabpanel" class="tab-pane amenities fade" id="tab_amenities">
						<div class="col-md-12">
							<h4 class="wizard-section-separator-text">
								<?php echo __('Tell Travelers About Your Space'); ?>
							</h4>
							<span class="help-block">
								<?php echo __('Every space on EMRS is unique. Highlight what makes your listing welcoming so that it stands out to guests who want to stay in your area.');?>
							</span>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Check only available characteristics on your property.'); ?>">
									<?php echo __('Characteristics'); ?>
								</label>
								<hr />
								<div class="col-lg-8 col-md-8 col-md-offset-3">
									<div class="row">
										<?php foreach ($AllCharacteristics as $characteristic) { ?>
											<?php
												$retVal = '';
												if (is_array($this->Form->value('Characteristic.Characteristic'))) {
													$retVal = (in_array($characteristic['Characteristic']['id'], $this->Form->value('Characteristic.Characteristic'))) ? 'checked' : '';
												}
											?>
											<div class="col-lg-6 col-md-6 col-sm-6">
												<label>
													<input type="checkbox" value="<?php echo $characteristic['Characteristic']['id']; ?>" name="data[Characteristic][Characteristic][]" <?php echo "{$retVal}"; ?>/>
													<!-- <i class="<?php // echo $characteristic['Characteristic']['icon_class']; ?>"></i> -->
													<span class="name"><?php echo $characteristic['CharacteristicTranslation']['characteristic_name']; ?></span>
												</label>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Check only available safeties on your property.'); ?>">
									<?php echo __('Safeties'); ?>
								</label>
								<hr />
								<div class="col-lg-8 col-md-8 col-md-offset-3">
									<div class="row">
										<?php foreach ($AllSafeties as $safety) { ?>
											<?php
												$retVal ='';
												if (is_array($this->Form->value('Safety.Safety'))) {
													$retVal = (in_array($safety['Safety']['id'], $this->Form->value('Safety.Safety'))) ? 'checked' : '' ;
												}
											?>
											<div class="col-lg-6 col-md-6 col-sm-6">
												<label>
													<input type="checkbox" value="<?php echo $safety['Safety']['id']; ?>" name="data[Safety][Safety][]" <?php echo "{$retVal}"; ?> />
													<!-- <i class="<?php  // echo $safety['Safety']['icon_class']; ?>"></i> -->
													<span class="name"><?php echo $safety['SafetyTranslation']['safety_name']; ?></span>
												</label>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane phottos fade" id="tab_phottos">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-12 text-center">
									<!-- <img src="http://res.cloudinary.com/dropinn65/image/upload/images/inbox.png"> -->
									<h3>
										<?php echo __('Photos Can Bring Your Space to Life. Add a photo or two!');?>
									</h3>
									<span class="help-block">
										<?php echo __('Or three, or more! Guests love photos that highlight the features of your space.');?>
									</span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div id="my-dropzone" class="dropzone clickable-dropzone">
										<div class="fallback">
											<?php echo __('Update your brouser in order to support Drag&amp;Drop features.'); ?>
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
								<div id="sortable-containment" class="col-md-12">
									<ul id="sortable_images" class="photo_img"></ul>
								</div>
								<div class="col-md-12">
									<span class="help-block"><?php echo __('Here you can Drag&Drop images to sort them, you can write image caption, you can delete them. The first image is the default image');?></span>
								</div>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane video fade" id="tab_video">
						<div class="col-md-12">
							<h3 class="wizard-section-separator-text"> <?php echo __('Video Can Bring Your Space to Life'); ?></h3>
							<span class="help-block">
								<?php echo __('Add video of areas guests have access to.');?>
							</span>
							<div class="form-group">
								<div class="col-md-8">
									<label class="control-label" for="video_url"><?php echo __('Video url');?></label>
									<div class="input-group">
										<?php
											echo $this->Form->input('video_url', array('id'=>'video_url', 'class'=>'form-control', 'placeholder'=>__('Video url'), 'div'=>false,'label'=>false));
										?>
										<div class="input-group-addon"><i class="fa fa-files-o"></i></div>
									</div>
									<span class="help-block"><?php echo __('Upload your video to your youtube.com channel or Vimeo and then just insert the video URL in the field above.');?></span>
								</div>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane terms fade" id="tab_terms">
						<div class="col-md-12">
							<h3 class="wizard-section-separator-text"> <?php echo __('Terms'); ?></h3>
							<span class="help-block">
								<?php echo __('The requirements and conditions to book a reservation at your listing.');?>
							</span>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Select the type of the cancellation policy.'); ?>">
									<?php echo __('Cancellation Policy'); ?>
								</label>
								<div class="col-lg-6 col-md-6">
									<?php echo $this->Form->input('cancellation_policy_id', array('class'=>'form-control', 'div'=>false,'label'=>false, 'empty'=>__('Select...'),'escape' => false, 'type'=>'select','options' =>$cancellationPolicies)); ?>
								</div>
								<div class="col-lg-3 col-md-3 message"></div>
							</div>

						</div>
					</div>

					<div role="tabpanel" class="tab-pane other fade" id="tab_other" >
						<div class="col-md-12">
							<h2 class="text-center wizard-section-separator-text"> <?php echo __('Other information'); ?></h2>

							<!-- PACKING LIST -->
							<div class="form-group">
								<div class="col-sm-8 col-sm-offset-2">
									<h3><?php echo __('Availability');?></h3>
									<p class="help-block"><?php echo __('If you host only for a period of time. Please select the dates.');?></p>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-8 col-sm-offset-2">
									<?php echo $this->Form->input('availability_type',array('div'=>false, 'class'=>'form-control js-availability-type','type'=>'select', 'options' => ['always' => 'Always', 'one_time' => 'One time',],  'escape' => false)); ?>
								</div>
							</div>
							
							<div class="js-availability-container" <?php if ($this->request->data['Property']['availability_type'] !== 'one_time') { ?> style="display: none;" <?php } ?>>
								<div class="form-group ">
								    <div class="col-sm-4 col-sm-offset-2">
								        <?php echo $this->Form->input('available_from',array('id'=>'available_from','div'=>false,'class'=>'form-control js-date-picker','placeholder'=>__('From'), 'autocomplete'=>'off')); ?>
								    </div>
								    <div class="col-sm-4">
								        <?php echo $this->Form->input('available_to',array('id'=>'available_to','div'=>false,'class'=>'form-control js-date-picker', 'placeholder'=>__('To'), 'autocomplete'=>'off')); ?>
								    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-3 col-md-3 text-right">
									<label class="control-label"><?php echo __('Instant Booking?');?></label>
								</div>
								<div class="col-lg-8 col-md-8 ">
									<?php echo $this->Form->input('allow_instant_booking', array('type'=>'checkbox','label'=>false, 'div'=>false, 'class'=>'bootstrap-switch')); ?>
									<span class="help-block"><?php echo __('Set to yes if you want to allow users to instantly book your space.');?></span>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Check if you want your property to be public'); ?>">
									<?php echo __('Publish Status'); ?>
								</label>
								<div class="col-lg-8 col-md-8 ">
									<?php echo $this->Form->input('status', array('class'=>'bootstrap-switch', 'div'=>false,'label'=>false)); ?>
								</div>
							</div>

							<div class="form-group ">
								<label class="col-lg-3 col-md-3 control-label" data-toggle="tooltip" title="<?php echo __('Indicates weather property has been aproved by admin.'); ?>">
									<?php echo __('Is approved'); ?>
								</label>
								<div class="col-lg-8 col-md-8">
									<?php echo $this->Form->input('is_approved', array('class'=>'bootstrap-switch', 'div'=>false,'label'=>false)); ?>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer no-padding">
				<div class="mailbox-controls">
					<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-check')).'&nbsp;'.__('Save'),'javascript:void(0);',array('escape' => false,'class'=>'btn btn-success btn-sm save-property')); ?>
					<div class="btn-group">
						<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-times')).'&nbsp;'.__('Cancel'),array('controller' => 'properties', 'action' => 'index'),array('escape' => false,'class'=>'btn btn-default btn-sm')); ?>

						<?php  echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus')).'&nbsp;'.__('New'),array('controller' => 'properties', 'action' => 'add', 'admin'=>false),array('escape' => false,'class'=>'btn btn-default btn-sm')); ?>
					</div>
					<?php echo $this->Html->link($this->Html->tag('i','',array('class' => ' fa fa-trash-o')).'&nbsp;'.__('Delete'),'javascript:void(0);',array('escape' => false,'class'=>'btn btn-danger btn-sm remove-property-button', 'onclick' =>"deleteThisProperty({$propertyID}); return false;")); ?>
					<!--
					<div class="pull-right">
						1-50/200
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
							<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
						</div>
					</div>
					-->
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
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
echo $this->Html->script('common/dropzone/dropzone', array('block' => 'scriptBottomMiddle'));
echo $this->Html->script('common/calendar/backendBookingCalendar', array('block' => 'scriptBottomMiddle'));
echo $this->Html->script('common/typewatch/jquery.typewatch', array('block' => 'scriptBottomMiddle'));
echo $this->Html->script('common/jquery-ui-timepicker-addon', array('block' => 'scriptBottomMiddle'));
$this->Froala->editor('.froala', array('block'=>'scriptBottom'));
$this->Html->scriptBlock("
	var propertyID = '".$propertyID."',
		currency_symbol = '".$currency_symbol."',
		property_price = '".(isset($this->request->data['Property']['price']) ? $this->request->data['Property']['price'] : null)."',
		selectedState = '".(isset($this->request->data['Address']['state_id']) ? $this->request->data['Property']['price'] : null)."',
		myDropzone = null,
		calendar = null,
		map = null;
	(function($){
		$(document).ready(function() {
			'use strict';

			// CALL FUNCTIONS TO SEE WHICH ELEMENT HAS BEEN SELECTED
			getPropertyImages(propertyID);

			// GOOGLE MAP INICIALISATION
			var addresspickerMap = $('#addresspicker_map').addresspicker({
				regionBias: '',
				key: google_map_key,
				language: '',
				componentsFilter: '',
				updateCallback: showCallback,
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

			$('#reverseGeocode').change(function(){
				$('#addresspicker_map').addresspicker('option', 'reverseGeocode', ($(this).val() === 'true'));
			});

			function showCallback(geocodeResult, parsedGeocodeResult){
				$('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
			}

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

			if ($('#id_country') && $('#id_state')) {
				if(selectedState) {
					ajaxStates(selectedState);
				}
				
				$('#id_country').on('change', function() {
					ajaxStates();
				});
			}

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

			// CONFIRM POPUP
			$('a.save-property').off('click');
			$('a.save-property').on('click', function(event) {
				event.preventDefault();
				$('#dialog-confirm').dialog({
					resizable: false,
					modal: true,
					buttons: {
						'Yes': function() {
							$('#property_edit_form').submit();
						},
						'Cancel': function() {
							$(this).dialog('close');
						}
					}
				});
				return;
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

			// REFRESHING BACKEND CALENDAR
			$('#backend-refresh').on('click', function(e){
				e.preventDefault();
				$('#backend_calendar').DOPBackendBookingCalendarPRO({
					'Reinitialize': true,
					'DataURL': fullBaseUrl+'/properties/loadCalendar/'+propertyID,
					'ID': propertyID,
					'PropertyID': propertyID,
					'PropertyPrice': property_price,
					'Currency': currency_symbol,
					'SaveURL': fullBaseUrl+'/properties/saveCalendar/'+propertyID,
				});
				return true;
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
					toastr.warning(data.error_message, 'Warning');
					var _this = this;
					_this.removeFile(file);
				}
				//var args = Array.prototype.slice.call(arguments);
			});

			// SHOW NOTIFICATION IF ANYTHING GOES WRONG
			myDropzone.on('error', function(file, response) {
				toastr.warning('Something went wrong while trying to fetch the data from server', 'Error!');
				var _this = this;
				_this.removeFile(file);
			});

			myDropzone.on('addedfile', function(file) {
				// console.log(this.getQueuedFiles().length);
				// console.log(this.getUploadingFiles().length);
				// console.log(this.getAcceptedFiles());
			});

			// LOAD ALL IMAGES AFTER UPLOAD HAS FINISHED
			myDropzone.on('queuecomplete', function() {
				getPropertyImages(propertyID);
			});

			//SORT PROPERTY IMAGES
			$('#sortable_images').sortable({
				opacity: 0.8,
				cursor: 'move',
				revert: true,
				delay: 150,
				tolerance: 'pointer',
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

			/**
			 * Events
			 * When showing a new tab, the events fire in the following order:
			 * hide.bs.tab (on the current active tab)
			 * show.bs.tab (on the to-be-shown tab)
			 * hidden.bs.tab (on the previous active tab, the same one as for the hide.bs.tab event)
			 * shown.bs.tab (on the newly-active just-shown tab, the same one as for the show.bs.tab event)
			 */
			$('a[data-toggle=\"tab\"]').on('shown.bs.tab', function (e) {
				if (e.target.hasAttribute('data-calendar')) {
					var property_id = e.target.getAttribute('data-calendar');
					$('#backend_calendar').DOPBackendBookingCalendarPRO({
						'DataURL': fullBaseUrl+'/properties/loadCalendar/'+property_id,
						'ID': property_id,
						'PropertyID': property_id,
						'PropertyPrice': property_price,
						'Currency': currency_symbol,
						'SaveURL': fullBaseUrl+'/properties/saveCalendar/'+property_id,
					});
				}
				// e.target // newly activated tab
				// e.relatedTarget // previous active tab
			});

		});
	})(jQuery);

	function ajaxStates(id_state_selected) {
		$.ajax({
			url: fullBaseUrl+'/countries/getStatesByCountry/'+$('#id_country').val(),
			cache: false,
			data: 'no_empty=0&id_country='+$('#id_country').val() + '&id_state=' + $('#id_state').val(),
			success: function(html) {
				if (html == 'false') {
					$('#contains_states').fadeOut();
					$('#id_state option[value=0]').attr('selected', 'selected');
				} else {
					$('#id_state').html(html);
					$('#contains_states').fadeIn();
					$('#id_state option[value=' + id_state_selected + ']').attr('selected', 'selected');
				}
			}
		});
	}

	// GET ALL IMAGES OF A SPECIFIC PROPERTY
	function getPropertyImages(property_id){
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


	// DELETE PROPERTY
	function deleteThisProperty(elementId){
		$( '#dialog-confirm-delete' ).dialog({
			resizable: false,
			modal: true,
			buttons: {
				'Delete': function() {
					isValid = true;
					var deleteReason = $('#property_delete_reason').val();
					if(!deleteReason || deleteReason.length <= 0){
						isValid = false;
						$('#property_delete_message').removeClass('alert-success').addClass('alert-danger').html('". addslashes(__('Please write something'))."').show();
					}else{
						$('#property_delete_message').removeClass('alert-danger').addClass('alert-success').html('Success!').show();
						isValid = true;
					}

					if (isValid) {
						var delete_reason = $('#property_delete_reason').val();
						var formData = 'property_id='+elementId+'&delete_reason='+ delete_reason+'&action=delete';
						$.ajax({
							data: formData,
							dataType:'json',
							success:function(data){
								if (data==1) {
									showPreloader();
									window.location = '".Router::Url(array('admin' => true, 'controller' => 'properties', 'action' => 'index'), true)."';
									$('#dialog-confirm-delete').dialog( 'close' );
								} else {
									toastr.error('".addslashes(__('Something Went Wrong wrong with delete'))."','Error!');
								}
							},
							error: function(){
								toastr.error('".addslashes(__('Something Went Wrong. We couldnt fetch the data'))."','Error!');
							},
							complete: function(done){
							},
							type: 'POST',
							url:'".Router::Url(array('admin' => true, 'controller' => 'properties', 'action' => 'deletePropertyAjax', $propertyID), true)."',
						});
						return;
					}
				},
				'Cancel': function() {
					$(this).dialog( 'close' );
				}
			}
		});
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
			<?php echo $this->Form->input('delete_reason',array('id'=>'property_delete_reason', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'textarea', 'placeholder'=>__('Write why are you deleting this property.'))); ?>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12 message alert" id="property_delete_message"></div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
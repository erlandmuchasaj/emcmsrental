<?php
	/*This css is applied only to this page*/
	echo $this->Html->css('frontend/fotorama/fotorama', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('common/calendar/jquery.dop.FrontendBookingCalendarPRO', null, array('block'=>'cssMiddle'));

	$propertyId = (int)$property['Property']['id'];

	$current_user_id = null;
	if (AuthComponent::user('id')) {
		$current_user_id = AuthComponent::user('id');
	}

	$currency_symbol = $this->Html->getDefaultCurrencySymbol();
	if (isset($property['Currency']['symbol']) && !empty($property['Currency']['symbol'])) {
		$currency_symbol = trim($property['Currency']['symbol']);
	}

	if (!empty($property['PropertyTranslation']['seo_title'])) {
		$this->set('title_for_layout', getDescriptionHtml($property['PropertyTranslation']['seo_title']));
		$this->assign('meta_title', getDescriptionHtml($property['PropertyTranslation']['seo_title']));
	}

	if (!empty($property['PropertyTranslation']['seo_description'])) {
		$this->assign('meta_description', getDescriptionHtml($property['PropertyTranslation']['seo_description']));
	}

	$this->assign('meta_url', Router::Url(null, true));
	$this->assign('meta_image', Router::url("/img/uploads/Property/{$propertyId}/PropertyPicture/large/{$property['Property']['thumbnail']}", true));
?>

<div class="em-container single-property">
	<!-- USER INFO & ADDRESS -->
	<div class="row">
		<div class="col-sm-12 property-details">
			<div class="agent">
				<?php
					echo $this->Html->link(
						$this->Html->displayUserAvatar($property['User']['image_path']),
						array('controller'=>'users', 'action'=>'view', $property['User']['id']),
						array('target' => '_blank', 'escape' => false, 'class'=>'avatar')
					);
				?>
				<h2 class="location">
					<?php echo getDescriptionHtml($property['Property']['location']); ?>
				</h2>
			</div>
		</div>
	</div>

	<!-- SLIDER -->
	<div class="row">
		<div class="col-md-12">
			<div id="fotorama_viewslider" class="fotorama"
				data-width="100%"
				data-ratio="16/9"
				data-minwidth="320"
				data-maxwidth="100%"
				data-minheight="360"
				data-maxheight="100%"
				data-transition="slide"
				data-clicktransition="crossfade"
				data-fit="cover"
				data-hash="false"
				data-loop="true"
				data-autoplay="true"
				data-arrows="true"
				data-click="true"
				data-swipe="true"
				data-stopautoplayontouch="false"
				data-shuffle="false"
				data-keyboard="true"
				data-nav="thumbs"
				data-navwidth= "100%"
				data-thumbfit="cover"
				data-allowfullscreen="true"
			  	>
				<?php
				if (!empty($property['PropertyPicture'])) {
					$directoryMdURL = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$propertyId.DS.'PropertyPicture'. DS . 'large' . DS;
					$baseDir = "/img/uploads/Property/{$propertyId}/PropertyPicture";

					$directoryMdPATH = "img/uploads/Property/{$propertyId}/PropertyPicture/large/";

					foreach ($property['PropertyPicture'] as $key => $propertyPicture) {
						$thumbnail = $largeImage = $fullImg = Router::url('/img/placeholder.png', true);
						if (file_exists($directoryMdURL.$propertyPicture['image_path']) && is_file($directoryMdURL .$propertyPicture['image_path'])) {

							$fullImg =  Router::url($baseDir."/".$propertyPicture['image_path'], true);

							$largeImage =  Router::url($baseDir."/large/".$propertyPicture['image_path'], true);

							$thumbnail =  Router::url($baseDir."/thumb/".$propertyPicture['image_path'], true);
						}
						echo $this->Html->link(
							'', // this is used for lazy loading
							/*
							//this is used if you worry for javascript
							$this->Html->image(
								$thumbnail,
								array(
									'alt' => 'property image',
									'class' => 'img-responsive',
								)
							),
							*/
							$largeImage,
							array(
								'escape' => false,
								'data-full' => $fullImg,
								'data-caption' => h($propertyPicture['image_caption']),
								'data-thumb' => $thumbnail
							)
						);

						/*Releas used memory*/
						unset($thumbnail);
						unset($largeImage);
						unset($fullImg);
					}
				}
				?>
			</div>
		</div>
	</div>

	<!-- PROPERTY CONTENT -->
	<div class="row">
		<div class="col-md-8">
			<!-- Property typpology & social share -->
			<div class="row">
				<div class="col-md-12">
					<h4 class="header-description"><?php echo __('Typology'); ?></h4>
					<p class="content-description">
					<?php
						if (!empty($property['RoomType']['room_type_name'])) {
							echo getDescriptionHtml($property['RoomType']['room_type_name']);
						} else {
							echo __('Property typology is not set!');
						}
					?>
					</p>
				</div>
			</div>
			<hr class="line-seperatortor" />

			<!-- Property title -->
			<div class="row">
				<div class="col-md-12 property-description">
					<!-- <h4 class="header-description"><?php // echo __('Title'); ?></h4> -->
					<h1 class="content-description">
					<?php
						if (isset($property['PropertyTranslation']['title']) && !empty($property['PropertyTranslation']['title'])) {
							echo getDescriptionHtml($property['PropertyTranslation']['title']);
						} else {
							echo __('No title for this property.');
						}
					?>
					</h1>

					<p class="content-description">
					<?php
						if (isset($property['PropertyTranslation']['description']) && !empty($property['PropertyTranslation']['description'])) {
							echo getDescriptionHtml($property['PropertyTranslation']['description']);
						} else {
							echo __('No description for this property.');
						}
					?>
					</p>
				</div>
			</div>
			<hr class="line-seperator" />

			<!-- property features -->
			<div class="row">
				<div class="col-md-12">
					<h4 class="header-description"><?php echo __('Features'); ?></h4>
				</div>
				<?php if (isset($property['Property']['bed_number']) && !empty($property['Property']['bed_number'])): ?>
				<div class="col-md-2 col-sm-4 col-xs-6 features-info-container">
					<i class="fa fa-bed"></i>
					<span class="icon-information">
						<?php echo __('%s Bed(s)', $property['Property']['bed_number']); ?>
					</span>
				</div>
				<?php endif ?>

				<?php if (isset($property['Property']['bedroom_number']) && !empty($property['Property']['bedroom_number'])): ?>
				<div class="col-md-2 col-sm-4 col-xs-6 features-info-container">
					<i class="fa fa-home"></i>
					<span class="icon-information"><?php echo __('%s Cabin(s)', $property['Property']['bedroom_number']); ?></span>
				</div>
				<?php endif ?>

				<?php if (isset($property['Property']['bathroom_number']) && !empty($property['Property']['bathroom_number'])): ?>
				<div class="col-md-2 col-sm-4 col-xs-6 features-info-container">
					<i class="fa fa-cloud-download"></i>
					<span class="icon-information"><?php echo __('%s Bathroom(s)', $property['Property']['bathroom_number']); ?></span>
				</div>
				<?php endif ?>

				<?php if (isset($property['Property']['capacity']) && !empty($property['Property']['capacity'])): ?>
				<div class="col-md-2 col-sm-4 col-xs-6 features-info-container">
					<i class="fa fa-users"></i>
					<span class="icon-information"><?php echo __('Capacity: %s people', $property['Property']['capacity']); ?></span>
				</div>
				<?php endif ?>

				<?php if (isset($property['Property']['surface_area']) && !empty($property['Property']['surface_area'])): ?>
				<div class="col-md-2 col-sm-4 col-xs-6 features-info-container">
					<i class="fa fa-arrows-alt"></i>
					<span class="icon-information"><?php echo __('Area: %s m<sup>2</sup>', $property['Property']['surface_area']); ?></span>
				</div>
				<?php endif ?>

				<?php if (isset($property['Property']['construction_year']) && !empty($property['Property']['construction_year'])): ?>
				<div class="col-md-3 col-sm-4 col-xs-6 features-info-container">
					<i class="fa fa-history"></i>
					<span class="icon-information"><?php echo __('Built Year: %s', $property['Property']['construction_year']); ?></span>
				</div>
				<?php endif ?>
			</div>
			<hr class="line-seperator" />

			<!-- Amenities -->
			<div class="row">
				<div class="col-md-12">
					<h4 class="header-description" style="margin-bottom: 15px;"><?php echo __('Amenities'); ?></h4>
				</div>
				<br />
				<div class="col-xs-12">
					<div class="tab-container">
						<ul class="nav nav-tabs book-nav" data-tabs="tabs" role="tablist">
							<li role="presentation" class="active">
								<a href="#characteristic" role="tab" data-toggle="tab" aria-expanded="true">
									<?php echo __('Characteristics'); ?>
								</a>
							</li>
							<li role="presentation">
								<a href="#security" role="tab" data-toggle="tab" aria-expanded="false" >
									<?php echo __('Security'); ?>
								</a>
							</li>

							<?php if ($property['Property']['contract_type'] === 'rent'): ?>
							<li role="presentation">
								<a href="#calendar" role="tab" data-toggle="tab" aria-expanded="false" data-calendar="<?php echo $propertyId; ?>">
									<?php echo __('Calendar'); ?>
								</a>
							</li>
							<li role="presentation">
								<a href="#house_rules" role="tab" data-toggle="tab" aria-expanded="false">
									<?php echo __('House Rules'); ?>
								</a>
							</li>
							<?php endif ?>

							<?php if (!empty($property['Property']['video_url'])): ?>
								<li role="presentation">
									<a href="#video_container" role="tab" data-toggle="tab" aria-expanded="false">
										<?php echo __('Video'); ?>
									</a>
								</li>
							<?php endif ?>
						</ul>

						<div id="book-tab-content" class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="characteristic">
								<div class="amenities">
									<div class="row">
									<?php
										if (isset($propertyCharacteristics) && !empty($propertyCharacteristics)){
											foreach ($propertyCharacteristics as $characteristic):
											?>
											<div class="col-xs-12 col-sm-6 col-md-4 amItem">
												<!-- <span class="<?php echo $characteristic['Characteristic']['icon_class']; ?> fa-2x"></span> -->
												<span class="amenties-name">
													<?php echo getDescriptionHtml($characteristic['CharacteristicTranslation']['characteristic_name']);?>
												</span>
											</div>
											<?php
											endforeach;
										} else {
											echo $this->Html->tag('div', __('No characteristics to display for this property.'), array('class' => 'col-md-12'));
										}
									?>
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="security">
								<div class="amenities">
									<div class="row">
									<?php
									if (isset($propertySafeties) && !empty($propertySafeties)){
										foreach ($propertySafeties as $safety):
										?>
											<div class="col-xs-12 col-sm-6 col-md-4 amItem">
												<!-- <span class="<?php echo $safety['Safety']['icon_class']; ?> fa-2x"></span> -->
												<span class="amenties-name">
													<?php echo getDescriptionHtml($safety['SafetyTranslation']['safety_name']);?>
												</span>
											</div>
										<?php
										endforeach;
									} else {
										echo $this->Html->tag('div', __('No extra safety to display for this property'), array('class' => 'col-md-12'));
									}
									?>
									</div>
								</div>
							</div>
							
							<?php if ($property['Property']['contract_type'] === 'rent'): ?>
							<div role="tabpanel" class="tab-pane fade" id="calendar">
								<div id="frontend_calendar"></div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="house_rules">
								<div class="amenities">
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-4 amItem">
											<span class="fa fa-users fa-2x"></span>
											<span class="amenties-name"><?php echo __('Minimum Days'); ?>:&nbsp;<?php echo __n('%s Day', '%s Day(s)', $property['Property']['minimum_days'], $property['Property']['minimum_days']) ?></span>
										</div>

										<div class="col-xs-12 col-sm-6 col-md-4 amItem">
											<span class="fa fa-clock-o fa-2x"></span>
											<span class="amenties-name"><?php echo __('Checkin Time'); ?>:&nbsp;<?php echo h($property['Property']['checkin_time']); ?></span>
										</div>

										<div class="col-xs-12 col-sm-6 col-md-4 amItem">
											<span class="fa fa-clock-o fa-2x"></span>
											<span class="amenties-name"><?php echo __('Checkout Time'); ?>:&nbsp;<?php echo h($property['Property']['checkout_time']); ?></span>
										</div>
									</div>
								</div>
							</div>
							<?php endif ?>

							<?php if (!empty($property['Property']['video_url'])): ?>
							<div role="tabpanel" class="tab-pane fade" id="video_container">
								<div class="embed-responsive embed-responsive-16by9">
									<?php echo $this->Video->embed($property['Property']['video_url']); ?>
								</div>
							</div>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
			<hr class="line-seperator" />

			<!-- Location Description -->
			<?php if (isset($property['PropertyTranslation']['location_description']) &&
			!empty($property['PropertyTranslation']['location_description'])): ?>
			<div class="row">
				<div class="col-md-12">
					<h4 class="header-description"><?php echo __('Location description'); ?></h4>
					<p class="content-description">
					<?php echo getDescriptionHtml($property['PropertyTranslation']['location_description']); ?>
					</p>
				</div>
			</div>
			<hr class="line-seperator" />
			<?php endif ?>

			<!-- Property Map -->
			<div class="row">
				<div class="col-md-12">
					<h4 class="header-description"><?php echo __('View map'); ?></h4>
				</div>
				<div class="col-md-12">
					<div id="map"
						data-lat="<?php echo $property['Property']['latitude'] ?>"
						data-lng="<?php echo $property['Property']['longitude'] ?>">
					</div>
					<span class="help-block">
						<?php echo __('Exact location information is provided after a booking is confirmed.');?>
					</span>
				</div>
			</div>
			<hr class="line-seperator" />

			<!-- Property Reviews -->
			<div class="row">
				<div class="col-md-12 center-child">
					<?php
						echo $this->Html->tag('h4', __n('%d Review', '%d Reviews', $property['Property']['total_reviews'], $property['Property']['total_reviews']), array('class'=>'header-description'));

						 if (isset($property['Rating']) && !empty($property['Rating'])) {
							echo $this->Html->tag('span', $property['Rating']['overall'], array('class'=>'stars'));
						}
					?>
				</div>
				<div class="col-md-12">
				<?php if (isset($property['Review']) && !empty($property['Review'])) { ?>
					<hr>
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="row">
								<div class="col-xs-6"><?php echo __('Accurancy ');?></div>
								<div class="col-xs-6"><span class="stars"><?php echo $property['Rating']['accurancy'];?></span></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><?php echo __('Communication');?></div>
								<div class="col-xs-6"><span class="stars"><?php echo $property['Rating']['communication'];?></span></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><?php echo __('Cleanliness');?></div>
								<div class="col-xs-6"><span class="stars"><?php echo $property['Rating']['cleanliness'];?></span></div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="row">
								<div class="col-xs-6"><?php echo __('Location');?></div>
								<div class="col-xs-6"><span class="stars"><?php echo $property['Rating']['location'];?></span></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><?php echo __('Checkin');?></div>
								<div class="col-xs-6"><span class="stars"><?php echo $property['Rating']['checkin'];?></span></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><?php echo __('Value');?></div>
								<div class="col-xs-6"><span class="stars"><?php echo $property['Rating']['value'];?></span></div>
							</div>
						</div>
					</div>
					<?php $userURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS.'small'.DS; ?>
					<div class="comments">
						<?php foreach ($property['Review'] as $review){
							$user_review = '';
							$user_avatar = 'avatars/avatar.png';
							if ($review['Review']['is_dummy']) {
								$user_review = $review['Review']['dummy_user'];
								if (isset($review['Review']['publish_date']) && !empty($review['Review']['publish_date']) && trim($review['Review']['publish_date'])!='') {
									$time = $review['Review']['publish_date'];
								} else {
									$time = $review['Review']['modified'];
								}
							} else {
								if (file_exists($userURL.$review['UserBy']['image_path']) && is_file($userURL.$review['UserBy']['image_path'])) {
									$user_avatar = $review['UserBy']['image_path'];
								}
								$user_review = $review['UserBy']['name'].'&nbsp;'.$review['UserBy']['surname'];
								$time = $review['Review']['modified'];
							}

							$review_title = $review['Review']['title'];
							$review_description = $review['Review']['review'];
						?>
						<div class="comment">
							<div class="commentAvatar">
								<?php echo $this->Html->link(
										$this->Html->image('uploads/User/small/'.$user_avatar, array('alt' => 'avatar', 'border' => '0','fullBase' => true, 'class'=>'avatar')),
										array('controller'=>'users', 'action'=>'view', $review['UserBy']['id']),
										array('target' => '_blank', 'escape' => false)
									);
								?>
								<div class="commentArrow"><span class="fa fa-caret-left"></span></div>
							</div>
							<div class="commentContent">
								<div class="commentName"><?php echo $user_review; ?></div>
								<div class="commentTitle"><?php echo h($review_title); ?></div>
								<div class="commentBody">
									<?php echo h($review_description); ?>
								</div>
								<div class="commentActions">
									<div class="commentTime">
										<span class="fa fa-clock-o"></span>&nbsp;
										<?php echo $this->Time->timeAgoInWords($time); ?>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<?php } ?>

						<?php 
						if ($property['Property']['total_reviews'] > 15):
							echo $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp;'.__('View other reviews'),
								array('controller'=>'reviews', 'action'=>'listReview', $property['Property']['id']),
								array('target' => '_blank', 'escape' => false, 'class'=>'btn btn-lg outline view-review-btn')
							);
						endif
						?>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="seperator"></div>
			<!-- PROPERTY PRICE -->
			<div class="row remove-margin">
				<div class="col-sm-12 book-it__price-container">
					<div class="row">
						<div class="col-md-12 text-right">
							<h3 class="price-holder">
								<?php echo $property['Property']['price_converted'];?>
								<?php if ($property['Property']['allow_instant_booking'] == true): ?>
									<i class="fa fa-bolt icon-instant-book" aria-hidden="true"></i>
								<?php endif ?>
							</h3>
							<span class="price-daily"><?php echo $property['Property']['type_formated']; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<span class="price-string"><?php echo __('Best price guarantee'); ?></span>
						</div>
					</div>
				</div>
			</div>

			<!-- BOOKING CALENDAR AND RATING -->
			<?php if ($property['Property']['contract_type'] === 'rent'): ?>
			<div id="booking_calendar" class="row column-wrapper remove-margin">
				<div class="col-lg-12">
					<div class="row individual-ratings"></div>
					<!-- BOOKING PROPERTY FORM -->
					<?php echo $this->Form->create('Booking', array('type' => 'GET', 'url' => array('controller' => 'properties', 'action' => 'book', $property['Property']['id']), 'class'=>'form-horizontal book-it_form', 'id'=>'booking_form_view'));
						echo $this->Form->input('Booking.property_id',array('id'=>'property_id_input','type'=>'hidden','value' => $property['Property']['id']));
					?>
					<!-- check in -->
					<div class="form-group book-style">
						<div class="col-md-12">
							<div class="input-group search-property readonly">
								<?php echo $this->Form->input('Booking.checkin',array('label'=>false, 'div'=>false,'class'=>'form-control booking-input','type'=>'text', 'id'=>'checkin', 'placeholder'=>__('Checkin'), 'autocomplete'=>'off', 'readonly'=>'readonly' )); ?>
								<div class="input-group-addon checkin_trigger"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>

					<!-- check out -->
					<div class="form-group book-style">
						<div class="col-md-12">
							<div class="input-group search-property readonly">
								<?php echo $this->Form->input('Booking.checkout',array('label'=>false, 'div'=>false,'class'=>'form-control booking-input','type'=>'text', 'id'=>'checkout', 'placeholder'=>__('Checkout'), 'autocomplete'=>'off', 'readonly'=>'readonly' ));?>
								<div class="input-group-addon checkout_trigger"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>

					<!-- guests -->
					<div class="form-group book-style">
						<div class="col-md-12">
						<?php
							$capacity = [1 => __('%d Guest', 1)];
							if (!empty($property['Property']['capacity']) && (int)$property['Property']['capacity'] > 1) {
								for ($i=2; $i <= $property['Property']['capacity']; $i++) {
									$capacity[$i] = __('%d Guests', $i);
								}
							}
							echo $this->Form->input('Booking.guests',array('label'=>false, 'div'=>false,'class' => 'form-control booking-input search-property', 'type'=>'select', 'id'=>'guests', 'options' =>$capacity));
						?>
						</div>
					</div>

					<div class="form-group book-style DOPBCPCalendar-sidebar display-none" id="reservation_information">
						<div class="dopbcp-module">
							<h4><?php echo __(' Reservation Information ');?></h4>
							<div class="dopbcp-cart-wrapper">
								<table class="dopbcp-cart">
									<tbody>
										<tr>
											<td class="dopbcp-label"><?php echo __('Checkin');?></td>
											<td class="dopbcp-value reservation-value" id="check_in_date"></td>
										</tr>
										<tr>
											<td class="dopbcp-label"><?php echo __('Checkout');?></td>
											<td class="dopbcp-value reservation-value" id="check_out_date"></td>
										</tr>
										<tr>
											<td class="dopbcp-label"><?php echo __('Number of days');?></td>
											<td class="dopbcp-value reservation-value" id="number_of_days"></td>
										</tr>
										<tr>
											<td class="dopbcp-label"><?php echo __('Avarage Price');?></td>
											<td class="dopbcp-value reservation-value" id="subtotal_price_per_night"></td>
										</tr>

										<tr>
											<td class="dopbcp-label"><?php echo __('Subtotal');?></td>
											<td class="dopbcp-value">
												<span class="dopbcp-info-price reservation-value" id="subtotal_price"></span>
											</td>
										</tr>

										<tr>
											<td class="dopbcp-label"><?php echo __('Cleaning Fee');?>&nbsp;<i data-toggle="tooltip" title="<?php echo __('One-time fee charged by host to cover the cost of cleaning their space.'); ?>" class="fa fa-question-circle"></i>
											</td>
											<td class="dopbcp-value">
												<span class="dopbcp-info-price reservation-value" id="cleaning_fee"></span>
											</td>
										</tr>

										<tr>
											<td class="dopbcp-label">
												<?php echo __('Security Deposit');?>&nbsp;<i data-toggle="tooltip" title="<?php echo __('Security deposit is a set amount of money that is collected from a guest in order to cover damages to the property incurred during a stay.'); ?>" class="fa fa-question-circle"></i>
											</td>
											<td class="dopbcp-value">
												<span class="dopbcp-info-price reservation-value" id="security_fee"></span>
											</td>
										</tr>


										<tr id="extra_guests_placeholder" style="display: none;">
											<td class="dopbcp-label"><?php echo __('Extra Guests');?></td>
											<td class="dopbcp-value">
												<span class="dopbcp-info-price"></span>
											</td>
										</tr>



										<!--
										<tr>
											<td class="dopbcp-label"><?php // echo __('Avarage price');?></td>
											<td class="dopbcp-value dopbcp-price reservation-value" id="avarage_price"></td>
										</tr>
										-->

										<tr class="dopbcp-separator">
											<td class="dopbcp-label"><div class="dopbcp-line"></div></td>
											<td class="dopbcp-value"><div class="dopbcp-line"></div></td>
										</tr>

										<tr>
											<td class="dopbcp-label"><?php echo __('Service Fee');?>&nbsp;
												<i data-toggle="tooltip" title="<?php echo __('This helps us run our platform and offer services like 24/7 support on your trip.'); ?>" class="fa fa-question-circle"></i>
											</td>
											<td class="dopbcp-value dopbcp-price reservation-value" id="service_fee"></td>
										</tr>

										<tr class="dopbcp-separator">
											<td></td>
											<td></td>
										</tr>
										<tr class="dopbcp-total">
											<td class="dopbcp-label"><?php echo __('Total'); ?></td>
											<td class="dopbcp-value reservation-value" id="total_price"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="form-group book-style display-none" id="message_container">
						<div class="col-md-12">
							<div class="input-group search-property">
								<div id="message_information" class="message" style="padding: 8px;"></div>
								<div class="input-group-addon"><i class="fa fa-exclamation-circle"></i></div>
							</div>
						</div>
					</div>

					<div class="form-group book-style">
						<div class="col-md-12">
							<?php
								$booking_message = '<i class="fa fa-info" aria-hidden="true"></i>&nbsp;'.__('Request to Book');
								if ($property['Property']['allow_instant_booking']) {
									$booking_message = '<i class="fa fa-bolt" aria-hidden="true"></i>&nbsp;'.__('Instant Booking');
								}

								$disabled = ($property['Property']['user_id'] == $current_user_id) ? 'disabled' : '';
							?>
							<button type="submit" id="book_now_btn" class="btn btn-lg btn-block book-now-btn" <?php echo $disabled; ?> ><?php echo $booking_message; ?></button>

							<span class="help-block text-center">
								<?php echo __("You'll be able to review before paying.");?>
							</span>
						</div>
					</div>
					<?php
					echo $this->Form->input('Booking.days',array('id'=>'days_number_input','class'=>'clear-this','type'=>'hidden','value' =>''));
					
					echo $this->Form->input('Booking.price_per_night',array('id'=>'price_per_night_input','class'=>'clear-this','type'=>'hidden','value' =>''));
					
					echo $this->Form->input('Booking.subtotal_price',array('id'=>'subtotal_price_input','class'=>'clear-this','type'=>'hidden','value' =>''));
					
					echo $this->Form->input('Booking.cleaning_fee',array('id'=>'cleaning_fee_input','class'=>'clear-this','type'=>'hidden','value' => 0));
					
					echo $this->Form->input('Booking.security_fee',array('id'=>'security_fee_input','class'=>'clear-this','type'=>'hidden','value' => 0));
					
					echo $this->Form->input('Booking.service_fee',array('id'=>'service_fee_input','class'=>'clear-this','type'=>'hidden','value' =>''));
					
					echo $this->Form->input('Booking.extra_guest',array('id'=>'extra_guest_input','class'=>'clear-this','type'=>'hidden','value' =>''));
					
					echo $this->Form->input('Booking.extra_guest_price',array('id'=>'extra_guest_price_input','class'=>'clear-this','type'=>'hidden','value' =>''));
					
					echo $this->Form->input('Booking.total_price',array('id'=>'total_price_input','class'=>'clear-this','type'=>'hidden','value' =>''));
					
					echo $this->Form->input('Booking.currency',array('id'=>'currency_input','class'=>'clear-this','type'=>'hidden','value' =>''));
					
					echo $this->Form->end();
					?>
				</div>
			</div>
			<?php endif ?>
			
			<?php if ($property['Property']['user_id'] != $current_user_id): ?>
			<div class="row remove-margin">
				<div class="col-sm-12 book-it__wishlist-panel">
					<div class="row">
						<div class="col-md-12">
						<?php if(!$property['Property']['short_listed']) { ?>
							<button type="button" oncontextmenu="return false" class="btn btn-lg btn-block book-now-btn outline" id="my_shortlist" onclick="add_shortlist(<?php echo $propertyId; ?>,<?php echo $property['Property']['count_wishlist']; ?>,this);"><i class="fa fa-heart-o" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo __('Save to wishlist');?></button>
						<?php } else { ?>
							<button type="button" oncontextmenu="return false" class="btn btn-lg btn-block book-now-btn outline" id="my_shortlist" onclick="add_shortlist(<?php echo $propertyId; ?>,<?php echo $property['Property']['count_wishlist']; ?>, this);"><i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo __('Remove from Wishlist');?></button>
						<?php } ?>
						</div>
					</div>					
					<div class="row">
						<div class="col-sm-12">
							<ul class="wishlist-panel-group btn-group btn-group-justified">
						        <li class="wishlist-panel-btn">
						            <a href="mailto:<?php echo h($property['User']['email']); ?>?subject=Reservation%20Request&body=Tell%20me%20more.">
						                <i class="fa fa-envelope"></i>
						                <span><?php echo __('Email'); ?></span>
						            </a>
						        </li>
						        <li class="wishlist-panel-btn">
						            <!-- <a href="<?php //echo $this->Html->url(array('controller' => 'messages', 'action' => 'index', 'all'), true); ?>">
						                <i class="fa fa-comments"></i>
						                <span><?php // echo __('Messages'); ?></span>
						            </a> -->

						            <a href="javascript:void(0" data-toggle='modal' data-target='#myAuctionModalNorm'>
						                <i class="fa fa-comments"></i>
						                <span><?php echo __('Messages'); ?></span>
						            </a>
						        </li>
						        <li class="wishlist-panel-btn dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
										<span>...&nbsp;<?php echo __('More'); ?></span>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<?php
												//Create a share button
												echo $this->SocialShare->fa('facebook',__('Share on Facebook'),Router::Url(null, true),array('class'=>'btn btn-sm share-btn'));
											?>
										</li>
										<li>
											<?php
												//Create a share button
												echo $this->SocialShare->fa('google',__('Share on Google'),Router::Url(null, true),array('class'=>'btn btn-sm share-btn'));
											?>
										</li>
										<li>
											<?php
												//Create a share button
												echo $this->SocialShare->fa('twitter',__('Share on Twitter'),Router::Url(null, true),array('class'=>'btn btn-sm share-btn'));
											?>
										</li>
										<li>
											<?php
												//Create a share button
												echo $this->SocialShare->fa('pinterest',__('Share on Pinterest'),Router::Url(null, true),array('class'=>'btn btn-sm share-btn'));
											?>
										</li>
										<!--
										<li class="divider"></li>
										<li><a href="#">Separated link</a></li>
										-->
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>

<div id="wishlist_property_modal" class="modal fade wishlist-modal" tabindex="-1" role="dialog" aria-labelledby="wishlistPropertyModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<h4 class="modal-title sr-only" id="wishlistPropertyModalLabel"><?php echo __('Wishlist'); ?></h4>
			<div class="modal-body" id="modal_content"></div>
		</div>
	</div>
</div>

<!-- AUCTION Modal -->
<div class="modal fade make-offer-modal" id="myAuctionModalNorm" tabindex="-1" role="dialog" aria-labelledby="messagePropertyModalLabel" aria-hidden="true">
	<?php echo $this->Form->create('Message',array('url'=>array('controller' => 'messages', 'action' => 'newMessage', '?' => array('property_id' => $property['Property']['id'])) ,'class'=>'form-horizontal booking-form', 'id'=>'booking_form_view_modal')); ?>
	<div class="modal-dialog mask_this_element">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->tag('h4',__('Send a message!'),array('id' => 'messagePropertyModalLabel', 'class'=>'modal-title')) ?>
			</div>
			<div class="modal-body">
				<!-- HEader -->
				<div class="form-group">
					<div class="col-md-12">
						<?php echo $this->Form->input('subject',array('label'=>false, 'div'=>false,'class'=>'form-control clear-this','id'=>'message_subject', 'placeholder'=>__('Subject'), 'autocomplete'=>'off')); ?>
					</div>
				</div>
			
				<!-- message -->
				<div class="form-group">
					<div class="col-md-12">
						<?php echo $this->Form->input('message',array('id'=>'message_content','label'=>false, 'div'=>false,'class'=>'form-control clear-this','type'=>'textarea', 'placeholder'=>__('Message goes here') , 'rows'=>'4')); ?>
					</div>
				</div>
				<!-- hidden data -->
				<?php 
					echo $this->Form->input('property_id',array('type' => 'hidden', 'value' => $property['Property']['id']));
					echo $this->Form->input('user_by', array('type' => 'hidden', 'value' => AuthComponent::user('id')));
				?>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->submit(__('Send'), array('id'=>'send_offer','class'=>'btn btn-default','label'=>false,'div'=>false)); ?>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end();?>
</div>


<?php
	$daily_price = $weekly_price = $monthly_price = 0;
	$minimum_days = $capacity = 1;

	if (isset($property['Property']['price']) && !empty($property['Property']['price'])) {
		$daily_price = (float) $property['Property']['price'];
	}

	if (isset($property['Property']['weekly_price']) && !empty($property['Property']['weekly_price'])) {
		$weekly_price = (float) $property['Property']['weekly_price'];
	}

	if (isset($property['Property']['monthly_price']) && !empty($property['Property']['monthly_price'])) {
		$monthly_price = (float) $property['Property']['monthly_price'];
	}

	if (isset($property['Property']['minimum_days']) && !empty($property['Property']['minimum_days'])) {
		$minimum_days = (int) $property['Property']['minimum_days'];
	}

	if (isset($property['Property']['capacity']) && !empty($property['Property']['capacity'])) {
		$capacity = (int) $property['Property']['capacity'];
	}

	echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&amp;libraries=places&amp;key='.Configure::read('Google.key').'&callback=initializeMap', array('block'=>'scriptBottomMiddle', 'async', 'defer'));
	echo $this->Html->script("common/calendar/jquery.dop.FrontendBookingCalendarPRO", array('block' => 'scriptBottomMiddle'));
	echo $this->Html->script('frontend/fotorama/fotorama', array('block'=>'scriptBottomMiddle'));
	$this->Html->scriptBlock("
		var propertyID = ".$propertyId.",
			user_id    = ".(int)$current_user_id.",
			minDays    = ".$minimum_days.",
			capacity   = ".$capacity.",
			currency_symbol = '".$currency_symbol."',
			defaultDayPrice   = '".$daily_price."',
			defaultWeekPrice  = '".$weekly_price."',
			defaultMonthPrice = '".$monthly_price."',
			disabledDays  = [],
			availableDays = [],
			nights        = null;
			isValidSelection = true,
			alreadySubmitted = false;

		// DYNAMICLLY CREATE RATING STARS
		$.fn.stars = (function() {
			return $(this).each(function() {
				// Get the value
				var val = parseFloat($(this).html());
				// Make sure that the value is in 0 - 10 range, multiply to get width
				var size = Math.max(0, (Math.min(5, val))) * 20;

				// val = Math.round(val * 4) / 4; /* To round to nearest quarter */
				// val = Math.round(val * 2) / 2; /* To round to nearest half */

				// Create stars holder
				var \$span = $('<span />').width(size);
				// Replace the numerical value with stars
				$(this).html(\$span);
			});
		});

		// LOAD CALENDAR DATA
		function loadCalendarData(property_id){
			$.ajax({
				async: true,
				data:{data:{Property:{id:property_id}}},
				dataType:'json',
				beforeSend: function(request, obj) {
					$('#booking_calendar').mask('Waiting...');
				},
				success:function(data) {
					$.each(data, function(key, field){
						if(field.status === 'booked' || field.status === 'unavailable') {
							disabledDays.push(key);
						} else if (field.status === 'available' && $.trim(field.price) != '') {
							if (parseFloat(field.price) != parseFloat(defaultDayPrice)) {
								availableDays.push(key);
							}
						}
					});
				},
				error:function(e){
					toastr.error('We couldnt fetch the calendar data','Error!');
				},
				complete: function(d){
					$('#booking_calendar').unmask();
				},
				type: 'POST',
				url: fullBaseUrl+'/properties/load/'+property_id,
			});
		}

		// CHECK IF USER IS LOGGEDIN
		function isLoggedInUser(){
			$.ajax({
				success: function(data, textStatus, xhr) {
					if (textStatus == 'success') {
						var response = $.parseJSON(JSON.stringify(data));
						if (response.error == 0) {
							return true;
						} else {
							return false;
						}
					} else {
						return false;
					}
				},
				error:function(e){
					return false;
				},
				type: 'POST',
				url:fullBaseUrl+'/users/isLoggedIn',
			});
		}

		// CUSTOM DATE RANGE PICKER
		function customRange(input) {
			var newMin = new Date();
			newMin = new Date(newMin.setDate(newMin.getDate() + 1));
			return {
				minDate: newMin
			};
		}

		// DISABLE DATES THAT ARE BOOKED ALSO ADD THOSE WITH EXTRA PRICES
		function disableSpecificDays(date) {
			if (disabledDays.length === 0) {
				return [true, '', ''];
			}
			var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
			var daynum = date.getDay();
			var now = new Date();
			now.setDate(now.getDate()-1);

			for (var i=0,len=disabledDays.length;i<len;i++) {
				if (jQuery.inArray(string, disabledDays) != -1) {
					return [false, 'highlight', 'Unavailable'];
				} else {
					return [true, '', ''];
				}
			}

			if (availableDays.length) {
				for (var j=0,lenother=availableDays.length;j<lenother;j++) {
					if (jQuery.inArray(string, availableDays) != -1) {
						return [true, 'highlight', 'Extra price'];
					} else {
						return [true, '', ''];
					}
				}
			}
		}

		// CLEAR CHECKIN/CHECKOUT FIELDS
		function clearDates(element1, element2){
			element1 = element1 || '#checkin';
			element2 = element2 || '#checkout';
			$(element1).val('');
			$(element2).val('');
		}

		//CLEAR RESERVATION INFO FORM
		function clearReservationData(reservationContainer){
			$('.reservation-value', reservationContainer).each(function() {
				$(this).html('');
			});
			$(reservationContainer).fadeOut();
		}

		//FILL RESERVATION VIEW INFO FORM
		function fillReservationData(reservation){
			$('#check_in_date').html(reservation.checkin);
			$('#check_out_date').html(reservation.checkout);
			$('#number_of_days').html(reservation.days);

			$('#subtotal_price_per_night').html(reservation.subtotal_price_per_night_html);
			$('#subtotal_price').html(reservation.subtotal_price_html);

			$('#cleaning_fee').html(reservation.cleaning_fee_html);
			$('#security_fee').html(reservation.security_fee_html);
			$('#service_fee').html(reservation.service_fee_html);
		
			if (reservation.extra_guest) {
				$('#extra_guests_placeholder').fadeIn().find('.dopbcp-info-price').html(reservation.extra_guest_price_html);
			}

			// $('#avarage_price').html(reservation.avarage_price_per_night_html);

			$('#total_price').html(reservation.total_price_html);
			$('#reservation_information').fadeIn();
		}

		// FIRL RESERVATIO FORM DATA
		function fillReservationFormData(reservation){
			$('#days_number_input').val(reservation.days);
			$('#price_per_night_input').val(reservation.price_per_night);
			$('#subtotal_price_input').val(reservation.subtotal_price);
			$('#cleaning_fee_input').val(reservation.cleaning_fee);
			$('#security_fee_input').val(reservation.security_fee);
			$('#service_fee_input').val(reservation.service_fee);
			$('#extra_guest_input').val(reservation.extra_guest);

			if (reservation.extra_guest) {
				$('#extra_guest_price_input').val(reservation.extra_guest_price);
			}

			$('#total_price_input').val(reservation.total_price);
			$('#currency_input').val(reservation.locale_currency);
		}

		// CLEAR ALL FORM FILDS WITH THE CLASS .clear-this
		function clearForm(form) {
			// iterate over all of the inputs for the form
			// element that was passed in
			$('.clear-this', form).each(function() {
				var type = this.type;
				var tag = this.tagName.toLowerCase(); // normalize case
				// it's ok to reset the value attr of text inputs,
				// password inputs, number inputs and textareas
				if (type == 'text' || type == 'email' || type == 'password' || type=='hidden' || type=='number' || tag == 'textarea' )
					this.value = '';
				// checkboxes and radios need to have their checked state cleared
				// but should *NOT* have their 'value' changed
				else if (type == 'checkbox' || type == 'radio')
				this.checked = false;
				// select elements need to have their 'selectedIndex' property set to -1
				// (this works for both single and multiple select elements)
				else if (tag == 'select')
				this.selectedIndex = -1;
			});
		}

		//  SHOW MESSAGE
		function showMessage(messageText){
			messageText = messageText || '';
			$('#message_information').html(messageText);
			$('#message_container').slideDown(500).delay(5000).slideUp(500);
		}

		// CHECK IF CAPACITY IS GRATER THEN GUEST NUMBER
		function checkCapacity(guests){
			guests = guests || 1;
			if (guests > capacity) {
				isValidSelection = false;
				clearDates();
				clearReservationData('#reservation_information');
				showMessage('Number of guests selected is grater then capacity of the property.');
				return false;
			}
			return true;
		}

		// IF SELECTION IS VALID, CALCULATE PRICE
		function calculatePrice(){
			var checkin =  $('#checkin').val(),
				checkout = $('#checkout').val();
			if ($.trim(checkin) != '' && $.trim(checkout) != '' && isValidSelection) {
				
				// $.ajax({
				// 	async: true,
				// 	type: 'GET',
				// 	data: $('#booking_form_view').serialize(),
				// 	url: fullBaseUrl+'/properties/ajax_refresh_subtotal',
				// 	dataType:'json',
				// 	beforeSend: function(request, obj) {
				// 		$('#booking_calendar').mask('Waiting...');
				// 	},
				// 	success: function(data, textStatus, xhr) {
				// 		//called when successful
				// 		if (textStatus == 'success') {
				// 			response = $.parseJSON(JSON.stringify(data));
				// 			if (response.available) {
				// 				fillReservationData(response.data);
				// 			} else {
				// 				clearReservationData('#reservation_information');
				// 				showMessage(response.message);
				// 			}
				// 		} else {
				// 			toastr.warning(textStatus,'Warning!');
				// 		}
				// 	},
				// 	error: function(xhr, textStatus, errorThrown) {
				// 		//called when there is an error
				// 		var message = '';
				// 		if(xhr.responseJSON.hasOwnProperty('message')){
				// 			message = xhr.responseJSON.message;
				// 		}
				// 		toastr.error(errorThrown+' '+message, textStatus);
				// 	},
				// 	complete: function(d){
				// 		$('#booking_calendar').unmask();
				// 	}
				// });

				$.getJSON(fullBaseUrl+'/properties/ajax_refresh_subtotal', $('#booking_form_view').serialize()
				).done(function(response, textStatus) {
					//called when successful
					if (textStatus == 'success') {
						response = $.parseJSON(JSON.stringify(response));
						if (response.available) {
							fillReservationData(response.data);
							fillReservationFormData(response.data);
						} else {
							clearReservationData('#reservation_information');
							showMessage(response.message);
						}
					} else {
						toastr.warning(textStatus,'Warning!');
					}
				}).fail(function(jqxhr, textStatus, error) {
					toastr.error('Data could not be retrived from the server. Please try again!','Error!');
				});
				return false;
			} else {
				showMessage('You must select both checkin and checkout date to procceed!');
				return false;
			}
			return true;
		}

		// VALIDATE THE DATE RANGE SELECTED
		function validateDateRange() {
			isValidSelection = true;
			clearReservationData('#reservation_information');
			var cin, cout, difference, oneDay, dayDifference, startDate, endDate, tempDate,
				txtStartDate = $('#checkin'),
				txtEndDate = $('#checkout'),
				txtGuests = $('#guests');

			if ($.trim(txtStartDate.val()) == '') {
				return false;
			}

			if ($.trim(txtEndDate.val()) == '') {
				return false;
			}

			// if ($.trim(txtGuests.val()) == '') {
			// 	return false;
			// }

			startDate = new Date(txtStartDate.val());
			endDate   = new Date(txtEndDate.val());

			cin = startDate.getTime();
			cout = endDate.getTime();
			difference = Math.abs(cin-cout);
			oneDay = 1000 * 60 * 60 * 24;
			dayDifference = Math.floor(difference/oneDay);
			if (dayDifference === 0) {
				dayDifference = 1;
			}

			if (minDays > dayDifference) {
				isValidSelection = false;
				clearDates();
				showMessage('The minimum of days allowed is: ' + minDays);
				return false;
			}

			for (var i=0,len=disabledDays.length;i<len;i++) {
				var temp = disabledDays[i].split('-');
				tempDate = new Date(temp[0], temp[1]-1, temp[2]);
				if ((startDate < tempDate) && (tempDate < endDate)) { // endDate > tempDate
					isValidSelection = false;
					clearDates();
					showMessage('Selected date range is not valid. Please change your dates.');
					return false;
				}
			}

			var guests = txtGuests.val();
			checkCapacity(guests);
			/*
			* if everything works good so far
			* meaning all the validation is passed
			* then start calculating subtotal;
			*/
			if (isValidSelection) {
				calculatePrice();
			}
			return true;
		}

		(function($){
			$(document).ready(function() {
				'use strict';

				// Load calendar data
				loadCalendarData(propertyID);

				// clear wishlist modal on close
				$('#wishlist_property_modal').on('hidden.bs.modal', function (e) {
					$('#modal_content').html('');
				});

				// Inicialise Calendar on Tab content
				$('a[data-toggle=\"tab\"]').on('shown.bs.tab', function (e) {
					if (e.target.hasAttribute('data-calendar')) {
						var property_id = e.target.getAttribute('data-calendar');
						$('#frontend_calendar').DOPFrontendBookingCalendarPRO({
							'DataURL': fullBaseUrl+'/properties/load/'+property_id,
							'ID': property_id,
							'PropertyID': property_id,
							'Currency': currency_symbol,
						});
					}
				});

				$('.checkout_trigger').off('click');
				$('.checkout_trigger').on('click', function(){
					$('#checkout').datepicker('show');
				});

				$('.checkin_trigger').off('click');
				$('.checkin_trigger').on('click', function(){
					$('#checkin').datepicker('show');
				});

				$('#checkin').on('change input', validateDateRange).datepicker({
					minDate: 0,
					maxDate: '+1Y',
					dateFormat: 'yy-mm-dd',
					beforeShow: function(input, inst) {
						// setTimeout(function() {
						// 	inst.dpDiv.find('a.ui-state-highlight').removeClass('ui-state-highlight');
						// 	$('.ui-state-disabled').removeAttr('title');
						// 	$('.highlight').not('.ui-state-disabled').tooltip({container:'body'});
						// }, 100);
					},
					beforeShowDay: disableSpecificDays,
					onSelect: function(dateText, inst) {
						if ($.trim($('#checkout').val()) == '') {
							setTimeout(function() {
								var nextDate = $('#checkin').datepicker('getDate');
								var newMin = new Date(nextDate.setDate(nextDate.getDate() + minDays));
								$('#checkout').datepicker('setDate', newMin).trigger('change').datepicker('show');
							}, 150);
						} else {
							var cInDate  = $('#checkin').datepicker('getDate');
							var cOutDate = $('#checkout').datepicker('getDate');
							if (cInDate >= cOutDate) {
								setTimeout(function() {
									var nextDate = new Date(cInDate.setDate(cInDate.getDate() + minDays));
									$('#checkout').datepicker('setDate', nextDate).trigger('change').datepicker('show');
								}, 150);
							} else {
								$('#checkout').trigger('change');
							}
						}
					},
					onChangeMonthYear: function(){
					    setTimeout(function() {
					    	$('.highlight').not('.ui-state-disabled').tooltip({container:'body'});
					    },100);  
					}
				});

				$('#checkout').on('change input', validateDateRange).datepicker({
					dateFormat: 'yy-mm-dd',
					minDate: 1,
					maxDate: '+1Y',
					beforeShowDay: disableSpecificDays,
					beforeShow: customRange,
					onSelect: function(dateText, inst) {
						if ($.trim($('#checkin').val()) == '') {
							setTimeout(function() {
								var nextDate = $('#checkout').datepicker('getDate');
								var newMin = new Date(nextDate.setDate(nextDate.getDate() - 1));
								$('#checkin').datepicker('setDate', newMin).trigger('change').datepicker('show');
							}, 150);
						} else {
							var cInDate  = $('#checkin').datepicker('getDate');
							var cOutDate = $('#checkout').datepicker('getDate');
							if (cOutDate <= cInDate) {
								setTimeout(function() {
									var nextDate = new Date(cOutDate.setDate(cOutDate.getDate() - 1));
									$('#checkin').datepicker('setDate', nextDate).trigger('change').datepicker('show');
								}, 150);
							} else {
								$('#checkin').trigger('change');
							}
						}
					},
				});

				$('#guests').on('change', function(e){
					var guests =  $.trim($(this).val());
					if (guests != '') {
						if (guests > capacity) {
							clearDates();
							clearReservationData('#reservation_information');
							showMessage('Number of guests selected is grater then capacity of property');
							isValidSelection = false;
							return false;
						}
					}
					validateDateRange();
					return false;
				});

				$('#refundable_fee_checkbox').change(function(){
					calculatePrice();
				});

				// INICIALISE STAR RATING AUTOMATICLLY
				$('.stars').stars();

				//  SUBMITING THE FORM
				$('#book_now_btn').off('click');
				$('#book_now_btn').on('click', function(event){
					event.preventDefault();
					event.stopPropagation();
					var checkin  =  $('#checkin').val(),
						checkout = $('#checkout').val(),
						guests   = $('#guests').val();
					if (($.trim(checkin) != '') && ($.trim(checkout) != '') && ($.trim(guests) != '') &&
						isValidSelection) {
						if (alreadySubmitted === false) {
							showMessage('Form submiting.');
							alreadySubmitted = true;
							$('#booking_form_view').submit();
						} else {
							showMessage('Form has allredy been submited');
						}
					} else {
						showMessage('You must select both checkin and checkout date to procceed');
						isValidSelection = false;
					}
					return false;
				});

				//  SUBMITING OFFER FORM
				$('#send_offer').off('click');
				$('#send_offer').on('click',function(event){
					event.preventDefault();
					event.stopPropagation();

					var __that = $(this);

					if (user_id == 0) {
						toastr.info('You have to be logged in order to send a message.', 'Info!');
						return !1;
					}

					if ($.trim($('#message_subject').val()) === '' || $.trim($('#message_content').val()) === '') {
						toastr.error('You must fill all modal filds in order to submit your message.', 'Error!');
						return !1;
					} else {
						$.ajax({
							dataType:'json',
							data: $('#booking_form_view_modal').serialize(),
							beforeSend: function() {
								__that.closest('mask_this_element').mask('Waiting...');
							},
							success:function(response){
								var data = $.parseJSON(JSON.stringify(response));
								if (data.error==0) {
									toastr.success(data.message,'Success!');
									$('#myAuctionModalNorm').modal('hide'); 
									clearForm('#booking_form_view_modal');
								} else {
									toastr.error(data.message,'Error!');
								}
								__that.closest('mask_this_element').unmask();
							},
							error:function(e){
								__that.closest('mask_this_element').unmask();
								toastr.error('We could not fetch the data from the server. Please try again!', 'Error!');
							},
							complete: function(done){
								__that.closest('mask_this_element').unmask();
							},
							type: 'POST',
							url: $('#booking_form_view_modal').attr('action'), 
						});
					} 
					return false;
				});

				// clear modal form filds when modal auction is closed
				$('#myAuctionModalNorm').on('hidden.bs.modal', function (e) {
  					clearForm('#booking_form_view_modal');
				})
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>
<script>
	/**
	 * initializeMap
	 * initialize google map to show the circle of proprty
	 * once the script has fully loaded
	 *
	 * @return void
	 */
	function initializeMap() {
	    var mapElement = document.getElementById("map");
	    if (!mapElement) return !1;

	    var mapCoordinates = new google.maps.LatLng($("#map").attr("data-lat"), $("#map").attr("data-lng")),
	    	mapOptions = {
	            center: mapCoordinates,
	            zoom: 13,
	            disableDefaultUI: true,
	            zoomControl: !0,
	            scrollwheel: !1,
	            mapTypeControl: !1,
	            streetViewControl: !1,
	            zoomControlOptions: {
	                style: google.maps.ZoomControlStyle.SMALL
	            },
	            panControl: !1,
	            scaleControl: !1,
	            mapTypeId: google.maps.MapTypeId.ROADMAP
	        },
	    	map = new google.maps.Map(mapElement, mapOptions);
	    map.setCenter(mapCoordinates);

	    if (false){
	    	infowindow = new google.maps.InfoWindow({
	    		content: 'Description goes here it can nontain Html'
	    	}),
	    	marker = new google.maps.Marker({
	    		position: mapCoordinates,
	    		icon: new google.maps.MarkerImage(fullBaseUrl+'/img/map/marker.png'),
	    		map: map,
	    		title: '',
	    		animation: google.maps.Animation.DROP
	    	});
	    	marker.addListener('click', function() {
	    		infowindow.open(map, marker);
	    	});
	    } else {
	    	new google.maps.Circle({
		        strokeColor: "#008489",
		        strokeOpacity: '.5',
		        strokeWeight: 2,
		        fillColor: "#008489",
		        fillOpacity: '.35',
		        map: map,
		        center: mapCoordinates,
		        radius: 1e3
	    	});
	    }

	    google.maps.event.addListener(map, 'zoom_changed', function() {
	    	var center = map.getCenter();
	    	google.maps.event.trigger(map, 'resize');
	    	map.setCenter(center);
	    });
	}

	/**
	 * add_shortlist Change publish/unpublish status
	 * @param  $this obj       [description]
	 * @param  INT data_id     [description]
	 * @param  INT data_status [1/0]
	 * @return string          [description]
	 */
	function add_shortlist(property_id, count_wishlist, that){
		$.ajax({
			url: fullBaseUrl+'/users/isLoggedIn',
			type: 'POST',
			dataType: 'json',
			async: true,
			beforeSend: function() {
				// called before response
				$(that).mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='success') {
					var response = $.parseJSON(JSON.stringify(data));
					if (response.error) {
						toastr.info(response.message,'Info!');
						//window.location.replace(fullBaseUrl+'/users/login');
					} else {
						showWishlistPopUp(property_id, that);
					}
				} else {
					toastr.warning(textStatus,'Warning!');
				}
			},
			complete: function(xhr, textStatus) {
				//called when complete
				$(that).unmask();
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				var message = '';
				if(xhr.responseJSON.hasOwnProperty('message')){
					//do struff
					message = xhr.responseJSON.message;
				}
				$(that).unmask();
				toastr.error(errorThrown+":&nbsp;"+message, textStatus);
			}
		});
	}

	/**
	 * showWishlistPopUp
	 * @param  int property_id
	 * @param  obj that
	 * @return void
	 */
	function showWishlistPopUp(property_id, that){
		$.ajax({
			url: fullBaseUrl+'/wishlists/wishlist_popup/'+property_id+'/Property',
			type: 'GET',
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='error') {
					toastr.error(textStatus, 'Error!');
				} else {
					$('#wishlist_property_modal').modal('show');
					$('#modal_content').html(data);
				}
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				var message = '';
				if(xhr.responseJSON.hasOwnProperty('message')){
					//do struff
					message = xhr.responseJSON.message;
				}
				toastr.error(errorThrown+":&nbsp;"+message, textStatus);
			}
		});
	}
</script>

<?php
/*This css is applied only to this page*/
echo $this->Html->css('calendar/jquery.dop.FrontendBookingCalendarPRO', null, array('block'=>'cssMiddle'));
echo $this->Html->css('common/owl-carousel/owl.carousel.min', null, array('block'=>'cssMiddle'));

$ModelName = Inflector::classify($this->params['controller']);
$thumbnail = IMAGES . $ModelName .DS;
$directoryMdURL = IMAGES.'Property'.DS.$property['Property']['id'].DS.'PropertyPicture'.DS .'medium'.DS;
$directoryMdPATH = 'uploads/Property/'.$property['Property']['id'].'/PropertyPicture/medium/';
?>
<div class="row">
	<div class="col-md-12">
		<ul class="breadcrumbs-alt">
			<li> </li>
			<li>
				<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-home')). ' ' .__('Go to Properties homepage'),array('user'=>true, 'controller' => 'properties', 'action' => 'index'),array('escape' => false,'class'=>'active-trail active')); ?>
			</li>
		</ul>
	</div>
</div>
<div id="view-property-<?php echo $property['Property']['id']; ?>" class="fade in">
	<div class="modal-dialog modal-dialog-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-info"></i>&nbsp;<?php echo __('Property'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="panel-body">
					<div class="col-md-12">
						<ul class="nav nav-tabs has-calendar custom">
							<li class="active">
								<a href="#one_<?php echo $property['Property']['id']; ?>" data-toggle="tab">
									<?php echo __('General'); ?>
								</a>
							</li>
							<li class="calendar">
								<a href="#three_<?php echo $property['Property']['id']; ?>" data-calendar="<?php echo $property['Property']['id']; ?>" data-toggle="tab">
									<?php echo __('Calendar'); ?>
								</a>
							</li>
							<li>
								<a href="#four_<?php echo $property['Property']['id']; ?>" data-toggle="tab">
									<?php echo __('Photos'); ?>
								</a>
							</li>
							<li class="has-map">
								<a href="#five_<?php echo $property['Property']['id']; ?>" data-toggle="tab" onclick="generateMap('map_canvas', <?php echo $property['Property']['latitude']; ?>, <?php echo $property['Property']['longitude']; ?>)">
									<?php echo __('Location'); ?>
								</a>
							</li>
							<li>
								<a href="#six_<?php echo $property['Property']['id']; ?>" data-toggle="tab">
									<?php echo __('Details'); ?>
								</a>
							</li>
						</ul>
						<div class="tab-content custom">
							<div class="tab-pane active" id="one_<?php echo $property['Property']['id']; ?>">
								<div class="well">
									<div class="row">
										<div class="col-md-6 alert-message-info">
											<h5><b><i class="ico-type"></i>&nbsp; <?php echo __('Title: '); ?></b></h5>
											<p>
											<?php
												echo htmlspecialchars_decode(stripslashes($property['PropertyTranslation']['title']));
											?>
											</p>
										</div>
										<div class="col-md-6 alert-message-info">
											<div class="alert-message alert-message-info">
												<h5><b><i class="fa fa-comment"></i>&nbsp; <?php echo __('Description'); ?></b></h5>
												<div class="contact-message">
													<?php
														echo htmlspecialchars_decode(stripslashes($property['PropertyTranslation']['description']));
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="three_<?php echo $property['Property']['id']; ?>">
								<div class="well">
									<div class="row">
										<div class="col-lg-12 alert-message-info">
											<div id="calendar_holder"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="four_<?php echo $property['Property']['id']; ?>">
								<div class="well">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6">
											<h3 class="bolded">
												<?php
													if ($property['Property']['property_type']=='rent') {
														echo __('For Rent');
													} else if ($property['Property']['property_type']=='sale') {
														echo __('For Sale');
													} else {
														echo __('Both');
													}
												?>
												<span class="text-danger">&#36;
												<?php
													if ($property['Property']['property_type']=='rent') {
														echo h($property['Property']['rent_daily_price']);
													} else if ($property['Property']['property_type']=='sale') {
														echo h($property['Property']['sale_price']);
													} else {
														echo h($property['Property']['rent_daily_price']) . ' ' . __('Rent') . ' / ' . h($property['Property']['sale_price']) . ' ' . __('Sale');
													}
												?>
												</span>
											</h3>

											<div class="owl-carousel owl-theme property-image">
												<?php foreach ($property['PropertyPicture'] as $propertyPicture): ?>
													<div class='item full'>
														<?php
															if (file_exists($directoryMdURL.$propertyPicture['image_path']) && is_file($directoryMdURL .$propertyPicture['image_path'])) {
																	$base64 = $directoryMdPATH . $propertyPicture['image_path'];
																	echo $this->Html->image($base64, array('alt' => 'image','class'=>'img-responsive'));
															} else {
																echo $this->Html->image('no-img-available.png', array('alt' => 'User Avatar'));
															}
														?>
													</div>
												<?php
													unset($base64); /*Releas used memory*/
													endforeach;
												?>
											</div>
										</div>

										<div class="col-lg-6 col-md-6 col-sm-6">
											<h4><i class="ico-info"></i>&nbsp;<?php echo __('Property Information'); ?></h4>
											<br /><br />
											<table class="table table-th-block">
												<tbody>
													<tr>
														<td class="active"><i class="fa fa-user-plus"></i>&nbsp;<?php echo __('Capacity'); ?>:</td>
														<td><?php echo h($property['Property']['capacity']);?></td>
													</tr>
													<tr>
														<td class="active"><i class="fa fa-home"></i>&nbsp;<?php echo __('Room Number'); ?>:</td>
														<td><?php echo h($property['Property']['bedroom_number']);?></td>
													</tr>
													<tr>
														<td class="active"><i class="fa fa-bed"></i>&nbsp;<?php echo __('Beds'); ?>:</td>
														<td><?php echo h($property['Property']['bed_number']);?></td>
													</tr>
													<tr>
														<td class="active"><i class="fa fa-smile-o"></i>&nbsp;<?php echo __('Bathrooms'); ?>:</td>
														<td><?php echo h($property['Property']['bathroom_number']);?></td>
													</tr>
													<tr>
														<td class="active"><i class="fa fa-bar-chart"></i>&nbsp;<?php echo __('Min. Days'); ?>:</td>
														<td><?php echo h($property['Property']['minimum_days']);?></td>
													</tr>

													<?php if (isset($property['Property']['construction_year']) && !empty($property['Property']['construction_year'])) { ?>
													<tr>
														<td class="active"><i class="fa fa-calendar"></i>&nbsp;<?php echo __('Construction year'); ?>:</td>
														<td><?php echo h($property['Property']['construction_year']);?></td>
													</tr>
													<?php } ?>

													<?php if (isset($property['Property']['surface_area']) && !empty($property['Property']['surface_area'])) { ?>
													<tr>
														<td class="active"><i class="fa fa-arrows-alt"></i>&nbsp;<?php echo __('Area'); ?>:</td>
														<td><?php echo h($property['Property']['surface_area']);?></td>
													</tr>
													<?php } ?>

													<?php if (isset($property['Property']['energy_certification']) && !empty($property['Property']['energy_certification'])) { ?>
													<tr>
														<td class="active"><i class="fa fa-file-text-o"></i>&nbsp;<?php echo __('Certificate'); ?>:</td>
														<td><?php echo h($property['Property']['energy_certification']);?></td>
													</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane map" id="five_<?php echo $property['Property']['id']; ?>">
								<div class="well well-sm">
									<div class="row">
										<div class="col-lg-8 alert-message-info">
											<h4><i class="glyphicon glyphicon-globe"></i> &nbsp;<?php echo __('Map'); ?></h4>
											<div id="map_canvas" class="map_holder"></div>
										</div>

										<div class="col-lg-4">
											<h4><i class="ico-info">&nbsp;</i><?php echo __('Information'); ?></h4>
											<table class="table table-th-block">
												<tbody>
													<tr>
														<td class="active"><i class="fa fa-book"></i>&nbsp;<?php echo __('Address'); ?>:</td>
														<td><?php echo h($property['Property']['address']);?></td>
													</tr>
													<tr>
														<td class="active"><i class="fa fa-globe"></i>&nbsp;<?php echo __('Country'); ?>:</td>
														<td><?php echo h($property['Property']['country']);?></td>
													</tr>
													<tr>
														<td class="active"><i class="fa fa-globe"></i>&nbsp;<?php echo __('Locality'); ?>:</td>
														<td><?php echo h($property['Property']['locality']);?></td>
													</tr>
													<tr>
														<td class="active"><i class="fa fa-globe"></i>&nbsp;<?php echo __('District'); ?>:</td>
														<td><?php echo h($property['Property']['district']);?></td>
													</tr>
													<tr>
														<td class="active"><i class="fa fa-globe"></i>&nbsp;<?php echo __('State/Province'); ?>:</td>
														<td><?php echo h($property['Property']['state_province']);?></td>
													</tr>
													<tr>
														<td class="active"><i class="fa fa-map-marker"></i>&nbsp;<?php echo __('Latitude'); ?>:</td>
														<td><?php echo h($property['Property']['latitude']);?></td>
													</tr>
													<tr>
														<td class="active"><i class="fa fa-map-marker"></i>&nbsp;<?php echo __('Longitude'); ?>:</td>
														<td><?php echo h($property['Property']['longitude']);?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="six_<?php echo $property['Property']['id']; ?>">
								<div class="well well-sm">
									<div class="row">
										<div class="col-xs-12">
											<?php
											if (!empty($property['Review'])) { ?>
												<div class="col-md-10 col-md-offset-1">
													<h4><i class="ico-info">&nbsp;</i><?php echo __('Review Information'); ?></h4>
														<table class="table table-th-block">
															<tbody>
																<?php
																foreach ($property['Review'] as $propertyReview){
																	if ($propertyReview['is_dummy']) { ?>
																		<tr>
																			<td class="active" style="border-top: 0;"><i class="fa fa-user"></i>&nbsp;<?php echo __('User'); ?>:</td>
																			<td style="border-top: 0;"><?php echo h($propertyReview['dummy_user']); ?></td>
																		</tr>
																		<tr>
																			<td ><i class="fa fa-info"></i>&nbsp;<?php echo __('Review Title'); ?>:</td>
																			<td><?php echo h($propertyReview['title']); ?></td>
																		</tr>
																		<tr>
																			<td><i class="fa fa-file-text"></i>&nbsp;<?php echo __('Review Description'); ?>:</td>
																			<td><?php echo h($propertyReview['text']); ?></td>
																		</tr>
																		<tr>
																			<td style="border-top: 0;"></td>
																			<td style="border-top: 0;"></td>
																		</tr>
																	<?php
																	} else {

																	}
																} ?>
															</tbody>
														</table>
												</div>
											<?php
											} else {
												echo __('There are no Review for this Item');
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<?php
	unset($directoryMdURL);
	unset($directoryMdPATH);
?>
<?php
echo $this->Html->script('//maps.googleapis.com/maps/api/js?key='.Configure::read('Google.key'), array('block'=>'scriptBottomMiddle'));
echo $this->Html->script("common/owl-carousel/dist/owl.carousel.min", array('block' => 'scriptBottomMiddle'));
echo $this->Html->script("calendar/jquery.dop.FrontendBookingCalendarPRO", array('block' => 'scriptBottomMiddle'));
$this->Html->scriptBlock("
	$(document).ready(function() {
		/* Inicialise calendar on user
		*  @params userSubmit holds an object of type calendar.
		*  @ backend the div that holds the calendar visualisation
		*/
		$('ul.has-calendar').on('click', 'li.calendar a', function(e){
			var propertyID = $(this).attr('data-calendar');
			$('#calendar_holder').DOPFrontendBookingCalendarPRO({
				'Reinitialize': true,
				'DataURL': '".Router::Url(array('user' => true, 'controller' => $this->params['controller'],'action' => 'load'), true)."',
				'ID': propertyID,
				'PropertyID': propertyID,
			});
		});

		// BEGIN REAL ESTATE DESIGN JS FUNCTION
		$('div.property-image').owlCarousel({
			navigation : true, // Show next and prev buttons
			slideSpeed : 500,
			paginationSpeed : 400,
			paginationNumbers: true,
			singleItem:true,
			rewindSpeed : 810,
			autoPlay : true,
			// autoHeight : true,
			transitionStyle:'fade',
		});

		$('li.has-map').off('click');
		$('li.has-map').on('click', function(){
			if (typeof map !== 'undefined'){
				var center = map.getCenter();
				google.maps.event.trigger(map, 'resize');
				map.setCenter(center);
			}
		});
	});
", array('block' => 'scriptBottom'));
?>
<script>
	var map = null;
	var latitude;
	var longitude;
	function generateMap(map_id, lat, lng){
		if (lat) {
			latitude = lat;
		} else {
			latitude = 13.0630171;
		}

		if (lng) {
			longitude = lng;
		} else {
			longitude = 80.2296082;
		}

		var egglabs = new google.maps.LatLng(latitude, longitude);
		var image = new google.maps.MarkerImage('<?php echo Router::url('/img/map/marker.png', true); ?>');
		var mapCoordinates = new google.maps.LatLng(latitude, longitude);
		var mapOptions = {
			backgroundColor: '#ffffff',
			zoom: 10,
			disableDefaultUI: true,
			center: mapCoordinates,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: true,
			draggable: true,
			zoomControl: false,
			disableDoubleClickZoom: true,
			mapTypeControl: false,
			styles: [
				{
					'featureType': 'all',
					'elementType': 'labels',
					'stylers': [
						{
							'lightness': 63
						},
						{
							'hue': '#ff0000'
						}
					]
				},
				{
					'featureType': 'administrative',
					'elementType': 'all',
					'stylers': [
						{
							'hue': '#000bff'
						},
						{
							'visibility': 'on'
						}
					]
				},
				{
					'featureType': 'administrative',
					'elementType': 'geometry',
					'stylers': [
						{
							'visibility': 'on'
						}
					]
				},
				{
					'featureType': 'administrative',
					'elementType': 'labels',
					'stylers': [
						{
							'color': '#4a4a4a'
						},
						{
							'visibility': 'on'
						}
					]
				},
				{
					'featureType': 'administrative',
					'elementType': 'labels.text',
					'stylers': [
						{
							'weight': '0.01'
						},
						{
							'color': '#727272'
						},
						{
							'visibility': 'on'
						}
					]
				},
				{
					'featureType': 'administrative.country',
					'elementType': 'labels',
					'stylers': [
						{
							'color': '#ff0000'
						}
					]
				},
				{
					'featureType': 'administrative.country',
					'elementType': 'labels.text',
					'stylers': [
						{
							'color': '#ff0000'
						}
					]
				},
				{
					'featureType': 'administrative.province',
					'elementType': 'geometry.fill',
					'stylers': [
						{
							'visibility': 'on'
						}
					]
				},
				{
					'featureType': 'administrative.province',
					'elementType': 'labels.text',
					'stylers': [
						{
							'color': '#545454'
						}
					]
				},
				{
					'featureType': 'administrative.locality',
					'elementType': 'labels.text',
					'stylers': [
						{
							'visibility': 'on'
						},
						{
							'color': '#737373'
						}
					]
				},
				{
					'featureType': 'administrative.neighborhood',
					'elementType': 'labels.text',
					'stylers': [
						{
							'color': '#7c7c7c'
						},
						{
							'weight': '0.01'
						}
					]
				},
				{
					'featureType': 'administrative.land_parcel',
					'elementType': 'labels.text',
					'stylers': [
						{
							'color': '#404040'
						}
					]
				},
				{
					'featureType': 'landscape',
					'elementType': 'all',
					'stylers': [
						{
							'lightness': 16
						},
						{
							'hue': '#ff001a'
						},
						{
							'saturation': -61
						}
					]
				},
				{
					'featureType': 'poi',
					'elementType': 'labels.text',
					'stylers': [
						{
							'color': '#828282'
						},
						{
							'weight': '0.01'
						}
					]
				},
				{
					'featureType': 'poi.government',
					'elementType': 'labels.text',
					'stylers': [
						{
							'color': '#4c4c4c'
						}
					]
				},
				{
					'featureType': 'poi.park',
					'elementType': 'all',
					'stylers': [
						{
							'hue': '#00ff91'
						}
					]
				},
				{
					'featureType': 'poi.park',
					'elementType': 'labels.text',
					'stylers': [
						{
							'color': '#7b7b7b'
						}
					]
				},
				{
					'featureType': 'road',
					'elementType': 'all',
					'stylers': [
						{
							'visibility': 'on'
						}
					]
				},
				{
					'featureType': 'road',
					'elementType': 'labels',
					'stylers': [
						{
							'visibility': 'off'
						}
					]
				},
				{
					'featureType': 'road',
					'elementType': 'labels.text',
					'stylers': [
						{
							'color': '#999999'
						},
						{
							'visibility': 'on'
						},
						{
							'weight': '0.01'
						}
					]
				},
				{
					'featureType': 'road.highway',
					'elementType': 'all',
					'stylers': [
						{
							'hue': '#ff0011'
						},
						{
							'lightness': 53
						}
					]
				},
				{
					'featureType': 'road.highway',
					'elementType': 'labels.text',
					'stylers': [
						{
							'color': '#626262'
						}
					]
				},
				{
					'featureType': 'transit',
					'elementType': 'labels.text',
					'stylers': [
						{
							'color': '#676767'
						},
						{
							'weight': '0.01'
						}
					]
				},
				{
					'featureType': 'water',
					'elementType': 'all',
					'stylers': [
						{
							'hue': '#0055ff'
						}
					]
				}
			]

		};

		map = new google.maps.Map(document.getElementById(map_id),mapOptions);
		marker = new google.maps.Marker({position: egglabs, raiseOnDrag: false, icon: image, map: map, draggable: false,  title: ''});
		google.maps.event.addListener(map, 'zoom_changed', function() {
			var center = map.getCenter();
			google.maps.event.trigger(map, 'resize');
			map.setCenter(center);
		});
	}
</script>
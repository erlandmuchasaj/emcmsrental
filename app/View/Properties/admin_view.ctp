<?php ob_start();
if (!empty($property)):
	$property_id = (int)$property['Property']['id'];
	$directoryMdURL = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$property_id.DS.'PropertyPicture'. DS. 'large' . DS;
	$directoryMdPATH = "img/uploads/Property/{$property_id}/PropertyPicture/large/";
?>
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs" role="tablist">
			<li  role="presentation" class="active">
				<a href="#one_<?php echo $property_id; ?>" role="tab" data-toggle="tab" aria-expanded="true">
					<?php echo __('General'); ?>
				</a>
			</li>
			<li role="presentation">
				<a href="#two_<?php echo $property_id; ?>" role="tab" data-toggle="tab" aria-expanded="false">
					<?php echo __('Photos'); ?>
				</a>
			</li>
			<li role="presentation">
				<a href="#three_<?php echo $property_id; ?>" role="tab" data-toggle="tab" aria-expanded="false" data-calendar="<?php echo $property_id; ?>" >
					<?php echo __('Calendar'); ?>
				</a>
			</li>
			<li role="presentation">
				<a href="#four_<?php echo $property_id; ?>" role="tab" data-toggle="tab" aria-expanded="false">
					<?php echo __('Information'); ?>
				</a>
			</li>
			<li role="presentation">
				<a href="#price_<?php echo $property_id; ?>" role="tab" data-toggle="tab" aria-expanded="false">
					<?php echo __('Pricing'); ?>
				</a>
			</li>
			<li role="presentation">
				<a href="#five_<?php echo $property_id; ?>" role="tab" data-toggle="tab" aria-expanded="false" data-map="true" onclick="javascript:generateMap('map_canvas_<?php echo $property_id; ?>', <?php echo $property['Property']['latitude']; ?>, <?php echo $property['Property']['longitude']; ?>); return false;">
					<?php echo __('Location'); ?>
				</a>
			</li>
			<li role="presentation">
				<a href="#six_<?php echo $property_id; ?>" role="tab" data-toggle="tab" aria-expanded="false">
					<?php echo __('Reviews'); ?>
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="one_<?php echo $property_id; ?>">
				<p class="lead">
					<?php echo getDescriptionHtml($property['PropertyTranslation']['title']);	?>
				</p>
				<div class="contact-message">
					<?php echo getDescriptionHtml($property['PropertyTranslation']['description']); ?>
				</div>
			</div>

			<div role="tabpanel" class="tab-pane fade" id="two_<?php echo $property_id; ?>">
				<div class="owl-carousel owl-theme">
					<?php foreach ($property['PropertyPicture'] as $propertyPicture):
						$thumbnail = $this->webroot.'img/placeholder.png';
						if (file_exists($directoryMdURL.$propertyPicture['image_path']) && is_file($directoryMdURL.$propertyPicture['image_path'])) {
							$thumbnail = $this->webroot.$directoryMdPATH.$propertyPicture['image_path'];
						}
						echo $this->Html->tag('div', $this->Html->image('general/noimg/empty.png', array('alt' => 'property image', 'class' => 'img-responsive owl-lazy', 'data-src' => $thumbnail)), array('class' => 'item'));

						unset($thumbnail); /*Releas used memory*/
						endforeach;
					?>
				</div>
			</div>

			<div role="tabpanel" class="tab-pane fade" id="three_<?php echo $property_id; ?>">
				<div id="frontend_calendar">
					<?php echo $this->Html->image('spinner.gif', array('alt' => 'loading','fullBase' => true)); ?>
				</div>
			</div>

			<div role="tabpanel" class="tab-pane fade" id="four_<?php echo $property_id; ?>">
				<h4><i class="fa fa-info"></i>&nbsp;<?php echo __('Property Information'); ?></h4>
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

			<div role="tabpanel" class="tab-pane fade" id="price_<?php echo $property_id; ?>">
				<h4><i class="fa fa-info"></i>&nbsp;<?php echo __('Property pricing'); ?></h4>
				<br />
				<table class="table table-th-block">
					<tbody>
						<tr>
							<td class="active"><i class="fa fa-user-plus"></i>&nbsp;<?php echo __('Price per night'); ?>:</td>
							<td><?php echo h($property['Price']['night']);?></td>
						</tr>
						<tr>
							<td class="active"><i class="fa fa-home"></i>&nbsp;<?php echo __('Weekly pricing'); ?>:</td>
							<td><?php echo h($property['Price']['week']);?></td>
						</tr>
						<tr>
							<td class="active"><i class="fa fa-bed"></i>&nbsp;<?php echo __('Monthly pricing'); ?>:</td>
							<td><?php echo h($property['Price']['month']);?></td>
						</tr>
						<tr>
							<td class="active"><i class="fa fa-smile-o"></i>&nbsp;<?php echo __('Added guest pricing'); ?>:</td>
							<td><?php echo h($property['Price']['addguests']);?></td>
						</tr>
						<tr>
							<td class="active"><i class="fa fa-bar-chart"></i>&nbsp;<?php echo __('Cleaning fee'); ?>:</td>
							<td><?php echo h($property['Price']['cleaning']);?></td>
						</tr>

						<tr>
							<td class="active"><i class="fa fa-calendar"></i>&nbsp;<?php echo __('Security Deposit'); ?>:</td>
							<td><?php echo h($property['Price']['security_deposit']);?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div role="tabpanel" class="tab-pane fade" id="five_<?php echo $property_id; ?>">
				<div class="row">
					<div class="col-md-6">
						<h4><i class="glyphicon glyphicon-globe"></i>&nbsp;<?php echo __('Map'); ?></h4>
						<div id="map_canvas_<?php echo $property_id; ?>" class="map_holder"></div>
					</div>

					<div class="col-md-6">
						<h4><i class="fa fa-info"></i>&nbsp;<?php echo __('Information'); ?></h4>
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

			<div role="tabpanel" class="tab-pane fade" id="six_<?php echo $property_id; ?>">
				<div class="row">
					<?php if (!empty($property['Review'])) { ?>
						<div class="col-md-12">
							<div class="direct-chat-messages">
								<?php foreach ($property['Review'] as $propertyReview) { ?>
									<?php if ($propertyReview['user_to'] == $property['Property']['user_id']) { ?>
										<div class="direct-chat-msg">
											<div class="direct-chat-info clearfix">
												<span class="direct-chat-name pull-left">
												<?php echo h($propertyReview['UserBy']['name']).'&nbsp;'.h($propertyReview['UserBy']['surname']); ?>
												</span>
												<span class="direct-chat-timestamp pull-right">
													<?php echo $this->Time->nice($propertyReview['created']) ?>
												</span>
											</div>
											<!-- /.direct-chat-info -->
											<?php
												echo $this->Html->displayUserAvatar($propertyReview['UserBy']['image_path'], [
													'width' => 50,
													'height' => 50,
													'class' => 'media-round media-photo direct-chat-img',
													'alt' => h($propertyReview['UserBy']['name']),
													'title' => h($propertyReview['UserBy']['name'])
												]);
											?>
											<div class="direct-chat-text">
												<span class="small"><?php echo getDescriptionHtml($propertyReview['title']); ?></span>
												<p class="small"><?php echo getDescriptionHtml($propertyReview['review']); ?></p>
												<!-- here we can publish or unpublish a review -->
												<?php if (AuthComponent::user('role') === 'admin'): ?>
												<a data-toggle="tooltip" data-placement="top" title="<?php echo  __('Click to unpublish this review');?>" href="javascript:void(0);" onclick="changeReviewStatus(this,'<?php echo h($propertyReview['id']); ?>',0); return false;" id="status_allowed_<?php echo h($propertyReview['id']); ?>" <?php if ($propertyReview['status'] == 0){ ?> style="display: none;" <?php } ?>>
													<span class="label label-success">
														<?php echo __('Published');?>
													</span>
												</a>
												<a data-toggle="tooltip" data-placement="top" title="<?php echo  __('Click to publish this property');?>" href="javascript:void(0);" onclick="changeReviewStatus(this,'<?php echo h($propertyReview['id']); ?>',1); return false;" id="status_denied_<?php echo h($propertyReview['id']); ?>" <?php if ($propertyReview['status'] == 1){ ?> style="display: none;" <?php } ?>>
													<span class="label label-danger"><?php echo __('Unpublished');?></span>
												</a>
												<?php endif ?>
											</div>
										</div>
										<hr>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					<?php } else { ?>
						<div class="col-xs-12">
							<?php echo __('There are no Review for this Item'); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<script>
	var map = null;
	(function($){
		$(document).ready(function() {
			'use strict';

			$('.owl-carousel').owlCarousel({
				lazyLoad: true,
				items: 1,
				loop:true,
				margin:10,
				nav:true
			});

			/**
			 * Events
			 * When showing a new tab, the events fire in the following order:
			 * hide.bs.tab (on the current active tab)
			 * show.bs.tab (on the to-be-shown tab)
			 * hidden.bs.tab (on the previous active tab, the same one as for the hide.bs.tab event)
			 * shown.bs.tab (on the newly-active just-shown tab, the same one as for the show.bs.tab event)
			 */
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				// e.target // newly activated tab
				// e.relatedTarget // previous active tab
				if (e.target.hasAttribute('data-map')) {
					var center = map.getCenter();
					google.maps.event.trigger(map, 'resize');
					map.setCenter(center);
				}

				if (e.target.hasAttribute('data-calendar')) {
					var property_id = e.target.getAttribute('data-calendar');
					$('#frontend_calendar').DOPFrontendBookingCalendarPRO({
						'DataURL': fullBaseUrl+'/properties/loadCalendar/'+property_id,
						'ID': property_id,
						'PropertyID': property_id
					});
				}
			});
		});
	})(jQuery);
	/**
	 * generateMap
	 * @param  string map_id map location where we are going to display the map
	 * @param  float lat
	 * @param  float lng
	 * @return void
	 */
	function generateMap(map_id, lat, lng){
		var latitude, longitude, marker;

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

		var egglabs = new google.maps.LatLng(latitude, longitude),
		image = new google.maps.MarkerImage(fullBaseUrl+'/img/map/marker.png'),
		mapCoordinates = new google.maps.LatLng(latitude, longitude),
		mapOptions = {
			backgroundColor: '#ffffff',
			zoom: 10,
			disableDefaultUI: true,
			center: mapCoordinates,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: true,
			draggable: true,
			zoomControl: false,
			disableDoubleClickZoom: true,
			mapTypeControl: false
		};

		map = new google.maps.Map(document.getElementById(map_id),mapOptions);
		marker = new google.maps.Marker({position: egglabs, raiseOnDrag: false, icon: image, map: map, draggable: false,});
		google.maps.event.addListener(map, 'zoom_changed', function() {
			var center = map.getCenter();
			google.maps.event.trigger(map, 'resize');
			map.setCenter(center);
		});
	}

	function changeReviewStatus(obj,data_id,data_status){
		var modal = $(obj).closest('.nav-tabs-custom');
		if (data_status == undefined){
			data_status = 0;
		}
		$.ajax({
			url: fullBaseUrl+'/admin/reviews/changeStatus/'+data_id,
			type: 'POST',
			dataType: 'json',
			data:{data:{Review:{id:data_id,status:data_status}}},
			beforeSend: function() {
				// called before response
				$(modal).mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='success') {
					var response = $.parseJSON(JSON.stringify(data));
					if (!response.error) {
						if (data_status == 0){
							$('#status_allowed_'+data_id, modal).hide();
							$('#status_denied_'+data_id, modal).fadeIn('slow');
						}else{
							$('#status_allowed_'+data_id, modal).fadeIn('slow');
							$('#status_denied_'+data_id, modal).hide();
						}
						toastr.success(response.message,'Success!');
					} else {
						toastr.error(response.message,'Error!');
					}
				} else {
					toastr.warning(textStatus,'Warning!');
				}
			},
			complete: function(xhr, textStatus) {
				//called when complete
				$(modal).unmask();
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				var message = '';
				if(xhr.responseJSON.hasOwnProperty('message')){
					//do struff
					message = xhr.responseJSON.message;
				}
				$(modal).unmask();
				toastr.error(errorThrown+":&nbsp;"+message, textStatus);
			}
		});
	}
</script>
<?php ob_end_flush(); ?>
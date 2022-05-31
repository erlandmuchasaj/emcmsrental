<div id="search_result_wrapper" class="row">
	<div id="searchContent" class="col-xs-6 remove-padding">
		<div class="filter">
			<h1 class="osLight filter-your-results"><?php echo __('Filter your results'); ?></h1>
			<a href="javascript: void(0);" class="handleFilter"><span class="fa fa-server"></span></a>
			<div class="clearfix"></div>
			<?php echo $this->Form->create('Property', array('type' => 'get', 'url' => array('admin'=>false, 'controller'=>'properties', 'action'=>'search'), 'id'=>'property_search_form', 'class' => 'filterForm', 'onkeypress' => 'return event.keyCode != 13;')); ?>
				<div class="row">
					<div class="formItem col-xs-12 col-md-6 ">
						<div class="formField">
							<label><?php echo __('Room Type'); ?></label>
								<?php echo $this->Form->input('room_type_id', array('id'=>'room_type_id','class'=>'form-control', 'div'=>false,'label'=>false,'empty'=>__('All'))); ?>
						</div>
					</div>
					<div class="formItem col-xs-12 col-md-6 ">
						<div class="formField">
							<label><?php echo __('Accommodation Type'); ?></label>
							<?php echo $this->Form->input('accommodation_type_id', array('id'=>'accommodation_type_id','class'=>'form-control', 'div'=>false,'label'=>false,'empty'=>__('All'), 'escape'=>false)); ?>
						</div>
					</div>
					<div class="formItem col-xs-12 col-md-6 ">
						<div class="formField">
							<label><?php echo __('Property Type'); ?></label>
							<?php
								echo $this->Form->input('contract_type',array('id'=>'contract_type', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('property_type'), 'empty'=>__('All')));
							?>
						</div>
					</div>
					<div class="formItem col-xs-12 col-md-6">
						<div class="formField">
							<label><?php echo __('Location'); ?></label>
						   <div class="input-group search-property">
								<?php
								 echo $this->Form->input('location', array('id'=>'property_address','class'=>'form-control', 'placeholder'=>__('Location'), 'div'=>false,'label'=>false));
								?>
								<div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
							</div>
						</div>
					</div>
					<div class="formItem col-xs-12 col-md-6">
						<div class="formField">
							<label><?php echo __('Surface Area'); ?></label>
						   <div class="input-group search-property">
								<?php
								 echo $this->Form->input('surface_area', array('id'=>'property_surface_area_sale','class'=>'form-control allow-only-numbers', 'placeholder'=>__('Surface area'), 'div'=>false,'label'=>false, 'min'=>'0','type'=>'number'));
								?>
								<div class="input-group-addon">m<sup>2</sup></div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="formItem col-xs-6 col-md-3 ">
						<div class="formField">
							<label><?php echo __('Rooms'); ?></label>
							<?php echo $this->Form->input('bedroom_number',array('id'=>'bedroom_number', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('bedrooms'), 'empty'=>__('All'))); ?>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="formItem col-xs-6 col-md-3 ">
						<div class="formField">
							<label><?php echo __('Beds'); ?></label>
							<?php echo $this->Form->input('bed_number',array('id'=>'bed_number', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' =>  $this->Html->getData('beds'), 'empty'=>__('All'))); ?>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="formItem col-xs-6 col-md-3 ">
						<div class="formField">
							<label><?php echo __('Bathrooms'); ?></label>
							<?php echo $this->Form->input('bathroom_number',array('id'=>'bathroom_number', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('bathrooms'), 'empty'=>__('All'))); ?>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="formItem col-xs-6 col-md-3 ">
						<div class="formField">
							<label><?php echo __('Capacity'); ?></label>
							<?php echo $this->Form->input('capacity',array('id'=>'capacity', 'label'=>false, 'div'=>false,'class'=>'form-control','type'=>'select','options' => $this->Html->getData('capacity'), 'empty'=>__('All'))); ?>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<?php echo $this->Form->input('lat', ['type' => 'hidden', 'id' => 'search_field_lat']);?>
				<?php echo $this->Form->input('lng', ['type' => 'hidden', 'id' => 'search_field_lng']);?>
				<?php echo $this->Form->input('checkin',array('type'=>'hidden', 'id'=>'checkin')); ?>
				<?php echo $this->Form->input('checkout',array('type'=>'hidden', 'id'=>'checkout')); ?>

				<div class="row">
					<div class="col-xs-12">
						<a href="javascript:void(0);" class="btn btn-default handleFilter_advance">
							<?php echo __('More Filters'); ?>
						</a>
						<button type="submit" class="btn btn-success pull-right" id="search_button">
							<?php echo __('SEARCH');?>
						</button>
					</div>
				</div>

				<br/>

				<div class="filterForm_advance">
					<div class="row safeties">
						<div class="col-xs-12 col-sm-2">
							<label><?php echo __('Safeties'); ?></label>
						</div>
						<div class="col-xs-12 col-sm-10">
							<div class="row">
								<?php //debug();  ?>
								<?php if (!empty($safeties)) {  ?>
									<?php foreach ($safeties as $safety) { ?>
										<?php
											$retVal = '';
											if (isset($this->request->query['safeties'])) {
												if (is_array($this->request->query['safeties'])) {
													$retVal = (in_array($safety['Safety']['id'], $this->request->query['safeties'])) ? 'checked' : '';
												}
											}
										?>
										<div class="col-sm-6 col-md-4">
											<label>
												<input type="checkbox" <?php echo "{$retVal}"; ?> value="<?php echo $safety['Safety']['id']; ?>" name="safeties[]" class="property-search-filter" />
												&nbsp;<!-- <i class="<?php // echo $safety['Safety']['icon_class']; ?> icon-lg"></i>&nbsp; -->
												<span class="name"><?php echo $safety['SafetyTranslation']['safety_name']; ?></span>
											</label>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>

					<hr />

					<div class="row characteristics">
						<div class="col-xs-12 col-sm-2">
							<label><?php echo __('Characteristics');?></label>
						</div>
						<div class="col-xs-12 col-sm-10">
							<div class="row">
								<?php if (!empty($characteristics)) { ?>
									<?php foreach ($characteristics as $characteristic) { ?>
									<?php
										$retVal = '';
										if (isset($this->request->query['characteristics'])) {
											if (is_array($this->request->query['characteristics'])) {
												$retVal = (in_array($characteristic['Characteristic']['id'], $this->request->query['characteristics'])) ? 'checked' : '';
											}
										}
									?>
									<div class="col-sm-6 col-md-4">
											<label>
												<input type="checkbox" <?php echo "{$retVal}"; ?> value="<?php echo $characteristic['Characteristic']['id']; ?>" name="characteristics[]" class="property-search-filter" />
												&nbsp;<!-- <i class="<?php //echo $characteristic['Characteristic']['icon_class']; ?> icon-sm"></i> &nbsp; -->
												<span class="name"><?php echo $characteristic['CharacteristicTranslation']['characteristic_name']; ?></span>
											</label>
										<!-- <div class="amenties-name">
											&nbsp;<i class="<?php //echo $characteristic['Characteristic']['icon_class']; ?> icon-sm"></i> &nbsp;
											<span class="name"><?php //echo $characteristic['CharacteristicTranslation']['characteristic_name']; ?></span>
										</div> -->
									</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php // echo $this->Form->input('page',array('type'=>'hidden'));?>
			<?php echo $this->Form->end(); ?>
		</div>
		<div class="resultsList">
			<div class="row" id="filter-results">
			<?php if (!empty($searchResults)) { ?>
				<?php foreach ($searchResults as $key => $searchResult) { ?>
				<?php
					$propId = (int) $searchResult['Property']['id'];
					$propertyThumbnail 	= $this->webroot.'img/no-img-available.png';
					$directoryMdURL  = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Property'.DS.$propId.DS.'PropertyPicture'.DS.'medium'.DS;
					$directoryMdPATH = '/img/uploads/Property/'.$propId.'/PropertyPicture/medium/';
					if (file_exists($directoryMdURL.$searchResult['Property']['thumbnail']) &&
						is_file($directoryMdURL.$searchResult['Property']['thumbnail'])
					) {
						$propertyThumbnail = Router::Url($directoryMdPATH.$searchResult['Property']['thumbnail'], true);
					}

					$propertyLink = Router::Url(array('controller' => 'properties','action' => 'view', $propId), true);
					$label = ($searchResult['Property']['contract_type'] === 'rent') ? 'label-success' : 'label-primary';
				?>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<!-- 
						onmouseenter="on_mouse(this, <?php // echo $key; ?>, <?php // echo $propId; ?>); return true;" 
						onmouseleave="out_mouse(this, <?php // echo $key; ?>, <?php // echo $propId; ?>); return true;" 
					-->
				    <a href="<?php echo $propertyLink; ?>"
				    	data-prop-key="<?php echo $key; ?>"
				    	data-prop-id="<?php echo $propId; ?>"
				    	class="card js-map-card">
				        <figure class="figure">
				        	<!-- 'general/noimg/empty.png' -->
				            <?php echo $this->Html->image('general/noimg/empty.png', array('alt' => 'image', 'class' => 'lazy img-responsive', 'data-src' => $propertyThumbnail)) ?>
				            <figcaption class="figCaption">
				                <p class="price"><?php echo $searchResult['Property']['price_converted'];?></p>
				                <span class="fa fa-eye">&nbsp;<?php echo $searchResult['Property']['hits']; ?></span>
				                <!-- <span class="fa fa-heart">&nbsp;54</span> -->
				                <!-- <span class="fa fa-comment">&nbsp;13</span> -->
				            </figcaption>
				        </figure>
				        <div class="figView"><span class="fa fa-eye"></span></div>
				        <div class="figType <?php echo $label; ?>"><?php echo $searchResult['Property']['type_formated']; ?></div>
				        <h2><?php echo getDescriptionHtml($searchResult['PropertyTranslation']['title']); ?></h2>
				        <div class="cardAddress">
				        	<span class="icon-pointer"></span><?php echo h($searchResult['Property']['address']); ?>
				        </div>
				        <!--
				        <div class="cardRating">
				            <span class="fa fa-star"></span>
				            <span class="fa fa-star"></span>
				            <span class="fa fa-star"></span>
				            <span class="fa fa-star"></span>
				            <span class="fa fa-star-o"></span>
				            (146)
				        </div>
				    	-->
				        <ul class="cardFeat">
				        	<li>
				        		<i class="fa fa-home" aria-hidden="true"></i>&nbsp;
				        		<?php echo $searchResult['Property']['bedroom_number'];?>
				        	</li>
				            <li>
				            	<i class="fa fa-bed" aria-hidden="true"></i>&nbsp;
				            	<?php echo $searchResult['Property']['bed_number'];?>
				            </li>
				            <li>
				            	<i class="fa fa-bath" aria-hidden="true"></i>&nbsp;
				            	<?php echo $searchResult['Property']['bathroom_number'];?>
				            </li>
				            <li>
				            	<i class="fa fa-users" aria-hidden="true"></i>&nbsp;
				            	<?php echo $searchResult['Property']['capacity'];?>
				            </li>
				            <li>
				            	<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
				            	<?php echo $searchResult['Property']['surface_area'];?>m<sup>2</sup>
				            </li>

				            <?php if ($searchResult['Property']['allow_instant_booking']): ?>
				            <li>
				            	<i class="fa fa-bolt" aria-hidden="true"></i>&nbsp;
				            </li>
				            <?php endif ?>
				        </ul>
				        <div class="clearfix"></div>
				    </a>
				</div>
				<?php } ?>
			<?php } else { ?>
				<div class="col-sm-10 col-sm-offset-1">
					<h3>
						<?php echo __('We couldn’t find any results that matched your criteria, but tweaking your search may help. Here are some ideas:'); ?>
					</h3>
					<p>
					<?php echo __('Remove some filters.') ?><br>
					<?php echo __('Expand the area of your search.') ?><br>
					<?php echo __('Search for a city, address, or landmark.') ?><br>
					</p>
				</div>
			<?php } ?>
			</div>
			<!-- pagination START -->
			<div class="row">
				<div class="col-xs-12 text-center">
					<?php echo $this->element('Pagination/counter'); ?>
					<?php echo $this->element('Pagination/navigation'); ?>
				</div>
			</div>
			<!-- pagination END -->
		</div>
	</div>
	
	<div id="mapView" class="col-xs-6 remove-padding">
		<div class="mapPlaceholder"></div>
	</div>

	<!-- 
	<div class="col-xs-6 remove-padding search-results-map">
		<div id="mapView"></div>
	
		<div class="mapPlaceholder"></div>
	
		<a class="map-manual-refresh btn btn-primary hide">
			Redo search here&nbsp;<i class="fa fa-refresh icon-space-left"></i>
		</a>
		
		<div class="map-auto-refresh panel">
			<label class="checkbox" for="map-auto-refresh-checkbox">
				<input type="checkbox" class="map-auto-refresh-checkbox" id="map-auto-refresh-checkbox" value="on">
				<span class="move_map">Search as I move the map</span>
			</label>
		</div>
	</div>
	-->

	<div class="clearfix"></div>
	<a href="javascript: void(0);" class="handleMap mapHandler visible-xs"><i class="fa fa-map"></i></a>
</div>
<?php
$this->Html->script('//maps.googleapis.com/maps/api/js?libraries=places&amp;key='.Configure::read('Google.key'), array('block'=>'scriptBottomMiddle'));
// $this->Html->script('frontend/map/markerclusterer_compiled', array('block'=>'scriptBottomMiddle', 'async', 'defer'));
$this->Html->script('frontend/map/markerwithlabel', array('block'=>'scriptBottomMiddle'));
$this->Html->script('frontend/map/infobox.min', array('block'=>'scriptBottomMiddle'));
$this->Html->script('frontend/search', array('block'=>'scriptBottom'));

$this->Html->script('frontend/jquery.lazy/jquery.lazy.min.js', array('block'=>'scriptBottomMiddle'));
$this->Html->scriptBlock("
	(function($){
		$(document).ready(function() {
			'use strict';
			if ($.isFunction($.fn.lazy) && $('.lazy').length) {
				$('.lazy').lazy({
					effect: 'fadeIn',
					effectTime: 300,
					threshold: 0,
					visibleOnly: true,
					appendScroll: $('#searchContent'),
				});
			}
		});
	})(jQuery);
", array('block' => 'scriptBottom'));
?>
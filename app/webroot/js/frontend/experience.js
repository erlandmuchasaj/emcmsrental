var selectedState = null,
	map = null,
	urisegment = location.pathname.split('/');

var sgmnt = urisegment[urisegment.length - 1],
	secondLastSegment= urisegment[urisegment.length - 2];

(function($){
	$(document).ready(function() {
		'use strict';
		$('#js_toggle_event').on('switchChange.bootstrapSwitch', function (event, state) {
			var element = $('.js-subcategory');
			if (state == true) {
				element.fadeIn().find('#subcategory_id').prop('disabled', false);
			} else {
				element.fadeOut().find('#subcategory_id').prop('disabled', true);
			}
		}); 

		$('#js_toggle_notes').on('switchChange.bootstrapSwitch', function (event, state) {
			var element = $('.js-notes');
			if (state == true) {
				element.show().find('#extra_notes').prop('disabled', false);
			} else {
				element.hide().find('#extra_notes').prop('disabled', true);
			}
		});

		$('.toggle-switch').on('switchChange.bootstrapSwitch', function (event, state) {
			var container = $(this).attr('data-container-class');
			if (typeof container !== typeof undefined && container !== false) {
				var element = $(container);
				if (state == true) {
					element.fadeIn().find('.switch-input').prop('disabled', false);
				} else {
					element.fadeOut().find('.switch-input').prop('disabled', true);
				}
			}
		});

		$('#experience_city_id').on('change', function () {
			var city = $(this).find('option[value=' + $(this).val() + ']').text();
			$('#address_city').val(city);
			return true;
		});

		setTimeout(function() {
			$('#address_city').val($('#experience_city_id option:selected').text());
		}, 30);

		$(document).on('click', '.lang_option_show', function() {
			var inc = $("#inc").val();
			if (inc == 1) {
				inc++;
				var $select = $("#language_id").clone().removeAttr("id").removeAttr("required").attr('name', 'data[Experience][other_lang][]').prop('multiple', true);
				
				var languageSellect = Array();
				languageSellect.push('<div class="row" id="remove_id_id'+inc+'">');
				languageSellect.push('	<div class="col-sm-12">');
				languageSellect.push(		$select[0].outerHTML);
				languageSellect.push('		<span class="help-block">Submission additional language (optional)&nbsp;');
				languageSellect.push('			<button type="button" class="lang_option_hide btn btn-danger" aria-disabled="false" aria-busy="false" data-id="'+inc+'">Remove</button>');
				languageSellect.push('		</span>');
				languageSellect.push('	</div>');
				languageSellect.push('</div>');

				$("#multi_lang_add").append(languageSellect.join(''));
				$("#inc").val(inc);
				$("#lang_other").hide();
			}
		});

		$(document).on('click', '.lang_option_hide', function(){
			var inc = $("#inc").val();
			var id = $(this).attr('data-id');
			if (inc == 2) {
				inc--;
				$("#remove_id_id"+id).remove();
				$("#inc").val(inc);
				$("#lang_other").show();
			}
		});

		$(document).on('click', '.add_items_pack', function(){
			var packNr = $('#pack_list_nr').val();
				packNr++;

			var itempPackHTML = Array();

			itempPackHTML.push('<div class="form-group" id="con_'+packNr+'">');
			itempPackHTML.push('	<div class="col-sm-8 col-sm-offset-2 input-group" style="padding-left: 15px; padding-right: 15px;">');
			itempPackHTML.push('		<input name="data[Experience][packing_list][]" placeholder="Enter Item Here" class="form-control switch-input" type="text">');
			itempPackHTML.push('		<div class="input-group-btn">');
			itempPackHTML.push('			<button type="button"  class="btn btn-danger del_pack_list" data-val="'+packNr+'" type="submit" aria-disabled="false" aria-busy="false">');
			itempPackHTML.push('				<i class="glyphicon glyphicon-remove"></i>');
			itempPackHTML.push('			</button>');
			itempPackHTML.push('		</div>');
			itempPackHTML.push('	</div>');
			itempPackHTML.push('</div>');

			$('.js-packing-list').append(itempPackHTML.join(''));
			$('#pack_list_nr').val(packNr);
		})

		$(document).on('click', '.del_pack_list',function() {
			var packNr = $('#pack_list_nr').val();
			packNr--;

			var value = $(this).data('val');
			$('#con_'+value).remove();

			$('#pack_list_nr').val(packNr);
		});


		// $('a[data-toggle=\"tab\"]').on('hide.bs.tab', function (e) {
		// 	console.log(e);
		// 	console.log(e.target);  // newly activated tab
		// 	console.log(e.relatedTarget); // previous active tab
		// 	console.log($(e.target));
		// });

		// $('a[data-toggle=\"tab\"]').on('show.bs.tab', function (e) {
		// 	console.log(e);
		// 	console.log(e.target);  // newly activated tab
		// 	console.log(e.relatedTarget); // previous active tab
		// 	console.log($(e.target));
		// });

		// $('a[data-toggle=\"tab\"]').on('hidden.bs.tab', function (e) {
		// 	console.log(e);
		// 	console.log(e.target);  // newly activated tab
		// 	console.log(e.relatedTarget); // previous active tab
		// 	console.log($(e.target));
		// });

		// $('a[data-toggle=\"tab\"]').on('shown.bs.tab', function (e) {
		// 	console.log(e);
		// 	console.log(e.target);  // newly activated tab
		// 	console.log(e.relatedTarget); // previous active tab
		// 	console.log($(e.target));
		// });


		if ($('#id_country') && $('#id_state')) {
			if(selectedState) {
				ajaxStates(selectedState);
			}
			
			$('#id_country').on('change', function() {
				ajaxStates();
			});
		};

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
				administrative_area_level_1: '#state_province',
				postal_code: '#postal_code'
			}
		});

		var gmarker = addresspickerMap.addresspicker('marker');
		gmarker.setVisible(true);
		addresspickerMap.addresspicker('updatePosition');

		var image = new google.maps.MarkerImage(fullBaseUrl+'/img/map/marker1.png');
		gmarker.setIcon(image);

		function showCallback(geocodeResult, parsedGeocodeResult) {		
			var idCountry = $('#id_country option').filter(function() { return $(this).html() == parsedGeocodeResult.country; }).val();
			if (idCountry === undefined) {
				$('#id_country').val(0);
			} else {
				$('#id_country').val(idCountry).trigger('change');
			}
			// $('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
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
// calculations for elements that changes size on window resize
var google,
	main_lat_lng = new google.maps.LatLng(41.9026974, 12.4961853),
	main_zoom_level=parseInt(getUrlParameter('zoom')),
	map = new google.maps.Map(document.getElementById('mapView'), {
		zoom: 1,
		minZoom: 1,
		center: main_lat_lng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		disableDefaultUI: false,
		scrollwheel: false,
		mapTypeControl: false,
		streetViewControl: false,
		zoomControl: true,
		disableDoubleClickZoom: true,
	    zoomControlOptions: {
	        position: google.maps.ControlPosition.LEFT_TOP,
	        style:google.maps.ZoomControlStyle.SMALL
	    },
	    navigationControlOptions: {
            position: google.maps.ControlPosition.LEFT
        },
	}),
	infowindow = new google.maps.InfoWindow(),
	markers = [],
	useMarkerLabel = true,
	currentZoom = 1,
	infobox = new InfoBox({
		maxWidth: 0,
		zIndex: null,
		pixelOffset: new google.maps.Size(-101, 0),
		boxClass: 'infoTrending',
		boxStyle: {
			border: '0px solid transparent',
			textAlign: 'left',
			background: 'url('+fullBaseUrl+'/img/map/infobox-bg.png) no-repeat',
			opacity: 1,
			width: '202px',
			height: '246px',
			overflow: 'hidden' // remove this one to display the x
		},
		alignBottom: !0,
		visible: true,
		infoBoxClearance: new google.maps.Size(10, 10),
		pane: 'floatPane',
		closeBoxMargin: '0px -16px -16px -16px',
		closeBoxURL: '',
		disableAutoPan: !1,
		enableEventPropagation: !0
	}),
	bounds = new google.maps.LatLngBounds(),
	markerImage = new google.maps.MarkerImage(fullBaseUrl+'/img/map/marker-green.png'),
	markerCluster,
	windowHeight,
	contentHeight,
	autocomplete,
	call_listing_timer = false,
	active_request = false,
	params = window.location.search,
	//set style options for marker clusters (these are the default styles)
	mcOptions = {
		zoomOnClick: true,
		gridSize: 30,
		styles:[
		{
			url: fullBaseUrl+'/img/map/m1.png',
			height: 52,
			width: 53,
		},
		{
			url: fullBaseUrl+'/img/map/m2.png',
			height: 55,
			width: 56,
		},
		{
			url: fullBaseUrl+'/img/map/m3.png',
			height: 65,
			width: 66,
		},
		{
			url: fullBaseUrl+'/img/map/m4.png',
			height: 77,
			width: 78,
		},
		{
			url: fullBaseUrl+'/img/map/m5.png',
			height: 89,
			width: 90,
		}
	]};

(function($){
	$(document).ready(function() {
		'use strict';

		var search_lat  = getUrlParameter('lat');
		var search_lng  = getUrlParameter('lng');
		var search_zoom = getUrlParameter('zoom');
		var search_city = getUrlParameter('location');

		if(search_lat!=undefined && search_lng!=undefined) {
			main_lat_lng=new google.maps.LatLng(search_lat,search_lng);
		}

		if(search_zoom!=undefined) {
			main_zoom_level=search_zoom;
		}

		bounds.extend(main_lat_lng);

		// var str = window.location.search;
		// var gio_status=false;
		// if (search_city!=undefined) {
		//     var geocoder =  new google.maps.Geocoder();
		//     geocoder.geocode({'address': search_city}, function(results, status) {
		//         if (status == google.maps.GeocoderStatus.OK) {
		//             var bounds = map.getBounds();
		//             if (results[0].geometry.viewport) {
		//                 map.fitBounds(results[0].geometry.viewport);
		//                 bounds = results[0].geometry.viewport;
		//             } else {
		//                 map.setCenter(results[0].geometry.location);
		//                 map.setZoom(17);  // Why 17? Because it looks good.
		//                 bounds = map.getBounds();
		//             }
		//             var center = map.getCenter();
		//             var ne = bounds.getNorthEast(); // LatLng of the north-east corner
		//             var sw = bounds.getSouthWest();
		//             str = replaceQueryParam('lat',center.lat(), str);
		//             str = replaceQueryParam('lng',center.lng(), str);
		//             str = replaceQueryParam('sw_lat',sw.lat(), str);
		//             str = replaceQueryParam('sw_lng',sw.lng(), str);
		//             str = replaceQueryParam('ne_lat',ne.lat(), str);
		//             str = replaceQueryParam('ne_lng',ne.lng(), str);
		//             gio_status=true;
		//         }
		//     });
		// }
		// var myVar = setInterval(function() { 
		//     if (gio_status==true) {
		//         if (history.pushState) {
		//             window.history.pushState({path:window.location.pathname + str},'',window.location.pathname + str);
		//         }
		//         get_search_result(true);
		//         clearInterval(myVar);
		//     }
		// }, 1000);

		// loadSearch(params);
		var windowResizeHandler = function() {
			windowHeight = $(window).height();
			contentHeight = windowHeight - $('#main_menu').outerHeight(true);
			//$('#search_result_wrapper').css('margin-top', $('#main_menu').outerHeight(true)+'px');
			$('#mapView').height(contentHeight);
			$('#searchContent').height(contentHeight);
		};

		windowResizeHandler();
		$(window).resize(function() {
			windowResizeHandler();
		});

		// GOOGLE ADDRESS PICKER
		if ($('#property_address').length) {
			autocomplete = new google.maps.places.Autocomplete(document.getElementById('property_address'), {
				types : [ 'geocode' ]
				// componentRestrictions: {country: "us"} // or you can use array ["us"]
			});
			autocomplete.addListener("place_changed", fillInAddress);
		}

		// add other markers on map
		// map events to auto search on map zoom change or dragend change
		google.maps.event.addListenerOnce(map, 'idle', function() {
			// load the first listings on map
			callListings(params, map, markerImage, infowindow, bounds);
 
			google.maps.event.addListener(map, 'click', function() {
			    // perform event when map clicked
			    // infowindow.close();

			    if (infobox.getVisible()) {
			        infobox.close();
			    }
			});

			google.maps.event.addListener(map, 'dblclick', function (e) {
				//lat and lng is available in e object
				var center = e.latLng;
				map.setCenter(center);
				getMapResult();
				return false;
			});

		    google.maps.event.addListener(map, 'dragend', function() {
		        // reload listing when map dragged lat and lng is available in e object

		        // if (infobox.getVisible()) {
		        //     infobox.close();
		        // }
	
		        setMapBounds();
		        if ($('#map-auto-refresh-checkbox').is(":checked")) {
		        	getMapResult();
		        } else {
		        	$('.map-auto-refresh').hide();
		        	$('.map-manual-refresh').removeClass('hide');
		        }
		        return true
		    });

		    google.maps.event.addListener(map, 'zoom_changed', function() {
				setMapBounds();
				if ($('#map-auto-refresh-checkbox').is(":checked")) {
					getMapResult();
				} else {
					$('.map-auto-refresh').hide();
					$('.map-manual-refresh').removeClass('hide');
				}

		    	// reload listing when zoom change in or out
		        // zoon in on search on map page
		        if ( map.getZoom() > currentZoom) {
		        }
		        // zoom out
		        else if (map.getZoom() < currentZoom) {
		        }

		        currentZoom = map.getZoom();
		        return true;
		    });
		});

		$('input[type="text"]').on('keydown', function(e) {
		    if (e.which === 32 && e.target.selectionStart === 0) {
		        return false;
		    }
		});

		// infobox events delegate
		// prevent dragable when over modal
		$(document).on('mouseenter touchstart', 'div.infoW', function() {
		    map.setOptions({
		        draggable: false,
		        scrollwheel: false
		    });
		});

		$(document).on('mouseleave touchend', 'div.infoW', function() {
		    map.setOptions({
		        draggable: true,
		        scrollwheel: true
		    });
		});

		if (useMarkerLabel === true) {
			$(document).on('mouseenter touchstart', '.js-map-card', function(e) {
				on_mouse(this, $(this).data('prop-key'), $(this).data('prop-id'));
			}).on('mouseleave touchend', '.js-map-card',  function(e) {
				out_mouse(this, $(this).data('prop-key'), $(this).data('prop-id'));
			});
		}

		$('#search_button').off('click');
		$('#search_button').on('click', function(e) {
			// var inputA = $('#property_search_form').serialize();
			// loadSearch(inputA);
			$('#property_search_form').submit();
			e.preventDefault();
		});

		// functionality for map manipulation icon on mobile devices
		$('.mapHandler').on('click', function(e) {
			$('#mapView').toggleClass('max');
			$('#searchContent').toggleClass('min');
			setTimeout(function() {
				if (typeof map !== typeof undefined && map !== false) {
				    var center = map.getCenter();
					google.maps.event.trigger(map, 'resize');
					if (map.getZoom() > 13) {
						map.setZoom(13);
					}

					if (map.getZoom() <= 0) {
						map.setZoom(2);
					}
					map.setCenter(center);
				}
			}, 300);
		});

		$('.handleFilter').on('click', function(e) {
			$('#property_search_form').slideToggle(300);
			e.preventDefault();
		});

		$('.handleFilter_advance').on('click', function(e) {
			$('.filterForm_advance').slideToggle(200);
			e.preventDefault();
		});

		$('.map-manual-refresh').on('click', function(e) {
			setMapBounds();
			$('.map-auto-refresh').show();
			$('.map-manual-refresh').addClass('hide');
			getMapResult();
		});

		//CLOSE INFO BOX
		$('#mapView').off('click', '.closeInfo');
		$('#mapView').on('click', '.closeInfo', function(e) {
			e.preventDefault();
			e.stopPropagation();

			infobox.close();
			infobox.setZIndex(0);
			
			// reactivate map dragable and scrollwheel event
			map.setOptions({
			    draggable: true,
			    scrollwheel: true
			});
			return false;
		});
	});
})(jQuery);

function callListings(searchParams, map, markerImage, infowindow, bounds) {
	clearTimeout(call_listing_timer);
	call_listing_timer = setTimeout(loadSearchForMap(searchParams, map, markerImage, infowindow, bounds), 1000);
}

function loadSearchForMap(searchParams, map, markerImage, infowindow, bounds) {
	var elementToMaskList = $('#mapView');
	if (active_request) {
	    active_request.abort();
	}

	active_request = $.ajax({
		url: fullBaseUrl+'/properties/search'+searchParams,
		type: 'get',
		dataType: 'json',
		cache: false,
		// data: searchParams.substring(1), # or you can chose data attribute to pass params
		beforeSend: function() {
			elementToMaskList.mask('Waiting...');
		},
		success: function(response, textStatus, xhr) {
			//called when successful
			if (textStatus == 'success') {
				response = $.parseJSON(JSON.stringify(response));
				if (!response.error) {
					addMarkers(response.data, map, markerImage, infowindow, bounds);
				} else {
					toastr.error(response.message,'Error');
				}
			} else {
				toastr.warning(textStatus,'Warning!');
			}
		},
		complete: function(xhr, textStatus) {
			//called when complete
			elementToMaskList.unmask();
		},
		error: function(xhr, textStatus, errorThrown) {
			//called when there is an error
			elementToMaskList.unmask();
			toastr.error(errorThrown, 'Error!');
		}
	});
}

function addMarkers(propertyList, map, markerImage, infowindow, bounds) {
	/* Used for marker Clustering */
	if (propertyList.length > 0) {
		propertyList.forEach(function (property, key) {

			var latlng = new google.maps.LatLng(property.position.lat, property.position.lng);
			
			if (useMarkerLabel === true) {
				var markerLabel = property.price;
				if (property.allow_instant_booking === true && property.contract_type !== "sale") {
					markerLabel = property.price + '&nbsp;<i class="fa fa-bolt icon-instant-book" aria-hidden="true"></i>';
				}
				var marker = new MarkerWithLabel({
					map: map,
					icon: ' ',
					position: latlng,
					labelContent: markerLabel,
					labelAnchor: new google.maps.Point(0, 32),
					labelClass: "custom-marker-with-label em_property_map_label_"+property.id, // your desired CSS class
					labelInBackground: true
				});
			} else {
				var marker = new google.maps.Marker({
					position: latlng,
					map: map,
					icon: markerImage
				});
			}

			markers.push(marker);
			/* Used for marker Clustering */
			marker.setMap(map);
			bounds.extend(marker.getPosition());

			var infoboxContent = getInfoContent(property);
			google.maps.event.addListener(marker, 'click', function(event) {
				// // this is used for native google map infowindow
				// infowindow.setContent(infoboxContent);
				// infowindow.open(this.map, this);

				// using custom infowindow
				infobox.setContent(infoboxContent);
				infobox.setZIndex(999);
				infobox.open(this.map, this);
				// map.panTo(latlng);
				$(".gm-style-iw").next("div").hide();
			});
		});
	}

	/* Used for marker Clustering */
	// markerCluster = new MarkerClusterer(map, markers, mcOptions);
	map.fitBounds(bounds);
	var boundsListener = google.maps.event.addListener(map, 'idle', function(event) {
		if (this.getZoom() > 13) {
            this.setZoom(13);
        }
		google.maps.event.removeListener(boundsListener);
	});
}

function getInfoContent(property) {
	return '<div class="infoW">' +
		'<div class="propImg">' +
			'<img src="' + property.image + '">' +
			'<div class="propBg">' +
				'<div class="propPrice">' + property.price + '</div>' +
				'<div class="propType">' + property.type + '</div>' +
			'</div>' +
		'</div>' +
		'<div class="paWrapper">' +
			'<div class="propTitle">' + property.title + '</div>' +
			'<div class="propAddress">' + property.address + '</div>' +
		'</div>' +
		'<ul class="propFeat">' +
			'<li><i class="fa fa-home" aria-hidden="true"></i> ' + property.bedrooms + '</li>' +
			'<li><i class="fa fa-bed" aria-hidden="true"></i> ' + property.bed_number + '</li>' +
			'<li><i class="fa fa-bath" aria-hidden="true"></i> ' + property.bathrooms + '</li>' +
			'<li><i class="fa fa-users" aria-hidden="true"></i> ' + property.capacity + '</li>' +
			'<li><i class="fa fa-square" aria-hidden="true"></i> ' + property.area + '</li>' +
		'</ul>' +
		'<div class="clearfix"></div>' +
		'<div class="infoButtons">' +
			'<a class="btn btn-sm btn-info btn-round btn-gray btn-o closeInfo">Close</a>' +
			'<a href="' + property.view + '" class="btn btn-sm btn-success btn-round btn-green viewInfo">View</a>' +
		'</div>' +
	'</div>';
}

function geoFindMe() {
	var geo_options = {
		enableHighAccuracy: true,
		maximumAge        : 30000,
		timeout           : 3000
	};

	if (!navigator.geolocation){
		return false;
	}

	function success(position) {
		return position.coords;
	}

	function error(error) {
		console.log('Unable to retrieve your location: ERROR(' + error.code + '): ' + error.message);
		return false;
	}

	navigator.geolocation.getCurrentPosition(success, error, geo_options);
}

function getEdgeBounds() {
    if (typeof map.getCenter() == 'undefined') {
        return false;
    }

    return {
        centerLat: map.getCenter().lat(),
        centerLng: map.getCenter().lng(),
        northEastLat: map.getBounds().getNorthEast().lat(),
        northEastLng: map.getBounds().getNorthEast().lng(),
        southWestLat: map.getBounds().getSouthWest().lat(),
        southWestLng: map.getBounds().getSouthWest().lng()
    };
}

function loadSearch(searchParams) {
	var elementToMaskList = $('#filter-results');
	$.ajax({
		url: fullBaseUrl+'/properties/search_ajax',
		type: 'get',
		dataType: 'html',
		data: searchParams.substring(1),
		cache: false,
		beforeSend: function() {
			elementToMaskList.mask('Waiting...');
		},
		success: function(data, textStatus, xhr) {
			//called when successful
			if (textStatus == 'success') {
				$('#filter-results').html(data);
			} else {
				toastr.warning(textStatus, 'Warning!');
			}
		},
		complete: function(xhr, textStatus) {
			//called when complete
			elementToMaskList.unmask();
		},
		error: function(xhr, textStatus, errorThrown) {
			//called when there is an error
			elementToMaskList.unmask();
			toastr.error(errorThrown, 'Error!');
		}
	});
}

function onHtmlClick(evt, key) {
	google.maps.event.trigger(markers[key], 'click');
	return true;
}

function closeInfoWindow(evt, key) {
	infobox.close();
	return true;
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

function replaceQueryParam(param, newval, search) {
    var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
    var query = search.replace(regex, "$1").replace(/&$/, '');

    return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
}

function fillInAddress() {
	var place = autocomplete.getPlace();

	if (place.geometry.viewport) {
	    map.fitBounds(place.geometry.viewport);
	} else {
	    map.setCenter(place.geometry.location);
	    map.setZoom(17);
	}

	setMapBounds();

	$('#search_field_lat').val(place.geometry.location.lat());
	$('#search_field_lng').val(place.geometry.location.lng());

	get_search_result();
}

function setMapBounds() {
	var mapCenter = map.getCenter();
	var mapBounds = map.getBounds();
    var ne = mapBounds.getNorthEast(); // LatLng of the north-east corner
    var sw = mapBounds.getSouthWest();

	var str = window.location.search;
    str = replaceQueryParam('lat', mapCenter.lat(), str);
    str = replaceQueryParam('lng', mapCenter.lng(), str);
    str = replaceQueryParam('sw_lat', sw.lat(), str);
    str = replaceQueryParam('sw_lng', sw.lng(), str);
    str = replaceQueryParam('ne_lat', ne.lat(), str);
    str = replaceQueryParam('ne_lng', ne.lng(), str);
    if (history.pushState) {
        window.history.pushState({path:window.location.pathname + str},'',window.location.pathname + str);
    }
}

function getMapResult() {
	var mapCenter = map.getCenter();
	main_lat_lng = {lat: mapCenter.lat(), lng: mapCenter.lng()};

	var str = window.location.search;
	str = replaceQueryParam('lat', mapCenter.lat(), str);
	str = replaceQueryParam('lng', mapCenter.lng(), str);

	if (history.pushState) {
		window.history.pushState({path:window.location.pathname + str},'',window.location.pathname + str);
	}

	get_search_result(main_lat_lng);	
}

function getMapDistance() {
	// center and miles calculation

	var bounds = map.getBounds();
	var center = bounds.getCenter();
	
	var ne = bounds.getNorthEast();
	var r = 3963.0;  
	var lat1 = center.lat() / 57.2958; 
	var lon1 = center.lng() / 57.2958;
	var lat2 = ne.lat() / 57.2958;
	var lon2 = ne.lng() / 57.2958;
	var dist = r * Math.acos(Math.sin(lat1) * Math.sin(lat2) + Math.cos(lat1) * Math.cos(lat2) * Math.cos(lon2 - lon1));
	//cityCircle.setCenter(center);
	//cityCircle.setRadius((dist*75/100) * 1609.34);
	return (dist*75/100);
	// center and miles calculation end
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {

	if (infobox != undefined) {
	    if (infobox.getVisible()) {
	        infobox.close();
	    }
	}

	for (var i = 0; i < markers.length; i++) {
		markers[i].setMap(map);
	}
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
	setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() {
	setMapOnAll(map);
}

function get_search_result(pagination)
{
	// if (pagination==undefined) {
	// 	pagination = false;
	// }
	// if (pagination == false) {
	// 	var str = window.location.search;
	// 	str = replaceQueryParam('page', '1', str);
	// 	if (history.pushState) {
	// 		window.history.pushState({path:window.location.pathname + str},'',window.location.pathname + str);
	// 	}
	// }
	// // var params = window.location.search.substring(1);
	// // var bounds = new google.maps.LatLngBounds();
	// // callListings(params, map, markerImage, infowindow, bounds);
	// clearMarkers();

	// var str = window.location.search;
	// var bounds = new google.maps.LatLngBounds();
	// $.ajax({
	// 	url: fullBaseUrl+'/properties/search'+str, 
	// 	type:"get",
	// 	dataType:'json',
	// 	data:{},
	// 	cache:false,
	// 	success: function(result) {
	// 		// console.log(result.rooms);
	//            $('.search_result_content').html(result.html);
	//            var search_lat=getUrlParameter('lat');
	//            var search_lng=getUrlParameter('lng');
	//            main_lat_lng = new google.maps.LatLng(search_lat,search_lng);
	//            map.setCenter(main_lat_lng );
	//            //map.setZoom(main_zoom_level);
	//            map.setOptions({disableDoubleClickZoom: true });
	//            //alert(main_zoom_level);
	//            //map.setOptions({zoom: main_zoom_level });
	//            var rooms=result.rooms;
	//            var currency_symbol= result.currency_symbol;
	//            var current_cr_val=parseFloat(result.current_cr_val);
	//            $.each(rooms,function(i,val) {
	//                if(val.room_unit_html != ''){
	//                    latlngset = new google.maps.LatLng(val.latitude, val.longitude);
	//                    var amount = current_cr_val*val.rcomsn.toFixed(2);
	//                    var markerLabel = currency_symbol + amount;
	//                    var marker = new MarkerWithLabel({
	//                        map: map,
	//                        //animation: google.maps.Animation.DROP,
	//                        icon: " ",
	//                        position: latlngset,
	//                        labelContent: markerLabel,
	//                        labelAnchor: new google.maps.Point(16, 32),
	//                        labelClass: "custom-marker-with-label room_map_label_"+val.room_id, // your desired CSS class
	//                        labelInBackground: true
	//                    });
	//                    markers.push(marker);
	//                    marker.setMap(map);
	//                    bounds.extend( marker.getPosition() );
	//                    //var content = "<h3> " + val.room_name +  '</h3>' ; 
	//                    var content =  val.room_unit_html ; 
	//                    google.maps.event.addListener(marker,'click', (function(marker,content,infowindow)
	//                    { 
	//                        return function() 
	//                        {
	//                            infowindow.setContent(content);
	//                            infowindow.open(map,marker);
	//                            $(".gm-style-iw").next("div").hide();
	//                        };
	//                    })(marker,content,infowindow)); 
	//                }
	//            });
	//            var search_host_id=getUrlParameter('host_id');
	//            var host_search=getUrlParameter('host_search');
	//            if(search_host_id!=undefined && host_search==undefined) {
	//                map.fitBounds(bounds);
	//                var str = window.location.search;
	//                str = replaceQueryParam('host_search', 'true', str);
	//                if (history.pushState) {
	//                  window.history.pushState({path:window.location.pathname + str},'',window.location.pathname + str);
	//                 }
	//            }
	// 	}
	// });
	// return true;
}

function on_mouse(evt, index, propId) {
	$('.em_property_map_label_'+propId, '#mapView').addClass('hover');

    if (markers[index] != undefined) {
        mark = markers[index];
    	mark.setZIndex(99);
        // $(mark).addClass('hover');
    }
}

function out_mouse(evt, index, propId) {
	$('.em_property_map_label_'+propId, '#mapView').removeClass('hover');

    if (markers[index] != undefined) {
        mark = markers[index];
		mark.setZIndex(null);
        // $(mark).removeClass('hover');
    }
}

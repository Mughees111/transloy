
function isReady()
{
	var lat = document.getElementById('pickup_lat');
	var lng = document.getElementById('pickup_lng');

	var lat2 = document.getElementById('dropoff_lat');
	var lng2 = document.getElementById('dropoff_lng');


	if(lat.value=="" || lng.value=="")
	{
		alert("Please select valid pickup");
		return false;
	}
	if(lat2.value=="" || lng2.value=="")
	{
		alert("Please select valid dropoff");
		return false;
	}
	
}

var defaultLat =  parseFloat( lat_Edit )
var defaultLng = parseFloat(  lng_Edit )


function initMap() {
	console.log("starteedd");
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: defaultLat, lng: defaultLng},
          zoom: 17
        });
		var input = document.getElementById('pac-input');
		var lat = document.getElementById('pickup_lat');
		var lng = document.getElementById('pickup_lng');


		var autocomplete = new google.maps.places.Autocomplete(input);

		// Bind the map's bounds (viewport) property to the autocomplete object,
		// so that the autocomplete requests use the current map bounds for the
		// bounds option in the request.
		autocomplete.bindTo('bounds', map);

		// Set the data fields to return when the user selects a place.
		autocomplete.setFields(
		    ['address_components', 'geometry', 'icon', 'name']);

		var infowindow = new google.maps.InfoWindow();
		var infowindowContent = document.getElementById('infowindow-content');
		infowindow.setContent(infowindowContent);
		var marker = new google.maps.Marker({
		  map: map,
		  draggable:true,
	    animation: google.maps.Animation.DROP,
	    position: {lat: defaultLat, lng: defaultLng}
		  // anchorPoint: new google.maps.Point(0, -29)
		});








		// var marker2 = new google.maps.Marker(
		// {
		//     map:map,
		//     draggable:true,
		//     animation: google.maps.Animation.DROP,
		//     position: {lat: defaultLat, lng: defaultLng}
		// });
		google.maps.event.addListener(marker, 'dragend', function() 
		{
		    geocodePosition(marker.getPosition());
		});

		function geocodePosition(pos) 
		{
		   geocoder = new google.maps.Geocoder();
		   geocoder.geocode
		    ({
		        latLng: pos
		    }, 
		        function(results, status) 
		        {
		            if (status == google.maps.GeocoderStatus.OK) 
		            {
		            	var pp = results[0];
		            	console.log(results);


		            	 if (pp.geometry.viewport) {
						    map.fitBounds(pp.geometry.viewport);
						  } else {
						    map.setCenter(pp.geometry.location);
						    map.setZoom(17);  // Why 17? Because it looks good.
						  }
						  marker.setPosition(pp.geometry.location);


		            	lat.value = pp.geometry.location.lat();
		  				lng.value = pp.geometry.location.lng();


		  					var address = '';
						  if (pp.address_components) {
						    address = [
						      (pp.address_components[0] && pp.address_components[0].short_name || ''),
						      (pp.address_components[1] && pp.address_components[1].short_name || ''),
						      (pp.address_components[2] && pp.address_components[2].short_name || '')
						    ].join(' ');
						  }

						  var address2 = pp && pp?.formatted_address || ''
						  input.value = address2;
						  infowindowContent.children['place-icon'].src = pp.icon;
						  infowindowContent.children['place-name'].textContent = pp.name;
						  infowindowContent.children['place-address'].textContent = address;
						  infowindow.open(map, marker);

		                $("#mapSearchInput").val(results[0].formatted_address);
		                $("#mapErrorMsg").hide(100);
		            } 
		            else 
		            {
		                $("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
		            }
		        }
		    );
		}





		autocomplete.addListener('place_changed', function() {
		  infowindow.close();
		  // marker.setVisible(false);
		  var place = autocomplete.getPlace();
		  if (!place.geometry) {
		    // User entered the name of a Place that was not suggested and
		    // pressed the Enter key, or the Place Details request failed.
		    window.alert("No details available for input: '" + place.name + "'");
		    return;
		  }

		  // If the place has a geometry, then present it on a map.
		  if (place.geometry.viewport) {
		    map.fitBounds(place.geometry.viewport);
		  } else {
		    map.setCenter(place.geometry.location);
		    map.setZoom(17);  // Why 17? Because it looks good.
		  }
		  marker.setPosition(place.geometry.location);
		  lat.value = place.geometry.location.lat();
		  lng.value = place.geometry.location.lng();

		  // marker.setVisible(true);

		  var address = '';
		  if (place.address_components) {
		    address = [
		      (place.address_components[0] && place.address_components[0].short_name || ''),
		      (place.address_components[1] && place.address_components[1].short_name || ''),
		      (place.address_components[2] && place.address_components[2].short_name || '')
		    ].join(' ');
		  }

		  infowindowContent.children['place-icon'].src = place.icon;
		  infowindowContent.children['place-name'].textContent = place.name;
		  infowindowContent.children['place-address'].textContent = address;
		  infowindow.open(map, marker);
		});
	


		//////////////////////////////////////////////



}

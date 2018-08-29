$(document).ready(function() {
	var map;        
	var myCenter=new google.maps.LatLng(53, -1.33);
	var contentString = 'htrtutuy';
	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});
			
	function initialize() {
		var mapProp = {
			center:myCenter,
			zoom: 14,
			draggable: true,
			scrollwheel: false,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		};
	  
		map = new google.maps.Map(document.getElementById("map-canvas"),mapProp);
	}
	
	function codeAddress() {
		var address = $("#postcode").val();
		geocoder.geocode( { 'address': address, 'region': 'uk'}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				ParseLocation(results[0].geometry.location);
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location,
					draggable: true
				});
				
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.setContent(contentString);
					infowindow.open(map, marker);
				});
				
				google.maps.event.addListener(marker, 'drag', function() {
					ParseLocation(marker.getPosition());
				});
				
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}

	function ParseLocation(location) {
		var lat = location.lat().toString().substr(0, 12);
		var lng = location.lng().toString().substr(0, 12);
		
		$("#latitude").val(lat);
		$("#longitude").val(lng);
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);

	google.maps.event.addDomListener(window, "resize", resizingMap());


	
	$('#postcode').keyup(function() {
		$('#showmap').removeClass('disabled').click(function initialize() {
			geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng(-34.397, 150.644);
			var mapOptions = {
				zoom: 14,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			codeAddress();
										
			map = new google.maps.Map($("#map-canvas").get(0), mapOptions); 
			$('#myModal').modal('show');
		});
		
	});

	$('#myModal').on('show.bs.modal', function() {
	   //Must wait until the render of the modal appear, thats why we use the resizeMap and NOT resizingMap!! ;-)
	   resizeMap();
	});

	function resizeMap() {
	   if(typeof map =="undefined") return;
	   setTimeout( function(){resizingMap();} , 400);
	}

	function resizingMap() {
	   if(typeof map =="undefined") return;
	   var center = map.getCenter();
	   google.maps.event.trigger(map, "resize");
	   map.setCenter(center); 
	}
	
	$('#eventdatepicker').datepicker({
		inline: true,
		dateFormat: 'dd-mm-yy',
		showOtherMonths: true,
		dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		onSelect: function(dateText, inst) { 
			var dateAsString = dateText; //the first parameter of this function
		}
	});
});
	
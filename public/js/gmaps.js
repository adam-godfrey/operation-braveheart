function initialize() {
	var loc, map, marker, infobox;
	var resizeTimeout;
 
	loc = new google.maps.LatLng(latitude, longitude);

	map = new google.maps.Map(document.getElementById("map-canvas"), {
		 zoom: 15,
		 center: loc,
		 mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	
	marker = new google.maps.Marker({
		map: map,
		position: loc,
		visible: true
	});

	infobox = new InfoBox({
		content: document.getElementById("infobox"),
		disableAutoPan: false,
		maxWidth: 150,
		pixelOffset: new google.maps.Size(-140, 0),
		zIndex: null,
		boxStyle: {
			background: "url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
			opacity: 0.75,
			width: "280px"
		},
		closeBoxMargin: "12px 4px 2px 2px",
		closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
		infoBoxClearance: new google.maps.Size(1, 1)
	});
	
	google.maps.event.addListener(marker, 'click', function() {
		infobox.open(map, this);
		map.panTo(loc);
	});
	
	google.maps.event.addDomListener(window, "resize", function() {
		if (resizeTimeout) { 
			clearTimeout(resizeTimeout);
		} 
		resizeTimeout = setTimeout(function() {
			var center = map.getCenter();
			google.maps.event.trigger(map, "resize");
			map.setCenter(center); 
		}, 250);
	});
}
google.maps.event.addDomListener(window, 'load', initialize);
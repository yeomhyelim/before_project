
	// 페이지 첫 시작시 실행
	function goProductListShopSkin2ReadyMoveEvent(strAppID) {

		google.maps.event.addDomListener(window, 'load', function() {
			var strAddress = objScriptData['APP'][strAppID]['SHOP_ADDRESS'];
			if(strAddress) { 
				$.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address=' + strAddress, function(data) {
					if(data['status'] == "OK") {
						var lat = data['results'][0]['geometry']['location']['lat'];
						var lng = data['results'][0]['geometry']['location']['lng'];
						var myLatLng = new google.maps.LatLng(lat, lng);
						var mapOptions = new Object();
						mapOptions['zoom'] = 18;
						mapOptions['center'] = myLatLng;
						mapOptions['mapTypeId'] = google.maps.MapTypeId.ROADMAP;
						var map = new google.maps.Map($('#' + strAppID).find('#shopMap')[0], mapOptions);
						var marker = new google.maps.Marker({
							position : myLatLng,
							map:map,
							title: strAddress
						});
					}
				});
			}
		});
	}





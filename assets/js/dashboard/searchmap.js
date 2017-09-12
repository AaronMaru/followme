var markers = [];

function initAutocomplete() {

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 7,
        center: {
            lat: 11.5793558,
            lng: 104.8137736
        },
        zoomControl: true,
        mapTypeControl: true,
        scaleControl: true,
        streetViewControl: true,
        rotateControl: true,
        fullscreenControl: true
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    marker = new google.maps.Marker({
        position: {
            lat: parseFloat($('#newLat').val()),
            lng: parseFloat($('#newLng').val())
        },
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP
    });


    markers.push(marker);
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        $('#newLat').val('');
        $('#newLng').val('');
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                return;
            }

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });

    google.maps.event.addListener(map, 'click', function(e) {


        markers.forEach(function(marker) {
            marker.setMap(null);
        });

        locationplace = {
            lat: e.latLng.lat(),
            lng: e.latLng.lng()
        }

        marker = new google.maps.Marker({
            position: locationplace,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        });

        markers.push(marker);

        $('#newLat').val(e.latLng.lat());
        $('#newLng').val(e.latLng.lng());

        marker.addListener('click', toggleBounce);
        marker.addListener('drag', getLanLng);
        marker.addListener('dragend', getLanLng);
    });

    $('#getLocation').click(function() {
        markers.forEach(function(marker) {
            marker.setMap(null);
        });

        marker = new google.maps.Marker({
            position: {
                lat: parseFloat($('#newLat').val()),
                lng: parseFloat($('#newLng').val())
            },
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        });

        markers.push(marker);

        marker.addListener('click', toggleBounce);
        marker.addListener('drag', getLanLng);
        marker.addListener('dragend', getLanLng);
    });

    function toggleBounce() {

        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }

    function getLanLng(e) {
        $('#newLat').val(e.latLng.lat());
        $('#newLng').val(e.latLng.lng());
    }

    marker.addListener('click', toggleBounce);
    marker.addListener('dragend', getLanLng);
    marker.addListener('drag', getLanLng);
}

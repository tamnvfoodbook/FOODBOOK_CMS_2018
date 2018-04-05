/**
 * Created by Administrator on 10/2/2015.
 */

var map = new google.maps.Map(document.getElementById('map-canvas'), {
    center: {lat: 20.986102, lng: 105.846498},
    zoom: 15,
    mapTypeId: google.maps.MapTypeId.ROADMAP
});

// Create the search box and link it to the UI element.
var input = document.getElementById('pac-input');
var searchBox = new google.maps.places.SearchBox(input);
map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

// Bias the SearchBox results towards current map's viewport.
map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
});

var markers = [];
// [START region_getplaces]
// Listen for the event fired when the user selects a prediction and retrieve
// more details for that place.
searchBox.addListener('places_changed', function() {
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
        var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
        };

        // Create a marker for each place.
        var marker = new google.maps.Marker({
            map: map,
            //icon: icon,
            title: place.name,
            position: place.geometry.location,
            draggable: true
        });


        var posPossion =  getPosPossion(); // Lấy Possion của nhà hàng

        //console.log(place.formatted_address);
        $('#orderonlinelog-to_address').val(place.formatted_address);
        $('#latitude').val(place.geometry.location.lat()); //show  Latitude lên textInput sau khi kéo thả
        $('#longitude').val(place.geometry.location.lng()); //show  Long lên textInput sau khi kéo thả

        distance = getDistance(posPossion[0],posPossion[1],place.geometry.location.lat(),place.geometry.location.lng());
        $distance_convert = distance.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + 'm';

        $('#distance').val($distance_convert); //show  Long lên textInput sau khi kéo thả


        markers.push(marker);

        if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
            } else {
            bounds.extend(place.geometry.location);
            }



        google.maps.event.addListener(marker, 'dragend', function() {
                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            //console.log(results[0]);
                            $('#orderonlinelog-to_address').val(results[0].formatted_address);
                            $('#latitude').val(results[0].geometry.location.lat()); //show  Latitude lên textInput sau khi kéo thả
                            $('#longitude').val(results[0].geometry.location.lng()); //show  Long lên textInput sau khi kéo thả

                            distance = getDistance(posPossion[0],posPossion[1],place.geometry.location.lat(),place.geometry.location.lng());
                            $distance_convert = distance.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + 'm';
                            $('#distance').val($distance_convert); //show  Long lên textInput sau khi kéo thả
        }
        }
        });
        });



        });
        map.fitBounds(bounds);
        });


        var geocoder = new google.maps.Geocoder();
        //var myLatlng = new google.maps.LatLng(lat, long);


        var rad = function(x) {
            return x * Math.PI / 180;
            };

        var getDistance = function(lat1,long1,lat2,long2) {
            var R = 6378137; // Earth’s mean radius in meter
            var dLat = rad(lat2 - lat1);
            var dLong = rad(long2 - long1);
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(rad(lat1)) * Math.cos(rad(lat2)) *
            Math.sin(dLong / 2) * Math.sin(dLong / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c;
            return d; // returns the distance in meter
            };

        var link = document.getElementById('step2');

    link.addEventListener('click', function() {

        var form = document.getElementById('pac-input');
        console.log(form.value.length);
        if (form.value.length === 0) {
            alert("Bạn phải nhập địa chỉ vào bản đồ");
            form.focus();
            stop();
        }

    });




/*

var map;
var marker;
var distance;

var lat;
var long;
var possionPos;
var posLat;
var posLong;


var geocoder = new google.maps.Geocoder();
var infowindow = new google.maps.InfoWindow();



var rad = function(x) {
    return x * Math.PI / 180;
};

var getDistance = function(lat1,long1,lat2,long2) {
    var R = 6378137; // Earth’s mean radius in meter
    var dLat = rad(lat2 - lat1);
    var dLong = rad(long2 - long1);
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(rad(lat1)) * Math.cos(rad(lat2)) *
        Math.sin(dLong / 2) * Math.sin(dLong / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    return d; // returns the distance in meter
};

function initialize(lat,long) {
    var myLatlng = new google.maps.LatLng(lat, long);

    var mapOptions = {
        zoom: 18,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("pac-input"), mapOptions);

    marker = new google.maps.Marker({
        map: map,
        position: myLatlng,
        draggable: true
    });

    var posPossion =  getPosPossion(); // Lấy Possion của nhà hàng


    geocoder.geocode({'latLng': myLatlng }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                $('#orderonlinelog-to_address').val(results[0].formatted_address);
                $('#latitude').val(marker.getPosition().lat());
                $('#longitude').val(marker.getPosition().lng());
                distance = getDistance(posPossion[0],posPossion[1],marker.getPosition().lat(),marker.getPosition().lng());
                $('#distance').val(distance.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + 'm'); //show  Distancelên textInput sau khi vào
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
            }
        }
    });

    //
    //

    google.maps.event.addListener(marker, 'dragend', function() {

        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#orderonlinelog-to_address').val(results[0].formatted_address);
                    $('#latitude').val(marker.getPosition().lat());
                    $('#longitude').val(marker.getPosition().lng());
                    distance = getDistance(posPossion[0],posPossion[1],marker.getPosition().lat(),marker.getPosition().lng());
                    $('#distance').val(distance.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + 'm'); //show  Distancelên textInput sau khi vào
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                }
            }
        });
    });

}


function initializeWhenstartup(){

    var value = document.getElementById('checkmap').value;
    if(value){
        var array = value.split('-');
        lat = array[0];
        long = array[1];
    }

    var myLatlng = new google.maps.LatLng(lat,long);

    var mapOptions = {
        zoom: 18,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
        };

    map = new google.maps.Map(document.getElementById("myMap"), mapOptions);

    marker = new google.maps.Marker({
        map: map,
        position: myLatlng,
        draggable: true
    });

    var posPossion =  getPosPossion(); // Lấy Possion của nhà hàng
    //alert(posPossion[0]);

    geocoder.geocode({'latLng': myLatlng }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                $('#orderonlinelog-to_address').val(results[0].formatted_address);
                $('#latitude').val(marker.getPosition().lat()); //show  Latitude lên textInput sau khi vào
                $('#longitude').val(marker.getPosition().lng()); //show  Long lên textInput sau khi vào
                distance = getDistance(posPossion[0],posPossion[1],marker.getPosition().lat(),marker.getPosition().lng());
                $('#distance').val(distance.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + 'm'); //show  Distancelên textInput sau khi vào
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
            }
        }
    });



    google.maps.event.addListener(marker, 'dragend', function() {

        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#orderonlinelog-to_address').val(results[0].formatted_address);
                    $('#latitude').val(marker.getPosition().lat()); //show  Latitude lên textInput sau khi kéo thả
                    $('#longitude').val(marker.getPosition().lng()); //show  Long lên textInput sau khi kéo thả
                    distance = getDistance(posPossion[0],posPossion[1],marker.getPosition().lat(),marker.getPosition().lng());
                    $('#distance').val(distance.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + 'm'); //show  Distancelên textInput sau khi vào
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                }
            }
        });
    });

}

google.maps.event.addDomListener(window, 'load', initializeWhenstartup);

function selectChanged(newvalue){
    var array = newvalue.split('-');
    lat = array[0];
    long = array[1];
    google.maps.event.addDomListener(window,'load', initialize(lat,long));
}*/

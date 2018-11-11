import * as Map from 'leaflet';
import * as $ from 'jquery';

export default function carsShow() {

    let map = Map.map('locationMap').setView([40.6917969,-74.0360951], 10);

    let marker = null;

    let inputs = {
        location_lat: $('[name=pickup_location_lat]'),
        location_lon: $('[name=pickup_location_lon]'),
        full_location: $('[name=full_pickup_location]'),
    };

    Map.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiZGVuaXNrb3JvbmV0cyIsImEiOiJjam9kYTl6b3gyamkzM3BwdWpndjRxdDRpIn0.Bf3g80PoLcbYTmlpqGoJVg'
    }).addTo(map);

    map.on('click', function (e) {

        if (marker) {
            marker.removeFrom(map);
        }

        marker = Map.marker([e.latlng.lat, e.latlng.lng]);
        marker.addTo(map);

        inputs.location_lat.val(e.latlng.lat);
        inputs.location_lon.val(e.latlng.lng);

        inputs.full_location.val('Loading...');

        $.ajax({
            url: 'https://nominatim.openstreetmap.org/search?q=' + e.latlng.lat + ',' + e.latlng.lng + '&format=json&addressdetails=1'
        }).done(function(response) {
            inputs.full_location.val(response[0].display_name);
        });
    });

    $('#location-tabs .nav-link').click(function() {

       switch ($(this).attr('href')) {
           case '#tab-pickup':
               inputs = {
                   location_lat: $('[name=pickup_location_lat]'),
                   location_lon: $('[name=pickup_location_lon]'),
                   full_location: $('[name=full_pickup_location]'),
               };
               break;

           case '#tab-return':
               inputs = {
                   location_lat: $('[name=return_location_lat]'),
                   location_lon: $('[name=return_location_lon]'),
                   full_location: $('[name=full_return_location]'),
               };
               break;
       }
    });
}
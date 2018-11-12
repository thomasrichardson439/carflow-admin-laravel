import * as Map from 'leaflet';
import * as $ from 'jquery';
import MapHelper from "../helpers/map_helper";

export default function carsShow() {

    let map = new MapHelper('locationMap');
    map.moveTo(40.6917969, -74.0360951, 10);

    let marker = null;

    let inputs = {
        location_lat: $('[name=pickup_location_lat]'),
        location_lon: $('[name=pickup_location_lon]'),
        full_location: $('[name=full_pickup_location]'),
    };

    map.subscribe('click', function (e) {

        map.removeMarkers();
        map.addMarker(e.lat, e.lon);

        inputs.location_lat.val(e.lat);
        inputs.location_lon.val(e.lon);

        inputs.full_location.val('Loading...');

        map.locateAddress(e.lat, e.lon).then(function(address) {
            inputs.full_location.val(address);
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
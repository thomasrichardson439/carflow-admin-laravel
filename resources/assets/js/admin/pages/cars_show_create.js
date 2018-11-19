import * as Map from 'leaflet';
import * as $ from 'jquery';
import MapHelper from "../helpers/map_helper";
import Vue from 'vue';
import moment from 'moment';

export default function carsShow(create) {

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

    if (!create) {

        let data = {
            recurring: [
                {
                    id: 1,
                    day: 'Monday',
                    hourFrom: '12:00AM',
                    hourTo: '00:00PM',
                },
                {
                    id: 2,
                    day: 'Tuesday',
                    hourFrom: '12:00AM',
                    hourTo: '00:00PM',
                }
            ],
            onetime: [
                {
                    id: 2,
                    date: '2010-10-10',
                    hourFrom: '12:00AM',
                    hourTo: '00:00PM',
                }
            ]
        };

        let extraId = -1;

        const app = new Vue({
            el: '#vue-availability',
            data: data,
            methods: {
                addRecurring: function() {
                    data.recurring.push({
                        id: extraId--,
                        day: 'monday',
                        hourFrom: '12:00AM',
                        hourTo: '12:00PM',
                    });
                },
                addOneTime: function() {
                    data.onetime.push({
                        id: extraId--,
                        date: moment().format('YYYY-MM-DD'),
                        hourFrom: '12:00AM',
                        hourTo: '12:00PM',
                    });
                },
                removeRecurring: function(index) {
                    data.recurring.splice(index, 1);
                },
                removeOnetime: function(index) {
                    data.onetime.splice(index, 1);
                }
            }
        });
    }
}
import * as $ from 'jquery';
import MapHelper from "../helpers/map_helper";
import Vue from 'vue';
import moment from 'moment';
import AutocompleteHelper from "../helpers/autocomplete_helper";

function generateTimeSlots(minute) {

    let slots = {0: '12:' + minute + ' AM'}

    for (let i = 1; i <= 23; i++) {

        let _i = i;

        if (i === 12) {
            slots[12] = '12:' + minute + ' PM';
            continue;
        }

        if (_i > 12) {
            _i -= 12;
        }

        if (_i < 10) {
            _i = '0' + _i.toString();
        }

        slots[i] = _i + ':' + minute + ' ' + (i > 12 ? 'PM' : 'AM');
    }

    return slots;
}

export default function carsShowCreate(create) {

    let map = new MapHelper('locationMap', 40.6917969, -74.0360951, 10);

    let marker = null;

    let inputs = {
        location_lat: $('[name=pickup_location_lat]'),
        location_lon: $('[name=pickup_location_lon]'),
        full_location: $('[name=full_pickup_location]'),
    };

    map.onMapClicked(function (e) {

        map.removeMarkers();
        map.addMarker(e.lat, e.lon);

        inputs.location_lat.val(e.lat);
        inputs.location_lon.val(e.lon);

        inputs.full_location.val('Loading...');

        map.locateAddress(e.lat, e.lon).then(function(address) {
            inputs.full_location.val(address);
        }, function() {
            inputs.full_location.val('Unable to fetch address. Please pick another location');
        });
    });

    $('.autocomplete').each(function(index) {

        let locationUnpicked = false;
        let $self = $(this);

        $(this).keyup(function() {
            locationUnpicked = true;
            $('#save').addClass('disabled').prop('disabled', true);
        });

        $(this).focusout(function() {
            setTimeout(() => {
                if (locationUnpicked) {
                    $(this).addClass('is-invalid');
                }
            }, 1000);
        });

        new AutocompleteHelper($(this)[0]).onAutocompleteChanged((coordinates) => {
            if ($(this).is(':not(:visible)')) {
                return;
            }

            inputs.location_lat.val(coordinates.lat);
            inputs.location_lon.val(coordinates.lon);

            map.removeMarkers();
            map.addMarker(coordinates.lat, coordinates.lon);

            locationUnpicked = false;
            $('#save').removeClass('disabled').prop('disabled', false);
            $self.removeClass('is-invalid');
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

        let editButton = $('#edit');

        let data = {
            recurring: window.carAvailabilitySlots.recurring,
            onetime: window.carAvailabilitySlots.onetime,
            editOn: editButton.attr('edit-on') === '1',

            timeSlots: generateTimeSlots('00'),
            timeSlotsTo: generateTimeSlots('59'),

            daysOfWeek: {
                monday: 'Monday',
                tuesday: 'Tuesday',
                wednesday: 'Wednesday',
                thursday: 'Thursday',
                friday: 'Friday',
                saturday: 'Saturday',
                sunday: 'Sunday',
            },

            deletedAvailability: [],
        };

        editButton.on('edit-mode-changed', function(event, editOn) {
            data.editOn = editOn;
        });

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
                        hourTo: '11:59:PM',
                    });
                },
                addOneTime: function() {
                    data.onetime.push({
                        id: extraId--,
                        date: moment().format('MM/DD/YYYY'),
                        hourFrom: '12:00AM',
                        hourTo: '11:59PM',
                    });
                },
                removeRecurring: function(index) {

                    data.deletedAvailability.push(data.recurring[index].id);
                    data.recurring.splice(index, 1);
                },
                removeOnetime: function(index) {

                    data.deletedAvailability.push(data.onetime[index].id);
                    data.onetime.splice(index, 1);
                }
            }
        });
    }
}
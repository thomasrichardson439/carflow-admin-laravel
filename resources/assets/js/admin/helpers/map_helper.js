import * as $ from "jquery";

export default class MapHelper {

    constructor(containerId, lat, lon, zoom) {

        $('body').append(
            '<script async defer src="https://maps.googleapis.com/maps/api/js?key=' + window.googleMapsKey + '&callback=initMap" type="text/javascript"></script>'
        );

        window.initMap = () => {

            let center = {lat: lat, lng: lon};

            this.map = new window.google.maps.Map(
                document.getElementById(containerId), {zoom: zoom, center: center}
            );
        };

        this.markers = [];
    }

    /**
     * Moves map view to coordinates
     * @param {float} lat
     * @param {float} lon
     * @param {int} zoom
     */
    moveTo(lat, lon, zoom) {
        this.map.panTo(new google.maps.LatLng(lat, lon));
    }

    /**
     * Locates address by coordinates
     * @param {float} lat
     * @param {float} lon
     * @returns {Promise<any>}
     */
    locateAddress(lat, lon) {

        return new Promise((resolve, reject) => {

            $.ajax({
                url: 'https://nominatim.openstreetmap.org/search?q=' + lat + ',' + lon + '&format=json&addressdetails=1&accept-language=EN_us'
            }).done(function (response) {

                if (!response[0].address) {
                    reject();
                    return;
                }

                let address = response[0].address;

                resolve(address.house_number + ' ' + address.road + ', ' + address.city + ', ' + address.state + ', ' + address.postcode);

                resolve(response[0].display_name);
            });
        });
    }

    mapInitialized() {
        return new Promise((resolve, reject) => {

            let interval = null;

            interval = setInterval(() => {

                if (this.map) {
                    clearInterval(interval);
                    resolve();
                }

            }, 500);

        });
    }


    /**
     * Allows to subscribe for event
     * @param eventName
     * @param callback
     */
    subscribe(eventName, callback) {

        this.mapInitialized().then(() => {
            this.map.addListener(eventName, function (e) {

                let event = e;

                switch (eventName) {
                    case 'click':
                        event = {
                            lat: e.latLng.lat(),
                            lon: e.latLng.lng(),
                        };
                        break;
                }

                callback(event);
            });
        });
    }

    /**
     * Allows to add marker to map
     * @param lat
     * @param lon
     */
    addMarker(lat, lon) {

        let marker = new window.google.maps.Marker({
            position: {lat: lat, lng: lon},
            map: this.map
        });

        this.markers.push(marker);
    }

    /**
     * Remove all markers
     */
    removeMarkers() {
        this.markers.forEach((marker) => {
            marker.setMap(null);
        });
    }
}
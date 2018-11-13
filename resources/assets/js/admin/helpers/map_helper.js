import * as Map from "leaflet";
import * as $ from "jquery";

export default class MapHelper {

    constructor(containerId, lat, lon, zoom) {
        this.map =  Map.map(containerId);

        this.markers = [];

        Map.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.map);
    }

    /**
     * Moves map view to coordinates
     * @param {float} lat
     * @param {float} lon
     * @param {int} zoom
     */
    moveTo(lat, lon, zoom) {
        this.map.setView([lat, lon], zoom);
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
                url: 'https://nominatim.openstreetmap.org/search?q=' + lat + ',' + lon + '&format=json&addressdetails=1'
            }).done(function (response) {
                resolve(response[0].display_name);
            });
        });
    }


    /**
     * Allows to subscribe for event
     * @param eventName
     * @param callback
     */
    subscribe(eventName, callback) {
        this.map.on(eventName, function(e) {

            let event = e;

            switch (eventName) {
                case 'click':
                    event = {
                        lat: e.latlng.lat,
                        lon: e.latlng.lng,
                    };
                    break;
            }

            callback(event);
        });
    }

    /**
     * Allows to add marker to map
     * @param lat
     * @param lon
     */
    addMarker(lat, lon) {
        let marker = Map.marker([lat, lon]);
        marker.addTo(this.map);

        this.markers.push(marker);
    }

    /**
     * Remove all markers
     */
    removeMarkers() {
        this.markers.forEach((marker) => {
            marker.removeFrom(this.map);
        });
    }


}
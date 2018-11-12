import * as Map from "leaflet";
import * as $ from "jquery";

export default class MapHelper {

    constructor(containerId, lat, lon, zoom) {
        this.map =  Map.map(containerId);

        this.markers = [];

        Map.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoiZGVuaXNrb3JvbmV0cyIsImEiOiJjam9kYTl6b3gyamkzM3BwdWpndjRxdDRpIn0.Bf3g80PoLcbYTmlpqGoJVg'
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
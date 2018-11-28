import * as $ from "jquery";

export default class AutocompleteHelper {

    constructor(autocompleteInput) {

        this.autocomplete = null;

        this.initialized(() => window.google).then(() => {
            this.autocomplete = new window.google.maps.places.Autocomplete(
                autocompleteInput,
                {types: ['address']}
            );
        });
    }

    /**
     * Allows to wait for component initalization
     * @returns {Promise<any>}
     */
    initialized(callback) {
        return new Promise((resolve, reject) => {

            let interval = null;

            interval = setInterval(() => {

                if (callback()) {
                    clearInterval(interval);
                    resolve();
                }

            }, 500);

        });
    }

    onAutocompleteChanged(callback) {

        this.initialized(() => this.autocomplete).then(() => {
            this.autocomplete.addListener('place_changed', () => {

                const place = this.autocomplete.getPlace();

                callback({
                    lat: place.geometry.location.lat(),
                    lon: place.geometry.location.lng(),
                });
            });
        });
    }
}
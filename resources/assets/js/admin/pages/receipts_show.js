import * as $ from "jquery";

export default function receiptsShow() {

    $('body').append(
        '<script async defer src="https://maps.googleapis.com/maps/api/js?key=' + window.googleMapsKey + '&callback=initMap&libraries=places" type="text/javascript"></script>'
    );

    window.initMap = () => {
        new google.maps.places.Autocomplete(
            (document.getElementById('address-autocomplete')),
            {types: ['geocode']}
        );
    }
}
import * as $ from 'jquery';
import 'select2';

export default (function () {
    $('select.select2').select2({
        theme: 'bootstrap',
    });
}())

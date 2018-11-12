import * as $ from 'jquery';

'use strict';

export default (function () {

    if ($('.container-admin-form').length == 0) {
        return;
    }

    const inputs = $('input, select, textarea').not('[type=hidden]');

    /**
     * Allows to switch edit mode
     * @param {bool} on
     */
    const switchEdit = (on) => {
        if (on) {
            $('.edit-off').hide();
            $('.edit-on').show();
            inputs.prop('disabled', false);
        } else {
            $('.edit-on').hide();
            $('.edit-off').show();
            inputs.prop('disabled', true);
        }

        $('.edit-has-changes').hide();
    };

    $('#edit').click(() => {
        switchEdit(true);

        // Switch to info section
        $('.nav-link[href="#user-info"]').click();
    });

    $('#cancelChanges').click(() => {
        switchEdit(false);
    });

    inputs.on('change keyup', () => {
        $('.edit-has-changes').show();
    });

    $('#save').click(function () {
        let formSelector = $(this).data('form');
        $(formSelector).submit();
    });

    switchEdit(window.location.hash === '#edit');

})();
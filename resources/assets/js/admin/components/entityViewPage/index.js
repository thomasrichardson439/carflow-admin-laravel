import * as $ from 'jquery';

'use strict';

export default (function () {

    const editButton = $('#edit');
    const deleteButton = $('#delete');
    const formPageContainer = $('.container-admin-form');

    if (formPageContainer.length === 0) {
        return;
    }

    if (deleteButton.length > 0) {
        deleteButton.click(function(e) {
            if (!confirm('Are you sure want to delete this item?')) {
                e.preventDefault();
            }
        });
    }

    if (editButton.length > 0) {

        const inputs = $('input, select, textarea').not('[type=hidden]').not('.non-disabling');

        /**
         * Allows to switch edit mode
         * @param {bool} on
         */
        const switchEdit = (on) => {
            if (on) {
                $('.edit-off').hide();
                $('.edit-on').show();

            } else {
                $('.edit-on').hide();
                $('.edit-off').show();
            }

            inputs.prop('disabled', !on);
            inputs.each(function () {
                $(this).closest('.input-group, .form-group').toggleClass('disabled', !on);
            });

            $('.edit-has-changes').hide();

            editButton.trigger('edit-mode-changed', on).attr('edit-on', on ? 1 : 0);
        };

        editButton.click(() => {
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
    }

})();
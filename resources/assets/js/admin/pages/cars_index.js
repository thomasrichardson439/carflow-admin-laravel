import * as $ from 'jquery';

export default function carsIndex() {

    let filtersForm = $('#filters-form'),
        filters = $('.filter'),
        filterPicks = $('#filters-menu .dropdown-item');

    const updateCars = function() {
        $.ajax({
            url: window.location.pathname,
            data: filtersForm.find('input,select').filter(':visible').serialize(),
            type: 'get',
            dataType: 'html',

        }).done(function(response) {
            $('.grid-view-container').html($('.grid-view-container', response));

        }).fail(function() {
            alert('Something went wrong while processing your request');
        });
    };

    filterPicks.click(function() {
        filtersForm.show();
        $(this).addClass('selected');
        filters.filter('[data-filter="' + $(this).data('filter') + '"]').css('display', 'flex');
    });

    filters.find('.removeFilter').click(function() {
        $(this).closest('.filter').css('display', 'none');
        filterPicks.filter('[data-filter="' + $(this).closest('.filter').data('filter') + '"]').removeClass('selected');

        if (filters.filter(':visible').length == 0) {
            filtersForm.hide();
        }

        updateCars();
    });

    filtersForm.find('input,select').change(updateCars);
}
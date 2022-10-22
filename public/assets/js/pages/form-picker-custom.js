'use strict';

$(document).ready(function() {

    $('#date-invoice, #arrivalDate ,#departureDate').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'DD MMMM YYYY',
        time: false

    });

    $('#date-Valid-To, #date-Cruise-Check-out').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });
    $('#date-Valid-From, #date-Cruise-Check-in').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    }).on('change', function(e, date) {
        $('#date-Valid-To').removeAttr("disabled");
        $('#date-Valid-To, #date-Cruise-Check-out').bootstrapMaterialDatePicker('setMinDate', date);
    });

    $('#Departure-date').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY - HH:mm',
        shortTime : true,
        time: true
    });
    $('#Arrival-date').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY - HH:mm',
        shortTime : true,
        time: true
    }).on('change', function(e, date) {
        $('#Departure-date').bootstrapMaterialDatePicker('setMinDate', date);
    });

    $('#date, #date-Hiring, #date-Promotion, #Date-of-Issue, #date-sond-ligt-Show, #flight-date, #Request-date,#tourDate').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });

    $('#tourDate').bootstrapMaterialDatePicker().on('change', function(e, date) {
        $('.joTGGuidesDDL, .joTGCitiesDDL, .joTGVisitsDDL').removeAttr("disabled");
    });

    $('#Train-Departure-date, #Train-Arrival-date').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });

    $('#time, #time-of-show, #Time-From, #Time-To,#Train-Arrival-Time,#Train-Departure-Time').bootstrapMaterialDatePicker({
        date: false,
        shortTime : true,
        format: 'HH:mm'
    });


    $('#date-format').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY - HH:mm',
        shortTime : true
    });


    $('#date-fr').bootstrapMaterialDatePicker({
        format: 'DD/MM/YYYY HH:mm',
        shortTime : true,
        lang: 'fr',
        weekStart: 1,
        cancelText: 'ANNULER'
    });

    $('#min-date').bootstrapMaterialDatePicker({
        format: 'DD/MM/YYYY HH:mm',
        shortTime : true,
        minDate: new Date()
    });

    $('#date-end').bootstrapMaterialDatePicker({
        weekStart: 0,
        shortTime : true,
        format: 'dddd DD MMMM YYYY - HH:mm'
    });
    $('#date-start').bootstrapMaterialDatePicker({
        weekStart: 0,
        shortTime : true,
        format: 'dddd DD MMMM YYYY - HH:mm'
    }).on('change', function(e, date) {
        $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
    });

    $('.demo').each(function() {
        $(this).minicolors({
            control: $(this).attr('data-control') || 'hue',
            defaultValue: $(this).attr('data-defaultValue') || '',
            format: $(this).attr('data-format') || 'hex',
            keywords: $(this).attr('data-keywords') || '',
            inline: $(this).attr('data-inline') === 'true',
            letterCase: $(this).attr('data-letterCase') || 'lowercase',
            opacity: $(this).attr('data-opacity'),
            position: $(this).attr('data-position') || 'bottom',
            swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
            change: function(value, opacity) {
                if (!value) return;
                if (opacity) value += ', ' + opacity;
                if (typeof console === 'object') {
                }
            },
            theme: 'bootstrap'
        });
    });
});

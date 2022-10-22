'use strict';

var weekpicker, start_date, end_date;

function set_week_picker(date) {
    start_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
    end_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
    weekpicker.datepicker('update', start_date);
    weekpicker.val(
        start_date.getDate() + '/' + (start_date.getMonth() + 1) + '/' + start_date.getFullYear()
        + ' - ' +
        end_date.getDate() + '/' + (end_date.getMonth() + 1) + '/' + end_date.getFullYear()
    );
}

$(document).ready(function() {
    weekpicker = $('.week-picker');
    console.log(weekpicker);
    weekpicker.datepicker({
        weekStart: 5,
        autoclose: true,
        forceParse: false,
        container: '#week-picker-wrapper',

    }).on("changeDate", function(e) {
        set_week_picker(e.date);
    });
    $('.week-prev').on('click', function() {
        var prev = new Date(start_date.getTime());
        prev.setDate(prev.getDate() - 1);
        set_week_picker(prev);
    });
    $('.week-next').on('click', function() {
        var next = new Date(end_date.getTime());
        next.setDate(next.getDate() + 1);
        set_week_picker(next);
    });
    // set_week_picker(new Date);
});

// $(document).ready(function() {

//     $('#d_week').datepicker({
//         daysOfWeekDisabled: "2"
//     });

//     $('#d_highlight').datepicker({
//         daysOfWeekHighlighted: "1"
//     });

//     $('#d_auto').datepicker({
//         autoclose: true
//     });

//     $('#d_disable').datepicker({
//         datesDisabled: ['10/15/2018', '10/16/2018' ,  '10/17/2018' , '10/18/2018' ]
//     });

//     $('#d_toggle').datepicker({
//         keyboardNavigation: false,
//         forceParse: false,
//         toggleActive: true
//     });

//     $('#d_today').datepicker({
//         keyboardNavigation: false,
//         forceParse: false,
//         todayHighlight: true
//     });

//     $('#disp_week').datepicker({
//         calendarWeeks: true
//     });

//     $('#datepicker_range').datepicker({});
// });

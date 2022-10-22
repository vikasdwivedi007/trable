function resetAccommodationForm(element, except = null) {
    // element = $(element);
    var form = element.closest('form');
    form.find('input[type="hidden"]').remove();
    form.find('input').each(function () {
        if ($(this).val()) {
            $(this).val("");
        }
    });
    form.find('select').each(function () {
        if ((!except || $(this)[0] != except[0]) && $(this).val()) {
            $(this).val("").trigger("change")
        }
    });
    form.find('.CancelationFees').val("Cancellation Fees");
    form.find('.TimePreiod').val("Before 1 day");
    form.find('.joHotelsDDL, .joRoomTypesDDL, .joRoomViewsDDL, .joRoomCategoriesDDL, .joMealPlansDDL, .joSituationDDL, .date-Valid-From, .date-Valid-To, .HotelPaymentDate, .HotelVoucherDate').attr("disabled", "disabled");
    form.find('.room_prices').html("");
}

function resetFlightForm(form = null) {
    if (!form) {
        $('#DomesticFlightsAdded form input:not([type=\"hidden\"]), #InternationalFlightsAdded form input:not([type=\"hidden\"])').val("");
        $('#DomesticFlightsAdded form .item_id, #InternationalFlightsAdded form .item_id').remove();
    } else {
        form.find('input:not([type=\"hidden\"])').val("");
        form.find('.item_id').remove();
    }
}

function resetGuideForm(element) {
    var form = element.closest('form');
    form.find('input').val("");
    form.find('select').each(function () {
        if ($(this).val()) {
            $(this).val("").trigger("change")
        }
    });
    form.find('input,select').attr('disabled', 'disabled');
    form.find('.tourDate').removeAttr('disabled');
}

function addNewDomisticFlgiht() {
    var existing_item = $("#DomesticFlightsAdded .domestic_flight_item").first();
    existing_item.find('.remove_item').css('display', 'none');
    var new_item = existing_item.clone();
    new_item.find('input:not([type="hidden"])').val("");
    new_item.find('.item_id').val("");
    new_item.find('.remove_item').css('display', 'block');
    $('#DomesticFlightsAdded').append(new_item);
    flight_items_count++;
    new_item.find('input').each(function () {
        var input_name = $(this).attr("name");
        if (input_name && input_name.indexOf('][') > -1) {
            input_name = input_name.replace('[' + (input_name.charAt(input_name.indexOf('][') - 1)) + ']', '[' + (flight_items_count - 1) + ']');
            $(this).attr('name', input_name);
        }
    });
    new_item.find('.form_err').remove();
    new_item.find('.flight_id').val('');
}

function addNewInternationalFlgiht() {

    var existing_item = $("#InternationalFlightsAdded .international_flight_item").first();
    existing_item.find('.remove_item').css('display', 'none');
    var new_item = existing_item.clone();
    new_item.find('input:not([type="hidden"])').val("");
    new_item.find('.item_id').val("");
    new_item.find('.remove_item').css('display', 'block');
    $('#InternationalFlightsAdded').append(new_item);
    flight_items_count++;
    new_item.find('input').each(function () {
        var input_name = $(this).attr("name");
        if (input_name && input_name.indexOf('][') > -1) {
            input_name = input_name.replace('[' + (input_name.charAt(input_name.indexOf('][') - 1)) + ']', '[' + (flight_items_count - 1) + ']');
            $(this).attr('name', input_name);
        }
    });
    new_item.find('.form_err').remove();
    new_item.find('.flight_id').val('');
}


function addNewAccommodation() {
    var existing_item = $("#acc_wrapper .accommodation-item").first();
    existing_item.find(".js-example-tags").select2("destroy");
    existing_item.find('.remove_item').css('display', 'none');
    var new_item = existing_item.clone();
    new_item.find('select,input').attr('disabled', 'disabled');
    new_item.find('.joHCitiesDDL').removeAttr('disabled');
    new_item.find('.remove_item').css('display', 'block');
    new_item.find('.reset_item').css('display', 'none');
    accommodation_items_count++;
    new_item.find('select, input').each(function () {
        var input_name = $(this).attr("name");
        if (input_name && input_name.indexOf('][') > -1) {
            input_name = input_name.replace('[' + (input_name.charAt(input_name.indexOf('][') - 1)) + ']', '[' + (accommodation_items_count - 1) + ']');
            $(this).attr('name', input_name);
        }
    });
    new_item.find('.form_err').remove();
    $('#acc_wrapper').append(new_item);
    $("#acc_wrapper .js-example-tags, #acc_wrapper .js-example-tags option").removeAttr('data-select2-id');
    $("#acc_wrapper .js-example-tags").select2();
    new_item.find('.date-Valid-From,  .date-Valid-To, .HotelPaymentDate, .HotelVoucherDate').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });
    new_item.find('.date-Valid-From').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    }).on('change', function (e, date) {
        var form = $(this).closest('form');
        if (form) {
            form.find('.date-Valid-To').removeAttr("disabled");
            form.find('.date-Valid-To').bootstrapMaterialDatePicker('setMinDate', date);
        }
    });
    new_item.find('.date-Valid-From,  .date-Valid-To').val("");
    resetAccommodationForm(new_item.find('.joHCitiesDDL'));
}

function addNewTourGuide_updated() {
    var existing_item = $("#Tour-Guide .guide_item").first();
    existing_item.find(".js-example-tags").select2("destroy");
    existing_item.find('.remove_item').css('display', 'none');
    existing_item.find('.reset_item').css('display', 'block');
    var new_item = existing_item.clone();
    new_item.find('select,input').attr('disabled', 'disabled');
    new_item.find('.tourDate').removeAttr('disabled');
    new_item.find('.remove_item').css('display', 'block');
    new_item.find('.reset_item').css('display', 'none');
    guide_items_count++;
    new_item.find('select, input').each(function () {
        var input_name = $(this).attr("name");
        if (input_name && input_name.indexOf('][') > -1) {
            input_name = input_name.replace('[' + (input_name.charAt(input_name.indexOf('][') - 1)) + ']', '[' + (guide_items_count - 1) + ']');
            $(this).attr('name', input_name);
        }
    });
    new_item.find('.form_err').remove();
    $('#Tour-Guide').append(new_item);
    $("#Tour-Guide .js-example-tags, #Tour-Guide .js-example-tags option").removeAttr('data-select2-id')
    new_item.find('.joVisitsDDL option').remove();
    new_item.find('.joVisitsDDL').append('<option value="">Select Visits(SightSeeing)</option>');

    $("#Tour-Guide .js-example-tags").select2();
    new_item.find('.tourDate').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });
    new_item.find('input').val('');
    new_item.find('select').val('').trigger('change');
}

function delay(callback, ms) {
    var timer = 0;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}

function validateTourForm(form) {
    var city_id = form.find('.joCitiesDDL').val().trim();
    var sightseeing_id = form.find('.joVisitsDDL').val().trim();
    var date = form.find('.tourDate').val().trim();
    var guide_id = form.find('.joGuidesDDL').val().trim();
    if (
        (!city_id && !sightseeing_id && !date && !guide_id) //all empty
        ||
        (city_id && sightseeing_id && date && guide_id) // all full
    ) {
        return true;
    } else {
        return false;
    }
}

function addAnotherDay_updated() {
    var existing_item = $("#ProgramAdded .program_item").first();
    existing_item.find(".js-example-tags").select2("destroy");
    existing_item.find(".js-example-tags,.js-example-tags option").removeAttr('data-select2-id');

    existing_item.find('.remove_main_item').css('display', 'none');
    var new_item = existing_item.clone();
    new_item.find('.remove_main_item').css('display', 'block');
    new_item.find('.reset_item').css('display', 'none');
    new_item.find('select.joCitiesDDL').val("");
    program_days_count++;
    new_item.find('select, input').each(function () {
        var input_name = $(this).attr("name");
        if (input_name && getAllIndexes(input_name, '][').length) {
            var first_occ = getAllIndexes(input_name, '][')[0] - 1;
            input_name = input_name.replace('[' + (input_name.charAt(first_occ)) + ']', '[' + (program_days_count - 1) + ']');
            $(this).attr('name', input_name);
        }
    });
    new_item.find('input[type="checkbox"]').each(function () {
        var input_id = $(this).attr("id");
        var update_id = input_id + "-" + program_days_count;
        $(this).attr("id", update_id);
        $(this).siblings('label').attr("for", update_id);
    });
    new_item.find('.form_err').remove();
    new_item.find('input[type="checkbox"]').prop('checked', false);
    new_item.find(".SoundLightShowDetails, .Visit-Night-Details, .SightSeeingDetails, .LiftDetails").addClass('d-none');
    $('#ProgramAdded').append(new_item);
    $("#ProgramAdded .js-example-tags").select2();
    new_item.find('select,input:not(".item_type")').val("");
    new_item.find('.time, .time-of-show, .Time-From, .Time-To,.Train-Arrival-Time,.Train-Departure-Time').bootstrapMaterialDatePicker({
        date: false,
        shortTime: true,
        format: 'HH:mm'
    });
    new_item.find('.program_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });
    // new_item.find('.date-Cruise-Check-in, .date-Cruise-Check-out').bootstrapMaterialDatePicker({
    //     weekStart: 0,
    //     format: 'dddd DD MMMM YYYY',
    //     time: false
    // });
    new_item.find('.sightseeing_item').slice(1).remove();
    new_item.find('.vbnight_item').slice(1).remove();
    new_item.find('.lift    _item').slice(1).remove();
    // new_item.find('.cabin_item').slice(1).remove();
    // new_item.find('.NileCuriseDetails .joNileCruisesDDL option[value!=""]').remove();
    //reset form
}

function getAllIndexes(arr, val) {
    var indexes = [], i = -1;
    while ((i = arr.indexOf(val, i + 1)) != -1) {
        indexes.push(i);
    }
    return indexes;
}

function addSightSeeing_updated(element) {
    var form = element.closest('form');
    var existing_sightseeing_item = form.find(".SightSeeingDetails .sightseeing_item").first();

    existing_sightseeing_item.find(".js-example-tags").select2("destroy");
    existing_sightseeing_item.find(".js-example-tags,.js-example-tags option").removeAttr('data-select2-id');

    existing_sightseeing_item.find('.remove_item').css('display', 'none');
    var new_item = existing_sightseeing_item.clone();
    new_item.find('.remove_item').css('display', 'block');
    // new_item.find('.reset_item').css('display', 'none');
    program_sightseeing_count++;
    new_item.find('select, input').each(function () {
        var input_name = $(this).attr("name");
        if (input_name && getAllIndexes(input_name, '][').length > 1) {
            var new_name = "[items][" + program_sightseeing_count + "]";
            input_name = input_name.replace(/\[items\]\[\d+\]/, new_name);
            $(this).attr('name', input_name);
        }
    });
    form.find('.SightSeeingDetails').append(new_item);
    form.find(".SightSeeingDetails .js-example-tags").select2();
    new_item.find('select,input:not(".item_type")').val("");
    new_item.find('.time, .time-of-show, .Time-From, .Time-To,.Train-Arrival-Time,.Train-Departure-Time').bootstrapMaterialDatePicker({
        date: false,
        shortTime: true,
        format: 'HH:mm'
    });
    new_item.find('.program_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });
    new_item.find('.date-Cruise-Check-in, .date-Cruise-Check-out').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });
}

function addVisitNight_updated(element) {
    var form = element.closest('form');
    var existing_item = form.find(".Visit-Night-Details .vbnight_item").first();

    existing_item.find(".js-example-tags").select2("destroy");
    existing_item.find(".js-example-tags,.js-example-tags option").removeAttr('data-select2-id');

    existing_item.find('.remove_item').css('display', 'none');
    var new_item = existing_item.clone();
    new_item.find('.remove_item').css('display', 'block');
    // new_item.find('.reset_item').css('display', 'none');
    program_vbnights_count++;
    new_item.find('select, input').each(function () {
        var input_name = $(this).attr("name");
        if (input_name && getAllIndexes(input_name, '][').length > 1) {
            var new_name = "[items][" + program_vbnights_count + "]";
            input_name = input_name.replace(/\[items\]\[\d+\]/, new_name);
            $(this).attr('name', input_name);
        }
    });
    form.find('.Visit-Night-Details').append(new_item);
    form.find(".Visit-Night-Details .js-example-tags").select2();
    new_item.find('select,input:not(".item_type")').val("");
    new_item.find('.time, .time-of-show, .Time-From, .Time-To,.Train-Arrival-Time,.Train-Departure-Time').bootstrapMaterialDatePicker({
        date: false,
        shortTime: true,
        format: 'HH:mm'
    });
    new_item.find('.program_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });
    new_item.find('.date-Cruise-Check-in, .date-Cruise-Check-out').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });
}

function addLift(element) {
    var form = element.closest('form');
    var existing_lift_item = form.find(".LiftDetails .lift_item").first();

    existing_lift_item.find('.remove_item').css('display', 'none');
    var new_item = existing_lift_item.clone();
    new_item.find('.remove_item').css('display', 'block');
    // new_item.find('.reset_item').css('display', 'none');
    program_lift_count++;
    new_item.find('select, input').each(function () {
        var input_name = $(this).attr("name");
        if (input_name && getAllIndexes(input_name, '][').length > 1) {
            var new_name = "[items][" + program_lift_count + "]";
            input_name = input_name.replace(/\[items\]\[\d+\]/, new_name);
            $(this).attr('name', input_name);
        }
    });
    form.find('.LiftDetails').append(new_item);
    new_item.find('input:not(".item_type")').val("");
    new_item.find('input.item_id').val("9999");
    new_item.find('.time, .time-of-show, .Time-From, .Time-To,.Train-Arrival-Time,.Train-Departure-Time').bootstrapMaterialDatePicker({
        date: false,
        shortTime: true,
        format: 'HH:mm'
    });
}

function addTrainTicket(element) {
    var parent_div = $('.TrainTicketDetails');
    var existing_train_item = parent_div.find(".train-item").first();

    existing_train_item.find(".js-example-tags").select2("destroy");
    existing_train_item.find(".js-example-tags,.js-example-tags option").removeAttr('data-select2-id');

    existing_train_item.find('.remove_item').css('display', 'none');
    var new_item = existing_train_item.clone();
    new_item.find('.remove_item').css('display', 'block');

    parent_div.find('.js-example-tags').select2();
    new_item.find('select,input').val("");
    parent_div.append(new_item);
    $('.Train-Departure-date').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });
}

function addNileCruise() {
    cruise_items_count++;
    var parent_div = $('.NileCuriseDetails');
    var existing_cruise_item = parent_div.find(".cruise-item").first();
    existing_cruise_item.find(".js-example-tags").select2("destroy");
    existing_cruise_item.find(".js-example-tags,.js-example-tags option").removeAttr('data-select2-id');

    existing_cruise_item.find('.remove_item').css('display', 'none');
    var new_item = existing_cruise_item.clone();
    new_item.find('.remove_item').css('display', 'block');
    new_item.find('.remove_cabin').css('display', 'none');

    // new_item.find('select,input').val("");
    parent_div.append(new_item);

    new_item.find('.cabin_item').slice(1).remove();
    new_item.find('.joNileCruisesDDL option[value!=""]').remove();
    new_item.find('select:not(".joNileCruisesCitiesDDL"),input:not([type=\"checkbox\"])').val("").trigger('change').attr('disabled', 'disabled');
    new_item.find('input[type="checkbox"]').prop('checked', false);
    new_item.find('input[type="checkbox"]').each(function () {
        var input_id = $(this).attr("id");
        var update_id = input_id + "-" + cruise_items_count;
        $(this).attr("id", update_id);
        $(this).siblings('label').attr("for", update_id);
    });
    parent_div.find('.js-example-tags').select2();
}

function resetProgramForm() {
    $("#Program form").find('input:not(.item_type,input[type="checkbox"])').val("");
    $("#Program form").find('select').val("").trigger("change");
    $("#Program form").find('input[type="checkbox"]').prop('checked', false);
}

function addCabinItem(element) {
    var cruise_item = element.closest('.cruise-item');
    var existing_item = cruise_item.find(".cabin_item").first();

    existing_item.find(".js-example-tags").select2("destroy");
    existing_item.find(".js-example-tags,.js-example-tags option").removeAttr('data-select2-id');

    var new_item = existing_item.clone();
    new_item.find('.remove_cabin').css('display', 'block');
    $(new_item).insertBefore(cruise_item.find('.cruise_checkboxes_row'));
    cruise_item.find(".js-example-tags").select2();
    new_item.find('.js-example-tags').val("").trigger('change');
}

function calculateSightInProgram(form) {
    form.find('.joSightSeeingsDDL').each(function () {
        var sights_input = $(this);
        var sights_id = sights_input.val().trim();
        if (sights_id) {
            var option_selected = sights_input.find('option:selected');
            var adult_price = option_selected.attr('data-adult-price');
            var child_price = option_selected.attr('data-child-price');
            var sell_price_adult_currency = option_selected.attr('data-sell_price_adult_currency');
            var sell_price_child_currency = option_selected.attr('data-sell_price_child_currency');
            form.find('.adult_price').val(adult_price + " " + sell_price_adult_currency);
            form.find('.child_price').val(child_price + " " + sell_price_child_currency);
            var total_price = ($('select[name="adults_count"]').val() * adult_price) + ($('select[name="children_count"]').val() * child_price);
            form.find('.total_price').val(total_price + " " + sell_price_adult_currency);
        } else {
            form.find('.adult_price').val('');
            form.find('.child_price').val('');
            form.find('.total_price').val('');
        }
    });
}

function calculateVBNightInProgram(form) {
    form.find('.joVisitsNightDDL').each(function () {
        var vbnight_input = $(this);
        var vbnight_id = vbnight_input.val().trim();
        if (vbnight_id) {
            var option_selected = vbnight_input.find('option:selected');
            var adult_price = option_selected.attr('data-adult-price');
            var child_price = option_selected.attr('data-child-price');
            var adult_sell_currency = option_selected.attr('data-adult_sell_currency');
            var child_sell_currency = option_selected.attr('data-child_sell_currency');
            form.find('.adult_price').val(adult_price + " " + adult_sell_currency);
            form.find('.child_price').val(child_price + " " + child_sell_currency);
            var total_price = ($('select[name="adults_count"]').val() * adult_price) + ($('select[name="children_count"]').val() * child_price);
            form.find('.total_price').val(total_price + " " + adult_sell_currency);
        } else {
            form.find('.adult_price').val('');
            form.find('.child_price').val('');
            form.find('.total_price').val('');
        }
    });
}

function calculateSLShowInProgram(slshow_item) {
    time_input = slshow_item.find('.time');
    slshow_item.find('.adult_price,.child_price,.total_price').val("");
    var slshow_id = time_input.val().trim();
    if (slshow_id) {
        var option_selected = time_input.find('option:selected');
        var item_id_input = slshow_item.find('.item_id');
        var adult_price_input = slshow_item.find('.adult_price');
        var child_price_input = slshow_item.find('.child_price');
        var total_price_input = slshow_item.find('.total_price');
        item_id_input.val(slshow_id);
        var adult_price = option_selected.attr('data-adult-price');
        var child_price = option_selected.attr('data-child-price');
        var adult_sell_currency = option_selected.attr('data-adult_sell_currency');
        var child_sell_currency = option_selected.attr('data-child_sell_currency');
        adult_price_input.val(adult_price + " " + adult_sell_currency);
        child_price_input.val(child_price + " " + child_sell_currency);
        var total_price = ($('select[name="adults_count"]').val() * adult_price) + ($('select[name="children_count"]').val() * child_price);
        total_price_input.val(total_price + " " + adult_sell_currency);
    } else {
        slshow_item.find('.adult_price,.child_price,.total_price,.item_id').val("");
    }
}

function AddNewGift() {
    var existing_item = $("#GiftDetails .gift_item").first();
    existing_item.find(".js-example-tags").select2("destroy");
    existing_item.find(".js-example-tags,.js-example-tags option").removeAttr('data-select2-id');

    existing_item.find('.remove_item').css('display', 'none');
    var new_item = existing_item.clone();
    new_item.find('.add_item').css('display', 'none');
    new_item.find('.remove_item').css('display', 'block');
    new_item.find('select,input').val("");
    new_item.insertBefore("#GiftDetails hr");
    $(".gift_item .js-example-tags").select2();
}

$(function () {

    $('.date-Valid-To, .HotelPaymentDate, .HotelVoucherDate, .tourDate').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });

    $('.date-Valid-From').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    }).on('change', function (e, date) {
        var form = $(this).closest('form');
        if (form) {
            form.find('.date-Valid-To').removeAttr("disabled");
            form.find('.date-Valid-To').bootstrapMaterialDatePicker('setMinDate', date);
        }
    });

    $('.Train-Departure-date').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });

    $('#Arrival-date-job').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    }).on('change', function (e, date) {
        $('#Departure-date-job').bootstrapMaterialDatePicker('setMinDate', date);
    });

    $('#Departure-date-job').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    }).on('change', function (e, date) {
        $('#Arrival-date-job').bootstrapMaterialDatePicker('setMaxDate', date);
    });

    $('.program_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });

    $('.time, .time-of-show, .Time-From, .Time-To,.Train-Arrival-Time,.Train-Departure-Time').bootstrapMaterialDatePicker({
        date: false,
        shortTime: true,
        format: 'HH:mm'
    });

    $('.date-Cruise-Check-in, .date-Cruise-Check-out').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'dddd DD MMMM YYYY',
        time: false
    });

    $(document).on("change", ".date-Valid-From, .date-Valid-To", function () {
        var changed = $(this);
        var form = changed.closest('form');
        checkRoomIsAvailable(form);
    });

    $(document).on("change", "#Tour-Guide .tourDate", function () {
        var date_input = $(this);
        var form = date_input.closest('form');
        var date_value = date_input.val().trim();
        var guides_input = form.find('.joGuidesDDL');
        guides_input.attr('disabled', 'disabled');
        if (date_value) {
            $.post('/guides/available', {'day': date_value, 'job_id': job_id})
                .done(function (data) {
                    if (data.guides) {
                        guides_input.select2('destroy');
                        guides_input.find('option').remove();
                        guides_input.append('<option value="">Select Guide</option>');
                        for (var i = 0; i < data.guides.length; i++) {
                            var guide = data.guides[i];
                            guides_input.append('<option value="' + guide.id + '" data-phone="' + guide.phone + '" data-languages="' + guide.languages_str + '">' + guide.name + '</option>');
                        }
                        guides_input.select2();
                    }
                })
                .fail(function (err) {
                    console.log(err);
                });

            form.find('.joGuidesDDL, .joCitiesDDL, .joVisitsDDL').removeAttr("disabled");
        }
    });

    $(document).on("change", "#Tour-Guide .joCitiesDDL", function () {
        var cities_input = $(this);
        var form = cities_input.closest('form');
        var city_id = cities_input.val().trim();
        var sights_input = form.find('.joVisitsDDL');
        sights_input.attr('disabled', 'disabled');
        if (city_id) {
            $.post('/sightseeings/search-by-city', {'city_id': city_id})
                .done(function (data) {
                    if (data.sightseeings) {
                        sights_input.select2('destroy');
                        sights_input.find('option').remove();
                        sights_input.append('<option value="">Select Visits(SightSeeing)</option>');
                        for (var i = 0; i < data.sightseeings.length; i++) {
                            var sight = data.sightseeings[i];
                            sights_input.append('<option value="' + sight.id + '" >' + sight.name + '</option>');
                        }
                        sights_input.select2();
                    }
                })
                .fail(function (err) {
                    console.log(err);
                });

            sights_input.removeAttr("disabled");
        }
    });

    $(document).on("change", "#Tour-Guide .joGuidesDDL", function () {
        var guide_input = $(this);
        var form = guide_input.closest('form');
        var guide_id = guide_input.val().trim();
        var lang_input = form.find('.joGLanguages');
        var phone_input = form.find('.mob_no');
        if (guide_id) {
            lang_input.val(guide_input.find('option[value="' + guide_id + '"]').attr('data-languages'));
            phone_input.val(guide_input.find('option[value="' + guide_id + '"]').attr('data-phone'));
        } else {
            lang_input.val("");
            phone_input.val("");
        }
    });

    $('#checkbox-fill-Router').change(function () {
        if ($(this).is(':checked')) {
            $('#RouterDetails').removeClass('d-none');
            $('#RouterDetails [name="router_id"]').attr('required', 'required');
            $('#RouterDetails [name="days_count"]').attr('required', 'required');
        } else {
            $('#RouterDetails').addClass('d-none');
            $('#RouterDetails [name="router_id"]').removeAttr('required');
            $('#RouterDetails [name="days_count"]').removeAttr('required');
        }
    });

    $('#checkbox-fill-Service-Conciergerie').change(function () {
        if ($(this).is(':checked')) {
            $('#ServiceDetails').removeClass('d-none');
            $('#ServiceDetails [name="concierge_emp_id"]').attr('required', 'required');
        } else {
            $('#ServiceDetails').addClass('d-none');
            $('#ServiceDetails [name="concierge_emp_id"]').removeAttr('required');
        }
    });

    $('#checkbox-fill-Travel-Visa').change(function () {
        if ($(this).is(':checked')) {
            $('#VisaDetails').removeClass('d-none');
            $('#VisaDetails [name="visa_id"]').attr('required', 'required');
            $('#VisaDetails [name="visas_count"]').attr('required', 'required');
        } else {
            $('#VisaDetails').addClass('d-none');
            $('#VisaDetails [name="visa_id"]').removeAttr('required');
            $('#VisaDetails [name="visas_count"]').removeAttr('required');
        }
    });

    $('#checkbox-fill-Gift').change(function () {
        if ($(this).is(':checked')) {
            $('#GiftDetails').removeClass('d-none');
            $('#GiftDetails .joGiftsDDL').attr('required', 'required');
            $('#GiftDetails .Gifts-Count').attr('required', 'required');
        } else {
            $('#GiftDetails').addClass('d-none');
            $('#GiftDetails .joGiftsDDL').removeAttr('required');
            $('#GiftDetails .Gifts-Count').removeAttr('required');
        }
    });

    $(document).on("change", ".joHCitiesDDL", function () {
        var cities_select = $(this);
        var form = cities_select.closest('form');
        var hotels_select = form.find('.joHotelsDDL');
        var valueHCities = cities_select.val();
        resetAccommodationForm(cities_select, cities_select);
        if (valueHCities !== "") {
            $.post('/hotels/search-by-city', {city_id: valueHCities})
                .done(function (data) {
                    if (data && data.hotels && data.hotels.length) {
                        $("option", hotels_select).remove();
                        hotels_select.append('<option value="">Hotel Name *</option>');
                        for (var i = 0; i < data.hotels.length; i++) {
                            hotels_select.append('<option value="' + data.hotels[i].id + '">' + data.hotels[i].name + '</option>');
                        }
                        hotels_select.removeAttr("disabled");
                    } else {
                        $("option", hotels_select).remove();
                        hotels_select.append('<option value="">Hotel Name *</option>');
                        hotels_select.attr("disabled", "disabled");
                        resetAccommodationForm(cities_select, cities_select);
                        // cities_select.val(valueHCities);
                    }
                });
        } else {
            resetAccommodationForm(cities_select);
        }
    });

    $(document).on("change", ".joHotelsDDL", function () {
        let hotels_select = $(this);
        let acc_item = hotels_select.closest('.accommodation-item');
        let valueHotels = hotels_select.val();
        let views_input = acc_item.find('.joRoomViewsDDL');
        let categories_input = acc_item.find('.joRoomCategoriesDDL');
        acc_item.find('.form_err').remove();
        if (valueHotels !== "") {
            $.post('/rooms/get-available-rooms', {hotel_id: valueHotels})
                .done(function (data) {
                    if (data && data.views.length && data.categories.length) {
                        views_input.find("option[value!='']").remove();
                        categories_input.find("option[value!='']").remove();
                        for (var i = 0; i < data.views.length; i++) {
                            views_input.append('<option value="' + data.views[i] + '">' + data.views[i] + '</option>');
                        }
                        for (var i = 0; i < data.categories.length; i++) {
                            categories_input.append('<option value="' + data.categories[i] + '">' + data.categories[i] + '</option>');
                        }
                        categories_input.removeAttr("disabled");
                        views_input.removeAttr("disabled");
                        hotels_select.closest('form').find('.joRoomTypesDDL, .joMealPlansDDL, .joSituationDDL, .date-Valid-From, .date-Valid-To, .HotelPaymentDate, .HotelVoucherDate').val("").trigger("change").attr("disabled", "disabled");
                        acc_item.find('.room_prices').html("");
                    } else {
                        let html = '<h6 class="text-danger form_err" style="text-align: center;">No rooms available in this hotel and ny selected data won\'t be saved. Please contact the admin.</h6>';
                        acc_item.prepend(html);
                        views_input.find("option[value!='']").remove();
                        categories_input.find("option[value!='']").remove();
                        // views_input.attr("disabled", "disabled");
                        // categories_input.attr("disabled", "disabled");
                        hotels_select.closest('form').find('.joRoomTypesDDL, .joRoomViewsDDL, .joRoomCategoriesDDL, .joMealPlansDDL, .joSituationDDL, .date-Valid-From, .date-Valid-To, .HotelPaymentDate, .HotelVoucherDate').val("").trigger("change").attr("disabled", "disabled");

                        acc_item.find('.room_prices').html("");
                    }
                })
                .fail(function (err) {
                    console.log(err);
                    let html = '<h6 class="text-danger form_err" style="text-align: center;">Server Error!</h6>';
                    acc_item.prepend(html);
                    hotels_select.closest('form').find('.joRoomTypesDDL, .joRoomViewsDDL, .joRoomCategoriesDDL, .joMealPlansDDL, .joSituationDDL, .date-Valid-From, .date-Valid-To, .HotelPaymentDate, .HotelVoucherDate').val("").trigger("change").attr("disabled", "disabled");
                    acc_item.find('.room_prices').html("");
                });
        } else {
            hotels_select.closest('form').find('.joRoomTypesDDL, .joRoomViewsDDL, .joRoomCategoriesDDL, .joMealPlansDDL, .joSituationDDL, .date-Valid-From, .date-Valid-To, .HotelPaymentDate, .HotelVoucherDate').val("").trigger("change").attr("disabled", "disabled");
            acc_item.find('.room_prices').html("");
        }
    });

    $(document).on("change", ".joRoomViewsDDL, .joRoomCategoriesDDL", function () {
        let form = $(this).closest('form');
        let valueViews = form.find(".joRoomViewsDDL").val().trim();
        let valueCategories = form.find(".joRoomCategoriesDDL").val().trim();
        if (valueViews && valueCategories) {
            form.find(".joRoomTypesDDL, .joMealPlansDDL, .joSituationDDL").removeAttr('disabled');
            checkRoomIsAvailable(form);
        } else {
            form.find(".joRoomTypesDDL, .joMealPlansDDL, .date-Valid-From, .date-Valid-To, .joSituationDDL, .HotelPaymentDate, .HotelVoucherDate").val("").trigger("change").attr('disabled', 'disabled');
            form.find('.room_prices').html("");
        }
    });

    $(document).on("change", ".joRoomTypesDDL, .joMealPlansDDL, .joSituationDDL", function () {
        var form = $(this).closest('form');
        var valueRoomTypes = form.find(".joRoomTypesDDL").val(),
            valueMeal = form.find(".joMealPlansDDL").val(),
            valueSituation = form.find(".joSituationDDL").val();
        if (valueRoomTypes !== "" !== "" && valueMeal !== "" && valueSituation !== "") {
            form.find('.date-Valid-From, .date-Valid-To, .HotelPaymentDate, .HotelVoucherDate').removeAttr("disabled");
            checkRoomIsAvailable(form);
        } else {
            form.find('.date-Valid-From, .date-Valid-To, .HotelPaymentDate, .HotelVoucherDate').attr("disabled", "disabled");
            form.find('.room_prices').html("");
        }
    });

    $(document).on("keyup", ".FlightNo", delay(function (e) {
        var flight_no_input = $(this);
        var flight_no = flight_no_input.val().trim();
        let departure_date = $('#Departure-date-job').val();
        let arrival_date = $('#Arrival-date-job').val();
        var form = flight_no_input.closest('form');
        if (flight_no) {
            $.post('/flights/search', {
                'flight_no': flight_no,
                'departure_date': departure_date,
                'arrival_date': arrival_date
            })
                .done(function (data) {
                    if (data.flight) {
                        form.find('.form_err').remove();
                        var flight = data.flight;
                        form.find('.flight_id').val(flight.id);
                        form.find('.ReferenceNo').val(flight.reference);
                        form.find('.flight-date').val(flight.date);
                        form.find('.joDepartureBy').val(flight.airport_from_formatted.text);
                        form.find('.Time-From').val(flight.depart_at);
                        form.find('.joArrivalBy').val(flight.airport_to_formatted.text);
                        form.find('.Time-To').val(flight.arrive_at);
                        form.find('.No-of-Seats').val(flight.seats_count);
                        form.find('.No-of-Seats').val(flight.seats_count);
                        form.find('.joStatusDDL').val(flight.status);
                    } else {
                        form.find('.form_err').remove();
                        var html = '<h6 class="text-danger form_err" style="text-align: center;">Flight doesn\'t exist and will not be added to the file. Please contact the admin.</h6>';
                        form.prepend(html);
                        resetFlightForm(form);
                        form.find('.flight_id').val('');
                        flight_no_input.val(flight_no);
                    }
                })
                .fail(function (err) {
                    console.log(err);
                    form.find('.form_err').remove();
                    var html = '<h6 class="text-danger form_err" style="text-align: center;">Server Error</h6>';
                    form.prepend(html);
                    resetFlightForm(form);
                    form.find('.flight_id').val('');
                    flight_no_input.val(flight_no);
                });

        } else {
            form.find('.form_err').remove();
            resetFlightForm(form);
            form.find('.flight_id').val('');
        }
    }, 500));

    $(document).on("change", ".checkbox-fill-SightSeeing", function () {
        var form = $(this).closest('form');
        if ($(this).is(':checked')) {
            form.find('.SightSeeingDetails').removeClass('d-none');
        } else {
            form.find('.SightSeeingDetails').addClass('d-none');
        }
    });

    $(document).on("change", ".checkbox-fill-Visit-Night", function () {
        var form = $(this).closest('form');
        if ($(this).is(':checked')) {
            form.find('.Visit-Night-Details').removeClass('d-none');
        } else {
            form.find('.Visit-Night-Details').addClass('d-none');
        }
    });

    $(document).on("change", ".checkbox-fill-Light-Show", function () {
        var form = $(this).closest('form');
        if ($(this).is(':checked')) {
            form.find('.SoundLightShowDetails').removeClass('d-none');
        } else {
            form.find('.SoundLightShowDetails').addClass('d-none');
        }
    });

    $(document).on("change", ".checkbox-fill-Lift", function () {
        var form = $(this).closest('form');
        if ($(this).is(':checked')) {
            form.find('.LiftDetails').removeClass('d-none');
        } else {
            form.find('.LiftDetails').addClass('d-none');
        }
    });

    $(document).on("change", ".checkbox-fill-Train-Ticket", function () {
        var form = $(this).closest('form');
        if ($(this).is(':checked')) {
            form.find('.TrainTicketDetails').removeClass('d-none');
        } else {
            form.find('.TrainTicketDetails').addClass('d-none');
        }
    });

    $(document).on("change", ".checkbox-fill-Nile-Curise", function () {
        var form = $(this).closest('form');
        if ($(this).is(':checked')) {
            form.find('.NileCuriseDetails').removeClass('d-none');
        } else {
            form.find('.NileCuriseDetails').addClass('d-none');
        }
    });

    $(document).on("change", "#Program .joCitiesDDL", function () {
        var program_city_input = $(this);
        var form = program_city_input.closest('form');
        var program_city_id = program_city_input.val().trim();
        if (program_city_id) {
            searchSightseeingsByCityInProgram(program_city_id, form);
            searchVBNightsByCityInProgram(program_city_id, form);
        } else {
            $(this).find('.sightseeing_item').each(function () {
                resetSightseeingItem($(this));
            });
            $(this).find('.vbnight_item').each(function () {
                resetSightseeingItem($(this));
            });
        }
    });

    $(document).on("change", "#Program .program_date", function () {
        var program_date_input = $(this);
        var form = program_date_input.closest('form');
        var date = program_date_input.val().trim();
        if (date) {
            searchSLShowsLangsByCityAndDate(form.find('.SoundLightShowDetails .place'));
        } else {
            resetSLShowItem(form.find('.SoundLightShowDetails'));
        }
    });

    $(document).on("change", "#Program .joSightSeeingsDDL", function () {
        var sights_input = $(this);
        var form = sights_input.closest('.sightseeing_item');
        calculateSightInProgram(form);
    });

    $(document).on("change", "#Program .joVisitsNightDDL", function () {
        var vbnight_input = $(this);
        var form = vbnight_input.closest('.vbnight_item');
        calculateVBNightInProgram(form);
    });

    $(document).on("keyup", ".TrainTicketDetails .Train-Number", delay(function (e) {
        var input = $(this);
        var form = input.closest('.train-item');
        searchTrains(form);
    }, 500));

    $(document).on("change", ".TrainTicketDetails .Train-Departure-date", delay(function (e) {
        var input = $(this);
        var form = input.closest('.train-item');
        searchTrains(form);
    }, 500));


    $(document).on("change", "#Program .place", function () {
        var place_input = $(this);
        searchSLShowsLangsByCityAndDate(place_input);
    });

    $(document).on("change", "#Program .SoundLightShowDetails .joLanguagesDDL", function () {
        var language_input = $(this);
        searchSLShowsByCityLangAndDate(language_input);
    });

    $(document).on("change", "#Program .SoundLightShowDetails .time", function () {
        var time_input = $(this);
        var slshow_item = time_input.closest('.SoundLightShowDetails');
        calculateSLShowInProgram(slshow_item);
    });

    $(document).on("change", ".NileCuriseDetails .joNileCruisesCitiesDDL", function () {
        var cruise_city_input = $(this);
        var cruise_item = cruise_city_input.closest('.cruise-item');
        var city_id = cruise_city_input.val().trim();
        cruise_item.find('select:not(".joNileCruisesCitiesDDL"),input:not([type=\"checkbox\"],.item_type)').val("").trigger('change').attr('disabled', 'disabled');
        if (city_id) {
            searchCruisesByCityInProgram(city_id, cruise_item);
        } else {
            cruise_item.find('select:not(".joNileCruisesCitiesDDL"),input:not([type=\"checkbox\"],.item_type)').val("").trigger('change').attr('disabled', 'disabled');
        }
    });

    $(document).on("change", ".NileCuriseDetails .joNileCruisesDDL", function () {
        var cruise_name_input = $(this);
        var cruise_item = cruise_name_input.closest('.cruise-item');
        var city_input = cruise_item.find('.joNileCruisesCitiesDDL');
        var cruise_name = cruise_name_input.val().trim();
        var city_id = city_input.val().trim();
        let arrival_date = $("#Arrival-date-job").val();
        let departure_date = $("#Departure-date-job").val();
        cruise_item.find('select:not(".joNileCruisesDDL,.joNileCruisesCitiesDDL"),input:not([type=\"checkbox\"],.item_type)').val("").trigger("change").attr('disabled', 'disabled');

        if (cruise_name && city_id && arrival_date && departure_date) {
            $.post('/nile-cruises/get-cruise-by-name-date-city', {
                'city_id': city_id,
                'arrival_date': arrival_date,
                'departure_date': departure_date,
                'name': cruise_name
            })
                .done(function (data) {
                    if (data.dates.length) {
                        var available_dates_input = cruise_item.find('.nile_cruise_date');
                        available_dates_input.select2('destroy');
                        available_dates_input.find('option[value!=""]').remove();
                        for (var i = 0; i < data.dates.length; i++) {
                            var cruise = data.dates[i];
                            available_dates_input.append('<option value="' + cruise.date + '" data-cruise-ids="' + cruise.cruise_ids + '">' + cruise.date + '</option>');
                            // available_dates_input.append('<option value="' + cruise.id + '" data-cruise-id="' + cruise.id + '" data-from-city="' + cruise.from_city.name + '" data-to-city="' + cruise.to_city.name + '" data-sight-price="' + cruise.sight_sell_price + '" data-private-guide-price="' + cruise.private_guide_sell_price + '" data-boat-guide-price="' + cruise.boat_guide_sell_price + '" data-child-price="' + cruise.child_sell_price + '" data-sgl-adult-price="' + cruise.sgl_sell_price + '" data-dbl-adult-price="' + cruise.dbl_sell_price + '" data-trpl-adult-price="' + cruise.trpl_sell_price + '"  data-currency="' + cruise.currency_str + '" data-cruise-ids="'+data.dates[cruise.dates].join(',')+'">' + cruise.dates + '</option>');
                        }
                        available_dates_input.select2();
                        available_dates_input.removeAttr('disabled');
                    } else {
                        // cruise_item.find('select:not(".joNileCruisesDDL"),input:not([type=\"checkbox\"],.item_type)').val("").trigger('change').attr('disabled', 'disabled');
                    }
                })
                .fail(function (err) {
                    console.log(err);
                });
        } else {
            // cruise_item.find('select:not(".joNileCruisesDDL"),input:not([type=\"checkbox\"],.item_type)').val("").trigger('change').attr('disabled', 'disabled');
        }
    });

    $(document).on("change", ".NileCuriseDetails .nile_cruise_date", function () {
        var cruise_dates_input = $(this);
        var cruise_item = cruise_dates_input.closest('.cruise-item');
        var program = cruise_item.closest('form');
        var date = cruise_dates_input.val().trim();
        var cruise_ids = cruise_dates_input.find('option[value="' + date + '"]').attr('data-cruise-ids');
        let cabin_type_select = cruise_item.find('.cabin_type');
        let room_type_select = cruise_item.find('.room_type');
        let deck_type_select = cruise_item.find('.deck_type');
        let including_sightseeing_select = cruise_item.find('.including_sightseeing');

        if (date && cruise_ids) {
            //search by ids
            $.post('/nile-cruises/get-cruises-by-ids', {cruise_ids: cruise_ids})
                .done(function (data) {
                    cabin_type_select.find('option[value != ""]').remove();
                    room_type_select.find('option[value != ""]').remove();
                    deck_type_select.find('option[value != ""]').remove();
                    including_sightseeing_select.find('option[value != ""]').remove();
                    if (data.cruises.length) {
                        for (var i = 0; i < data.cabin_type.length; i++) {
                            cabin_type_select.append('<option value="' + data.cabin_type[i] + '">' + data.cabin_type[i] + '</option>');
                        }
                        for (var i = 0; i < data.room_type.length; i++) {
                            room_type_select.append('<option value="' + data.room_type[i].key + '">' + data.room_type[i].value + '</option>');
                        }
                        for (var i = 0; i < data.deck_type.length; i++) {
                            deck_type_select.append('<option value="' + data.deck_type[i] + '">' + data.deck_type[i] + '</option>');
                        }
                        for (var i = 0; i < data.including_sightseeing.length; i++) {
                            including_sightseeing_select.append('<option value="' + data.including_sightseeing[i].key + '">' + data.including_sightseeing[i].value + '</option>');
                        }
                    }
                    cabin_type_select.select2();
                    cabin_type_select.removeAttr('disabled');
                    room_type_select.select2();
                    room_type_select.removeAttr('disabled');
                    deck_type_select.select2();
                    deck_type_select.removeAttr('disabled');
                    including_sightseeing_select.select2();
                    including_sightseeing_select.removeAttr('disabled');
                })
                .fail(function (err) {

                });

            //comment all the lines below
            // var selected_option = cruise_dates_input.find('option:selected');
            // cruise_item.find('.city_from').val(selected_option.attr('data-from-city'));
            // cruise_item.find('.city_to').val(selected_option.attr('data-to-city'));
            // cruise_item.find('.cabin_item select').val("").trigger('change').removeAttr('disabled');
            // cruise_item.find('.item_id').val(selected_option.attr('data-cruise-id'));
            // var currency = selected_option.attr('data-currency');
            // cruise_item.find('.adult_sgl_price').val(selected_option.attr('data-sgl-adult-price') + " " + currency);
            // cruise_item.find('.adult_dbl_price').val(selected_option.attr('data-dbl-adult-price') + " " + currency);
            // cruise_item.find('.child_price').val(selected_option.attr('data-child-price') + " " + currency);
        } else {
            cabin_type_select.attr('disabled', 'disabled');
            room_type_select.attr('disabled', 'disabled');
            deck_type_select.attr('disabled', 'disabled');
            including_sightseeing_select.attr('disabled', 'disabled');
        }
    });

    $(document).on("change", ".cabin_type, .room_type, .deck_type, .including_sightseeing", function () {
        var cruise_item = $(this).closest('.cruise-item');
        searchForCruiseByOptions(cruise_item);
    });

    function searchForCruiseByOptions(cruise_item) {
        let cruise_dates_input = cruise_item.find('.nile_cruise_date');
        var date = cruise_dates_input.val().trim();
        let cruise_ids = cruise_dates_input.find('option[value="' + date + '"]').attr('data-cruise-ids');
        let cabin_type_select = cruise_item.find('.cabin_type');
        let room_type_select = cruise_item.find('.room_type');
        let deck_type_select = cruise_item.find('.deck_type');
        let including_sightseeing_select = cruise_item.find('.including_sightseeing');

        let cabin_type = cabin_type_select.val();
        let room_type = room_type_select.val();
        let deck_type = deck_type_select.val();
        let including_sightseeing = including_sightseeing_select.val();

        let data = {cruise_ids: cruise_ids};
        let options_count = 0;
        if (cabin_type !== '') {
            data.cabin_type = cabin_type;
            options_count++;
        }
        if (room_type !== '') {
            data.room_type = room_type;
            options_count++;
        }
        if (deck_type !== '') {
            data.deck_type = deck_type;
            options_count++;
        }
        if (including_sightseeing !== '') {
            data.including_sightseeing = including_sightseeing;
            options_count++;
        }

        $.post('/nile-cruises/get-cruises-by-ids', data)
            .done(function (response) {
                if (response.cruises.length) {
                    if (options_count == 4) {
                        //fill to city field
                        //open cabin rows
                        //add input class cruise_info with data-prices

                        cruise_item.find('.cruise_info').remove();
                        let cruise = response.cruises[0];
                        cruise_item.append('<div class="d-none cruise_info" value="' + cruise.id + '" data-cruise-id="' + cruise.id + '" data-from-city="' + cruise.from_city.name + '" data-to-city="' + cruise.to_city.name + '" data-private-guide-price="' + cruise.private_guide_sell_price + '" data-boat-guide-price="' + cruise.boat_guide_sell_price + '" data-child-price="' + cruise.child_sell_price + '" data-sgl-adult-price="' + cruise.sgl_sell_price + '" data-dbl-adult-price="' + cruise.dbl_sell_price + '" data-trpl-adult-price="' + cruise.trpl_sell_price + '"  data-adult_sgl_currency="' + cruise.sgl_sell_currency + '" data-adult_dbl_currency="' + cruise.dbl_sell_currency + '" data-adult_trpl_currency="' + cruise.trpl_sell_currency + '" data-child_sgl_currency="' + cruise.child_sell_currency + '" data-private_guide_currency="' + cruise.private_guide_sell_currency + '" data-boat_guide_currency="' + cruise.boat_guide_sell_currency + '" ></div>');
                        let cuise_info = cruise_item.find('.cruise_info');

                        cruise_item.find('.city_to').val(cruise.to_city.name);
                        cruise_item.find('.cabin_item select').val("").trigger('change').removeAttr('disabled');
                        cruise_item.find('.item_id').val(cruise.id);
                        var adult_sgl_currency = cruise.sgl_sell_currency;
                        var adult_dbl_currency = cruise.dbl_sell_currency;
                        var adult_trpl_currency = cruise.trpl_sell_currency;
                        var child_sgl_currency = cruise.child_sell_currency;
                        var private_guide_currency = cruise.private_guide_sell_currency;
                        var boat_guide_currency = cruise.boat_guide_sell_currency;
                        cruise_item.find('.adult_price').val(cuise_info.attr('data-sgl-adult-price') + " " + adult_sgl_currency);
                        cruise_item.find('.child_price').val(cuise_info.attr('data-child-price') + " " + child_sgl_currency);
                    } else {
                        cruise_item.find('.cruise_info').remove();
                        cruise_item.find('.city_to').val("");
                        //disable cabin rows

                        if (!data.hasOwnProperty('cabin_type')) {
                            cabin_type_select.find('option[value != ""]').remove();
                            for (var i = 0; i < response.cabin_type.length; i++) {
                                cabin_type_select.append('<option value="' + response.cabin_type[i] + '">' + response.cabin_type[i] + '</option>');
                            }
                            cabin_type_select.select2();
                        }
                        if (!data.hasOwnProperty('room_type')) {
                            room_type_select.find('option[value != ""]').remove();
                            for (var i = 0; i < response.room_type.length; i++) {
                                room_type_select.append('<option value="' + response.room_type[i].key + '">' + response.room_type[i].value + '</option>');
                            }
                            room_type_select.select2();
                        }
                        if (!data.hasOwnProperty('deck_type')) {
                            deck_type_select.find('option[value != ""]').remove();
                            for (var i = 0; i < response.deck_type.length; i++) {
                                deck_type_select.append('<option value="' + response.deck_type[i] + '">' + response.deck_type[i] + '</option>');
                            }
                            deck_type_select.select2();
                        }
                        if (!data.hasOwnProperty('including_sightseeing')) {
                            including_sightseeing_select.find('option[value != ""]').remove();
                            for (var i = 0; i < response.including_sightseeing.length; i++) {
                                including_sightseeing_select.append('<option value="' + response.including_sightseeing[i].key + '">' + response.including_sightseeing[i].value + '</option>');
                            }
                            including_sightseeing_select.select2();
                        }
                    }
                }
            })
            .fail(function (err) {

            });
    }

    $(document).on("change", ".NileCuriseDetails .cabin_item .cruise_adults_count", function () {
        var cruise_item = $(this).closest('.cruise-item');
        calculateTotalCruise(cruise_item);
    });

    $(document).on("change", ".NileCuriseDetails .cabin_item .cruise_children_count", function () {
        var cruise_item = $(this).closest('.cruise-item');
        calculateTotalCruise(cruise_item);
    });

    $(document).on("change", ".NileCuriseDetails .cabin_item .joTypesRoomDDL", function () {
        var cruise_item = $(this).closest('.cruise-item');
        calculateTotalCruise(cruise_item);
    });

    $(document).on("change", ".NileCuriseDetails .checkbox-Guide-Boat", function () {
        var cruise_item = $(this).closest('.cruise-item');
        calculateTotalCruise(cruise_item);
    });

    $(document).on("change", ".NileCuriseDetails .checkbox-Private-Guide", function () {
        var cruise_item = $(this).closest('.cruise-item');
        calculateTotalCruise(cruise_item);
    });
});

function checkRoomIsAvailable(form) {
    let valueRoomTypes = form.find(".joRoomTypesDDL").val().trim(),
        valueViews = form.find(".joRoomViewsDDL").val().trim(),
        valueCategories = form.find(".joRoomCategoriesDDL").val().trim(),
        valueMeal = form.find(".joMealPlansDDL").val().trim(),
        check_in = form.find(".date-Valid-From").val().trim(),
        check_out = form.find(".date-Valid-To").val().trim(),
        hotel_id = form.find(".joHotelsDDL").val().trim();
    if (valueRoomTypes && valueCategories && valueViews && valueMeal && check_in && check_out && hotel_id) {
        $.ajax({
            url: "/rooms/is-available",
            type: 'POST',
            data: form.serialize(),
        })
            .done(function (data) {
                if (!data || !data.rooms || !data.rooms.length) {
                    form.find('.form_err').remove();
                    var html = '<h6 class="text-danger form_err" style="text-align: center;">This room is not available or not found. Please contact the admin.</h6>';
                    form.prepend(html);
                    form.find('.CancelationFees').val("Cancellation Fees");
                    form.find('.TimePreiod').val("Before 1 day");
                    form.find('.room_id').remove();
                    form.find('.room_prices').html("");
                } else {
                    form.find('.form_err').remove();
                    var room = data.rooms[0];
                    form.find('.room_id').remove();
                    form.append('<input type="hidden" class="room_id" value="' + room.id + '">');

                    let room_prices_container = form.find('.room_prices');
                    let room_prices_content = '<div class="col-md-6"><table class="table table-bordered"><tr><th>Source</th><th>Price</th></tr>';
                    room_prices_content += '<tr><td>VDM</td><td>' + room.details.base_rate + ' ' + room.currency + '</td>';
                    for (source in data.other_options) {
                        let price = data.other_options[source];
                        if (price != 'Not available') {
                            price += ' ' + room.currency;
                        }
                        room_prices_content += '<tr><td>' + source + '</td><td>' + price + '</td>';
                    }
                    room_prices_content += '</table></div>';
                    room_prices_container.html(room_prices_content);
                    room_prices_container.removeClass('d-none');

                    if (room.cancellations && room.cancellations.length) {
                        var cancellation = room.cancellations[0];
                        var value = cancellation.value;
                        if (cancellation.type != 2) {//percentage
                            value += '%';
                        } else {
                            value += ' ' + room.currency;
                        }
                        form.find('.CancelationFees').val(value);
                        form.find('.TimePreiod').val("Before " + cancellation.time + " day(s)");
                    } else {
                        form.find('.CancelationFees').val("Cancellation Fees");
                        form.find('.TimePreiod').val("Before 1 day");
                    }
                }
            })
            .fail(function (err) {
                console.log(err);
                form.find('.form_err').remove();
                var html = '<h6 class="text-danger form_err" style="text-align: center;">Server Error</h6>';
                form.prepend(html);
                form.find('.room_prices').html("");
            });
    }
}

function resetSLShowItem(item) {
    item.find('input[type="text"]').val("");
    item.find('.item_id').val("");
    item.find('select').val("").trigger('change');
}

function searchSLShowsLangsByCityAndDate(place_input) {
    var program_item = place_input.closest('.program_item');
    var slshow_item = place_input.closest('.SoundLightShowDetails');
    slshow_item.find('.adult_price,.child_price,.total_price,.item_id').val("");
    var language_input = slshow_item.find('.joLanguagesDDL');
    var time_input = slshow_item.find('.time');
    var date = program_item.find('.program_date').val().trim();
    var place = place_input.val().trim();
    slshow_item.find('.time,.joLanguagesDDL').attr('disabled', 'disabled').val('').trigger('change');
    language_input.find('option[value!=""]').remove();
    time_input.find('option[value!=""]').remove();
    if (date && place) {
        $.post('/slshows/get-langs-by-place-and-date', {'date': date, 'place': place})
            .done(function (data) {
                if (data && data.langs) {
                    for (var i = 0; i < data.langs.length; i++) {
                        var lang = data.langs[i];
                        language_input.append('<option value="' + lang.id + '">' + lang.lang + '</option>');
                    }
                }
                language_input.removeAttr('disabled');
            })
            .fail(function (err) {
                console.log(err);
            });
    }
}

function searchSLShowsByCityLangAndDate(language_input) {
    var program_item = language_input.closest('.program_item');
    var slshow_item = language_input.closest('.SoundLightShowDetails');
    slshow_item.find('.adult_price,.child_price,.total_price,.item_id').val("");
    var place_input = slshow_item.find('.place');
    var time_input = slshow_item.find('.time');
    var date = program_item.find('.program_date').val().trim();
    var language_id = language_input.val().trim();
    var place = place_input.val().trim();
    time_input.attr('disabled', 'disabled').val('').trigger('change');
    time_input.find('option[value!=""]').remove();
    if (date && place && language_id) {
        $.post('/slshows/get-times-by-lang-place-and-date', {'date': date, 'place': place, 'language_id': language_id})
            .done(function (data) {
                if (data && data.slshows) {
                    for (var i = 0; i < data.slshows.length; i++) {
                        var slshow = data.slshows[i];
                        time_input.append('<option value="' + slshow.id + '" data-adult-price="' + slshow.sell_price_adult_vat_exc + '" data-child-price="' + slshow.sell_price_child_vat_exc + '" data-adult_sell_currency="' + slshow.adult_sell_currency + '" data-child_sell_currency="' + slshow.child_sell_currency + '">' + slshow.time + '</option>');
                    }
                }
                time_input.removeAttr('disabled');
            })
            .fail(function (err) {
                console.log(err);
            });
    }
}

function resetTrainItem(item) {
    item.find('input[type="text"]:not(".Train-Departure-date")').val("");
    item.find('.train_id').val("");
    item.find('.adult_price').removeAttr('data-sgl-price');
    item.find('.adult_price').removeAttr('data-currency');
    item.find('select').val("").trigger('change');
}

function searchTrains(form) {
    var number_input = form.find('.Train-Number');
    var train_number = number_input.val().trim();
    resetTrainItem(form);
    if (train_number) {
        number_input.val(train_number);
        var date = form.find('.Train-Departure-date').val().trim();
        if (date) {
            $.post('/train-tickets/search', {'number': train_number, 'date': date})
                .done(function (data) {
                    if (data.train_ticket) {
                        var train = data.train_ticket;
                        form.find('.item_type').val("train");
                        form.find('.train_id').val(train.id);
                        form.find('.Train-Type').val(train.type);
                        form.find('.City-From').val(train.from_station.name);
                        form.find('.City-To').val(train.to_station.name);
                        form.find('.Train-Departure-date').val(train.depart_at_date);
                        form.find('.Train-Departure-Time').val(train.depart_at_time);
                        form.find('.Train-Arrival-date').val(train.arrive_at_date);
                        form.find('.Train-Arrival-Time').val(train.arrive_at_time);
                        form.find('.Wagon-Number').val(train.wagon_no);
                        form.find('.Seat-Number').val(train.seat_no);
                        form.find('.Train-Class').val(train.class);
                        form.find('.adult_price').val(train.sgl_sell_price + " " + train.sgl_sell_currency);
                        form.find('.adult_price').attr('data-sgl-price', train.sgl_sell_price);
                        form.find('.adult_price').attr('data-currency', train.sgl_sell_currency);
                        calculateTrainInProgram(form);
                    }
                })
                .fail(function (err) {
                    console.log(err);
                });
        }
    } else {
        resetTrainItem(form);
    }
}

function calculateTrainInProgram(form) {
    if (form.find('.adult_price').val()) {
        var price = form.find('.adult_price').attr('data-sgl-price');
        var currency = form.find('.adult_price').attr('data-currency');
        if (price) {
            var total_price = (parseInt($('select[name="adults_count"]').val()) + parseInt($('select[name="children_count"]').val())) * price;
            form.find('.total_price').val(total_price + " " + currency);
        }
    } else {
        form.find('.total_price').val("");
        form.find('.adult_price').removeAttr("data-sgl-price");
        form.find('.adult_price').removeAttr("data-currency");
    }
}

function resetSightseeingItem(item) {
    item.find('input[type="text"]').val("");
    item.find('.item_id').val("");
    item.find('select').val("").trigger('change');
}

function searchSightseeingsByCityInProgram(city_id, form) {
    form.find('.sightseeing_item').each(function () {
        resetSightseeingItem($(this));
    });
    $.post('/sightseeings/search-by-city', {'city_id': city_id})
        .done(function (data) {
            if (data.sightseeings) {
                var sights_input = form.find('.joSightSeeingsDDL');
                sights_input.select2('destroy');
                sights_input.find('option[value!=""]').remove();
                // sights_input.append('<option value="">Select SightSeeing</option>');
                for (var i = 0; i < data.sightseeings.length; i++) {
                    var sight = data.sightseeings[i];
                    sights_input.append('<option value="' + sight.id + '" data-adult-price="' + sight.sell_price_adult_vat_exc + '" data-child-price="' + sight.sell_price_child_vat_exc + '" data-sell_price_adult_currency="' + sight.sell_price_adult_currency + '" data-sell_price_child_currency="' + sight.sell_price_child_currency + '">' + sight.name + '</option>');
                }
                sights_input.select2();
            }
        })
        .fail(function (err) {
            console.log(err);
        });
}

function searchVBNightsByCityInProgram(city_id, form) {
    form.find('.vbnight_item').each(function () {
        resetSightseeingItem($(this));
    });
    $.post('/vbnights/search-by-city', {'city_id': city_id})
        .done(function (data) {
            if (data.vbnights) {
                var vbnights_input = form.find('.joVisitsNightDDL');
                vbnights_input.select2('destroy');
                vbnights_input.find('option[value!=""]').remove();
                // vbnights_input.append('<option value="">Select Visit by Night</option>');
                for (var i = 0; i < data.vbnights.length; i++) {
                    var vbnight = data.vbnights[i];
                    vbnights_input.append('<option value="' + vbnight.id + '" data-adult-price="' + vbnight.sell_price_adult_vat_exc + '" data-child-price="' + vbnight.sell_price_child_vat_exc + '" data-adult_sell_currency="' + vbnight.adult_sell_currency + '" data-child_sell_currency="' + vbnight.child_sell_currency + '">' + vbnight.name + '</option>');
                }
                vbnights_input.select2();
            }
        })
        .fail(function (err) {
            console.log(err);
        });
}

function resetCruiseItem(item) {
    item.find('input[type="text"]').val("");
    item.find('.item_id').val("");
    item.find('select').val("");
}

function searchCruisesByCityInProgram(city_id, cruise_item) {
    let arrival_date = $("#Arrival-date-job").val();
    let departure_date = $("#Departure-date-job").val();
    if (!arrival_date || !departure_date) {
        return false;
    }
    // resetCruiseItem(cruise_item);
    var cruises_input = cruise_item.find('.joNileCruisesDDL');
    $.post('/nile-cruises/get-names-by-date-city', {
        'city_id': city_id,
        'arrival_date': arrival_date,
        'departure_date': departure_date
    })
        .done(function (data) {
            cruise_item.find('select:not(".joNileCruisesCitiesDDL"),input:not([type=\"checkbox\"],.item_type)').val("").trigger('change').attr('disabled', 'disabled');
            cruises_input.select2('destroy');
            cruises_input.find('option[value!=""]').remove();
            if (data.cruises.length) {
                for (var i = 0; i < data.cruises.length; i++) {
                    var cruise = data.cruises[i];
                    cruises_input.append('<option value="' + cruise + '">' + cruise + '</option>');
                }
            }
            cruises_input.select2();
            cruises_input.removeAttr("disabled");
        })
        .fail(function (err) {
            console.log(err);
        });
}

function calculateTotalCruise(cruise_item) {
    var cruise_info_input = cruise_item.find('.cruise_info');
    if (cruise_info_input.length) {
        var total = 0;
        var adult_sgl_price = parseFloat(cruise_info_input.attr('data-sgl-adult-price'));
        var adult_dbl_price = parseFloat(cruise_info_input.attr('data-dbl-adult-price'));
        var adult_trpl_price = parseFloat(cruise_info_input.attr('data-trpl-adult-price'));
        var child_price = parseFloat(cruise_info_input.attr('data-child-price'));
        var adult_sgl_currency = cruise_info_input.attr('data-adult_sgl_currency');
        var adult_dbl_currency = cruise_info_input.attr('data-adult_dbl_currency');
        var adult_trpl_currency = cruise_info_input.attr('data-adult_trpl_currency');
        var child_currency = cruise_info_input.attr('data-child_sgl_currency');
        var total_adults_count = 0;
        var total_children_count = 0;
        var cabin_type = cruise_item.find('.room_type').val().trim();
        let currency = adult_sgl_currency;
        cruise_item.find('.cabin_item').each(function () {
            var cabin_item = $(this);
            var adults_count = parseInt(cabin_item.find('.cruise_adults_count').val().trim());
            var children_count = parseInt(cabin_item.find('.cruise_children_count').val().trim());
            var cabin_price = 0;

            if (cabin_type && !isNaN(children_count)) {
                total_children_count += children_count;
                cabin_price += (children_count * child_price);
            }
            if (cabin_type == 1 && !isNaN(adults_count)) {
                total_adults_count += adults_count;
                cabin_price += (adults_count * adult_sgl_price);
                currency = adult_sgl_currency;
                cruise_item.find('.adult_price').val(adult_sgl_price + " " + currency);
            } else if (cabin_type == 2 && !isNaN(adults_count)) {
                total_adults_count += adults_count;
                cabin_price += (adults_count * adult_dbl_price);
                currency = adult_dbl_currency;
                cruise_item.find('.adult_price').val(adult_dbl_price + " " + currency);
            } else if (cabin_type == 3 && !isNaN(adults_count)) {
                total_adults_count += adults_count;
                cabin_price += (adults_count * adult_trpl_price);
                currency = adult_trpl_currency;
                cruise_item.find('.adult_price').val(adult_trpl_price + " " + currency);
            }
            total += cabin_price;
        });

        if (cruise_item.find(".checkbox-Private-Guide").is(':checked')) {
            var private_guide_price = parseFloat(cruise_info_input.attr("data-private-guide-price"));
            if (!isNaN(private_guide_price)) {
                total += (private_guide_price);
            }
        }
        if (cruise_item.find(".checkbox-Guide-Boat").is(':checked')) {
            var boat_guide_price = parseFloat(cruise_info_input.attr("data-boat-guide-price"));
            if (!isNaN(boat_guide_price)) {
                total += (boat_guide_price);
            }
        }
        cruise_item.find('.total_price').val(total + " " + currency);
    }

}

function programFormSerialized() {
    var data = [];
    $("#Program form").each(function () {
        var form = $(this);
        var form_data = {};
        var program_date = form.find('.program_date').val().trim();
        var city_id = form.find('.joCitiesDDL').val().trim();
        if (program_date && city_id) {
            form_data.day = program_date;
            form_data.city_id = city_id;
            if (form.find('.program_row_id').length) {
                form_data.id = form.find('.program_row_id').val().trim();
            }
            form_data.items = [];
            form.find('.sightseeing_item').each(function () {
                var sight_item = $(this);
                if (sight_item.is(":visible")) {
                    var item = {};
                    item.item_type = sight_item.find('.item_type').val().trim();
                    item.item_id = sight_item.find('.joSightSeeingsDDL').val().trim();
                    item.time_from = sight_item.find('.Time-From').val().trim();
                    item.time_to = sight_item.find('.Time-To').val().trim();
                    if (item.item_id && item.item_type) {
                        form_data['items'].push(item);
                    }
                }
            });
            form.find('.vbnight_item').each(function () {
                var vbnight_item = $(this);
                if (vbnight_item.is(":visible")) {
                    var item = {};
                    item.item_type = vbnight_item.find('.item_type').val().trim();
                    item.item_id = vbnight_item.find('.joVisitsNightDDL').val().trim();
                    item.time_from = vbnight_item.find('.Time-From').val().trim();
                    item.time_to = vbnight_item.find('.Time-To').val().trim();
                    if (item.item_id && item.item_type) {
                        form_data['items'].push(item);
                    }
                }
            });
            form.find('.lift_item').each(function () {
                var lift_item = $(this);
                if (lift_item.is(":visible")) {
                    var item = {};
                    item.item_type = "lift";
                    item.item_id = 9999;
                    item.details = lift_item.find('.details').val().trim();
                    item.time_from = lift_item.find('.Time-From').val().trim();
                    if (item.details && item.details) {
                        form_data['items'].push(item);
                    }
                }
            });
            form.find('.SoundLightShowDetails').each(function () {
                var slshow_item = $(this);
                if (slshow_item.is(":visible")) {
                    var item = {};
                    item.item_type = slshow_item.find('.item_type').val().trim();
                    item.item_id = slshow_item.find('.item_id').val().trim();
                    if (item.item_id && item.item_type) {
                        form_data['items'].push(item);
                    }
                }
            });

            if (form_data['items'].length) {
                data.push(form_data);
            }
        }
    });
    return data;
}

function trainFormSerialized() {
    var data = [];
    if ($("#checkbox-fill-Train-Ticket").is(":checked")) {
        $(".TrainTicketDetails .train-item").each(function () {
            var train_item = $(this);
            var form_data = {};
            var train_id = train_item.find('.train_id').val().trim();
            var train_number = train_item.find('.Train-Number').val().trim();
            var train_type = train_item.find('.Train-Type').val().trim();
            var departure_date = train_item.find('.Train-Departure-date').val().trim();
            if (train_id && train_number && departure_date && train_type) {
                data.push(train_id);
            }
        });
    }

    return data;
}

function cruiseFormSerialized() {
    var data = [];
    if ($("#checkbox-fill-Nile-Curise").is(":checked")) {
        $('.NileCuriseDetails .cruise-item').each(function () {
            var cruise_item = $(this);
            let cruise_info_input = cruise_item.find('.cruise_info');
            if (cruise_info_input.length) {
                var item = {};
                item.item_id = cruise_info_input.attr('data-cruise-id').trim();
                item.room_type = cruise_item.find('.room_type').val().trim();
                if (item.item_id) {
                    var cabins = [];
                    cruise_item.find('.cabin_item').each(function () {
                        var cabin = {};
                        var cabin_item = $(this);
                        var adults_count = parseInt(cabin_item.find('.cruise_adults_count').val().trim());
                        var children_count = parseInt(cabin_item.find('.cruise_children_count').val().trim());
                        if (adults_count || children_count) {
                            cabin.adults_count = 0;
                            cabin.children_count = 0;
                            if (!isNaN(adults_count)) {
                                cabin.adults_count = adults_count;
                            }
                            if (!isNaN(children_count)) {
                                cabin.children_count = children_count;
                            }
                            cabins.push(cabin);
                        }
                    });
                    if (cabins.length) {
                        item.cabins = cabins;
                        item.inc_private_guide = 0;
                        item.inc_boat_guide = 0;
                        if (cruise_item.find(".checkbox-Private-Guide").is(':checked')) {
                            item.inc_private_guide = 1;
                        }
                        if (cruise_item.find(".checkbox-Guide-Boat").is(':checked')) {
                            item.inc_boat_guide = 1;
                        }

                        data.push(item);
                    }
                }
            }
        });
    }
    return data;
}

function flightFormSerialized() {
    var data = [];
    $("#InternationalFlightsAdded .international_flight_item").each(function () {
        let flight_item = $(this);
        let flight_id_input = flight_item.find('.flight_id');
        let flight_no_input = flight_item.find('.FlightNo');
        if (flight_id_input && flight_id_input.val() && flight_no_input && flight_no_input.val()) {
            let item = {};
            item.type = 'international';
            item.flight_no = flight_no_input.val();
            data.push(item);
        }
    });

    $("#DomesticFlightsAdded .domestic_flight_item").each(function () {
        let flight_item = $(this);
        let flight_id_input = flight_item.find('.flight_id');
        let flight_no_input = flight_item.find('.FlightNo');
        if (flight_id_input && flight_id_input.val() && flight_no_input && flight_no_input.val()) {
            let item = {};
            item.type = 'domestic';
            item.flight_no = flight_no_input.val();
            data.push(item);
        }
    });

    return data;
}

function accFormSerialized() {
    let data = [];
    $("#Accommodations form.accommodation-item").each(function () {
        let acc_item = $(this);
        let hotel_id = acc_item.find(".joHotelsDDL").val().trim(),
            valueViews = acc_item.find(".joRoomViewsDDL").val().trim(),
            valueCategories = acc_item.find(".joRoomCategoriesDDL").val().trim(),
            valueRoomTypes = acc_item.find(".joRoomTypesDDL").val().trim(),
            valueMeal = acc_item.find(".joMealPlansDDL").val().trim(),
            situation = acc_item.find('.joSituationDDL').val().trim(),
            check_in = acc_item.find(".date-Valid-From").val().trim(),
            check_out = acc_item.find(".date-Valid-To").val().trim(),
            payment_date = acc_item.find(".HotelPaymentDate").val().trim(),
            voucher_date = acc_item.find(".HotelVoucherDate").val().trim();
        let room_id = null;
        if (acc_item.find('.room_id').length) {
            room_id = acc_item.find('.room_id').val().trim();
        }

        if (hotel_id && valueViews && valueCategories && valueRoomTypes && valueMeal && situation && check_in && check_out) {
            let item = {};
            item.hotel_id = hotel_id;
            item.room_id = room_id;
            item.room_type = valueRoomTypes;
            item.meal_plan = valueMeal;
            item.view = valueViews;
            item.category = valueCategories;
            item.check_in = check_in;
            item.check_out = check_out;
            item.situation = situation;
            item.payment_date = payment_date;
            item.voucher_date = voucher_date;

            data.push(item);
        }
    });
    return data;
}

function giftsFormSerialized() {
    let data = [];
    if ($("#checkbox-fill-Gift").is(':checked')) {
        $("#GiftDetails .gift_item").each(function () {
            let gift_item = $(this);
            let gift_id = gift_item.find(".joGiftsDDL").val().trim(),
                gifts_count = parseInt(gift_item.find(".Gifts-Count").val().trim());

            if (gift_id && gifts_count) {
                let item = {};
                item.gift_id = gift_id;
                item.gifts_count = gifts_count;

                data.push(item);
            }
        });
    }
    return data;
}


function saveJobFile(url, type, add_to_url = '') {
    var save_buttons = $("#save_job, #save_job_then_draft");
    save_buttons.attr('disabled', 'disabled');
    var program_data = programFormSerialized();
    var train_data = trainFormSerialized();
    var cruise_data = cruiseFormSerialized();
    var flight_data = flightFormSerialized();
    var acc_data = accFormSerialized();
    var gifts_data = giftsFormSerialized();
    $.ajax({
        url: url + add_to_url,
        type: type,
        data: $("#Basic-Information form, #Additional-Information form, #Tour-Guide form").serialize() + '&' + $.param({programs: program_data}) + '&' + $.param({train_tickets: train_data}) + '&' + $.param({nile_cruises: cruise_data}) + '&' + $.param({flights: flight_data}) + '&' + $.param({accommodations: acc_data}) + '&' + $.param({gifts_data: gifts_data})
    })
        .done(function (data) {
            if (data && data.success && data.redirect_to) {
                window.location.href = data.redirect_to;
            }
        })
        .fail(function (err) {
            console.log(err);
            save_buttons.removeAttr('disabled');
        });

}


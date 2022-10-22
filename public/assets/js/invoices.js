function addNewItem_updated() {
    let existing_item = $("#NewItemAdded .invoice_item").first();
    existing_item.find(".js-example-tags").select2("destroy");
    let new_item = existing_item.clone();
    new_item.removeClass('d-none');

    $("#NewItemAdded").append(new_item);
    $("#NewItemAdded .js-example-tags").removeAttr('data-select2-id');
    $("#NewItemAdded .js-example-tags").select2();
    new_item.find('input,select,textarea').removeAttr('disabled').removeClass('form-control-asLabel');
    setTimeout(function () {
        $('html, body').animate({
            scrollTop: new_item.offset().top - 50
        }, 500);
    }, 250);
}

function draftInvoiceFormSerialized() {
    let draft_invoice = {job_id: job_id, items: []};
    let i = 0;
    let error = false;
    $(".invoice_item").each(function () {
        if ($(this).is(":visible")) {
            $(this).find('.currency,.price,.details,.vat').removeClass("is-invalid");
            $(this).find('.error').remove();
            if (i == 0) {
                draft_invoice.currency = $(this).find('.currency').val().trim();
            }
            let item = {};
            let details_input = $(this).find('.details');
            item.details = details_input.val().trim();
            if (!item.details) {
                validateInput(details_input);
            }

            let price_input = $(this).find('.price');
            item.price = parseFloat(price_input.val().trim());
            if (!price_input.val().trim().length || item.price < 0 || (!item.price && item.price !== 0)) {
                validateInput(price_input);
            }

            let currency_input = $(this).find('.currency');
            item.currency = currency_input.val().trim();
            if (!item.currency) {
                validateInput(currency_input);
            }

            let vat_input = $(this).find('.vat');
            item.vat = parseFloat(vat_input.val().trim());
            if (!vat_input.val().trim().length || item.vat < 0 || (!item.vat && item.vat !== 0)) {
                validateInput(vat_input);
            }

            if (item.details && item.price >= 0 && item.currency && item.vat >= 0) {
                draft_invoice.items.push(item);
            } else {
                error = true;
            }
            i++;
        }
    });
    if (error) {
        setTimeout(function () {
            if ($(".error:visible").length) {
                $('html, body').animate({
                    scrollTop: $(".error:visible").offset().top - 50
                }, 500);
            }
        }, 250);
        return false;
    }
    return draft_invoice;
}

function validateInput(input_item) {
    let err_label = '<label class="error jquery-validation-error small form-text invalid-feedback" >This field is required.</label>';
    input_item.addClass('is-invalid');
    input_item.closest('.form-group').find('label').remove();
    input_item.closest('.form-group').append(err_label);
    input_item.removeClass("form-control-asLabel");
    input_item.removeAttr("disabled");
}

function invoiceFormSerialized() {
    let invoice_date = $("#date-invoice").val();
    let status = $('input[name="Status"]:checked').val();
    let invoice = {draft_invoice_id: draft_invoice_id, date: invoice_date, status: status, items: []};
    let i = 0;
    let error = false;
    $(".invoice_item").each(function () {
        if ($(this).is(":visible")) {
            $(this).find('.currency,.price,.details,.vat').removeClass("is-invalid");
            $(this).find('.error').remove();
            if (i == 0) {
                invoice.currency = $(this).find('.currency').val().trim();
            }
            let item = {};
            let details_input = $(this).find('.details');
            item.details = details_input.val().trim();
            if (!item.details) {
                validateInput(details_input);
            }
            let price_input = $(this).find('.price');
            item.price = parseFloat(price_input.val().trim());
            if (!price_input.val().trim().length || item.price < 0 || (!item.price && item.price !== 0)) {
                validateInput(price_input);
            }
            let currency_input = $(this).find('.currency');
            item.currency = currency_input.val().trim();
            if (!item.currency) {
                validateInput(currency_input);

            }
            let vat_input = $(this).find('.vat');
            item.vat = parseFloat(vat_input.val().trim());
            if (!vat_input.val().trim().length || item.vat < 0 || (!item.vat && item.vat !== 0)) {
                validateInput(vat_input);
            }
            if (item.details && item.price >= 0 && item.currency && item.vat >= 0) {
                invoice.items.push(item);
            } else {
                error = true;
            }

            i++;
        }
    });
    if (error) {
        setTimeout(function () {
            if ($(".error:visible").length) {
                $('html, body').animate({
                    scrollTop: $(".error:visible").offset().top - 50
                }, 500);
            }
        }, 250);
        return false;
    }
    return invoice;
}

function calculateTotal() {
    let total = 0, total_without_vat = 0;
    let i = 0;
    let currency = 'USD';
    $(".invoice_item").each(function () {
        if ($(this).is(":visible")) {
            let item_currency = currencies[$(this).find('.currency').val().trim()];
            if (i == 0) {
                currency = item_currency;
            }
            let price = parseFloat($(this).find('.price').val().trim());
            let vat = parseFloat($(this).find('.vat').val().trim());
            let item_total = 0;
            if (price >= 0 && vat >= 0) {
                total_without_vat += roundTwoDecimal(price);
                item_total = roundTwoDecimal((price) + (price * vat / 100));
            }
            total += item_total;
            $(this).find('.item_total').html(item_total + " " + item_currency);

            i++;
        }
    });

    $("#total_without_vat").val(roundTwoDecimal(total_without_vat) + " " + currency);
    $("#total").val(roundTwoDecimal(total) + " " + currency);
    $("#total_vat").val(roundTwoDecimal(total - total_without_vat) + " " + currency);

}

function roundTwoDecimal(num) {
    return Math.round(num * 100) / 100
}

function saveDraftInvoice(url, type) {
    let save_button = $("#saveInvoice");
    save_button.attr('disabled', 'disabled');
    let data = draftInvoiceFormSerialized();
    if (!data || !data.items.length) {
        save_button.removeAttr('disabled');
        return false;
    }
    let zero_fields_count = 0;
    for(let i=0; i<data.items.length; i++){
        let item = data.items[i];
        if(item.price == 0){
            zero_fields_count++;
        }
    }
    if(!zero_fields_count){
        makeDraftRequest(url, type, data, save_button);
    }else{
        Swal.fire({
            icon: 'warning',
            title: are_you_sure_text,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: confirm_btn_text,
            cancelButtonText: cancel_btn_text,
            text: 'You have ' + zero_fields_count + ' price field(s) with value: 0',
        }).then((result) => {
            if (result.isConfirmed) {
                makeDraftRequest(url, type, data, save_button);
            }else{
                save_button.removeAttr('disabled');
            }
        })
    }
}

function makeDraftRequest(url, type, data, save_button) {
    $.ajax({
        url: url,
        type: type,
        data: $.param(data)
    })
        .done(function (data) {
            if (data && data.success && data.redirect_to) {
                window.location.href = data.redirect_to;
            }
        })
        .fail(function (err) {
            console.log(err);
            save_button.removeAttr('disabled');
        });
}

function saveInvoice(url, type) {
    if (typeof draft_invoice_id === 'undefined' || !draft_invoice_id) {
        return false;
    }
    let save_button = $("#saveInvoice");
    save_button.attr('disabled', 'disabled');
    let data = invoiceFormSerialized();
    if (!data || !data.items.length) {
        save_button.removeAttr('disabled');
        return false;
    }

    let zero_fields_count = 0;
    for(let i=0; i<data.items.length; i++){
        let item = data.items[i];
        if(item.price == 0){
            zero_fields_count++;
        }
    }
    if(!zero_fields_count){
        makeInvoiceRequest(url, type, data, save_button);
    }else{
        Swal.fire({
            icon: 'warning',
            title: are_you_sure_text,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: confirm_btn_text,
            cancelButtonText: cancel_btn_text,
            text: 'You have ' + zero_fields_count + ' price field(s) with value: 0',
        }).then((result) => {
            if (result.isConfirmed) {
                makeInvoiceRequest(url, type, data, save_button);
            }else{
                save_button.removeAttr('disabled');
            }
        })
    }
}

function makeInvoiceRequest(url, type, data, save_button) {
    $.ajax({
        url: url,
        type: type,
        data: $.param(data)
    })
        .done(function (data) {
            if (data && data.success && data.redirect_to) {
                window.location.href = data.redirect_to;
            }
        })
        .fail(function (err) {
            console.log(err);
            save_button.removeAttr('disabled');
        });
}

$(function () {
    if (calculateTotalOnLoad) {
        calculateTotal();
    }

    $(document).on('click', "#nvoicDetalsShow_updated", function () {
        $('.changeLabel input, .changeLabel textarea, .changeLabel select, #date-invoice').addClass("form-control-asLabel");
        $('.changeLabel input, .changeLabel textarea, .changeLabel select, #date-invoice').attr("disabled", "disabled");
        $('#nvoicDetalsShow_updated').addClass("d-none");
        $('#nvoicDetalsEdit_updated').removeClass("d-none");
        return false;
    });

    $(document).on('click', "#nvoicDetalsEdit_updated", function () {
        $('.changeLabel input, .changeLabel textarea, .changeLabel select, #date-invoice').removeClass("form-control-asLabel");
        $('.changeLabel input, .changeLabel textarea, .changeLabel select, #date-invoice').removeAttr("disabled");
        $('#nvoicDetalsShow_updated').removeClass("d-none");
        $('#nvoicDetalsEdit_updated').addClass("d-none");
        return false;
    });

    $(document).on('change', ".price, .vat, .currency", function () {
        calculateTotal();
    });

});

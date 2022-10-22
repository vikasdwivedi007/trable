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

function searchJobFile(item, file_no, date){
    $.get(search_job_file_route, {'file_no': file_no, 'date': date})
.done(function (data) {
        if(data.job_file){
            let job_file = data.job_file;
            item.find(".travel_agent").val(job_file.travel_agent.name);
            item.find(".client_name").val(job_file.client_name);
            item.find(".client_phone").val(job_file.client_phone);
            item.find(".pax").val(job_file.adults_count+job_file.children_count);
            if(data.daily_sheet){
                item.find(".router_number").val(data.daily_sheet.router_number);
            }else{
                item.find(".router_number").val(job_file.job_router ? job_file.job_router.router.number : "");
            }
            item.find(".flight_number").val(job_file.arrival_flight);
            item.find(".flight_time").val(job_file.arrival_date);
            item.find(".pnr").val(data.daily_sheet ? data.daily_sheet.pnr : "");
            item.find(".guide_name").val(job_file.guides.length ? job_file.guides[0].guide.name : "");
            item.find(".guide_phone").val(job_file.guides.length ? job_file.guides[0].guide.phone : "");
            item.find(".transfer_man_name").val( data.daily_sheet && data.daily_sheet.representative ? data.daily_sheet.representative.user.name : "");
            item.find(".transfer_man_phone").val(data.daily_sheet && data.daily_sheet.representative ? data.daily_sheet.representative.user.phone : "");

            item.find(".concierge").val(job_file.service_conciergerie ? 'Yes' : "No");

            item.find(".transportation_company").val(data.daily_sheet && data.daily_sheet.transportation ? data.daily_sheet.transportation.name : "");
            item.find(".driver_name").val(data.daily_sheet ? data.daily_sheet.driver_name : "");
            item.find(".driver_phone").val(data.daily_sheet ? data.daily_sheet.driver_phone : "");

            item.find(".remarks").val(data.daily_sheet ? data.daily_sheet.remarks : job_file.remarks);
            item.find(".itinerary").val(data.daily_sheet ? data.daily_sheet.itinerary : job_file.itinerary);

            item.find('.item_details').removeClass('d-none');
            item.find('.show_data_btn').attr('disabled', 'disabled');
        }else{
            resetFields(item);
        }
    })
        .fail(function(err){
            resetFields(item);
        });
}

function resetFields(item){
    item.find('input[type!="checkbox"],textarea,select').val("");
    item.find('input,select,textarea').attr('disabled', 'disabled').addClass('form-control-asLabel');
    item.find('.FileNo').removeAttr('disabled').removeClass('form-control-asLabel');
    // item.find('.driver_phone,.representative_phone').removeClass('form-control-asLabel');
    item.find('.item_details').addClass('d-none');
    item.find('.show_data_btn').removeAttr('disabled');
}

function getFormData(){
    let date = $("#date").val().trim();
    let emp_id = $("#emp_id").val().trim();
    $('.error').remove();
    $('.is-invalid').removeClass('is-invalid');
    if(date && emp_id){
        let data = {date:date, emp_id:emp_id};
        let job_item = $(".job_item").first();
        data.file_no = job_item.find('.FileNo').val().trim();
        if(!data.file_no){
            validateInput(job_item.find('.FileNo'));
        }
        data.router_number = job_item.find('.router_number').val().trim();
        data.remarks = job_item.find('.remarks').val().trim();
        data.itinerary = job_item.find('.itinerary').val().trim();
        if($(".error:visible").length){
            setTimeout(function(){
                $('html, body').animate({
                    scrollTop: $(".error:visible").offset().top - 50
                }, 500 );
            }, 250);
            return false;
        }
        if(!data.file_no){
            return false;
        }
        return data;
    }else{
        validateInput($('#date'));
        validateInput($('#emp_id'));
        if($(".error:visible").length){
            setTimeout(function(){
                $('html, body').animate({
                    scrollTop: $(".error:visible").offset().top - 50
                }, 500 );
            }, 250);
            return false;
        }
        return false;
    }
}


function validateInput(input_item){
    let err_label = '<label class="error jquery-validation-error small form-text invalid-feedback" >This field is required.</label>';
    input_item.addClass('is-invalid');
    input_item.closest('.form-group').find('label').remove();
    input_item.closest('.form-group').append(err_label);
    input_item.removeClass("form-control-asLabel");
    input_item.removeAttr("disabled");
}

function saveData(url, type){
    let save_button = $("#saveData_btn");
    save_button.attr('disabled', 'disabled');
    let data = getFormData();
    if(!data){
        save_button.removeAttr('disabled');
        return false;
    }
    $.ajax({
        url: url,
        type: type,
        data: $.param(data)
    })
        .done(function(data){
            if(data && data.success && data.redirect_to){
                window.location.href = data.redirect_to;
            }
        })
        .fail(function(err){
            console.log(err);
            save_button.removeAttr('disabled');
        });
}

function loadFileData(show_data_btn){
    let item = show_data_btn.closest('.job_item');
    let file_no_input = item.find('.FileNo');
    let file_no = file_no_input.val().trim();
    let date = $("#date").val().trim();
    if(file_no && date){
        searchJobFile(item, file_no, date);
    }else{
        resetFields(item);
    }
}

$(function () {

    $(document).on('click',"#sheetDetalsShow_updated", function () {
        $('.changeLabel input, .changeLabel textarea, .changeLabel select, #date-invoice').addClass("form-control-asLabel");
        $('.changeLabel input, .changeLabel textarea, .changeLabel select, #date-invoice').attr("disabled", "disabled");
        $('#nvoicDetalsShow_updated').addClass("d-none");
        $('#nvoicDetalsEdit_updated').removeClass("d-none");
        return false;
    });

    $(document).on('click',"#sheetDetalsEdit_updated", function () {
        let job_item = $(this).closest('.job_item');
        job_item.find('.changeLabel input, .changeLabel textarea, .changeLabel select, #date-invoice').removeClass("form-control-asLabel");
        job_item.find('.changeLabel input, .changeLabel textarea, .changeLabel select, #date-invoice').removeAttr("disabled");
        // $('#nvoicDetalsShow_updated').removeClass("d-none");
        job_item.find('#nvoicDetalsEdit_updated').addClass("d-none");
        return false;
    });

    $(document).on("change", ".transportation_id", function () {
        let transportation_input = $(this);
        let item = transportation_input.closest('.job_item');
        let transportation_id = transportation_input.val();
        if(transportation_id){
            item.find('.driver_id').removeAttr('disabled');
            item.find('.driver_id option[data-transportation-id!='+transportation_id+']').attr('disabled', 'disabled');
            item.find('.driver_id option[data-transportation-id='+transportation_id+']').removeAttr('disabled');
            item.find('.driver_id option[value=""]').removeAttr('disabled');
            item.find('.driver_id').select2();
        }else{
            item.find('.driver_id').val("").trigger('change');
            item.find('.driver_id').attr('disabled', 'disabled');
        }
    });

    $(document).on("change", ".driver_id", function () {
        let driver_id_input = $(this);
        let item = driver_id_input.closest('.job_item');
        let driver_id = driver_id_input.val();
        if(driver_id){
            let driver_phone = driver_id_input.find('option[value='+driver_id+']').attr('data-phone');
            item.find('.driver_phone').val(driver_phone);
        }else{
            item.find('.driver_phone').val('');
        }
    });

    $(document).on("change", ".representative_id", function () {
        let representative_id_input = $(this);
        let item = representative_id_input.closest('.job_item');
        let representative_id = representative_id_input.val();
        if(representative_id){
            let driver_phone = representative_id_input.find('option[value='+representative_id+']').attr('data-phone');
            item.find('.representative_phone').val(driver_phone);
        }else{
            item.find('.representative_phone').val('');
        }
    });

    $("#date").change(function(){
        $(".job_item").each(function(){
            let file_no_input = $(this).find('.FileNo');
            let file_no = file_no_input.val();
            resetFields($(this));
            file_no_input.val(file_no);
        });
    });


});

$(function () {
    if(window.location.hash && $(window.location.hash).length){
        $(window.location.hash).click();
    }

    if(typeof hotels_index_path != 'undefined') {
        columns = [
            {
                "data": null,
                "render": function (data, type, row) {
                    if(!rooms_write){
                        return '';
                    }
                    var content = '<div class="dropdown text-center">\n' +
                        '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '        <i class=\'feather icon-more-vertical\'></i>\n' +
                        '    </a>\n' +
                        '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                        '        <ul class="pro-body">\n' +
                        '            <li>\n' +
                        '                <a href="' + rooms_edit_path.replace('room_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n' +
                        '            <li>\n' +
                        '                <form action="' + rooms_destroy_path.replace('room_id', row.id) + '" method="POST">\n' +
                        delete_method + csrf +
                        '                <a href="#" class="dropdown-item confirm_delete">\n' +
                        '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text +
                        '                </a>\n' +
                        '                </form>' +
                        '            </li>\n';
                    content += '</ul>\n' +
                        '</div>\n' +
                        '</div>';

                    return content;
                }
            },
            {"data": "city.name"}, {"data": "hotel.name"}, {"data": "name"}, {"data": "type"}, {"data": "meal_plan"}, {"data": "price_valid_from"}, {"data": "price_valid_to"}, {"data": "base_rate"}, {"data": "formatted_discount", "orderable": false}, {"data": "rate_after_discount", "orderable": false}, {"data": "extra_bed_exc"}, {"data": "single_parent_exc"}, {"data": "single_parent_child_exc"}, {"data": "hotel.phone"}, {"data": "hotel.email"}];

        $('#rooms-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": hotels_index_path,
            "columns": columns
        });
    }

    if(typeof restaurants_index_path != 'undefined') {
        columns = [{
            "data": null,
            "render": function (data, type, row) {
                if(!restaurants_write){
                    return '';
                }
                var content = '<div class="dropdown text-center">\n' +
                    '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                    '        <i class=\'feather icon-more-vertical\'></i>\n' +
                    '    </a>\n' +
                    '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                    '        <ul class="pro-body">\n' +
                    '            <li>\n' +
                    '                <a href="' + restaurants_edit_path.replace('restaurant_id', row.id) + '" class="dropdown-item">\n' +
                    '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                    '                </a>\n' +
                    '            </li>\n' +
                    '            <li>\n' +
                    '                <form action="' + restaurants_destroy_path.replace('restaurant_id', row.id) + '" method="POST">\n' +
                    delete_method + csrf +
                    '                <a href="#" class="dropdown-item confirm_delete">\n' +
                    '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text  +
                    '                </a>\n' +
                    '                </form>' +
                    '            </li>\n';
                content += '</ul>\n' +
                    '</div>\n' +
                    '</div>';

                return content;
            }
        },{"data": "name"}, {"data": "city.name"}, {"data": "phone"},{"data": "email"}];

        $('#restaurants-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": restaurants_index_path,
            "columns": columns
        });
    }

    if(typeof transportations_index_path != 'undefined') {
        columns = [{
            "data": null,
            "render": function (data, type, row) {
                if(!transportations_write){
                    return '';
                }
                var content = '<div class="dropdown text-center">\n' +
                    '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                    '        <i class=\'feather icon-more-vertical\'></i>\n' +
                    '    </a>\n' +
                    '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                    '        <ul class="pro-body">\n' +
                    '            <li>\n' +
                    '                <a href="' + transportations_edit_path.replace('transportation_id', row.id) + '" class="dropdown-item">\n' +
                    '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                    '                </a>\n' +
                    '            </li>\n' +
                    '            <li>\n' +
                    '                <form action="' + transportations_destroy_path.replace('transportation_id', row.id) + '" method="POST">\n' +
                    delete_method + csrf +
                    '                <a href="#" class="dropdown-item confirm_delete">\n' +
                    '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text +
                    '                </a>\n' +
                    '                </form>' +
                    '            </li>\n';
                content += '</ul>\n' +
                    '</div>\n' +
                    '</div>';

                return content;
            }
        },{"data": "code"}, {"data": "transportations.name"}, {"data": "phone"}, {"data": "email"}, {"data": "city.name"}];

        $('#transportations-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": transportations_index_path,
            "columns": columns
        });
    }

    if(typeof train_tickets_index_path != 'undefined') {
        columns = [
            {
                "data": null,
                "render": function (data, type, row) {
                    if(!train_tickets_write){
                        return '';
                    }
                    var content = '<div class="dropdown text-center">\n' +
                        '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '        <i class=\'feather icon-more-vertical\'></i>\n' +
                        '    </a>\n' +
                        '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                        '        <ul class="pro-body">\n' +
                        '            <li>\n' +
                        '                <a href="' + train_tickets_edit_path.replace('train_ticket_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text  +
                        '                </a>\n' +
                        '            </li>\n' ;
                        if(row.can_be_deleted) {
                            content += '            <li>\n' +
                            '                <form action="' + train_tickets_destroy_path.replace('train_ticket_id', row.id) + '" method="POST">\n' +
                            delete_method + csrf +
                            '                <a href="#" class="dropdown-item confirm_delete">\n' +
                            '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text  +
                            '                </a>\n' +
                            '                </form>' +
                            '            </li>\n';
                        }
                    content += '</ul>\n' +
                        '</div>\n' +
                        '</div>';

                    return content;
                }
            }, {"data": "number"}, {"data": "type"}, {"data": "class"}, {"data": "wagon_no"}, {"data": "seat_no"}, {"data": "from_station.name"}, {"data": "to_station.name"}, {"data": "depart_at"}, {"data": "arrive_at"}];
        if(train_tickets_write){
            columns.push({"data": "sgl_buy_price"});
        }
        columns.push({"data": "sgl_sell_price"});

        $('#train-tickets-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "order": [[ 8, "desc" ]],
            "ajax": train_tickets_index_path,
            "columns": columns
        });
    }

    if(typeof guides_index_path != 'undefined') {
        columns = [
            {
                "data": null,
                "render": function (data, type, row) {
                    if(!guides_write){
                        return '';
                    }
                    var content = '<div class="dropdown text-center">\n' +
                        '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '        <i class=\'feather icon-more-vertical\'></i>\n' +
                        '    </a>\n' +
                        '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                        '        <ul class="pro-body">\n' +
                        '            <li>\n' +
                        '                <a href="' + guides_edit_path.replace('guide_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text  +
                        '                </a>\n' +
                        '            </li>\n' ;
                    if(row.can_be_deleted) {
                        content += '            <li>\n' +
                        '                <form action="' + guides_destroy_path.replace('guide_id', row.id) + '" method="POST">\n' +
                        delete_method + csrf +
                        '                <a href="#" class="dropdown-item confirm_delete">\n' +
                        '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text +
                        '                </a>\n' +
                        '                </form>' +
                        '            </li>\n';
                    }
                    content += '</ul>\n' +
                        '</div>\n' +
                        '</div>';

                    return content;
                }
            },
            {"data": "name"}, {"data": "city.name"}, {"data": "phone"}, {"data": "languages_str", "orderable": false}, {"data": "email", "orderable": false}, {"data": "license_no"}, {"data": "daily_fee"}];

        $('#guides-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": guides_index_path,
            "columns": columns
        });
    }

    if(typeof nile_cruises_index_path != 'undefined') {
        columns = [
            {
                "data": null,
                "render": function (data, type, row) {
                    if(!nile_cruises_write){
                        return '';
                    }
                    var content = '<div class="dropdown text-center">\n' +
                        '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '        <i class=\'feather icon-more-vertical\'></i>\n' +
                        '    </a>\n' +
                        '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                        '        <ul class="pro-body">\n' +
                        '            <li>\n' +
                        '                <a href="' + nile_cruises_edit_path.replace('nile_cruise_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n';
                    if(row.can_be_deleted) {
                        content += '            <li>\n' +
                        '                <form action="' + nile_cruises_destroy_path.replace('nile_cruise_id', row.id) + '" method="POST">\n' +
                        delete_method + csrf +
                        '                <a href="#" class="dropdown-item confirm_delete">\n' +
                        '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text +
                        '                </a>\n' +
                        '                </form>' +
                        '            </li>\n';
                    }
                    content += '</ul>\n' +
                        '</div>\n' +
                        '</div>';

                    return content;
                }
            },
            {"data": "company_name"}, {"data": "from_city.name"}, {"data": "to_city.name"}, {"data": "name"}, {"data": "date_from"}, {"data": "date_to"}, {"data": "cabin_type"}];
        if(nile_cruises_write){
            columns.push({"data": "sgl_buy_price"});
        }
        columns.push({"data": "sgl_sell_price"});
        if(nile_cruises_write){
            columns.push({"data": "dbl_buy_price"});
        }
        columns.push({"data": "dbl_sell_price"});
        if(nile_cruises_write){
            columns.push({"data": "trpl_buy_price"});
        }
        columns.push({"data": "trpl_sell_price"});
        if(nile_cruises_write){
            columns.push({"data": "child_buy_price"});
        }
        columns.push({"data": "child_sell_price"});

        $('#nile-cruises-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": nile_cruises_index_path,
            "columns": columns
        });
    }

    if(typeof flights_index_path != 'undefined') {
        columns = [
            {
                "data": null,
                "render": function (data, type, row) {
                    if(!flights_write){
                        return '';
                    }
                    var content = '<div class="dropdown text-center">\n' +
                        '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '        <i class=\'feather icon-more-vertical\'></i>\n' +
                        '    </a>\n' +
                        '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                        '        <ul class="pro-body">\n' +
                        '            <li>\n' +
                        '                <a href="' + flights_edit_path.replace('flight_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n' ;
                    if(row.can_be_deleted) {
                        content += '            <li>\n' +
                        '                <form action="' + flights_destroy_path.replace('flight_id', row.id) + '" method="POST">\n' +
                        delete_method + csrf +
                        '                <a href="#" class="dropdown-item confirm_delete">\n' +
                        '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text +
                        '                </a>\n' +
                        '                </form>' +
                        '            </li>\n';
                    }
                    content += '</ul>\n' +
                        '</div>\n' +
                        '</div>';

                    return content;
                }
            }, {"data": "number"}, {"data": "date"}, {"data": "airport_from.state"}, {"data": "airport_to.state"}, {"data": "depart_at"}, {"data": "arrive_at"}, {"data": "seats_count"}, {"data": "reference"}, {"data": "status"}];
        if(flights_write){
            columns.push({"data": "buy_price"});
        }
        columns.push({"data": "sell_price_vat_exc"});

        $('#flights-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": flights_index_path,
            "columns": columns
        });
    }

});

$(function () {
    if(window.location.hash && $(window.location.hash).length){
        $(window.location.hash).click();
    }

    //traffic vouchers table
    columns = [
        {
            "data": null,
            "render": function (data, type, row) {
                var content = '<div class="dropdown text-center">\n' +
                    '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                    '        <i class=\'feather icon-more-vertical\'></i>\n' +
                    '    </a>\n' +
                    '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                    '        <ul class="pro-body">\n';
                content += '            <li>\n' +
                    '                <a target="_blank" href="'+traffic_view_path.replace('voucher_id', row.id)+'" class="dropdown-item">\n' +
                    '<i class="mdi mdi-eye"></i>' +
                    " " +view_btn_text +
                    '                </a>\n' +
                    '            </li>\n' ;
                content += '            <li>\n' +
                    '                <a target="_blank" href="'+traffic_print_path.replace('voucher_id', row.id)+'" class="dropdown-item">\n' +
                    '<i class="mdi mdi-printer"></i>'+
                    ' ' +print_btn_text +
                    '                </a>\n' +
                    '            </li>\n' ;
                if(traffic_write) {
                    content += '            <li>\n' +
                        '                <a href="' + traffic_edit_path.replace('voucher_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n' +
                        '            <li>\n' +
                        '                <form action="' + traffic_destroy_path.replace('voucher_id', row.id) + '" method="POST">\n' +
                        delete_method + csrf +
                        '                <a href="#" class="dropdown-item confirm_delete">\n' +
                        '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text +
                        '                </a>\n' +
                        '                </form>' +
                        '            </li>\n';
                }
                content += '</ul>\n' +
                    '</div>\n' +
                    '</div>'

                return content;
            }
        },
        {"data": "serial_no"}, {"data": "job_file.file_no"}, {"data": "issued_by"}, {"data":"to"}, {"data":"job_file.client_name"}, {"data":"job_file.arrival_date"}, {"data":"airport_to_formatted.text", 'orderable':false}, {"data":"job_file.departure_date"}, {"data":"airport_from_formatted.text", 'orderable':false}
    ];

    $('#traffic-vouchers-table').DataTable({
        paging: true,
        "processing": true,
        "serverSide": true,
        "ajax": traffic_index_path,
        "columns": columns
    });


    //restaurant vouchers table
    columns = [
        {
            "data": null,
            "render": function (data, type, row) {
                var content = '<div class="dropdown text-center">\n' +
                    '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                    '        <i class=\'feather icon-more-vertical\'></i>\n' +
                    '    </a>\n' +
                    '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                    '        <ul class="pro-body">\n';
                content += '            <li>\n' +
                    '                <a target="_blank" href="'+restaurant_view_path.replace('voucher_id', row.id)+'" class="dropdown-item">\n' +
                    '<i class="mdi mdi-eye"></i>' +
                    ' ' +view_btn_text +
                    '                </a>\n' +
                    '            </li>\n' ;
                content += '            <li>\n' +
                    '                <a target="_blank" href="'+restaurant_print_path.replace('voucher_id', row.id)+'" class="dropdown-item">\n' +
                    '<i class="mdi mdi-printer"></i>'+
                    ' ' +print_btn_text +
                    '                </a>\n' +
                    '            </li>\n' ;
                if(traffic_write) {
                    content += '            <li>\n' +
                        '                <a href="' + restaurant_edit_path.replace('voucher_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n' +
                        '            <li>\n' +
                        '                <form action="' + restaurant_destroy_path.replace('voucher_id', row.id) + '" method="POST">\n' +
                        delete_method + csrf +
                        '                <a href="#" class="dropdown-item confirm_delete">\n' +
                        '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text +
                        '                </a>\n' +
                        '                </form>' +
                        '            </li>\n';
                }
                content += '</ul>\n' +
                    '</div>\n' +
                    '</div>'

                return content;
            }
        },
        {"data": "serial_no"}, {"data": "job_file.file_no"}, {"data": "issued_by"}, {"data":"to"}, {"data":"job_file.client_name"}, {"data":"job_file.arrival_date"}, {"data":"airport_to_formatted.text", 'orderable':false}, {"data":"job_file.departure_date"}, {"data":"airport_from_formatted.text", 'orderable':false}];

    $('#restaurant-vouchers-table').DataTable({
        paging: true,
        "processing": true,
        "serverSide": true,
        "ajax": restaurant_index_path,
        "columns": columns
    });


    //hotel vouchers table
    columns = [
        {
            "data": null,
            "render": function (data, type, row) {
                var content = '<div class="dropdown text-center">\n' +
                    '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                    '        <i class=\'feather icon-more-vertical\'></i>\n' +
                    '    </a>\n' +
                    '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                    '        <ul class="pro-body">\n';
                content += '            <li>\n' +
                    '                <a target="_blank" href="'+hotel_view_path.replace('voucher_id', row.id)+'" class="dropdown-item">\n' +
                    '<i class="mdi mdi-eye"></i>' +
                    ' ' +view_btn_text +
                    '                </a>\n' +
                    '            </li>\n' ;
                content += '            <li>\n' +
                    '                <a target="_blank" href="'+hotel_print_path.replace('voucher_id', row.id)+'" class="dropdown-item">\n' +
                    '<i class="mdi mdi-printer"></i>'+
                    ' ' +print_btn_text +
                    '                </a>\n' +
                    '            </li>\n' ;
                if(traffic_write) {
                    content += '            <li>\n' +
                        '                <a href="' + hotel_edit_path.replace('voucher_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n' +
                        '            <li>\n' +
                        '                <form action="' + hotel_destroy_path.replace('voucher_id', row.id) + '" method="POST">\n' +
                        delete_method + csrf +
                        '                <a href="#" class="dropdown-item confirm_delete">\n' +
                        '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text +
                        '                </a>\n' +
                        '                </form>' +
                        '            </li>\n';
                }
                content += '</ul>\n' +
                    '</div>\n' +
                    '</div>'

                return content;
            }
        },
        {"data": "serial_no"}, {"data": "job_file.file_no"}, {"data": "issued_by"},
        {"data": null, "render": function(data,type,row){
            if(row.hotel){
                return row.hotel.name;
            }else if(row.cruise){
                return row.cruise.name;
            }
            return "";
        }, 'orderable':false},
        {"data":"job_file.client_name"}, {"data":"arrival_date"}, {"data":"departure_date"}, {"data":"nights_count", 'orderable':false}, {"data":"guests_count", 'orderable':false}
    ];

    $('#hotel-vouchers-table').DataTable({
        paging: true,
        "processing": true,
        "serverSide": true,
        "ajax": hotel_index_path,
        "columns": columns
    });


    //guide vouchers table
    columns = [
        {
            "targets": -1,
            "data": null,
            "render": function (data, type, row) {
                var content = '<div class="dropdown text-center">\n' +
                    '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                    '        <i class=\'feather icon-more-vertical\'></i>\n' +
                    '    </a>\n' +
                    '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                    '        <ul class="pro-body">\n';
                content += '            <li>\n' +
                    '                <a target="_blank" href="'+guide_view_path.replace('voucher_id', row.id)+'" class="dropdown-item">\n' +
                    '<i class="mdi mdi-eye"></i>' +
                    ' ' +view_btn_text +
                    '                </a>\n' +
                    '            </li>\n' ;
                content += '            <li>\n' +
                    '                <a target="_blank" href="'+guide_print_path.replace('voucher_id', row.id)+'" class="dropdown-item">\n' +
                    '<i class="mdi mdi-printer"></i>'+
                    ' ' +print_btn_text +
                    '                </a>\n' +
                    '            </li>\n' ;
                if(traffic_write) {
                    content += '            <li>\n' +
                        '                <a href="' + guide_edit_path.replace('voucher_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n' +
                        '            <li>\n' +
                        '                <form action="' + guide_destroy_path.replace('voucher_id', row.id) + '" method="POST">\n' +
                        delete_method + csrf +
                        '                <a href="#" class="dropdown-item confirm_delete">\n' +
                        '                    <i class="mdi mdi-delete-forever"></i> ' + delete_btn_text +
                        '                </a>\n' +
                        '                </form>' +
                        '            </li>\n';
                }
                content += '</ul>\n' +
                    '</div>\n' +
                    '</div>'

                return content;
            }
        },
        {"data": "serial_no"}, {"data": "job_file.file_no"}, {"data": "issued_by"}, {"data":"job_file.client_name"}, {"data":"hotel.name"}, {"data":"pax_no"}, {"data":"guide.name"}, {"data":"guide.languages_str", 'orderable':false},  {"data":"tour_operator"}
    ];

    $('#guide-vouchers-table').DataTable({
        paging: true,
        "processing": true,
        "serverSide": true,
        "ajax": guide_index_path,
        "columns": columns
    });

});

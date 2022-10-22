$(function () {
    if(window.location.hash && $(window.location.hash).length){
        $(window.location.hash).click();
    }

    if(typeof sightseeings_index_path != 'undefined') {
        columns = [
            {
                "data": null,
                "render": function (data, type, row) {
                    if(!sightseeings_write){
                        return '';
                    }
                    var content = '<div class="dropdown text-center">\n' +
                        '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '        <i class=\'feather icon-more-vertical\'></i>\n' +
                        '    </a>\n' +
                        '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                        '        <ul class="pro-body">\n' +
                        '            <li>\n' +
                        '                <a href="' + sightseeings_edit_path.replace('sightseeing_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n';
                    if(row.can_be_deleted) {
                        content += '            <li>\n' +
                        '                <form action="' + sightseeings_destroy_path.replace('sightseeing_id', row.id) + '" method="POST">\n' +
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
            {"data": "name"}, {"data": "desc"}, {"data": "city.name"}
        ];
        if(sightseeings_write){
            columns.push({"data": "buy_price_adult"});
        }
        columns.push({"data": "sell_price_adult_vat_exc"});
        if(sightseeings_write){
            columns.push({"data": "buy_price_child"});
        }
        columns.push({"data": "sell_price_child_vat_exc"});

        $('#responsive-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": sightseeings_index_path,
            "columns": columns
        });
    }

    if(typeof routers_index_path != 'undefined') {
        columns = [
            {
                "data": null,
                "render": function (data, type, row) {
                    if(!routers_write){
                        return '';
                    }
                    var content = '<div class="dropdown text-center">\n' +
                        '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '        <i class=\'feather icon-more-vertical\'></i>\n' +
                        '    </a>\n' +
                        '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                        '        <ul class="pro-body">\n' +
                        '            <li>\n' +
                        '                <a href="' + routers_edit_path.replace('router_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text  +
                        '                </a>\n' +
                        '            </li>\n';
                    if(row.can_be_deleted) {
                        content += '            <li>\n' +
                        '                <form action="' + routers_destroy_path.replace('router_id', row.id) + '" method="POST">\n' +
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
            {"data": "city.name"}, {"data": "serial_no"}, {"data": "number"}, {"data": "provider"},{"data": "quota"}
        ];
        if(routers_write){
            columns.push({"data": "package_buy_price"});
        }
        columns.push({"data": "package_sell_price_vat_exc"});
        $('#col-reorder').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": routers_index_path,
            "columns": columns
        });
    }

    if(typeof slshows_index_path != 'undefined') {
        columns = [
                {
                    "data": null,
                    "render": function (data, type, row) {
                    if(!slshows_write){
                        return '';
                    }
                    var content = '<div class="dropdown text-center">\n' +
                        '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '        <i class=\'feather icon-more-vertical\'></i>\n' +
                        '    </a>\n' +
                        '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                        '        <ul class="pro-body">\n' +
                        '            <li>\n' +
                        '                <a href="' + slshows_edit_path.replace('slshow_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n';
                    if(row.can_be_deleted) {
                        content += '            <li>\n' +
                        '                <form action="' + slshows_destroy_path.replace('slshow_id', row.id) + '" method="POST">\n' +
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
            {"data": "place"}, {"data": "date"}, {"data": "time"}, {"data": "language.language"}, {"data":"ticket_type"}
        ];
        if(slshows_write){
            columns.push({"data": "buy_price_adult"});
        }
        columns.push({"data": "sell_price_adult_vat_exc"});
        if(slshows_write){
            columns.push({"data": "buy_price_child"});
        }
        columns.push({"data": "sell_price_child_vat_exc"});

        $('#fixed-header').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": slshows_index_path,
            "columns": columns
        });
    }

    if(typeof vbnights_index_path != 'undefined') {
        columns = [
            {
                "data": null,
                "render": function (data, type, row) {
                    if(!vbnights_write){
                        return '';
                    }
                    var content = '<div class="dropdown text-center">\n' +
                        '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '        <i class=\'feather icon-more-vertical\'></i>\n' +
                        '    </a>\n' +
                        '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                        '        <ul class="pro-body">\n' +
                        '            <li>\n' +
                        '                <a href="' + vbnights_edit_path.replace('vbnight_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n';
                    if(row.can_be_deleted){
                        content += '            <li>\n' +
                        '                <form action="' + vbnights_destroy_path.replace('vbnight_id', row.id) + '" method="POST">\n' +
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
            }
            ,{"data": "city.name"}, {"data": "name"}
        ];
        if(vbnights_write){
            columns.push({"data": "buy_price_adult"});
        }
        columns.push({"data": "sell_price_adult_vat_exc"});
        if(vbnights_write){
            columns.push({"data": "buy_price_child"});
        }
        columns.push({"data": "sell_price_child_vat_exc"});
        $('#vbnights-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": vbnights_index_path,
            "columns": columns
        });
    }

    if(typeof lkfriends_index_path != 'undefined') {
        columns = [
            {
                "data": null,
                "render": function (data, type, row) {
                    if(!lkfriends_write){
                        return '';
                    }
                    var content = '<div class="dropdown text-center">\n' +
                        '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '        <i class=\'feather icon-more-vertical\'></i>\n' +
                        '    </a>\n' +
                        '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                        '        <ul class="pro-body">\n' +
                        '            <li>\n' +
                        '                <a href="' + lkfriends_edit_path.replace('lkfriend_id', row.id) + '" class="dropdown-item">\n' +
                        '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                        '                </a>\n' +
                        '            </li>\n';
                    if(row.can_be_deleted) {
                        content += '            <li>\n' +
                        '                <form action="' + lkfriends_destroy_path.replace('lkfriend_id', row.id) + '" method="POST">\n' +
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
            {"data": "name"}, {"data": "city.name"}, {"data": "phone"}, {"data": "languages_str", "orderable": false}
        ];
        if(lkfriends_write){
            columns.push({"data": "rent_day"});
        }
        columns.push({"data": "sell_rent_day_vat_exc"});
        $('#lkfriends-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": lkfriends_index_path,
            "columns": columns
        });
    }

    if(typeof shops_index_path != 'undefined') {
        $('#shops-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": shops_index_path,
            "columns": [
                {
                    "data": null,
                    "render": function (data, type, row) {
                        if(!shops_write){
                            return '';
                        }
                        var content = '<div class="dropdown text-center">\n' +
                            '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                            '        <i class=\'feather icon-more-vertical\'></i>\n' +
                            '    </a>\n' +
                            '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                            '        <ul class="pro-body">\n' +
                            '            <li>\n' +
                            '                <a href="' + shops_edit_path.replace('shop_id', row.id) + '" class="dropdown-item">\n' +
                            '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                            '                </a>\n' +
                            '            </li>\n';
                        if(row.can_be_deleted) {
                            content += '            <li>\n' +
                            '                <form action="' + shops_destroy_path.replace('shop_id', row.id) + '" method="POST">\n' +
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
                {"data": "city.name"},
                {"data": "name"},
                {"data": "phone"},
                {
                    "data": "commission", "render": function (data, type, row) {
                        return data + "%";
                    }
                },
            ]
        });
    }

    if(typeof gifts_index_path != 'undefined') {
        $('#gifts-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": gifts_index_path,
            "columns": [
                {
                    "data": null,
                    "render": function (data, type, row) {
                        if(!gifts_write){
                            return '';
                        }
                        var content = '<div class="dropdown text-center">\n' +
                            '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                            '        <i class=\'feather icon-more-vertical\'></i>\n' +
                            '    </a>\n' +
                            '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                            '        <ul class="pro-body">\n' +
                            '            <li>\n' +
                            '                <a href="' + gifts_edit_path.replace('gift_id', row.id) + '" class="dropdown-item">\n' +
                            '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                            '                </a>\n' +
                            '            </li>\n';
                        if(row.can_be_deleted) {
                            content += '            <li>\n' +
                            '                <form action="' + gifts_destroy_path.replace('gift_id', row.id) + '" method="POST">\n' +
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
                {"data": "name"},
                {"data": "buy_price"},
                {"data": "sell_price"},

            ]
        });
    }

    if(typeof visas_index_path != 'undefined') {
        $('#travel-visass-table').DataTable({
            paging: true,
            "processing": true,
            "serverSide": true,
            "ajax": visas_index_path,
            "columns": [
                {
                    "data": null,
                    "render": function (data, type, row) {
                        if(!visas_write){
                            return '';
                        }
                        var content = '<div class="dropdown text-center">\n' +
                            '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                            '        <i class=\'feather icon-more-vertical\'></i>\n' +
                            '    </a>\n' +
                            '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                            '        <ul class="pro-body">\n' +
                            '            <li>\n' +
                            '                <a href="' + visas_edit_path.replace('visa_id', row.id) + '" class="dropdown-item">\n' +
                            '                    <i class="mdi mdi-square-edit-outline"></i> ' + edit_btn_text +
                            '                </a>\n' +
                            '            </li>\n' ;
                        if(row.can_be_deleted) {
                            content += '            <li>\n' +
                            '                <form action="' + visas_destroy_path.replace('visa_id', row.id) + '" method="POST">\n' +
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
                {"data": "name"},
                {"data": "buy_price"},
                {"data": "sell_price"},

            ]
        });
    }
});

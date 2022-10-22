'use strict';
$(document).ready(function() {
    // [ Zero-configuration ] start
    $('#zero-configuration').DataTable();

     // [ HTML5-Export ] start
     $('#key-print-button').DataTable({
        // Hide Search Bar
        //sDom: 'lrtip',
        bFilter: false,
        dom: 'Bfrtip',         
        buttons: [            
            'print'
        ]
    });

    // [ HTML5-Export ] start
    $('#key-act-button').DataTable({
        dom: 'Bfrtip',
        buttons: [
            //'copyHtml5',
            //'csvHtml5',
            'excelHtml5',            
            'pdfHtml5',
            'print'
        ]
    });

    // [ Columns-Reorder ] start
    $('#col-reorder').DataTable({
        colReorder: true
    });

    // [ Fixed-Columns ] start
    $('#fixed-columns-left').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: true,
    });
    $('#fixed-columns-left-right').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: true,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        }
    });
    $('#fixed-header, #fixed-header2 ').DataTable({
        fixedHeader: true
    });

    // [ Scrolling-table ] start
    $('#scrolling-table').DataTable({
        scrollY: 300,
        paging: false,
        keys: true
    });

    // [ Responsive-table ] start
    $('#responsive-table, .dt-responsive').DataTable({
        paging: true,
        responsive: true
    });

    $('#responsive-table-no-search').DataTable({
        paging: true,
        // Hide Search Bar
        sDom: 'lrtip'
    });

    $('#responsive-table-model').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(row) {
                        var data = row.data();
                        return 'Details for ' + data[0] + ' ' + data[1];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table'
                })
            }
        }
    });
});

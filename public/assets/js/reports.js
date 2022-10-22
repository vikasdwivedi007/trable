files_chart = null;
clients_chart = null;
rooms_chart = null;

files_chart_options = null;
clients_chart_options = null;
rooms_chart_options = null;

function getFilesReport(year = null) {
    let data = {};
    if (year) {
        data = {year: year};
    }
    $.post(files_report_url, data)
        .done(function (data) {
            if (data.success && data.data) {
                files_chart_options = getFilesChartOptions(data.data);
                loadFilesChart(files_chart_options);
                $("#files_chart_column").prop('checked', true);
            }
        })
        .fail(function (err) {
            console.log(err);
        });
}

function getClientsReport(year = null) {
    let data = {};
    if (year) {
        data = {year: year};
    }
    $.post(clients_report_url, data)
        .done(function (data) {
            if (data.success && data.data) {
                clients_chart_options = getClientsChartOptions(data.data);
                loadClientsChart(clients_chart_options);
                $("#clients_chart_column").prop('checked', true);
            }
        })
        .fail(function (err) {
            console.log(err);
        });
}

function getRoomsReport(hotel = null, year = null) {
    let data = {};
    if (year) {
        data = {year: year};
    }
    data.hotel_id = hotel;
    $.post(rooms_report_url, data)
        .done(function (data) {
            if (data.success && data.data) {
                rooms_chart_options = getRoomsChartOptions(data.data);
                loadRoomsChart(rooms_chart_options);
                $("#rooms_chart_column").prop('checked', true);
            }
        })
        .fail(function (err) {
            console.log(err);
        });
}

function getFilesChartOptions(series = null) {
    var options = {
        chart: {
            events: {
                drilldown: function (e) {
                    if (!e.seriesOptions) {
                        var chart = this;
                        chart.showLoading('Loading ...');
                        setTimeout(function () {
                            chart.hideLoading();
                            chart.addSeriesAsDrilldown(e.point, series);
                        }, 1000);
                    }
                }
            },
            plotBorderWidth: 0
        },
        title: {
            text: '',
        },
        subtitle: {},
        xAxis: {
            showEmpty: false
        },
        yAxis: {
            title: {
                margin: 10,
                text: 'No. of Files'
            },
        },
        //
        legend: {
            enabled: false,
        },
        plotOptions: {
            series: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            },
            pie: {
                plotBorderWidth: 0,
                allowPointSelect: true,
                cursor: 'pointer',
                size: '100%',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: <b>{point.y}</b>'
                }
            }
        },
        series: [{
            name: 'Files',
            colorByPoint: true,
            data: series,
        }],
        //
        drilldown: {
            series: []
        }
    };

    options.chart.renderTo = 'file-chart';
    options.chart.type = 'column';
    return options;
}

function getClientsChartOptions(series = null) {
    var options = {
        chart: {
            events: {
                drilldown: function (e) {
                    if (!e.seriesOptions) {
                        var chart = this;
                        chart.showLoading('Loading ...');
                        setTimeout(function () {
                            chart.hideLoading();
                            chart.addSeriesAsDrilldown(e.point, series);
                        }, 1000);
                    }
                }
            },
            plotBorderWidth: 0
        },
        title: {
            text: '',
        },
        subtitle: {},
        xAxis: {
            showEmpty: false
        },
        yAxis: {
            title: {
                margin: 10,
                text: 'No. of Files'
            },
        },
        //
        legend: {
            enabled: false,
        },
        plotOptions: {
            series: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            },
            pie: {
                plotBorderWidth: 0,
                allowPointSelect: true,
                cursor: 'pointer',
                size: '100%',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: <b>{point.y}</b>'
                }
            }
        },
        series: [{
            name: 'Clients',
            colorByPoint: true,
            data: series,
        }],
        //
        drilldown: {
            series: []
        }
    };

    options.chart.renderTo = 'client-chart';
    options.chart.type = 'column';
    return options;
}

function getRoomsChartOptions(series = null) {
    var options = {
        chart: {
            events: {
                drilldown: function (e) {
                    if (!e.seriesOptions) {
                        var chart = this;
                        chart.showLoading('Loading ...');
                        setTimeout(function () {
                            chart.hideLoading();
                            chart.addSeriesAsDrilldown(e.point, series);
                        }, 1000);
                    }
                }
            },
            plotBorderWidth: 0
        },
        title: {
            text: '',
        },
        subtitle: {},
        xAxis: {
            showEmpty: false
        },
        yAxis: {
            title: {
                margin: 10,
                text: 'No. of Files'
            },
        },
        //
        legend: {
            enabled: false,
        },
        plotOptions: {
            series: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            },
            pie: {
                plotBorderWidth: 0,
                allowPointSelect: true,
                cursor: 'pointer',
                size: '100%',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: <b>{point.y}</b>'
                }
            }
        },
        series: [{
            name: 'Rooms',
            colorByPoint: true,
            data: series,
        }],
        //
        drilldown: {
            series: []
        }
    };

    options.chart.renderTo = 'room-chart';
    options.chart.type = 'column';
    return options;
}

function loadFilesChart(options) {
    files_chart = new Highcharts.Chart(options);
}

function loadClientsChart(options) {
    clients_chart = new Highcharts.Chart(options);
}

function loadRoomsChart(options) {
    rooms_chart = new Highcharts.Chart(options);
}

chartfunc = function () {
    var column = document.getElementById('files_chart_column');
    if (column.checked) {
        files_chart_options.chart.renderTo = 'file-chart';
        files_chart_options.chart.type = 'column';
        files_chart = new Highcharts.Chart(files_chart_options);
    } else {
        files_chart_options.chart.renderTo = 'file-chart';
        files_chart_options.chart.type = 'pie';
        files_chart = new Highcharts.Chart(files_chart_options);
    }
};

clientschartfunc = function () {
    var column = document.getElementById('clients_chart_column');
    if (column.checked) {
        clients_chart_options.chart.renderTo = 'client-chart';
        clients_chart_options.chart.type = 'column';
        clients_chart = new Highcharts.Chart(clients_chart_options);
    } else {
        clients_chart_options.chart.renderTo = 'client-chart';
        clients_chart_options.chart.type = 'pie';
        clients_chart = new Highcharts.Chart(clients_chart_options);
    }
};

roomschartfunc = function () {
    var column = document.getElementById('rooms_chart_column');
    if (column.checked) {
        rooms_chart_options.chart.renderTo = 'room-chart';
        rooms_chart_options.chart.type = 'column';
        rooms_chart = new Highcharts.Chart(rooms_chart_options);
    } else {
        rooms_chart_options.chart.renderTo = 'room-chart';
        rooms_chart_options.chart.type = 'pie';
        rooms_chart = new Highcharts.Chart(rooms_chart_options);
    }
};

$(function () {
    getFilesReport($("#FilesChartYearDDL").val());
    getClientsReport($("#ClientsChartYearDDL").val());
    getRoomsReport($("#RoomsChartHotelDDL").val(), $("#RoomsChartYearDDL").val());

    $("#FilesChartYearDDL").change(function () {
        let year = $(this).val();
        getFilesReport(year);
    });

    $("#ClientsChartYearDDL").change(function () {
        let year = $(this).val();
        getClientsReport(year);
    });

    $("#RoomsChartYearDDL,#RoomsChartHotelDDL").change(function () {
        let year = $("#RoomsChartYearDDL").val();
        let hotel_id = $("#RoomsChartHotelDDL").val();
        getRoomsReport(hotel_id, year);
    });

});


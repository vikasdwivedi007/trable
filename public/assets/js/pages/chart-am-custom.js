'use strict';
$(document).ready(function() {
    
        // [ pie-legend chart ] start
        $(function() {
            var chart = am4core.create("am-pie-2", am4charts.PieChart3D);
            chart.data = [{
                "month": "Jan",
                "FileNo": 201
            }, {
                "month": "Feb",
                "FileNo": 165
            }, {
                "month": "Mar",
                "FileNo": 139
            }, {
                "month": "Apr",
                "FileNo": 128
            }, {
                "month": "May",
                "FileNo": 99
            }, {
                "month": "Jun",
                "FileNo": 60
            },{
                "month": "Jul",
                "FileNo": 201
            }, {
                "month": "Aug",
                "FileNo": 165
            }, {
                "month": "Sep",
                "FileNo": 139
            }, {
                "month": "Oct",
                "FileNo": 128
            }, {
                "month": "Nov",
                "FileNo": 99
            }, {
                "month": "Dec",
                "FileNo": 60
            }];
            var pieSeries = chart.series.push(new am4charts.PieSeries3D());
            pieSeries.dataFields.value = "FileNo";
            pieSeries.dataFields.category = "month";
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 2;
            pieSeries.slices.template.strokeOpacity = 1;
            pieSeries.labels.template.text = "{category}: {value.value}";
            pieSeries.slices.template.tooltipText = "{category}: {value.value}";
            
            chart.legend = new am4charts.Legend();
        });
        // [ pie-legend chart ] end




        
    // [ Bar Chart2 ] Start
    var chart = AmCharts.makeChart("bar-chart2", {
        "type": "serial",
        "theme": "light",
        "marginTop": 10,
        "marginRight": 0,
        "valueAxes": [{
            "id": "v1",
            "position": "left",
            "axisAlpha": 0,
            "lineAlpha": 0,
            "autoGridCount": false,
            "labelFunction": function (value) {
                return +Math.round(value) + "00";
            }
        }],
        "graphs": [{
            "id": "g1",
            "valueAxis": "v1",
            "lineColor": ["#1de9b6", "#1dc4e9"],
            "fillColors": ["#1de9b6", "#1dc4e9"],
            "fillAlphas": 1,
            "type": "column",
            "title": "SALES",
            "valueField": "sales",
            "columnWidth": 0.3,
            "legendValueText": "$[[value]]M",
            "balloonText": "[[title]]<br /><b style='font-size: 130%'>$[[value]]M</b>"
        }, {
            "id": "g2",
            "valueAxis": "v1",
            "lineColor": ["#a389d4", "#899ed4"],
            "fillColors": ["#a389d4", "#899ed4"],
            "fillAlphas": 1,
            "type": "column",
            "title": "VISITS ",
            "valueField": "visits",
            "columnWidth": 0.3,
            "legendValueText": "$[[value]]M",
            "balloonText": "[[title]]<br /><b style='font-size: 130%'>$[[value]]M</b>"
        }, {
            "id": "g3",
            "valueAxis": "v1",
            "lineColor": ["#04a9f5", "#049df5"],
            "fillColors": ["#04a9f5", "#049df5"],
            "fillAlphas": 1,
            "type": "column",
            "title": "CLICKS",
            "valueField": "clicks",
            "columnWidth": 0.3,
            "legendValueText": "$[[value]]M",
            "balloonText": "[[title]]<br /><b style='font-size: 130%'>$[[value]]M</b>"
        }],
        "chartCursor": {
            "pan": true,
            "valueLineEnabled": true,
            "valueLineBalloonEnabled": true,
            "cursorAlpha": 0,
            "valueLineAlpha": 0.2
        },
        "categoryField": "Year",
        "categoryAxis": {
            "dashLength": 1,
            "gridAlpha": 0,
            "axisAlpha": 0,
            "lineAlpha": 0,
            "minorGridEnabled": true
        },
        "legend": {
            "useGraphSettings": true,
            "position": "top"
        },
        "balloon": {
            "borderThickness": 1,
            "shadowAlpha": 0
        },
        "dataProvider": [{
            "Year": "2014",
            "sales": 2,
            "visits": 4,
            "clicks": 3
        }, {
            "Year": "2015",
            "sales": 4,
            "visits": 7,
            "clicks": 5
        }, {
            "Year": "2016",
            "sales": 2,
            "visits": 3,
            "clicks": 4
        }, {
            "Year": "2017",
            "sales": 4.5,
            "visits": 6,
            "clicks": 4
        }]
    });
    // [ Bar Chart2 ] end

});

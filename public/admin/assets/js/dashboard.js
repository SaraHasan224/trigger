$(function () {
    "use strict";
    if ($("#sales-revenue-chart").length) {
        var areaData = {
            labels: [
                "Jul",
                "Aug",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sept",
                "Oct",
                "Nov",
                "Dec"
            ],
            datasets: [{
                    data: [100, 125, 135, 255, 190, 365, 285, 492, 375, 520],
                    backgroundColor: [chartColors[5]],
                    borderColor: [chartColors[5]],
                    borderWidth: 1,
                    fill: "origin",
                    label: "Sales"
                },
                {
                    data: [100, 195, 195, 355, 290, 465, 385, 592, 475, 620],
                    backgroundColor: [chartColors[1]],
                    borderColor: [chartColors[1]],
                    borderWidth: 1,
                    fill: "origin",
                    label: "Marketing"
                }
            ]
        };
        var areaOptions = {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: true,
                    ticks: {
                        display: false,
                        stepSize: 100,
                        min: 100,
                        max: 700,
                        padding: 0,
                        beginAtZero: true,
                        fontSize: 12,
                        fontFamily: "'Roboto', sans-serif",
                        fontColor: "#929292",
                        fontStyle: "500"
                    },
                    gridLines: {
                        drawBorder: false,
                        color: 'rgb(93,93,93,0.2)'
                    }
                }]
            },
            legend: {
                display: false,
                legendCallback: function (chart) {
                    var text = [];
                    text.push('<ul class="legend-list">');
                    for (var i = 0; i < chart.data.datasets.length; i++) {
                        text.push(
                            '<li><span class="legend-dots" style="background:' +
                            chart.data.datasets[i].legendColor +
                            '"></span>'
                        );
                        if (chart.data.datasets[i].label) {
                            text.push(chart.data.datasets[i].label);
                        }
                        text.push("</li>");
                    }
                    text.push("</ul>");
                    return text.join("");
                }
            },
            layout: {
                padding: {
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            elements: {
                point: {
                    radius: 0
                },
                line: {
                    tension: 0
                }
            }
        };
        var ctx = document.getElementById("sales-revenue-chart").getContext("2d");
        var revenueChart = new Chart(ctx, {
            type: "line",
            data: areaData,
            options: areaOptions
        });

        $("#sales-revenue-chart-legend").html(revenueChart.generateLegend());
    }

    if ($("#current-circle-progress").length) {
        $("#current-circle-progress")
            .circleProgress({
                value: 0.73,
                size: 120,
                startAngle: -1.55,
                fill: chartColors[1]
            })
            .on("circle-animation-progress", function (event, progress, stepValue) {
                $(this)
                    .find(".circle-progress-value")
                    .text(stepValue.toFixed(2).substr(2) + "%");
            });
    }

    if ($("#sales-conversion").length) {
        var BarData = {
            labels: ["2013", "2014", "2014", "2015", "2016", "2017"],
            datasets: [{
                    label: "Profit",
                    data: [10, 19, 3, 5, 12, 3],
                    backgroundColor: chartColors[1]
                },
                {
                    label: "Sales",
                    data: [23, 12, 8, 13, 9, 17],
                    backgroundColor: chartColors[5]
                }
            ]
        };
        var BarOptions = {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }]
            },
            legend: {
                display: false
            }
        };
        var SalesConversionChartCanvas = $("#sales-conversion")
            .get(0)
            .getContext("2d");
        var SalesConversionChart = new Chart(SalesConversionChartCanvas, {
            type: "bar",
            data: BarData,
            options: BarOptions
        });
    }
});
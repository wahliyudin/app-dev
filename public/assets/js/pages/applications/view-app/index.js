"use strict";

// Class definition
var viewApp = function () {
    // Colors
    var primary = KTUtil.getCssVariableValue('--bs-primary');
    var lightPrimary = KTUtil.getCssVariableValue('--bs-primary-light');
    var success = KTUtil.getCssVariableValue('--bs-success');
    var lightSuccess = KTUtil.getCssVariableValue('--bs-success-light');
    var gray200 = KTUtil.getCssVariableValue('--bs-gray-200');
    var gray500 = KTUtil.getCssVariableValue('--bs-gray-500');

    // Private functions
    var initChart = function () {
        // init chart
        var element = document.getElementById("project_overview_chart");

        if (!element) {
            return;
        }

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [30, 45, 25],
                    backgroundColor: ['#00A3FF', '#50CD89', '#E4E6EF']
                }],
                labels: ['Active', 'Completed', 'Yet to start']
            },
            options: {
                chart: {
                    fontFamily: 'inherit'
                },
                cutoutPercentage: 75,
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                title: {
                    display: false
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'nearest',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10,
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: '#20D489',
                    titleFontColor: '#ffffff',
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        };

        var ctx = element.getContext('2d');
        var myDoughnut = new Chart(ctx, config);
    }

    var initGraph = function () {
        var element = document.getElementById("kt_project_overview_graph");
        var height = parseInt(KTUtil.css(element, 'height'));

        if (!element) {
            return;
        }

        var options = {
            series: [{
                name: 'Incomplete',
                data: [70, 70, 80, 80, 75, 75, 75]
            }, {
                name: 'Complete',
                data: [55, 55, 60, 60, 55, 55, 60]
            }],
            chart: {
                type: 'area',
                height: height,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {

            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [primary, success]
            },
            xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: gray500,
                        fontSize: '12px'
                    }
                },
                crosshairs: {
                    position: 'front',
                    stroke: {
                        color: primary,
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: undefined,
                    offsetY: 0,
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: gray500,
                        fontSize: '12px',
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                },
                y: {
                    formatter: function (val) {
                        return val + " tasks"
                    }
                }
            },
            colors: [lightPrimary, lightSuccess],
            grid: {
                borderColor: gray200,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                //size: 5,
                colors: [lightPrimary, lightSuccess],
                strokeColor: [primary, success],
                strokeWidth: 3
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }

    // Public methods
    return {
        init: function () {
            initChart();
            initGraph();
        }
    }
}();


// On document ready
KTUtil.onDOMContentLoaded(function() {
    viewApp.init();
});

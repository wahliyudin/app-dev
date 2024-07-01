"use strict";

var viewApp = function () {
    var chart;
    var primary = KTUtil.getCssVariableValue('--bs-primary');
    var lightPrimary = KTUtil.getCssVariableValue('--bs-primary-light');
    var success = KTUtil.getCssVariableValue('--bs-success');
    var lightSuccess = KTUtil.getCssVariableValue('--bs-success-light');
    var gray200 = KTUtil.getCssVariableValue('--bs-gray-200');
    var gray500 = KTUtil.getCssVariableValue('--bs-gray-500');

    var initChart = function () {
        var element = document.getElementById("project_overview_chart");
        const taskSummary = document.querySelector('input[name="task_summary"]');
        if (taskSummary) {
            var taskSummaryData = JSON.parse(taskSummary.value);
        }

        if (!element) {
            return;
        }

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: taskSummaryData.data,
                    backgroundColor: ['#00A3FF', '#50CD89', '#E4E6EF', '#F1416C']
                }],
                labels: ['Active', 'Completed', 'Yet to start', 'Overdue']
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
            series: [],
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
                opacity: 0.3
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [primary, success]
            },
            xaxis: {
                categories: [],
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

        chart = new ApexCharts(element, options);
        chart.render();
        function refreshGraph(year = null, quarter = null) {
            $.ajax({
                url: "/applications/view-app/task-overtime",
                type: "POST",
                data: {
                    year,
                    quarter
                },
                dataType: "json",
                success: function (response) {
                    chart.updateSeries([{
                        name: 'Incomplete',
                        data: response.data.incomplete
                    }, {
                        name: 'Complete',
                        data: response.data.complete
                    }]);

                    chart.updateOptions({
                        xaxis: {
                            categories: response.data.categories,
                        },
                    });
                }
            });
        }

        var year = $('select[name="quarter"]').find('option:selected').data('year');
        var quarter = $('select[name="quarter"]').val();
        refreshGraph(year, quarter);
        $('select[name="quarter"]').on('change', function (e) {
            e.preventDefault();
            var year = $(this).find('option:selected').data('year');
            var quarter = $(this).val();
            refreshGraph(year, quarter);
        });
    }

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            initChart();
            initGraph();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    viewApp.init();
});

"use strict"

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var initChart = function () {
        // init chart
        var element = document.getElementById("kt_project_list_chart");
        const currentApp = JSON.parse(document.querySelector('input[name="current_app"]').value);

        if (!element) {
            return;
        }

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: currentApp.percentages,
                    backgroundColor: ['#3E97FF', '#50CD89', '#E1E3EA', '#FFC700']
                }],
                labels: ['In Progress', 'Completed', 'Yet to start', 'Pending']
            },
            options: {
                chart: {
                    fontFamily: 'inherit'
                },
                borderWidth: 0,
                cutout: '75%',
                cutoutPercentage: 65,
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                stroke: {
                    width: 0
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
                    titleSpacing: 0,
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
        var element = document.getElementById("project_overview_chart");
        const taskSummary = JSON.parse(document.querySelector('input[name="task_summary"]').value);
        if (!element) {
            return;
        }

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: taskSummary.data,
                    backgroundColor: ['#3E97FF', '#50CD89', '#E1E3EA', '#F1416C']
                }],
                labels: ['In Progress', 'Completed', 'Yet to start', 'Overdue']
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

    initChart();
    initGraph();

    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: false,
        order: [[0, 'asc']],
        ajax: {
            type: "POST",
            url: "/home/applications"
        },
        columns: [
            {
                name: 'name',
                data: null,
                render: function (data, type, row, meta) {
                    return `<div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-3">
                                    <img src="${row.logo}" class=""
                                        alt="" />
                                </div>

                                <div class="d-flex justify-content-start flex-column">
                                    <span class="text-gray-800 fw-bold mb-1 fs-6">${row.display_name}</span>
                                    ${row.description ? `<span class="text-gray-400 fw-semibold d-block fs-7">${row.description}</span>` : ''}
                                </div>
                            </div>`
                },
            },
            {
                name: 'due_date',
                data: 'due_date',
                class: 'text-center',
            },
            {
                name: 'status',
                data: 'status',
                class: 'text-end',
            },
        ],
    });

    const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
    filterSearch.addEventListener('keyup', function (e) {
        datatable.search(e.target.value).draw();
    });
});

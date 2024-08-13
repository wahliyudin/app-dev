"use strict"

import { action } from "./components/action.js";

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var datatable = $('#request_table').DataTable({
        processing: true,
        serverSide: false,
        order: [[0, 'asc']],
        ajax: {
            type: "POST",
            url: "/history-approvals/requests/datatable"
        },
        columns: [
            {
                name: 'code',
                data: 'code',
            },
            {
                name: 'requestor',
                data: 'requestor',
            },
            {
                name: 'department',
                data: 'department',
            },
            {
                name: 'application',
                data: 'application',
            },
            {
                name: 'type_request',
                data: 'type_request',
            },
            {
                name: 'type_budget',
                data: 'type_budget',
            },
            {
                name: 'start_date',
                data: 'start_date',
            },
            {
                name: 'estimated_date',
                data: 'estimated_date',
            },
            {
                name: 'status',
                data: 'status',
            },
            {
                name: 'action',
                data: null,
                render: action,
                orderable: false,
                searchable: false
            },
        ],
    });

    const filterSearch = document.querySelector('[data-kt-access-permission-table-filter="search"]');
    filterSearch.addEventListener('change', function (e) {
        datatable.search(e.target.value).draw();
    });
})

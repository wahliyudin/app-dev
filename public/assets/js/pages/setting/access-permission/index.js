"use strict"

import { action } from "./components/action.js";

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    datatable = $('#access_permission_table').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        ajax: {
            type: "POST",
            url: "/settings/access-permission/datatable"
        },
        columns: [
            {
                name: 'nik',
                data: 'nik',
            },
            {
                name: 'nama_karyawan',
                data: 'nama_karyawan',
            },
            {
                name: 'email_perusahaan',
                data: 'email_perusahaan',
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

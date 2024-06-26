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
            url: "/requests/datatable"
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

    $('#request_table').on('click', '#btn-delete', function () {
        const _this = this;
        $(_this).attr('data-kt-indicator', 'on');
        var key = $(_this).data('key');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete now!',
            preConfirm: () => {
                return new Promise(function (resolve) {
                    $.ajax({
                        type: "DELETE",
                        url: `/requests/${key}/destroy`,
                        dataType: 'json',
                    })
                        .done(function (myAjaxJsonResponse) {
                            Swal.fire(
                                'Deleted!',
                                myAjaxJsonResponse.message,
                                'success'
                            ).then(function () {
                                datatable.ajax.reload();
                            });
                        })
                        .fail(function (erordata) {
                            if (erordata.status == 422) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Warning!',
                                    text: erordata.responseJSON
                                        .message,
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: erordata.responseJSON
                                        .message,
                                })
                            }
                        })
                })
            }
        }).then(function () {
            $(_this).attr('data-kt-indicator', 'off');
        });
    });
})

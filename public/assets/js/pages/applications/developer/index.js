"use strict"

import { handleErrors } from "../../helpers/global.js";
import { action } from "./action.js";

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const request_id = $('input[name="request_id"]').val();

    var datatable = $('#developers-table').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        order: [[0, 'asc']],
        ajax: {
            type: "POST",
            url: `/applications/${request_id}/developers/datatable`
        },
        columns: [
            {
                name: 'DT_RowIndex',
                data: 'DT_RowIndex',
            },
            {
                name: 'nik',
                data: 'nik',
            },
            {
                name: 'developer',
                data: 'developer',
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

    const filterSearch = document.querySelector('[data-kt-access-table-filter="search"]');
    filterSearch.addEventListener('change', function (e) {
        datatable.search(e.target.value).draw();
    });

    const optionFormat = (item) => {
        if (!item.id) {
            return item.text;
        }

        var span = document.createElement('span');
        var template = '';

        template += '<div class="d-flex align-items-center py-1 px-1">';
        template += '<img src="' + item.icon + '" class="rounded-circle h-40px me-3" alt="' + item.text + '"/>';
        template += '<div class="d-flex flex-column">';
        template += '<span class="fs-5 fw-bold lh-1">' + item.text + '</span>';
        template += '<span class="text-muted fs-6">' + item.subcontent + '</span>';
        template += '</div>';
        template += '</div>';

        span.innerHTML = template;

        return $(span);
    };

    $('#select-developer').select2({
        placeholder: "Select an option",
        minimumResultsForSearch: Infinity,
        templateSelection: optionFormat,
        templateResult: optionFormat,
        ajax: {
            type: "POST",
            url: '/applications/developers',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('#btn-add-developer').click(function (e) {
        e.preventDefault();
        resetForm();
    });

    $('#developers-table').on('click', '#btn-edit', function (e) {
        e.preventDefault();
        const _this = this;
        $(_this).attr('data-kt-indicator', 'on');
        const key = $(this).data('key');
        $.ajax({
            type: "GET",
            url: `/applications/developers/${key}/edit`,
            dataType: 'json',
        })
            .done(function (myAjaxJsonResponse) {
                $(_this).attr('data-kt-indicator', 'off');
                fillForm(myAjaxJsonResponse);
                $('#modal-developer').modal('show');
            })
            .fail(function (erordata) {
                $(_this).attr('data-kt-indicator', 'off');
                handleErrors(erordata);
            });
    });

    $('#developers-table').on('click', '#btn-delete', function (e) {
        e.preventDefault();
        const _this = this;
        $(_this).attr('data-kt-indicator', 'on');
        const key = $(this).data('key');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete now!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: `/applications/developers/${key}/destroy`,
                    dataType: 'json',
                })
                    .done(function (myAjaxJsonResponse) {
                        $(_this).attr('data-kt-indicator', 'off');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: myAjaxJsonResponse.message,
                        }
                        ).then(function () {
                            datatable.ajax.reload();
                        });
                    })
                    .fail(function (erordata) {
                        $(_this).attr('data-kt-indicator', 'off');
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
                    });
            }
        }).then(function () {
            $(_this).attr('data-kt-indicator', 'off');
        });
    });

    $('#modal-developer').on('click', '#btn-save', function (e) {
        e.preventDefault();
        const formData = new FormData();
        formData.append('key', $('#modal-developer input[name="key"]').val());
        formData.append('request_id', $('#modal-developer input[name="request_id"]').val());
        formData.append('developer_nik', $('#modal-developer select[name="developer_nik"]').val());
        const _this = this;
        $(_this).attr('data-kt-indicator', 'on');
        $.ajax({
            type: "POST",
            url: `/applications/developers/store`,
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                resetForm();
                $(_this).attr('data-kt-indicator', 'off');
                $('#modal-developer').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                }).then(function () {
                    datatable.ajax.reload();
                })
            },
            error: function (jqXHR) {
                $(_this).attr('data-kt-indicator', 'off');
                handleErrors(jqXHR);
            }
        });
    });

    function resetForm() {
        $('#modal-developer input[name="key"]').val('');
        $('#modal-developer select[name="developer_nik"]').val('').trigger('change');
    }

    function fillForm(data) {
        $('#modal-developer input[name="key"]').val(data.key);
        $('#modal-developer select[name="developer_nik"]').val(data.nik).trigger('change');
    }
});

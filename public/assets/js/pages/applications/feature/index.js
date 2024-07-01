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

    var datatable = $('#featrures-table').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        order: [[0, 'asc']],
        ajax: {
            type: "POST",
            url: `/applications/${request_id}/features/datatable`
        },
        columns: [
            {
                name: 'DT_RowIndex',
                data: 'DT_RowIndex',
            },
            {
                name: 'name',
                data: 'name',
            },
            {
                name: 'description',
                data: 'description',
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

    $('#btn-add-feature').click(function (e) {
        e.preventDefault();
        resetFormFeature();
    });

    $('#featrures-table').on('click', '#btn-edit', function (e) {
        e.preventDefault();
        const _this = this;
        $(_this).attr('data-kt-indicator', 'on');
        const key = $(this).data('key');
        $.ajax({
            type: "GET",
            url: `/applications/features/${key}/edit`,
            dataType: 'json',
        })
            .done(function (myAjaxJsonResponse) {
                $(_this).attr('data-kt-indicator', 'off');
                fillFormFeature(myAjaxJsonResponse);
                $('#modal-feature').modal('show');
            })
            .fail(function (erordata) {
                $(_this).attr('data-kt-indicator', 'off');
                handleErrors(erordata);
            });
    });

    $('#featrures-table').on('click', '#btn-delete', function (e) {
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
                    url: `/applications/features/${key}/destroy`,
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
                            location.reload();
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

    $('#modal-feature').on('click', '#btn-save', function (e) {
        e.preventDefault();
        const formData = new FormData();
        formData.append('key', $('#modal-feature input[name="key"]').val());
        formData.append('request_id', $('#modal-feature input[name="request_id"]').val());
        formData.append('name', $('#modal-feature input[name="name"]').val());
        formData.append('description', $('#modal-feature textarea[name="description"]').val());
        const _this = this;
        $(_this).attr('data-kt-indicator', 'on');
        $.ajax({
            type: "POST",
            url: `/applications/features/store`,
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                resetFormFeature();
                $(_this).attr('data-kt-indicator', 'off');
                $('#modal-feature').modal('hide');
                $('#modal-board select[name="feature"]').append(new Option(response.data.name, response.data.key));
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

    function resetFormFeature() {
        $('#modal-feature input[name="key"]').val('');
        $('#modal-feature input[name="name"]').val('');
        $('#modal-feature textarea[name="description"]').val('');
    }

    function fillFormFeature(data) {
        $('#modal-feature input[name="key"]').val(data.key);
        $('#modal-feature input[name="name"]').val(data.name);
        $('#modal-feature textarea[name="description"]').val(data.description);
    }
});

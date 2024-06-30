"use strict"

import { handleErrors } from "../../helpers/global.js";

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#due_date").flatpickr();

    $('#form-setting').on('click', '#btn-save', function (e) {
        e.preventDefault();
        var postData = new FormData($(`#form-setting`)[0]);
        const key = $('input[name="key"]').val();
        var _this = this;
        $(_this).attr("data-kt-indicator", "on");
        $.ajax({
            type: 'POST',
            url: `/applications/${key}/settings/store`,
            processData: false,
            contentType: false,
            data: postData,
            success: function (data) {
                $(_this).removeAttr("data-kt-indicator");
                Swal.fire({
                    text: "Setting saved successfully!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            },
            error: function (data) {
                $(_this).removeAttr("data-kt-indicator");
                handleErrors(data);
            }
        });
    });
})

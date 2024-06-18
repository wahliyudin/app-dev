"use strict"

import { handleErrors } from "../helpers/global.js";

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.flatpickr-input').flatpickr({
        altFormat: "d-m-Y",
    });

    $('select[name="pic_user"]').select2({
        placeholder: "Select an option",
        width: '100%',
        ajax: {
            type: "POST",
            url: '/requests/employees',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params
                        .term
                };
            },
            processResults: function (data) {
                return {
                    results: data.results.map(item => ({
                        id: item.id,
                        text: item.text,
                        'data-email': item.email_perusahaan
                    }))
                };
            },
            cache: true
        },
        templateSelection: function (data) {
            if (data.id) {
                $('input[name="email"]').val(data['data-email']);
            }
            return data.text;
        },
        minimumInputLength: 1,
    });

    var attachments = new Dropzone("#attachments", {
        url: "/requests/upload",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        addRemoveLinks: true,
        init: function () {
            const _this = this;
            // set default files
            const key = $('input[name="key"]').val();
            if (key) {
                $.ajax({
                    type: 'GET',
                    url: `/requests/${key}/files`,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        data.forEach(item => {
                            _this.options.addedfile.call(_this, item);
                            const extension = item.name.split('.').pop().toLowerCase();
                            if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(extension)) {
                                _this.options.thumbnail.call(_this, item, '/storage/' + item.path);
                            }
                            item.previewElement.classList.add('dz-complete');
                        });
                    },
                    error: function (jqXHR) {
                        handleErrors(jqXHR);
                    }
                });
            }

            this.on("success", function (file, response) {
                const responseData = response.find(item => item.oldname === file.name);
                if (responseData) {
                    Object.defineProperty(file, 'path', { value: responseData.path });
                }
            });
            this.on("removedfile", function (file) {
                var formData = new FormData();
                formData.append("file", file.path);
                $.ajax({
                    type: 'POST',
                    url: "/requests/remove",
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {

                    },
                    error: function (jqXHR) {
                        handleErrors(jqXHR);
                        if (file.status === Dropzone.QUEUED) {
                            _this.addFile(file)
                        } else if (file.status !== undefined) {
                            _this.emit('addedfile', file);
                        }
                    }
                });
            });
        },
    });

    $('#form-request').on('click', '#btn-submit', function (e) {
        e.preventDefault();
        var formData = new FormData();
        $.each($("#form-request").serializeArray(), function (i, field) {
            formData.append(field.name, field.value);
        });
        $.each(attachments.files, function (i, file) {
            formData.append('attachments[]', file.name);
        });
        const _this = this;
        $(_this).attr("data-kt-indicator", "on");
        $.ajax({
            type: 'POST',
            url: "/requests/store",
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $(_this).attr("data-kt-indicator", "off");
                Swal.fire({
                    text: data.message,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        window.location.href = "/requests";
                    }
                })
            },
            error: function (jqXHR) {
                $(_this).attr("data-kt-indicator", "off");
                handleErrors(jqXHR);
            }
        });
    });
});

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
            if (data.id && data['data-email']) {
                $('input[name="email"]').val(data['data-email']);
            }
            return data.text;
        },
        minimumInputLength: 1,
    });

    const isShow = $('input[name="is_show"]').val() ? JSON.parse($('input[name="is_show"]').val()) : false;

    var attachments = new Dropzone("#attachments", {
        url: "/requests/upload",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        addRemoveLinks: !isShow,
        clickable: !isShow,
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
                            const file = {
                                name: item.original_name,
                                size: item.size,
                                path: item.path,
                                newname: item.name,
                            };
                            _this.files.push(file);
                            _this.options.addedfile.call(_this, file);
                            const extension = item.name.split('.').pop().toLowerCase();
                            if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(extension)) {
                                _this.options.thumbnail.call(_this, file, item.path);
                            }
                            file._downloadLink = Dropzone.createElement(`<a class="btn btn-info w-100 btn-sm" id="bt-down" target="_blank" style="cursor:pointer;" href="${item.path}" title="Download" data-dz-download><i class="fa fa-download" style="cursor:pointer;"></i></a>`);
                            file.previewElement.appendChild(file._downloadLink);
                            file.previewElement.classList.add('dz-complete');
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
                    Object.defineProperty(file, 'newname', { value: responseData.newname });
                    file._downloadLink = Dropzone.createElement(`<a class="btn btn-info w-100 btn-sm" id="bt-down" target="_blank" style="cursor:pointer;" href="${responseData.path_download}" title="Download" data-dz-download><i class="fa fa-download" style="cursor:pointer;"></i></a>`);
                    file.previewElement.appendChild(file._downloadLink);
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
            this.on("thumbnail", function (file, dataUrl) {

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
            formData.append(`attachments[${i}][original_name]`, file.name);
            formData.append(`attachments[${i}][name]`, file.newname);
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

    $('#btn-approve').click(function (e) {
        e.preventDefault();
        var key = $(this).data('key');
        var _this = this;
        $(_this).attr("data-kt-indicator", "on");
        Swal.fire({
            title: 'Apa kamu yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin!',
            preConfirm: () => {
                return new Promise(function (resolve) {
                    $.ajax({
                        type: "POST",
                        url: `/approvals/requests/${key}/approv`,
                        dataType: 'json',
                    })
                        .done(function (myAjaxJsonResponse) {
                            $(_this).removeAttr("data-kt-indicator");
                            Swal.fire(
                                'Verified!',
                                myAjaxJsonResponse.message,
                                'success'
                            ).then(function () {
                                window.location = '/approvals/requests';
                            });
                        })
                        .fail(function (erordata) {
                            $(_this).removeAttr("data-kt-indicator");
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
                                    text: "Terdapat kesalahan sistem. Silakan lengkapi informasi yang diperlukan dan coba kembali.",
                                })
                            }
                        })
                })
            },
            willClose: () => {
                $(_this).removeAttr("data-kt-indicator");
            }
        });
    });
    $('#btn-reject').click(function (e) {
        e.preventDefault();
        var key = $(this).data('key');
        var _this = this;
        $(_this).attr("data-kt-indicator", "on");
        Swal.fire({
            title: "Tolak?",
            text: "Masukan alasan kenapa ditolak!",
            input: 'textarea',
            icon: 'warning',
            inputPlaceholder: 'Catatan',
            showCancelButton: true,
            confirmButtonText: 'Ya, tolak!',
            cancelButtonText: "Batal",
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            showLoaderOnConfirm: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'Catatan tidak boleh kosong!'
                }
            },
            preConfirm: async (note) => {
                return await $.ajax({
                    type: "POST",
                    url: `/approvals/requests/${key}/reject`,
                    data: {
                        note: note
                    },
                    dataType: 'json',
                })
                    .done(function (myAjaxJsonResponse) {
                        $(_this).removeAttr("data-kt-indicator");
                        Swal.fire(
                            'Rejected!',
                            myAjaxJsonResponse.message,
                            'success'
                        ).then(function () {
                            window.location = '/approvals/requests';
                        });
                    })
                    .fail(function (erordata) {
                        $(_this).removeAttr("data-kt-indicator");
                        if (erordata.status == 422) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning!',
                                text: erordata.responseJSON
                                    .message,
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: "Terdapat kesalahan sistem. Silakan lengkapi informasi yang diperlukan dan coba kembali.",
                            })
                        }
                    })
            },
            willClose: () => {
                $(_this).removeAttr("data-kt-indicator");
            }
        });
    });

    $('input[name="type_request"]').on('change', function (e) {
        e.preventDefault();
        var type = $(this).val();
        if (type == 'new_application' || type == 'replace_an_existing_application') {
            $('#application_name').removeClass('d-none');
            $('#application_id').addClass('d-none');
            $('#feature_name').addClass('d-none');
            $('#feature_id').addClass('d-none');
        }
        if (type == 'new_automate_application' || type == 'enhancement_to_existing_application') {
            $('#application_name').addClass('d-none');
            $('#application_id').removeClass('d-none');
        }
        if (type == 'new_automate_application') {
            $('#feature_name').removeClass('d-none');
            $('#feature_id').addClass('d-none');
        }
        if (type == 'enhancement_to_existing_application') {
            const applicationId = $('select[name="application_id"]').val();
            $('select[name="application_id"]').val(applicationId).trigger('change');
            $('#feature_name').addClass('d-none');
            $('#feature_id').removeClass('d-none');
        }
    });

    $('select[name="application_id"]').on('change', function (e) {
        e.preventDefault();
        const applicationId = $(this).val();
        if (applicationId) {
            $.ajax({
                type: "POST",
                url: `/requests/${applicationId}/features`,
                dataType: "json",
                success: function (response) {
                    $('select[name="feature_id"]').empty();
                    $('select[name="feature_id"]').append(
                        '<option value="" disabled selected>Select an option</option>'
                    )
                    $.each(response, function (key, value) {
                        $('select[name="feature_id"]').append(
                            `<option value="${value.id}">${value.name}</option>`
                        );
                    });
                },
                error: function (jqXHR) {
                    handleErrors(jqXHR);
                }
            });
        }
    });
});

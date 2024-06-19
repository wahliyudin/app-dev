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
});

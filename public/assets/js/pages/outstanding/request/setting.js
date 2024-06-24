"use strict"

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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
        multiple: true,
        ajax: {
            url: '/outstandings/requests/developers',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term // search term
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

    $('#features').repeater({
        initEmpty: false,
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },
        ready: function () {
        }
    });

    $(`#form-setting`).on('click', `#btn-submit`, function (e) {
        e.preventDefault();
        var postData = new FormData($(`#form-setting`)[0]);
        var _this = this;
        $(_this).attr("data-kt-indicator", "on");
        $.ajax({
            type: 'POST',
            url: `/outstandings/requests/store`,
            processData: false,
            contentType: false,
            data: postData,
            success: function (response) {
                $(_this).removeAttr("data-kt-indicator");
                Swal.fire(
                    'Success!',
                    response.message,
                    'success'
                ).then(function () {
                    location.reload();
                });
            },
            error: function (jqXHR, xhr, textStatus, errorThrow, exception) {
                $(_this).removeAttr("data-kt-indicator");
                if (jqXHR.status == 422) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan!',
                        text: JSON.parse(jqXHR.responseText)
                            .message,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: "Terdapat kesalahan sistem. Silakan lengkapi informasi yang diperlukan dan coba kembali.",
                    })
                }
            }
        });
    });
});

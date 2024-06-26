"use strict"

import { handleErrors } from "../helpers/global.js";
import { action } from "./components/action-feature.js";
import Board from "./components/board.js";

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#kt_app_body').attr('data-kt-app-sidebar-minimize', 'on');

    const tasks = JSON.parse($('input[name="tasks"]').val());

    const board = new Board(tasks);

    const element = '#kt_docs_jkanban_rich';
    const kanbanEl = document.querySelector(element);
    const isDragging = (e) => {
        const allBoards = kanbanEl.querySelectorAll('.kanban-drag');
        allBoards.forEach(board => {
            const dragItem = board.querySelector('.gu-transit');
            if (!dragItem) {
                return;
            }
            const containerRect = board.getBoundingClientRect();
            const itemSize = dragItem.offsetHeight;
            const dragMirror = document.querySelector('.gu-mirror');
            const mirrorRect = dragMirror.getBoundingClientRect();
            const topDiff = mirrorRect.top - containerRect.top;
            const bottomDiff = containerRect.bottom - mirrorRect.bottom;
            if (topDiff <= itemSize) {
                board.scroll({
                    top: board.scrollTop - 3,
                });
            } else if (bottomDiff <= itemSize) {
                board.scroll({
                    top: board.scrollTop + 3,
                });
            } else {
                board.scroll({
                    top: board.scrollTop,
                });
            }
        });
    }

    const kanbanHeight = kanbanEl.getAttribute('data-kt-jkanban-height');
    var kanban = new jKanban({
        element: '#kt_docs_jkanban_rich',
        gutter: '0',
        dragBoards: false,
        widthBoard: '370px',
        itemAddOptions: {
            enabled: true,
            content: `Add a card`,
            class: 'kanban-title-button btn btn-light-secondary btn-sm ps-4 pe-3 w-100 text-start text-black fs-6',
            footer: true,
        },
        boards: board.boards,
        dragEl: function (el, source) {
            document.addEventListener('mousemove', isDragging);
        },

        dragendEl: function (el) {
            document.removeEventListener('mousemove', isDragging);
        },

        dropEl: function (el, target, source, sibling) {
            if (target !== source) {
                const key = $(el).find('[data-item-key]').data('item-key');
                const status = $(target).parent().data('id');
                $.ajax({
                    type: "POST",
                    url: `/tasks/${key}/update`,
                    data: {
                        status: status
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success(`From "${response.data.from}" to "${response.data.to}"`, `Successfully moved`, { timeOut: 5000, progressBar: true, closeButton: true, })
                    },
                    error: function (jqXHR) {
                        toastr.error(jqXHR?.responseJSON?.message, `Failed moved`, { timeOut: 5000, progressBar: true, closeButton: true, })
                        kanban.removeElement(el);
                        const item = board.item({
                            id: $(el).find('[data-item-key]').data('item-key'),
                            content: $(el).find('#content').text(),
                            feature: {
                                name: $(el).find('#feature').text(),
                            }
                        });
                        kanban.addElement($(source).parent().data('id'), item);
                    }
                });
            }
        }
    });
    const allBoards = kanbanEl.querySelectorAll('.kanban-drag');
    allBoards.forEach(board => {
        board.style.maxHeight = kanbanHeight + 'px';
    });

    $('#kt_docs_jkanban_rich').on('click', '.kanban-title-button', function (e) {
        e.preventDefault();
        const parentId = $(this).parent().parent().data('id');
        resetFormBoard();
        $('input[name="status"]').val(parentId);
        $('#modal-board').modal('show');

    });

    $('#kt_docs_jkanban_rich').on('click', '#btn-edit', function (e) {
        e.preventDefault();
        const key = $(this).data('key');
        $('#modal-board').modal('show');
        $.ajax({
            type: "GET",
            url: `/tasks/${key}/edit`,
            dataType: "json",
            success: function (response) {
                fillFormBoard(response);
            },
            error: function (jqXHR) {
                handleErrors(jqXHR);
            }
        });
    });

    $('#kt_docs_jkanban_rich').on('click', '#btn-delete', function (e) {
        e.preventDefault();
        const key = $(this).data('key');
        const _this = this;
        $(_this).attr('data-kt-indicator', 'on');
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
                        url: `/tasks/${key}/destroy`,
                        dataType: 'json',
                    })
                        .done(function (myAjaxJsonResponse) {
                            Swal.fire(
                                'Deleted!',
                                myAjaxJsonResponse.message,
                                'success'
                            ).then(function () {
                                $(_this).attr('data-kt-indicator', 'off');
                                const btnDelete = document.querySelector(`#kt_docs_jkanban_rich #btn-delete[data-key="${key}"]`);
                                const nodeItem = btnDelete.parentNode.parentNode.parentNode;
                                kanban.removeElement(nodeItem);
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

    $('#modal-board').on('click', '#btn-save', function (e) {
        e.preventDefault();
        const formData = new FormData();
        const key = $('input[name="key"]').val();
        const status = $('input[name="status"]').val();
        formData.append('key', $('input[name="key"]').val());
        formData.append('status', $('input[name="status"]').val());
        formData.append('content', $('textarea[name="content"]').val());
        formData.append('feature_id', $('select[name="feature"]').val());
        const _this = this;
        $(_this).attr('data-kt-indicator', 'on');
        $.ajax({
            type: "POST",
            url: `/tasks/store`,
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                resetFormBoard();
                $(_this).attr('data-kt-indicator', 'off');
                $('#modal-board').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Task has been saved successfully',
                }).then(function () {
                    const item = board.item(response);
                    if (key) {
                        const btnEdit = document.querySelector(`#kt_docs_jkanban_rich #btn-edit[data-key="${key}"]`);
                        const nodeItem = btnEdit.parentNode.parentNode.parentNode;
                        kanban.replaceElement(nodeItem, item);
                    } else {
                        kanban.addElement(status, item);
                    }
                })
            },
            error: function (jqXHR) {
                $(_this).attr('data-kt-indicator', 'off');
                handleErrors(jqXHR);
            }
        });
    });

    function resetFormBoard() {
        $('#modal-board input[name="key"]').val('');
        $('#modal-board input[name="status"]').val('');
        $('#modal-board textarea[name="content"]').val('');
        $('#modal-board select[name="feature"]').val('').trigger('change');
    }

    function fillFormBoard(data) {
        $('#modal-board input[name="key"]').val(data.key);
        $('#modal-board input[name="status"]').val(data.status);
        $('#modal-board textarea[name="content"]').val(data.content);
        $('#modal-board select[name="feature"]').val(data.feature_id).trigger('change');
    }

    var datatable = $('#featrures-table').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        order: [[0, 'asc']],
        ajax: {
            type: "POST",
            url: "/tasks/features/datatable"
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
            url: `/tasks/features/${key}/edit`,
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
                    url: `/tasks/features/${key}/destroy`,
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
            url: `/tasks/features/store`,
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

"use strict"

import { handleErrors } from "../../helpers/global.js";
import Board from "./board.js";

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#kt_app_body').attr('data-kt-app-sidebar-minimize', 'on');
    $('#due_date').flatpickr();

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
        widthBoard: '390px',
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
                    url: `/applications/tasks/${key}/update`,
                    data: {
                        status: status
                    },
                    dataType: "json",
                    success: function (response) {
                        const item = board.item(response.data.task);
                        if (key) {
                            kanban.replaceElement(el, item);
                        } else {
                            kanban.addElement(status, item);
                        }
                        toastr.success(`From "${response.data.from}" to "${response.data.to}"`, `Successfully moved`, { timeOut: 5000, progressBar: true, closeButton: true, })
                    },
                    error: function (jqXHR) {
                        toastr.error(jqXHR?.responseJSON?.message, `Failed moved`, { timeOut: 5000, progressBar: true, closeButton: true, })
                        kanban.removeElement(el);
                        const item = board.item({
                            key: $(el).find('[data-item-key]').data('item-key'),
                            content: $(el).find('#content').text(),
                            status: $(el).find('#due_date').data('status'),
                            due_date: $(el).find('#due_date').data('date'),
                            feature_name: $(el).find('#feature').text(),
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
            url: `/applications/tasks/${key}/edit`,
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
                        url: `/applications/tasks/${key}/destroy`,
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
        const formData = new FormData($(`#modal-form`)[0]);
        const key = $('input[name="key"]').val();
        const status = $('input[name="status"]').val();
        const _this = this;
        $(_this).attr('data-kt-indicator', 'on');
        $.ajax({
            type: "POST",
            url: `/applications/tasks/store`,
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
        $('#modal-board select[name="feature_id"]').val('').trigger('change');
        $('#modal-board input[name="due_date"]').val('');
        $('#modal-board select[name="developers[]"]').val('').trigger('change');
    }

    function fillFormBoard(data) {
        $('#modal-board input[name="key"]').val(data.key);
        $('#modal-board input[name="status"]').val(data.status);
        $('#modal-board textarea[name="content"]').val(data.content);
        $('#modal-board select[name="feature_id"]').val(data.feature_id).trigger('change');
        $('#modal-board input[name="due_date"]').val(data.due_date);
        $('#modal-board select[name="developers[]"]').val(data.developers).trigger('change');
    }
});

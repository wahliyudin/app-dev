"use strict"

import { handleErrors } from "../helpers/global.js";
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
                        handleErrors(jqXHR);
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
                // handleErrors(jqXHR);
            }
        });
    });

    $('#kt_docs_jkanban_rich').on('click', '#btn-delete', function (e) {
        e.preventDefault();
        const key = $(this).data('key');
        const _this = this;
        $(_this).attr('data-progress', 'on');
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
                                $(_this).attr('data-progress', 'off');
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
            $(_this).attr('data-progress', 'off');
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
        $(_this).attr('data-progress', 'on');
        $.ajax({
            type: "POST",
            url: `/tasks/store`,
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                resetFormBoard();
                $(_this).attr('data-progress', 'off');
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
                $(_this).attr('data-progress', 'off');
                handleErrors(jqXHR);
            }
        });
    });

    function resetFormBoard() {
        $('input[name="key"]').val('');
        $('input[name="status"]').val('');
        $('textarea[name="content"]').val('');
        $('select[name="feature"]').val('').trigger('change');
    }

    function fillFormBoard(data) {
        $('input[name="key"]').val(data.key);
        $('input[name="status"]').val(data.status);
        $('textarea[name="content"]').val(data.content);
        $('select[name="feature"]').val(data.feature_id).trigger('change');
    }
});

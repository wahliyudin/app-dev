"use strict"

import { handleErrors } from "../helpers/global.js";
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
    const permission = JSON.parse($('input[name="permission"]').val());

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
        widthBoard: '380px',
        itemAddOptions: {
            enabled: permission?.is_create ?? false,
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
                            is_update: permission?.is_update ?? false,
                            is_delete: permission?.is_delete ?? false,
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
        const formData = new FormData($(`#modal-form`)[0]);
        const key = $('input[name="key"]').val();
        const status = $('input[name="status"]').val();
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


    $('#modal-board').on('hide.bs.modal', function () {
        console.log("modal closed");
        resetFormBoard();
    });

    function resetFormBoard() {
        $('#modal-board input[name="key"]').val('');
        $('#modal-board input[name="status"]').val('');
        $('#modal-board textarea[name="content"]').val('');
        $('#modal-board select[name="app_id"]').val('').trigger('change');
        $('#modal-board select[name="feature_id"]').val('').trigger('change');
        $('#modal-board input[name="temp_feature_id"]').val('');
        $('#modal-board input[name="due_date"]').val('');
        $('#modal-board input[name="temp_developers[]"]').val('');
        $('#modal-board select[name="developers[]"]').val('').trigger('change');
    }

    function fillFormBoard(data) {
        $('#modal-board input[name="key"]').val(data.key);
        $('#modal-board input[name="status"]').val(data.status);
        $('#modal-board textarea[name="content"]').val(data.content);
        $('#modal-board select[name="app_id"]').val(data.app_id).trigger('change');
        $('#modal-board input[name="temp_feature_id"]').val(data.feature_id);
        $('#modal-board input[name="due_date"]').val(data.due_date);
        $('#modal-board input[name="temp_developers[]"]').val(data.developers);
    }

    $('#modal-board').on('change', '#app_id', function (e) {
        e.preventDefault();
        const key = $(this).val();
        if (key) {
            $.ajax({
                type: "POST",
                url: `/tasks/${key}/features`,
                dataType: "json",
                success: function (response) {
                    let select = $('#modal-board select[name="feature_id"]');
                    const selectedId = $('#modal-board input[name="temp_feature_id"]').val();
                    select.empty();
                    select.append('<option value="" selected disabled>-- Select --</option>');
                    response.data.forEach(function (item, index) {
                        select.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                    select.val(selectedId).trigger('change');
                },
                error: function (jqXHR) {
                    handleErrors(jqXHR);
                }
            });
        }
    });

    $('#modal-board').on('change', '#feature', function (e) {
        e.preventDefault();
        const key = $(this).val();
        if (key) {
            $.ajax({
                type: "POST",
                url: `/tasks/${key}/developers`,
                dataType: "json",
                success: function (response) {
                    let select = $('#modal-board select[name="developers[]"]');
                    const selectedIds = $('#modal-board input[name="temp_developers[]"]').val();
                    select.empty();
                    response.data.forEach(function (item, index) {
                        select.append('<option ' + (selectedIds.includes(item.nik) ? 'selected' : '') + ' value="' + item.nik + '">' + item.developer?.nama_karyawan + '</option>');
                    });
                },
                error: function (jqXHR) {
                    handleErrors(jqXHR);
                }
            });
        }
    });

    function debounce(func, delay) {
        let debounceTimer;
        return function () {
            const context = this;
            const args = arguments;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(context, args), delay);
        };
    }

    function searchKanban(e) {
        var searchTerm = e.target.value.toLowerCase();
        var board = e.target.closest('.kanban-board');
        var items = board.querySelectorAll('.kanban-item');

        items.forEach(function (item) {
            var itemText = item.textContent.toLowerCase();

            if (itemText.includes(searchTerm)) {
                item.classList.remove('hidden');
                setTimeout(() => item.classList.remove('hide'), 10);
            } else {
                item.classList.add('hide');
                setTimeout(function () {
                    item.classList.add('hidden');
                }, 200);
            }
        });
    }

    document.querySelectorAll('#search').forEach(function (input) {
        input.addEventListener('input', debounce(searchKanban, 100));
    });

    function sortBoardByDate(boardElement, order) {
        var items = Array.from(boardElement.querySelectorAll('.kanban-item'));
        items.sort(function (a, b) {
            var dateA = new Date(a.dataset.date);
            var dateB = new Date(b.dataset.date);
            return order === 'asc' ? dateA - dateB : dateB - dateA;
        });
        items.forEach(function (item) {
            boardElement.querySelector('.kanban-drag').appendChild(item);
        });
    }

    document.querySelectorAll('#sort-button').forEach(function (button) {
        button.addEventListener('click', function () {
            var board = button.closest('.kanban-board');
            var order = button.getAttribute('data-order');
            const arrow = button.querySelector('.fa-solid');
            const orderIcon = arrow.classList.contains('fa-arrow-up-wide-short') ? 'fa-arrow-down-wide-short' : 'fa-arrow-up-wide-short';
            const newOrder = arrow.classList.contains('fa-arrow-up-wide-short') ? 'desc' : 'asc';
            arrow.classList.replace('fa-arrow-up-wide-short', orderIcon);
            arrow.classList.replace('fa-arrow-down-wide-short', orderIcon);
            button.setAttribute('data-order', newOrder);

            sortBoardByDate(board, order);
        });
    });
});

@extends('template.master')

@section('title', 'My Tasks')

@section('toolbar')
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                My Tasks
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    My Tasks
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card mt-4">
            <div class="card-body p-3">
                <div id="kt_docs_jkanban_rich" class="kanban-fixed-height scroll-y" data-kt-jkanban-height="350"></div>
            </div>
        </div>
    </div>
    <input type="hidden" name="tasks" value="{{ json_encode($tasks) }}">
@endsection

@push('modal')
    <div class="modal fade" tabindex="-1" id="modal-board">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Form Board</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="temp_feature_id">
                    <input type="hidden" name="temp_developers[]">
                    <form action="" id="modal-form">
                        <input type="hidden" name="key">
                        <input type="hidden" name="status">
                        <div class="row gap-2">
                            <div class="col-md-12">
                                <label for="">Application</label>
                                <select name="app_id" id="app_id" class="form-select" data-control="select2"
                                    data-dropdown-parent="#modal-board" data-placeholder="- Select -">
                                    <option value="" selected disabled>- Select -</option>
                                    @foreach ($apps as $app)
                                        <option value="{{ $app->id }}">{{ $app->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="">Feature</label>
                                <select name="feature_id" id="feature" class="form-select" data-control="select2"
                                    data-dropdown-parent="#modal-board" data-placeholder="- Select -">
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="">Content</label>
                                <textarea name="content" id="content" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="">Due Date</label>
                                <input type="date" name="due_date" id="due_date" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="">Developers</label>
                                <select name="developers[]" id="developers" class="form-select" data-control="select2"
                                    data-dropdown-parent="#modal-board" data-placeholder="- Select -" multiple>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary ps-4" id="btn-save">
                        <span class="indicator-label">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-save-2 fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>
                                <span>Save changes</span>
                            </div>
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="permission" value="{{ json_encode($permission) }}">
@endpush

@push('css')
    <style>
        .card-header {
            min-height: 50px !important;
        }

        .modal {
            --bs-modal-header-padding: 1rem 1rem;
            --bs-modal-padding: 1rem;
        }

        .kanban-board-header.bg-light-dark .kanban-title-board {
            --bs-text-opacity: 1;
            color: rgba(var(--bs-dark-rgb), var(--bs-text-opacity)) !important;
        }

        .kanban-board-header.bg-light-warning .kanban-title-board {
            --bs-text-opacity: 1;
            color: rgba(var(--bs-warning-rgb), var(--bs-text-opacity)) !important;
        }

        .kanban-board-header.bg-light-success .kanban-title-board {
            --bs-text-opacity: 1;
            color: rgba(var(--bs-success-rgb), var(--bs-text-opacity)) !important;
        }

        #accordian-task .accordion-button::after {
            display: none;
        }

        .kanban-item {
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .kanban-item.hide {
            opacity: 0;
            transform: scale(0.9);
        }

        .kanban-item.hidden {
            display: none;
        }

        i[class^=fa-],
        i[class*=" fa-"] {
            line-height: 0 !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/jkanban/jkanban.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/toastr/toastr.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jkanban/jkanban.bundle.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/pages/task/index.js') }}?v={{ config('app.version') }}"></script>
@endpush

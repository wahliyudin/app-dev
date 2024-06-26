@extends('template.master')

@section('title', 'Request')

@section('toolbar')
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                Request
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    Request
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">{{ $requestModel->code }}</h3>
            </div>
            <div class="card-body p-3">
                <div class="accordion mb-4" id="accordian-feature">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="accordian-feature-header">
                            <button class="accordion-button fs-4 fw-semibold" aria-expanded="true" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordian-feature-body" aria-expanded="false"
                                aria-controls="accordian-feature-body">
                                Features
                            </button>
                        </h2>
                        <div id="accordian-feature-body" class="accordion-collapse collapse show"
                            aria-labelledby="accordian-feature-header" data-bs-parent="#accordian-feature">
                            <div class="accordion-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" data-kt-access-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm ps-4" id="btn-add-feature"
                                        data-bs-toggle="modal" data-bs-target="#modal-feature">
                                        <i class="ki-duotone ki-plus fs-2"></i>Add Feature
                                    </button>
                                </div>
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="featrures-table">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="text-nowrap" style="max-width: 20px;">No</th>
                                            <th class="text-nowrap">Name</th>
                                            <th>Description</th>
                                            <th class="text-end" style="max-width: 70px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion" id="accordian-task">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="accordian-task-header">
                            <div class="accordion-button fs-4 fw-semibold" style="cursor: default !important;"
                                aria-expanded="true" type="button" aria-expanded="false">
                                Tasks
                            </div>
                        </h2>
                        <div id="accordian-task-body" class="accordion-collapse collapse show"
                            aria-labelledby="accordian-task-header" data-bs-parent="#accordian-task">
                            <div class="accordion-body">
                                <div id="kt_docs_jkanban_rich" class="kanban-fixed-height scroll-y"
                                    data-kt-jkanban-height="350"></div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body">
                    <form action="" id="modal-form">
                        <input type="hidden" name="key">
                        <input type="hidden" name="status">
                        <div class="row gap-2">
                            <div class="col-md-12">
                                <label for="">Feature</label>
                                <select name="feature" id="feature" class="form-select" data-control="select2"
                                    data-dropdown-parent="#modal-board">
                                    <option value="" selected disabled>- Select -</option>
                                    @foreach ($requestModel->features as $feature)
                                        <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="">Content</label>
                                <textarea name="content" id="content" class="form-control"></textarea>
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
    <div class="modal fade" tabindex="-1" id="modal-feature">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Form Feature</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body">
                    <form action="" id="modal-form">
                        <input type="hidden" name="key">
                        <input type="hidden" name="request_id" value="{{ $requestModel->id }}">
                        <div class="row gap-2">
                            <div class="col-md-12">
                                <label for="">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="">Description</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
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
    </style>
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/jkanban/jkanban.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/toastr/toastr.min.css') }}">
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jkanban/jkanban.bundle.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/pages/task/show.js') }}"></script>
@endpush

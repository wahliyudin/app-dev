@extends('template.master')

@section('title', 'Tasks')

@section('toolbar')
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                Tasks
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('applications.my-app.index') }}" class="text-muted text-hover-primary">
                        Applications
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Tasks</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <x-applications.header :navItemActive="$navItemActive" :application="$application" />
        <div class="row">
            <div class="col-md-12">
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
                                    @foreach ($application->request->features as $feature)
                                        <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                                    @endforeach
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
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jkanban/jkanban.bundle.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/pages/applications/task/index.js') }}"></script>
@endpush

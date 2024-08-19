@extends('template.master')

@section('title', 'Feature')

@section('toolbar')
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                Feature
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
                <li class="breadcrumb-item text-muted">Feature</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <x-applications.header :navItemActive="$navItemActive" :application="$application" />
        <input type="hidden" name="application_id" value="{{ $application?->id }}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" data-kt-access-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
                            </div>
                            @permission('application_feature_create')
                                <button type="button" class="btn btn-primary btn-sm ps-4" id="btn-add-feature"
                                    data-bs-toggle="modal" data-bs-target="#modal-feature">
                                    <i class="ki-duotone ki-plus fs-2"></i>Add Feature
                                </button>
                            @endpermission
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
    </div>
@endsection

@push('modal')
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
                        <input type="hidden" name="application_id" value="{{ $application?->id }}">
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
    </style>
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/pages/applications/feature/index.js') }}?v={{ config('app.version') }}">
    </script>
@endpush

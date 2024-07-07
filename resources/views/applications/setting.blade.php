@extends('template.master')

@section('title', 'Setting')

@section('toolbar')
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                Setting
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
                <li class="breadcrumb-item text-muted">Setting</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <x-applications.header :navItemActive="$navItemActive" :application="$application" />
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">Project Settings</div>
            </div>

            <form id="form-setting" class="form" enctype="multipart/form-data">
                <input type="hidden" name="key" value="{{ $application->getKey() }}">
                <div class="card-body p-9">
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Project Logo</div>
                        </div>
                        <div class="col-lg-8">
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url('../../assets/media/svg/avatars/blank.svg')">
                                <div class="image-input-wrapper w-125px h-125px bgi-position-center"
                                    style="background-size: 75%; background-image: url({{ $application->logo() }})">
                                </div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Project Name</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="text" class="form-control form-control-solid" name="display_name"
                                value="{{ $application->display_name }}" />
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Project Description</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <textarea name="description" class="form-control form-control-solid h-100px">{{ $application->description }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Due Date</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <div class="position-relative d-flex align-items-center">
                                <i class="ki-duotone ki-calendar-8 position-absolute ms-4 mb-1 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                </i>
                                <input class="form-control form-control-solid ps-12" name="due_date"
                                    placeholder="Pick a date" id="due_date" value="{{ $application->due_date }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Status</div>
                        </div>
                        <div class="col-xl-9">
                            <select name="status" data-control="select2" data-hide-search="true"
                                class="form-select form-select-solid">
                                @foreach (\App\Enums\Request\Application\Status::cases() as $status)
                                    <option @selected($application->status == $status) value="{{ $status->value }}">
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @permission('application_setting_update')
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-primary ps-4" id="btn-save">
                            <span class="indicator-label">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ki-duotone ki-save-2 fs-2">
                                        <i class="path1"></i>
                                        <i class="path2"></i>
                                    </i>
                                    <span>Save Changes</span>
                                </div>
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                @endpermission
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script type="module" src="{{ asset('assets/js/pages/applications/setting/index.js') }}"></script>
@endpush

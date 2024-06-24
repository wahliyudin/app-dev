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
                    Outstanding
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('outstandings.requests.index') }}" class="text-muted text-hover-primary">
                        Request </a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                    Setting
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h5 class="text-dark">Request</h5>
                </div>
                <div class="card-toolbar">
                    <h6 class="text-dark">{{ $request->code }}</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div class="w-100 w-md-50 pe-0 pe-md-4">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td style="width: 120px;">
                                        <label class="form-label m-0">Nama Pemohon</label>
                                    </td>
                                    <td style="width: 10px;">:</td>
                                    <td>
                                        {{ $formDto->nama_pemohon }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 120px;">
                                        <label class="form-label m-0">Job Title</label>
                                    </td>
                                    <td style="width: 10px;">:</td>
                                    <td>
                                        {{ $formDto->job_title }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 120px;">
                                        <label class="form-label m-0">Department</label>
                                    </td>
                                    <td style="width: 10px;">:</td>
                                    <td>
                                        {{ $formDto->department }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 120px;">
                                        <label class="form-label m-0">Application Name</label>
                                    </td>
                                    <td style="width: 10px;">:</td>
                                    <td>
                                        {{ $formDto->application_name }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="w-100 w-md-50">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td style="width: 120px;">
                                        <label class="form-label m-0">PIC User</label>
                                    </td>
                                    <td style="width: 10px;">:</td>
                                    <td>
                                        {{ $formDto->pic_user }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 120px;">
                                        <label class="form-label m-0">Estimated Project</label>
                                    </td>
                                    <td style="width: 10px;">:</td>
                                    <td>
                                        {{ $formDto->estimated_project }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 120px;">
                                        <label class="form-label m-0">Email</label>
                                    </td>
                                    <td style="width: 10px;">:</td>
                                    <td>
                                        {{ $formDto->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 120px;">
                                        <label class="form-label m-0">Date</label>
                                    </td>
                                    <td style="width: 10px;">:</td>
                                    <td>
                                        {{ $formDto->date }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <form action="" method="POST" id="form-setting">
            <input type="hidden" name="key" value="{{ $request->getKey() }}">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="text-dark">Developers</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="border rounded">
                        <select id="select-developer" class="form-select form-select-transparent" name="developers[]"
                            data-placeholder="- Select Developers -">
                        </select>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="text-dark">Features</h5>
                    </div>
                </div>
                <div class="card-body" id="features">
                    <div class="form-group">
                        <div data-repeater-list="features" class="d-flex flex-column gap-3">
                            <div data-repeater-item class="form-group d-flex align-items-end justify-content-between gap-5">
                                <div class="row" style="width: 90%;">
                                    <input type="hidden" name="key" value="">
                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Name
                                            <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="name" value="" />
                                    </div>
                                    <div class="col-md-8">
                                        <label for="description" class="form-label">Description
                                            <small class="text-danger">*</small></label>
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                </div>

                                <button type="button" data-repeater-delete class="btn btn-sm btn-icon btn-danger">
                                    <span class="svg-icon svg-icon-1"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2"
                                                rx="1" transform="rotate(-45 7.05025 15.5356)"
                                                fill="currentColor" />
                                            <rect x="8.46447" y="7.05029" width="12" height="2" rx="1"
                                                transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                                        </svg></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3 d-flex align-items-center justify-content-end">
                        <button type="button" data-repeater-create class="btn btn-sm btn-info text-white">
                            <span class="svg-icon svg-icon-2"><svg width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1"
                                        transform="rotate(-90 11 18)" fill="currentColor" />
                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                        fill="currentColor" />
                                </svg></span>
                            Add another developer
                        </button>
                    </div>
                    <div class="d-flex align-items-center justify-content-end mt-4">
                        <button type="button" class="btn btn-primary ps-4" id="btn-submit">
                            <span class="indicator-label">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ki-duotone ki-save-2 fs-2">
                                        <i class="path1"></i>
                                        <i class="path2"></i>
                                    </i>
                                    <span>Submit</span>
                                </div>
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/outstanding/request/setting.js') }}"></script>
@endpush

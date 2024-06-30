@extends('template.master')

@section('title', 'Files')

@section('toolbar')
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                Files
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
                <li class="breadcrumb-item text-muted">Files</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <x-applications.header :navItemActive="$navItemActive" :application="$application" />
        <div class="d-flex flex-wrap flex-stack my-5">
            <h3 class="fw-bold my-2">
                Application Files
                {{-- <span class="fs-6 text-gray-400 fw-semibold ms-1">{{ count($attachments) }}</span> --}}
            </h3>
            {{-- <div class="d-flex my-2">
                <div class="d-flex align-items-center position-relative me-4">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute translate-middle-y top-50 ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" id="kt_filter_search"
                        class="form-control form-control-sm form-control-solid bg-body fw-semibold fs-7 w-150px ps-11"
                        placeholder="Search" />
                </div>
            </div> --}}
        </div>
        <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
            @foreach ($attachments as $attachment)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 ">
                        <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                            <div class="text-gray-800 d-flex flex-column">
                                <div class="symbol symbol-60px mb-5">
                                    <img src="{{ asset($attachment->type_file?->pathSvgLight()) }}" class="theme-light-show"
                                        alt="" />
                                    <img src="{{ asset($attachment->type_file?->pathSvgDark()) }}" class="theme-dark-show"
                                        alt="" />
                                </div>
                                <div class="fs-5 fw-bold mb-2">
                                    {{ $attachment->display_name }}
                                </div>
                            </div>
                            <div class="fs-7 fw-semibold text-gray-400">
                                {{ $attachment->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $attachments->links() }}
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script type="module" src="{{ asset('assets/js/pages/applications/file/index.js') }}"></script>
@endpush

@extends('template.master')

@section('title', 'View Application')

@section('toolbar')
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                View Application
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
                <li class="breadcrumb-item text-muted">View Application</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <x-applications.header :navItemActive="$navItemActive" :application="$application" />
        <input type="hidden" name="application_id" value="{{ $application->id }}">
        <div class="row g-6 g-xl-9">
            <div class="col-lg-6">
                <div class="card card-flush h-lg-100">
                    <div class="card-header mt-6">
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">Tasks Summary</h3>

                            <div class="fs-6 fw-semibold text-gray-400">{{ $taskSummary->overdue }} Overdue Tasks</div>
                        </div>

                        <div class="card-toolbar">
                            <a href="{{ route('applications.tasks.index', $application->id) }}"
                                class="btn btn-light btn-sm">View Tasks</a>
                        </div>
                    </div>

                    <div class="card-body p-9 pt-5">
                        <div class="d-flex flex-wrap">
                            <div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
                                <div
                                    class="position-absolute translate-middle start-50 top-50 d-flex flex-column flex-center">
                                    <span class="fs-2qx fw-bold">{{ $taskSummary->total }}</span>
                                    <span class="fs-6 fw-semibold text-gray-400">
                                        Total Tasks
                                    </span>
                                </div>

                                <canvas id="project_overview_chart"></canvas>
                            </div>

                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                                <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                    <div class="bullet bg-primary me-3"></div>
                                    <div class="text-gray-400">Active</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $taskSummary->in_progress }}</div>
                                </div>

                                <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-400">Completed</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $taskSummary->done }}</div>
                                </div>

                                <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-400">Overdue</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $taskSummary->overdue }}</div>
                                </div>

                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-gray-300 me-3"></div>
                                    <div class="text-gray-400">Yet to start</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $taskSummary->notting }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-flush h-lg-100">
                    <div class="card-header mt-6">
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">Tasks Over Time</h3>
                            <div class="fs-6 d-flex text-gray-400 fs-6 fw-semibold">
                                <div class="d-flex align-items-center me-6">
                                    <span class="menu-bullet d-flex align-items-center me-2">
                                        <span class="bullet bg-success"></span>
                                    </span>
                                    Complete
                                </div>

                                <div class="d-flex align-items-center">
                                    <span class="menu-bullet d-flex align-items-center me-2">
                                        <span class="bullet bg-primary"></span>
                                    </span>
                                    Incomplete
                                </div>
                            </div>
                        </div>

                        <div class="card-toolbar">
                            <select name="quarter" data-control="select2" data-hide-search="true"
                                class="form-select form-select-solid form-select-sm fw-bold w-120px">
                                @foreach ($quarters as $quarter)
                                    <option data-year="{{ $quarter['year'] }}" value="{{ $quarter['quarter'] }}"
                                        @selected($quarter['is_selected'])>{{ $quarter['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-body py-0 px-5">
                        <div id="kt_project_overview_graph" class="card-rounded-bottom" style="height: 200px"></div>
                    </div>
                </div>
            </div>

            <!--begin::Col-->
            <div class="col-lg-6">
                <!--begin::Card-->
                <div class="card  card-flush h-lg-100">
                    <!--begin::Card header-->
                    <div class="card-header mt-6">
                        <!--begin::Card title-->
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">Developers</h3>

                            <div class="fs-6 text-gray-400">Total {{ $developers->count() }} developers</div>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        {{-- <div class="card-toolbar">
                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View
                                All</a>
                        </div> --}}
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card toolbar-->

                    <!--begin::Card body-->
                    <div class="card-body d-flex flex-column p-9 pt-3 mb-9">
                        @foreach ($developers as $developer)
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-5">
                                <!--begin::Avatar-->
                                <div class="me-5 position-relative">
                                    <!--begin::Image-->
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic"
                                            src="{{ \App\Data\Applications\TaskDto::avatar($developer->developer?->identity?->avatar) }}" />
                                    </div>
                                    <!--end::Image-->
                                </div>
                                <!--end::Avatar-->

                                <!--begin::Details-->
                                <div class="fw-semibold">
                                    <span
                                        class="fs-5 fw-bold text-gray-900">{{ $developer->developer?->nama_karyawan }}</span>

                                    <div class="text-gray-400">
                                        {{ $developer->user?->total_task_open }} Open &
                                        {{ $developer->user?->total_task_done }} Completed Tasks
                                    </div>
                                </div>
                                <!--end::Details-->

                                <!--begin::Badge-->
                                <div class="badge badge-light ms-auto">{{ $developer->user?->total_task_open }}</div>
                                <!--end::Badge-->
                            </div>
                            <!--end::Item-->
                        @endforeach
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->

        </div>
        <input type="hidden" name="task_summary" value="{{ json_encode($taskSummary) }}">
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script type="module" src="{{ asset('assets/js/pages/applications/view-app/index.js') }}"></script>
@endpush

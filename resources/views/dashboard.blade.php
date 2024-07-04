@extends('template.master')

@section('title', 'Dashboard')

@section('toolbar')
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                Dashboard
            </h1>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container  container-fluid ">
        <div class="row g-6 g-xl-9">
            <div class="col-lg-6 col-xxl-4">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="fs-2hx fw-bold">{{ $currentApp->total }}</div>
                        <div class="fs-4 fw-semibold text-gray-400 mb-7">Current Applications</div>
                        <div class="d-flex flex-wrap">
                            <div class="d-flex flex-center h-100px w-100px me-9 mb-5">
                                <canvas id="kt_project_list_chart"></canvas>
                                <input type="hidden" name="current_app" value="{{ json_encode($currentApp) }}">
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5 gap-3">
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-primary me-3"></div>
                                    <div class="text-gray-400">In Progress</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $currentApp->in_progress }}</div>
                                </div>
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-400">Completed</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $currentApp->completed }}</div>
                                </div>
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-gray-300 me-3"></div>
                                    <div class="text-gray-400">Yet to start</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $currentApp->yet_to_start }}</div>
                                </div>
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-warning me-3"></div>
                                    <div class="text-gray-400">Pending</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $currentApp->pending }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xxl-4">
                <div class="card card-flush h-100">
                    <div class="card-header mt-6">
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">Tasks Summary</h3>

                            <div class="fs-6 fw-semibold text-gray-400">{{ $taskSummary->overdue }} Overdue Tasks</div>
                        </div>
                    </div>

                    <div class="card-body p-4 pt-5">
                        <div class="d-flex flex-wrap">
                            <div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
                                <div
                                    class="position-absolute translate-middle start-50 top-50 d-flex flex-column flex-center">
                                    <span class="fs-2qx fw-bold">{{ $taskSummary->total }}</span>
                                    <span class="fs-6 fw-semibold text-gray-400">Total
                                        Tasks</span>
                                </div>

                                <canvas id="project_overview_chart"></canvas>
                                <input type="hidden" name="task_summary" value="{{ json_encode($taskSummary) }}">
                            </div>

                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5 gap-3">
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-primary me-3"></div>
                                    <div class="text-gray-400">In Progress</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $taskSummary->in_progress }}</div>
                                </div>

                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-400">Completed</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $taskSummary->done }}</div>
                                </div>

                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-gray-300 me-3"></div>
                                    <div class="text-gray-400">Yet to start</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $taskSummary->notting }}</div>
                                </div>

                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-400">Overdue</div>
                                    <div class="ms-auto fw-bold text-gray-700">{{ $taskSummary->overdue }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

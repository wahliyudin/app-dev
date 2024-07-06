@extends('template.master')

@section('title', 'My Applications')

@section('toolbar')
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                My Applications
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    Applications
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
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

        <div class="d-flex flex-wrap flex-stack my-5">
            <h2 class="fs-2 fw-semibold my-2">
                Applications
                <span class="fs-6 text-gray-400 ms-1">by Status</span>
            </h2>
            <div class="d-flex flex-wrap my-1">
                <div class="m-0">
                    <select name="status" data-control="select2" data-hide-search="true"
                        class="form-select form-select-sm bg-body border-body fw-bold w-125px"
                        onchange="window.location.href = this.value">
                        <option value="{{ route('applications.my-app.index') }}" selected>- All -</option>
                        @foreach (\App\Enums\Request\Application\Status::cases() as $status)
                            <option @selected(request('status') == $status->value)
                                value="{{ route('applications.my-app.index', ['status' => $status->value]) }}">
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row g-6 g-xl-9 mb-5">
            @forelse ($applications as $app)
                <div class="col-md-6 col-xl-4">
                    <a href="{{ route('applications.view-app.index', $app->id) }}" class="card border-hover-primary ">
                        <div class="card-header border-0 p-6">
                            <div class="card-title m-0">
                                <div class="symbol symbol-50px w-50px bg-light">
                                    <img src="{{ $app->logo() }}" alt="image" class="p-3" />
                                </div>
                            </div>
                            <div class="card-toolbar">
                                {!! $app->status->badge() !!}
                            </div>
                        </div>
                        <div class="card-body p-6">
                            <div class="fs-3 fw-bold text-dark">
                                {{ $app->name }}
                            </div>
                            <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">
                                {{ \Illuminate\Support\Str::limit($app->description, 100) }}
                            </p>
                            @php
                                $totalOpen = $app->features?->sum('total_open') ?? 0;
                                $totalProgress = $app->features?->sum('total_progress') ?? 0;
                                $totalDone = $app->features?->sum('total_done') ?? 0;
                                $total = $totalOpen + $totalProgress + $totalDone;
                                $progress = $total ? round(($totalDone / $total) * 100) : 0;
                            @endphp
                            <div class="d-flex flex-wrap mb-5 gap-4">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4">
                                    <div class="fs-6 text-gray-800 fw-bold">
                                        {{ \Carbon\Carbon::parse($app->due_date)->translatedFormat('M d, Y') }}
                                    </div>
                                    <div class="fw-semibold text-gray-400">Due Date</div>
                                </div>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-abstract-26 fs-3 text-secondary me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <div class="fs-6 fw-bold" data-kt-countup="true"
                                            data-kt-countup-value="{{ $totalOpen }}">
                                            0
                                        </div>
                                    </div>

                                    <div class="fw-semibold fs-8 text-gray-400">Open Tasks</div>
                                </div>

                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-abstract-26 fs-3 text-warning me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <div class="fs-6 fw-bold" data-kt-countup="true"
                                            data-kt-countup-value="{{ $totalProgress }}">
                                            0
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-8 text-gray-400">In Progress Tasks</div>
                                </div>

                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-abstract-26 fs-3 text-success me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <div class="fs-6 fw-bold" data-kt-countup="true"
                                            data-kt-countup-value="{{ $totalDone }}">
                                            0
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-8 text-gray-400">Done Tasks</div>
                                </div>
                            </div>

                            <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                title="This project {{ $progress }}% completed">
                                @php
                                    $color = 'bg-primary';
                                    if ($progress < 50) {
                                        $color = 'bg-warning';
                                    }
                                    if ($progress >= 80) {
                                        $color = 'bg-success';
                                    }
                                @endphp
                                <div class="{{ $color }} rounded h-4px" role="progressbar"
                                    style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="symbol-group symbol-hover">
                                @foreach ($app->request?->developers ?? [] as $developer)
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                        title="{{ $developer->developer?->nama_karyawan }}">
                                        <img alt="Pic"
                                            src="{{ \App\Data\Applications\TaskDto::avatar($developer->developer?->identity?->avatar) }}" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-md-12">
                    <h2 class="fs-2 fw-bold text-gray-400 text-center">No Applications</h2>
                </div>
            @endforelse
        </div>

        {{ $applications->links() }}

    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script type="module" src="{{ asset('assets/js/pages/applications/my-app/index.js') }}"></script>
@endpush

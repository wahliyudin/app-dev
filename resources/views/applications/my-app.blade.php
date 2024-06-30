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
                        <div class="fs-2hx fw-bold">237</div>
                        <div class="fs-4 fw-semibold text-gray-400 mb-7">Current Applications</div>
                        <div class="d-flex flex-wrap">
                            <div class="d-flex flex-center h-100px w-100px me-9 mb-5">
                                <canvas id="kt_project_list_chart"></canvas>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                                <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                    <div class="bullet bg-primary me-3"></div>
                                    <div class="text-gray-400">Active</div>
                                    <div class="ms-auto fw-bold text-gray-700">30</div>
                                </div>
                                <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-400">Completed</div>
                                    <div class="ms-auto fw-bold text-gray-700">45</div>
                                </div>
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-gray-300 me-3"></div>
                                    <div class="text-gray-400">Yet to start</div>
                                    <div class="ms-auto fw-bold text-gray-700">25</div>
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

                            <div class="fs-6 fw-semibold text-gray-400">24 Overdue Tasks</div>
                        </div>

                        <div class="card-toolbar">
                            <a href="#" class="btn btn-light btn-sm">View Tasks</a>
                        </div>
                    </div>

                    <div class="card-body p-4 pt-5">
                        <div class="d-flex flex-wrap">
                            <div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
                                <div
                                    class="position-absolute translate-middle start-50 top-50 d-flex flex-column flex-center">
                                    <span class="fs-2qx fw-bold">237</span>
                                    <span class="fs-6 fw-semibold text-gray-400">Total
                                        Tasks</span>
                                </div>

                                <canvas id="project_overview_chart"></canvas>
                            </div>

                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                                <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                    <div class="bullet bg-primary me-3"></div>
                                    <div class="text-gray-400">Active</div>
                                    <div class="ms-auto fw-bold text-gray-700">30</div>
                                </div>

                                <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-400">Completed</div>
                                    <div class="ms-auto fw-bold text-gray-700">45</div>
                                </div>

                                <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-400">Overdue</div>
                                    <div class="ms-auto fw-bold text-gray-700">0</div>
                                </div>

                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <div class="bullet bg-gray-300 me-3"></div>
                                    <div class="text-gray-400">Yet to start</div>
                                    <div class="ms-auto fw-bold text-gray-700">25</div>
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
                        <div class="card-header border-0 pt-9">
                            <div class="card-title m-0">
                                <div class="symbol symbol-50px w-50px bg-light">
                                    <img src="{{ $app->logo() }}" alt="image" class="p-3" />
                                </div>
                            </div>
                            <div class="card-toolbar">
                                {!! $app->status->badge() !!}
                            </div>
                        </div>
                        <div class="card-body p-9">
                            <div class="fs-3 fw-bold text-dark">
                                {{ $app->name }}
                            </div>
                            <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">
                                {{ \Illuminate\Support\Str::limit($app->description, 100) }}
                            </p>
                            <div class="d-flex flex-wrap mb-5">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                    <div class="fs-6 text-gray-800 fw-bold">
                                        {{ \Carbon\Carbon::parse($app->due_date)->translatedFormat('M d, Y') }}
                                    </div>
                                    <div class="fw-semibold text-gray-400">Due Date</div>
                                </div>
                            </div>
                            <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                title="This project 50% completed">
                                <div class="bg-primary rounded h-4px" role="progressbar" style="width: 50%"
                                    aria-valuenow=" 50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="symbol-group symbol-hover">
                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                    title="Emma Smith">
                                    <img alt="Pic" src="../../assets/media/avatars/300-6.jpg" />
                                </div>
                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                    title="Rudy Stone">
                                    <img alt="Pic" src="../../assets/media/avatars/300-1.jpg" />
                                </div>
                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                    title="Susan Redwood">
                                    <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                                </div>
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

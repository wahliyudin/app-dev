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
        <div class="row g-6 g-xl-9">
            <div class="col-lg-6">
                <div class="card card-flush h-lg-100">
                    <div class="card-header mt-6">
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">Tasks Summary</h3>

                            <div class="fs-6 fw-semibold text-gray-400">24 Overdue Tasks</div>
                        </div>

                        <div class="card-toolbar">
                            <a href="#" class="btn btn-light btn-sm">View Tasks</a>
                        </div>
                    </div>

                    <div class="card-body p-9 pt-5">
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

                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed  p-6">

                            <div class="d-flex flex-stack flex-grow-1 ">
                                <div class=" fw-semibold">
                                    <div class="fs-6 text-gray-700 ">
                                        <a href="#" class="fw-bold me-1">Invite New .NET
                                            Collaborators</a> to create great outstanding
                                        business to business .jsp modutr class scripts
                                    </div>
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
                            <select name="status" data-control="select2" data-hide-search="true"
                                class="form-select form-select-solid form-select-sm fw-bold w-100px">
                                <option value="1">2020 Q1</option>
                                <option value="2">2020 Q2</option>
                                <option value="3" selected>2020 Q3</option>
                                <option value="4">2020 Q4</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-body pt-10 pb-0 px-5">
                        <div id="kt_project_overview_graph" class="card-rounded-bottom" style="height: 300px"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-flush h-lg-100">
                    <div class="card-header mt-6">
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">What's on the road?</h3>
                            <div class="fs-6 text-gray-400">Total 482 participants</div>
                        </div>

                        <div class="card-toolbar">
                            <select name="status" data-control="select2" data-hide-search="true"
                                class="form-select form-select-solid form-select-sm fw-bold w-100px">
                                <option value="1" selected>Options</option>
                                <option value="2">Option 1</option>
                                <option value="3">Option 2</option>
                                <option value="4">Option 3</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-body p-9 pt-4">
                        <ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2">
                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary "
                                    data-bs-toggle="tab" href="#kt_schedule_day_0">

                                    <span class="opacity-50 fs-7 fw-semibold">Su</span>
                                    <span class="fs-6 fw-bold">22</span>
                                </a>
                            </li>
                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary active"
                                    data-bs-toggle="tab" href="#kt_schedule_day_1">
                                    <span class="opacity-50 fs-7 fw-semibold">Mo</span>
                                    <span class="fs-6 fw-bold">23</span>
                                </a>
                            </li>
                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary "
                                    data-bs-toggle="tab" href="#kt_schedule_day_2">
                                    <span class="opacity-50 fs-7 fw-semibold">Tu</span>
                                    <span class="fs-6 fw-bold">24</span>
                                </a>
                            </li>
                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary "
                                    data-bs-toggle="tab" href="#kt_schedule_day_3">

                                    <span class="opacity-50 fs-7 fw-semibold">We</span>
                                    <span class="fs-6 fw-bold">25</span>
                                </a>
                            </li>
                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary "
                                    data-bs-toggle="tab" href="#kt_schedule_day_4">
                                    <span class="opacity-50 fs-7 fw-semibold">Th</span>
                                    <span class="fs-6 fw-bold">26</span>
                                </a>
                            </li>
                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary "
                                    data-bs-toggle="tab" href="#kt_schedule_day_5">

                                    <span class="opacity-50 fs-7 fw-semibold">Fr</span>
                                    <span class="fs-6 fw-bold">27</span>
                                </a>
                            </li>
                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary "
                                    data-bs-toggle="tab" href="#kt_schedule_day_6">

                                    <span class="opacity-50 fs-7 fw-semibold">Sa</span>
                                    <span class="fs-6 fw-bold">28</span>
                                </a>
                            </li>

                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary "
                                    data-bs-toggle="tab" href="#kt_schedule_day_7">

                                    <span class="opacity-50 fs-7 fw-semibold">Su</span>
                                    <span class="fs-6 fw-bold">29</span>
                                </a>
                            </li>

                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary "
                                    data-bs-toggle="tab" href="#kt_schedule_day_8">

                                    <span class="opacity-50 fs-7 fw-semibold">Mo</span>
                                    <span class="fs-6 fw-bold">30</span>
                                </a>
                            </li>

                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary "
                                    data-bs-toggle="tab" href="#kt_schedule_day_9">

                                    <span class="opacity-50 fs-7 fw-semibold">Tu</span>
                                    <span class="fs-6 fw-bold">31</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="kt_schedule_day_0" class="tab-pane fade show ">
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>

                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <div class="fs-5">
                                            14:30 - 15:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>

                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Marketing Campaign Discussion </a>
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Yannis Gloverson</a>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                </div>
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <div class="fs-5">
                                            11:00 - 11:45

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                am </span>
                                        </div>
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Sales Pitch Proposal </a>
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Terry Robins</a>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                </div>
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <div class="fs-5">
                                            12:00 - 13:00

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Committee Review Approvals </a>
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Michael Walters</a>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                </div>
                            </div>
                            <div id="kt_schedule_day_1" class="tab-pane fade show active">
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <div class="fs-5">
                                            12:00 - 13:00

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Weekly Team Stand-Up </a>
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Mark Randall</a>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                </div>
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <div class="fs-5">
                                            13:00 - 14:00

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            9 Degree Project Estimation Meeting </a>
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Peter Marcus</a>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                </div>
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <div class="fs-5">
                                            13:00 - 14:00

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Team Backlog Grooming Session </a>
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Bob Harris</a>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                </div>
                            </div>
                            <div id="kt_schedule_day_2" class="tab-pane fade show ">
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <div class="fs-5">
                                            12:00 - 13:00

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Committee Review Approvals </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Karina Clarke</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            11:00 - 11:45

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                am </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Project Review & Testing </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Peter Marcus</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            12:00 - 13:00

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Marketing Campaign Discussion </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Terry Robins</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                            </div>
                            <!--end::Day-->
                            <!--begin::Day-->
                            <div id="kt_schedule_day_3" class="tab-pane fade show ">
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            11:00 - 11:45

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                am </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Team Backlog Grooming Session </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">David Stevenson</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            16:30 - 17:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Creative Content Initiative </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Walter White</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            11:00 - 11:45

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                am </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Committee Review Approvals </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Terry Robins</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                            </div>
                            <!--end::Day-->
                            <!--begin::Day-->
                            <div id="kt_schedule_day_4" class="tab-pane fade show ">
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            11:00 - 11:45

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                am </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Project Review & Testing </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Karina Clarke</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            14:30 - 15:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Lunch & Learn Catch Up </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Naomi Hayabusa</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            11:00 - 11:45

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                am </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Lunch & Learn Catch Up </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Terry Robins</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                            </div>
                            <!--end::Day-->
                            <!--begin::Day-->
                            <div id="kt_schedule_day_5" class="tab-pane fade show ">
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            16:30 - 17:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Project Review & Testing </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Terry Robins</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            11:00 - 11:45

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                am </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Sales Pitch Proposal </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Michael Walters</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            14:30 - 15:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Weekly Team Stand-Up </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Yannis Gloverson</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                            </div>
                            <!--end::Day-->
                            <!--begin::Day-->
                            <div id="kt_schedule_day_6" class="tab-pane fade show ">
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            14:30 - 15:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Sales Pitch Proposal </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Peter Marcus</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            13:00 - 14:00

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Development Team Capacity Review </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Kendell Trevor</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            16:30 - 17:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Committee Review Approvals </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Caleb Donaldson</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                            </div>
                            <!--end::Day-->
                            <!--begin::Day-->
                            <div id="kt_schedule_day_7" class="tab-pane fade show ">
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            14:30 - 15:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Development Team Capacity Review </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Terry Robins</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            16:30 - 17:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            9 Degree Project Estimation Meeting </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">David Stevenson</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            16:30 - 17:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Dashboard UI/UX Design Review </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Yannis Gloverson</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                            </div>
                            <!--end::Day-->
                            <!--begin::Day-->
                            <div id="kt_schedule_day_8" class="tab-pane fade show ">
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            13:00 - 14:00

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Creative Content Initiative </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Terry Robins</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            11:00 - 11:45

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                am </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Creative Content Initiative </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Michael Walters</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            16:30 - 17:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Marketing Campaign Discussion </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Naomi Hayabusa</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                            </div>
                            <!--end::Day-->
                            <!--begin::Day-->
                            <div id="kt_schedule_day_9" class="tab-pane fade show ">
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            16:30 - 17:30

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Sales Pitch Proposal </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Yannis Gloverson</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            12:00 - 13:00

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                pm </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Marketing Campaign Discussion </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Bob Harris</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <!--end::Bar-->

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            9:00 - 10:00

                                            <span class="fs-7 text-gray-400 text-uppercase">
                                                am </span>
                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                            Creative Content Initiative </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            Lead by <a href="#">Michael Walters</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->
                            </div>
                            <!--end::Day-->
                        </div>
                        <!--end::Tab Content-->
                    </div>
                    <!--end::Card body-->
                </div>
            </div>

            <!--begin::Col-->
            <div class="col-lg-6">

                <!--begin::Card-->
                <div class="card card-flush h-lg-100">
                    <!--begin::Card header-->
                    <div class="card-header mt-6">
                        <!--begin::Card title-->
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">Latest Files</h3>

                            <div class="fs-6 text-gray-400">Total 382 fiels, 2,6GB space usage
                            </div>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View
                                All</a>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body p-9 pt-3">
                        <!--begin::Files-->
                        <div class="d-flex flex-column mb-9">
                            <!--begin::File-->
                            <div class="d-flex align-items-center mb-5">
                                <!--begin::Icon-->
                                <div class="symbol symbol-30px me-5">
                                    <img alt="Icon" src="../../assets/media/svg/files/pdf.svg" />
                                </div>
                                <!--end::Icon-->

                                <!--begin::Details-->
                                <div class="fw-semibold">
                                    <a class="fs-6 fw-bold text-dark text-hover-primary" href="#">Project tech
                                        requirements</a>

                                    <div class="text-gray-400">
                                        2 days ago <a href="#">Karina Clark</a>
                                    </div>
                                </div>
                                <!--end::Details-->

                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                    <i class="ki-duotone ki-element-plus fs-3"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span></i>
                                </button>



                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                    id="kt_menu_645a632eeaed3">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Form-->
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Status:</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <div>
                                                <select class="form-select form-select-solid" data-kt-select2="true"
                                                    data-placeholder="Select option"
                                                    data-dropdown-parent="#kt_menu_645a632eeaed3" data-allow-clear="true">
                                                    <option></option>
                                                    <option value="1">Approved</option>
                                                    <option value="2">Pending</option>
                                                    <option value="2">In Process</option>
                                                    <option value="2">Rejected</option>
                                                </select>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Member
                                                Type:</label>
                                            <!--end::Label-->

                                            <!--begin::Options-->
                                            <div class="d-flex">
                                                <!--begin::Options-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input" type="checkbox" value="1" />
                                                    <span class="form-check-label">
                                                        Author
                                                    </span>
                                                </label>
                                                <!--end::Options-->

                                                <!--begin::Options-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="2"
                                                        checked="checked" />
                                                    <span class="form-check-label">
                                                        Customer
                                                    </span>
                                                </label>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Notifications:</label>
                                            <!--end::Label-->

                                            <!--begin::Switch-->
                                            <div
                                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="notifications" checked />
                                                <label class="form-check-label">
                                                    Enabled
                                                </label>
                                            </div>
                                            <!--end::Switch-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                data-kt-menu-dismiss="true">Reset</button>

                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-kt-menu-dismiss="true">Apply</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Form-->
                                </div>
                                <!--end::Menu 1--> <!--end::Menu-->
                            </div>
                            <!--end::File-->
                            <!--begin::File-->
                            <div class="d-flex align-items-center mb-5">
                                <!--begin::Icon-->
                                <div class="symbol symbol-30px me-5">
                                    <img alt="Icon" src="../../assets/media/svg/files/doc.svg" />
                                </div>
                                <!--end::Icon-->

                                <!--begin::Details-->
                                <div class="fw-semibold">
                                    <a class="fs-6 fw-bold text-dark text-hover-primary" href="#">Create FureStibe
                                        branding proposal</a>

                                    <div class="text-gray-400">
                                        Due in 1 day <a href="#">Marcus Blake</a>
                                    </div>
                                </div>
                                <!--end::Details-->

                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                    <i class="ki-duotone ki-element-plus fs-3"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span></i>
                                </button>



                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                    id="kt_menu_645a632eeaee6">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Form-->
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Status:</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <div>
                                                <select class="form-select form-select-solid" data-kt-select2="true"
                                                    data-placeholder="Select option"
                                                    data-dropdown-parent="#kt_menu_645a632eeaee6" data-allow-clear="true">
                                                    <option></option>
                                                    <option value="1">Approved</option>
                                                    <option value="2">Pending</option>
                                                    <option value="2">In Process</option>
                                                    <option value="2">Rejected</option>
                                                </select>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Member
                                                Type:</label>
                                            <!--end::Label-->

                                            <!--begin::Options-->
                                            <div class="d-flex">
                                                <!--begin::Options-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input" type="checkbox" value="1" />
                                                    <span class="form-check-label">
                                                        Author
                                                    </span>
                                                </label>
                                                <!--end::Options-->

                                                <!--begin::Options-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="2"
                                                        checked="checked" />
                                                    <span class="form-check-label">
                                                        Customer
                                                    </span>
                                                </label>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Notifications:</label>
                                            <!--end::Label-->

                                            <!--begin::Switch-->
                                            <div
                                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="notifications" checked />
                                                <label class="form-check-label">
                                                    Enabled
                                                </label>
                                            </div>
                                            <!--end::Switch-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                data-kt-menu-dismiss="true">Reset</button>

                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-kt-menu-dismiss="true">Apply</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Form-->
                                </div>
                                <!--end::Menu 1--> <!--end::Menu-->
                            </div>
                            <!--end::File-->
                            <!--begin::File-->
                            <div class="d-flex align-items-center mb-5">
                                <!--begin::Icon-->
                                <div class="symbol symbol-30px me-5">
                                    <img alt="Icon" src="../../assets/media/svg/files/css.svg" />
                                </div>
                                <!--end::Icon-->

                                <!--begin::Details-->
                                <div class="fw-semibold">
                                    <a class="fs-6 fw-bold text-dark text-hover-primary" href="#">Completed Project
                                        Stylings</a>

                                    <div class="text-gray-400">
                                        Due in 1 day <a href="#">Terry Barry</a>
                                    </div>
                                </div>
                                <!--end::Details-->

                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                    <i class="ki-duotone ki-element-plus fs-3"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span></i>
                                </button>



                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                    id="kt_menu_645a632eeaef4">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Form-->
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Status:</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <div>
                                                <select class="form-select form-select-solid" data-kt-select2="true"
                                                    data-placeholder="Select option"
                                                    data-dropdown-parent="#kt_menu_645a632eeaef4" data-allow-clear="true">
                                                    <option></option>
                                                    <option value="1">Approved</option>
                                                    <option value="2">Pending</option>
                                                    <option value="2">In Process</option>
                                                    <option value="2">Rejected</option>
                                                </select>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Member
                                                Type:</label>
                                            <!--end::Label-->

                                            <!--begin::Options-->
                                            <div class="d-flex">
                                                <!--begin::Options-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input" type="checkbox" value="1" />
                                                    <span class="form-check-label">
                                                        Author
                                                    </span>
                                                </label>
                                                <!--end::Options-->

                                                <!--begin::Options-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="2"
                                                        checked="checked" />
                                                    <span class="form-check-label">
                                                        Customer
                                                    </span>
                                                </label>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Notifications:</label>
                                            <!--end::Label-->

                                            <!--begin::Switch-->
                                            <div
                                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="notifications" checked />
                                                <label class="form-check-label">
                                                    Enabled
                                                </label>
                                            </div>
                                            <!--end::Switch-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                data-kt-menu-dismiss="true">Reset</button>

                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-kt-menu-dismiss="true">Apply</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Form-->
                                </div>
                                <!--end::Menu 1--> <!--end::Menu-->
                            </div>
                            <!--end::File-->
                            <!--begin::File-->
                            <div class="d-flex align-items-center ">
                                <!--begin::Icon-->
                                <div class="symbol symbol-30px me-5">
                                    <img alt="Icon" src="../../assets/media/svg/files/ai.svg" />
                                </div>
                                <!--end::Icon-->

                                <!--begin::Details-->
                                <div class="fw-semibold">
                                    <a class="fs-6 fw-bold text-dark text-hover-primary" href="#">Create Project
                                        Wireframes</a>

                                    <div class="text-gray-400">
                                        Due in 3 days <a href="#">Roth Bloom</a>
                                    </div>
                                </div>
                                <!--end::Details-->

                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                    <i class="ki-duotone ki-element-plus fs-3"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span></i>
                                </button>



                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                    id="kt_menu_645a632eeaf02">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Form-->
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Status:</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <div>
                                                <select class="form-select form-select-solid" data-kt-select2="true"
                                                    data-placeholder="Select option"
                                                    data-dropdown-parent="#kt_menu_645a632eeaf02" data-allow-clear="true">
                                                    <option></option>
                                                    <option value="1">Approved</option>
                                                    <option value="2">Pending</option>
                                                    <option value="2">In Process</option>
                                                    <option value="2">Rejected</option>
                                                </select>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Member
                                                Type:</label>
                                            <!--end::Label-->

                                            <!--begin::Options-->
                                            <div class="d-flex">
                                                <!--begin::Options-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input" type="checkbox" value="1" />
                                                    <span class="form-check-label">
                                                        Author
                                                    </span>
                                                </label>
                                                <!--end::Options-->

                                                <!--begin::Options-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="2"
                                                        checked="checked" />
                                                    <span class="form-check-label">
                                                        Customer
                                                    </span>
                                                </label>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Notifications:</label>
                                            <!--end::Label-->

                                            <!--begin::Switch-->
                                            <div
                                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="notifications" checked />
                                                <label class="form-check-label">
                                                    Enabled
                                                </label>
                                            </div>
                                            <!--end::Switch-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                data-kt-menu-dismiss="true">Reset</button>

                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-kt-menu-dismiss="true">Apply</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Form-->
                                </div>
                                <!--end::Menu 1--> <!--end::Menu-->
                            </div>
                            <!--end::File-->

                        </div>
                        <!--end::Files-->


                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed  p-6">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-svg/files/upload.svg fs-2tx text-primary me-4"></i>
                            <!--end::Icon-->

                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1 ">
                                <!--begin::Content-->
                                <div class=" fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">Quick file uploader</h4>

                                    <div class="fs-6 text-gray-700 ">Drag & Drop or choose files
                                        from computer</div>
                                </div>
                                <!--end::Content-->

                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Notice-->
                    </div>
                    <!--end::Card body -->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-6">
                <!--begin::Card-->
                <div class="card  card-flush h-lg-100">
                    <!--begin::Card header-->
                    <div class="card-header mt-6">
                        <!--begin::Card title-->
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">New Contibutors</h3>

                            <div class="fs-6 text-gray-400">From total 482 Participants</div>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View
                                All</a>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card toolbar-->

                    <!--begin::Card body-->
                    <div class="card-body d-flex flex-column p-9 pt-3 mb-9">

                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-5">
                            <!--begin::Avatar-->
                            <div class="me-5 position-relative">
                                <!--begin::Image-->
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="../../assets/media/avatars/300-6.jpg" />
                                </div>
                                <!--end::Image-->

                            </div>
                            <!--end::Avatar-->

                            <!--begin::Details-->
                            <div class="fw-semibold">
                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Emma
                                    Smith</a>

                                <div class="text-gray-400">
                                    8 Pending & 97 Completed Tasks </div>
                            </div>
                            <!--end::Details-->

                            <!--begin::Badge-->
                            <div class="badge badge-light ms-auto">5</div>
                            <!--end::Badge-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-5">
                            <!--begin::Avatar-->
                            <div class="me-5 position-relative">
                                <!--begin::Image-->
                                <div class="symbol symbol-35px symbol-circle">
                                    <span class="symbol-label bg-light-danger text-danger fw-semibold">
                                        M </span>
                                </div>
                                <!--end::Image-->

                                <!--begin::Online-->
                                <div
                                    class="bg-success position-absolute h-8px w-8px rounded-circle translate-middle start-100 top-100 ms-n1 mt-n1">
                                </div>
                                <!--end::Online-->
                            </div>
                            <!--end::Avatar-->

                            <!--begin::Details-->
                            <div class="fw-semibold">
                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Melody
                                    Macy</a>

                                <div class="text-gray-400">
                                    5 Pending & 84 Completed </div>
                            </div>
                            <!--end::Details-->

                            <!--begin::Badge-->
                            <div class="badge badge-light ms-auto">8</div>
                            <!--end::Badge-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-5">
                            <!--begin::Avatar-->
                            <div class="me-5 position-relative">
                                <!--begin::Image-->
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="../../assets/media/avatars/300-1.jpg" />
                                </div>
                                <!--end::Image-->

                            </div>
                            <!--end::Avatar-->

                            <!--begin::Details-->
                            <div class="fw-semibold">
                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Max
                                    Smith</a>

                                <div class="text-gray-400">
                                    9 Pending & 103 Completed </div>
                            </div>
                            <!--end::Details-->

                            <!--begin::Badge-->
                            <div class="badge badge-light ms-auto">9</div>
                            <!--end::Badge-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-5">
                            <!--begin::Avatar-->
                            <div class="me-5 position-relative">
                                <!--begin::Image-->
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="../../assets/media/avatars/300-5.jpg" />
                                </div>
                                <!--end::Image-->

                            </div>
                            <!--end::Avatar-->

                            <!--begin::Details-->
                            <div class="fw-semibold">
                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Sean
                                    Bean</a>

                                <div class="text-gray-400">
                                    3 Pending & 55 Completed </div>
                            </div>
                            <!--end::Details-->

                            <!--begin::Badge-->
                            <div class="badge badge-light ms-auto">3</div>
                            <!--end::Badge-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-center ">
                            <!--begin::Avatar-->
                            <div class="me-5 position-relative">
                                <!--begin::Image-->
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="../../assets/media/avatars/300-25.jpg" />
                                </div>
                                <!--end::Image-->

                            </div>
                            <!--end::Avatar-->

                            <!--begin::Details-->
                            <div class="fw-semibold">
                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Brian
                                    Cox</a>

                                <div class="text-gray-400">
                                    4 Pending & 115 Completed </div>
                            </div>
                            <!--end::Details-->

                            <!--begin::Badge-->
                            <div class="badge badge-light ms-auto">4</div>
                            <!--end::Badge-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-6">

                <!--begin::Tasks-->
                <div class="card card-flush h-lg-100">
                    <!--begin::Card header-->
                    <div class="card-header mt-6">
                        <!--begin::Card title-->
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">My Tasks</h3>

                            <div class="fs-6 text-gray-400">Total 25 tasks in backlog</div>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View
                                All</a>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body d-flex flex-column mb-9 p-9 pt-3">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center position-relative mb-7">
                            <!--begin::Label-->
                            <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px">
                            </div>
                            <!--end::Label-->

                            <!--begin::Checkbox-->
                            <div class="form-check form-check-custom form-check-solid ms-6 me-4">
                                <input class="form-check-input" type="checkbox" value="" />
                            </div>
                            <!--end::Checkbox-->

                            <!--begin::Details-->
                            <div class="fw-semibold">
                                <a href="#" class="fs-6 fw-bold text-gray-900 text-hover-primary">Create
                                    FureStibe branding logo</a>

                                <!--begin::Info-->
                                <div class="text-gray-400">
                                    Due in 1 day <a href="#">Karina Clark</a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Details-->

                            <!--begin::Menu-->
                            <button type="button"
                                class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                <i class="ki-duotone ki-element-plus fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span
                                        class="path4"></span><span class="path5"></span></i> </button>



                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="kt_menu_645a632eeaf9e">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                </div>
                                <!--end::Header-->

                                <!--begin::Menu separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Menu separator-->

                                <!--begin::Form-->
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Status:</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid" data-kt-select2="true"
                                                data-placeholder="Select option"
                                                data-dropdown-parent="#kt_menu_645a632eeaf9e" data-allow-clear="true">
                                                <option></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="2">In Process</option>
                                                <option value="2">Rejected</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Member
                                            Type:</label>
                                        <!--end::Label-->

                                        <!--begin::Options-->
                                        <div class="d-flex">
                                            <!--begin::Options-->
                                            <label
                                                class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                                <span class="form-check-label">
                                                    Author
                                                </span>
                                            </label>
                                            <!--end::Options-->

                                            <!--begin::Options-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    checked="checked" />
                                                <span class="form-check-label">
                                                    Customer
                                                </span>
                                            </label>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Notifications:</label>
                                        <!--end::Label-->

                                        <!--begin::Switch-->
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="notifications" checked />
                                            <label class="form-check-label">
                                                Enabled
                                            </label>
                                        </div>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                            data-kt-menu-dismiss="true">Reset</button>

                                        <button type="submit" class="btn btn-sm btn-primary"
                                            data-kt-menu-dismiss="true">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Menu 1--> <!--end::Menu-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center position-relative mb-7">
                            <!--begin::Label-->
                            <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px">
                            </div>
                            <!--end::Label-->

                            <!--begin::Checkbox-->
                            <div class="form-check form-check-custom form-check-solid ms-6 me-4">
                                <input class="form-check-input" type="checkbox" value="" />
                            </div>
                            <!--end::Checkbox-->

                            <!--begin::Details-->
                            <div class="fw-semibold">
                                <a href="#" class="fs-6 fw-bold text-gray-900 text-hover-primary">Schedule
                                    a meeting with FireBear CTO John</a>

                                <!--begin::Info-->
                                <div class="text-gray-400">
                                    Due in 3 days <a href="#">Rober Doe</a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Details-->

                            <!--begin::Menu-->
                            <button type="button"
                                class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                <i class="ki-duotone ki-element-plus fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span
                                        class="path4"></span><span class="path5"></span></i> </button>



                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="kt_menu_645a632eeafab">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                </div>
                                <!--end::Header-->

                                <!--begin::Menu separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Menu separator-->

                                <!--begin::Form-->
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Status:</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid" data-kt-select2="true"
                                                data-placeholder="Select option"
                                                data-dropdown-parent="#kt_menu_645a632eeafab" data-allow-clear="true">
                                                <option></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="2">In Process</option>
                                                <option value="2">Rejected</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Member
                                            Type:</label>
                                        <!--end::Label-->

                                        <!--begin::Options-->
                                        <div class="d-flex">
                                            <!--begin::Options-->
                                            <label
                                                class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                                <span class="form-check-label">
                                                    Author
                                                </span>
                                            </label>
                                            <!--end::Options-->

                                            <!--begin::Options-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    checked="checked" />
                                                <span class="form-check-label">
                                                    Customer
                                                </span>
                                            </label>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Notifications:</label>
                                        <!--end::Label-->

                                        <!--begin::Switch-->
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="notifications" checked />
                                            <label class="form-check-label">
                                                Enabled
                                            </label>
                                        </div>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                            data-kt-menu-dismiss="true">Reset</button>

                                        <button type="submit" class="btn btn-sm btn-primary"
                                            data-kt-menu-dismiss="true">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Menu 1--> <!--end::Menu-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center position-relative mb-7">
                            <!--begin::Label-->
                            <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px">
                            </div>
                            <!--end::Label-->

                            <!--begin::Checkbox-->
                            <div class="form-check form-check-custom form-check-solid ms-6 me-4">
                                <input class="form-check-input" type="checkbox" value="" />
                            </div>
                            <!--end::Checkbox-->

                            <!--begin::Details-->
                            <div class="fw-semibold">
                                <a href="#" class="fs-6 fw-bold text-gray-900 text-hover-primary">9
                                    Degree Porject Estimation</a>

                                <!--begin::Info-->
                                <div class="text-gray-400">
                                    Due in 1 week <a href="#">Neil Owen</a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Details-->

                            <!--begin::Menu-->
                            <button type="button"
                                class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                <i class="ki-duotone ki-element-plus fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span
                                        class="path4"></span><span class="path5"></span></i> </button>



                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="kt_menu_645a632eeafb7">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                </div>
                                <!--end::Header-->

                                <!--begin::Menu separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Menu separator-->

                                <!--begin::Form-->
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Status:</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid" data-kt-select2="true"
                                                data-placeholder="Select option"
                                                data-dropdown-parent="#kt_menu_645a632eeafb7" data-allow-clear="true">
                                                <option></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="2">In Process</option>
                                                <option value="2">Rejected</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Member
                                            Type:</label>
                                        <!--end::Label-->

                                        <!--begin::Options-->
                                        <div class="d-flex">
                                            <!--begin::Options-->
                                            <label
                                                class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                                <span class="form-check-label">
                                                    Author
                                                </span>
                                            </label>
                                            <!--end::Options-->

                                            <!--begin::Options-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    checked="checked" />
                                                <span class="form-check-label">
                                                    Customer
                                                </span>
                                            </label>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Notifications:</label>
                                        <!--end::Label-->

                                        <!--begin::Switch-->
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="notifications" checked />
                                            <label class="form-check-label">
                                                Enabled
                                            </label>
                                        </div>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset"
                                            class="btn btn-sm btn-light btn-active-light-primary me-2"
                                            data-kt-menu-dismiss="true">Reset</button>

                                        <button type="submit" class="btn btn-sm btn-primary"
                                            data-kt-menu-dismiss="true">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Menu 1--> <!--end::Menu-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center position-relative mb-7">
                            <!--begin::Label-->
                            <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px">
                            </div>
                            <!--end::Label-->

                            <!--begin::Checkbox-->
                            <div class="form-check form-check-custom form-check-solid ms-6 me-4">
                                <input class="form-check-input" type="checkbox" value="" />
                            </div>
                            <!--end::Checkbox-->

                            <!--begin::Details-->
                            <div class="fw-semibold">
                                <a href="#" class="fs-6 fw-bold text-gray-900 text-hover-primary">Dashgboard
                                    UI & UX for Leafr CRM</a>

                                <!--begin::Info-->
                                <div class="text-gray-400">
                                    Due in 1 week <a href="#">Olivia Wild</a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Details-->

                            <!--begin::Menu-->
                            <button type="button"
                                class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                <i class="ki-duotone ki-element-plus fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span
                                        class="path4"></span><span class="path5"></span></i> </button>



                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="kt_menu_645a632eeafc4">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                </div>
                                <!--end::Header-->

                                <!--begin::Menu separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Menu separator-->

                                <!--begin::Form-->
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Status:</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid" data-kt-select2="true"
                                                data-placeholder="Select option"
                                                data-dropdown-parent="#kt_menu_645a632eeafc4" data-allow-clear="true">
                                                <option></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="2">In Process</option>
                                                <option value="2">Rejected</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Member
                                            Type:</label>
                                        <!--end::Label-->

                                        <!--begin::Options-->
                                        <div class="d-flex">
                                            <!--begin::Options-->
                                            <label
                                                class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                                <span class="form-check-label">
                                                    Author
                                                </span>
                                            </label>
                                            <!--end::Options-->

                                            <!--begin::Options-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    checked="checked" />
                                                <span class="form-check-label">
                                                    Customer
                                                </span>
                                            </label>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Notifications:</label>
                                        <!--end::Label-->

                                        <!--begin::Switch-->
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="notifications" checked />
                                            <label class="form-check-label">
                                                Enabled
                                            </label>
                                        </div>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset"
                                            class="btn btn-sm btn-light btn-active-light-primary me-2"
                                            data-kt-menu-dismiss="true">Reset</button>

                                        <button type="submit" class="btn btn-sm btn-primary"
                                            data-kt-menu-dismiss="true">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Menu 1--> <!--end::Menu-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center position-relative ">
                            <!--begin::Label-->
                            <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px">
                            </div>
                            <!--end::Label-->

                            <!--begin::Checkbox-->
                            <div class="form-check form-check-custom form-check-solid ms-6 me-4">
                                <input class="form-check-input" type="checkbox" value="" />
                            </div>
                            <!--end::Checkbox-->

                            <!--begin::Details-->
                            <div class="fw-semibold">
                                <a href="#" class="fs-6 fw-bold text-gray-900 text-hover-primary">Mivy
                                    App R&D, Meeting with clients</a>

                                <!--begin::Info-->
                                <div class="text-gray-400">
                                    Due in 2 weeks <a href="#">Sean Bean</a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Details-->

                            <!--begin::Menu-->
                            <button type="button"
                                class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                <i class="ki-duotone ki-element-plus fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span
                                        class="path4"></span><span class="path5"></span></i> </button>



                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="kt_menu_645a632eeafd0">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                </div>
                                <!--end::Header-->

                                <!--begin::Menu separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Menu separator-->

                                <!--begin::Form-->
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Status:</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid" data-kt-select2="true"
                                                data-placeholder="Select option"
                                                data-dropdown-parent="#kt_menu_645a632eeafd0" data-allow-clear="true">
                                                <option></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="2">In Process</option>
                                                <option value="2">Rejected</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Member
                                            Type:</label>
                                        <!--end::Label-->

                                        <!--begin::Options-->
                                        <div class="d-flex">
                                            <!--begin::Options-->
                                            <label
                                                class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                                <span class="form-check-label">
                                                    Author
                                                </span>
                                            </label>
                                            <!--end::Options-->

                                            <!--begin::Options-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    checked="checked" />
                                                <span class="form-check-label">
                                                    Customer
                                                </span>
                                            </label>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Notifications:</label>
                                        <!--end::Label-->

                                        <!--begin::Switch-->
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="notifications" checked />
                                            <label class="form-check-label">
                                                Enabled
                                            </label>
                                        </div>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset"
                                            class="btn btn-sm btn-light btn-active-light-primary me-2"
                                            data-kt-menu-dismiss="true">Reset</button>

                                        <button type="submit" class="btn btn-sm btn-primary"
                                            data-kt-menu-dismiss="true">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Menu 1--> <!--end::Menu-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Tasks-->
            </div>
            <!--end::Col-->
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script type="module" src="{{ asset('assets/js/pages/applications/view-app/index.js') }}"></script>
@endpush

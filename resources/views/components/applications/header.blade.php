<div class="card mb-6 mb-xl-9">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <div
                class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                <img class="mw-50px mw-lg-75px" src="../../assets/media/svg/brand-logos/volicity-9.svg" alt="image" />
            </div>

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-1">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">
                                CRM Dashboard
                            </a>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <span class="badge badge-light-success fs-6 me-auto">In
                            Progress
                        </span>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-start">
                    <div class="d-flex flex-wrap">
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">29 Januari, 2023</div>
                            </div>

                            <div class="fw-semibold fs-6 text-gray-400">Due Date</div>
                        </div>

                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="75">0</div>
                            </div>

                            <div class="fw-semibold fs-6 text-gray-400">Open Tasks</div>
                        </div>

                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="75">0</div>
                            </div>
                            <div class="fw-semibold fs-6 text-gray-400">In Progress Tasks</div>
                        </div>

                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="75">0</div>
                            </div>
                            <div class="fw-semibold fs-6 text-gray-400">Done Tasks</div>
                        </div>
                    </div>

                    <div class="symbol-group symbol-hover mb-3">
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
                            <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michael Eberon">
                            <img alt="Pic" src="../../assets/media/avatars/300-11.jpg" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="separator"></div>

        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            @foreach (\App\Enums\Applications\NavItem::cases() as $navItem)
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 {{ $navItem === $navItemActive ? 'active' : '' }}"
                        href="{{ $navItem->url($application->id) }}">
                        {{ $navItem->label() }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

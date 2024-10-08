<div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('home') }}">
            <img alt="Logo" src="{{ asset('assets/media/logos/Logo-TBU-white.png') }}"
                class="h-30px app-sidebar-logo-default" />
        </a>
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-sm h-30px w-30px rotate "
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-double-left fs-2 rotate-180"><span class="path1"></span><span
                    class="path2"></span></i>
        </div>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
            <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">
                @permission('dashboard_dashboard_read')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-home-2 fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                @endpermission
                @permission('request_read')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('requests.*') ? 'active' : '' }}"
                            href="{{ route('requests.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-call fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                    <i class="path6"></i>
                                    <i class="path7"></i>
                                    <i class="path8"></i>
                                </i>
                            </span>
                            <span class="menu-title">Request</span>
                        </a>
                    </div>
                @endpermission
                @permission('request_approve|request_reject')
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion" id="approval">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-notepad-bookmark fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                    <i class="path6"></i>
                                </i>
                            </span>
                            <span class="menu-title">History Approval</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div
                            class="menu-sub menu-sub-accordion {{ request()->routeIs('history-approvals.requests.*') ? 'hover show' : '' }}">
                            @permission('request_approve|request_reject')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('history-approvals.requests.*') ? 'active' : '' }}"
                                        href="{{ route('history-approvals.requests.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Request</span>
                                    </a>
                                </div>
                            @endpermission
                        </div>
                    </div>
                @endpermission
                @permission('request_approve|request_reject')
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion" id="approval">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-check fs-2"></i>
                            </span>
                            <span class="menu-title">Approval</span>
                            <span class="menu-badge">
                                <span class="badge badge-success" id="grand-total"><i
                                        class="fa-solid fa-arrows-spin fa-spin text-white"></i></span>
                            </span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div
                            class="menu-sub menu-sub-accordion {{ request()->routeIs('approvals.requests.*') ? 'hover show' : '' }}">
                            @permission('request_approve|request_reject')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('approvals.requests.*') ? 'active' : '' }}"
                                        href="{{ route('approvals.requests.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Request</span>
                                        <span class="menu-badge">
                                            <span class="badge badge-success" id="request"><i
                                                    class="fa-solid fa-arrows-spin fa-spin text-white"></i></span>
                                        </span>
                                    </a>
                                </div>
                            @endpermission
                        </div>
                    </div>
                @endpermission
                @role('developer')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}"
                            href="{{ route('tasks.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-frame fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                </i>
                            </span>
                            <span class="menu-title">My Tasks</span>
                            <span class="menu-badge">
                                <span class="badge badge-success" id="task">
                                    <i class="fa-solid fa-arrows-spin fa-spin text-white"></i>
                                </span>
                            </span>
                        </a>
                    </div>
                @endrole
                @permission('application_task_read|application_feature_read|application_file_read|application_developer_read|application_setting_read')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('applications.*') ? 'active' : '' }}"
                            href="{{ route('applications.my-app.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-abstract-41 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Applications</span>
                        </a>
                    </div>
                @endpermission
                @permission('setting_access_permission_read')
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-setting fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>
                            </span>
                            <span class="menu-title">Setting</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div
                            class="menu-sub menu-sub-accordion {{ request()->routeIs('settings.approval.*', 'settings.access-permission.*') ? 'hover show' : '' }}">
                            @permission('setting_approval_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('settings.approval.*') ? 'active' : '' }}"
                                        href="{{ route('settings.approval.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Approval</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('setting_access_permission_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('settings.access-permission.*') ? 'active' : '' }}"
                                        href="{{ route('settings.access-permission.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Access Permission</span>
                                    </a>
                                </div>
                            @endpermission
                        </div>
                    </div>
                @endpermission
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>

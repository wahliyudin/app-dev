@extends('template.master')

@section('title', 'Access Permission')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Access Permission
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('settings.access-permission.index') }}" class="text-muted text-hover-primary">
                            Access Permission </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Edit Access Permission</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="formInput" method="POST" action="{{ route('settings.access-permission.update', $user->getKey()) }}">
                @method('PUT')
                @csrf
                <div class="d-flex align-items-center justify-content-between mb-2 ms-3">
                    <div class="form-check">
                        <input class="form-check-input all" type="checkbox" name="all" id="all" />
                        <label class="form-check-label" for="all">Select All</label>
                    </div>
                    <div class="d-flex align-items-center gap-4">
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" @checked($role->assigned) type="checkbox" name="roles[]"
                                    value="{{ $role->getKey() }}" id="{{ $role->name }}" />
                                <label class="form-check-label" for="{{ $role->name }}">{{ $role->display_name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <table id="momTable" width="100%" cellpadding="0" cellspacing="0" border="0"
                    class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Main Menu</th>
                            <th>
                                Modul
                            </th>
                            <th colspan="6">Available Fitur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sidebars as $sidebar)
                            @php
                                $sidebarChildren = isset($sidebar['children']) ? $sidebar['children'] : [];
                                $total = 0;
                                foreach ($sidebarChildren as $child) {
                                    $total =
                                        $total +
                                        collect($child['permissions'])
                                            ->pluck('assigned')
                                            ->sum();
                                }
                            @endphp
                            @if (count($sidebarChildren) > 0)
                                <tr>
                                    <td rowspan="{{ count($sidebarChildren) + 1 }}">
                                        <input class="form-check-input checkall_modul"
                                            {{ $total >= count($sidebarChildren) ? 'checked' : '' }} type="checkbox"
                                            value="{{ $sidebar['name'] }}" name="menu">
                                        {{ $sidebar['title'] }}
                                    </td>
                                </tr>
                            @endif
                            @forelse ($sidebarChildren as $children)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input checkall_fitur {{ $sidebar['name'] }}"
                                                type="checkbox" value="{{ $sidebar['name'] }}"
                                                {{ collect($children['permissions'])->pluck('assigned')->sum() > 0? 'checked': '' }}
                                                name="modul[]">
                                            {{ $children['title'] }}
                                        </div>
                                    </td>
                                    @foreach ($children['permissions'] as $permission)
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input fitur sub_{{ $sidebar['name'] }}"
                                                    data-modulid="{{ $sidebar['name'] }}" type="checkbox"
                                                    value="{{ $permission->getKey() }}"
                                                    {{ $permission->assigned ? 'checked' : '' }} name="permissions[]">
                                                {{ $permission->display }}
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input checkall_fitur {{ $sidebar['name'] }}"
                                                type="checkbox" value="{{ $sidebar['name'] }}"
                                                {{ collect($sidebar['permissions'])->pluck('assigned')->sum() > 0? 'checked': '' }}
                                                name="modul[]">
                                            {{ $sidebar['title'] }}
                                        </div>
                                    </td>
                                    <td></td>
                                    @foreach ($sidebar['permissions'] as $permission)
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input fitur sub_{{ $sidebar['name'] }}"
                                                    data-modulid="{{ $sidebar['name'] }}" type="checkbox"
                                                    value="{{ $permission->getKey() }}"
                                                    {{ $permission->assigned ? 'checked' : '' }} name="permissions[]">
                                                {{ $permission->display }}
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforelse
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/setting/access-permission/edit.js') }}"></script>
@endpush

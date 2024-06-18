<form action="" id="form-request">
    <input type="hidden" name="key" value="{{ $requestModel?->getKey() }}">
    <input type="hidden" name="department_id" value="{{ $formDto?->department_id }}">
    <input type="hidden" name="nik_requestor" value="{{ $requestModel?->nik_requestor ?? userAuth()?->nik }}">
    <x-form-header title="SYSTEM APPLICATION DEVELOPMENT" nomor="TBU-FM-IST-003" tanggal="01-03-2020" revisi="00"
        halaman="1 dari 1" />
    <hr>
    <table>
        <tbody>
            <tr>
                <td class="form-label">RQ#</td>
                <td class="form-label" style="width: 10px;">:</td>
                <td class="form-label">{{ $code }}
                    <input type="hidden" name="code" value="{{ $code }}">
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
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
                            <input type="text" readonly class="form-control form-control-transparent form-control-sm"
                                value="{{ $formDto->nama_pemohon }}">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 120px;">
                            <label class="form-label m-0">Job Title</label>
                        </td>
                        <td style="width: 10px;">:</td>
                        <td>
                            <input type="text" name="job_title" placeholder="Job Title"
                                class="form-control form-control-sm" value="{{ $formDto->job_title }}">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 120px;">
                            <label class="form-label m-0">Department</label>
                        </td>
                        <td style="width: 10px;">:</td>
                        <td>
                            <input type="text" readonly name="department" value="{{ $formDto->department }}"
                                class="form-control form-control-transparent form-control-sm">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 120px;">
                            <label class="form-label m-0">Application Name</label>
                        </td>
                        <td style="width: 10px;">:</td>
                        <td>
                            @if ($isShow)
                                {{ $formDto->application_name }}
                            @else
                                <select class="form-select form-select-sm" data-control="select2" data-tags="true"
                                    name="application_name" data-placeholder="Select an option">
                                    @foreach ($apps as $app)
                                        <option @selected($app->id == $requestModel?->application_id) value="{{ $app->id }}">
                                            {{ $app->display_name }}</option>
                                    @endforeach
                                </select>
                            @endif
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
                            @if ($isShow)
                                {{ $formDto->pic_user }}
                            @else
                                <select class="form-select form-select-sm" name="pic_user">
                                    @if ($requestModel)
                                        <option selected value="{{ $requestModel?->pic->nik }}">
                                            {{ $requestModel?->pic?->nik . ' - ' . $requestModel?->pic?->nama_karyawan }}
                                        </option>
                                    @endif
                                </select>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 120px;">
                            <label class="form-label m-0">Estimated Project</label>
                        </td>
                        <td style="width: 10px;">:</td>
                        <td>
                            @if ($isShow)
                                {{ $formDto->estimated_project }}
                            @else
                                <input class="form-control form-control-sm flatpickr-input"
                                    placeholder="Estimated Project" name="estimated_project"
                                    value="{{ $requestModel?->estimated_project }}" />
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 120px;">
                            <label class="form-label m-0">Email</label>
                        </td>
                        <td style="width: 10px;">:</td>
                        <td>
                            @if ($isShow)
                                {{ $formDto->email }}
                            @else
                                <input class="form-control form-control-transparent form-control-sm" placeholder="Email"
                                    type="email" readonly name="email" value="{{ $formDto->email }}" />
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 120px;">
                            <label class="form-label m-0">Date</label>
                        </td>
                        <td style="width: 10px;">:</td>
                        <td>
                            @if ($isShow)
                                {{ $formDto->date }}
                            @else
                                <input class="form-control form-control-sm flatpickr-input" placeholder="Date"
                                    name="date" value="{{ $requestModel?->date }}" />
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <table class="w-100 w-md-50">
        <tbody>
            <tr>
                <td colspan="2" class="pb-3">
                    <label class="form-label m-0">Service Request</label>
                </td>
            </tr>
            @foreach (\App\Enums\Request\TypeRequest::cases() as $typeRequest)
                <tr>
                    <td>
                        <input class="form-check-input custom-check custom-check-rectangle"
                            style="width: 18px; height: 18px;" type="radio" value="{{ $typeRequest->value }}"
                            name="type_request" @checked($requestModel?->type_request == $typeRequest)>
                    </td>
                    <td>{{ $typeRequest->label() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <table class="w-100 w-md-50">
        <tbody>
            <tr>
                <td style="width: 120px;">
                    <label class="form-label m-0">Budget</label>
                </td>
                <td style="width: 10px;">:</td>
                @foreach (\App\Enums\Request\TypeBudget::cases() as $typeBudget)
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="form-check-input custom-check custom-check-rectangle"
                                            style="width: 18px; height: 18px;" type="radio"
                                            value="{{ $typeBudget->value }}" name="type_budget"
                                            @checked($requestModel?->type_budget == $typeBudget)>
                                    </td>
                                    <td>{{ $typeBudget->label() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
    <hr>
    <div class="form-group">
        <label for="description" class="form-label">Detail Description of the Requested Service</label>
        <textarea name="description" id="description" class="form-control">{{ $requestModel?->description }}</textarea>
    </div>
    <hr>
    <div class="form-group">
        <label for="attachments" class="form-label">Attachments</label>
        <div class="dropzone" id="attachments">
            <div class="dz-message needsclick">
                <i class="ki-duotone ki-file-up fs-3x text-primary">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="ms-4">
                    <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                    <span class="fs-7 fw-semibold text-gray-400">Upload up to 10 files</span>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-2">
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
</form>

@push('css')
    <link href="{{ asset('assets/css/pages/global.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script type="module" src="{{ asset('assets/js/pages/request/form.js') }}"></script>
@endpush

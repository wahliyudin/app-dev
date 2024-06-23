<div class="col-md-12 d-flex justify-content-center">
    <table class="text-center w-100">
        <tbody>
            <tr>
                @php
                    $background = 'bg-warning';
                @endphp
                @foreach ($workflows as $workflow)
                    @php
                        if ($workflow->last_action == \App\Enums\Workflows\LastAction::REJECT) {
                            $background = 'bg-danger';
                        } elseif ($workflow->last_action == \App\Enums\Workflows\LastAction::APPROV) {
                            $background = 'bg-success';
                        } else {
                            $background = $background == 'bg-danger' ? 'bg-danger' : 'bg-warning';
                        }
                    @endphp
                    <td style="text-transform: uppercase !important; width: 155px; {{ $workflow->sequence == 1 ? 'border-top-left-radius: 10px' : ($workflow->sequence == count($workflows) ? 'border-top-right-radius: 10px;' : '') }};"
                        class="{{ $background }} text-white px-3 fs-6 fw-semibold {{ $workflow->sequence != 1 ? 'border-start' : '' }}">
                        {{ $workflow->last_action == \App\Enums\Workflows\LastAction::REJECT ? 'rejected' : $workflow->title }}
                        By</td>
                @endforeach
            </tr>
            <tr>
                @php
                    $background = 'bg-warning';
                @endphp
                @foreach ($workflows as $workflow)
                    @php
                        if ($workflow->last_action == \App\Enums\Workflows\LastAction::REJECT) {
                            $background = 'bg-danger';
                        } elseif ($workflow->last_action == \App\Enums\Workflows\LastAction::APPROV) {
                            $background = 'bg-success';
                        } else {
                            $background = $background == 'bg-danger' ? 'bg-danger' : 'bg-warning';
                        }
                    @endphp
                    <td style="width: 155px; vertical-align: top;"
                        class="{{ $background }} text-white px-3 {{ $workflow->sequence != 1 ? 'border-start' : '' }}">
                        {{ $workflow?->employee?->nama_karyawan }}</td>
                @endforeach
            </tr>
            <tr class="border-top">
                @php
                    $background = 'bg-warning';
                @endphp
                @foreach ($workflows as $workflow)
                    @php
                        if ($workflow->last_action == \App\Enums\Workflows\LastAction::REJECT) {
                            $background = 'bg-danger';
                        } elseif ($workflow->last_action == \App\Enums\Workflows\LastAction::APPROV) {
                            $background = 'bg-success';
                        } else {
                            $background = $background == 'bg-danger' ? 'bg-danger' : 'bg-warning';
                        }
                    @endphp
                    <td style="text-transform: uppercase !important; width: 155px;"
                        class="{{ $background }} text-white px-3 fs-6 fw-semibold {{ $workflow->sequence != 1 ? 'border-start' : '' }}">
                        {{ $workflow->last_action == \App\Enums\Workflows\LastAction::REJECT ? 'rejected' : $workflow->title }}
                        On</td>
                @endforeach
            </tr>
            <tr>
                @php
                    $background = 'bg-warning';
                @endphp
                @foreach ($workflows as $workflow)
                    @php
                        if ($workflow->last_action == \App\Enums\Workflows\LastAction::REJECT) {
                            $background = 'bg-danger';
                        } elseif ($workflow->last_action == \App\Enums\Workflows\LastAction::APPROV) {
                            $background = 'bg-success';
                        } else {
                            $background = $background == 'bg-danger' ? 'bg-danger' : 'bg-warning';
                        }
                    @endphp
                    <td style="width: 155px; {{ $workflow->sequence == 1 ? 'border-bottom-left-radius: 10px' : ($workflow->sequence == count($workflows) ? 'border-bottom-right-radius: 10px;' : '') }};"
                        class="{{ $background }} text-white px-3 {{ $workflow->sequence != 1 ? 'border-start' : '' }}">
                        {{ in_array($workflow->last_action, [\App\Enums\Workflows\LastAction::APPROV, \App\Enums\Workflows\LastAction::REJECT]) ? $workflow?->last_action_date : '-' }}
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

<?php

namespace App\View\Components\Request;

use App\Data\Requests\FormDto;
use App\Domain\Services\RequestService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $requestModel = null,
        public $isShow = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        /** @var RequestService $requestService */
        $requestService = app(RequestService::class);
        return view('components.request.form', [
            'formDto' => $this->requestModel ? FormDto::fromModel($this->requestModel) : FormDto::fromDefault(),
            'code' => $this->requestModel ? $this->requestModel->code : $requestService->generateCode(),
        ]);
    }
}

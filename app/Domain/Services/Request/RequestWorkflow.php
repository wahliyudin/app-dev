<?php

namespace App\Domain\Services\Request;

use App\Domain\Workflows\Workflow;
use App\Enums\Request\TypeRequest;
use App\Enums\Workflows\Module;
use App\Jobs\Request\ApprovalJob;
use App\Models\Request\Request;
use Illuminate\Database\Eloquent\Model;

class RequestWorkflow extends Workflow
{
    public static function setModel(Request $request)
    {
        return new self($request, Module::REQUEST);
    }

    protected function handleStoreWorkflow()
    {
        dispatch(new ApprovalJob('emails.request.approv', $this->model, $this->currentWorkflow()));
    }

    protected function handleIsLastAndApprov()
    {
        /** @var RequestService $requestService */
        $requestService = app(RequestService::class);
        if ($this->model->type_request === TypeRequest::NEW_AUTOMATE_APPLICATION) {
            $requestService->storeNewFeature($this->model->application_id, $this->model->feature_name, $this->model->description);
        }
        if ($this->model->type_request === TypeRequest::ENHANCEMENT_TO_EXISTING_APPLICATION) {
            $requestService->storeTaskRevision($this->model->feature_id, $this->model->estimated_project, $this->model->description);
        }
        dispatch(new ApprovalJob('emails.request.close', $this->model));
    }

    protected function handleIsNotLastAndApprov()
    {
        dispatch(new ApprovalJob('emails.request.approv', $this->model, $this->nextWorkflow()));
    }

    protected function handleIsRejected()
    {
        dispatch(new ApprovalJob('emails.request.reject', $this->model));
    }

    protected function handleChanges(Model $request) {}
}

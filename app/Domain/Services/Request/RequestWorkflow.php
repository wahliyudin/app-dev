<?php

namespace App\Domain\Services\Request;

use App\Domain\Workflows\Workflow;
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
        dispatch(new ApprovalJob('emails.request.approv', $this->model, $this->nextWorkflow()));
    }

    protected function handleIsLastAndApprov()
    {
        dispatch(new ApprovalJob('emails.request.close', $this->model, $this->nextWorkflow()));
    }

    protected function handleIsNotLastAndApprov()
    {
        dispatch(new ApprovalJob('emails.request.approv', $this->model, $this->nextWorkflow()));
    }

    protected function handleIsRejected()
    {
        dispatch(new ApprovalJob('emails.request.reject', $this->model, $this->nextWorkflow()));
    }

    protected function handleChanges(Model $request)
    {
    }
}

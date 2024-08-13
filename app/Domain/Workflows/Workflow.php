<?php

namespace App\Domain\Workflows;

use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Module;
use App\Enums\Workflows\Status;
use App\Models\Setting\SettingApproval;
use App\Domain\API\HCIS\ApprovalRepository as HCISApprovalRepository;
use App\Domain\Gateway\Services\WorkflowService;
use App\Domain\Repositories\Setting\ApprovalRepository;
use App\Domain\Workflows\Repositories\WorkflowRepository;
use App\Domain\Workflows\Contracts\ModelThatHaveWorkflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

abstract class Workflow
{
    use Checker;

    protected array $additionalParams = [];

    protected \Closure $condition;

    public function __construct(
        protected Model $model,
        protected Module $module,
    ) {
        $this->checkModel();
        $this->condition = function ($approval) {
            return true;
        };
    }

    private function checkModel()
    {
        if (!$this->model instanceof ModelThatHaveWorkflow) {
            throw new \Exception("Model must be implements " . ModelThatHaveWorkflow::class);
        }
    }

    public function approvals()
    {
        $approvals = $this->approvalsByModule();

        $data = $this->prepareApprovals($approvals);

        $response = $this->patchDataWorkflows($data, userAuth()?->nik);
        return collect($response)->except('employee', 'last_action_date');
    }

    private function approvalsByModule(): Collection
    {
        return ApprovalRepository::getByModule($this->module);
    }

    private function prepareApprovals(Collection $approvals): array
    {
        $data = [];
        foreach ($approvals as $key => $approval) {
            if (!($this->condition)($approval)) break;
            array_push($data, $this->payloadApprovalForHRIS($approval, $key++));
        }
        return $data;
    }

    private function payloadApprovalForHRIS(SettingApproval $approval, $sequence): array
    {
        $payload = [
            'approval' => $approval->approval->valueByHRIS(),
            'nik' => $approval->nik,
            'title' => $approval->title
        ];
        foreach ($this->additionalParams as $param) {
            if ((isset($param['sequence']) ? $param['sequence'] : null) == $sequence) {
                $payload = array_merge($payload, $param);
            }
        }
        return $payload;
    }

    private function patchDataWorkflows(array $data, $nik)
    {
        $payload = $this->preparePayload($data, $nik);
        /** @var WorkflowService $workflowService */
        $workflowService = app(WorkflowService::class);
        $response = $workflowService->getBySubmitted($payload);
        return $response;
    }

    private function preparePayload(array $data, $nik)
    {
        $payload = [
            'submitted' => $nik,
            'approvals' => $data,
        ];
        return array_merge($payload, $this->additionalParams);
    }

    public function store()
    {
        $workflowDatas = $this->approvals();
        $workflowDatas = $this->checkDuplicate($workflowDatas);
        $this->model = WorkflowRepository::store($this->model, $workflowDatas->toArray());
        $this->handleStoreWorkflow();
        return $this->model;
    }

    public function checkDuplicate(Collection $approvals)
    {
        $submitted = $approvals->shift();
        return $approvals->unique('nik')->prepend($submitted);
    }

    public function lastAction(LastAction $lastAction, $note = null)
    {
        return DB::transaction(function () use ($lastAction, $note) {
            $workflow = $this->currentWorkflow();
            if (!$workflow->nik == userAuth()?->nik) {
                throw ValidationException::withMessages(['Anda tidak berhak melakukan aksi ini']);
            }
            $isLast = $this->isLast();
            if ($isLast && $lastAction == LastAction::APPROV) {
                $newModel = WorkflowRepository::updateStatusAndNote($this->model, Status::CLOSE, $note);
                $this->handleChanges($newModel);
                $this->handleIsLastAndApprov();
            }
            if (!$isLast && $lastAction == LastAction::APPROV) {
                $this->handleIsNotLastAndApprov();
            }
            if ($lastAction == LastAction::REJECT) {
                $newModel = WorkflowRepository::updateStatusAndNote($this->model, Status::REJECT, $note);
                $this->handleChanges($newModel);
                $this->handleIsRejected();
            }
            $result = WorkflowRepository::updateLasAction($workflow, $lastAction);
            return $result;
        });
    }

    public function addAdditionalParam(array $param)
    {
        $this->additionalParams[] = $param;
        return $this;
    }

    public function setAdditionalParams(array $params)
    {
        $this->additionalParams = $params;
        return $this;
    }

    public function setCondition(\Closure $condition)
    {
        $this->condition = $condition;
        return $this;
    }

    protected abstract function handleStoreWorkflow();

    protected abstract function handleIsLastAndApprov();

    protected abstract function handleIsNotLastAndApprov();

    protected abstract function handleIsRejected();

    protected abstract function handleChanges(Model $model);
}

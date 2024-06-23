<?php

namespace App\Domain\Workflows;

use App\Enums\Workflows\LastAction;

trait Checker
{
    public function isAllApprov(): bool
    {
        return is_null($this->model->workflow);
    }

    public function currentWorkflow()
    {
        return $this->model->workflows
            ->where('last_action', LastAction::NOTTING)
            ->sortBy('sequence')
            ->first();
    }

    public function isCurrentWorkflow(): bool
    {
        return $this->currentWorkflow()?->nik == auth()->user()?->nik;
    }

    public function isLast(): bool
    {
        $curr = $this->currentWorkflow();
        return $this->model->workflows->last()?->sequence === $curr?->sequence;
    }

    public function nextWorkflow()
    {
        $curr = $this->currentWorkflow();
        if (!$curr)
            return null;
        $nextSequence = $curr->sequence + 1;
        return $nextSequence <= count($this->model->workflows) ? $this->next($nextSequence) : null;
    }

    private function next($sequence)
    {
        return $this->model->workflows
            ->where('sequence', $sequence)
            ->first();
    }

    public function firstWorkflow()
    {
        return $this->model->workflows?->first();
    }
}

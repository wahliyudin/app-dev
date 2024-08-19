<?php

namespace App\Jobs;

use App\Domain\Services\Applications\ApplicationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckStatusApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ApplicationService $appService;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->appService = app(ApplicationService::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->appService->updateCurrentOverdue();
    }
}

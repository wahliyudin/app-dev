<?php

namespace App\Jobs\Request;

use App\Models\Request\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ApprovalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected string $view,
        protected Request $request,
        protected $requestWorkflow
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->view == 'emails.request.approv') {
            $employee = $this->requestWorkflow?->employee;
            $data['url'] = route('approvals.requests.show', $this->request->getKey());
        } else {
            $employee = $this->request->requestor;
            $data['url'] = route('requests.show', $this->request->getKey());
        }

        $data['email'] = $employee->email_perusahaan;
        $data['title'] = "AppDev Alert System";

        $data['employee'] = $employee;
        $data['request'] = $this->request;

        Mail::send($this->view, $data, function ($message) use ($data) {
            $message->to($data["email"])
                ->subject($data["title"]);
        });
    }
}

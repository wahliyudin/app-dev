<?php

namespace App\Http\Controllers\Setting;

use App\Data\Settings\ApprovalDto;
use App\Domain\Repositories\Setting\ApprovalRepository;
use App\Domain\Services\HCIS\EmployeeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\ApprovalRequest;

class ApprovalController extends Controller
{
    public function __construct(
        protected ApprovalRepository $approvalRepository,
        protected EmployeeService $employeeService,
    ) {
    }

    public function index()
    {
        return view('setting.approval.index', [
            'employees' => $this->employeeService->all(['nik', 'nama_karyawan']),
            'settingApprovals' => ApprovalRepository::dataForView()
        ]);
    }

    public function store(ApprovalRequest $request)
    {
        try {
            $this->approvalRepository->updateOrCreate(ApprovalDto::fromRequest($request));
            return response()->json([
                'message' => 'Successfully'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

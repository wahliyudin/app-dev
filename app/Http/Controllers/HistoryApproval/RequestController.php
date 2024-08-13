<?php

namespace App\Http\Controllers\HistoryApproval;

use App\Domain\Services\Request\RequestService;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    public function __construct(
        private RequestService $requestService,
    ) {}

    public function index()
    {
        return view('history-approval.request.index');
    }

    public function datatable()
    {
        $data = $this->requestService->getByHistoryApproval();
        return datatables()->of($data)
            ->editColumn('application', function ($data) {
                return $data->application->display_name;
            })
            ->editColumn('requestor', function ($data) {
                return $data->requestor?->nama_karyawan;
            })
            ->editColumn('type_request', function ($data) {
                return $data->type_request->label();
            })
            ->editColumn('type_budget', function ($data) {
                return $data->type_budget->label();
            })
            ->addColumn('start_date', function ($data) {
                return $data->date ? carbon($data->date)->translatedFormat('d F Y') : '-';
            })
            ->addColumn('estimated_date', function ($data) {
                return $data->estimated_project ? carbon($data->estimated_project)->translatedFormat('d F Y') : '-';
            })
            ->editColumn('status', function ($data) {
                return $data->status->badge();
            })
            ->rawColumns(['action', 'status'])
            ->make();
    }

    public function show($key)
    {
        return view('history-approval.request.show', [
            'request' => $this->requestService->findOrFail($key),
        ]);
    }
}

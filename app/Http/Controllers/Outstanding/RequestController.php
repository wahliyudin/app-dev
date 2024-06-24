<?php

namespace App\Http\Controllers\Outstanding;

use App\Data\Requests\FormDto;
use App\Domain\Services\HCIS\EmployeeService;
use App\Domain\Services\Request\RequestService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Outstanding\Request\StoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function __construct(
        private RequestService $requestService,
        private EmployeeService $employeeService,
    ) {
    }

    public function index()
    {
        return view('outstanding.request.index');
    }

    public function datatable()
    {
        $data = $this->requestService->getByOutstanding();
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
            ->rawColumns(['action', 'status'])
            ->make();
    }

    public function setting($key)
    {
        $requestModel = $this->requestService->findOrFail($key);
        return view('outstanding.request.setting', [
            'request' => $requestModel,
            'formDto' => FormDto::fromModel($requestModel),
            'employees' => $this->employeeService->all(['nik', 'nama_karyawan']),
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $this->requestService->storeSetting($request);
            return response()->json(['message' => 'Successfully saved']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function developers(Request $request)
    {
        try {
            $search = $request->get('q');

            $developers = User::query()
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'developer');
                })
                ->with(['employee' => function ($query) use ($search) {
                    $query->select(['nik', 'nama_karyawan'])
                        ->with('identity:nik,avatar')
                        ->when($search, function ($query) use ($search) {
                            $query->where('nik', 'like', '%' . $search . '%')
                                ->orWhere('nama_karyawan', 'like', '%' . $search . '%');
                        });
                }])
                ->get();

            $formattedDevelopers = [];
            foreach ($developers as $developer) {
                if ($developer->employee) {
                    $formattedDevelopers[] = [
                        'id' => $developer->nik,
                        'text' => $developer->employee?->nama_karyawan,
                        'subcontent' => $developer->nik,
                        'icon' => config('urls.hcis') . 'storage/' . $developer->employee?->identity?->avatar,
                    ];
                }
            }

            return response()->json($formattedDevelopers);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

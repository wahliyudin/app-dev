<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\DeveloperService;
use App\Enums\Applications\NavItem;
use App\Enums\Settings\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Applications\Developer\StoreRequest;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function __construct(
        private DeveloperService $developerService
    ) {}

    public function index($id)
    {
        return view('applications.developer', [
            'navItemActive' => NavItem::DEVELOPER,
            'application' => $this->developerService->findOrFail($id),
        ]);
    }

    public function datatable($id)
    {
        $data = $this->developerService->datatable($id);
        return datatables()->of($data)
            ->editColumn('developer', function ($data) {
                return $data->developer?->nama_karyawan;
            })
            ->addColumn('is_update', fn() => hasPermission(Permission::APPLICATION_DEVELOPER_UPDATE))
            ->addColumn('is_delete', fn() => hasPermission(Permission::APPLICATION_DEVELOPER_DELETE))
            ->addIndexColumn()
            ->make();
    }

    public function store(StoreRequest $request)
    {
        try {
            $this->developerService->store($request);
            return response()->json([
                'message' => 'Developer saved successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($key)
    {
        try {
            $developer = $this->developerService->findOrFailDeveloper($key);
            return response()->json([
                'key' => $developer->getKey(),
                'nik' => $developer->nik,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($key)
    {
        try {
            $this->developerService->destroy($key);
            return response()->json([
                'message' => 'Developer deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function developers(Request $request)
    {
        try {
            return $this->developerService->getDevelopers($request);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

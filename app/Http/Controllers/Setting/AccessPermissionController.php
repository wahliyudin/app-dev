<?php

namespace App\Http\Controllers\Setting;

use App\Domain\Repositories\UserRepository;
use App\Domain\Services\Setting\AccessPermissionService;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AccessPermissionController extends Controller
{
    public function __construct(
        protected AccessPermissionService $accessPermissionService,
        protected UserRepository $userRepository,
    ) {
    }

    public function index()
    {
        return view('setting.access-permission.index');
    }

    public function datatable()
    {
        $data = $this->accessPermissionService->datatable();
        return datatables()->of($data)
            ->addColumn('is_setting', hasPermission('setting_access_permission_update'))
            ->make();
    }

    public function edit($id)
    {
        $user = $this->userRepository->firstOrFail($id);
        return view('setting.access-permission.edit', [
            'user' => $user,
            'sidebars' => $this->accessPermissionService->getSidebarAlreadyBuild($user),
            'roles' => $this->accessPermissionService->roles($user),
        ]);
    }

    public function update(Request $request, User $user)
    {
        try {
            $user->roles()->sync($request->roles);
            $user->permissions()->sync($request->permissions);
            Cache::forget("laratrust_roles_for_users_{$user->id}");
            Cache::forget("laratrust_permissions_for_users_{$user->id}");
            return to_route('settings.access-permission.index')
                ->with('success', 'Berhasil di update');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())
                ->withInput();
        }
    }
}

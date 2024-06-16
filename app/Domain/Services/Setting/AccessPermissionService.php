<?php

namespace App\Domain\Services\Setting;

use App\Models\HCIS\Employee;
use App\Models\Role;
use App\Models\Sidebar;
use App\Models\User;

class AccessPermissionService
{
    public function datatable()
    {
        $users = User::select(['nik', 'name'])->get();
        $employees = Employee::select(['nik', 'nama_karyawan', 'email_perusahaan'])
            ->whereIn('nik', $users->pluck('nik'))
            ->get();
        $admin = $users->where('nik', 12345678)->first();
        if ($admin) {
            $employees->add(new Employee([
                'nik' => $admin->nik,
                'nama_karyawan' => $admin->name,
                'email_perusahaan' => 'administrator@tbu.co.id',
            ]));
        }
        return $employees;
    }

    public function getSidebarAlreadyBuild(User $user)
    {
        $sidebars = Sidebar::query()->with('permissions:id,name')->get();
        return $this->build($sidebars, $user);
    }

    private function build($sidebars, $user, $parent = null)
    {
        $results = [];
        foreach ($sidebars as $sidebar) {
            if ($sidebar->parent_id == $parent) {
                $children = [];
                if ($this->hasChild($sidebars, $sidebar->id)) {
                    $children = array_merge($children, $this->build($sidebars, $user, $sidebar->id));
                }
                $sidebar = $this->attributeAdditional($sidebar, $user);
                array_push($results, [
                    'title' => $sidebar->title,
                    'name' => $sidebar->name,
                    'permissions' => $sidebar->permissions,
                    'children' => $children
                ]);
            }
        }
        return $results;
    }

    private function hasChild($sidebars, $sidebar_id)
    {
        foreach ($sidebars as $sidebar) {
            if ($sidebar->parent_id == $sidebar_id) {
                return true;
            }
        }
        return false;
    }

    private function attributeAdditional(Sidebar $sidebar, User $user)
    {
        foreach ($sidebar->permissions as $permission) {
            $permission->assigned = $user->permissions
                ->pluck('id')
                ->contains($permission->id);
            $permissionsMap = config('sidebar-with-permission.permissions_map');
            foreach ($permissionsMap as $key => $val) {
                if (str($permission->name)->contains('_' . $val)) {
                    $permission->display = str($val)->ucfirst();
                    $permission->input_name = $val . "[]";
                }
            }
        }
        return $sidebar;
    }

    public function roles(User $user)
    {
        $roles = Role::query()->select(['id', 'name', 'display_name'])->get();
        foreach ($roles as $role) {
            $role->assigned = $user->roles
                ->pluck('id')
                ->contains($role->id);
        }
        return $roles;
    }
}

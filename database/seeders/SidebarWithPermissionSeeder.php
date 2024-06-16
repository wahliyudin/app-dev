<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Sidebar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SidebarWithPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = config('sidebar-with-permission.roles');
        $modules = config('sidebar-with-permission.sidebars');
        $mapPermission = collect(config('sidebar-with-permission.permissions_map'));

        foreach ($roles as $role) {
            $name = str($role)->lower()->snake()->value();
            Role::query()->updateOrCreate([
                'name' => $name,
            ], [
                'name' => $name,
                'display_name' => str($role)->ucfirst()->value(),
            ]);
        }
        foreach ($modules as $module) {
            $parentName = str($module['title'])->lower()->value();
            $parent = Sidebar::query()->updateOrCreate([
                'name' => str($parentName)->snake()->value(),
            ], [
                'title' => isset($module['label']) ? $module['label'] : $module['title'],
                'name' => str($parentName)->snake()->value(),
            ]);
            if (isset($module['permissions'])) {
                $result = $this->checkPermission($module['permissions'], $mapPermission, $parentName);
                $parent->permissions()->sync($result);
            }
            foreach (isset($module['child']) ? $module['child'] : [] as $child) {
                $childName = str($child['title'])->lower()->value();
                $data = [
                    'title' => isset($child['label']) ? $child['label'] : $child['title'],
                    'name' => str($childName)->snake()->value(),
                    'parent_id' => $parent->getKey(),
                ];
                $sidebar = Sidebar::query()->updateOrCreate([
                    'name' => str($childName)->snake()->value(),
                    'parent_id' => $parent->getKey(),
                ], $data);
                if (isset($child['permissions'])) {
                    $result = $this->checkPermission($child['permissions'], $mapPermission, $childName, $parentName);
                    $sidebar->permissions()->sync($result);
                }
            }
        }
    }

    public function checkPermission($strPermissions, $mapPermission, $name, $parentName = null)
    {
        $permissions = [];
        foreach (explode(',', $strPermissions) as $p => $perm) {
            $permissionValue = $mapPermission->get($perm);
            $resultName = $this->name($name, $parentName);
            $permission = \App\Models\Permission::firstOrCreate([
                'name' => $resultName . '_' . $permissionValue,
                'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($resultName),
                'description' => ucfirst($permissionValue) . ' ' . ucfirst($resultName),
            ])->id;
            $permissions[] = $permission;
            $permis[] = $permission;

            $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $resultName);
        }
        return $permissions;
    }

    public function name($childName, $parentName = null)
    {
        $name = str($childName)->snake();
        return $parentName ? str($parentName)->snake() . '_' . $name : $name;
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return  void
     */
    public function truncateLaratrustTables()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        Schema::disableForeignKeyConstraints();

        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();

        if (Config::get('laratrust_seeder.truncate_tables')) {
            DB::table('roles')->truncate();
            DB::table('permissions')->truncate();

            if (Config::get('laratrust_seeder.create_users')) {
                $usersTable = (new \App\Models\User)->getTable();
                DB::table($usersTable)->truncate();
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}

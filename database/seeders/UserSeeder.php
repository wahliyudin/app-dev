<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::query()->get()->pluck('id')->toArray();
        User::query()->updateOrCreate([
            'nik' => 11190659,
        ], [
            'nik' => 11190659,
            'name' => 'MARIANTI',
            'email' => 'marianti@tbu.co.id',
            'password' => bcrypt('1234567890')
        ])->syncPermissions($permissions);
    }
}

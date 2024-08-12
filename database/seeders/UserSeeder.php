<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::query()->get()->pluck('id')->toArray();
        User::query()->updateOrCreate([
            'nik' => 12345678,
        ], [
            'nik' => 12345678,
            'name' => 'Administrator',
            'email' => 'administrator@tbu.co.id',
            'password' => Hash::make(1234567890)
        ])->syncPermissions($permissions);
    }
}

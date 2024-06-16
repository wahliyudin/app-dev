<?php

namespace App\Domain\Repositories;

use App\Models\User;

class UserRepository
{
    public function store($data)
    {
        if (!$data) return false;
        return User::query()->updateOrCreate([
            'nik' => $data['nik'],
            'email' => $data['email'],
        ], [
            'nik' => $data['nik'],
            'name' => $data['employee']['nama_karyawan'],
            'email' => $data['email'],
            'password' => isset($data['password']) ? $data['password'] : null,
        ]);
    }

    public function firstOrFail($nik)
    {
        return User::query()->with(['permissions:id'])->where('nik', $nik)->firstOrFail();
    }
}

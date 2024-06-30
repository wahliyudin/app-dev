<?php

namespace App\Domain\Services\Applications;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingService extends ApplicationService
{
    public function store($request)
    {
        /** @var Request $request */
        return DB::transaction(function () use ($request) {
            $app = $this->findOrFail($request->key);
            $data = [
                'display_name' => $request->display_name,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'status' => $request->status,
            ];
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $extension = $file->extension();
                $randomString = Str::random(10);
                $filename = str($app->name)->lower()->value() . '_' . $randomString . '.' . $extension;
                $file->storeAs('public/applications/logo', $filename);
                $path = "applications/logo/$filename";
                if ($app->logo) {
                    Storage::disk('public')->delete("$app->logo");
                }
                $data['logo'] = $path;
            }
            $app->update($data);
            return $app;
        });
    }
}

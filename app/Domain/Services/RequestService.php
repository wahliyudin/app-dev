<?php

namespace App\Domain\Services;

use App\Models\Request\Request;
use App\Models\Request\RequestApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequestService
{
    public function datatable()
    {
        return Request::select(['id', 'code', 'nik_requestor', 'department', 'application_id', 'type_request', 'type_budget', 'date', 'estimated_project', 'status'])
            ->with(['requestor:nik,nama_karyawan', 'application:id,name,display_name'])
            ->get();
    }

    public function store($request)
    {
        DB::transaction(function () use ($request) {
            $application = RequestApplication::query()
                ->where('id', is_integer($request->application_name) ? $request->application_name : null)
                ->firstOrCreate([
                    'department_id' => $request->department_id,
                    'name' => $request->application_name,
                    'display_name' => str($request->application_name)->ucfirst()->toString(),
                ]);
            $requestModel = Request::query()->updateOrCreate([
                'id' => $request->key,
            ], [
                'code' => $request->code,
                'nik_requestor' => $request->nik_requestor,
                'job_title' => $request->job_title,
                'department' => $request->department,
                'application_id' => $application->getKey(),
                'nik_pic' => $request->pic_user,
                'estimated_project' => $request->estimated_project,
                'email' => $request->email,
                'date' => $request->date,
                'type_request' => $request->type_request,
                'type_budget' => $request->type_budget,
                'description' => $request->description,
            ]);

            if ($request->has('attachments')) {
                foreach ($request->attachments as $fileName) {
                    $requestModel->attachments()->updateOrCreate(
                        ['name' => $fileName],
                        ['name' => $fileName, 'path' => 'storage/requests/' . $fileName]
                    );
                    Storage::disk('public')->move('requests/temp/' . $fileName, 'requests/' . $fileName);
                }
                $existingFiles = $requestModel->attachments->pluck('name')->toArray();
                foreach ($existingFiles as $fileName) {
                    if (!in_array($fileName, $request->attachments)) {
                        Storage::disk('public')->delete('requests/' . $fileName);
                        $requestModel->attachments()->where('name', $fileName)->delete();
                    }
                }
            }

            return $requestModel;
        });
    }

    public function generateCode()
    {
        $lastRecord = Request::select('code')
            ->orderBy('code', 'desc')
            ->first();

        if ($lastRecord) {
            $lastCode = $lastRecord->code;
            $lastNumber = (int) substr($lastCode, 3);
            $nextNumber = $lastNumber + 1;
            $nextCode = 'REQ' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        } else {
            $nextCode = 'REQ00001';
        }

        return $nextCode;
    }
}

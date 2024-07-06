<?php

namespace App\Domain\Services\Request;

use App\Enums\Request\Task\Status as TaskStatus;
use App\Enums\SvgTypeFile\TypeFile;
use App\Enums\Workflows\Status;
use App\Models\Request\Request;
use App\Models\Request\RequestApplication;
use App\Models\Request\RequestFeature;
use App\Models\Request\RequestFeatureTask;
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

    public function findOrFail($id)
    {
        return Request::query()->with([
            'requestor' => function ($query) {
                $query->select(['nik', 'nama_karyawan', 'position_id'])
                    ->with(['position:position_id,dept_id']);
            },
            'feature:id,name,description',
            'application:id,name,display_name',
            'pic:nik,nama_karyawan',
            'workflows' => function ($query) {
                $query->with('employee:nik,nama_karyawan')->orderBy('sequence', 'ASC');
            }
        ])
            ->findOrFail($id);
    }

    public function store($request)
    {
        DB::transaction(function () use ($request) {
            $application = $this->storeApplication($request);
            $requestModel = $this->updateOrCreateRequest($request, $application);
            if ($request->has('attachments')) {
                $this->storeAttachments($request->attachments, $requestModel);
            }
            if (!$request->key) {
                RequestWorkflow::setModel($requestModel)->store();
            }
            return $requestModel;
        });
    }

    public function storeNewFeature($appId, $name, $description)
    {
        return RequestFeature::query()->create([
            'application_id' => $appId,
            'name' => $name,
            'description' => $description,
        ]);
    }

    public function storeTaskRevision($featureId, $dueDate, $content)
    {
        return RequestFeatureTask::query()->create([
            'request_feature_id' => $featureId,
            'due_date' => $dueDate,
            'content' => $content,
            'status' => TaskStatus::NOTTING,
        ]);
    }

    private function storeAttachments($attachments, $requestModel)
    {
        foreach ($attachments as $attachment) {
            $requestModel->attachments()->updateOrCreate(
                ['name' => $attachment['name']],
                [
                    'name' => $attachment['name'],
                    'original_name' => $attachment['original_name'],
                    'path' => 'storage/requests/' . $attachment['name'],
                    'type_file' => TypeFile::svg($attachment['name']),
                    'display_name' => str(pathinfo($attachment['original_name'], PATHINFO_FILENAME))->ucfirst()->value(),
                ]
            );
            if (Storage::disk('public')->exists('requests/temp/' . $attachment['name'])) {
                Storage::disk('public')->move('requests/temp/' . $attachment['name'], 'requests/' . $attachment['name']);
            }
        }
        $existingFiles = $requestModel->attachments->pluck('name')->toArray();
        foreach ($existingFiles as $fileName) {
            if (!in_array($fileName, array_column($attachments, 'name'))) {
                Storage::disk('public')->delete('requests/' . $fileName);
                $requestModel->attachments()->where('name', $fileName)->delete();
            }
        }
    }

    private function updateOrCreateRequest($request, $application)
    {
        return Request::query()->updateOrCreate([
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
            'feature_name' => $request->feature_name,
            'feature_id' => $request->feature_id,
        ]);
    }

    private function storeApplication($request)
    {
        $appId = $request->application_name && is_numeric($request->application_name) ? $request->application_name : ($request->application_id ?? null);
        $application = RequestApplication::query()
            ->where('id', $appId)
            ->first();
        if (!$application) {
            $application = RequestApplication::query()->create([
                'department_id' => $request->department_id,
                'name' => $request->application_name,
                'display_name' => str($request->application_name)->ucfirst()->toString(),
                'due_date' => $request->estimated_project,
            ]);
        }
        return $application;
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

    public function appByDept($dept_id)
    {
        return RequestApplication::query()
            ->where('department_id', $dept_id)
            ->select(['id', 'name', 'display_name'])
            ->get();
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $request = $this->findOrFail($id);
            foreach ($request->attachments as $attachment) {
                Storage::disk('public')->delete('requests/' . $attachment->name);
            }
            $request->workflows()->delete();
            $request->attachments()->delete();
            $request->delete();
        });
    }

    public function getByCurrentApproval()
    {
        return $this->queryCurrentApproval()->get();
    }

    public function totalCurrentApproval()
    {
        return $this->queryCurrentApproval()->count();
    }

    private function queryCurrentApproval()
    {
        return Request::select(['id', 'code', 'nik_requestor', 'department', 'application_id', 'type_request', 'type_budget', 'date', 'estimated_project', 'status'])
            ->with(['requestor:nik,nama_karyawan', 'application:id,name,display_name'])
            ->where('status', Status::OPEN)
            ->whereHas('workflow', function ($query) {
                $query->where('nik', userAuth()?->nik);
            });
    }

    public function featureByAppId($appId)
    {
        return RequestFeature::query()
            ->where('application_id', $appId)
            ->select(['id', 'name'])
            ->get();
    }
}

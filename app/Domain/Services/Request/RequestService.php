<?php

namespace App\Domain\Services\Request;

use App\Enums\Request\Task\Status as TaskStatus;
use App\Enums\Request\TypeRequest;
use App\Enums\Workflows\Status;
use App\Models\Request\Request;
use App\Models\Request\RequestApplication;
use App\Models\Request\RequestDeveloper;
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
            $application = RequestApplication::query()
                ->where('id', is_numeric($request->application_name) ? $request->application_name : null)
                ->first();
            if (!$application) {
                $application = RequestApplication::query()->create([
                    'department_id' => $request->department_id,
                    'name' => $request->application_name,
                    'display_name' => str($request->application_name)->ucfirst()->toString(),
                ]);
            }
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
                foreach ($request->attachments as $attachment) {
                    $requestModel->attachments()->updateOrCreate(
                        ['name' => $attachment['name']],
                        ['name' => $attachment['name'], 'original_name' => $attachment['original_name'], 'path' => 'storage/requests/' . $attachment['name']]
                    );
                    if (Storage::disk('public')->exists('requests/temp/' . $attachment['name'])) {
                        Storage::disk('public')->move('requests/temp/' . $attachment['name'], 'requests/' . $attachment['name']);
                    }
                }
                $existingFiles = $requestModel->attachments->pluck('name')->toArray();
                foreach ($existingFiles as $fileName) {
                    if (!in_array($fileName, array_column($request->attachments, 'name'))) {
                        Storage::disk('public')->delete('requests/' . $fileName);
                        $requestModel->attachments()->where('name', $fileName)->delete();
                    }
                }
            }

            if (!$request->key) {
                RequestWorkflow::setModel($requestModel)->store();
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

    public function getByOutstanding()
    {
        return $this->queryOutstanding()->get();
    }

    public function totalOutstanding()
    {
        return $this->queryOutstanding()->count();
    }

    private function queryOutstanding()
    {
        return Request::select(['id', 'code', 'nik_requestor', 'department', 'application_id', 'type_request', 'type_budget', 'date', 'estimated_project', 'status'])
            ->with(['requestor:nik,nama_karyawan', 'application:id,name,display_name'])
            ->where('status', Status::CLOSE)
            ->whereDoesntHave('features')
            ->where('type_request', TypeRequest::NEW_APPLICATION);
    }

    public function storeSetting($request)
    {
        return DB::transaction(function () use ($request) {
            foreach ($request->developers as $developer) {
                RequestDeveloper::query()->updateOrCreate([
                    'request_id' => $request->key,
                    'nik' => $developer,
                ], [
                    'request_id' => $request->key,
                    'nik' => $developer,
                ]);
            }
            foreach ($request->features as $feature) {
                RequestFeature::query()->updateOrCreate([
                    'request_id' => $request->key,
                    'id' => $feature['key'],
                ], [
                    'request_id' => $request->key,
                    'name' => $feature['name'],
                    'description' => $feature['description'],
                ]);
            }
        });
    }

    public function getByTask()
    {
        return $this->queryTask()->get();
    }

    public function totalTask()
    {
        return $this->queryTask()->count();
    }

    private function queryTask()
    {
        return Request::select(['id', 'code', 'nik_requestor', 'department', 'application_id', 'type_request', 'type_budget', 'date', 'estimated_project', 'status'])
            ->with(['requestor:nik,nama_karyawan', 'application:id,name,display_name'])
            ->where('status', Status::CLOSE)
            ->whereHas('features')
            ->where('type_request', TypeRequest::NEW_APPLICATION);
    }

    public function getTaskByRequest($key)
    {
        return RequestFeatureTask::query()->withWhereHas('feature', function ($query) use ($key) {
            $query->where('request_id', $key);
        })
            ->latest()
            ->get();
    }

    public function findOrFailForTask($key)
    {
        return Request::query()
            ->with('features')
            ->findOrFail($key);
    }

    public function storeTask($request)
    {
        return DB::transaction(function () use ($request) {
            return RequestFeatureTask::query()->updateOrCreate([
                'request_feature_id' => $request->feature_id,
                'id' => $request->key,
            ], [
                'request_feature_id' => $request->feature_id,
                'status' => TaskStatus::resetId($request->status),
                'content' => $request->content,
            ])
                ->load('feature');
        });
    }

    public function updateTask($request, $key)
    {
        return DB::transaction(function () use ($request, $key) {
            $task = RequestFeatureTask::query()->findOrFail($key);
            $from = $task->status->label();
            $to = TaskStatus::resetId($request->status);
            $task->update([
                'status' => $to,
            ]);
            return [
                'from' => $from,
                'to' => $to->label(),
            ];
        });
    }

    public function destroyTask($key)
    {
        return DB::transaction(function () use ($key) {
            RequestFeatureTask::query()->findOrFail($key)->delete();
        });
    }
}

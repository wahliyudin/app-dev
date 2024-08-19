<?php

namespace App\Data\Applications;

use App\Enums\Settings\Permission;
use App\Models\Request\RequestFeatureTask;

class TaskDto
{
    public function __construct(
        public readonly ?string $key = null,
        public readonly ?string $feature_name = null,
        public readonly ?string $content = null,
        public readonly ?string $due_date = null,
        public readonly ?string $created_at = null,
        public readonly ?string $status = null,
        public readonly ?bool $is_create = false,
        public readonly ?bool $is_update = false,
        public readonly ?bool $is_delete = false,
        public readonly ?array $developers = null,
    ) {}

    public static function fromModel(RequestFeatureTask $task): self
    {
        $task->loadMissing(['feature', 'developers' => function ($query) {
            $query->with(['developer' => function ($query) {
                $query->select('nik', 'nama_karyawan')
                    ->with('identity:nik,avatar');
            }]);
        }]);
        return new self(
            $task->getKey(),
            $task->feature?->name,
            $task->content,
            $task->due_date,
            $task->created_at->format('Y-m-d H:i:s'),
            $task->status->value,
            hasPermission(Permission::APPLICATION_TASK_CREATE),
            hasPermission(Permission::APPLICATION_TASK_UPDATE),
            hasPermission(Permission::APPLICATION_TASK_DELETE),
            self::convertDevelopers($task->developers),
        );
    }

    public static function convertDevelopers($developers)
    {
        $results = [];
        foreach ($developers as $developer) {
            $item = [];
            $item['nik'] = $developer->nik;
            $item['name'] = $developer->developer?->nama_karyawan;
            $item['avatar'] = self::avatar($developer->developer?->identity?->avatar);
            $results[] = $item;
        }
        return $results;
    }

    public static function avatar($avatar)
    {
        if (!$avatar) {
            return asset('assets/media/avatars/300-1.jpg');
        }
        return config('urls.hcis') . 'storage/' . $avatar;
    }
}

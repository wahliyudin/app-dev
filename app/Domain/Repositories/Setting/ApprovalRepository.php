<?php

namespace App\Domain\Repositories\Setting;

use App\Data\Settings\ApprovalDto;
use App\Enums\Workflows\Module;
use App\Models\Setting\SettingApproval;

class ApprovalRepository
{
    public static function updateOrCreate(ApprovalDto $dto): mixed
    {
        for ($i = 0; $i < count($dto->data ?? []); $i++) {
            if (isset($dto->data[$i])) {
                SettingApproval::query()->updateOrCreate([
                    'id' => $dto->data[$i]['key'],
                ], [
                    'module' => $dto->module,
                    'approval' => $dto->data[$i]['approval'],
                    'title' => $dto->data[$i]['title'],
                    'nik' => $dto->data[$i]['nik'],
                ]);
            }
        }
        return SettingApproval::query()
            ->where('module', $dto->module)
            ->when(count($dto->keys) > 0, function ($query) use ($dto) {
                $query->whereNotIn('id', $dto->keys);
            })
            ->delete();
    }

    public static function getByModule(Module $module)
    {
        return SettingApproval::query()->where('module', $module)->orderBy('id', 'ASC')->get();
    }

    public static function all()
    {
        return SettingApproval::query()->select(['id', 'module', 'approval', 'nik', 'title'])->get();
    }

    public static function dataForView(): array
    {
        $settingApprovals = self::all();
        $results = [];
        foreach (Module::cases() as $key => $module) {
            $tmp = $settingApprovals->where('module', $module);
            $results = array_merge($results, [
                $module->value => [
                    'title' => $module->label(),
                    'module' => $module->value,
                    'childs' => $tmp
                ],
            ]);
        }
        return $results;
    }
}

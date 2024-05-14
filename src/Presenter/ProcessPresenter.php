<?php

declare(strict_types=1);

namespace App\Presenter;

use App\Model\Process;

class ProcessPresenter
{
    /**
     * @param Process[] $processes
     * @return array
     */
    public static function collection(array $processes): array
    {
        return array_map(function ($process) {
            return self::getValues($process);
        }, $processes);
    }

    public static function item(Process $process): array
    {
        return self::getValues($process);
    }

    private static function getValues(Process $process): array
    {
        return [
            'id' => $process->getId(),
            'name' => $process->getName(),
            'fields' => empty($process->getFields()) ? [] : FieldPresenter::collection($process->getFields()),
        ];
    }
}

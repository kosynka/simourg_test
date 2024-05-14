<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Process;

abstract class Controller
{
    protected function jsonResponse(array $response, int $code): bool|string
    {
        header('Content-type: application/json');
        http_response_code($code);

        return json_encode($response);
    }
}

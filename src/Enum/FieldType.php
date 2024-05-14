<?php

declare(strict_types=1);

namespace App\Enum;

enum FieldType: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case DATE = 'date';
}

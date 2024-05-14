<?php

declare(strict_types=1);

namespace App\Presenter;

use App\Enum\FieldType;
use App\Model\Field;
use DateTime;

class FieldPresenter
{

    /**
     * @param Field[] $fields
     * @return array
     */
    public static function collection(array $fields): array
    {
        return array_map(function ($field) {
            return self::getValues($field);
        }, $fields);
    }

    public static function item(Field $field): array
    {
        return self::getValues($field);
    }

    private static function getValues(Field $field): array
    {
        return [
            'id' => $field->getId(),
            'name' => $field->getName(),
            'type' => $field->getType(),
            'value' => self::getFormattedValue($field),
            'number_format' => $field->getNumberFormat(),
            'date_format' => $field->getDateFormat(),
        ];
    }

    private static function getFormattedValue(Field $field): string|DateTime
    {
        // format example '%+.2f'
        if (
            $field->getType() === FieldType::NUMBER->value
            && $field->getNumberFormat() !== null
            && !empty($field->getNumberFormat())
        ) {
            return sprintf($field->getNumberFormat(), (float) $field->getValue());
        }

        // format example DateTime::format
        if (
            $field->getType() === FieldType::DATE->value
            && $field->getDateFormat() !== null
            && !empty($field->getDateFormat())
        ) {
            $date = new DateTime($field->getValue());

            return $date->format($field->getDateFormat());
        }

        return $field->getValue();
    }
}

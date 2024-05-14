<?php

declare(strict_types=1);

namespace App\Repository;

use App\DB;
use App\Model\Field;

class FieldRepository
{
    private string $table = 'process_fields';

    public function storeProcessFields(int $processId, array $data): array
    {
        $connection = DB::getInstance();
        $sql = "INSERT INTO {$this->table} (process_id, name, type, value, number_format, date_format) VALUES ";
        $values = [];

        foreach ($data as $field) {
            $values[] = "({$processId}, " .
                "'{$field['name']}', " .
                "'{$field['type']}', " .
                "'{$field['value']}', " .
                "'{$field['number_format']}', " .
                "'{$field['date_format']}')"
            ;
        }

        $sql .= implode(', ', $values);

        $statement = $connection->prepare($sql);
        $statement->execute();

        return $data;
    }

    public function fetchAll(int $processId): array
    {
        $connection = DB::getInstance();
        $statement = $connection->query("SELECT * FROM {$this->table} WHERE process_id = {$processId}");

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return [];
        }

        foreach ($result as $field) {
            $fields[] = new Field(
                $field['id'],
                $processId,
                $field['name'],
                $field['type'],
                $field['value'],
                $field['number_format'],
                $field['date_format'],
            );
        }

        return $fields;
    }

    public function addFields(int $id, array $data): array
    {
        $connection = DB::getInstance();
        $sql = "INSERT INTO {$this->table} (process_id, name, value) VALUES ";
        $values = [];

        foreach ($data as $field) {
            $values[] = "({$id}, '{$field['name']}', '{$field['value']}')";
        }

        $sql .= implode(', ', $values);

        $statement = $connection->prepare($sql);
        $statement->execute();

        return $data;
    }
}
